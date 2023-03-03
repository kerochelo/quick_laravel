<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Tag;

use Carbon\Carbon;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tags = Tag::whereNull('deleted_at')->latest()->paginate(20);

        return view('admin.tags.index', [
            'tags' => $tags
        ]);
    }

    public function store(Request $request)
    {
        $this->storeValidation($request);

        Tag::create($request->all());

        session()->flash('flash_message', '登録しました。');
        return redirect()->route('admin.tags.index');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', [
            'tag' => $tag
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $this->updateValidation($request, $tag);

        $tag->update($request->all());

        session()->flash('flash_message', '更新しました。');
        return redirect()->route('admin.tags.index');
    }

    public function destroy(Request $request, Tag $tag)
    {
        $tag->delete();

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.tags.index');
    }

    private function storeValidation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:512|unique:tags,name',
            'slug' => 'required|string|max:512|unique:tags,slug',
        ],
        [
            'name.required' => 'タグ名は必須です。',
            'name.unique'   => 'タグ名はすでに登録されています。',
            'slug.required' => 'スラッグは必須です。',
            'slug.unique'   => 'スラッグはすでに登録されています。',
        ]);
    }

    private function updateValidation(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:512|unique:tags,name,' . $tag->id,
            'slug' => 'required|string|max:512|unique:tags,slug,' . $tag->id,
        ],
        [
            'name.required' => 'タグ名は必須です。',
            'name.unique'   => 'タグ名はすでに登録されています。',
            'slug.required' => 'スラッグは必須です。',
            'slug.unique'   => 'スラッグはすでに登録されています。',
        ]);
    }
}
