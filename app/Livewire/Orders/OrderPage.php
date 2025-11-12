<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.customer')]
class OrderPage extends Component
{
    public Order $order;

    protected $listeners = ['orderUpdated' => 'refreshOrder'];

    public $subtotal = 0;

    public $packagingFeeTotal = 0;

    public $total = 0;

    public function mount()
    {
        $user = Auth::user() ?? User::find(1);

        if (! $user) {
            abort(404, 'User tidak ditemukan. Untuk testing, buat User ID 1.');
        }

        $this->addCartToOrder($user);
        // $this->clearCart($user);
        $this->loadOrderDetails();
        $this->calculateTotals();
    }

    // Create a new order for the user
    protected function createOrderFromCart(User $user)
    {
        $this->order = $user->orders()->create([
            'total_price' => 0.00,
            'payment_status' => 'unpaid',
        ]);
    }

    public function refreshOrder()
    {
        $this->loadOrderDetails();
        $this->calculateTotals();
    }

    protected function addCartToOrder(User $user)
    {
        $this->createOrderFromCart($user);
        $cart = $user->cart()->with('items')->first();

        if ($cart && $cart->items->isNotEmpty()) {
            foreach ($cart->items as $cartItem) {
                $this->order->items()->updateOrCreate(
                    [
                        'product_id' => $cartItem->product_id,
                    ],
                    [
                        'product_name' => $cartItem->product->name,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $cartItem->product->price,
                        'subtotal' => $cartItem->subtotal,
                    ]
                );
            }
        }
    }

    protected function clearCart(User $user)
    {
        $cart = $user->cart()->with('items')->first();

        if ($cart) {
            $cart->items()->delete();
        }
    }

    protected function loadOrderDetails()
    {
        if ($this->order) {
            $this->order->load(['items.product', 'items.optionValues']);
        }
    }

    public function calculateTotals()
    {
        if (! $this->order || ! $this->order->relationLoaded('items')) {
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
