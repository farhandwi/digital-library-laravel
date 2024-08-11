<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users(Request $request)
    {
        $search = $request->get('search', '');

        $users = User::where('name', 'like', '%' . $search . '%')->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function userBooks(Request $request, User $user)
    {
        $perPage = $request->get('per_page', 5);
        $query = Book::query();
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }
        if ($user) {
            $query->where('user_id', $user->id)->get();
        } else {
            $query->where('user_id', Auth::id());
        }

        $books = $query->paginate($perPage);

        return view('admin.users.books', compact('books', 'perPage', 'user'));
    }

    public function editBook(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10000'
        ]);

        $book->title = $request->title;
        $book->category_id = $request->category_id;
        $book->description = $request->description;
        $book->quantity = $request->quantity;

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image_path) {
                Storage::delete($book->cover_image_path);
            }
            $book->cover_image_path = $request->file('cover_image')->store('public/covers');
        }

        if ($request->hasFile('pdf_file')) {
            if ($book->file_path) {
                Storage::delete($book->file_path);
            }
            $book->file_path = $request->file('pdf_file')->store('public/books');
        }

        $book->save();

        return redirect()->route('admin.users.books', $book->user_id)->with('success', 'Book updated successfully.');
    }

    public function deleteBook(Book $book)
    {
        if ($book->cover_image_path) {
            Storage::delete($book->cover_image_path);
        }

        if ($book->file_path) {
            Storage::delete($book->file_path);
        }

        $book->delete();

        return redirect()->route('admin.users.books', $book->user_id)->with('success', 'Book deleted successfully.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }
}
