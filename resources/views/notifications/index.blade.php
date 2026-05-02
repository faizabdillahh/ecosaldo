<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Notifikasi</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-lg">
        @foreach($notifications as $n)
            <div class="p-3 mb-2 border rounded {{ $n->read_at ? 'bg-gray-50' : 'bg-blue-50' }}">
                <strong>{{ $n->data['title'] ?? '' }}</strong>
                <p class="text-sm">{{ $n->data['message'] ?? '' }}</p>
                <small>{{ $n->created_at->diffForHumans() }}</small>
            </div>
        @endforeach

        {{ $notifications->links() }}
    </div>
</x-app-layout>