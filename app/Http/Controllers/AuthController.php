<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function admin_login()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'student') {
                return redirect()->route('home');
            } elseif ($user->role === 'admin' || $user->role === 'instructor') {
                return redirect()->route('dashboard');
            }
        }
        $admins = User::where('role', 'admin')->get();
        if ($admins->count() >= 1) {
            return redirect()->route('home');
        }
        return view('auth.admin-login');
    }

    public function admin_make_login(Request $request)
    {
        $request->validate([
            'login_email' => 'required|email',
            'login_password' => 'required',
        ]);

        $credentials = $request->only('login_email', 'login_password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('instructor')) {
                return redirect()->route('dashboard');
            } elseif (Auth::user()->hasRole('student')) {
                return redirect()->route('learning');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function admin_register(Request $request)
    {
        $request->validate([
            'register_first_name' => 'required|string',
            'register_last_name' => 'required|string',
            'register_username' => 'required|string',
            'register_email' => 'required|string',
            'register_password' => 'required|string',
        ]);

        $user = new User();
        $user->first_name = $request->input('register_first_name');
        $user->last_name = $request->input('register_last_name');
        $user->username = $request->input('register_username');
        $user->email = $request->input('register_email');
        $user->password = Hash::make($request->input('register_password'));
        $user->role = 'admin';
        $user->save();

        Auth::login($user);

        return redirect()->intended('dashboard');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'student') {
                return redirect()->route('home');
            } elseif ($user->role === 'admin' || $user->role === 'instructor') {
                return redirect()->route('dashboard');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('instructor')) {
                return redirect()->route('dashboard');
            } elseif (Auth::user()->hasRole('student')) {
                return redirect()->route('learning');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistration()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('instructor')) {
                return redirect()->route('dashboard');
            } elseif (Auth::user()->hasRole('student')) {
                return redirect()->route('learning');
            }

            return redirect()->route('home');
        }
        return view('auth.register');
    }

    // After the first stage of the registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Store basic info temporarily in session or request data
        $request->session()->put('basic_info', $request->all());

        // Redirect to role selection stage (second stage)
        /*return redirect()->route('profile-type');*/
        return view('auth.profile-type');
    }


    /*$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);*/



    // Redirect to the selection of the role (second stage)
    public function profile_type()
    {
        return view('auth.profile-type');
    }

    // After the selection of the role (second stage)
    public function store_basic_info(Request $request)
    {
        // Retrieve basic info from session or request data
        $basicInfo = $request->session()->get('basic_info');

        // Create new user record
        $user = new User();
        $user->first_name = $basicInfo['first_name'];
        $user->last_name = $basicInfo['last_name'];
        $user->username = $basicInfo['username'];
        $user->email = $basicInfo['email'];
        $user->password = bcrypt($basicInfo['password']);
        $user->role = $request->role;
        $user->save();


        // Save the user ID to the session for later use
        $request->session()->put('user_id', $user->id);


        // Create student or instructor record based on role
        if ($request->input('role') === 'student') {
            $student = new Student();
            $student->user_id = $user->id;
            $student->first_name = $basicInfo['first_name'];
            $student->last_name = $basicInfo['last_name'];
            $student->save();
        } elseif ($request->input('role') === 'instructor') {
            $instructor = new Instructor();
            $instructor->user_id = $user->id;
            $instructor->first_name = $basicInfo['first_name'];
            $instructor->last_name = $basicInfo['last_name'];
            $instructor->save();
        }


        // Clear basic_info from session after use
        $request->session()->forget('basic_info');

        // Redirect to additional information stage (third stage)
        if ($request->input('role') === 'instructor') {
            return view('auth.ins-additional-info');
        } else {
            return view('auth.std-additional-info');
        }
    }

    public function store_additional_info(Request $request)
    {
        $request->validate([
            'profile' => 'nullable|mimes:jpeg,jpg,png,webp',
        ]);

        $userId = $request->session()->get('user_id');
        $user = User::where('id', $userId)->first();



        if ($user->role === 'student') {
            $student = Student::where('user_id', $userId)->first();
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
            $student->status = true;
            $student->save();

            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $extension = $file->getClientOriginalExtension();
                $filename = 'std_' . time() . '.' . $extension;
                $filePath = $file->storeAs('users/avatars/students', $filename, 'public');
                $user->profile = $filePath;
                $user->save();
            }

        } elseif ($user->role === 'instructor') {
            $instructor = Instructor::where('user_id', $userId)->first();
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
            $instructor->status = true;
            $instructor->save();

            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $extension = $file->getClientOriginalExtension();
                $filename = 'ins_' . time() . '.' . $extension;
                $filePath = $file->storeAs('users/avatars/instructors', $filename, 'public');
                $user->profile = $filePath;
                $user->save();
            }
        }

        $request->session()->forget('user_id');
        Auth::login($user);
        if ($user->role === 'instructor') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('home');
    }

    public function skip_additional_info(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $user = User::where('id', $userId)->first();

        $request->session()->forget('user_id');
        Auth::login($user);
        if ($user->role === 'instructor') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('home');
    }
}


//Auth::loginUsingId($userId);
//Auth::login($user);
