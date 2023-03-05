<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'deleted_at'
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
