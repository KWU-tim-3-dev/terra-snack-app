<div>
    {{-- HEADER --}}
    <div class="mt-5 mb-8">
        <div class="flex items-center justify-center gap-4">
            <span class="text-2xl text-[#E13220]">
                <i class="fa-solid fa-file-invoice"></i>
            </span>
            <p class="text-[#E13220] font-semibold text-2xl">
                Checkout
            </p>
        </div>
    </div>

    {{-- PICKUP LOCATION --}}
    <div class="bg-white rounded-2xl shadow-md mt-4 w-full p-4">
        <h2 class="text-gray-800 font-semibold mb-1">Pickup Location</h2>
        <p class="text-gray-600 text-sm leading-relaxed">
            @if ($order->user->address)
                {{ $order->user->address }}
            @else
                Alamat pickup tidak tersedia.
            @endif
        </p>
        <button
            class="mt-3 flex items-center gap-2 bg-[#E13220] text-white font-medium px-3 py-2 rounded-lg shadow-md text-sm hover:bg-red-700 transition-colors">
            <x-heroicon-o-map-pin class="w-4 h-4" /> Buka di peta
        </button>
    </div>

    {{-- PRODUCT CARD --}}
    <div class="bg-white rounded-2xl shadow-md mt-4 w-full p-4 flex flex-col gap-3">
        {{-- Gambar Produk --}}
        <div class="flex items-center gap-4">
            <img src="public\assets\logo.webp" alt="Maxicorn" class="w-24 h-24 object-contain rounded-lg">
            <div>
                <h3 class="font-bold text-lg text-gray-900">Maxicorn</h3>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Topping:</span> mix beef <br>
                    <span class="font-semibold">Sayur:</span> sayur sawi <br>
                    <span class="font-semibold">Saus:</span> saus campur
                </p>
                <p class="text-base font-semibold text-gray-900 mt-1">Rp 40.000,00</p>
            </div>
        </div>

        {{-- Quantity & Edit --}}
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center gap-3">
                <button
                    class="bg-[#E13220] text-white w-7 h-7 flex justify-center items-center rounded-full text-lg font-bold">−</button>
                <span class="text-lg font-semibold text-gray-800">2</span>
                <button
                    class="bg-[#E13220] text-white w-7 h-7 flex justify-center items-center rounded-full text-lg font-bold">+</button>
            </div>
            <button
                class="border border-gray-300 text-gray-600 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-gray-100">
                ✎ EDIT
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 pb-40">
        @if ($order && $order->items->isNotEmpty())
            <p>Ada isinya</p>
            @foreach ($order->items as $item)
                {{-- <livewire:orders.order-item :orderItem="$item" :key="$item->id" /> --}}
            @endforeach
        @else
            <p class="col-span-2 text-center text-gray-500 mt-10">Pesanan tidak ditemukan.</p>
        @endif
    </div>

    <div
        class="fixed py-10 flex flex-col gap-8 bottom-0 max-w-content mx-auto px-mobile-gutter left-0 right-0 w-full bg-white border-t-4 border-[#E13220] rounded-t-2xl shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">

        <div>
            <div class="flex justify-between items-center text-xs  text-black mb-4">
                <span class="font-bold">Total Yang Harus Dibayarkan</span>
                <span class="text-[#8F8F8F]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div>
            <a href="#"
                class="block w-full text-sm text-center bg-[#E13220] text-white font-semibold py-2 rounded-lg shadow-md hover:bg-red-700 transition-colors">
                Lanjutkan Ke Pembayaran
            </a>

            <a href="{{ route('cart') }}" wire:navigate class="block text-center text-gray-500 font-medium mt-3">
                <i class="fa-solid fa-chevron-left fa-xs mr-1"></i>
                Kembali Ke Keranjang
            </a>
        </div>
    </div>
</div>
