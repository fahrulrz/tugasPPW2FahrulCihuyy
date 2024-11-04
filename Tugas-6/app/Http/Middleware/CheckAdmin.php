<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role === "admin") {
            session()->flash('success', 'Anda login sebagai administrador');
            return $next($request);
        }

        return redirect('welcome')->with('error', 'Anda Login sebagai user');
    }
}
