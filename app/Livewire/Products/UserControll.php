<?php

namespace App\Livewire\Products;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Http\Request;

#[Layout('components.layouts.customer')]
class UserControll extends Component
{   
    
    public function render()
    {
        $user = Auth::user();

        if (! $user) {
            abort(404, 'User tidak ditemukan. Untuk testing, buat User ID 1.');
        }

        return view('livewire.products.view', [
            'user' => $user,
        ]);
    }
}
