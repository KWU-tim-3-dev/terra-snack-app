<?php

namespace App\Filament\Stand\Resources\Orders\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

/**
 * OrderForm Schema - 3 Steps Version
 * 
 * Simplified wizard with product-based customization:
 * 1. Produk - Customer name + product list with individual customization
 * 2. Review Order - Summary of all items
 * 3. Checkout - Payment method and total
 */
class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                // Hidden field untuk trigger auto-save
                Hidden::make('_trigger_save')
                    ->dehydrated(false),
                
                Wizard::make([

                    /**
                     * ═══════════════════════════════════════════════════════
                     * STEP 1: PRODUK (Customer Name + Products with Customization)
                     * ═══════════════════════════════════════════════════════
                     */
                    Step::make('Produk')
                        ->icon(Heroicon::ShoppingBag)
                        ->description('Data pelanggan dan pilih produk')
                        ->schema([
                            // Customer Name
                            TextInput::make('customer_name')
                                ->label('Nama Pelanggan')
                                ->placeholder('Masukkan nama pelanggan')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('_trigger_save', time());
                                })
                                ->columnSpanFull(),

                            // Product Repeater dengan customization per-item
                            Repeater::make('items')
                                ->label('Daftar Produk')
                                ->schema([
                                    // Nama Produk
                                    Select::make('product_name')
                                        ->label('Nama Produk')
                                        ->options([
                                            'chitato_sapi_panggang' => 'Chitato Sapi Panggang',
                                            'chitato_lite' => 'Chitato Lite',
                                            'happytos' => 'Happytos',
                                            'chikitwist' => 'Chiki Twist',
                                            'maxicorn' => 'Maxicorn',
                                        ])
                                        ->required()
                                        ->searchable()
                                        ->live()
                                        ->columnSpan(2),

                                    // Jumlah
                                    TextInput::make('quantity')
                                        ->label('Jumlah')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live(onBlur: true)
                                        ->columnSpan(1),

                                    // Harga Satuan (read-only)
                                    TextInput::make('price')
                                        ->label('Harga Satuan')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(20000)
                                        ->required()
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpan(1),

                                    // Sayur
                                    Select::make('vegetable')
                                        ->label('Sayur')
                                        ->options([
                                            'tomato' => 'Tomat',
                                            'cucumber' => 'Timun',
                                            'sawi' => 'Sawi',
                                            'none' => 'Tanpa sayur',
                                        ])
                                        ->default('none')
                                        ->required()
                                        ->columnSpan(1),

                                    // Topping
                                    Select::make('topping')
                                        ->label('Topping')
                                        ->options([
                                            'mix_beef' => 'Mix Beef (+Rp 5.000)',
                                            'mix_chicken' => 'Mix Chicken (+Rp 5.000)',
                                            'mix_beef_chicken' => 'Mix Beef & Chicken (+Rp 5.000)',
                                            'none' => 'Tanpa topping',
                                        ])
                                        ->default('none')
                                        ->required()
                                        ->live()
                                        ->columnSpan(1),

                                    // Saus
                                    Select::make('sauce')
                                        ->label('Saus')
                                        ->options([
                                            'tartar' => 'Tar-Tar',
                                            'marinara' => 'Marinara',
                                            'cheese' => 'Cheese',
                                            'mixed' => 'Mixed',
                                            'none' => 'Tanpa saus',
                                        ])
                                        ->default('none')
                                        ->required()
                                        ->columnSpan(1),

                                    // Packaging per item
                                    Checkbox::make('use_packaging')
                                        ->label('Pakai Packaging (+Rp 1.000)')
                                        ->default(false)
                                        ->live()
                                        ->columnSpan(1),
                                ])
                                ->columns(4)
                                ->defaultItems(1)
                                ->addActionLabel('Tambah Produk Lagi')
                                ->reorderable()
                                ->collapsible()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    // Calculate total price dari semua items
                                    $totalPrice = 0;
                                    $totalPackagingFee = 0;

                                    if (is_array($state)) {
                                        foreach ($state as $item) {
                                            $qty = intval($item['quantity'] ?? 1);
                                            $price = 20000; // Base price
                                            
                                            // Add topping fee
                                            $topping = $item['topping'] ?? 'none';
                                            if ($topping !== 'none') {
                                                $price += 5000;
                                            }
                                            
                                            // Add packaging fee
                                            $usePackaging = $item['use_packaging'] ?? false;
                                            if ($usePackaging) {
                                                $totalPackagingFee += $qty * 1000;
                                            }
                                            
                                            $totalPrice += $qty * $price;
                                        }
                                    }

                                    $set('packaging_fee_total', $totalPackagingFee);
                                    $set('total_price', $totalPrice + $totalPackagingFee);
                                    $set('_trigger_save', time());
                                })
                                ->itemLabel(function (array $state): ?string {
                                    $productName = match($state['product_name'] ?? '') {
                                        'chitato_sapi_panggang' => 'Chitato Sapi Panggang',
                                        'chitato_lite' => 'Chitato Lite',
                                        'happytos' => 'Happytos',
                                        'chikitwist' => 'Chiki Twist',
                                        'maxicorn' => 'Maxicorn',
                                        default => 'Produk',
                                    };
                                    
                                    $qty = $state['quantity'] ?? 1;
                                    $price = 20000;
                                    
                                    // Add topping price
                                    if (($state['topping'] ?? 'none') !== 'none') {
                                        $price += 5000;
                                    }
                                    
                                    $subtotal = $qty * $price;
                                    
                                    return $productName . ' x' . $qty . ' = Rp ' . number_format($subtotal, 0, ',', '.');
                                })
                                ->columnSpanFull(),
                        ]),

                    /**
                     * ═══════════════════════════════════════════════════════
                     * STEP 2: REVIEW ORDER
                     * ═══════════════════════════════════════════════════════
                     */
                    Step::make('Review Order')
                        ->icon(Heroicon::ClipboardDocumentList)
                        ->description('Review pesanan sebelum checkout')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('order_summary')
                                ->label('Ringkasan Pesanan')
                                ->content(function ($get) {
                                    $customerName = $get('customer_name') ?? 'Belum diisi';
                                    $items = $get('items') ?? [];

                                    if (empty($items)) {
                                        return 'Belum ada item yang dipilih';
                                    }

                                    $html = '<div class="space-y-6">';

                                    // Customer Name Section
                                    $html .= '<div class="bg-primary-50 dark:bg-primary-950 p-4 rounded-lg border-2 border-primary-200 dark:border-primary-800">';
                                    $html .= '<div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nama Pelanggan</div>';
                                    $html .= '<div class="text-2xl font-bold text-primary-700 dark:text-primary-300">' . htmlspecialchars($customerName) . '</div>';
                                    $html .= '</div>';

                                    // Items List
                                    $html .= '<div>';
                                    $html .= '<div class="font-semibold text-base text-gray-800 dark:text-gray-200 mb-3">🛒 Daftar Produk</div>';
                                    $html .= '<div class="space-y-3">';
                                    
                                    $grandTotal = 0;
                                    $totalPackaging = 0;
                                    $counter = 1;

                                    $productLabels = [
                                        'chitato_sapi_panggang' => 'Chitato Sapi Panggang',
                                        'chitato_lite' => 'Chitato Lite',
                                        'happytos' => 'Happytos',
                                        'chikitwist' => 'Chiki Twist',
                                        'maxicorn' => 'Maxicorn',
                                    ];

                                    $vegetableLabels = [
                                        'tomato' => 'Tomat',
                                        'cucumber' => 'Timun',
                                        'sawi' => 'Sawi',
                                        'none' => 'Tanpa sayur',
                                    ];

                                    foreach ($items as $item) {
                                        $qty = intval($item['quantity'] ?? 1);
                                        $productName = $productLabels[$item['product_name'] ?? ''] ?? 'Produk';
                                        $vegetable = $vegetableLabels[$item['vegetable'] ?? 'none'] ?? 'Tanpa sayur';
                                        $topping = $item['topping'] ?? 'none';
                                        $sauce = $item['sauce'] ?? 'none';
                                        $usePackaging = $item['use_packaging'] ?? false;
                                        
                                        $price = 20000;
                                        $itemSubtotal = $qty * $price;
                                        
                                        // Calculate topping fee
                                        $toppingFee = 0;
                                        if ($topping !== 'none') {
                                            $toppingFee = $qty * 5000;
                                        }
                                        
                                        // Calculate packaging fee
                                        $packagingFee = 0;
                                        if ($usePackaging) {
                                            $packagingFee = $qty * 1000;
                                            $totalPackaging += $packagingFee;
                                        }
                                        
                                        $itemTotal = $itemSubtotal + $toppingFee + $packagingFee;
                                        $grandTotal += $itemTotal;

                                        $html .= '<div class="bg-white dark:bg-gray-900 p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-sm">';
                                        $html .= '<div class="flex justify-between items-start mb-3">';
                                        $html .= '<div class="flex-1">';
                                        $html .= '<div class="font-bold text-lg text-gray-900 dark:text-gray-100">#' . $counter . ' - ' . $productName . '</div>';
                                        $html .= '<div class="text-sm text-gray-600 dark:text-gray-400 mt-1">';
                                        $html .= '<span class="font-medium">' . $qty . ' pcs</span> × Rp ' . number_format($price, 0, ',', '.');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-right">';
                                        $html .= '<div class="text-xl font-bold text-primary-600 dark:text-primary-400">';
                                        $html .= 'Rp ' . number_format($itemTotal, 0, ',', '.');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        // Customization details
                                        $html .= '<div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">';
                                        $html .= '<div class="bg-gray-50 dark:bg-gray-800 p-2 rounded">';
                                        $html .= '<span class="font-semibold">Sayur:</span> ' . $vegetable;
                                        $html .= '</div>';
                                        $html .= '<div class="bg-gray-50 dark:bg-gray-800 p-2 rounded">';
                                        $html .= '<span class="font-semibold">Topping:</span> ' . ($topping !== 'none' ? ucfirst(str_replace('_', ' ', $topping)) : 'Tanpa');
                                        if ($toppingFee > 0) {
                                            $html .= ' <span class="text-green-600">(+Rp ' . number_format($toppingFee, 0, ',', '.') . ')</span>';
                                        }
                                        $html .= '</div>';
                                        $html .= '<div class="bg-gray-50 dark:bg-gray-800 p-2 rounded">';
                                        $html .= '<span class="font-semibold">Saus:</span> ' . ($sauce !== 'none' ? ucfirst($sauce) : 'Tanpa');
                                        $html .= '</div>';
                                        $html .= '<div class="bg-gray-50 dark:bg-gray-800 p-2 rounded">';
                                        $html .= '<span class="font-semibold">Packaging:</span> ' . ($usePackaging ? 'Ya (+Rp ' . number_format($packagingFee, 0, ',', '.') . ')' : 'Tidak');
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        $html .= '</div>';
                                        $counter++;
                                    }

                                    $html .= '</div></div>';

                                    // Total Summary
                                    $html .= '<div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-950 dark:to-primary-900 p-5 rounded-lg border-2 border-primary-300 dark:border-primary-700">';
                                    $html .= '<div class="font-semibold text-base text-gray-800 dark:text-gray-200 mb-4">💰 Total Pembayaran</div>';
                                    $html .= '<div class="flex justify-between items-center">';
                                    $html .= '<span class="text-xl font-bold text-gray-900 dark:text-gray-100">TOTAL</span>';
                                    $html .= '<span class="text-3xl font-extrabold text-primary-600 dark:text-primary-400">Rp ' . number_format($grandTotal, 0, ',', '.') . '</span>';
                                    $html .= '</div>';
                                    $html .= '</div>';

                                    $html .= '</div>';

                                    return new HtmlString($html);
                                })
                                ->columnSpanFull(),
                        ]),

                    /**
                     * ═══════════════════════════════════════════════════════
                     * STEP 3: CHECKOUT
                     * ═══════════════════════════════════════════════════════
                     */
                    Step::make('Checkout')
                        ->icon(Heroicon::CreditCard)
                        ->completedIcon(Heroicon::CheckCircle)
                        ->schema([
                            TextInput::make('total_price')
                                ->label('Total Harga')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->readOnly()
                                ->dehydrated(true)
                                ->helperText('Total sudah termasuk topping dan packaging')
                                ->columnSpanFull(),

                            Select::make('payment_method')
                                ->label('Metode Pembayaran')
                                ->options([
                                    'cash' => 'Cash',
                                    'qris' => 'QRIS',
                                    'transfer' => 'Transfer',
                                ])
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('_trigger_save', time());
                                })
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button type="submit" size="sm">
                            Buat Pesanan
                        </x-filament::button>
                    BLADE))),
                
                // JavaScript untuk save dan restore wizard step
                ViewField::make('step_saver')
                    ->view('filament.pages.wizard-step-saver')
                    ->dehydrated(false),
            ]);
    }
}