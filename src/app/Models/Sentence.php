<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
    ];

    public function articles()
    {
        return $this->morphToMany(Article::class, 'article_block');
    }
}
