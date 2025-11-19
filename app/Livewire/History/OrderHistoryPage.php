<?php

namespace App\Livewire\History;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.customer')]
class OrderHistoryPage extends Component
{
    public $orders;

    public function mount()
    {
        $user = Auth::user();

        $this->dispatch('message', 'User Terdeteksi: '. $user->name . ' (ID: ' . $user->id . ')');

        $this->orders = $user->orders()
            ->with(['items.product', 'items.optionValues'])
            ->latest()
            ->get();
    }

    public function test(Order $order)
    {
        $this->dispatch('message', 'Clicked order ID: '. $order->id);
        
    }

    public function render()
    {
        return view('livewire.history.history-page');
    }
}
