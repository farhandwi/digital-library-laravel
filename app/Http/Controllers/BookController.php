<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class BookController extends Controller
{
    public function index(Request $request, User $user = null)
    {
        $perPage = $request->get('per_page', 5);
        $query = Book::query();

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        if ($user) {
            $query->where('user_id', $user->id);
        } else {
            $query->where('user_id', Auth::id());
        }

        $books = $query->paginate($perPage);

        return view('books.index', compact('books', 'perPage', 'user'));
    } 


    public function show(Book $book)
    {
        $this->authorize('view', $book);
        return view('books.show', compact('book'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'file' => 'required|mimes:pdf|max:10240',
            'cover_image' => 'required|mimes:jpeg,jpg,png|max:2048',
        ]);

        $filePath = $request->file('file')->store('public/books');
        $coverImagePath = $request->file('cover_image')->store('public/covers');

        $book = new Book();
        $book->title = $request->title;
        $book->category_id = $request->category_id;
        $book->description = $request->description;
        $book->quantity = $request->quantity;
        $book->file_path = $filePath;
        $book->cover_image_path = $coverImagePath;
        $book->user_id = Auth::id();
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book created successfully');
    }

    public function edit(Book $book)
    {
        $this->authorize('update', $book);

        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'file' => 'nullable|mimes:pdf|max:10240', // max 10MB
            'cover_image' => 'nullable|mimes:jpeg,jpg,png|max:2048', // max 2MB
        ]);

        if ($request->hasFile('file')) {
            // Hapus file PDF lama jika ada file baru
            if ($book->file_path) {
                Storage::delete($book->file_path);
            }
            $filePath = $request->file('file')->store('public/books');
            $book->file_path = $filePath;
        }

        if ($request->hasFile('cover_image')) {
            // Hapus gambar cover lama jika ada file baru
            if ($book->cover_image_path) {
                Storage::delete($book->cover_image_path);
            }
            $coverImagePath = $request->file('cover_image')->store('public/covers');
            $book->cover_image_path = $coverImagePath;
        }

        $book->title = $request->title;
        $book->category_id = $request->category_id;
        $book->description = $request->description;
        $book->quantity = $request->quantity;
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        // Hapus file PDF dan gambar cover jika ada
        if ($book->file_path) {
            Storage::delete($book->file_path);
        }
        if ($book->cover_image_path) {
            Storage::delete($book->cover_image_path);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }

    public function exportExcel(User $user)
    {
        return Excel::download(new BooksExport($user), 'books_' . $user->name . '.xlsx');
    }


    public function exportPDF(User $user)
    {
        $books = Book::with('category')
                    ->where('user_id', $user->id)
                    ->get();

        $pdf = PDF::loadView('books.pdf', compact('books'));
        return $pdf->download('books_' . $user->name . '.pdf');
    }

}
