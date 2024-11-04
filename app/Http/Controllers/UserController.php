<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function edit($id) {
        $user = User::find($id);
        return view('edit')->with('user', $user);
    }

    public function update(Request $request, $id) {
        // mengambil data user
        $user = User::find($id);

        // validasi file foto jika ada
        if ($request->hasFile('photo')) {
            // hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete('images/'. $user->photo);
            }


            // menyimpan file baru
            $filenameWithExt = $request->file('photo')->getClientoriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;

            // menyimpan foto di storage
            $path = $request->file('photo')->storeAs('images', $filenameSimpan, 'public');

            // update nama (path) di database
            $user->photo = $path;
            $user->save();
            // menyimpan perubahan
            return redirect('users')->with('success', "Data user berhasil diperbarui");
        }
        return redirect()->back()->with('error', "Tidak ada file foto yang di-upload.");
    }
}
