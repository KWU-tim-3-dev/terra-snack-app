<div class="flex flex-col items-center justify-center py-8 space-y-6">
    <div class="w-full max-w-md bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-2xl shadow-2xl">
        <div class="text-sm opacity-90 mb-2">Transfer ke:</div>
        <div class="text-2xl font-bold mb-4">Bank Mandiri</div>
        
        <div class="bg-white/20 backdrop-blur-sm p-4 rounded-lg space-y-3">
            <div>
                <div class="text-xs opacity-75 mb-1">Nomor Rekening</div>
                <div class="text-3xl font-mono font-bold tracking-wider">
                    1420 0257 2302 3
                </div>
            </div>
            <div class="border-t border-white/30 pt-3">
                <div class="text-xs opacity-75 mb-1">Atas Nama</div>
                <div class="text-xl font-bold">
                    TERRAFEL AGUNG SAFIT
                </div>
            </div>
        </div>
    </div>

    <div class="text-center space-y-2">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Total Pembayaran
        </p>
        <p class="text-4xl font-extrabold text-primary-600 dark:text-primary-400">
            Rp {{ number_format($total, 0, ',', '.') }}
        </p>
    </div>

    <div class="w-full max-w-md bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">
            📝 Cara Transfer:
        </p>
        <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-2 list-decimal list-inside">
            <li>Buka aplikasi mobile banking Anda</li>
            <li>Pilih menu Transfer ke Bank Mandiri</li>
            <li>Masukkan nomor rekening tujuan</li>
            <li>Masukkan nominal sesuai total pembayaran</li>
            <li>Konfirmasi dan selesaikan transfer</li>
        </ol>
    </div>

    <div class="text-center space-y-2">
        <p class="text-xs text-gray-500 dark:text-gray-500">
            Transfer dari bank mana saja
        </p>
        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">
            BCA • BNI • BRI • Mandiri • CIMB • Permata • dll
        </p>
    </div>

    <div class="max-w-md p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <p class="text-xs text-yellow-800 dark:text-yellow-200 text-center">
            ⚠️ Pastikan transfer sudah berhasil sebelum klik "Sudah Transfer"
        </p>
    </div>
</div>