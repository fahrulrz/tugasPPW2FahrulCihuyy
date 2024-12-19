<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMailJob;
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

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'photo' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientoriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('images', $filenameSimpan);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $path
        ]);

        $credentials = $request->only('email', 'password'); //! Baris ini mengambil hanya email dan password dari request untuk digunakan sebagai kredensial saat mencoba untuk login. Fungsi only memastikan bahwa hanya data yang diperlukan yang diambil, yang membantu mencegah kebocoran data sensitif.
        Auth::attempt($credentials); //! Fungsi ini mencoba untuk melakukan login dengan menggunakan kredensial yang telah disiapkan. Jika login berhasil, sesi pengguna akan dimulai, dan pengguna akan dianggap terautentikasi.
        $request->session()->regenerate();  //! Setelah berhasil login, sesi pengguna diatur ulang. Ini penting untuk mencegah serangan "session fixation," di mana penyerang mencoba untuk menggunakan sesi yang sudah ada untuk mendapatkan akses. Dengan mengatur ulang sesi, Laravel membuat sesi baru untuk pengguna yang baru saja login.

        // Kirim email konfirmasi register
        $registerEmail = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => 'Register Success'
        ];

        dispatch(new SendMailJob($registerEmail));

        return redirect()->route('dashboard')->withSuccess('You have successfully registered & logged in!');
    
        // return redirect()->route('kirim-email');
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
