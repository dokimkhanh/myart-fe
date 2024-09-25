<?php

use App\Http\Controllers\Admin\ArtController as AdminArtController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\ArtController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/art/{art}', [ArtController::class, 'show'])->name('art.show');
Route::get('/art/{art}/edit', [ArtController::class, 'edit'])->name('art.edit')->middleware('auth.token');
Route::put('/art/{art}', [ArtController::class, 'update'])->name('art.update')->middleware('auth.token');

Route::post('/art', [ArtController::class, 'store'])->name('art.store')->middleware('auth.token');
Route::delete('/art/{art}', [ArtController::class, 'destroy'])->name('art.destroy')->middleware('auth.token');
Route::delete('/art/{art}/comment/{comment}', [CommentController::class, 'destroy'])->name('art.comment.destroy')->middleware('auth.token');

Route::post('art/{art}/like', [LikeController::class, 'like'])->name('art.like');
Route::post('art/{art}/unlike', [LikeController::class, 'unlike'])->name('art.unlike');

Route::post('/art/{art}/comment', [CommentController::class, 'store'])->name('art.comment.store');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'store'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('profile', [UserController::class, 'profile'])->name('profile');

Route::resource('user', UserController::class)->only(['edit', 'update'])->middleware('auth.token');
Route::resource('user', UserController::class)->only(['show']);

Route::post('user/{id}/follow', [FollowerController::class, 'follow'])->name('user.follow')->middleware('auth.token');
Route::post('user/{id}/unfollow', [FollowerController::class, 'unfollow'])->name('user.unfollow')->middleware('auth.token');



Route::get('feed', FeedController::class)->name('feed')->middleware('auth.token');

Route::get('lang/{lang}', function ($lang) {
    app()->setLocale($lang);
    session()->put('locale', $lang);
    return redirect()->back();
})->name('lang');


#ADMIN
Route::middleware(['auth.admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class)->only(['index']);
    Route::resource('arts', AdminArtController::class)->only(['index']);
    Route::resource('comments', AdminCommentController::class)->only(['index', 'destroy']);
});
