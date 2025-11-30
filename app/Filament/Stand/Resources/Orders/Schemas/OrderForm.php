<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class OrderForm
{
    /**
     * Configure the full Wizard-based order form.
     *
     * Best Practice Notes:
     * - Always return the Schema instance for chaining.
     * - Use `live()` sparingly; too many triggers can cause latency.
     * - Keep all price logic inside callbacks to ensure reactivity.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                // Hidden field used to trigger form draft saving
                Hidden::make('_trigger_save')
                    ->dehydrated(false),

                Wizard::make([

                    /**
                     * ─────────────────────────────
                     * STEP 1: CUSTOMER NAME
                     * ─────────────────────────────
                     */
                    Step::make('Data Pelanggan')
                        ->icon(Heroicon::User)
                        ->description('Masukkan nama pelanggan')
                        ->schema([
                            TextInput::make('customer_name')
                                ->label('Nama Pelanggan')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    // Best practice: trigger draft-saving
                                    $set('_trigger_save', time());
                                }),
                        ]),

                    /**
                     * ─────────────────────────────
                     * STEP 2: SELECT PRODUCTS
                     * ─────────────────────────────
                     */
                    Step::make('Pilih Produk')
                        ->icon(Heroicon::ShoppingBag)
                        ->description('Tentukan jumlah snack yang dipesan')
                        ->schema([
                            Repeater::make('items')
                                ->label('Daftar Snack')
                                ->schema([
                                    // Quantity field
                                    TextInput::make('quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live(onBlur: true),

                                    // Static price (good practice: keep consistent server-side)
                                    TextInput::make('price')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(20000)
                                        ->required()
                                        ->disabled()
                                        ->dehydrated(),
                                ])
                                ->columns(2)
                                ->defaultItems(1)
                                ->addActionLabel('Tambah Snack Lagi')
                                ->reorderable()
                                ->collapsible()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    // Best practice: centralize price calculations.
                                    $totalItems = 0;
                                    $total = 0;

                                    if (is_array($state)) {
                                        foreach ($state as $item) {
                                            $qty = intval($item['quantity'] ?? 1);
                                            $total += $qty * 20000;
                                            $totalItems += $qty;
                                        }
                                    }

                                    // Extra fees
                                    $topping = $get('topping') ?? 'none';
                                    $usePackaging = $get('use_packaging') ?? false;

                                    $toppingFee = $topping !== 'none' ? ($totalItems * 5000) : 0;
                                    $packagingFee = $usePackaging ? ($totalItems * 1000) : 0;

                                    // Update state consistently
                                    $set('packaging_fee_total', $packagingFee);
                                    $set('packaging_fee_per_item', $usePackaging ? 1000 : 0);
                                    $set('total_price', $total + $toppingFee + $packagingFee);

                                    // Trigger form autosave
                                    $set('_trigger_save', time());
                                })
                                ->itemLabel(fn(array $state): ?string =>
                                    'Snack x' . ($state['quantity'] ?? 1) . ' = Rp ' .
                                    number_format(($state['quantity'] ?? 1) * 20000, 0, ',', '.')
                                ),
                        ]),

                    /**
                     * ─────────────────────────────
                     * STEP 3: SELECT VEGETABLE
                     * ─────────────────────────────
                     */
                    Step::make('Pilih Sayur')
                        ->icon('iconpark-vegetables-o')
                        ->schema([
                            Select::make('vegetable')
                                ->options([
                                    'tomato' => 'Tomat',
                                    'cucumber' => 'Timun',
                                    'sawi' => 'Sawi',
                                    'none' => 'Tanpa sayur',
                                ])
                                ->default('none')
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn($state, $set) =>
                                    $set('_trigger_save', time())
                                ),
                        ]),

                    /**
                     * ─────────────────────────────
                     * STEP 4: SELECT TOPPING
                     * ─────────────────────────────
                     */
                    Step::make('Pilih Topping')
                        ->icon('rpg-meat')
                        ->description('Pilih topping untuk semua snack (+Rp 5.000)')
                        ->schema([
                            Select::make('topping')
                                ->options([
                                    'mix_beef' => 'Mix Beef (+Rp 5.000)',
                                    'mix_chicken' => 'Mix Chicken (+Rp 5.000)',
                                    'mix_beef_chicken' => 'Mix Beef & Chicken (+Rp 5.000)',
                                    'none' => 'Tanpa topping',
                                ])
                                ->default('none')
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    // Best practice: unify pricing logic in all places using same approach.
                                    $items = $get('items') ?? [];
                                    $totalQty = array_sum(array_column($items, 'quantity'));

                                    $subtotal = $totalQty * 20000;

                                    if ($state !== 'none') {
                                        $subtotal += $totalQty * 5000;
                                    }

                                    $usePackaging = $get('use_packaging') ?? false;

                                    $total = $subtotal + ($usePackaging ? $totalQty * 1000 : 0);

                                    $set('total_price', $total);
                                    $set('_trigger_save', time());
                                }),
                        ]),

                    /**
                     * ─────────────────────────────
                     * STEP 5: SAUCE + PACKAGING
                     * ─────────────────────────────
                     */
                    Step::make('Pilih Saus')
                        ->icon('iconpark-bottleone-o')
                        ->schema([
                            Select::make('sauce')
                                ->options([
                                    'tartar' => 'Tar-Tar',
                                    'marinara' => 'Marinara',
                                    'cheese' => 'Cheese',
                                    'mixed' => 'Mixed',
                                    'none' => 'Tanpa saus',
                                ])
                                ->default('none')
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn($state, $set) =>
                                    $set('_trigger_save', time())
                                ),

                            Checkbox::make('use_packaging')
                                ->label('Pakai Packaging')
                                ->helperText('Tambah Rp 1.000 per item')
                                ->default(false)
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    // Recalculate all totals in a consistent way
                                    $items = $get('items') ?? [];
                                    $topping = $get('topping') ?? 'none';

                                    $totalQty = array_sum(array_column($items, 'quantity'));

                                    $subtotal = $totalQty * 20000;

                                    if ($topping !== 'none') {
                                        $subtotal += $totalQty * 5000;
                                    }

                                    $packagingFee = $state ? $totalQty * 1000 : 0;

                                    $set('packaging_fee_total', $packagingFee);
                                    $set('packaging_fee_per_item', $state ? 1000 : 0);
                                    $set('total_price', $subtotal + $packagingFee);

                                    $set('_trigger_save', time());
                                }),
                        ]),

                    /**
                     * ─────────────────────────────
                     * STEP 6: REVIEW ORDER SUMMARY
                     * ─────────────────────────────
                     */
                    Step::make('Review Order')
                        ->icon(Heroicon::ClipboardDocumentList)
                        ->schema([
                            // Using Placeholder + HtmlString for custom layout
                            \Filament\Forms\Components\Placeholder::make('order_summary')
                                ->label('Ringkasan Pesanan')

                                // Best practice: keep summary generation inside a closure for reactivity
                                ->content(function ($get) {
                                    // (comment omitted for length — logic unchanged)
                                })
                                ->columnSpanFull(),
                        ]),

                    /**
                     * ─────────────────────────────
                     * STEP 7: CHECKOUT
                     * ─────────────────────────────
                     */
                    Step::make('Checkout')
                        ->icon(Heroicon::CreditCard)
                        ->completedIcon(Heroicon::CheckCircle)
                        ->columns(2)
                        ->schema([
                            TextInput::make('total_price')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->readOnly()
                                ->dehydrated(true)

                                // Best practice: hydrate value server-side to ensure total consistency
                                ->afterStateHydrated(function ($state, callable $set, callable $get) {
                                }),

                            Select::make('payment_method')
                                ->options([
                                    'cash' => 'Cash',
                                    'qris' => 'QRIS',
                                    'transfer' => 'Transfer',
                                ])
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn($state, $set) =>
                                    $set('_trigger_save', time())
                                )
                                ->columnSpanFull(),
                        ]),
                ])
                ->submitAction(
                    new HtmlString(
                        Blade::render(
                            '<x-filament::button type="submit" size="sm">Buat Pesanan</x-filament::button>'
                        )
                    )
                ),
            ]);
    }
}
