<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Site;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $site = Site::first();
        return view('admin.sites.index', [
            'site' => $site
        ]);
    }

    public function update(Request $request, Site $site)
    {
        $this->doValidation($request);
        $requestArray = $request->all();

        if (array_key_exists('favicon', $requestArray) && $requestArray['favicon']) {
            $request->validate(
                [ 'favicon' => 'dimensions:width=32,height=32|mimes:png', ],
                [ 'favicon.dimensions' => 'favicon の画像サイズが不正です。',
                  'favicon.mimes' => 'favicon のファイル種別が不正です。', ]
            );

            $image_path = $request->file('favicon')->store('public/favicon');
            $requestArray['favicon'] = basename($image_path);
        }

        if (array_key_exists('og_image', $requestArray) && $requestArray['og_image']) {
            $request->validate(
                [ 'og_image' => 'dimensions:width=1200,height=630|mimes:jpeg,png,jpg', ],
                [ 'og_image.dimensions' => 'og:image の画像サイズが不正です。', ]
            );

            $image_path = $request->file('og_image')->store('public/og_image/');
            $requestArray['og_image'] = basename($image_path);
        }

        if (array_key_exists('main_image', $requestArray) && $requestArray['main_image']) {
            $request->validate(
                [ 'main_image' => 'dimensions:width=1200,height=400|mimes:jpeg,png,jpg', ],
                [ 'main_image.dimensions' => 'Main image の画像サイズが不正です。', ]
            );

            $image_path = $request->file('main_image')->store('public/main_image/');
            $requestArray['main_image'] = basename($image_path);
        }

        $site->update($requestArray);

        session()->flash('flash_message', '更新しました。');
        return redirect()->route('admin.sites.index');
    }

    public function destroy_favicon(Request $request, Site $site)
    {
        Storage::delete('public/favicon/' . $site->favicon);
        $site->update(['favicon' => null]);

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.sites.index');
    }

    public function destroy_og_image(Request $request, Site $site)
    {
        Storage::delete('public/og_image/' . $site->og_image);
        $site->update(['og_image' => null]);

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.sites.index');
    }

    public function destroy_main_image(Request $request, Site $site)
    {
        Storage::delete('public/main_image/' . $site->main_image);
        $site->update(['main_image' => null]);

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.sites.index');
    }

    private function doValidation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:512',
        ],
        [
            'name.required' => 'サイト名は必須です。',
        ]);
    }
}
