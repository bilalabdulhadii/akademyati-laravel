<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ArticleLecture;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseAttribute;
use App\Models\CourseRating;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\Section;
use App\Models\Student;
use App\Models\VideoLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'published')->get();

        return view('home.index', [
            'courses' => $courses,
        ]);
    }

    public function for_instructors()
    {
        return view('home.for-instructors');
    }

    public function course_index($slug, $id)
    {
        $course = Course::find($id);
        if ($course && $course->status == 'published' && $slug === Str::slug($course->title)) {
            $attributes = CourseAttribute::where('course_id', $id)->get();
            $data = $this->getCurriculumPublished($id);
            $enrollment = null;
            if (Auth::check() && Auth::user()->hasRole('student')) {
                $userId = Auth::id();
                $student = Student::where('user_id', $userId)->first();
                $enrollment = Enrollment::where('student_id', $student->id)
                    ->where('course_id', $id)
                    ->first();
            }

            return view('home.course', [
                'data' => $data,
                'course' => $course,
                'attributes' => $attributes,
                'enrollment' => $enrollment,
            ]);
        }
        return redirect()->route('courses.index');
    }

    public function course_rating($slug, $id)
    {
        $course = Course::find($id);
        if ($course && $course->status == 'published' && $slug === Str::slug($course->title)) {
            $enrollment = null;
            $student_rate = null;
            if (Auth::check() && Auth::user()->hasRole('student')) {
                $userId = Auth::id();
                $student = Student::where('user_id', $userId)->first();
                $enrollment = Enrollment::where('student_id', $student->id)
                    ->where('course_id', $id)
                    ->first();
                if ($enrollment) {
                    $rate = CourseRating::where('course_id', $id)
                        ->where('student_id', $student->id)
                        ->first();
                    if ($rate) {
                        $student_rate = $rate;
                        $enrollment->has_rate = true;
                    } else {
                        $enrollment->has_rate = false;
                    }
                }
            }
            $ratings = CourseRating::where('course_id', $id)->get();
            return view('home.course-rating', [
                'course' => $course,
                'ratings' => $ratings,
                'student_rate' => $student_rate,
                'enrollment' => $enrollment,
            ]);
        }
        return redirect()->route('courses.index');
    }

    public function course_rating_store(Request $request, $slug, $id)
    {
        $course = Course::find($id);
        if ($course && $course->status == 'published' && $slug === Str::slug($course->title)) {
            $enrollment = null;
            if (Auth::check() && Auth::user()->hasRole('student')) {
                $userId = Auth::id();
                $student = Student::where('user_id', $userId)->first();
                $enrollment = Enrollment::where('student_id', $student->id)
                    ->where('course_id', $id)
                    ->first();
                if ($enrollment) {
                    $rate = CourseRating::where('course_id', $id)
                        ->where('student_id', $student->id)
                        ->first();
                    if (!$rate) {
                        $newRating = new CourseRating();
                        $newRating->student_id = $student->id;
                        $newRating->course_id = $course->id;
                        $newRating->enrollment_id = $enrollment->id;
                        $newRating->rating = $request->input('rating_value');
                        $newRating->comment = $request->input('rating_comment');
                        $newRating->save();
                    } else {
                        $rate->rating = $request->input('rating_value');
                        $rate->comment = $request->input('rating_comment');
                        $rate->save();
                    }
                    $course->rating = CourseRating::where('course_id', $id)->avg('rating');
                    $course->save();
                }
            }
            return redirect()->route('course.index.rating', [
                'slug' => Str::slug($course->title),
                'id' => $course->id
            ]);
        }
        return redirect()->route('courses.index');
    }

    function formatDuration($seconds)
    {
        // Calculate hours, minutes, and seconds
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Format the string
        $formattedDuration = '';

        if ($hours > 0) {
            $formattedDuration .= str_pad($hours, 2, '0', STR_PAD_LEFT) . ':';
        }
        $formattedDuration .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);

        return $formattedDuration;
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
                            'duration' => $this->formatDuration($articleLecture->duration),
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
                            'duration' => $this->formatDuration($videoLecture->duration),
                        ];
                    }
                }
            }
        }

        return $data;
    }

    public function courses(Request $request)
    {
        $categories = Category::where('level', 1)->get();

        $query = Course::where('status', 'published');

        // Filter by category
        if ($request->has('category')) {
            $slug = $request->query('category');
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $query->where(function ($q) use ($category) {
                    $q->where('category_id', $category->id)
                        ->orWhere('subcategory_id', $category->id)
                        ->orWhere('subsubcategory_id', $category->id);
                });
            }
        }

        // Filter by rating
        if ($request->has('rate')) {
            $rate = $request->query('rate');
            switch ($rate) {
                case 'top':
                    $query->where('rating', '>=', 4.5);
                    break;
                case 'high':
                    $query->where('rating', '>=', 4);
                    break;
                case 'well':
                    $query->where('rating', '>=', 3);
                    break;
                case 'good':
                    $query->where('rating', '>=', 2);
                    break;
                case 'all':
                    $query->where('rating', '>=', 0);
                    break;
            }
        }

        $courses = $query->get();

        return view('home.courses', [
            'courses' => $courses,
            'categories' => $categories,
        ]);
    }
}
