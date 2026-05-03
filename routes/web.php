<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\WithdrawalController;
use App\Models\Reward;
use App\Models\Setoran;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

// Rate Limiting
RateLimiter::for('login', fn($request) => Limit::perMinute(5)->by($request->ip()));
RateLimiter::for('register', fn($request) => Limit::perMinute(3)->by($request->ip()));
RateLimiter::for('withdrawal', fn($request) => Limit::perMinute(2)->by(auth()->id()));

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', function () {
    $isAdmin = auth()->user()->hasRole('admin');

    $data = [
        'totalNasabah' => User::role('nasabah')->count(),
        'totalSetoran' => Setoran::count(),
        'pendingWithdrawal' => Withdrawal::where('status', 'pending')->count(),
        'totalReward' => Reward::where('stok', '>', 0)->count(),
        'setoranBulanan' => Setoran::selectRaw('MONTH(tanggal_setor) as bulan, SUM(total_saldo) as total')
            ->whereYear('tanggal_setor', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan'),
        'rewardPopuler' => Reward::withCount('redemptions')
            ->orderByDesc('redemptions_count')
            ->take(5)
            ->get(),
        'aktivitasTerbaru' => Setoran::with(['user', 'jenisSampah'])
            ->latest()
            ->take(5)
            ->get(),
    ];

    return view('dashboard', $data);
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

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/setoran', [SetoranController::class, 'index'])->name('setoran.index');
    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::get('/withdrawal/create', [WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal', [WithdrawalController::class, 'store'])
        ->middleware('throttle:withdrawal')
        ->name('withdrawal.store');
    Route::get('/redemption/catalog', [RedemptionController::class, 'catalog'])->name('redemption.catalog');
    Route::post('/redemption', [RedemptionController::class, 'store'])->name('redemption.store');
    Route::get('/redemption', [RedemptionController::class, 'history'])->name('redemption.history');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('jenis-sampah', \App\Http\Controllers\JenisSampahController::class);
    Route::get('/setoran/create', [SetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [SetoranController::class, 'store'])->name('setoran.store');
    Route::get('/admin/setoran', [SetoranController::class, 'adminIndex'])->name('admin.setoran.index');
    Route::get('/admin/withdrawal', [WithdrawalController::class, 'adminIndex'])->name('admin.withdrawal.index');
    Route::post('/admin/withdrawal/{withdrawal}/verify', [WithdrawalController::class, 'verify'])->name('admin.withdrawal.verify');
    Route::resource('reward', RewardController::class);
    Route::get('/admin/redemption', [RedemptionController::class, 'adminIndex'])->name('admin.redemption.index');
    Route::post('/admin/redemption/{redemption}/proses', [RedemptionController::class, 'proses'])->name('admin.redemption.proses');
    Route::post('/admin/redemption/{redemption}/selesaikan', [RedemptionController::class, 'selesaikan'])->name('admin.redemption.selesaikan');
    Route::post('/admin/redemption/{redemption}/tolak', [RedemptionController::class, 'tolak'])->name('admin.redemption.tolak');
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/export', [LaporanController::class, 'export'])->name('admin.laporan.export');
    Route::get('/admin/laporan/export-withdrawals', [LaporanController::class, 'exportWithdrawals'])->name('admin.laporan.export-withdrawals');
    Route::get('/admin/laporan/export-redemptions', [LaporanController::class, 'exportRedemptions'])->name('admin.laporan.export-redemptions');
});

require __DIR__ . '/auth.php';
