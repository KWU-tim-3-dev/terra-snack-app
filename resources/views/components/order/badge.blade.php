{{-- @props(['type'])

@php
$styles = [
    'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    'processing' => 'bg-blue-100 text-blue-800 border border-blue-200',
    'completed' => 'bg-green-100 text-green-800 border border-green-200',
    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
    'paid' => 'bg-green-100 text-green-800 border-green-200',
    'unpaid' => 'bg-gray-100 text-gray-800 border-gray-300',
];
@endphp

<span class="px-3 py-1 text-xs font-bold rounded-full inline-flex items-center
    {{ $styles[$type] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
    {{ $slot }}
</span> --}}

@props(['type'])

@php
$styles = [
    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
    'processing' => 'bg-blue-100 text-blue-700 border-blue-300',
    'completed' => 'bg-green-100 text-green-700 border-green-300',
    'cancelled' => 'bg-red-100 text-red-700 border-red-300',
    'paid' => 'bg-green-100 text-green-700 border-green-300',
    'unpaid' => 'bg-gray-100 text-gray-600 border-gray-300',
];
@endphp

<span class="px-4 py-1.5 text-xs font-black rounded-xl border-2 uppercase tracking-wide inline-flex items-center gap-1
    {{ $styles[$type] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
    
    @if($type == 'completed' || $type == 'paid') <i class="fa-solid fa-check"></i> @endif
    @if($type == 'pending' || $type == 'unpaid') <i class="fa-solid fa-clock"></i> @endif
    
    {{ $slot }}
</span>