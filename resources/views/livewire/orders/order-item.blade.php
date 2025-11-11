<div class="max-w-4xl mx-auto p-6" wire:key="order-payment-{{ $order->id ?? now()->timestamp }}">
    {{-- Order Summary --}}
    <h2 class="text-2xl font-semibold mb-4">Order Payment</h2>

    <div class="bg-white shadow rounded-lg divide-y divide-gray-200">
        <div class="p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Order #{{ $order->id ?? '—' }}</p>
                    <p class="text-lg font-medium">{{ $order->customer_name ?? 'Customer' }}</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at ? $order->created_at->toDayDateTimeString() : '' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-sm font-semibold text-indigo-600">{{ $order->status ?? 'pending' }}</p>
                </div>
            </div>
        </div>

        <div class="p-4">
            <h3 class="font-medium mb-2">Items</h3>
            <ul class="space-y-3">
                @forelse($order->items ?? [] as $item)
                    <li class="flex justify-between">
                        <div class="text-sm">
                            <div class="font-medium">{{ $item->name }}</div>
                            <div class="text-gray-500">Qty: {{ $item->quantity }}</div>
                        </div>
                        <div class="text-sm font-medium">
                            {{ currency($item->price * $item->quantity ?? 0) }}
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-gray-500">No items found on this order.</li>
                @endforelse
            </ul>

            <div class="mt-4 border-t pt-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">{{ currency($order->subtotal ?? 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">{{ currency($order->shipping ?? 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-medium">{{ currency($order->tax ?? 0) }}</span>
                </div>
                <div class="flex justify-between mt-2 pt-2 border-t">
                    <span class="text-lg font-semibold">Total</span>
                    <span class="text-lg font-semibold">{{ currency($order->total ?? 0) }}</span>
                </div>
            </div>
        </div>

        <div class="p-4">
            {{-- Payment Form --}}
            <form wire:submit.prevent="pay">
                <h3 class="font-medium mb-3">Payment Method</h3>

                <div class="space-y-3">
                    <label class="flex items-center space-x-3">
                        <input type="radio" wire:model="paymentMethod" value="card" class="form-radio" />
                        <span class="text-sm">Credit / Debit Card</span>
                    </label>

                    <label class="flex items-center space-x-3">
                        <input type="radio" wire:model="paymentMethod" value="paypal" class="form-radio" />
                        <span class="text-sm">PayPal</span>
                    </label>

                    <label class="flex items-center space-x-3">
                        <input type="radio" wire:model="paymentMethod" value="cash" class="form-radio" />
                        <span class="text-sm">Cash on Delivery</span>
                    </label>

                    @error('paymentMethod')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Card form (Stripe/Elements integration placeholder) --}}
                @if($paymentMethod === 'card')
                    <div class="mt-4 space-y-3">
                        <div>
                            <label class="block text-sm text-gray-700">Cardholder name</label>
                            <input type="text" wire:model.defer="cardName" class="mt-1 block w-full border rounded px-3 py-2" />
                            @error('cardName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700">Card details</label>

                            {{-- This container is for Stripe Elements or other JS card widget.
                                 Livewire should ignore it so frontend JS can mount. --}}
                            <div id="card-element" wire:ignore class="mt-1 p-3 border rounded bg-white">
                                <!-- Stripe Elements will mount here -->
                                <p class="text-xs text-gray-500">Secure card input will appear here.</p>
                            </div>
                            @error('card') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                {{-- PayPal button placeholder --}}
                @if($paymentMethod === 'paypal')
                    <div class="mt-4" wire:ignore>
                        <div id="paypal-button-container">
                            <!-- PayPal button will be rendered here by client JS -->
                            <p class="text-sm text-gray-500">Click the PayPal button to complete payment.</p>
                        </div>
                    </div>
                @endif

                {{-- Cash info --}}
                @if($paymentMethod === 'cash')
                    <div class="mt-4 text-sm text-gray-700">
                        <p>Customer will pay at delivery. Please confirm the shipping details and contact info are correct.</p>
                    </div>
                @endif

                <div class="mt-6 flex items-center space-x-3">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-60"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Pay {{ currency($order->total ?? 0) }}</span>
                        <span wire:loading>Processing...</span>
                    </button>

                    <button type="button" wire:click="cancel" class="px-4 py-2 bg-gray-100 rounded">
                        Cancel
                    </button>

                    <div wire:loading class="text-sm text-gray-500">Please wait — processing payment.</div>
                </div>

                {{-- Generic error / success messages --}}
                @if(session()->has('error'))
                    <div class="mt-3 text-sm text-red-600">{{ session('error') }}</div>
                @endif

                @if(session()->has('success'))
                    <div class="mt-3 text-sm text-green-600">{{ session('success') }}</div>
                @endif
            </form>
        </div>
    </div>

    {{-- Helpful notes for JS integration (not visible to end users when integrated) --}}
    <div class="sr-only" aria-hidden="true">
        <p id="stripe-publishable-key">{{ $stripePublishableKey ?? '' }}</p>
    </div>
</div>
