<?php

namespace App\Livewire\Products;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.customer')]
class UserControll extends Component
{
    public function render()
    {
        $user = Auth::user();

        if (! $user) {
            abort(404, 'User tidak ditemukan. Untuk testing, buat User ID 1.');
        }

        // session()->flash('success', $user->name . ' berhasil masuk.');
        
        // $this->dispatch('productAdded', 'Barang ditambahkan ke keranjang!');

        return view('livewire.products.view', [
            'user' => $user,
        ]);
    }
}
