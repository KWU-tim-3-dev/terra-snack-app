<?php

namespace App\Livewire\Temp;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.customer')]
class OrderPaymentPage extends Component
{
    public Order $order;

    public string $paymentMethod = '';
    public ?string $cardName = null;
    public ?string $card = null; // placeholder, bukan data kartu nyata
    public ?string $stripePublishableKey = null; // jika nanti pakai stripe

    // computed values
    public float $subtotal = 0;
    public float $shipping = 0;
    public float $tax = 0;
    public float $total = 0;

    protected $rules = [
        'paymentMethod' => 'required|string|in:card,paypal,cash',
        'cardName' => 'nullable|string|max:255',
        // 'card' => 'nullable|string' // placeholder only
    ];

    public function mount(Order $order)
    {
        // optional: pastikan user can view this order (auth)
        $user = Auth::user();
        if (! $user) {
            // jika belum login, redirect ke login (atau abort)
            return redirect()->route('login');
        }

        $this->order = $order->loadMissing(['items', 'items.product', 'items.optionValues']);

        // compute summary
        $this->recalculateTotals();

        // optional: set stripe key if available from config
        $this->stripePublishableKey = config('services.stripe.key') ?? null;
    }

    protected function recalculateTotals(): void
    {
        $items = $this->order->items ?? collect();

        $this->subtotal = (float) $items->sum(function ($item) {
            // prefer subtotal column if present, else calculate
            return isset($item->subtotal) ? (float) $item->subtotal : ((float)($item->price ?? $item->unit_price ?? 0) * (int)($item->quantity ?? 1));
        });

        // you can adjust shipping/tax rules - here simple placeholders
        $this->shipping = (float) ($this->order->shipping ?? 0);
        $this->tax = (float) ($this->order->tax ?? 0);

        $this->total = $this->subtotal + $this->shipping + $this->tax;
    }

    // formatter to use in Blade as $this->formatCurrency($amount)
    public function formatCurrency($amount): string
    {
        $amount = (float) ($amount ?? 0);
        // format Indonesian style: Rp 10.000,00
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public function pay()
    {
        $this->validate();

        // Demo implementation: mark order as paid for 'cash' or simulate for card/paypal
        try {
            if ($this->paymentMethod === 'cash') {
                $this->order->update([
                    'payment_method' => 'cash',
                    'payment_status' => 'pending',
                    'status' => 'processing',
                ]);
                session()->flash('success', 'Order marked as Cash on Delivery. Silakan tunggu konfirmasi.');
            } elseif ($this->paymentMethod === 'paypal') {
                // placeholder: integrate PayPal SDK here
                $this->order->update([
                    'payment_method' => 'paypal',
                    'payment_status' => 'pending',
                    'status' => 'pending',
                ]);
                session()->flash('success', 'Redirecting to PayPal (simulasi).');
            } else { // card
                // placeholder: integrate Stripe/3rd party here
                $this->order->update([
                    'payment_method' => 'card',
                    'payment_status' => 'paid', // in real case, set after gateway callback
                    'status' => 'processing',
                ]);
                session()->flash('success', 'Pembayaran berhasil (simulasi). Terima kasih.');
            }

            // recompute totals in case model changed
            $this->recalculateTotals();
        } catch (\Throwable $e) {
            report($e);
            session()->flash('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function cancel()
    {
        // simple cancel action
        session()->flash('success', 'Pembayaran dibatalkan.');
        // optionally redirect
        // return redirect()->route('orders.history');
    }

    public function render()
    {
        return view('livewire.temp.order-item', [
            'stripePublishableKey' => $this->stripePublishableKey,
        ]);
    }
}
