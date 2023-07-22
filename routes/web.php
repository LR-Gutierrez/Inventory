<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemCategoryController;
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

Route::get('/', [AuthController::class, 'login_index'])->name('login.index');
Route::post('/', [AuthController::class, 'login_store'])->name('login.store');
Route::get('/reset_password', [AuthController::class, 'reset_index'])->name('reset.index');

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/create', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::prefix('item-categories')->group(function() {
        Route::get('/', [ItemCategoryController::class, 'index'])->name('item-categories.index');
        Route::get('/create', [ItemCategoryController::class, 'create'])->name('item-categories.create');
        Route::post('/create', [ItemCategoryController::class, 'store'])->name('item-categories.store');
        Route::get('/{id}', [ItemCategoryController::class, 'edit'])->name('item-categories.edit');
        Route::put('/{id}', [ItemCategoryController::class, 'update'])->name('item-categories.update');
        Route::delete('/{id}', [ItemCategoryController::class, 'destroy'])->name('item-categories.destroy');
    });
});
