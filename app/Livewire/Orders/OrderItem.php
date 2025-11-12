<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use Log;
use Livewire\Attributes\Layout;
use App\Models\OrderItem as OrderItemModel;

#[Layout('components.layouts.customer')]
class OrderItem extends Component
{
    public OrderItemModel $orderItem;
    public int $quantity;

    public function mount(OrderItemModel $orderItem)
    {
        $this->orderItem = $orderItem;
        $this->quantity = $orderItem->quantity;

    }

    public function updateQuantity()
    {
        $this->validate(['quantity' => 'required|integer|min:1']);
        try {
            $basePrice = $this->orderItem->unit_price;
            $optionsPrice = $this->orderItem->optionValues->sum('price_modifier');
            $newSubtotal = ($basePrice + $optionsPrice) * $this->quantity;
            $this->orderItem->update([
                'quantity' => $this->quantity,
                'subtotal' => $newSubtotal,
            ]);
            $this->dispatch('orderUpdated');
        } catch (\Exception $e) {
            Log::error('Error updating order item quantity: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal memperbarui jumlah barang.');
        }
    }

    public function incrementQuantity()
    {
        $this->quantity++;
        $this->updateQuantity();
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateQuantity();
        }
    }

    public function removeItem()
    {
        try {
            $this->orderItem->delete();
            $this->dispatch('orderUpdated');
            $this->dispatch('show-success', 'Barang dihapus dari pesanan.');
        } catch (\Exception $e) {
            Log::error('Error removing order item: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menghapus barang dari pesanan.');
        }
    }

    public function render()
    {
        $this->orderItem->loadMissing(['product', 'optionValues']);
        return view('livewire.orders.order-item');
    }
}
