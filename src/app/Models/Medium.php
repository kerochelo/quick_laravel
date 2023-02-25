<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_type',
        'name'
    ];

    public function articles()
    {
        return $this->morphToMany(Article::class, 'article_block');
    }
}
