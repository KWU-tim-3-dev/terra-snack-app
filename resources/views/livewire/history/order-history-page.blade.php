<div class="px-4 py-6">

    <h2 class="text-2xl font-bold mb-4 text-gray-800">Riwayat Pesanan</h2>

    @forelse ($orders as $order)
        <div class="bg-white shadow-md rounded-xl p-4 mb-5 border border-gray-100">
            
            {{-- Header Order --}}
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-900">
                    Order #{{ $order->id }}
                </h3>

                <span class="px-3 py-1 rounded-lg text-sm 
                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>

            <p class="text-gray-500 text-sm mt-1">
                {{ $order->created_at->format('d M Y, H:i') }}
            </p>

            <div class="border-t my-3"></div>

            {{-- Order Items --}}
            @foreach ($order->items as $item)
                <div class="flex items-start mb-4">

                    {{-- Product Image --}}
                    <img src="{{ $item->product->image_url ?? '/placeholder.png' }}"
                        alt="{{ $item->product_name }}"
                        class="w-16 h-16 object-cover rounded-lg border shadow-sm">

                    <div class="ml-3 flex-1">
                        <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>

                        <p class="text-sm text-gray-600">
                            {{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </p>

                        {{-- If product has customizations --}}
                        @if ($item->optionValues->isNotEmpty())
                            <div class="mt-1 text-sm text-gray-500">
                                <p class="font-medium text-gray-700">Kustomisasi:</p>
                                <ul class="ml-5 list-disc">
                                    @foreach ($item->optionValues as $opt)
                                        <li>
                                            {{ $opt->name }}
                                            @if (!empty($opt->details))
                                                ({{ collect($opt->details)->implode(', ') }})
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Subtotal --}}
                    <div class="text-right font-semibold text-gray-900">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach

            {{-- Footer --}}
            <div class="border-t pt-3 mt-3 flex justify-between font-bold text-gray-900 text-lg">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>

        </div>

    @empty
        <p class="text-gray-500 text-center mt-10">Belum ada riwayat pesanan.</p>
    @endforelse

</div>
