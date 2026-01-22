{{-- <nav class=" w-full mt-4" x-data="{ open: false }" wire:ignore>
    <div class="max-w-content mx-auto px-mobile-gutter">
        <ul class="flex justify-between items-center">
            <li>
                <a href="{{ route('products.list')  }}">
                    <img src="{{ asset('assets/logo.webp') }}" alt="logo" class="w-12">
                </a>
            </li>
            <li>
                <button @click="open = true"
                    class="text-2xl bg-[#E13220] rounded-full text-white p-[0.30rem] w-10 h-10 flex items-center justify-center">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </li>
        </ul>
        <div class="w-full h-1 bg-[#CD301F] mt-4"></div>
    </div>

    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-black bg-opacity-50 max-w-content mx-auto z-20" style="display: none;"></div>

    <div class="fixed mx-auto max-w-content inset-0 flex justify-end items-start z-50 pointer-events-none"
        aria-hidden="true">
        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="translate-x-10 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-10 opacity-0" class=" h-full  bg-white  p-6 pointer-events-auto"
            style="display: none;">
            <div class="flex justify-end mb-8">
                <button @click="open = false"
                    class="text-2xl bg-[#E13220] rounded-full text-white p-[0.30rem] w-10 h-10 flex items-center justify-center">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>

            <ul class="flex flex-col gap-6 text-lg font-medium text-gray-700">
                <li>
                    <a href="{{ route('products.list')  }}"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-burger text-[#E13220] w-6 text-center"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart')  }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-cart-shopping text-[#E13220] w-6 text-center"></i>
                        <span>Keranjang Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer-history.list')  }}"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-file-invoice text-[#E13220] w-6 text-center"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                </li>
                <li class="mt-8 border-t pt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 w-full text-left">
                            <i class="fa-solid fa-arrow-right-from-bracket text-[#E13220] w-6 text-center"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}

<nav class=" top-4 left-0 right-0 z-50 w-full max-w-md mx-auto px-4" x-data="{ open: false }" wire:ignore>

    <div class="relative z-50 bg-white rounded-full shadow-[4px_4px_0px_0px_#F8B418] p-2 pr-2 pl-4 flex justify-between items-center transition-transform duration-300"
        :class="{ '-translate-y-24': open }">

        <a href="{{ route('products.list') }}" wire:navigate class="flex items-center gap-2 group">
            <div
                class="w-10 h-10 bg-[#FFF8E1] rounded-full border-2 border-[#F8B418] flex items-center justify-center overflow-hidden group-hover:scale-110 transition-transform">
                <img src="{{ asset('assets/logo.webp') }}" alt="logo" class="w-8 object-contain">
            </div>
            <span class="font-black text-gray-800 text-lg tracking-tight group-hover:text-[#E13220] transition-colors">
                Terra Snack
            </span>
        </a>

        <button @click="open = true"
            class="w-12 h-12 bg-[#E13220] rounded-full text-white border-b-4 border-[#9a2316] flex items-center justify-center text-xl shadow-md active:border-b-0 active:translate-y-1 transition-all hover:bg-[#ff402c]">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-y-0 left-0 right-0 mx-auto max-w-md w-full bg-black/40 backdrop-blur-sm z-40"
        style="display: none;"></div>

    <div
        class="fixed inset-y-0 left-0 right-0 mx-auto max-w-md w-full z-50 flex justify-end pointer-events-none overflow-hidden">

        <div x-show="open" x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-[85%] h-full bg-[#FFFBEB] border-l-8 border-[#F8B418] shadow-2xl pointer-events-auto flex flex-col"
            style="background-image: radial-gradient(#f7e5bb 2px, transparent 2px); background-size: 24px 24px; display: none;">

            <div class="p-6 bg-white flex justify-between items-center">
                <span class="text-2xl font-black text-gray-800 uppercase tracking-widest">Menu</span>

                <button @click="open = false"
                    class="w-10 h-10 bg-white border-4 border-[#E13220] text-[#E13220] rounded-full flex items-center justify-center hover:bg-[#E13220] hover:text-white transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4">

                <div class="bg-white p-4 rounded-2xl border-4 border-gray-200 mb-6 flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-gray-100 rounded-full border-2 border-gray-300 flex items-center justify-center">
                        <i class="fa-solid fa-user text-gray-400"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Halo Pengguna!</p>
                        <p class="font-black text-gray-800">{{ Auth::user()->name ?? 'Guest' }}</p>
                    </div>
                </div>

                <a href="{{ route('products.list') }}" wire:navigate class="flex items-center gap-4 p-4 bg-white rounded-2xl border-4 transition-all group
                        {{ request()->routeIs('products.list')
                            ? 'border-[#F8B418] shadow-[4px_4px_0px_0px_#F8B418] -translate-y-1'
                            : 'border-transparent shadow-sm hover:border-[#F8B418] hover:shadow-[4px_4px_0px_0px_#F8B418] hover:-translate-y-1' 
                        }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors
                            {{ request()->routeIs('products.list')
                        ? 'bg-[#E13220] text-white'
                        : 'bg-[#FFF8E1] text-[#F8B418] group-hover:bg-[#E13220] group-hover:text-white'
                            }}">
                        <i class="fa-solid fa-burger text-lg"></i>
                    </div>
                    <span class="font-bold text-lg transition-colors
                         {{ request()->routeIs('products.list') ? 'text-gray-900' : 'text-gray-600 group-hover:text-gray-900' }}">
                        Jajan
                    </span>
                </a>

                {{-- Link 2: Keranjang --}}
                <a href="{{ route('cart') }}" wire:navigate class="flex items-center gap-4 p-4 bg-white rounded-2xl border-4 transition-all group
                        {{ request()->routeIs('cart')
                            ? 'border-[#F8B418] shadow-[4px_4px_0px_0px_#F8B418] -translate-y-1'
                            : 'border-transparent shadow-sm hover:border-[#F8B418] hover:shadow-[4px_4px_0px_0px_#F8B418] hover:-translate-y-1' 
                        }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors
                            {{ request()->routeIs('cart')
                        ? 'bg-[#E13220] text-white'
                        : 'bg-[#FFF8E1] text-[#F8B418] group-hover:bg-[#E13220] group-hover:text-white'
                            }}">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                    </div>
                    <span class="font-bold text-lg transition-colors
                          {{ request()->routeIs('cart') ? 'text-gray-900' : 'text-gray-600 group-hover:text-gray-900' }}">
                        Keranjang
                    </span>
                </a>

                {{-- Link 3: Riwayat --}}
                <a href="{{ route('customer-history.list') }}" wire:navigate class="flex items-center gap-4 p-4 bg-white rounded-2xl border-4 transition-all group
                        {{ request()->routeIs('customer-history.list')
                            ? 'border-[#F8B418] shadow-[4px_4px_0px_0px_#F8B418] -translate-y-1'
                            : 'border-transparent shadow-sm hover:border-[#F8B418] hover:shadow-[4px_4px_0px_0px_#F8B418] hover:-translate-y-1' 
                        }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors
                        {{ request()->routeIs('customer-history.list')
                    ? 'bg-[#E13220] text-white'
                    : 'bg-[#FFF8E1] text-[#F8B418] group-hover:bg-[#E13220] group-hover:text-white'
                        }}">
                        <i class="fa-solid fa-receipt text-lg"></i>
                    </div>
                    <span
                        class="font-bold text-lg transition-colors
                          {{ request()->routeIs('customer-history.list') ? 'text-gray-900' : 'text-gray-600 group-hover:text-gray-900' }}">
                        Riwayat
                    </span>
                </a>
            </div>

            <div class="p-6 bg-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 p-3 rounded-xl border-2 border-dashed border-red-300 text-red-500 font-black hover:bg-[#E13220] hover:text-white hover:border-solid hover:border-[#E13220] transition-all">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        KELUAR
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>