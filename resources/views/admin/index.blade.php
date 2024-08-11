@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Selamat datang di halaman admin.</p>
        <a href="{{ route('admin.users') }}" class="btn btn-primary">Manage Users</a>
    </div>
@endsection
