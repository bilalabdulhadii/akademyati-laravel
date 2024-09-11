<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsDashController extends Controller
{
    /*public function index()
    {
        $instructor = Instructor::where('user_id', Auth::id())->first();

        $courseIds = Course::where('instructor_id', $instructor->id)
            ->pluck('id');
        $enrollments = Enrollment::whereIn('course_id', $courseIds)
            ->distinct('student_id')
            ->count('student_id');

        $revenue = 0;
        $courses = Course::where('instructor_id', $instructor->id)->get();
        foreach ($courses as $course) {
            $enrollmentCount = Enrollment::where('course_id', $course->id)->count();
            $revenue += $enrollmentCount * $course->price;
        }

        $data = [
            'courses' => $courses->count(),
            'enrollments' => $enrollments,
            'revenue' => $revenue,
        ];

        return view('instructor.index', [
            'data' => $data,
        ]);
    }*/
}
