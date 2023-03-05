<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'eyecatch',
        'eyecatch_align',
        'eyecatch_width',
        'description',
        'body',
        'category_id',
        'author_id',
        'state',
        'published_at',
        'deleted_at'
    ];

    protected $dates = [
        'published_at'
    ];

    public function getRouteKeyName()
    {
        $route_name = Request::route()->getName();
        if (str_starts_with($route_name, 'admin')) {
            return 'id';
        }
        return 'slug';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    public function sentences()
    {
        return $this->morphedByMany(Sentence::class, 'article_block');
    }

    public function embeds()
    {
        return $this->morphedByMany(Embed::class, 'article_block');
    }

    public function media()
    {
        return $this->morphedByMany(Medium::class, 'article_block');
    }
}
