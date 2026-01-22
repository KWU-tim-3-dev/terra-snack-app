{{-- <div class="bg-white p-4 rounded-2xl shadow-lg flex flex-col items-center relative">
    <button wire:click="removeItem" wire:loading.attr="disabled" wire:target="removeItem"
        class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition-colors z-10" aria-label="Hapus item">
        <i class="fa-solid fa-times fa-lg"></i>
    </button>

    @if ($cartItem->product)
        <img src="{{ $cartItem->product->image_url ?? 'https://placehold.co/300x300/e2e8f0/e2e8f0?text=Image' }}"
            alt="{{ $cartItem->product->name ?? 'Produk' }}" class="w-full h-24 object-contain mb-3" 
    @endif

    <h3 class="font-bold text-lg text-gray-900 text-center mb-1">
        {{ $cartItem->product->name ?? 'Nama Produk' }}
    </h3>

    <div class="text-center mb-3 min-h-[30px]">
        <p class="text-xs text-gray-500 leading-tight">
            Rincian :
            @if ($cartItem->optionValues->isNotEmpty())
                {{ $cartItem->optionValues->pluck('name')->join(', ') }}
            @else
                -
            @endif
        </p>
    </div>

    <p class="text-sm font-semibold text-gray-800 mb-4">
        {{ $cartItem->quantity }}x Rp {{ number_format($cartItem->unit_price, 0, ',', '.') }}
    </p>

    <a href="{{ route('product.customize', $cartItem->product_id) }}?cartItemId={{ $cartItem->id }}" wire:navigate
        class="w-full text-center text-sm font-medium text-[#E13220] border border-[#E13220] py-2 rounded-lg hover:bg-[#E13220] hover:text-white transition-colors">
        Ubah
    </a>
</div> --}}

<div class="relative group h-full flex flex-col bg-white p-4 rounded-[2rem]  shadow-[6px_6px_0px_0px_#F8B418] hover:border-[#E13220] hover:shadow-[6px_6px_0px_0px_#E13220] hover:-translate-y-1 transition-all duration-300">

    <button wire:click="removeItem" wire:loading.attr="disabled"
            class="absolute -top-3 -right-3 w-8 h-8 bg-white border-2 border-red-200 text-red-400 rounded-full shadow-sm flex items-center justify-center hover:bg-[#E13220] hover:text-white hover:border-[#E13220] hover:scale-110 transition-all z-20"
            aria-label="Hapus item">
        <i class="fa-solid fa-xmark text-lg font-bold"></i>
    </button>

    <div class="relative -mt-8 mb-2 self-center">
        <div class="w-24 h-24 bg-white rounded-2xl border-4 border-white shadow-md overflow-hidden">
            @if ($cartItem->product)
                <img src="{{ Storage::url($cartItem->product->image_url) }}"
                     alt="{{ $cartItem->product->name }}"
                     class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    <div class="flex-1 text-center flex flex-col">
        <h3 class="font-black text-gray-800 text-lg leading-tight mb-2">
            {{ $cartItem->product->name ?? 'Produk' }}
        </h3>

        <div class="mb-3 flex-1">
            @if ($cartItem->optionValues->isNotEmpty())
                <div class="flex flex-wrap gap-1 justify-center">
                    @foreach($cartItem->optionValues as $option)
                        <span class="px-2 py-0.5 bg-[#FFF8E1] border border-[#F8B418] text-[#DFA113] text-[10px] font-bold rounded-md uppercase">
                            {{ $option->name }}
                        </span>
                    @endforeach
                </div>
            @else
                <span class="text-xs text-gray-400 font-bold italic">Original</span>
            @endif
        </div>

        <div class="bg-gray-50 rounded-xl p-2 mb-3 border-2 border-dashed border-gray-200">
            <p class="text-xs font-bold text-gray-500 mb-1">Total</p>
            <p class="text-sm font-black text-[#E13220]">
                {{ $cartItem->quantity }}x <span class="text-gray-800">Rp {{ number_format($cartItem->unit_price, 0, ',', '.') }}</span>
            </p>
        </div>

        <a href="{{ route('product.customize', $cartItem->product_id) }}?cartItemId={{ $cartItem->id }}" wire:navigate
           class="w-full block py-2 rounded-xl border-2 border-[#E13220] text-[#E13220] font-black text-sm uppercase tracking-wide hover:bg-[#E13220] hover:text-white transition-colors">
            <i class="fa-solid fa-pen mr-1"></i> Ubah
        </a>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const showToast = (icon, message) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon,
                title: message,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#fff',
                color: '#333',
                customClass: {
                    popup: 'rounded-xl shadow-md',
                    title: 'font-medium'
                }
            });
        };
        Livewire.on('show-success', message => showToast('success', message));
        Livewire.on('show-error', message => showToast('error', message));
    });
</script>