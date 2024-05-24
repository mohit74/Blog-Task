<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('blogs.index'));
    }
    return redirect(route('signIn'));
})->name('adminLoginPage');

Route::get('/', [AuthController::class, 'signIn'])->name('signIn');
Route::get('/register', [AuthController::class, 'signUp'])->name('signUp');
Route::post('/sign-up', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    
    Route::resource('/blogs', BlogController::class);
    Route::post('blogs/{id}/like', [BlogController::class, 'like'])->name('like');
    Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
