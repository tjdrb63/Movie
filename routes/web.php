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
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/main',[PostController::class,'ShowMain'])->name('showmain');
Route::get('/search',[PostController::class,'ShowSearch'])->name('showsearch');
Route::get('/search/{searchword}',[PostController::class,'SearchNow']);
Route::get('/search/api/{searchword}',[ApiController::class,'NaverApiCall']);
Route::get('/room/{room_id}',[PostController::class,'ShowRoom']);


Route::post('/post/comment/{room_id}',[PostController::class,'PostComment']);
Route::post('/show/room/{movie_title}',[PostController::class,'PostShowRoom']);
Route::post('/make/room',[PostController::class,'MakeRoom']);
Route::post('/room/info/{room_id}',[PostController::class,'RoomInfo']);
Route::post('/search/api/room',[ApiController::class,'CheckRoom']);
Route::post('/main/show/movie',[PostController::class,'MainShowMovie']);
