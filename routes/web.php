<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('movie/mainpage');
})->name('dashboard');

Route::get('/main',[PostController::class,'ShowMain'])->name('showmain');
Route::get('/search',[PostController::class,'ShowSearch'])->name('showsearch');
Route::get('/search/{searchword}',[PostController::class,'SearchNow']);
Route::get('/search/api/{searchword}',[ApiController::class,'NaverApiCall']);
Route::get('/room/{room_id}',[PostController::class,'ShowRoom']);
Route::get('/delete/room/{comment_id}',[PostController::class,'ShowRoom']);
Route::post('/delete/comment/{room_id}',[PostController::class,'DeleteComment']);
Route::post('/edit/comment/{comment_id}',[PostController::class,'EditComment']);
Route::post('/check/comment/{movie_id}',[PostController::class,'CheckComment']);
Route::post('/comment/info/{room_id}',[PostController::class,'CommentInfo']);
Route::post('/post/comment/{room_id}',[PostController::class,'PostComment']);
Route::post('/api/call/text',[ApiController::class,'TextApiCall']);
Route::post('/show/comments',[PostController::class,'ShowComments']);
Route::post('/show/room/{movie_title}',[PostController::class,'PostShowRoom']);
Route::post('/make/room',[PostController::class,'MakeRoom']);
Route::post('/room/info/{room_id}',[PostController::class,'RoomInfo']);
Route::post('/search/api/room',[ApiController::class,'CheckRoom']);
Route::post('/main/show/movie',[PostController::class,'MainShowMovie']);
