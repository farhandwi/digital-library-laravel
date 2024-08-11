@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Book</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.books.update', $book->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ $book->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $book->quantity }}"
                    required>
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                @if ($book->cover_image_path)
                    <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="Cover Image"
                        style="max-width: 100px; margin-top: 10px;">
                @endif
            </div>

            <div class="form-group">
                <label for="pdf_file">PDF File</label>
                <input type="file" class="form-control-file" id="pdf_file" name="pdf_file">
                @if ($book->file_path)
                    <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank"
                        style="display: block; margin-top: 10px;">View PDF</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
@endsection
