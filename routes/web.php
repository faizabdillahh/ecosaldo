<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/notifications', function () {
    $notifications = auth()->user()->notifications()->paginate(10);
    return view('notifications.index', compact('notifications'));
})->middleware('auth')->name('notifications.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes untuk semua user login
Route::middleware(['auth'])->group(function () {
    Route::get('/setoran', [App\Http\Controllers\SetoranController::class, 'index'])->name('setoran.index');
    Route::get('/withdrawal', [App\Http\Controllers\WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::get('/withdrawal/create', [App\Http\Controllers\WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdrawal.store');
});

// Routes khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('jenis-sampah', App\Http\Controllers\JenisSampahController::class);
    Route::get('/setoran/create', [App\Http\Controllers\SetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [App\Http\Controllers\SetoranController::class, 'store'])->name('setoran.store');
    Route::get('/admin/setoran', [App\Http\Controllers\SetoranController::class, 'adminIndex'])->name('admin.setoran.index');
    Route::get('/admin/withdrawal', [App\Http\Controllers\WithdrawalController::class, 'adminIndex'])->name('admin.withdrawal.index');
    Route::post('/admin/withdrawal/{withdrawal}/verify', [App\Http\Controllers\WithdrawalController::class, 'verify'])->name('admin.withdrawal.verify');
});

require __DIR__ . '/auth.php';
