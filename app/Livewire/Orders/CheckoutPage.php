<?php

namespace App\Livewire\Orders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.customer')]
class CheckoutPage extends Component
{
    public Order $order;

    protected $listeners = ['orderUpdated' => 'refreshOrder'];

    public $subtotal = 0;
    public $packagingFeeTotal = 0;
    public $total = 0;

    public function mount()
    {
        // Gunakan user yang sedang login jika ada, jika tidak pakai test user ID=1
        $user = Auth::user() ?? User::find(1);

        if (! $user) {
            abort(404, 'User tidak ditemukan. Untuk testing, buat User ID 1.');
        }

        // Pastikan saat membuat order, field NOT NULL diberi nilai default
        $this->order = $user->orders()->firstOrCreate(
            ['id' => request()->route('order')],
            [
                'total_price' => 0.00,
                'payment_status' => 'unpaid',
            ]
        );

        $this->loadOrderDetails();
        $this->calculateTotals();
    }

    public function refreshOrder()
    {
        $this->loadOrderDetails();
        $this->calculateTotals();
    }

    protected function loadOrderDetails()
    {
        if ($this->order) {
            $this->order->load(['items.product', 'items.optionValues']);
        }
    }

    public function calculateTotals()
    {
        if (!$this->order || !$this->order->relationLoaded('items')) {
            $this->subtotal = 0;
            $this->packagingFeeTotal = 0;
            $this->total = 0;
            return;
        }

        $this->subtotal = $this->order->items->sum('subtotal');

        $itemCount = $this->order->items->sum('quantity');
        $packagingFeePerItem = 1000;

        $this->packagingFeeTotal = $itemCount * $packagingFeePerItem;
        $this->total = $this->subtotal + $this->packagingFeeTotal;
    }

    public function render()
    {
        return view('livewire.orders.checkout-page');
    }
}
