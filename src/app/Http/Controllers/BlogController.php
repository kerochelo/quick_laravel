<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Category;
use App\Models\Site;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        $categories = Category::all();
        $site = Site::first();

        return view('blogs.index', [
            'site' => $site,
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    public function show(Article $article)
    {
        $site = Site::first();
        $category = Category::find($article->category_id);
        $new_articles = Article::all();
        $old_articles = Article::all();
        $categories = Category::all();

        return view('blogs.show', [
            'site'         => $site,
            'article'      => $article,
            'category'     => $category,
            'new_articles' => $new_articles,
            'old_articles' => $old_articles,
            'categories'   => $categories,
        ]);
    }

    public function category(Category $category)
    {
        $site = Site::first();
        $articles = Article::where('category_id', $category->id)->get();
        $new_articles = Article::all();
        $old_articles = Article::all();
        $categories = Category::all();

        return view('blogs.category.index', [
            'site'         => $site,
            'articles'     => $articles,
            'category'     => $category,
            'new_articles' => $new_articles,
            'old_articles' => $old_articles,
            'categories'   => $categories,
        ]);
    }
}
