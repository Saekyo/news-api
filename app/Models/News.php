<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'content',
        'url',
        'url_image',
        'published_at',
        'author_id',
        'category_id',
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
