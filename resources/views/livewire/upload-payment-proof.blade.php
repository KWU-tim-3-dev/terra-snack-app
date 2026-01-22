{{-- <div class="p-6 max-w-lg mx-auto space-y-6 flex flex-col justify-center items-center">
    <div class="flex items-center text-[#E13220] gap-4">
        <span class="fa-solid fa-upload"></span>
        <h1 class="text-xl font-bold text-center ">Upload Bukti Pembayaran</h1>
    </div>

    <x-order.card class="w-full max-w-xs space-y-3 text-center">

        <x-order.label icon="fa-solid fa-receipt">
            Ringkasan Pesanan
        </x-order.label>

        <p class="text-sm text-gray-600">
            <span class="font-semibold text-gray-700">Invoice:</span> #{{ $order->id }}
        </p>

        <p class="text-sm text-gray-600">
            <span class="font-semibold text-gray-700">Total:</span>
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </p>

        <div class="border-t pt-2 space-y-1">
            <p class="text-sm font-semibold text-gray-600">Produk:</p>

            @foreach ($order->items as $item)
                <p class="text-sm text-gray-500">
                    {{ $item->product_name ?? $item->product->name }} × {{ $item->quantity }}
                </p>
            @endforeach
        </div>

    </x-order.card>



    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('assets/qris.jpeg') }}" alt="QRIS"
            class="object-contain border-2 border-dashed border-gray-200 rounded-xl p-2">
        <p class="text-xs text-gray-400 mt-2">Scan QRIS di atas untuk membayar</p>
    </div>

    <form class="w-full space-y-4 flex flex-col items-center">

        <label
            class="w-full max-w-xs flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-md tracking-wide uppercase border border-gray-300 cursor-pointer hover:bg-gray-100 transition-colors text-center">
            <i class="fa-solid fa-upload text-2xl mb-2 text-red-500"></i>
            <span class="text-sm font-medium text-gray-700">Pilih file bukti pembayaran</span>
            <input type="file" wire:model="paymentProof" accept="image/*" class="hidden" />
        </label>

        @if ($paymentProof)
            <div class="w-full max-w-xs mt-2">
                <p class="text-sm text-gray-500 mb-1 text-center">Preview:</p>
                <img src="{{ $paymentProof->temporaryUrl() }}" alt="Preview Bukti"
                    class="w-full h-64 object-contain border rounded-lg shadow-sm">
            </div>
        @endif

        @error('paymentProof')
            <span class="text-red-500 text-sm text-center w-full max-w-xs">{{ $message }}</span>
        @enderror

        <button type="button" wire:click="uploadPaymentProof" wire:loading.attr="disabled"
            wire:loading.class="opacity-75 cursor-not-allowed" wire:target="uploadPaymentProof"
            class="w-full max-w-xs bg-[#E13220] text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-red-700 transition-colors flex items-center justify-center space-x-2">

            <span wire:loading wire:target="uploadPaymentProof">
                <i class="fa-solid fa-spinner animate-spin"></i>
            </span>
            <span wire:loading wire:target="uploadPaymentProof">
                Mengupload...
            </span>
            <span wire:loading.remove wire:target="uploadPaymentProof">
                Upload Bukti
            </span>
        </button>

    </form>
</div> --}}

<div class="min-h-screen pb-24 bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 1px, transparent 1px); background-size: 24px 24px;">

    <div class="pt-6 px-5 mb-8">
        <a href="{{ route('customer-history.detail', $order->id) }}" wire:navigate
           class="inline-flex items-center gap-2 px-4 py-2 bg-white  rounded-full text-[#F8B418] font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_#F8B418] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#E13220] hover:border-[#E13220] hover:text-[#E13220] transition-all">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        
        <div class="text-center mt-6">
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-wide">
                Upload Bukti
            </h1>
            <div class="h-2 w-24 bg-[#E13220] rounded-full mx-auto mt-2"></div>
        </div>
    </div>

    <div class="px-5 max-w-lg mx-auto space-y-8">
        
        <div class="bg-white p-6 rounded-[2rem]  shadow-[6px_6px_0px_0px_#F8B418] relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-4 bg-[#FFF8E1] "></div>
            
            <div class="text-center mb-4 mt-2">
                <span class="bg-[#E13220] text-white px-3 py-1 rounded-lg font-black text-xs uppercase tracking-widest">
                    TAGIHAN #{{ $order->id }}
                </span>
            </div>

            <div class="flex justify-between items-end border-b-2 border-dashed border-gray-200 pb-4 mb-4">
                <span class="font-bold text-gray-400 uppercase text-xs">Total Tagihan</span>
                <span class="font-black text-3xl text-gray-800">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </span>
            </div>

            <div class="space-y-2">
                @foreach ($order->items as $item)
                    <div class="flex justify-between text-sm font-bold text-gray-600">
                        <span>{{ $item->product_name ?? $item->product->name }}</span>
                        <span class="text-[#E13220]">x{{ $item->quantity }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-4 pb-8 rounded-[2rem] shadow-[6px_6px_0px_0px_#F8B418] transform rotate-1 hover:rotate-0 transition-transform duration-300">
            <div class="bg-gray-800 rounded-2xl p-4 mb-4 border-4 border-gray-100">
                <img src="{{ asset('assets/qris.jpeg') }}" alt="QRIS"
                    class="w-full h-64 object-contain bg-white rounded-lg">
            </div>
            <div class="text-center">
                <p class="font-black text-gray-800 text-lg uppercase">Scan Disini Ya!</p>
                <p class="text-xs font-bold text-gray-400">Gunakan aplikasi pembayaran favoritmu</p>
            </div>
        </div>

        <form class="space-y-6">
            
            <label class="block w-full cursor-pointer group">
                <input type="file" wire:model="paymentProof" accept="image/*" class="hidden" />
                
                <div class="bg-[#FFF8E1] border-4 border-dashed border-[#F8B418] rounded-[2rem] p-8 text-center transition-all group-hover:bg-white group-hover:border-[#E13220] group-hover:scale-[1.02]">
                    @if ($paymentProof)
                        <div class="relative inline-block">
                            <img src="{{ $paymentProof->temporaryUrl() }}" class="h-48 rounded-xl border-4 border-white shadow-lg rotate-2">
                            <div class="absolute -top-3 -right-3 bg-[#E13220] text-white w-8 h-8 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>
                        <p class="mt-4 font-black text-[#E13220] uppercase">Foto Siap!</p>
                    @else
                        <div class="w-16 h-16 bg-[#F8B418] text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:bg-[#E13220] transition-colors">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <p class="font-black text-gray-700 uppercase">Tap Untuk Upload</p>
                        <p class="text-xs font-bold text-gray-400">Foto bukti transfer kamu</p>
                    @endif
                </div>
            </label>

            @error('paymentProof')
                <div class="bg-red-100 border-l-4 border-[#E13220] text-[#E13220] p-4 rounded-r-xl font-bold text-sm">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $message }}
                </div>
            @enderror

            <button type="button" wire:click="uploadPaymentProof" wire:loading.attr="disabled"
                class="w-full bg-[#E13220] text-white text-xl font-black py-4 rounded-2xl border-b-8 border-[#9a2316] shadow-xl hover:bg-[#ff402c] hover:-translate-y-1 active:border-b-0 active:translate-y-2 active:shadow-none transition-all flex items-center justify-center gap-3 disabled:opacity-70 disabled:cursor-not-allowed">
                
                <span wire:loading.remove wire:target="uploadPaymentProof">
                    <i class="fa-solid fa-paper-plane"></i> KIRIM BUKTI
                </span>
                <span wire:loading wire:target="uploadPaymentProof">
                    <i class="fa-solid fa-circle-notch animate-spin"></i> MENGUPLOAD...
                </span>
            </button>
        </form>
    </div>
</div>