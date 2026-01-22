{{-- <div>
    <div class="p-5">
        <a href="{{ route('products.list') }}" wire:navigate class="mb-20 text-gray-400 font-semibold">&lt; Kembali</a>
        <h1 class="text-3xl font-bold mt-2">{{ $product->name }}</h1>
    </div>

    <div class="p-4 space-y-6">
        @foreach ($customizationGroups as $group)
            <div class="rounded-lg p-4 border border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-semibold">{{ $group->name }}</h3>
                    <button wire:click="resetTopping({{ $group->id }})" type="button"
                        class="text-sm text-gray-500 hover:text-red-600 transition-colors">
                        Reset
                    </button>
                </div>

                <div class="space-y-2">
                    @foreach ($group->optionValues as $value)
                        <label class="flex flex-col p-3 rounded-lg hover:bg-gray-50 cursor-pointer border border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-800">{{ $value->name }}</span>
                                <div class="flex items-center gap-4">
                                    @if ($value->price_modifier > 0)
                                        <span class="text-sm text-gray-600">
                                            + Rp {{ number_format($value->price_modifier, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-sm">Gratis</span>
                                    @endif

                                    @if ($group->type === 'radio')
                                        <input type="radio" class="sr-only peer" wire:model.live="selectedOptions.{{ $group->id }}"
                                            value="{{ $value->id }}">
                                        <span
                                            class="w-4 h-4 border border-gray-400 rounded-full peer-checked:bg-red-600 peer-checked:border-red-600"></span>
                                    @else
                                        <input type="checkbox" class="sr-only peer"
                                            wire:model.live="selectedOptions.{{ $group->id }}" value="{{ $value->id }}">
                                        <span
                                            class="w-4 h-4 border border-gray-400 rounded-sm peer-checked:bg-red-600 peer-checked:border-red-600"></span>
                                    @endif
                                </div>
                            </div>

                            @if (!empty($value->details) && in_array($value->id, (array) ($selectedOptions[$group->id] ?? [])))
                                <ul class="text-sm text-gray-500 mt-1 ml-4 list-disc">
                                    @foreach ($value->details as $key => $detail)
                                        <li>{{ $key }}: {{ $detail }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex flex-col gap-2 rounded-lg p-4 border border-gray-200">
            <label for="notes" class="text-xl font-semibold mb-3">Notes</label>
            <textarea id="notes" wire:model.live="notes" rows="5"
                class="w-full border-gray-300 p-2 rounded-lg focus:ring-red-500 focus:border-red-500"
                placeholder="Contoh: Jangan terlalu pedas..."></textarea>
        </div>

        <div class="flex items-center justify-between rounded-lg p-4 border border-gray-200">
            <span class="text-xl font-semibold">Jumlah Barang</span>
            <div class="flex items-center gap-4">
                <button wire:click="decrementQuantity"
                    class="w-8 h-8 rounded-full bg-gray-200 text-lg font-bold">-</button>
                <span class="text-xl font-bold w-8 text-center">{{ $quantity }}</span>
                <button wire:click="incrementQuantity"
                    class="w-8 h-8 rounded-full bg-red-600 text-white text-lg font-bold">+</button>
            </div>
        </div>
    </div>

    <div
        class="sticky py-10 px-mobile-gutter p-4 bottom-0 max-w-content mx-auto left-0 right-0 w-full bg-white border-t-4 border-[#E13220] rounded-t-2xl shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm font-semibold">Total Pembayaran</span>
            <span class="text-sm font-bold text-red-600">
                Rp {{ number_format($currentTotalPrice, 0, ',', '.') }}
            </span>
        </div>
        <button wire:click="saveToCart" wire:loading.attr="disabled"
            class="w-full bg-red-600 text-white text-sm font-bold py-2 rounded-lg hover:bg-red-700 transition-colors">
            Tambahkan ke keranjang
        </button>
    </div>
</div> --}}

<div class="min-h-screen pb-60 bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 1px, transparent 1px); background-size: 24px 24px;">

    <div class="pt-6 px-5 mb-6">
        <a href="{{ route('products.list') }}" wire:navigate
           class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-[#F8B418] font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_#F8B418] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#E13220] hover:border-[#E13220] hover:text-[#E13220] transition-all">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        
        <h1 class="text-4xl font-black text-gray-800 mt-6 leading-none drop-shadow-sm">
            {{ $product->name }}
        </h1>
        <div class="h-2 w-24 bg-[#E13220] rounded-full mt-3"></div>
    </div>

    <div class="px-5 space-y-8">
        @foreach ($customizationGroups as $group)
            <div class="bg-white rounded-[2rem] p-6  shadow-[8px_8px_0px_0px_#F8B418]">
                
                {{-- Group Header --}}
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-black text-gray-800">{{ $group->name }}</h3>
                    <button wire:click="resetTopping({{ $group->id }})" type="button"
                        class="px-3 py-1 text-xs font-bold bg-red-100 text-[#E13220] rounded-lg hover:bg-[#E13220] hover:text-white transition-colors uppercase tracking-wide">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach ($group->optionValues as $value)
                        <label class="group relative block cursor-pointer">
                            
                            {{-- Hidden Input --}}
                            @if ($group->type === 'radio')
                                <input type="radio" class="peer sr-only" 
                                       wire:model.live="selectedOptions.{{ $group->id }}" 
                                       value="{{ $value->id }}">
                            @else
                                <input type="checkbox" class="peer sr-only"
                                       wire:model.live="selectedOptions.{{ $group->id }}" 
                                       value="{{ $value->id }}">
                            @endif

                            {{-- The "Tile" --}}
                            <div class="flex justify-between items-center p-4 rounded-2xl border-4 border-gray-200 bg-white transition-all duration-200
                                        group-hover:border-[#F8B418] 
                                        peer-checked:border-[#E13220] peer-checked:bg-[#FFF8E1] peer-checked:shadow-[4px_4px_0px_0px_#E13220] peer-checked:-translate-y-1">
                                
                                <div class="flex items-center gap-3">
                                    {{-- Custom Checkbox/Radio Indicator --}}
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white 
                                                peer-checked:border-[#E13220] peer-checked:bg-[#E13220]">
                                        <i class="fa-solid fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                    
                                    <span class="font-bold text-gray-600 peer-checked:text-gray-900">{{ $value->name }}</span>
                                </div>

                                {{-- Price Badge --}}
                                @if ($value->price_modifier > 0)
                                    <span class="px-2 py-1 bg-white border-2 border-gray-200 rounded-lg text-xs font-bold text-gray-500
                                                 peer-checked:border-[#E13220] peer-checked:text-[#E13220]">
                                        +{{ number_format($value->price_modifier, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-[#F8B418] uppercase">Gratis</span>
                                @endif
                            </div>

                            {{-- Details/Sub-options --}}
                            @if (!empty($value->details) && in_array($value->id, (array) ($selectedOptions[$group->id] ?? [])))
                                <div class="mt-2 ml-4 p-3 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 text-sm font-medium text-gray-500">
                                    <ul class="list-disc list-inside">
                                        @foreach ($value->details as $key => $detail)
                                            <li>{{ $key }}: {{ $detail }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="bg-white  rounded-[2rem] p-6  shadow-[8px_8px_0px_0px_#F8B418]">
            <label for="notes" class="flex items-center gap-2 text-2xl font-black mb-4">
                <i class="fa-regular fa-message text-[#F8B418]"></i> Catatan Koki
            </label>
            <textarea id="notes" wire:model.live="notes" rows="3"
                class="w-full border-4 border-gray-200 p-4 rounded-2xl font-bold text-gray-700 placeholder-gray-400 focus:ring-0 focus:border-[#E13220] focus:shadow-[4px_4px_0px_0px_#E13220] transition-all outline-none resize-none"
                placeholder="Contoh: Jangan terlalu pedas ya..."></textarea>
        </div>

        <div class="bg-white rounded-[2rem] p-6  shadow-[8px_8px_0px_0px_#F8B418] flex items-center justify-between">
            <span class="text-xl font-black text-gray-800">Mau Berapa?</span>
            
            <div class="flex items-center gap-3 bg-[#FFFBEB] p-2 rounded-2xl border-2 border-[#F8B418]">
                <button wire:click="decrementQuantity"
                    class="w-10 h-10 rounded-xl bg-white border-2 border-[#F8B418] text-[#F8B418] text-xl font-black hover:bg-[#E13220] hover:border-[#E13220] hover:text-white transition-all active:scale-90">
                    -
                </button>
                
                <span class="text-2xl font-black w-8 text-center text-gray-800">{{ $quantity }}</span>
                
                <button wire:click="incrementQuantity"
                    class="w-10 h-10 rounded-xl bg-[#E13220] border-b-4 border-[#9a2316] text-white text-xl font-black hover:bg-[#ff402c] hover:-translate-y-0.5 active:border-b-0 active:translate-y-1 transition-all">
                    +
                </button>
            </div>
        </div>
    </div>

    <div class="fixed py-10 px-5 bottom-0 left-0 right-0 z-10 w-full max-w-md mx-auto bg-white/95 backdrop-blur-sm border-t-4 border-[#F8B418] rounded-t-[2rem] shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="max-w-md mx-auto">
            <div class="flex justify-between items-end mb-4 px-2">
                <span class="text-gray-500 font-bold text-sm uppercase tracking-wide">Total Harus Dibayar</span>
                <span class="text-3xl font-black text-[#E13220]">
                    Rp {{ number_format($currentTotalPrice, 0, ',', '.') }}
                </span>
            </div>
            
            <button wire:click="saveToCart" wire:loading.attr="disabled"
                class="w-full bg-[#E13220] text-white text-xl font-black py-4 rounded-2xl border-b-8 border-[#9a2316] shadow-xl hover:bg-[#ff402c] hover:-translate-y-1 active:border-b-0 active:translate-y-2 active:shadow-none transition-all flex items-center justify-center gap-3">
                <span wire:loading.remove>
                    <i class="fa-solid fa-cart-plus"></i> MASUK KERANJANG
                </span>
                <span wire:loading>
                    <i class="fa-solid fa-circle-notch animate-spin"></i> MEMPROSES...
                </span>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('show-success', message => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
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
        });
    });
</script>