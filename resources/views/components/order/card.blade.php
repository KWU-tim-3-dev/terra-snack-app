{{-- <div {{ $attributes->merge(['class' =>
    'bg-white p-5 rounded-xl justify-center items-center shadow flex flex-col items-center text-center space-y-3']) }}>
    {{ $slot }}
</div> --}}

<div {{ $attributes->merge(['class' => 'bg-white p-5 rounded-[1.5rem] shadow-[4px_4px_0px_0px_#F8B418]']) }}>
    {{ $slot }}
</div>