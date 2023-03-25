<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontEndController;

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




Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('adminHome');

    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
    Route::resource('likes', LikeController::class);
    Route::resource('comments', CommentController::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('change-password', [AuthController::class, 'change_password'])->name('admin.change-password');
    Route::post('post-change-password', [AuthController::class, 'post_change_password'])->name('admin.post-change-password');
});


Route::middleware('guest:admin')->prefix('admin')->group(function () {

    Route::get('adminLogin', [AuthController::class, 'adminLogin'])->name('adminLogin');
    Route::post('adminPostLogin', [AuthController::class, 'adminPostLogin'])->name('adminPostLogin');
});

// ------------------------------------------------------------- frontEnd ------------------------------


Route::prefix('user')->middleware('auth:web')->group(function () {
    Route::get('/', function () {
        $posts=Post::all();
        return view('frontEnd.home',compact('posts'));
    })->name('userHome');

    Route::get('userlogout', [AuthController::class, 'userlogout'])->name('user.logout');
    Route::get('addpost', [FrontEndController::class, 'addPost'])->name('addPost');
    Route::get('home', [FrontEndController::class, 'home'])->name('home');
    Route::delete('delete/{post}', [FrontEndController::class, 'deletePost'])->name('deletePost');
    Route::post('post/', [FrontEndController::class, 'storePost'])->name('storePost');
    Route::put('update/{id}', [FrontEndController::class, 'updatePost'])->name('updatePost');
    Route::get('edit/{id}', [FrontEndController::class, 'editPost'])->name('editPost');

    Route::post('comment/', [FrontEndController::class, 'storeComment'])->name('storeComment');



});


Route::middleware('guest:web')->prefix('user')->group(function () {

    Route::get('userLogin', [AuthController::class, 'userLogin'])->name('userLogin');
    Route::post('userPostLogin', [AuthController::class, 'userPostLogin'])->name('userPostLogin');



});
