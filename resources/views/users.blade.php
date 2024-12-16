@extends('auth.layouts')
@section('content')
    <table class="table">
        <thead>
            <tr class="table-primary">
                <td scope="col">No</td>
                <td scope="col">Name</td>
                <td scope="col">Email</td>
                <td scope="col">Photo</td>
                <td scope="col">Action</td>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            @foreach ($userss as $user)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->photo)
                            <a href="{{ asset('storage/' . $user->photo) }}">

                                <img src="{{ asset('storage/' . $user->photo) }}" width="150px"
                                    alt="photo {{ $user->name }}">
                            </a>
                        @else
                            <img src="{{ asset('storage/default.png') }}" width="150px" alt="no photo">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @method('DELETE')
                            {{ csrf_field() }} <br>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
