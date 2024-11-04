<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Please login to access the dashboard.'])->onlyInput('email');
        }
        $users = User::get();
        return view('users')->with('userss', $users);
    }

    public function destroy($id) {
        $user = User::find($id);
        $file = public_path() . '/storage/' . $user->photo;
        try {
            if (File::exists($file)) {
                File::delete($file);
                $user->delete();
            }
        } catch (\Throwable $th) {
            
            return redirect('users')->with('error', "Gagal hapus foto");
        }
        return redirect('users')->with('success', "Foto berhasil dihapus");
    }
}
