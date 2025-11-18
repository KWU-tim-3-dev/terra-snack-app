{{-- PRODUCT CARD --}}
<div class="bg-white rounded-2xl shadow-md mt-4 w-full p-4 flex flex-col gap-3">
    {{-- Gambar Produk --}}
    <div class="flex items-center gap-4">
        @if ($orderItem->product)
            <img src="{{ $orderItem->product->image_url ?? 'public/assets/logo.webp' }}"
                alt="{{ $orderItem->product->name ?? 'Product Image' }}" class="w-24 h-24 object-contain rounded-lg"
                onerror="this.src='https://placehold.co/300x300/e2e8f0/e2e8f0?text=Image'">
        @endif

        <div>
            <h3 class="font-bold text-lg text-gray-900">{{ $orderItem->product->name ?? 'Nama Produk' }}</h3>
            <p class="text-sm text-gray-600">
                Rincian :
                @if ($orderItem->optionValues->isNotEmpty()) <br>
                    @foreach ($orderItem->optionValues as $value)
                        <span class="font-semibold">{{ $value->customizationOption->name }}:</span> {{ $value->name }}
                        <br>
                    @endforeach
                @else
                    -
                @endif
            </p>

            <p class="text-base font-semibold text-gray-900 mt-1">Rp {{ number_format($orderItem->unit_price, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Quantity & Edit --}}
    <div class="flex justify-between items-center mt-2">
        <div class="flex items-center gap-3">
            <button wire:click="decrementQuantity"
                class="bg-[#E13220] text-white w-7 h-7 flex justify-center items-center rounded-full text-lg font-bold">−</button>
            <span class="text-lg font-semibold text-gray-800">{{ $orderItem->quantity }}</span>
            <button wire:click="incrementQuantity"
                class="bg-[#E13220] text-white w-7 h-7 flex justify-center items-center rounded-full text-lg font-bold">+</button>
        </div>
        <button class="bg-[#E13220] text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-red-700">
            ✎ EDIT
        </button>
    </div>
</div>
