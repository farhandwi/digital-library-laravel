<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Digital Library</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary ">
        <div class="px-10" style="padding-left: 20px">
            <a class="navbar-brand text-white text-weight-bold"
                href="{{ auth()->user()->role == 'admin' ? route('admin.index') : route('books.index') }}">Digital
                Library</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end mx-5 " id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @auth
                    @if (auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link text-white text-weight-bold" href="{{ route('admin.users') }}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-weight-bold"
                                href="{{ route('categories.index') }}">Categories</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white text-weight-bold" href="{{ route('books.index') }}">Books</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-white text-weight-bold" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
