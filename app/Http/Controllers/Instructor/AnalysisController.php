<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LectureProgress;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index()
    {
        $data = [
            'totalEnrollments' => '0',
            'completionRate' => '0',
            'lectureCompletionRate' => '0',
        ];

        $course = Course::find(1);

        if ($course) {
            // Assuming you have relationships set up
            $totalEnrollments = $course->enrollments()->count();

            // Completion Rate
            $completedEnrollments = Enrollment::where('status', 'completed')
                ->where('course_id', $course->id)
                ->count();
            $completionRate = $totalEnrollments > 0 ? ($completedEnrollments / $totalEnrollments) * 100 : 0;

            // Lecture Completion Rate
            $completedLecturesCount = $course->lectures()->whereHas('lectureProgress', function ($query) {
                $query->where('is_done', true);
            })->count();

            $totalLecturesCount = $course->sections->sum('lectures_count');
            $lectureCompletionRate = $totalLecturesCount > 0 ? ($completedLecturesCount / $totalLecturesCount) * 100 : 0;

            $data = [
                'totalEnrollments' => $totalEnrollments,
                'completionRate' => $completionRate,
                'lectureCompletionRate' => $lectureCompletionRate,
            ];
        }

        return view('instructor.analysis', [
            'data' => $data,
        ]);
    }
}
