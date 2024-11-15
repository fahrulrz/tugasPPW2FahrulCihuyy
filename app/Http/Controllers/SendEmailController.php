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
        $data = $request->all();
        dispatch(new SendMailJob($data));
        return redirect()->route('kirim-email')->with('success', 'Email Berhasil Dikirim');
    }

    public function send($email, $name) {
        $user = User::where('email', $email)->first();
        $content = [
            'name' => $name,
            'subject' => $email,
            'body' => $user->created_at,
        ];  

        Mail::to('mfahrulrazi695@gmail.com')->send(new SendEmail($content)); 
        return redirect()->route('dashboard')->with('success', 'Email Berhasil Dikirim');
    }
}
