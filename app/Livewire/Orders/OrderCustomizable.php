<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Log;

#[Layout('components.layouts.customer')]
class OrderCustomizable extends Component
{
    public Order $order;
    
    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.orders.order-customizable');
    }
}
