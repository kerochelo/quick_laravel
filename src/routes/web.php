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

Route::get('/blogs',                               [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{article}',                     [BlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs/category/{category}',           [BlogController::class, 'category'])->name('blogs.category.index');

Route::get('/admin/articles',                      [ArticleController::class, 'index'])->name('admin.articles.index');
Route::get('/admin/articles/create',               [ArticleController::class, 'create'])->name('admin.articles.create');
Route::get('/admin/articles/{article}',            [ArticleController::class, 'edit'])->name('admin.articles.edit');
Route::post('/admin/articles/search',              [ArticleController::class, 'search'])->name('admin.articles.search');
Route::post('/admin/articles/store',               [ArticleController::class, 'store'])->name('admin.articles.store');
Route::post('/admin/articles/update/{article}',    [ArticleController::class, 'update'])->name('admin.articles.update');
Route::get('/admin/articles/publish/{article}',    [ArticleController::class, 'publish'])->name('admin.articles.publish');
Route::get('/admin/articles/delete/{article}',     [ArticleController::class, 'destroy'])->name('admin.articles.delete');

Route::get('/admin/categories',                    [CategoryController::class, 'index'])->name('admin.categories.index');
Route::post('/admin/categories/create',            [CategoryController::class, 'store'])->name('admin.categories.create');
Route::post('/admin/categories/update/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::get('/admin/categories/{category}',         [CategoryController::class, 'edit'])->name('admin.categories.edit');
Route::get('/admin/categories/delete/{category}',  [CategoryController::class, 'destroy'])->name('admin.categories.delete');

Route::get('/admin/tags',                          [TagController::class, 'index'])->name('admin.tags.index');
Route::post('/admin/tags/create',                  [TagController::class, 'store'])->name('admin.tags.create');
Route::post('/admin/tags/update/{tag}',            [TagController::class, 'update'])->name('admin.tags.update');
Route::get('/admin/tags/{tag}',                    [TagController::class, 'edit'])->name('admin.tags.edit');
Route::get('/admin/tags/delete/{tag}',             [TagController::class, 'destroy'])->name('admin.tags.delete');

Route::get('/admin/authors',                       [AuthorController::class, 'index'])->name('admin.authors.index');
Route::post('/admin/authors/create',               [AuthorController::class, 'store'])->name('admin.authors.create');
Route::post('/admin/authors/update/{author}',      [AuthorController::class, 'update'])->name('admin.authors.update');
Route::get('/admin/authors/{author}',              [AuthorController::class, 'edit'])->name('admin.authors.edit');
Route::get('/admin/authors/delete/{author}',       [AuthorController::class, 'destroy'])->name('admin.authors.delete');

Route::get('/admin/users',                         [UserController::class, 'index'])->name('admin.users.index');
Route::post('/admin/users/create',                 [UserController::class, 'store'])->name('admin.users.create');
Route::post('/admin/users/update/{user}',          [UserController::class, 'update'])->name('admin.users.update');
Route::get('/admin/users/{user}',                  [UserController::class, 'edit'])->name('admin.users.edit');
Route::get('/admin/users/delete/{user}',           [UserController::class, 'destroy'])->name('admin.users.delete');

Route::get('/admin/sites',                         [SiteController::class, 'index'])->name('admin.sites.index');
Route::post('/admin/sites/update/{site}',          [SiteController::class, 'update'])->name('admin.sites.update');
Route::get('/admin/sites/del_favicon/{site}',      [SiteController::class, 'destroy_favicon'])->name('admin.sites.del_favicon');
Route::get('/admin/sites/del_og_image/{site}',     [SiteController::class, 'destroy_og_image'])->name('admin.sites.del_og_image');
Route::get('/admin/sites/del_main_image/{site}',   [SiteController::class, 'destroy_main_image'])->name('admin.sites.del_main_image');
