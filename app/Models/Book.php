<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'description',
        'quantity',
        'file_path',
        'cover_image_path',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

