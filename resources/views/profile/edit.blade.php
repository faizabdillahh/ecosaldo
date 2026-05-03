<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Profil</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-2xl mx-auto space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>