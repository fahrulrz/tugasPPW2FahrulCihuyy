@extends('auth.layouts')
@section('content')
    <table>
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Photo</td>
            <td>Action</td>
        </tr>
        @foreach ($userss as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" width="100px" alt="photo {{ $user->name }}">
                    @else
                        <img src="{{ asset('storage/default.png') }}" width="100px" alt="no photo">
                    @endif
                </td>
                <td>
                    <button>
                        Edit
                    </button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @method('DELETE')
                        {{ csrf_field() }} <br>
                        <button type="submit" class="btn btn-danger">Delete</button>

                    </form>
                </td>
            </tr>
        @endforeach
    </table>
