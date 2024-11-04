@extends('auth.layouts')

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Foto</div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    id="photo" name="photo">
                                @if ($errors->has('photo'))
                                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                                @endif
                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
