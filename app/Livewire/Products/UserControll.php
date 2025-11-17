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
        
        $this->dispatch('message', 'User Terdeteksi: '. $user->name . ' (ID: ' . $user->id . ')');

        return view('livewire.products.view', [
            'user' => $user,
        ]);
    }
}
