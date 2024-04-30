<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DetailUsersController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeDislikeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostSavedController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;

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
// File log
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);






Route::middleware(["is_blocked","spam"])->group(function() {
    Route::controller(IndexController::class)->group(function () {
        Route::get('/',  'index')->name('welcome');
        Route::get('/news/{post:slug}', 'detail')->name('news.detail');
    });
    // Comment
    Route::controller(CommentsController::class)->group(function() {

        Route::post('/', 'StoreComment')->name("comments");
        Route::delete("/news/comment/{id}", 'destroy')->name("delete.comment");
        Route::put("/news/comment/edit/{id}", 'update')->name("update.comment");
        Route::post("/news/comment/reply/{id}", 'StoreComment')->name("reply.comment");
    });

    // Like
    Route::prefix('/news/like')->group(function () {
        Route::get("/{id}", [LikeDislikeController::class, 'like'])->name("like");
        Route::get("/unlike/{id}", [LikeDislikeController::class, 'unlike'])->name("unlike");
    });

    // Post Saved Boomark
    Route::controller(PostSavedController::class)->group(function () {
        Route::get('/home/boomark/{post}', 'detail')->name('news.save');
        Route::post('/news/{post}', 'save')->name('news.store');
        Route::delete('/news/{post}', 'unsave')->name('news.destroy');
    })->middleware('auth')->name("bommark");
});





Auth::routes(['verify' => true]);

Route::middleware(['verified', 'auth', 'is_blocked', 'spam','xss','member'])->group(function(){
    // route home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users/details/{name}',DetailUsersController::class);

    // route untuk logout
    Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);

    // Route untuk menghapus dan menampilkan semua data user dengan yajrabox
    Route::prefix('user')->middleware('rolecek')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/list',  'list')->name('user.list');
            Route::get('/',  'index')->name('user.index');

            // Route untuk update dan melihat detail user
            Route::put('/detail/{id}',  'update')->name('user.update');
            Route::get('/detail/{id}',  'detail')->name('user.detail');

            // Route untuk delete user
            Route::delete('/delete/{user}', 'destroy')->name('destroy');

            // Route untuk membuat user
            Route::get('/create','create')->name("user.create");
            Route::post('/create','store')->name('user.store');
        });
    })->name('user');

    // Route untuk tag
    Route::prefix('tag')->group(function (){
        Route::controller(TagsController::class)->group(function () {
            // Route untuk return view
            Route::get('/','index')->name('tag.TagView');
            // Route view list
            Route::get('/list','listTag')->name('tag.listTag');
            // Route untuk menyimpan tag
            Route::get('/view','viewTagCreate')->name('tag.TagCreate');
            Route::post('/','StoreTag')->name('tag.StoreTag');
            // Route untuk menghapus tag
            Route::delete('/destroy/{id}','destroy')->name('tag.destroyTag');
            // Route untuk mengedit tag dan view edit tag
            Route::get('/edit/{id}','viewTagEdit')->name('tag.viewTagEdit');
            Route::put('/edit/{id}','update')->name('tag.EditTag');
        });
    })->name('tag');

    // Route untuk category

    Route::prefix('categories')->group(function (){
        Route::controller(CategoriesController::class)->group(function () {
            // Route untuk return view
            Route::get('/','index')->name('categories.categoriesView');
            // Route view list
            Route::get('/list','listCategories')->name('categories.categoriesList');
            // Route untuk menyimpan categories
            Route::get('/view','viewcategoriesCreate')->name('categories.categoriesCreate');
            Route::post('/','StoreCategories')->name('categories.Storecategories');
            // Route untuk menghapus categories
            Route::delete('/destroy/{id}','destroy')->name('categories.destroycategories');
            // Route untuk mengedit categories dan view edit categories
            Route::get('/edit/{id}','viewcategoriesEdit')->name('categories.viewcategoriesEdit');
            Route::put('/edit/{id}','update')->name('categories.Editcategories');
        });
    })->name('categories');

    Route::prefix('posts')->group(function (){
        Route::controller(PostController::class)->group(function () {
            // Route untuk return view
            Route::get('/','index')->name('posts.index');
            // Route view list
            Route::get('/list','show')->name('posts.list');
            // Route untuk menyimpan categories
            Route::get('/view','create')->name('posts.create');
            Route::post('/','store')->name('posts.store');
            // Route untuk menghapus categories
            Route::delete('/destroy/{id}','destroy')->name('posts.destroy');
            // Route untuk mengedit categories dan view edit categories
            Route::get('/edit/{id}','edit')->name('posts.edit');
            Route::put('/edit/{id}','update')->name('posts.update');
        });
    })->name('posts');

    Route::prefix('my-profile')->group(function() {
        Route::get('/', [MyProfileController::class, 'index'])->name('my.profile.index');
        Route::put('/', [MyProfileController::class, 'update'])->name('my.profile.update');
    });




});
