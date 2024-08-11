@extends('layouts.app')

@section('content')
    <div class="container bg-light p-5">
        <h1>{{ $book->title }}</h1>
        <p><strong>Category:</strong> {{ $book->category->name }}</p>
        <p><strong>Description:</strong> {{ $book->description }}</p>
        <p><strong>Quantity:</strong> {{ $book->quantity }}</p>
        <p><strong>File:</strong> <a href="{{ asset('storage/' . $book->file_path) }}">Download</a></p>
        <p><strong>Cover Image:</strong> <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="Cover Image"
                style="max-width: 100px;"></p>
        <a href="{{ route('books.index') }}" class="btn btn-primary mr-3">Kembali</a>
    </div>
@endsection
