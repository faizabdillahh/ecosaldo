<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-50">
        {{-- Header --}}
        <div class="bg-eco px-4 py-8 text-center text-white">
            <h1 class="text-2xl font-bold flex items-center justify-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                EcoSaldo
            </h1>
            <p class="text-eco-50 text-sm mt-1">Buat akun baru</p>
        </div>

        {{-- Form --}}
        <div class="flex-1 flex items-start justify-center px-4 -mt-4 pb-8">
            <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-6">

                {{-- Form Register Manual --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" rows="2" required
                            class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                                class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">No Rekening</label>
                            <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}"
                                class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full mt-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="register-password" required
                                class="w-full mt-1 px-3 py-2.5 pr-10 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                            <button type="button" onclick="togglePassword('register-password', this)" aria-label="Tampilkan password"
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
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="register-password-confirm" required
                                class="w-full mt-1 px-3 py-2.5 pr-10 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-eco focus:border-eco">
                            <button type="button" onclick="togglePassword('register-password-confirm', this)" aria-label="Tampilkan password"
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
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <button type="submit" class="w-full bg-eco text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-eco-700 transition">
                        Daftar
                    </button>
                </form>

                {{-- Separator --}}
                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-3 text-gray-400">atau</span>
                    </div>
                </div>

                {{-- Google Register --}}
                <a href="{{ route('google.login') }}"
                   class="flex items-center justify-center gap-2 w-full bg-white border border-gray-300 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Daftar dengan Google
                </a>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-eco font-semibold">Login</a>
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