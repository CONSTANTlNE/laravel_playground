<?php

use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';

// separate methods for github and google
//Route::get('auth/github/redirect', [SocialiteController::class, 'githubredirect'])->name('github.login');
//Route::get('auth/github/callback', [SocialiteController::class, 'githubcallback']);
//Route::get('auth/google/redirect', [SocialiteController::class, 'googleredirect'])->name('google.login');
//Route::get('auth/google/callback', [SocialiteController::class, 'googlecallback']);

// one method for social login
Route::get('auth/{provider}/redirect/', [SocialiteController::class, 'redirect'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback']);
