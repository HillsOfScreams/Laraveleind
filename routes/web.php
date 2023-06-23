<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\UserController;

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


Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->middleware(['auth'])->name('users.index');
Route::get('/friendrequest', [App\Http\Controllers\UserController::class, 'friendrequest'])->middleware(['auth'])->name('friendrequest.index');
Route::post('/friend-requests/{friendRequest}/accept', [App\Http\Controllers\UserController::class, 'acceptFriendRequest'])->middleware(['auth'])->name('acceptFriendRequest');
Route::post('/friend-requests/{friendRequest}/deny', [App\Http\Controllers\UserController::class, 'denyFriendRequest'])->middleware(['auth'])->name('denyFriendRequest');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/add-friend', [App\Http\Controllers\UserController::class, 'addFriend'])->middleware(['auth'])->name('addFriend');
    Route::get('/', [App\Http\Controllers\UserController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
});

require __DIR__ . '/auth.php';
