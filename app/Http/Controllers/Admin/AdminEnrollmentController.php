<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminEnrollmentController extends Controller
{

    public function enrollments()
    {
        $enrollments = Enrollment::orderBy('updated_at', 'desc')->get();
        return view('admin.enrollments.index', [
            'enrollments' => $enrollments,
        ]);
    }

    public function enrollment_show($id)
    {
        $enrollment = Enrollment::find($id);
        if ($enrollment) {
            return view('admin.enrollments.show', [
                'enrollment' => $enrollment,
            ]);
        }
        return redirect()->route('admin.enrollments');
    }

    public function suspend(Request $request)
    {
        $enrollment = Enrollment::find($request->input('enrollment_id'));
        if ($enrollment) {
            $enrollment->status = 'suspended';
            $enrollment->save();
            return redirect()->route('admin.enrollments.show', [
                'id' => $enrollment->id,
            ]);
        }
        return redirect()->route('admin.enrollments');
    }

    public function reactivate(Request $request)
    {
        $enrollment = Enrollment::find($request->input('enrollment_id'));
        if ($enrollment) {
            $enrollment->status = 'active';
            $enrollment->save();
            return redirect()->route('admin.enrollments.show', [
                'id' => $enrollment->id,
            ]);
        }
        return redirect()->route('admin.enrollments');
    }
}
