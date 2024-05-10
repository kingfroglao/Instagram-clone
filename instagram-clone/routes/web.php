<?php
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Home');
// });

// Route::get('/user', function () {
//     return Inertia::render('User');
// });

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'update'])->name('users.update');


    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/update', [PostController::class, 'update'])->name('posts.update');


    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes/{id}', [LikeController::class, 'destroy'])->name('likes.destroy');

    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::post('/searc/users', [SearchController::class, 'users'])->name('search.users');

    Route::post('/user/follow/{id}', [FollowController::class, 'followUser'])->name('users.follow');
    Route::delete('/user/unfollow/{id}', [FollowController::class, 'unfollowUser'])->name('users.unfollow');

    Route::post('/user/follow/{id}', [FollowController::class, 'followUser'])->name('user.follow');
    Route::delete('/user/unfollow/{id}', [FollowController::class, 'unfollowUser'])->name('user.unfollow');

});


require __DIR__.'/auth.php';