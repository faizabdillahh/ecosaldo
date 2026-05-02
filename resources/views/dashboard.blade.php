<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Dashboard</h2>
    </x-slot>

    <div class="py-6 px-4">
        <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}!</p>

        <div class="grid grid-cols-2 gap-4 mt-6">
            <a href="/setoran" class="bg-blue-100 p-4 rounded hover:bg-blue-200">
                📋 Riwayat Setoran
            </a>
            <a href="/withdrawal/create" class="bg-green-100 p-4 rounded hover:bg-green-200">
                💰 Tarik Saldo
            </a>
            <a href="/withdrawal" class="bg-yellow-100 p-4 rounded hover:bg-yellow-200">
                📜 Riwayat Penarikan
            </a>
        </div>
    </div>
</x-app-layout>