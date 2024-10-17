<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = "books";

    protected $casts = [
        'tgl_terbit' => 'date',
    ];

    protected $fillable = [
        'judul',
        'penulis',
        'harga',
        'tgl_terbit',
    ];

    protected $dates = [
        'tgl_terbit',
    ];
}
