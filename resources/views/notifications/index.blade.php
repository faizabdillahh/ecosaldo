<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900">Notifikasi</h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button class="text-sm text-eco font-medium hover:underline">Tandai Semua Dibaca</button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4 max-w-2xl mx-auto">
        @if($notifications->isEmpty())
            <x-empty-state 
                title="Belum ada notifikasi" 
                description="Notifikasi dari aktivitas akan muncul di sini" 
            />
        @else
            <div class="space-y-2">
                @foreach($notifications as $n)
                <div class="bg-white border border-gray-200 rounded-xl p-4 {{ $n->read_at ? 'opacity-60' : 'border-l-4 border-l-eco' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-semibold text-sm text-gray-900">{{ $n->data['title'] ?? '' }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $n->data['message'] ?? '' }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <p class="text-xs text-gray-400">{{ $n->created_at->diffForHumans() }}</p>
                                @if(!$n->read_at)
                                    <form action="{{ route('notifications.read', $n->id) }}" method="POST">
                                        @csrf
                                        <button class="text-xs text-eco font-medium hover:underline">Tandai Dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @if(!$n->read_at)
                            <span class="w-2 h-2 bg-eco rounded-full mt-1.5 shrink-0"></span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>