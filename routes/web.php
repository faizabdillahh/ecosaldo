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
    Route::get('/redemption/catalog', [App\Http\Controllers\RedemptionController::class, 'catalog'])->name('redemption.catalog');
    Route::post('/redemption', [App\Http\Controllers\RedemptionController::class, 'store'])->name('redemption.store');
    Route::get('/redemption', [App\Http\Controllers\RedemptionController::class, 'history'])->name('redemption.history');
});

// Routes khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('jenis-sampah', App\Http\Controllers\JenisSampahController::class);
    Route::get('/setoran/create', [App\Http\Controllers\SetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [App\Http\Controllers\SetoranController::class, 'store'])->name('setoran.store');
    Route::get('/admin/setoran', [App\Http\Controllers\SetoranController::class, 'adminIndex'])->name('admin.setoran.index');
    Route::get('/admin/withdrawal', [App\Http\Controllers\WithdrawalController::class, 'adminIndex'])->name('admin.withdrawal.index');
    Route::post('/admin/withdrawal/{withdrawal}/verify', [App\Http\Controllers\WithdrawalController::class, 'verify'])->name('admin.withdrawal.verify');
    Route::resource('reward', App\Http\Controllers\RewardController::class);
    Route::get('/admin/redemption', [App\Http\Controllers\RedemptionController::class, 'adminIndex'])->name('admin.redemption.index');
    Route::post('/admin/redemption/{redemption}/proses', [App\Http\Controllers\RedemptionController::class, 'proses'])->name('admin.redemption.proses');
    Route::post('/admin/redemption/{redemption}/selesaikan', [App\Http\Controllers\RedemptionController::class, 'selesaikan'])->name('admin.redemption.selesaikan');
    Route::post('/admin/redemption/{redemption}/tolak', [App\Http\Controllers\RedemptionController::class, 'tolak'])->name('admin.redemption.tolak');
    Route::get('/admin/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/export', [App\Http\Controllers\LaporanController::class, 'export'])->name('admin.laporan.export');
    Route::get('/admin/laporan/export-withdrawals', [App\Http\Controllers\LaporanController::class, 'exportWithdrawals'])->name('admin.laporan.export-withdrawals');
    Route::get('/admin/laporan/export-redemptions', [App\Http\Controllers\LaporanController::class, 'exportRedemptions'])->name('admin.laporan.export-redemptions');
});

require __DIR__ . '/auth.php';
