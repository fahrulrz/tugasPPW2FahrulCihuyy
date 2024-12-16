<form action="{{ route('book.addRandom') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Tambahkan Buku Acak</button>
</form>
