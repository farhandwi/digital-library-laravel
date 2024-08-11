@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <h1>{{ $user ? $user->name . "'s Books" : 'Your Books' }}</h1>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Tombol "Add Book" -->
                    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>

                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ route('books.index') }}" class="form-inline ">
                        <div class="input-group input-group-sm w-100">
                            <input type="text" name="category" class="form-control" placeholder="Search by Category"
                                value="{{ request('category') }}">
                            <button type="submit" class="btn btn-secondary px-3 mx-3">Search</button>
                        </div>
                    </form>
                </div>


                <!-- Tombol Export -->
                <di class="d-flex justify-content-end gap-2">
                    <a href="{{ route('books.export.excel', $user ? $user->id : Auth::id()) }}"
                        class="btn btn-success mr-2">Export to Excel</a>
                    <a href="{{ route('books.export.pdf', $user ? $user->id : Auth::id()) }}" class="btn btn-danger">Export
                        to PDF</a>
                </di>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Quantity</th>
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
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
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
                    <form method="GET" action="{{ route('books.index') }}" class="form-inline w-auto">
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
            </div>
        </div>
    </div>
@endsection
