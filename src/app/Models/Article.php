<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
