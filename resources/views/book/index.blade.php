<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="m-5" >

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')


    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Penulis</th>
            <th scope="col">Harga</th>
            <th scope="col">Tanggal Terbit</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($book_data as $book)                
            <tr>
              <th scope="row">{{$book->id}}</th>
              <td> {{$book->judul}} </td>
              <td> {{$book->penulis}} </td>
              <td> {{"Rp. ".number_format($book->harga, 2, ",", ".")}} </td>
              <td> {{$book->tgl_terbit->format('d/m/Y')}} </td>
              <td> <form action="{{ route('book.destroy', $book->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin mau di hapus')" type="submit" class="btn btn-danger">Hapus</button>
              </form> 
              <a href="{{ route('book.edit', $book->id) }}" class="btn btn-warning">Edit</a>
            </td>
            
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="table-success" style="text-align: center; font-weight: bold">Jumlah Buku</td>
                <td colspan="2" class="table-primary" style="font-weight: bold">{{$jumlahBuku}}</td>
            </tr>
            <tr>
                <td colspan="4" class="table-primary" style="text-align: center; font-weight: bold">Total Harga</td>
                <td colspan="2" class="table-success" style="font-weight: bold">{{"Rp. ".number_format($totalHarga, 2, ",", ".")}}</td>
            </tr>
        </tbody>
      </table>

      <br>
      <br>
      <x-form></x-form>
      <br>
      <x-button-random></x-button-random>

      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>