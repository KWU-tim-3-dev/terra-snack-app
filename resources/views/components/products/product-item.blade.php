{{-- <div
    class="relative duration-300 cursor-pointer hover:bg-[#E13220] bg-white p-4 rounded-xl shadow-lg flex justify-center flex-col items-center overflow-visible group">

    <img src="{{ Storage::url($product->image_url) }}" alt=" {{ $product->name }}"
        class="w-40 h-40 object-contain -mt-24 z-10 drop-shadow-lg">

    <div class="mt-7 text-center">
        <h3 class="font-bold text-lg text-gray-900 group-hover:text-white">{{ $product->name }}</h3>
        <p class="text-base text-gray-700 group-hover:text-white">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>
    </div>

    @if ($product->customizationOptions->isNotEmpty())
    <a href="{{ route('product.customize', ['product' => $product->slug]) }}" wire:navigate>
        Tambahkan
    </a>

    @else
    <button wire:click="addToCart" wire:loading.attr="disabled"
        class="mt-4 w-full bg-[#E13220] text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
        Tambahkan
    </button>
    @endif

    <a href="{{ route('product.customize', $product) }}" class="mt-4 w-full bg-[#E13220] text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors" wire:navigate.hover>
        Tambahkan
    </a>
</div> --}}

<div class="relative flex flex-col items-center">

    <div class="absolute inset-0 bg-white rounded-[2rem]  shadow-[8px_8px_0px_0px_#F8B418] transition-all duration-300 group-hover:border-[#E13220] group-hover:shadow-[8px_8px_0px_0px_#E13220] group-hover:-translate-y-2"></div>

    <div class="relative z-10 -mt-20 w-36 h-36 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
        <div class="absolute inset-0 bg-white rounded-full border-4 border-[#E13220]/20 blur-md scale-90 translate-y-4"></div> {{-- Shadow under food --}}
        <img src="{{ Storage::url($product->image_url) }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="w-full h-full object-contain drop-shadow-xl">
    </div>

    <div class="relative z-10 w-full px-4 pb-5 pt-2 text-center">
        <h3 class="font-black text-lg text-gray-800 leading-tight group-hover:text-[#E13220] transition-colors">
            {{ $product->name }}
        </h3>

        <div class="mt-2 inline-block px-3 py-1 bg-[#FFF8E1] rounded-lg border-2 border-[#F8B418] group-hover:bg-[#E13220] group-hover:border-[#E13220] transition-colors duration-300">
            <p class="text-sm font-extrabold text-[#F8B418] group-hover:text-white">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
        </div>

        <div class="mt-5 w-full">
            <a href="{{ route('product.customize', $product) }}"
               wire:navigate.hover
               class="block w-full bg-[#E13220] text-white py-3 rounded-xl font-black text-base border-b-4 border-[#9a2316] active:border-b-0 active:translate-y-1 active:shadow-inner transition-all hover:bg-[#ff402c]">
               MAKAN!
            </a>
        </div>
    </div>
</div>