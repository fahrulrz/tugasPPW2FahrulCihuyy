<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendEmailController extends Controller
{
    public function index()
    {
        return view('emails.kirim-email');

        // $content = [
        //     'name' => 'ini adalah mname',
        //     'subject' => 'ini adalah subject',
        //     'body' => 'ini adalah email'
        // ];

        // Mail::to('mfahrulrazi695@gmail.com')->send(new SendEmail($content));
        // return "email berhasil dikirim";
    }

    public function store(Request $request) {
        // $data = $request->all();
        // dispatch(new SendMailJob($data));
        // return redirect()->route('kirim-email')->with('success', 'Email Berhasil Dikirim');


        // Validasi input dengan pesan error yang lebih deskriptif
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => ['required', 'string', 'max:255', 'not_in:Registration Successful'],
            'body' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.not_in' => 'Subject tidak boleh bernilai "Registration Successful".',
            'body.required' => 'Isi pesan tidak boleh kosong.'
        ]);

        try {
            // Dispatch job untuk mengirim email
            dispatch(new SendMailJob($validatedData));

            // Redirect dengan pesan sukses
            return redirect()->route('send.email')->with('success', 'Email berhasil dikirim!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    // public function send($email, $name) {
    //     $user = User::where('email', $email)->first();
    //     $content = [
    //         'name' => $name,
    //         'subject' => $email,
    //         'body' => $user->created_at,
    //     ];  

    //     Mail::to('mfahrulrazi695@gmail.com')->send(new SendEmail($content)); 
    //     return redirect()->route('dashboard')->with('success', 'Email Berhasil Dikirim');
    // }
}
