<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseBookmark;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if ($user->role == 'student') {
            $student = Student::where('user_id', $user->id)->first();
            $enrollments = Enrollment::where('student_id', $student->id)
                ->whereNot('status', 'suspended')
                ->get();

            $fieldsWithWeights = [
                'gender' => 1,
                'bio' => 2,
                'phone' => 1,
                'address' => 1,
                'birth' => 1,
                'nationality' => 1,
                'education_level' => 2,
                'language' => 1,
            ];

            $totalWeight = array_sum($fieldsWithWeights) + 3;
            $completedWeight = 0;
            $progress = [];
            $progress['profile'] = false;
            if ($user->profile) {
                $completedWeight += 3;
                $progress['profile'] = true;
            }

            $additional = true;
            foreach ($fieldsWithWeights as $field => $weight) {
                if (!empty($student->$field)) {
                    $completedWeight += $weight;
                } else {
                    $additional = false;
                }
            }

            $progress['additional'] = $additional;
            $progress['value'] = ($completedWeight / $totalWeight) * 100;

            return view('student.profile', [
                'user' => $user,
                'student' => $student,
                'enrollments' => $enrollments,
                'progress' => $progress,
            ]);
        }
        return redirect()->route('home');
    }

    public function profile_update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user && $user->role === 'student') {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->save();

            $request->validate([
                'profile' => 'nullable|mimes:jpeg,jpg,png,webp',
            ]);

            $student = Student::where('user_id', $user->id)->first();
            if ($student) {
                $student->first_name = $request->input('first_name');
                $student->last_name = $request->input('last_name');
                $student->gender = $request->input('gender');
                $student->bio = $request->input('bio');
                $student->phone = $request->input('phone');
                $student->address = $request->input('address');
                $student->birth = $request->input('birth');
                $student->nationality = $request->input('nationality');
                $student->education_level = $request->input('education_level');
                $student->language = $request->input('language');
                $student->save();

                if ($request->hasFile('profile')) {
                    if ($user->profile) {
                        Storage::delete($user->profile);
                        $user->profile = '';
                        $user->save();
                    }

                    $file = $request->file('profile');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'std_' . time() . '.' . $extension;
                    $filePath = $file->storeAs('users/avatars/students', $filename, 'public');
                    $user->profile = $filePath;
                    $user->save();
                }
            }

            return redirect()->route('std.profile', ['username' => $user->username]);
        }
        return redirect()->route('home');
    }

    public function course_bookmark(Request $request)
    {
        $userId = Auth::id();
        $courseId = $request->input('course_id');

        // Check if the bookmark already exists
        $existingBookmark = CourseBookmark::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->first();

        if ($existingBookmark) {
            $existingBookmark->delete();
        } else {
            $bookmark = new CourseBookmark();
            $bookmark->user_id = $userId;
            $bookmark->course_id = $courseId;
            $bookmark->save();
        }

        // Redirect back to the previous page
        return redirect()->back();
    }
}
