{{-- <div class="p-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-center gap-4 mb-8"> <span class="text-2xl text-[#E13220]">
            <i class="fa-solid fa-scroll"></i>
        </span>
        <p class="text-[#E13220] font-semibold text-2xl">
            History Pembelian
        </p>
    </div>

    <div x-data="{
            observer: null,
            init() {
                const container = this.$refs.scrollContainer;
                const trigger = this.$refs.scrollTrigger;

                this.observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if(entry.isIntersecting) {
                            this.$wire.loadMore(); 
                        }
                    });
                }, {
                    root: container,
                    threshold: 1.0
                });
                if(trigger) this.observer.observe(trigger);
            }
        }" x-init="init()" class="space-y-10 max-h-[500px] overflow-auto rounded-lg p-3" x-ref="scrollContainer">

        @foreach($orders as $order)
                <a href="{{ route('customer-history.detail', ['orderId' => $order->id]) }}"
                    class=" p-6  shadow rounded-lg flex flex-col gap-12  duration-300 hover:bg-red-600 group font-semibold group-hover:text-white">
                    <div class="space-y-4">
                        <p class="font-bold group-hover:text-white  text-lg text-gray-800">Order #{{ $order->id }}</p>

                        <p class="text-sm text-gray-600 group-hover:text-white">
                            Status Pesanan:
                            <span class="inline-block px-2 ml-3 py-1 text-xs font-semibold rounded-full
                                    {{ match ($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>

                        <p class="text-sm text-gray-600 group-hover:text-white">
                            Pembayaran:
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full ml-3
                                        {{ match ($order->payment_status) {
                                            'unpaid' => 'bg-gray-100 text-gray-800',
                                            'paid' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </p>

                        <p class="text-xs text-gray-500 group-hover:text-white">
                            Dibuat: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
                        </p>

                        <p class="text-xl text-gray-600 group-hover:text-white">
                            Total: <span class="font-semibold">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </p>

                        <button class="bg-red-600 py-2 text-sm font-semibold group-hover:text-red-500 group-hover:bg-white rounded-full flex justify-center items-center text-white w-full">
                            Lihat Detail
                        </button>
                    </div>
                </a>
        @endforeach

        @if($hasMorePages)
            <div x-ref="scrollTrigger" class="flex justify-center py-4">
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <svg class="animate-spin h-5 w-5 text-[#E13220]" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memuat lebih banyak
                </div>
            </div>
        @endif
    </div>
</div> --}}

<div class="min-h-screen pb-24 bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 1px, transparent 1px); background-size: 24px 24px;">

    <div class="pt-8 px-5 mb-8 text-center">
        <div class="inline-flex items-center justify-center gap-3 bg-white px-6 py-3 rounded-full shadow-[4px_4px_0px_0px_#F8B418]">
            <i class="fa-solid fa-clock-rotate-left text-3xl text-[#E13220]"></i>
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-wide">
                Riwayat Jajan
            </h1>
        </div>
    </div>

    <div x-data="{
            observer: null,
            init() {
                const container = this.$refs.scrollContainer;
                const trigger = this.$refs.scrollTrigger;

                this.observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if(entry.isIntersecting) {
                            this.$wire.loadMore(); 
                        }
                    });
                }, {
                    root: null, // Changed to null to use viewport
                    threshold: 0.1
                });
                if(trigger) this.observer.observe(trigger);
            }
        }" 
        x-init="init()" 
        class="px-5 space-y-6 max-w-2xl mx-auto" 
        x-ref="scrollContainer">

        @foreach($orders as $order)
            <a href="{{ route('customer-history.detail', ['orderId' => $order->id]) }}" wire:navigate
               class="group relative block bg-white rounded-[2rem]  shadow-[6px_6px_0px_0px_#F8B418] overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:border-[#E13220] hover:shadow-[8px_8px_0px_0px_#E13220]">
                
                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-[#FFFBEB] rounded-full border-r-4 border-[#F8B418] group-hover:border-[#E13220]"></div>
                <div class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-[#FFFBEB] rounded-full border-l-4 border-[#F8B418] group-hover:border-[#E13220]"></div>

                <div class="p-6 flex flex-col gap-4">
                    <div class="flex justify-between items-start border-b-2 border-dashed border-gray-200 pb-4">
                        <div>
                            <span class="inline-block px-3 py-1 bg-[#FFF8E1] text-[#F8B418] font-black rounded-lg text-xs uppercase tracking-wider mb-1">
                                Order #{{ $order->id }}
                            </span>
                            <p class="text-xs font-bold text-gray-400">
                                <i class="fa-regular fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y • H:i') }}
                            </p>
                        </div>
                        
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                'processing' => 'bg-blue-100 text-blue-700 border-blue-300',
                                'completed' => 'bg-green-100 text-green-700 border-green-300',
                                'cancelled' => 'bg-red-100 text-red-700 border-red-300',
                            ];
                            $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                        @endphp
                        <div class="px-3 py-1.5 rounded-xl border-2 font-black text-xs uppercase {{ $colorClass }}">
                            {{ ucfirst($order->status) }}
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">Total Bayar</p>
                            <p class="text-2xl font-black text-gray-800">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-xs font-bold text-gray-400 uppercase">Status Bayar</p>
                            <span class="font-black {{ $order->payment_status == 'paid' ? 'text-green-500' : 'text-[#E13220]' }}">
                                {{ $order->payment_status == 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}
                            </span>
                        </div>
                    </div>

                    <div class="w-full bg-[#FFF8E1] text-[#F8B418] group-hover:bg-[#E13220] group-hover:text-white py-3 rounded-xl font-black text-center transition-colors">
                        LIHAT DETAIL
                    </div>
                </div>
            </a>
        @endforeach

        @if($hasMorePages)
            <div x-ref="scrollTrigger" class="flex justify-center py-6">
                <div class="bg-white px-4 py-2 rounded-full border-4 border-[#F8B418] flex items-center gap-2 text-[#F8B418] font-bold shadow-sm">
                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                    Memuat Resep Lainnya...
                </div>
            </div>
        @endif
    </div>
</div>