<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', function() {
    return redirect('/blogs');
});

Route::get('/admin', function() {
    return redirect('/admin/articles');
});

Route::resource('blogs', BlogController::class)->only([
    'index', 'show', 'category'
]);

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::resource('articles', ArticleController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destory', 'search', 'publish'
    ]);
    Route::resource('categories', CategoryController::class)->only([
        'index', 'store', 'edit', 'update', 'destory'
    ]);
    Route::resource('tags', TagController::class)->only([
        'index', 'store', 'edit', 'update', 'destory'
    ]);
    Route::resource('authors', AuthorController::class)->only([
        'index', 'store', 'edit', 'update', 'destory'
    ]);
    Route::resource('users', UserController::class)->only([
        'index', 'store', 'edit', 'update', 'destory'
    ]);
    Route::resource('sites', SiteController::class)->only([
        'index', 'update', 'destory_favicon', 'destory_og_image', 'destory_main_image'
    ]);
});
