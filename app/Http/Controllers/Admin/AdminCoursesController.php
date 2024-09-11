<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleLecture;
use App\Models\ArticleLectureVersion;
use App\Models\Course;
use App\Models\CourseAttribute;
use App\Models\CourseAttributeVersion;
use App\Models\CourseVersion;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\LectureVersion;
use App\Models\Progress;
use App\Models\ReviewVersion;
use App\Models\Section;
use App\Models\SectionVersion;
use App\Models\Student;
use App\Models\VideoLecture;
use App\Models\VideoLectureVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCoursesController extends Controller
{
    /* Courses Operations */
    public function index()
    {
        $courses = Course::orderBy('created_at', 'desc')->get();
        return view('admin.courses.index', [
            'courses' => $courses,
        ]);
    }

    public function show_course($id)
    {
        $course = Course::find($id);
        if ($course) {
            $data = $this->getCurriculumPublished($id);
            $attributes = CourseAttribute::where('course_id', $id)->get();
            return view('admin.courses.show', [
                'course' => $course,
                'data' => $data,
                'attributes' => $attributes,
            ]);
        }
        return redirect()->route('admin.courses');
    }

    public function getCurriculumPublished($id)
    {
        // Retrieve all sections for the given course
        $sections = Section::where('course_id', $id)
            ->orderBy('order') // Ensure sections are ordered correctly
            ->get();

        $data = [
            'sections' => [],
            'articleLectures' => [],
            'videoLectures' => [],
        ];

        foreach ($sections as $section) {
            // Store section data
            $data['sections'][$section->order] = [
                'section_number' => $section->order,
                'lectures_count' => $section->lectures_count,
                'title' => $section->title,
                'description' => $section->description,
            ];

            // Retrieve lectures for this section
            $lectures = Lecture::where('section_id', $section->id)
                ->orderBy('order')
                ->get();

            foreach ($lectures as $lecture) {
                // Check lecture type and retrieve corresponding data
                if ($lecture->type === 'article') {
                    $articleLecture = ArticleLecture::where('lecture_id', $lecture->id)->first();
                    if ($articleLecture) {
                        $data['articleLectures'][$section->order][$lecture->order] = [
                            'section_number' => $section->order,
                            'lecture_number' => $lecture->order,
                            'type' => 'article',
                            'title' => $articleLecture->title,
                            'content' => $articleLecture->content,
                        ];
                    }
                } elseif ($lecture->type === 'video') {
                    $videoLecture = VideoLecture::where('lecture_id', $lecture->id)->first();
                    if ($videoLecture) {
                        $data['videoLectures'][$section->order][$lecture->order] = [
                            'section_number' => $section->order,
                            'lecture_number' => $lecture->order,
                            'type' => 'video',
                            'title' => $videoLecture->title,
                            'url' => $videoLecture->video_url,
                            'description' => $videoLecture->description,
                        ];
                    }
                }
            }
        }

        return $data;
    }

    public function preview_course($id, $lecture_id)
    {
        $course = Course::where('id', $id)->first();

        if ($course) {
            $lecture = Lecture::where('id', $lecture_id)->first();

            if ($lecture) {
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

                $data = null;
                if ($lecture->type === 'article') {
                    $data = ArticleLecture::where('lecture_id', $lecture->id)->first();
                    if (!$data) {
                        abort(404, 'Article content not found');
                    }
                    return view('admin.lecture.article', [
                        'course_id' => $id,
                        'data' => $data,
                        'sections' => $sections,
                        'lectures' => $lectures,
                        'last' => $last,
                    ]);
                } elseif ($lecture->type === 'video') {
                    $data = VideoLecture::where('lecture_id', $lecture->id)->first();
                    if (!$data) {
                        abort(404, 'Video content not found');
                    }

                    return view('admin.lecture.video', [
                        'course_id' => $id,
                        'data' => $data,
                        'sections' => $sections,
                        'lectures' => $lectures,
                        'video_id' => $this->getYouTubeVideoID($data->video_url),
                        'last' => $last,
                    ]);
                }
            }
        }

        return redirect()->route('admin.courses');
    }

    public function preview_redirect($id)
    {
        $course = Course::where('id', $id)->first();

        if ($course) {
            $section = Section::where('course_id', $id)->where('order', 1)->first();
            if (!$section) {
                return view('admin.lecture-version.no-lectures');
            }
            $lecture = Lecture::where('section_id', $section->id)->where('order', 1)->first();
            if (!$lecture) {
                return view('admin.lecture-version.no-lectures');
            }

            if ($lecture) {
                return redirect()->route('admin.courses.preview', [
                    'id' => $id,
                    'lecture' => $lecture->id,
                ]);
            }
        }

        return redirect()->route('admin.courses');
    }

    public function preview_redirect_next($id, $lecture_id)
    {
        $course = Course::where('id', $id)->first();

        if ($course) {
            $currentLecture = Lecture::find($lecture_id);
            $currentSection = Section::find($currentLecture->section_id);

            $nextLecture = Lecture::where('section_id', $currentSection->id)
                ->where('order', '>', $currentLecture->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextLecture) {
                return redirect()->route('admin.courses.preview', [
                    'id' => $id,
                    'lecture' => $nextLecture->id,
                ]);
            } else {
                $nextSection = Section::where('course_id', $currentSection->course_id)
                    ->where('order', '>', $currentSection->order)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextSection) {
                    $nextLecture = Lecture::where('section_id', $nextSection->id)
                        ->orderBy('order', 'asc')
                        ->first();

                    if ($nextLecture) {
                        return redirect()->route('admin.courses.preview', [
                            'id' => $id,
                            'lecture' => $nextLecture->id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.courses');
    }

    public function preview_redirect_prev($id, $lecture_id)
    {
        $course = Course::where('id', $id)->first();

        if ($course) {
            $currentLecture = Lecture::find($lecture_id);
            $currentSection = Section::find($currentLecture->section_id);

            $prevLecture = Lecture::where('section_id', $currentSection->id)
                ->where('order', '<', $currentLecture->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($prevLecture) {
                return redirect()->route('admin.courses.preview', [
                    'id' => $id,
                    'lecture' => $prevLecture->id,
                ]);
            } else {
                $prevSection = Section::where('course_id', $currentSection->course_id)
                    ->where('order', '<', $currentSection->order)
                    ->orderBy('order', 'desc')
                    ->first();

                if ($prevSection) {
                    $prevLecture = Lecture::where('section_id', $prevSection->id)
                        ->orderBy('order', 'desc')
                        ->first();

                    if ($prevLecture) {
                        return redirect()->route('admin.courses.preview', [
                            'id' => $id,
                            'lecture' => $prevLecture->id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.courses');
    }

    /* Versions Operations */
    public function versions()
    {
        $courses = CourseVersion::orderBy('updated_at', 'desc')->get();
        return view('admin.courses.versions', [
            'courses' => $courses,
        ]);
    }

    public function show_version($id)
    {
        $course = CourseVersion::find($id);
        if ($course) {
            $data = $this->getCurriculumDraft($id);
            $attributes = CourseAttributeVersion::where('course_id', $id)->get();
            return view('admin.courses.show-version', [
                'course' => $course,
                'data' => $data,
                'attributes' => $attributes,
            ]);
        }
        return redirect()->route('admin.courses.versions');
    }

    public function getCurriculumDraft($id)
    {
        // Retrieve all sections for the given course
        $sections = SectionVersion::where('course_id', $id)
            ->orderBy('order') // Ensure sections are ordered correctly
            ->get();

        $data = [
            'sections' => [],
            'articleLectures' => [],
            'videoLectures' => [],
        ];

        foreach ($sections as $section) {
            // Store section data
            $data['sections'][$section->order] = [
                'section_number' => $section->order,
                'lectures_count' => $section->lectures_count,
                'title' => $section->title,
                'description' => $section->description,
            ];

            // Retrieve lectures for this section
            $lectures = LectureVersion::where('section_id', $section->id)
                ->orderBy('order')
                ->get();

            foreach ($lectures as $lecture) {
                // Check lecture type and retrieve corresponding data
                if ($lecture->type === 'article') {
                    $articleLecture = ArticleLectureVersion::where('lecture_id', $lecture->id)->first();
                    if ($articleLecture) {
                        $data['articleLectures'][$section->order][$lecture->order] = [
                            'section_number' => $section->order,
                            'lecture_number' => $lecture->order,
                            'type' => 'article',
                            'title' => $articleLecture->title,
                            'content' => $articleLecture->content,
                        ];
                    }
                } elseif ($lecture->type === 'video') {
                    $videoLecture = VideoLectureVersion::where('lecture_id', $lecture->id)->first();
                    if ($videoLecture) {
                        $data['videoLectures'][$section->order][$lecture->order] = [
                            'section_number' => $section->order,
                            'lecture_number' => $lecture->order,
                            'type' => 'video',
                            'title' => $videoLecture->title,
                            'url' => $videoLecture->video_url,
                            'description' => $videoLecture->description,
                        ];
                    }
                }
            }
        }

        return $data;
    }

    public function preview_version_redirect($id)
    {
        $course = CourseVersion::where('id', $id)->first();

        if ($course) {
            $section = SectionVersion::where('course_id', $id)->where('order', 1)->first();
            if (!$section) {
                return view('admin.lecture-version.no-lectures');
            }

            $lecture = LectureVersion::where('section_id', $section->id)->where('order', 1)->first();
            if (!$lecture) {
                return view('admin.lecture-version.no-lectures');
            }

            if ($lecture) {
                return redirect()->route('admin.courses.preview.version', [
                    'id' => $id,
                    'lecture' => $lecture->id,
                ]);
            }
        }

        return redirect()->route('admin.courses.versions');
    }

    public function preview_redirect_version_next($id, $lecture_id)
    {
        $course = CourseVersion::where('id', $id)->first();

        if ($course) {
            $currentLecture = LectureVersion::find($lecture_id);
            if (!$currentLecture) {
                return redirect()->route('admin.courses.versions');
            }

            $currentSection = SectionVersion::find($currentLecture->section_id);
            if (!$currentSection) {
                return redirect()->route('admin.courses.versions');
            }

            $nextLecture = LectureVersion::where('section_id', $currentSection->id)
                ->where('order', '>', $currentLecture->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextLecture) {
                return redirect()->route('admin.courses.preview.version', [
                    'id' => $id,
                    'lecture' => $nextLecture->id,
                ]);
            } else {
                $nextSection = SectionVersion::where('course_id', $currentSection->course_id)
                    ->where('order', '>', $currentSection->order)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextSection) {
                    $nextLecture = LectureVersion::where('section_id', $nextSection->id)
                        ->orderBy('order', 'asc')
                        ->first();

                    if ($nextLecture) {
                        return redirect()->route('admin.courses.preview.version', [
                            'id' => $id,
                            'lecture' => $nextLecture->id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.courses.versions');
    }

    public function preview_redirect_version_prev($id, $lecture_id)
    {
        $course = CourseVersion::where('id', $id)->first();

        if ($course) {
            $currentLecture = LectureVersion::find($lecture_id);
            if (!$currentLecture) {
                return redirect()->route('admin.courses.versions');
            }

            $currentSection = SectionVersion::find($currentLecture->section_id);
            if (!$currentSection) {
                return redirect()->route('admin.courses.versions');
            }

            $prevLecture = LectureVersion::where('section_id', $currentSection->id)
                ->where('order', '<', $currentLecture->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($prevLecture) {
                return redirect()->route('admin.courses.preview.version', [
                    'id' => $id,
                    'lecture' => $prevLecture->id,
                ]);
            } else {
                $prevSection = SectionVersion::where('course_id', $currentSection->course_id)
                    ->where('order', '<', $currentSection->order)
                    ->orderBy('order', 'desc')
                    ->first();

                if ($prevSection) {
                    $prevLecture = LectureVersion::where('section_id', $prevSection->id)
                        ->orderBy('order', 'desc')
                        ->first();

                    if ($prevLecture) {
                        return redirect()->route('admin.courses.preview.version', [
                            'id' => $id,
                            'lecture' => $prevLecture->id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.courses.versions');
    }

    public function preview_version($id, $lecture_id)
    {
        $course = CourseVersion::where('id', $id)->first();

        if ($course) {
            $lecture = LectureVersion::where('id', $lecture_id)->first();

            if ($lecture) {
                $sections = SectionVersion::where('course_id', $id)
                    ->orderBy('order')
                    ->get();

                $lectures = LectureVersion::whereIn('section_id', $sections->pluck('id'))
                    ->orderBy('section_id')
                    ->orderBy('order')
                    ->get();

                $lastSection = $sections->last();
                $lastLecture = $lectures->where('section_id', $lastSection->id)->last();
                $last =  ($lecture->id == $lastLecture->id);

                $data = null;
                if ($lecture->type === 'article') {
                    $data = ArticleLectureVersion::where('lecture_id', $lecture->id)->first();
                    if (!$data) {
                        abort(404, 'Article content not found');
                    }
                    return view('admin.lecture-version.article', [
                        'course_id' => $id,
                        'data' => $data,
                        'sections' => $sections,
                        'lectures' => $lectures,
                        'last' => $last,
                    ]);
                } elseif ($lecture->type === 'video') {
                    $data = VideoLectureVersion::where('lecture_id', $lecture->id)->first();
                    if (!$data) {
                        abort(404, 'Video content not found');
                    }

                    return view('admin.lecture-version.video', [
                        'course_id' => $id,
                        'data' => $data,
                        'sections' => $sections,
                        'lectures' => $lectures,
                        'video_id' => $this->getYouTubeVideoID($data->video_url),
                        'last' => $last,
                    ]);
                }
            }
        }

        return redirect()->route('admin.courses.versions');
    }

    function getYouTubeVideoID($url) {
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

    public function pendings()
    {
        $reviews = ReviewVersion::orderBy('updated_at', 'desc')->get();
        return view('admin.courses.pendings', [
            'reviews' => $reviews,
        ]);
    }

    public function start_review($id)
    {
        $review = ReviewVersion::find($id);
        if ($review) {
            $course = CourseVersion::find($review->course_id);
            if ($course) {
                $review->admin_saw = Auth::id();
                $review->status = 'started';
                $review->seen_at = now();
                $review->save();
                return redirect()->route('admin.courses.show.version', ['id' => $course->id]);
            }
        }
        return redirect()->route('admin.courses.pendings');
    }

    public function version_reject(Request $request)
    {
        $id = $request->input('course_id');
        $course = CourseVersion::find($id);
        if ($course) {
            $lastReview = ReviewVersion::where('course_id', $course->id)
                ->orderBy('order', 'desc')
                ->first();

            if ($lastReview && ($lastReview-> status === 'pending' || $lastReview-> status === 'started')) {
                $lastReview->status = 'rejected';
                $lastReview->feedback = $request->input('feedback');
                $lastReview->admin_finished = Auth::id();
                $lastReview->finished_at = now();
                $lastReview->save();

                $course->status = 'rejected';
                $course->save();

                return redirect()->route('admin.courses.show.version', ['id' => $id]);
            }
        }
        return redirect()->route('admin.courses.pendings');
    }

    public function version_accept(Request $request)
    {
        $id = $request->input('course_id');
        $course = CourseVersion::find($id);
        if ($course) {
            $lastReview = ReviewVersion::where('course_id', $course->id)
                ->orderBy('order', 'desc')
                ->first();

            if ($lastReview && ($lastReview-> status === 'pending' || $lastReview-> status === 'started')) {
                $lastReview->status = 'accepted';
                $lastReview->admin_finished = Auth::id();
                $lastReview->finished_at = now();
                $lastReview->save();

                $course->status = 'accepted';
                $course->save();

                return redirect()->route('admin.courses.show.version', ['id' => $id]);
            }
        }
        return redirect()->route('admin.courses.pendings');
    }
}
