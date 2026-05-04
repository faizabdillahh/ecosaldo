<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi user.
     * Belum dibaca di atas, sudah dibaca di bawah.
     */
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderByRaw('read_at IS NULL DESC')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Tandai satu notifikasi sebagai dibaca.
     */
    public function read(string $id): RedirectResponse
    {
        auth()->user()
            ->notifications()
            ->findOrFail($id)
            ->markAsRead();

        return back()->with('success', 'Notifikasi ditandai dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai dibaca.
     */
    public function readAll(): RedirectResponse
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }
}