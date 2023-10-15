<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.register');
});

Route::post('registration',[UserController::class, 'save'])->name('auth.save');
Route::get('logout',[UserController::class, 'logout'])->name('auth.logout');
Route::post('authenticate', [UserController::class, 'doLogin'])->name('auth.doLogin');

Route::group(['middleware'=>['authCheck']], function(){
    //new
    Route::get('login', [UserController::class, 'showLoginView'])->name('auth.login');
    Route::get('register',[UserController::class, 'showRegisterView'])->name('auth.register');
    Route::get('dashboard',[UserController::class, 'dashboard'])->name('dashboard');



    Route::get('users',[UserController::class,'index'])->name('users.index');
    Route::put('users/{id}', [UserController::class, 'update'])->name('update.user');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('blog-view/{id}', [BlogController::class, 'viewBlogs']);
    Route::get('blogs-view', [BlogController::class, 'show'])->name('blogs.show');
    Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::get('blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::get('blogs/{id}/links', [BlogController::class, 'showBlogLink'])->name('blogs.links-view');
    Route::delete('blogs/{id}', [BlogController::class, 'destroy'])
        ->name('blogs.destroy');
    Route::get('blogs/{id}/tags', [BlogController::class, 'showBlogTags'])->name('blogs.tags-view');

});


