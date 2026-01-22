{{-- @props(['icon'])

<p class=" mb-1 text-sm flex font-semibold text-gray-400 items-center gap-2 uppercase tracking-wide">
    <i class="{{ $icon }} text-red-600"></i>
    {{ $slot }}
</p> --}}

@props(['icon'])

<p class="mb-3 text-xs font-black text-gray-400 flex items-center gap-2 uppercase tracking-wider">
    <span class="w-6 h-6 rounded-full bg-[#FFF8E1] flex items-center justify-center text-[#E13220]">
        <i class="{{ $icon }}"></i>
    </span>
    {{ $slot }}
</p>