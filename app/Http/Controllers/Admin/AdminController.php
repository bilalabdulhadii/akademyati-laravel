<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if ($user->role === 'admin' && Auth::user()->hasRole('admin')) {
            $user = Auth::user();
            return view('admin.profile', [
                'user' => $user,
            ]);
        }
        return redirect()->route('home');
    }

    public function settings()
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            $user = Auth::user();
            return view('admin.settings', [
                'user' => $user,
            ]);
        }
        return redirect()->route('home');
    }

    public function settings_update(Request $request)
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            $user = User::find($request->input('user_id'));
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->save();

            $request->validate([
                'profile' => 'nullable|mimes:jpeg,jpg,png,webp',
            ]);

            if ($request->hasFile('profile')) {
                if ($user->profile) {
                    Storage::delete($user->profile);
                    $user->profile = '';
                    $user->save();
                }

                $file = $request->file('profile');
                $extension = $file->getClientOriginalExtension();
                $filename = 'admin_' . time() . '.' . $extension;
                $filePath = $file->storeAs('users/avatars/admins', $filename, 'public');
                $user->profile = $filePath;
                $user->save();
            }

            return redirect()->route('admin.profile', [
                'username' => $user->username,
            ]);
        }
        return redirect()->route('home');
    }
}
