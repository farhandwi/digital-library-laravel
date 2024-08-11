@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Books by {{ $user->name }}</h1>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('admin.users.books', $user->id) }}"
            class="d-flex form-inline mb-3 justify-content-end">
            <div class="input-group input-group-sm " style="width: 20%">
                <input type="text" name="category" class="form-control" placeholder="Search by Category"
                    value="{{ request('category') }}">
                <button type="submit" class="btn btn-secondary px-3 mx-3">Search</button>
            </div>
        </form>

        <!-- Tombol Export -->
        <di class="d-flex justify-content-end gap-2 mb-3">
            <a href="{{ route('books.export.excel', $user ? $user->id : Auth::id()) }}" class="btn btn-success mr-2">Export
                to
                Excel</a>
            <a href="{{ route('books.export.pdf', $user ? $user->id : Auth::id()) }}" class="btn btn-danger">Export
                to PDF</a>
        </di>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Cover</th>
                    <th>PDF</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->category ? $book->category->name : 'No Category' }}</td>
                        <td>{{ $book->description }}</td>
                        <td>{{ $book->quantity }}</td>
                        <td>
                            @if ($book->cover_image_path)
                                <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="Cover Image"
                                    style="max-width: 50px;">
                            @endif
                        </td>
                        <td>
                            @if ($book->file_path)
                                <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank">View PDF</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.books.delete', $book->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <form method="GET" action="{{ route('admin.users.books', $user->id) }}" class="form-inline w-auto">
                <label for="per_page" class="mr-2">Show</label>
                <select name="per_page" id="per_page" class="form-control form-control-sm mr-2"
                    onchange="this.form.submit()">
                    <option value="5"{{ $perPage == 5 ? ' selected' : '' }}>5</option>
                    <option value="10"{{ $perPage == 10 ? ' selected' : '' }}>10</option>
                    <option value="15"{{ $perPage == 15 ? ' selected' : '' }}>15</option>
                    <option value="20"{{ $perPage == 20 ? ' selected' : '' }}>20</option>
                </select>
            </form>
            {{ $books->appends(['per_page' => $perPage, 'category' => request('category')])->links('pagination::bootstrap-5') }}
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.users') }}" class="btn btn-light bg-primary text-white text-weight-bold">Kembali</a>
        </div>
    </div>
@endsection
