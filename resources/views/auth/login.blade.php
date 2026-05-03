<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-50">
        {{-- Header --}}
        <div class="bg-eco px-4 py-10 text-center text-white">
            <h1 class="text-2xl font-bold flex items-center justify-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                EcoSaldo
            </h1>
            <p class="text-eco-50 text-sm mt-1">Sampahmu, Saldomu</p>
        </div>

        {{-- Form --}}
        <div class="flex-1 flex items-start justify-center px-4 -mt-6">
            <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Login</h2>

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 text-sm p-3 rounded-lg mb-4">
                        Email atau password salah.
                    </div>
                @endif

                @if(session('status'))
                    <div class="bg-green-50 text-green-700 text-sm p-3 rounded-lg mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="w-full mt-1 px-3 py-2.5 pr-10 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="w-5 h-5 text-gray-400 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4 text-sm">
                        <label class="flex items-center gap-2 text-gray-600">
                            <input type="checkbox" name="remember" class="rounded border-gray-300">
                            Ingat saya
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-eco font-medium">Lupa?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-eco text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-eco-700 transition">
                        Login
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-eco font-semibold">Daftar</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const open = btn.querySelector('.eye-open');
            const closed = btn.querySelector('.eye-closed');
            input.type = input.type === 'password' ? 'text' : 'password';
            open.classList.toggle('hidden');
            closed.classList.toggle('hidden');
        }
    </script>
</x-guest-layout>