<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Category;

use Carbon\Carbon;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::whereNull('deleted_at')->latest()->paginate(20);

        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $this->storeValidation($request);

        Category::create($request->all());

        session()->flash('flash_message', '登録しました。');
        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $this->updateValidation($request, $category);

        $category->update($request->all());

        session()->flash('flash_message', '更新しました。');
        return redirect()->route('admin.categories.index');
    }

    public function destroy(Request $request, Category $category)
    {
        // INFO : logical deletion
        // $carbon = new Carbon();
        // $category->update(['deleted_at' => $carbon]);

        $category->delete();

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.categories.index');
    }

    private function storeValidation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:512|unique:categories,name',
            'slug' => 'required|string|max:512|unique:categories,slug',
        ],
        [
            'name.required' => 'カテゴリー名は必須です。',
            'name.unique'   => 'カテゴリー名はすでに登録されています。',
            'slug.required' => 'スラッグは必須です。',
            'slug.unique'   => 'スラッグはすでに登録されています。',
        ]);
    }

    private function updateValidation(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:512|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:512|unique:categories,slug,' . $category->id,
        ],
        [
            'name.required' => 'カテゴリー名は必須です。',
            'name.unique'   => 'カテゴリー名はすでに登録されています。',
            'slug.required' => 'スラッグは必須です。',
            'slug.unique'   => 'スラッグはすでに登録されています。',
        ]);
    }
}
