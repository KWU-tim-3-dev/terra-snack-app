<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.customer')]
class CartPage extends Component
{
    public Cart $cart;

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public $subtotal = 0;

    public $packagingFeeTotal = 0;

    public $total = 0;

    public function mount()
    {
        $user = Auth::user();

        if (! $user) {
            abort(404, 'User tidak ditemukan. Untuk testing, buat User ID 1.');
        }
        $this->cart = $user->cart()->firstOrCreate(
            ['user_id' => $user->id]
        );

        $this->loadCartDetails();
        $this->calculateTotals();
    }

    protected function addCartToOrder()
    {
        $user = Auth::user();
        if (! $user) {
            abort(404, 'User tidak ditemukan.');
        }

        if (! $this->cart || $this->cart->items->isEmpty()) {
            session()->flash('error', 'Keranjang kamu kosong.');

        } else {
            $this->createNewOrder();
            $this->insertCartItemsToOrder();
            // $this->clearCart();
            $this->refreshCart();
            session()->flash('success', 'Berhasil menambahkan pesanan dari keranjang.');
        }

    }

    protected function createNewOrder()
    {
        $user = Auth::user();
        $user->orders()->create([
            'total_price' => 0.00,
            'payment_status' => 'unpaid',
        ]);
    }

    protected function insertCartItemsToOrder()
    {
        $user = Auth::user();
        $order = $user->orders()->latest()->first();

        foreach ($this->cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->product->price,
                'subtotal' => $cartItem->subtotal,
            ]);
        }
    }

    public function clearCart()
    {
        $user = Auth::user();
        $user->cart->items()->delete();
    }

    public function refreshCart()
    {
        $this->loadCartDetails();
        $this->calculateTotals();
    }

    public function loadCartDetails()
    {
        if ($this->cart) {
            $this->cart->load(['items.product', 'items.optionValues']);
        }
    }

    public function calculateTotals()
    {
        if (! $this->cart || ! $this->cart->relationLoaded('items')) {
            $this->subtotal = 0;
            $this->packagingFeeTotal = 0;
            $this->total = 0;

            return;
        }

        $this->subtotal = $this->cart->items->sum('subtotal');

        $itemCount = $this->cart->items->sum('quantity');
        $packagingFeePerItem = 1000;

        $this->packagingFeeTotal = $itemCount * $packagingFeePerItem;
        $this->total = $this->subtotal + $this->packagingFeeTotal;
    }

    public function render()
    {
        return view('livewire.cart.cart-page');
    }
}
