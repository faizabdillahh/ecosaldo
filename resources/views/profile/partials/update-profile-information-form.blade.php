<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil dan email Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Avatar --}}
        <div>
            <label class="text-sm font-medium text-gray-700 block mb-2">Foto Profil</label>
            <div class="flex items-center gap-4">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-16 h-16 rounded-full object-cover">
                @else
                    <x-avatar :name="$user->name" size="lg" />
                @endif
                <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-eco-50 file:text-eco hover:file:bg-eco-100">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <hr class="border-gray-200">

        {{-- Name --}}
        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Email Anda belum terverifikasi.
                        <button form="send-verification" class="underline text-sm text-eco hover:text-eco-700">
                            Kirim ulang verifikasi
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-eco">Link verifikasi baru telah dikirim ke email Anda.</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Bank --}}
        <div>
            <x-input-label for="bank_name" value="Nama Bank" />
            <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="old('bank_name', $user->bank_name)" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
        </div>

        {{-- Rekening --}}
        <div>
            <x-input-label for="bank_account_number" value="Nomor Rekening" />
            <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" :value="old('bank_account_number', $user->bank_account_number)" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
        </div>

        <div class="flex items-center gap-4">
            <x-button type="submit">Simpan</x-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>