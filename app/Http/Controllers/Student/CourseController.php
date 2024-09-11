<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ArticleLecture;
use App\Models\Course;
use App\Models\CourseBookmark;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\LectureProgress;
use App\Models\Progress;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use App\Models\VideoLecture;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class CourseController extends Controller
{
    public function course()
    {
        return redirect()->route('learning');
    }

    public function learning()
    {
        $user_id = Auth::id();
        $student = Student::where('user_id', $user_id)->first();
        /*$enrollments = $student->enrollments()->with('course', 'progress')->get();*/
        $enrollments = Enrollment::where('student_id', $student->id)
            ->whereNot('status', 'suspended')
            ->get();

        // Adding lecture_id dynamically
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $sectionOrder = $enrollment->progress->section_order;
            $lectureOrder = $enrollment->progress->lecture_order;

            // Find the section based on course_id and section_order
            $section = $course->sections->firstWhere('order', $sectionOrder);

            if ($section) {
                // Find the lecture based on section_id and lecture_order
                $lecture = $section->lectures->firstWhere('order', $lectureOrder);

                // Dynamically attach the lecture ID to the enrollment
                $enrollment->lecture_id = $lecture ? $lecture->id : null;
            } else {
                // If no section is found, ensure lecture_id is null
                $enrollment->setAttribute('lecture_id', null);
            }
        }

        $bookmarks = CourseBookmark::where('user_id', $user_id)->get();

        return view('student.learning', [
            'enrollments' => $enrollments,
            'bookmarks' => $bookmarks,
        ]);
    }

    public function course_enroll(Request $request)
    {
        $course_id = $request->get('course_id');
        $user_id = Auth::id();
        $course = Course::find($course_id);
        $student = Student::where('user_id', $user_id)->first();

        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            $courseEnroll = new Enrollment();
            $courseEnroll->student_id = $student->id;
            $courseEnroll->course_id = $course_id;
            $courseEnroll->enrollment_date = now();
            $courseEnroll->save();

            $courseProgress = new Progress();
            $courseProgress->student_id = $student->id;
            $courseProgress->course_id = $course_id;
            $courseProgress->enrollment_id = $courseEnroll->id;
            $courseProgress->sections_count = $course->sections_count;
            $courseProgress->lectures_count = $course->lectures_count;
            $courseProgress->save();

            $sections = Section::where('course_id', $course_id)->get();
            $lectures = Lecture::whereIn('section_id', $sections->pluck('id'))
                ->orderBy('section_id')
                ->orderBy('order')
                ->get();

            foreach ($lectures as $lecture) {
                $lectureProgress = new LectureProgress();
                $lectureProgress->course_id = $course_id;
                $lectureProgress->student_id = $student->id;
                $lectureProgress->enrollment_id = $courseEnroll->id;
                /*$lectureProgress->lecture_id = $lecture->id;*/
                $lectureProgress->lecture_order = $lecture->order;
                $lectureProgress->section_order = $lecture->section_order;
                $lectureProgress->lecture_duration = $lecture->duration;
                $lectureProgress->save();
            }

            $course->enrollment_count = $course->enrollment_count + 1;
            $course->save();
        }

        return redirect()->route('learning');
    }

    public function redirect_to_progress($slug, $id, $lecture_id)
    {
        $user_id = Auth::id();
        $student = Student::where('user_id', $user_id)->first();
        $course = Course::where('id', $id)->first();

        if ($course->status === 'unpublished') {
            return redirect()->route('courses.index');
        }

        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->whereNot('status', 'suspended')
            ->first();

        if ($enrollment) {
            $progress = Progress::where('course_id', $id)
                ->where('enrollment_id', $enrollment->id)
                ->where('student_id', $student->id)
                ->first();

            if (!$progress) {
                abort(404, 'Progress record not found');
            }

            $section = Section::where('course_id', $id)
                ->where('order', $progress->section_order)
                ->first();

            if (!$section) {
                abort(404, 'Section not found');
            }

            $lecture = Lecture::where('id', $lecture_id)->first();
            $currentSection = Section::where('id', $lecture->section_id)->first();

            if (!$lecture) {
                abort(404, 'Lecture not found');
            }

            $sections = Section::where('course_id', $id)
                ->orderBy('order')
                ->get();

            $lectures = Lecture::whereIn('section_id', $sections->pluck('id'))
                ->orderBy('section_id')
                ->orderBy('order')
                ->get();

            $lastSection = $sections->last();
            $lastLecture = $lectures->where('section_id', $lastSection->id)->last();
            $last =  ($lecture->id == $lastLecture->id);

            $lectureProgress = [];
            foreach ($lectures as $oneLecture) {
                $lectureProgress[$oneLecture->id] = LectureProgress::where('course_id', $id)
                    ->where('student_id', $student->id)
                    ->where('section_order', $oneLecture->section_order)
                    ->where('lecture_order', $oneLecture->order)
                    ->first();

            }

            $data = null;
            if ($currentSection->course_id == $id && $slug === Str::slug($course->title)) {
                if ($lecture->type === 'article') {
                    $data = ArticleLecture::where('lecture_id', $lecture->id)->first();
                    if (!$data) {
                        abort(404, 'Article content not found');
                    }
                    return view('student.lecture.article', [
                        'data' => $data,
                        'sections' => $sections,
                        'lectures' => $lectures,
                        'progress' => $progress,
                        'lectureProgress' => $lectureProgress,
                        'last' => $last,
                    ]);
                } elseif ($lecture->type === 'video') {
                    $data = VideoLecture::where('lecture_id', $lecture->id)->first();
                    if (!$data) {
                        abort(404, 'Video content not found');
                    }

                    return view('student.lecture.video', [
                        'data' => $data,
                        'sections' => $sections,
                        'lectures' => $lectures,
                        'progress' => $progress,
                        'lectureProgress' => $lectureProgress,
                        'video_id' => $this->getYouTubeVideoID($data->video_url),
                        'last' => $last,
                    ]);
                }
            }
        }

        return redirect()->route('learning');
    }

    public function getYouTubeVideoID($url) {
        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]+)(?:\?|$)/',
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)(?:&|$)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)(?:\?|$)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return false;
    }

    public function lecture_done(Request $request, $slug, $id, $lecture_id)
    {
        $lecture = Lecture::where('id', $lecture_id)->first();
        $course = Course::where('id', $id)->first();

        if ($course && $lecture && $slug === Str::slug($course->title)) {
            if ($course->status === 'published') {
                $user_id = Auth::id();
                $student = Student::where('user_id', $user_id)->first();

                $enrollment = Enrollment::where('student_id', $student->id)
                    ->where('course_id', $id)
                    ->whereNot('status', 'suspended')
                    ->first();

                if ($enrollment) {
                    $progress = Progress::where('course_id', $id)
                        ->where('student_id', $student->id)
                        ->first();

                    if (!$progress) {
                        return redirect()->route('learning');
                    }

                    $lectureProgress = LectureProgress::where('course_id', $id)
                        ->where('student_id', $student->id)
                        ->where('lecture_order', $lecture->order)
                        ->where('section_order', $lecture->section_order)
                        /*->where('lecture_id', $lecture->id)*/
                        ->first();

                    if ($request->is_done) {
                        $lectureProgress->is_done = (bool)$request->is_done;
                        $lectureProgress->save();

                        $progress->completed_lectures += 1;
                        $progress->save();
                        $percentage = ($progress->completed_lectures / $progress->lectures_count) * 100;
                        $progress->time_spent += $lectureProgress->lecture_duration;
                        $progress->progress_percentage = $percentage;
                        $progress->save();

                        $enrollment->progress_percentage = $percentage;
                        $enrollment->time_spent += $lectureProgress->lecture_duration;
                        $enrollment->save();

                    }

                    $lectureProgresses = LectureProgress::where('course_id', $id)
                        ->where('student_id', $student->id)
                        ->get();

                    $completed = true;
                    foreach ($lectureProgresses as $lectureProgress) {
                        if (!$lectureProgress->is_done) {
                            $completed = false;
                            break;
                        }
                    }

                    if ($completed) {
                        $enrollment->completion_date = now();
                        $enrollment->status = 'completed';
                        $enrollment->save();
                    }

                    // Update section and lecture order
                    $sections = Section::where('course_id', $id)
                        ->orderBy('order') // Assuming you have an order field
                        ->get();

                    foreach ($sections as $section) {
                        $lectures = Lecture::where('section_id', $section->id)
                            ->orderBy('order') // Assuming you have an order field
                            ->get();

                        foreach ($lectures as $lecture) {
                            $lectureProgress = LectureProgress::where('course_id', $id)
                                ->where('student_id', $student->id)
                                ->where('lecture_order', $lecture->order)
                                ->where('section_order', $lecture->section_order)
                                /*->where('lecture_id', $lecture->id)*/
                                ->first();

                            if (!$lectureProgress->is_done) {
                                // Update progress with the current section and lecture
                                $progress->section_order = $section->order;
                                $progress->lecture_order = $lecture->order;
                                $progress->save();
                                break 2; // Break out of both loops
                            }
                        }
                    }

                    return redirect()->route('course.redirect.progress', [
                        'slug' => $slug,
                        'id' => $id,
                        'lecture' => $lecture_id
                    ]);

                }
            }
        }
        return redirect()->route('learning');
    }

    public function progress_next(Request $request, $slug, $id, $lecture_id)
    {
        $currentLecture = Lecture::find($lecture_id);

        if (!$currentLecture) {
            abort(404, 'Lecture not found');
        }

        // Get the current section
        $currentSection = Section::find($currentLecture->section_id);

        if (!$currentSection) {
            abort(404, 'Section not found');
        }

        // Find the next lecture in the same section
        $nextLecture = Lecture::where('section_id', $currentSection->id)
            ->where('order', '>', $currentLecture->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextLecture) {
            // If next lecture exists in the current section
            return redirect()->route('course.redirect.progress', [
                'slug' => $slug,
                'id' => $id,
                'lecture' => $nextLecture->id
            ]);
        } else {
            // No next lecture in the current section, find the next section's first lecture
            $nextSection = Section::where('course_id', $currentSection->course_id)
                ->where('order', '>', $currentSection->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextSection) {
                // Find the first lecture of the next section
                $nextLecture = Lecture::where('section_id', $nextSection->id)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextLecture) {
                    return redirect()->route('course.redirect.progress', [
                        'slug' => $slug,
                        'id' => $id,
                        'lecture' => $nextLecture->id
                    ]);
                } else {
                    // If no next section or lecture found, handle the end of course scenario
                    return redirect()->route('learning');
                }
            } else {
                // No, next section found, handle the end of course scenario
                return redirect()->route('learning');
            }
        }
    }

    public function progress_prev(Request $request, $slug, $id, $lecture_id)
    {
        $currentLecture = Lecture::find($lecture_id);

        if (!$currentLecture) {
            abort(404, 'Lecture not found');
        }

        // Get the current section
        $currentSection = Section::find($currentLecture->section_id);

        if (!$currentSection) {
            abort(404, 'Section not found');
        }

        // Find the previous lecture in the same section
        $prevLecture = Lecture::where('section_id', $currentSection->id)
            ->where('order', '<', $currentLecture->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($prevLecture) {
            // If previous lecture exists in the current section
            return redirect()->route('course.redirect.progress', [
                'slug' => $slug,
                'id' => $id,
                'lecture' => $prevLecture->id
            ]);
        } else {
            // No previous lecture in the current section, find the previous section's last lecture
            $prevSection = Section::where('course_id', $currentSection->course_id)
                ->where('order', '<', $currentSection->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($prevSection) {
                // Find the last lecture of the previous section
                $prevLecture = Lecture::where('section_id', $prevSection->id)
                    ->orderBy('order', 'desc')
                    ->first();

                if ($prevLecture) {
                    return redirect()->route('course.redirect.progress', [
                        'slug' => $slug,
                        'id' => $id,
                        'lecture' => $prevLecture->id
                    ]);
                } else {
                    // If no previous section or lecture found, handle the beginning of course scenario
                    return redirect()->route('learning');
                }
            } else {
                // No previous section found, handle the beginning of course scenario
                return redirect()->route('learning');
            }
        }
    }

    public function course_done($id)
    {
        $user_id = Auth::id();
        $student = Student::where('user_id', $user_id)->first();
        $course = Course::where('id', $id)->first();
        if ($course->status === 'unpublished') {
            return redirect()->route('courses.index');
        }

        $progress = Progress::where('course_id', $id)
            ->where('student_id', $student->id)
            ->first();

        if (!$progress) {
            abort(404, 'Progress record not found');
        }

        $sections = Section::where('course_id', $id)
            ->orderBy('order')
            ->get();

        $lectures = Lecture::whereIn('section_id', $sections->pluck('id'))
            ->orderBy('section_id')
            ->orderBy('order')
            ->get();

        $lectureProgresses = LectureProgress::where('course_id', $id)
            ->where('student_id', $student->id)
            ->get();

        $completed = true;
        foreach ($lectureProgresses as $lectureProgress) {
            if (!$lectureProgress->is_done) {
                $completed = false;
                break;
            }
        }

        $lectureProgress = [];
        foreach ($lectures as $oneLecture) {
            $lectureProgress[$oneLecture->id] = LectureProgress::where('course_id', $id)
                ->where('student_id', $student->id)
                ->where('section_order', $oneLecture->section_order)
                ->where('lecture_order', $oneLecture->order)
                ->first();

        }

        $enrollment = Enrollment::where('student_id', $student->id)
            ->whereNot('status', 'suspended')
            ->where('course_id', $id)->first();

        if ($enrollment) {
            $lastSection = $sections->last();
            $lastLecture = $lectures->where('section_id', $lastSection->id)->last();
            $last =  $lastLecture->id;

            return view('student.lecture.get-certificate', [
                'sections' => $sections,
                'lectures' => $lectures,
                'progress' => $progress,
                'completed' => $completed,
                'lectureProgress' => $lectureProgress,
                'last' => $last,
            ]);
        }
        return redirect()->route('learning');

    }
}
