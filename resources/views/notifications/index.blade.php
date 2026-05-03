<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Notifikasi</h2>
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
                        <div>
                            <p class="font-semibold text-sm text-gray-900">{{ $n->data['title'] ?? '' }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $n->data['message'] ?? '' }}</p>
                        </div>
                        @if(!$n->read_at)
                            <span class="w-2 h-2 bg-eco rounded-full mt-1.5 shrink-0"></span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-2">{{ $n->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>