@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 mt-2 text-white bg-purple-600 rounded-2xl font-bold shadow-lg shadow-purple-100 transition-all duration-300 transform scale-[1.02]'
            : 'flex items-center px-4 py-3 mt-2 text-gray-500 hover:bg-pink-50 hover:text-pink-600 rounded-2xl transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg {{ ($active ?? false) ? 'bg-white/20' : 'bg-gray-50' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
        </svg>
    </div>
    <span class="mx-3 text-sm tracking-wide">{{ $slot }}</span>
    @if($active ?? false)
        <div class="ml-auto w-2 h-2 rounded-full bg-white shadow-sm"></div>
    @endif
</a>