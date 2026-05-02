<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::resource('jenis-sampah', App\Http\Controllers\JenisSampahController::class);
    Route::get('/setoran', [App\Http\Controllers\SetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/create', [App\Http\Controllers\SetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [App\Http\Controllers\SetoranController::class, 'store'])->name('setoran.store');
    Route::get('/admin/setoran', [App\Http\Controllers\SetoranController::class, 'adminIndex'])->name('admin.setoran.index');
});

require __DIR__ . '/auth.php';
