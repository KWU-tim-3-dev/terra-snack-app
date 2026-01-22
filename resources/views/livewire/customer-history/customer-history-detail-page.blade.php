{{-- <div class="p-6 max-w-3xl mx-auto space-y-10">

    <a href="{{ route('customer-history.list') }}" wire:navigate
        class="text-gray-400 font-semibold hover:text-gray-600 transition flex items-center gap-1">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

    <h1 class="text-2xl font-bold mt-4 mb-6 text-center text-[#E13220]">
        Detail Pesanan #{{ $order->id }}
    </h1>

    <div class="flex flex-col gap-7">

        <x-order.card>
            <x-order.label icon="fa-solid fa-circle-info">Status Pesanan</x-order.label>
            <x-order.badge :type="$order->status">
                {{ ucfirst($order->status) }}
            </x-order.badge>
        </x-order.card>

        <x-order.card>
            <x-order.label icon="fa-solid fa-credit-card">Status Pembayaran</x-order.label>
            <x-order.badge :type="$order->payment_status">
                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
            </x-order.badge>
        </x-order.card>

        <x-order.card>
            <x-order.label icon="fa-solid fa-wallet">Total Harga</x-order.label>
            <p class="font-bold text-gray-800 text-lg">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </p>
        </x-order.card>

        <x-order.card>
            <x-order.label icon="fa-solid fa-calendar-days">Tanggal Transaksi</x-order.label>
            <p class="text-gray-800 font-medium">
                {{ $order->created_at->translatedFormat('d M Y • H:i') }}
            </p>
            <p class="text-xs text-gray-500">
                ({{ $order->created_at->diffForHumans() }})
            </p>
        </x-order.card>

        <x-order.card class="flex flex-col gap-3">

            <x-order.label icon="fa-solid fa-clock">Status Pembayaran</x-order.label>

            @if ($order->paid_at)
                <x-order.badge type="paid">
                    Pembayaran Berhasil
                </x-order.badge>
            @else
                <x-order.badge type="unpaid">
                    Belum Dibayar
                </x-order.badge>
            @endif


            @if ($order->paid_at)
                <div class="text-sm">
                    <p class="text-gray-800 font-semibold">
                        {{ $order->paid_at->timezone('Asia/Jakarta')->translatedFormat('d M Y • H:i') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        ({{ $order->paid_at->diffForHumans() }})
                    </p>
                </div>
            @endif


            @if ($order->payment_status === 'unpaid')
                <a href="{{ route('customer-history.upload-proof', $order->id) }}" wire:navigate class="w-full bg-[#E13220] text-white text-xs font-semibold py-2 rounded-lg shadow
                       hover:bg-red-700 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-upload"></i>
                    Upload Bukti Pembayaran
                </a>

                <p class="text-xs text-gray-400 text-center italic">
                    Silakan upload bukti setelah Anda melakukan pembayaran.
                </p>
            @endif

        </x-order.card>


        <x-order.card>
            <x-order.label icon="fa-solid fa-map">Pickup Location</x-order.label>
            <div>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Jl. Ketintang No.156, Ketintang, <br> Kec. Gayungan, Surabaya, Jawa Timur 60231
                </p>
            </div>
            <a href="https://maps.google.com/?q=Jl.+Ketintang+No.156,+Ketintang,+Surabaya" target="_blank"
                class="mt-4 flex items-center justify-center gap-2 w-full bg-gray-100 text-gray-700 py-2 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                <i class="fa-solid fa-map"></i> Buka di Peta
            </a>
        </x-order.card>


    </div>

    <div class="mt-10">
        <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2 flex items-center gap-2">
            <i class="fa-solid fa-list"></i>
            Daftar Item
        </h2>

        <div class="bg-white rounded-lg shadow divide-y divide-gray-200">

            @foreach ($order->items as $item)
                <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition">

                    <div class="space-y-1">
                        <p class="font-medium text-gray-800">
                            {{ $item->product->name ?? 'Produk' }}
                        </p>

                        <p class="text-sm text-gray-500 flex items-center gap-1">
                            {{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <p class="font-bold text-red-600 text-right">
                        Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                    </p>

                </div>
            @endforeach

        </div>

        <div class="mt-3 text-right font-semibold text-gray-700 text-xl">
            Total Item :
            <span class="text-[#E13220]">
                Rp {{ number_format($order->items->sum(fn($i) => $i->unit_price * $i->quantity), 0, ',', '.') }}
            </span>
        </div>
    </div>

</div> --}}


<div class="min-h-screen pb-24 bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 1px, transparent 1px); background-size: 24px 24px;">

    <div class="pt-6 px-5 mb-4">
        <a href="{{ route('customer-history.list') }}" wire:navigate
           class="inline-flex items-center gap-2 px-4 py-2 bg-white  rounded-full text-[#F8B418] font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_#F8B418] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#E13220] hover:border-[#E13220] hover:text-[#E13220] transition-all">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto px-5 space-y-8">
        
        <div class="text-center">
            <h1 class="text-3xl font-black text-gray-800 uppercase">
                Pesanan #{{ $order->id }}
            </h1>
            <div class="h-2 w-24 bg-[#E13220] rounded-full mx-auto mt-2"></div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            
            <x-order.card>
                <x-order.label icon="fa-solid fa-bell">Status</x-order.label>
                <x-order.badge :type="$order->status">
                    {{ ucfirst($order->status) }}
                </x-order.badge>
            </x-order.card>

            <x-order.card>
                <x-order.label icon="fa-solid fa-credit-card">Pembayaran</x-order.label>
                <x-order.badge :type="$order->payment_status">
                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                </x-order.badge>
            </x-order.card>

            <x-order.card class="col-span-2 bg-[#FFF8E1] border-[#F8B418]">
                <x-order.label icon="fa-solid fa-wallet">Total Harga</x-order.label>
                <p class="font-black text-[#E13220] text-3xl">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </p>
            </x-order.card>

            <x-order.card class="col-span-2">
                <x-order.label icon="fa-solid fa-calendar-days">Waktu Transaksi</x-order.label>
                <div class="flex justify-between items-end">
                    <p class="text-gray-800 font-bold text-lg">
                        {{ $order->created_at->translatedFormat('d M Y • H:i') }}
                    </p>
                    <span class="text-xs font-bold text-gray-400 bg-gray-100 px-2 py-1 rounded-lg">
                        {{ $order->created_at->diffForHumans() }}
                    </span>
                </div>
            </x-order.card>

            <x-order.card class="col-span-2 flex flex-col gap-4">
                <x-order.label icon="fa-solid fa-money-bill-wave">Info Pembayaran</x-order.label>

                @if ($order->paid_at)
                    <div class="bg-green-100 border-2 border-green-300 rounded-xl p-3 flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <p class="font-bold text-green-800">LUNAS</p>
                            <p class="text-xs font-semibold text-green-600">
                                {{ $order->paid_at->timezone('Asia/Jakarta')->translatedFormat('d M Y • H:i') }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border-2 border-red-200 rounded-xl p-3">
                        <p class="text-red-600 font-bold text-sm mb-3">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> Belum ada pembayaran
                        </p>
                        
                        @if ($order->payment_status === 'unpaid')
                            <a href="{{ route('customer-history.upload-proof', $order->id) }}" wire:navigate 
                               class="block w-full bg-[#E13220] text-white font-black text-center py-3 rounded-xl border-b-4 border-[#9a2316] hover:bg-[#ff402c] active:border-b-0 active:translate-y-1 transition-all">
                                <i class="fa-solid fa-upload mr-2"></i> UPLOAD BUKTI
                            </a>
                        @endif
                    </div>
                @endif
            </x-order.card>

            <x-order.card class="col-span-2">
                <x-order.label icon="fa-solid fa-map-location-dot">Lokasi Ambil</x-order.label>
                <div class="bg-gray-50 rounded-xl p-3 border-2 border-dashed border-gray-200 mb-3">
                    <p class="text-sm font-semibold text-gray-600 leading-relaxed">
                        Jl. Ketintang No.156, Ketintang,<br> Kec. Gayungan, Surabaya
                    </p>
                </div>
                <a href="https://maps.google.com/?q=Jl.+Ketintang+No.156,+Ketintang,+Surabaya" target="_blank"
                   class="flex items-center justify-center gap-2 w-full bg-[#F8B418] text-white py-3 rounded-xl font-black border-b-4 border-[#d39200] hover:bg-[#ffc12e] active:border-b-0 active:translate-y-1 transition-all">
                    <i class="fa-solid fa-map"></i> BUKA PETA
                </a>
            </x-order.card>
        </div>

        <div class="bg-white rounded-[2rem] border-4 border-[#F8B418] shadow-[6px_6px_0px_0px_#F8B418] overflow-hidden">
            <div class="bg-[#FFF8E1] p-4 border-b-4 border-[#F8B418]">
                <h2 class="text-lg font-black text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-[#E13220]"></i>
                    Daftar Belanjaan
                </h2>
            </div>

            <div class="divide-y-2 divide-dashed divide-gray-200">
                @foreach ($order->items as $item)
                    <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#E13220] text-white rounded-lg flex items-center justify-center font-black text-sm">
                                {{ $item->quantity }}x
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-lg">
                                    {{ $item->product->name ?? 'Produk' }}
                                </p>
                                <p class="text-xs font-bold text-gray-400">
                                    @ Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <p class="font-black text-gray-800">
                            Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="p-4 bg-[#FFF8E1] border-t-4 border-[#F8B418] flex justify-between items-center">
                <span class="font-bold text-gray-500 uppercase">Total Items</span>
                <span class="font-black text-[#E13220] text-xl">
                    Rp {{ number_format($order->items->sum(fn($i) => $i->unit_price * $i->quantity), 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
</div>