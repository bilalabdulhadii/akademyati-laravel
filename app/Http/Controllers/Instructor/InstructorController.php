<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if ($user->role === 'instructor') {
            $instructor = Instructor::where('user_id', $user->id)->first();
            $courses = Course::where('instructor_id', $instructor->id)->get();

            $fieldsWithWeights = [
                'gender' => 1,
                'bio' => 2,
                'phone' => 1,
                'address' => 1,
                'birth' => 1,
                'nationality' => 1,
                'education_level' => 2,
                'field_of_expertise' => 1,
                'professional_title' => 2,
                'certifications' => 1,
                'experience' => 1,
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
                if (!empty($instructor->$field)) {
                    $completedWeight += $weight;
                } else {
                    $additional = false;
                }
            }

            $progress['additional'] = $additional;
            $progress['value'] = ($completedWeight / $totalWeight) * 100;

            return view('instructor.profile', [
                'user' => $user,
                'instructor' => $instructor,
                'courses' => $courses,
                'progress' => $progress,
            ]);
        }
        return redirect()->route('home');
    }

    public function profile_update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user && $user->role === 'instructor') {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->save();

            $request->validate([
                'profile' => 'nullable|mimes:jpeg,jpg,png,webp',
            ]);

            $instructor = Instructor::where('user_id', $user->id)->first();
            if ($instructor) {
                $instructor->first_name = $request->input('first_name');
                $instructor->last_name = $request->input('last_name');
                $instructor->gender = $request->input('gender');
                $instructor->bio = $request->input('bio');
                $instructor->phone = $request->input('phone');
                $instructor->address = $request->input('address');
                $instructor->birth = $request->input('birth');
                $instructor->nationality = $request->input('nationality');
                $instructor->education_level = $request->input('education_level');
                $instructor->field_of_expertise = $request->input('field_of_expertise');
                $instructor->professional_title = $request->input('professional_title');
                $instructor->certifications = $request->input('certifications');
                $instructor->experience = $request->input('experience');
                $instructor->language = $request->input('language');
                $instructor->save();

                if ($request->hasFile('profile')) {
                    if ($user->profile) {
                        Storage::delete($user->profile);
                        $user->profile = '';
                        $user->save();
                    }

                    $file = $request->file('profile');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'ins_' . time() . '.' . $extension;
                    $filePath = $file->storeAs('users/avatars/instructors', $filename, 'public');
                    $user->profile = $filePath;
                    $user->save();
                }
            }

            return redirect()->route('ins.profile', ['username' => $user->username]);
        }
        return redirect()->route('home');
    }
}
