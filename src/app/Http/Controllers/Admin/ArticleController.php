<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use App\models\Article;
use App\models\ArticleTag;
use App\models\Author;
use App\models\Category;
use App\models\Tag;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $articles = Article::all();
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();

        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'authors' => $authors,
            'tags' => $tags,
        ]);
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $this->storeValidation($request);
        $requestArray = $request->all();
        $requestArray = $this->makeSlugUrl($requestArray);

        $article = Article::create($requestArray);

        session()->flash('flash_message', '登録しました。');
        return redirect()->route('admin.articles.index', ['article' => $article]);
    }

    public function show(Article $article)
    {
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();

        $choosedTags = [];
        $articleTags = $article->tags;
        foreach ($articleTags as $articleTag) {
            $choosedTags[] = $articleTag->tag_id;
        }

        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => $categories,
            'authors' => $authors,
            'tags' => $tags,
            'choosedTags' => $choosedTags,
        ]);
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();

        $choosedTags = [];
        $articleTags = $article->tags;
        foreach ($articleTags as $articleTag) {
            $choosedTags[] = $articleTag->tag_id;
        }

        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => $categories,
            'authors' => $authors,
            'tags' => $tags,
            'choosedTags' => $choosedTags,
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $this->updateValidation($request, $article);
        $requestArray = $request->all();
        $requestArray = $this->makeSlugUrl($requestArray);

        if (array_key_exists('eyecache', $requestArray) && $requestArray['eyecache']) {
            $image_path = $request->file('eyecache')->store('public/eyecache/');
            $requestArray['eyecache'] = basename($image_path);
        }

        $article->tags()->delete();
        if (array_key_exists('tag_ids', $requestArray) && $requestArray['tag_ids']) {
            foreach ($requestArray['tag_ids'] as $tag_id) {
                $article->tags()->create([
                    'tag_id' => $tag_id,
                ]);
            }
        }

        $requestArray = $this->makeRequestWithoutBodyx($article, $requestArray);

        $article->update($requestArray);

        session()->flash('flash_message', '更新しました。');
        return redirect()->route('admin.articles.index');
    }

    public function destroy(Request $request, Article $article)
    {
        $article->delete();

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.articles.index');
    }

    public function publish(Request $request, Article $article)
    {
        $carbon = new Carbon();
        $article->update([
            'state' => 1,
            'published_at' => $carbon,
        ]);

        session()->flash('flash_message', '公開しました。');
        return redirect()->route('admin.articles.index');
    }

    public function search(Request $request)
    {
        $articles = $this->makeSearchCondition($request->all());
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();

        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'authors' => $authors,
            'tags' => $tags,
        ]);
    }

    private function storeValidation(Request $request)
    {
        $requestArray = $request->all();
        $request->validate([
            'title' => 'required|string|max:512|unique:articles,title',
        ],
        [
            'title.required' => 'タイトルは必須です。',
            'title.unique'   => 'タイトルはすでに登録されています。',
        ]);

        if (array_key_exists('slug', $requestArray) && $requestArray['slug']) {
            $request->validate([
                'slug'  => 'string|max:512|unique:articles,slug',
            ],
            [
                'slug.unique'    => 'スラッグはすでに登録されています',
            ]);
        }
    }

    private function updateValidation(Request $request, Article $article)
    {
        $requestArray = $request->all();
        $request->validate([
            'title' => 'required|string|max:512|unique:articles,title,' . $article->id,
        ],
        [
            'title.required' => 'タイトルは必須です。',
            'title.unique'   => 'タイトルはすでに登録されています。',
        ]);

        if (array_key_exists('slug', $requestArray) && $requestArray['slug']) {
            $request->validate([
                'slug'  => 'string|max:512|unique:articles,slug,' . $article->id,
            ],
            [
                'slug.unique'    => 'スラッグはすでに登録されています',
            ]);
        }

    }

    private function makeSearchCondition($request)
    {
        $whereArray = [];
        if (array_key_exists('category_id', $request) && $request['category_id']) {
            $whereArray[] = [ 'category_id', '=', $request['category_id'] ];
        }

        if (array_key_exists('author_id', $request) && $request['author_id']) {
            $whereArray[] = [ 'author_id', '=', $request['author_id'] ];
        }

        if (array_key_exists('body', $request) && $request['body']) {
            $escapedKeyword = '%' . addcslashes($request['body'], '%_\\') . '%';
            $whereArray[] = [ 'body', 'like', $escapedKeyword ];
        }

        if (array_key_exists('title', $request) && $request['title']) {
            $escapedKeyword = '%' . addcslashes($request['title'], '%_\\') . '%';
            $whereArray[] = [ 'title', 'like', $escapedKeyword ];
        }

        $results = Article::with('tags')->where($whereArray);

        if (array_key_exists('tag_id', $request) && $request['tag_id']) {
            $articles = ArticleTag::where('tag_id', '=' , $request['tag_id'])->pluck('article_id')->toArray();
            $results = $results->whereIn('id', $articles);
        }

        return $results->get();
    }

    private function makeSlugUrl($params)
    {
        if ($params['slug']) {
            $params['slug'] = str_slug($params['slug']);
        }
        return $params;
    }

    private function makeRequestWithoutBodyx($article, $requestArray)
    {
        $bodies = [];
        foreach ($requestArray as $key => $value) {
            if (str_starts_with($key, 'body')) {
                $bodies[$key] =  $value;
                unset($requestArray[$key]);
            }
        }

        $article->bodies()->delete();
        if ($bodies) {
            ksort($bodies);
            foreach ($bodies as $body) {
                $article->bodies()->create([
                    'body' => $body,
                ]);
            }
        }
        return $requestArray;
    }
}
