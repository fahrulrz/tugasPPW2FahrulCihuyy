<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoCOntroller extends Controller
{
    public function index(){
        return response()->json(['message'=> 'Hello Wordl', 'succes' => true], 200);
    }
}
