@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users List</h1>

        <form method="GET" action="{{ route('admin.users') }}" class="d-flex form-inline mb-3 justify-content-end gap-2">
            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search by Name"
                style="width: 15%" value="{{ $search }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.users.books', $user->id) }}" class="btn btn-info btn-sm">View Books</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $users->appends(['search' => $search])->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
