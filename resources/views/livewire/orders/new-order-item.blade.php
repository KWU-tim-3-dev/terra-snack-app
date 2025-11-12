<div >
    {{-- ORDER ITEMS --}}
    <div>
        @if ($order && $order->items->isNotEmpty())
            @foreach ($order->items as $item)
                <livewire:orders.order-item :orderItem="$item" :key="$item->id" />
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