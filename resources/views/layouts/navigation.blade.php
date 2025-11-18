<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu (Header Utama) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center border-b-2 border-red-500">
            
            {{-- KONTEN HEADER YANG DIMODIFIKASI --}}
            <div class="flex justify-between items-center w-full">
                
                {{-- Logo Terra Snack --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}">
                        {{-- Pastikan logoTerraSnack.svg ada di public/images/ --}}
                        <img src="{{ asset('images/logoTerraSnack.svg') }}" alt="Terra Snack Logo" class="h-10 w-auto"> 
                    </a>
                </div>

                {{-- Link Navigasi Desktop (Disembunyikan di sini) --}}
                <div class="hidden sm:flex sm:items-center">
                    {{-- Navigasi Desktop bisa ditambahkan di sini --}}
                </div>

                {{-- Hamburger Menu (Hanya Muncul di Mobile) --}}
                <div class="sm:hidden flex items-center">
                    <button @click="open = true" class="inline-flex items-center justify-center p-2 rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            {{-- Icon Hamburger (3 Garis) --}}
                            <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            {{-- AKHIR KONTEN HEADER YANG DIMODIFIKASI --}}

        </div>
    </div>

    <!-- START: OFF-CANVAS SIDEBAR (Menu Mobile yang muncul dari kanan) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed inset-0 z-50 sm:hidden" 
         style="display: none;">

        {{-- Backdrop (Area gelap di belakang menu, klik untuk menutup) --}}
        <div @click="open = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        {{-- Sidebar Menu --}}
        <div class="fixed top-0 right-0 h-full w-4/5 max-w-sm bg-orange-400 p-6 shadow-2xl flex flex-col justify-between"
             style="background-color: #F8B44A;"> {{-- Menggunakan warna oranye-kuning yang mirip di gambar --}}

            {{-- Isi Menu dan Tombol Close --}}
            <div>
                {{-- Tombol Close (X) di Sudut Kanan Atas --}}
                <button @click="open = false" class="absolute top-4 right-4 text-white bg-red-600 rounded-full p-1 shadow-lg">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Header atau Logo di Sidebar (Opsional, untuk konsistensi) --}}
                <div class="mb-8 pt-4">
                    <a href="{{ route('dashboard') }}">
                         <img src="{{ asset('images/logoTerraSnack.svg') }}" alt="Terra Snack Logo" class="h-10 w-auto"> 
                    </a>
                </div>

                {{-- Daftar Menu --}}
                <div class="space-y-4">
                    {{-- Item 1: Keranjang Saya (Cart Icon) --}}
                    <a href="#" class="flex items-center text-gray-800 font-semibold text-lg hover:text-red-700 transition">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Keranjang Saya
                    </a>

                    {{-- Item 2: Riwayat Transaksi (Document Icon) --}}
                    <a href="#" class="flex items-center text-gray-800 font-semibold text-lg hover:text-red-700 transition">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Riwayat Transaksi
                    </a>

                    {{-- Item 3: Akun (User Icon) --}}
                    <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-800 font-semibold text-lg hover:text-red-700 transition">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Akun
                    </a>
                </div>
            </div>

            {{-- Tombol Logout (Di bagian Bawah) --}}
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-lg font-bold text-white shadow-xl transition duration-150"
                        style="background-color: #F08033;"> {{-- Warna oranye yang lebih gelap untuk tombol Keluar --}}
                    <span class="flex items-center justify-center">
                        {{-- Icon Logout --}}
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </span>
                </button>
            </form>

        </div>
    </div>
    <!-- END: OFF-CANVAS SIDEBAR -->
</nav>