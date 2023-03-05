<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Author;

use Carbon\Carbon;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $authors = Author::whereNull('deleted_at')->latest()->paginate(20);

        return view('admin.authors.index', [
            'authors' => $authors
        ]);
    }

    public function store(Request $request)
    {
        $this->storeValidation($request);

        Author::create($request->all());

        session()->flash('flash_message', '登録しました。');
        return redirect()->route('admin.authors.index');
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', [
            'author' => $author
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $this->updateValidation($request, $author);

        $requestArray = $request->all();
        if (array_key_exists('avatar', $requestArray) && $requestArray['avatar']) {
            $image_path = $request->file('avatar')->store('public/avatar/');
            $requestArray['avatar'] = basename($image_path);
        }

        $author->update($requestArray);

        session()->flash('flash_message', '更新しました。');
        return redirect()->route('admin.authors.index');
    }

    public function destroy(Request $request, Author $author)
    {
        // INFO : logical deletion
        // $carbon = new Carbon();
        // $author->update(['deleted_at' => $carbon]);

        $author->delete();

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.authors.index');
    }

    private function storeValidation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:512|unique:authors,name',
            'slug' => 'required|string|max:512|unique:authors,slug'
        ],
        [
            'name.required' => '著者名は必須です。',
            'name.unique'   => '著者名はすでに登録されています。',
            'slug.required' => 'スラッグは必須です。',
            'slug.unique'   => 'スラッグはすでに登録されています',
        ]);
    }

    private function updateValidation(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:512|unique:authors,name,' . $author->id,
            'slug' => 'required|string|max:512|unique:authors,slug,' . $author->id,
        ],
        [
            'name.required' => '著者名は必須です。',
            'name.unique'   => '著者名はすでに登録されています。',
            'slug.required' => 'スラッグは必須です。',
            'slug.unique'   => 'スラッグはすでに登録されています',
        ]);
    }
}
