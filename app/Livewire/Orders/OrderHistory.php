<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.customer')]
class OrderHistory extends Component
{
    public $orders;

    public function mount()
    {
        $user = User::find(1);
        if (!$user) {
            abort(404, 'Test user (ID 1) not found. Please run tinker to create User ID 1 and its orders.');
        }

        $this->orders = $user->orders()->with(['items.product', 'items.optionValues'])->get();
    }

    public function render()
    {
        return view('livewire.orders.order-history', [
            'orders' => $this->orders,
        ]);
    }
}
