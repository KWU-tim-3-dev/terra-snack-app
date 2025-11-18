<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Cart\CartPage;
use App\Livewire\Orders\OrderCustomizable;
use App\Livewire\Orders\OrderPage;
use App\Livewire\History\OrderHistory;
use App\Livewire\History\OrderHistoryPage;
use App\Livewire\Products\ProductCustomize;
use App\Livewire\Products\ProductList;
use App\Livewire\Temp\OrderPaymentPage;
use App\Livewire\Temp\UserControll;
use Illuminate\Support\Facades\Route;

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

Route::get('/orders', OrderPage::class)
    ->middleware('web')
    ->name('orders');

Route::get('/order/{order}/details', OrderPage::class)
    ->middleware('web')
    ->name('order.details');

Route::get('/checkout', OrderHistory::class)
    ->middleware('web')
    ->name('checkout');

Route::get('/orders/history', OrderHistoryPage::class)
    ->middleware('web')
    ->name('orders.history');

Route::get('/getlogin', UserControll::class)
    ->middleware('web')
    ->name('get.login');

Route::get('/payment/{order}', OrderPaymentPage::class)
    ->middleware('web')
    ->name('order.payment');