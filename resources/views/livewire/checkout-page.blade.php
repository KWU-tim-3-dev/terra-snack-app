{{-- <div>
        <div class="mt-5 mb-8">
            <div class="flex items-center justify-center gap-4">
                <span class="text-2xl text-[#E13220]">
                    <i class="fa-solid fa-money-bill"></i>
                </span>
                <h1 class="text-lg font-bold border-b-2 border-[#E13220] text-[#E13220]">Checkout</h1>
            </div>
        </div>

        @if ($order)
            <div class="p-5 space-y-5">

                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                    <div class="flex items-start gap-3">
                        <div class="bg-red-50 p-2 rounded-full text-[#E13220]">
                            <i class="fa-solid fa-map"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-800 text-sm mb-1">Pickup Location</h2>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Jl. Ketintang No.156, Ketintang, <br> Kec. Gayungan, Surabaya, Jawa Timur 60231
                            </p>
                        </div>
                    </div>
                    <a href="https://maps.google.com/?q=Jl.+Ketintang+No.156,+Ketintang,+Surabaya" target="_blank"
                        class="mt-4 flex items-center justify-center gap-2 w-full bg-gray-100 text-gray-700 py-2 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                        <i class="fa-solid fa-map"></i> Buka di Peta
                    </a>
                </div>

                @foreach($order->items as $item)
                    <div class="bg-white p-4 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)] flex gap-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $item->product_name }}</h3>

                            @if($item->optionValues && $item->optionValues->count() > 0)
                                <div class="mt-2 space-y-1">
                                    @foreach($item->optionValues as $option)
                                        <p class="text-xs text-gray-500">
                                            <span class="font-medium text-gray-400">{{ $option->customizationOption->name ?? 'N/A' }}:</span>
                                            {{ $option->name }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-3 font-bold text-gray-900">
                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="flex flex-col justify-between items-end">
                            <img src="{{ $item->product->image_url ?? asset('assets/snack-placeholder.png') }}"
                                class="w-20 h-24 object-cover rounded-lg shadow-sm">

                            <div class="text-sm font-semibold text-gray-600 mt-2">
                                x {{ $item->quantity }}
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($order->payment_status == 'unpaid')
                    <div class="bg-white p-5 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                        <h3 class="font-bold text-gray-800 mb-4">Pembayaran (QRIS)</h3>

                        <div class="flex flex-col items-center mb-6">
                            <img src="{{ asset('assets/qris.jpeg') }}" alt="QRIS"
                                class="object-contain border-2 border-dashed border-gray-200 rounded-xl p-2">
                            <p class="text-xs text-gray-400 mt-2">Scan QRIS di atas untuk membayar</p>
                        </div>

                        <form class="space-y-3">
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 p-4 text-center relative hover:bg-gray-100 transition cursor-pointer">
                                <input type="file" wire:model="paymentProof" accept="image/*"
                                  value="{{old('')  }}"  class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                @if ($paymentProof)
                                    <img src="{{ $paymentProof->temporaryUrl() }}" class="h-32 mx-auto object-contain rounded-lg">
                                    <p class="text-xs text-green-600 mt-2 font-semibold">File terpilih. Klik tombol di bawah.</p>
                                @else
                                    <i class="fa-solid fa-camera text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-xs text-gray-500 font-medium">Tap untuk upload bukti transfer</p>
                                @endif
                            </div>
                            @error('paymentProof') <span class="text-red-500 text-xs block text-center">{{ $message }}</span>
                            @enderror
                        </form>
                    </div>
                @endif

                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)] space-y-2 mb-20">
                    <h3 class="font-bold text-gray-800 mb-3">Rincian Pembayaran</h3>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Biaya Packaging</span>
                        <span>Rp {{ number_format($packagingFeeTotal, 0, ',', '.') }}</span>
                    </div>
                    <div
                        class="border-t border-dashed border-gray-200 my-2 pt-2 flex justify-between font-bold text-gray-900 text-lg">
                        <span>Total</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            @if($order->payment_status == 'unpaid')
                <div
                    class="sticky  py-10 px-mobile-gutter p-4 bottom-0 max-w-content mx-auto  left-0 right-0 w-full bg-white border-t-4 border-[#E13220] rounded-t-2xl shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
                    <div class="max-w-lg mx-auto flex items-center justify-between gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400">Total Pembayaran</span>
                            <span class="text-xl font-bold text-[#E13220]">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="button" wire:click="uploadPaymentProof" wire:loading.attr="disabled"
                            class="bg-[#E13220] text-white px-8 py-3 rounded-full font-bold text-sm shadow-lg shadow-red-200 hover:bg-red-700 transition flex items-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="uploadPaymentProof">
                                Kirim Bukti
                            </span>
                            <span wire:loading wire:target="uploadPaymentProof">
                                <i class="fa-solid fa-spinner animate-spin"></i> Sending...
                            </span>
                            <i wire:loading.remove wire:target="uploadPaymentProof" class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            @else
                <div class="fixed bottom-0 left-0 right-0 bg-green-50 border-t border-green-100 p-5 pb-8 z-30">
                    <div class="max-w-lg mx-auto text-center">
                        <p class="text-green-700 font-bold mb-2">
                            <i class="fa-solid fa-check-circle"></i> Bukti Terkirim
                        </p>
                        <p class="text-xs text-green-600">Menunggu konfirmasi admin.</p>
                    </div>
                </div>
            @endif

        @else
            <div class="flex items-center justify-center h-screen text-gray-400">
                <i class="fa-solid fa-circle-notch animate-spin text-3xl"></i>
            </div>
        @endif
</div> --}}

<div class="min-h-screen pb-48 bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 2px, transparent 2px); background-size: 24px 24px;">

    {{-- Header --}}
    <div class="pt-8 px-5 mb-8 text-center">
        <div class="inline-flex items-center justify-center gap-3 bg-white px-6 py-3 rounded-full border-4 border-[#F8B418] shadow-[4px_4px_0px_0px_#F8B418]">
            <i class="fa-solid fa-cash-register text-3xl text-[#E13220]"></i>
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-wide">
                Checkout
            </h1>
        </div>
    </div>

    @if ($order)
        <div class="px-5 space-y-6 max-w-lg mx-auto">

            {{-- Location Card --}}
            <div class="bg-white p-5 rounded-[2rem] border-4 border-[#F8B418] shadow-[6px_6px_0px_0px_#F8B418]">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-[#FFF8E1] rounded-full border-2 border-[#F8B418] flex items-center justify-center text-[#E13220] text-xl shrink-0">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-gray-800 text-lg uppercase mb-1">Lokasi Ambil</h2>
                        <p class="text-sm font-bold text-gray-500 leading-relaxed">
                            Jl. Ketintang No.156, Ketintang,<br> Kec. Gayungan, Surabaya
                        </p>
                    </div>
                </div>
                <a href="https://maps.google.com/?q=Jl.+Ketintang+No.156,+Ketintang,+Surabaya" target="_blank"
                    class="mt-4 flex items-center justify-center gap-2 w-full bg-[#F8B418] text-white py-3 rounded-xl font-black text-sm border-b-4 border-[#d39200] hover:bg-[#ffc12e] active:border-b-0 active:translate-y-1 transition-all">
                    <i class="fa-solid fa-map"></i> BUKA PETA
                </a>
            </div>

            {{-- Order Items --}}
            <div class="space-y-4">
                <h3 class="ml-2 font-black text-gray-400 uppercase tracking-wider text-sm">Pesanan Kamu</h3>
                
                @foreach($order->items as $item)
                    <div class="bg-white p-4 rounded-[1.5rem] border-4 border-gray-100 shadow-sm flex gap-4 items-center">
                        {{-- Image --}}
                        <div class="w-20 h-20 bg-gray-100 rounded-xl border-2 border-gray-200 overflow-hidden shrink-0">
                            <img src="{{ $item->product->image_url ?? asset('assets/snack-placeholder.png') }}"
                                 class="w-full h-full object-cover">
                        </div>

                        {{-- Details --}}
                        <div class="flex-1">
                            <h3 class="font-black text-gray-800 leading-tight mb-1">{{ $item->product_name }}</h3>
                            
                            @if($item->optionValues && $item->optionValues->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-2">
                                    @foreach($item->optionValues as $option)
                                        <span class="px-2 py-0.5 bg-[#FFF8E1] text-[#F8B418] text-[10px] font-bold rounded uppercase">
                                            {{ $option->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="flex justify-between items-end">
                                <span class="text-xs font-bold text-gray-400">x{{ $item->quantity }}</span>
                                <span class="font-black text-gray-800">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Payment Summary --}}
            <div class="bg-white p-6 rounded-[2rem] border-4 border-[#E13220] shadow-[6px_6px_0px_0px_#E13220] relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#E13220] text-white px-4 py-1 rounded-full font-black text-xs uppercase tracking-widest border-2 border-white shadow-sm">
                    Ringkasan
                </div>

                <div class="space-y-2 mt-2">
                    <div class="flex justify-between text-sm font-bold text-gray-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-gray-500">
                        <span>Biaya Packaging</span>
                        <span>Rp {{ number_format($packagingFeeTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t-2 border-dashed border-gray-200 my-3 pt-3 flex justify-between font-black text-gray-800 text-xl">
                        <span>Total Bayar</span>
                        <span class="text-[#E13220]">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Integrated Payment Upload (If Unpaid) --}}
            @if($order->payment_status == 'unpaid')
                <div class="bg-[#FFF8E1] p-6 rounded-[2rem] border-4 border-[#F8B418] border-dashed text-center">
                    <h3 class="font-black text-gray-800 mb-4 uppercase">Pembayaran (QRIS)</h3>

                    <div class="bg-white p-3 rounded-2xl border-2 border-[#F8B418] inline-block mb-4 shadow-sm">
                        <img src="{{ asset('assets/qris.jpeg') }}" alt="QRIS" class="h-40 object-contain rounded-lg">
                    </div>

                    <form class="space-y-3">
                        <label class="block w-full cursor-pointer">
                            <input type="file" wire:model="paymentProof" accept="image/*" class="hidden">
                            <div class="bg-white border-4 border-dashed border-[#F8B418] rounded-xl p-4 hover:bg-[#FFFBEB] transition-colors relative">
                                @if ($paymentProof)
                                    <img src="{{ $paymentProof->temporaryUrl() }}" class="h-24 mx-auto object-cover rounded-lg">
                                    <div class="mt-2 text-xs font-black text-green-500 uppercase">
                                        <i class="fa-solid fa-check-circle"></i> File Oke!
                                    </div>
                                @else
                                    <i class="fa-solid fa-camera text-2xl text-[#F8B418] mb-1"></i>
                                    <p class="text-xs font-bold text-gray-400 uppercase">Upload Bukti</p>
                                @endif
                            </div>
                        </label>
                        @error('paymentProof') 
                            <span class="text-[#E13220] text-xs font-bold block">{{ $message }}</span> 
                        @enderror
                    </form>
                </div>
            @endif

        </div>

        {{-- Sticky Footer --}}
        <div class="fixed bottom-0 left-0 right-0 z-50 w-full max-w-md mx-auto">
            <div class="bg-white/95 backdrop-blur-sm border-t-4 border-[#F8B418] rounded-t-[2.5rem] shadow-[0_-10px_40px_rgba(0,0,0,0.15)] p-6 pb-8">
                
                @if($order->payment_status == 'unpaid')
                    <div class="flex justify-between items-end mb-4 px-2">
                        <span class="text-gray-500 font-bold text-sm uppercase">Total</span>
                        <span class="text-3xl font-black text-[#E13220]">
                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="button" wire:click="uploadPaymentProof" wire:loading.attr="disabled"
                        class="w-full bg-[#E13220] text-white text-xl font-black py-4 rounded-2xl border-b-8 border-[#9a2316] shadow-xl hover:bg-[#ff402c] hover:-translate-y-1 active:border-b-0 active:translate-y-2 active:shadow-none transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="uploadPaymentProof">
                            <i class="fa-solid fa-check"></i> KONFIRMASI BAYAR
                        </span>
                        <span wire:loading wire:target="uploadPaymentProof">
                            <i class="fa-solid fa-spinner animate-spin"></i> PROSES...
                        </span>
                    </button>
                @else
                    <div class="text-center">
                        <div class="inline-block bg-green-100 text-green-600 px-6 py-2 rounded-full font-black text-sm uppercase mb-2">
                            <i class="fa-solid fa-check-circle mr-1"></i> Pembayaran Berhasil
                        </div>
                        <p class="text-xs font-bold text-gray-400">Menunggu konfirmasi admin dapur.</p>
                    </div>
                @endif
            </div>
        </div>

    @else
        <div class="flex flex-col items-center justify-center h-[50vh] text-[#F8B418]">
            <i class="fa-solid fa-circle-notch animate-spin text-5xl mb-4"></i>
            <p class="font-black text-xl uppercase">Menyiapkan Dapur...</p>
        </div>
    @endif
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