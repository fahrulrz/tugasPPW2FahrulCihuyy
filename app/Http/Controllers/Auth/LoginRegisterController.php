<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoginRegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    // membuat user baru

    public function store(Request $request)
    {
        dd($request->file('photo'));

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'photo' => 'image|mimes:png,jpg,jpeg|max:1999'
        ]);

        $fileNameToStore = null;

        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            // Simpan file foto ke direktori 'public/images'
            $path = $request->file('photo')->storeAs('images', $fileNameToStore, 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $fileNameToStore
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->withSuccess('You have successfully registered & logged in!');
    }

    // menampilkan login form
    public function login()
    {
        return view('auth.login');
    }

    // authenticate user
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
        }
        return back()->withErrors(['email' => 'Wrong email or password.'])->onlyInput('email');
    }

    // display dashboard to authenticated users
    public function dasbhboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        return redirect()->route('login')->withError('Please login first');
    }

    // logout the user from application
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withSuccess('You have successfully logged out!');
    }
}
