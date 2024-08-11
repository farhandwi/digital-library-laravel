<?php

namespace App\Exports;

use App\Models\Book;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        return Book::with('category')
                    ->where('user_id', $this->user->id)
                    ->get()
                    ->map(function ($book) {
                        return [
                            'Title' => $book->title,
                            'Category' => $book->category ? $book->category->name : 'No Category',
                            'Description' => $book->description,
                            'Quantity' => $book->quantity,
                        ];
                    });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Category',
            'Description',
            'Quantity',
        ];
    }
}

