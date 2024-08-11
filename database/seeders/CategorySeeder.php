<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Buat banyak kategori
        Category::factory(10)->create(); // Anda bisa mengubah jumlah sesuai kebutuhan
    }
}
