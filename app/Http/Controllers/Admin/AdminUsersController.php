<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function instructor()
    {
        $users = User::orderBy('created_at', 'desc')
            ->where('role', 'instructor')->get();
        return view('admin.users.instructor', [
            'users' => $users,
        ]);
    }

    public function student()
    {
        $users = User::orderBy('created_at', 'desc')
            ->where('role', 'student')->get();
        return view('admin.users.student', [
            'users' => $users,
        ]);
    }

    public function create(Request $request)
    {
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();


        // Create student or instructor record based on role
        if ($request->input('role') === 'student') {
            $student = new Student();
            $student->user_id = $user->id;
            $student->first_name = $request->input('first_name');
            $student->last_name = $request->input('last_name');
            $student->save();
        } elseif ($request->input('role') === 'instructor') {
            $instructor = new Instructor();
            $instructor->user_id = $user->id;
            $instructor->first_name = $request->input('first_name');
            $instructor->last_name = $request->input('last_name');
            $instructor->save();
        }

        return redirect()->route('admin.users');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->role === 'student') {
                $student = Student::where('user_id', $id)->first();
                return view('admin.users.std-edit', [
                    'user' => $user,
                    'student' => $student,
                ]);
            } elseif ($user->role === 'instructor') {
                $instructor = Instructor::where('user_id', $id)->first();
                return view('admin.users.ins-edit', [
                    'user' => $user,
                    'instructor' => $instructor,
                ]);
            } elseif ($user->role === 'admin') {
                return view('admin.users.admin-edit', [
                    'user' => $user,
                ]);

            }
            return redirect()->route('admin.users');
        }
        return redirect()->route('admin.users');
    }

    public function update_ins(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $instructor = Instructor::where('user_id', $id)->first();
            if ($instructor) {
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

                return redirect()->route('admin.users.edit', [
                    'id' => $user->id,
                ]);
            }
            return redirect()->route('admin.users');
        }
        return redirect()->route('admin.users');
    }

    public function update_std(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $student = Student::where('user_id', $id)->first();
            if ($student) {
                $student->gender = $request->input('gender');
                $student->bio = $request->input('bio');
                $student->phone = $request->input('phone');
                $student->address = $request->input('address');
                $student->birth = $request->input('birth');
                $student->nationality = $request->input('nationality');
                $student->education_level = $request->input('education_level');
                $student->major = $request->input('major');
                $student->interests = $request->input('interests');
                $student->language = $request->input('language');
                $student->save();

                return redirect()->route('admin.users.edit', [
                    'id' => $user->id,
                ]);
            }
            return redirect()->route('admin.users');
        }
        return redirect()->route('admin.users');
    }

    public function update_basic(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->save();

            if ($user->role === 'student') {
                $student = Student::where('user_id', $id)->first();
                if ($student) {
                    $student->first_name = $request->input('first_name');
                    $student->last_name = $request->input('last_name');
                    $student->save();
                }
            } elseif ($user->role === 'instructor') {
                $instructor = Instructor::where('user_id', $id)->first();
                if ($instructor) {
                    $instructor->first_name = $request->input('first_name');
                    $instructor->last_name = $request->input('last_name');
                    $instructor->save();
                }
            }
            return redirect()->route('admin.users.edit', [
                'id' => $user->id,
            ]);
        }
        return redirect()->route('admin.users');
    }

    public function update_password(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->password = Hash::make($request->input('password'));

            $user->save();return redirect()->route('admin.users.edit', [
                'id' => $user->id,
            ]);
        }
        return redirect()->route('admin.users');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
        $user->delete();
        return redirect()->route('admin.users');
    }

}
