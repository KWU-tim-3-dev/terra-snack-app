<div class="min-h-screen bg-[#F5FAF9] flex flex-col items-center pb-24">

    {{-- HEADER --}}
    <div class="w-full bg-white shadow-md p-4 flex items-center gap-2 sticky top-0 z-30">
        <x-heroicon-o-home class="w-6 h-6 text-[#E13220]" />
        <h1 class="text-xl font-bold text-[#E13220]">Checkout</h1>
    </div>

    {{-- PICKUP LOCATION --}}
    <div class="bg-white rounded-2xl shadow-md mt-4 w-[90%] p-4">
        <h2 class="text-gray-800 font-semibold mb-1">Pickup Location</h2>
        <p class="text-gray-600 text-sm leading-relaxed">
            Jl. Ketintang No.156, Ketintang, Kec. Gayungan, Surabaya, Jawa Timur 60231
        </p>
        <button
            class="mt-3 flex items-center gap-2 bg-[#F8F8F8] hover:bg-[#E13220] hover:text-white transition-all px-3 py-2 rounded-lg text-sm font-medium text-gray-700">
            <x-heroicon-o-map-pin class="w-4 h-4" /> Buka di peta
        </button>
    </div>

    {{-- PRODUCT CARD --}}
    <div class="bg-white rounded-2xl shadow-md mt-4 w-[90%] p-4 flex flex-col gap-3">
        {{-- Gambar Produk --}}
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/maxicorn.png') }}" alt="Maxicorn" class="w-24 h-24 object-contain rounded-lg">
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

    {{-- TOTAL PEMBAYARAN --}}
    <div class="bg-white rounded-2xl shadow-md mt-4 w-[90%] p-4">
        <div class="flex justify-between text-gray-800 font-medium mb-2">
            <span>Harga</span>
            <span>Rp 40.000,00</span>
        </div>
        <hr class="my-2 border-gray-200">
        <div class="flex justify-between text-gray-900 font-bold text-lg">
            <span>Total Pembayaran</span>
            <span>Rp 40.000,00</span>
        </div>
    </div>

    {{-- OPSI PEMBAYARAN (Bottom Sheet) --}}
    <div
        class="fixed bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl border-t-4 border-[#E13220] py-4 flex flex-col items-center">
        <button class="text-[#E13220] font-bold text-lg">OPSI PEMBAYARAN</button>
    </div>
</div>
