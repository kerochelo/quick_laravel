<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embed extends Model
{
    use HasFactory;

    protected $fillable = [
        'embed_type',
        'identifier'
    ];

    public function articles()
    {
        return $this->morphToMany(Article::class, 'article_block');
    }
}
