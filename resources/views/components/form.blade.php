<form action="{{route('book.addManualBook')}}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Judul Buku</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Penulis</label>
      <input type="text" class="form-control" id="author" name="author">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Harga</label>
        <input type="text" class="form-control" id="price" name="price">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Tanggal Terbit</label>
        <input type="date" class="form-control" id="date" name="published_date">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>