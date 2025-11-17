<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Log;

#[Layout('components.layouts.customer')] 
class ProductItem extends Component
{
    public Product $product;

    public function mount()
    {
        $this->product->loadMissing('customizationOptions');
    }

    public function addToCart()
    {
        $user = Auth::user() ?? User::find(1);
        if (!$user) {
            abort(500, 'Test user not found.');
        }
        // $user = Auth::user();
        // if (!$user) {
        //     return redirect()->route('login');
        // }

        try {
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

            $cartItem = $cart->items()
                ->where('product_id', $this->product->id)
                ->whereDoesntHave('optionValues')
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
                $newSubtotal = $cartItem->quantity * $cartItem->unit_price;
                $cartItem->update(['subtotal' => $newSubtotal]);

            } else {
                $cart->items()->create([
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'unit_price' => $this->product->price,
                    'subtotal' => $this->product->price,
                ]);
            }

            $this->dispatch('productAdded', 'Barang ditambahkan ke keranjang!');

        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menambahkan barang.');
        }
    }

    public function addToOrder()
    {
        $user = User::find(1);
        if (!$user) {
            abort(500, 'Test user not found.');
        }

        try {
            $order = $user->orders()->firstOrCreate(['user_id' => $user->id, 'status' => 'pending']);

            $orderItem = $order->items()
                ->where('product_id', $this->product->id)
                ->whereDoesntHave('optionValues')
                ->first();

            if ($orderItem) {
                $orderItem->increment('quantity');
                $newSubtotal = $orderItem->quantity * $orderItem->unit_price;
                $orderItem->update(['subtotal' => $newSubtotal]);

            } else {
                $order->items()->create([
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'unit_price' => $this->product->price,
                    'subtotal' => $this->product->price,
                ]);
            }

            $this->dispatch('productAddedToOrder', 'Barang ditambahkan ke pesanan!');

        } catch (\Exception $e) {
            Log::error('Error adding to order: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menambahkan barang ke pesanan.');
        }
    }

    public function render()
    {
        return view('livewire.products.product-item');
    }
}
