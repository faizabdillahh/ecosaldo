@props([
    'label' => null,
    'name' => '',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih',
])

<div>
    @if($label)
        <label for="{{ $name }}" class="text-xs font-medium text-gray-500 block mb-1">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        <select 
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 pr-10 appearance-none bg-white text-gray-700 focus:ring-2 focus:ring-eco focus:border-eco transition']) }}
        >
            <option value="">{{ $placeholder }}</option>
            @foreach($options as $value => $text)
                <option value="{{ $value }}" @selected((string) $value === (string) $selected)>
                    {{ $text }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>
</div>