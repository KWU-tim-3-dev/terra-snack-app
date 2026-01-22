{{-- <div>
    <div class="mt-5 mb-8">
        <div class="flex items-center justify-center gap-4">
            <span class="text-2xl text-[#E13220]">
                <i class="fa-solid fa-cart-shopping"></i>
            </span>
            <p class="text-[#E13220] font-semibold text-2xl">
                Keranjang
            </p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 pb-40">
        @if ($cart && $cart->items->isNotEmpty())
            @foreach ($cart->items as $item)
                <livewire:cart.cart-item :cartItem="$item" :key="$item->id" />
            @endforeach
        @else
            <p class="col-span-2 text-center text-gray-500 mt-10">Keranjang Anda kosong.</p>
        @endif
    </div>

    <div
        class="sticky py-10 flex flex-col gap-8 bottom-0 max-w-content mx-auto px-mobile-gutter left-0 right-0 w-full bg-white border-t-4 border-[#E13220] rounded-t-2xl shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">

        <div>
            <div class="flex justify-between items-center text-xs  text-gray-700 mb-2">
                <span class="font-medium">Total Barang</span>
                <span class="text-[#8F8F8F]">{{ $cart->items->sum('quantity') }}</span>
            </div>
            <div class="flex justify-between items-center text-xs  text-black mb-4">
                <span class="font-bold">Total Yang Harus Dibayarkan</span>
                <span class="text-[#8F8F8F]">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div>
            <a href="{{ route('checkout') }}" wire:navigate
                class="block w-full text-sm text-center bg-[#E13220] text-white font-semibold py-2 rounded-lg shadow-md hover:bg-red-700 transition-colors">
                Lanjutkan Ke Pembayaran
            </a>

            <a href="{{ route('products.list') }}" wire:navigate
                class="block text-center text-gray-500 font-medium mt-3">
                <i class="fa-solid fa-chevron-left fa-xs mr-1"></i>
                Kembali
            </a>
        </div>

    </div>
</div> --}}

<div class="min-h-screen pb-48 bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 1px, transparent 1px); background-size: 24px 24px;">

    <div class="pt-8 px-5 mb-8 text-center">
        <div class="inline-flex items-center justify-center gap-3 bg-white px-6 py-3 rounded-full shadow-[4px_4px_0px_0px_#F8B418]">
            <i class="fa-solid fa-basket-shopping text-3xl text-[#E13220] animate-bounce"></i>
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-wide">
                Keranjang
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-4 gap-y-8 px-5">
        @if ($cart && $cart->items->isNotEmpty())
            @foreach ($cart->items as $item)
                <livewire:cart.cart-item :cartItem="$item" :key="$item->id" />
            @endforeach
        @else
            <div class="col-span-2 flex flex-col items-center justify-center py-16 bg-white border-4 border-dashed border-[#F8B418] rounded-[2rem]">
                <div class="w-24 h-24 bg-[#FFF8E1] rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-cookie-bite text-5xl text-[#F8B418]"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Masih Kosong!</h3>
                <p class="text-gray-500 font-bold mb-6">Perut kamu masih lapar loh...</p>
                
                <a href="{{ route('products.list') }}" wire:navigate
                   class="px-6 py-3 bg-[#E13220] text-white font-black rounded-xl border-b-4 border-[#9a2316] hover:bg-[#ff402c] active:border-b-0 active:translate-y-1 transition-all">
                    CARI MAKANAN
                </a>
            </div>
        @endif
    </div>

    <div class="fixed bottom-0 left-0 right-0 z-10 w-full max-w-md mx-auto">
        <div class="bg-white/95 backdrop-blur-sm border-t-4 border-[#F8B418] rounded-t-[2.5rem] shadow-[0_-10px_40px_rgba(0,0,0,0.15)] p-6 pb-8">
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between items-center text-gray-500 font-bold text-sm uppercase">
                    <span>Total Barang</span>
                    <span class="bg-[#FFF8E1] text-[#F8B418] px-3 py-1 rounded-lg">
                        {{ $cart ? $cart->items->sum('quantity') : 0 }} Item
                    </span>
                </div>
                
                <div class="flex justify-between items-end border-t-2 border-dashed border-gray-200 pt-3">
                    <span class="text-gray-800 font-black text-sm uppercase tracking-wide">Total Bayar</span>
                    <span class="text-3xl font-black text-[#E13220]">
                        Rp {{ number_format($this->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="space-y-3">
                <a href="{{ route('checkout') }}" wire:navigate
                   class="block w-full bg-[#E13220] text-white text-xl text-center font-black py-4 rounded-2xl border-b-8 border-[#9a2316] shadow-xl hover:bg-[#ff402c] hover:-translate-y-1 active:border-b-0 active:translate-y-2 active:shadow-none transition-all">
                    BAYAR SEKARANG
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>

                <a href="{{ route('products.list') }}" wire:navigate
                   class="block w-full text-center text-[#F8B418] font-bold py-2 hover:text-[#E13220] transition-colors">
                    <i class="fa-solid fa-utensils mr-2"></i>
                    Tambah Jajan Lagi
                </a>
            </div>
        </div>
    </div>
</div>