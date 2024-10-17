<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index() {
        $book_data = Book::all();
        $jumlahBuku = Book::distinct('judul')->count('judul');
        $totalHarga = Book::sum('harga');

        return view('book.index', compact('book_data', 'totalHarga', 'jumlahBuku')); //book.index berarti merujuk ke halaman views pada folder book dan pada file index
    }

    public function addManualBook(Request $request) {
        
        //validasi input dari form
        $request->validate(
            [
                'title' => 'required|max:255',
                'author' => 'required|max:255',
                'price' => 'required|numeric',
                'published_date' => 'required|date',
            ]
        );

        $book = new Book;
        $book->judul = $request->title;
        $book->penulis = $request->author;
        $book->harga = $request->price;
        $book->tgl_terbit = $request->published_date;
        $book->save();

        return redirect()->route('index')->with('success', 'Buku baru ditambahkan');
    }

    public function addRandom() {
        Book::create([
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'harga'=> fake()->numberBetween(10000,50000),
            'tgl_terbit' => fake()->date(),
        ]);
        return redirect()->route('index')->with('success', 'Buku acak ditambahkan');
    }
    
    //Mengedit data
    public function edit($id) {
        // Ambil buku berdasarkan ID
        $book = Book::findOrFail($id);
    
        // Tampilkan formulir edit dengan data buku
        return view('book.edit', compact('book'));
    }
    
    public function update(Request $request, $id) {
        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'price' => 'required|numeric',
            'published_date' => 'required|date',
        ]);
    
        // Ambil buku berdasarkan ID
        $book = Book::findOrFail($id);
    
        // Perbarui data buku
        $book->judul = $request->title;
        $book->penulis = $request->author;
        $book->harga = $request->price;
        $book->tgl_terbit = $request->published_date;
        $book->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('index')->with('success', 'Buku berhasil diperbarui');
    }
    
    public function destroy($id) {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('index')->with('success', 'Buku berhasil dihapus');
    }

}
