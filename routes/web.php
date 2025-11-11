<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Cart\CartPage;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductCustomize;
use App\Livewire\Orders\CheckoutPage;
use App\Livewire\Orders\OrderHistory;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

use function Termwind\render;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('/cart', CartPage::class)
    ->middleware('web')
    ->name('cart');

Route::get('/products', ProductList::class)
    ->middleware('web')
    ->name('products.list');

Route::get('/products/{product}/customize', ProductCustomize::class)
    ->middleware('web')
    ->name('product.customize');

Route::get('/orders/{order}/checkout', CheckoutPage::class)
    ->middleware('web')
    ->name('orders.checkout');

Route::get('/orders/history', OrderHistory::class)
    ->middleware('web')
    ->name('orders.history');
