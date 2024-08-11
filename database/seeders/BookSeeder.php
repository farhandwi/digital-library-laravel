<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class BookSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $user = User::first();

        if ($categories->isEmpty() || !$user) {
            $this->command->info('Please seed categories and users first.');
            return;
        }

        foreach ($categories as $category) {
            Book::create([
                'title' => 'Sample Book ' . $category->id,
                'category_id' => $category->id,
                'description' => 'Sample Description for Book ' . $category->id,
                'quantity' => rand(1, 10),
                'file_path' => 'books/sample.pdf',
                'cover_image_path' => 'covers/sample.jpg',
                'user_id' => $user->id,
            ]);
        }
    }
}
