<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="m-5">
    <h1>Edit Buku</h1>
    <form action="{{ route('book.update', $book->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $book->judul }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ $book->penulis }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Harga</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $book->harga }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Tanggal Terbit</label>
            <input type="date" class="form-control" id="date" name="published_date" value="{{ $book->tgl_terbit->format('Y-m-d') }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
