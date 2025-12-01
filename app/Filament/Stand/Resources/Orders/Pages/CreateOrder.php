<?php

namespace App\Filament\Stand\Resources\Orders\Pages;

use App\Filament\Stand\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

/**
 * CreateOrder Page
 * 
 * Halaman untuk membuat order baru dengan wizard multi-step.
 * Fitur utama:
 * - Auto-save form data ke session saat ada perubahan
 * - Restore form data dan step wizard saat refresh
 * - Clear draft saat order berhasil dibuat atau dibatalkan
 */
class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    /**
     * Session key untuk menyimpan draft data form
     */
    private const SESSION_DRAFT_KEY = 'order_draft_data';

    /**
     * Mount lifecycle hook
     * Dipanggil saat halaman pertama kali dimuat
     * Restore data dan step dari session jika ada
     */
    public function mount(): void
    {
        parent::mount();
        
        // Restore data form dari session
        $draftData = session(self::SESSION_DRAFT_KEY);
        if ($draftData && is_array($draftData)) {
            $this->form->fill($draftData);
        }
    }

    /**
     * Livewire hook: dipanggil setiap kali property $data berubah
     * Trigger auto-save ke session
     */
    public function updatedData(): void
    {
        $this->saveFormDraft();
    }

    /**
     * Save form draft ke session
     * Method ini dipanggil otomatis saat ada perubahan data
     */
    public function saveFormDraft(): void
    {
        try {
            // Simpan form data
            session([self::SESSION_DRAFT_KEY => $this->data]);
        } catch (\Exception $e) {
            // Silent fail - jangan ganggu user experience
        }
    }

    /**
     * Mutate form data sebelum create order
     * Menghitung total price, fees, dan set default values
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Cache items untuk digunakan saat create order items
        $this->cachedItems = $data['items'] ?? [];

        // Hitung topping fee
        $topping = $data['topping'] ?? 'none';
        $toppingFee = 0;
        
        if ($topping !== 'none' && !empty($this->cachedItems)) {
            $totalItems = 0;
            foreach ($this->cachedItems as $item) {
                $totalItems += intval($item['quantity'] ?? 1);
            }
            $toppingFee = $totalItems * 5000;
        }

        // Hitung packaging fee
        $usePackaging = $data['use_packaging'] ?? false;
        $packagingFee = 0;
        
        if ($usePackaging && !empty($this->cachedItems)) {
            $totalItems = 0;
            foreach ($this->cachedItems as $item) {
                $totalItems += intval($item['quantity'] ?? 1);
            }
            $packagingFee = $totalItems * 1000;
        }

        // Hitung total price jika belum ada
        if (empty($data['total_price']) && !empty($this->cachedItems)) {
            $totalPrice = 0;
            foreach ($this->cachedItems as $item) {
                $totalPrice += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
            $data['total_price'] = $totalPrice + $toppingFee + $packagingFee;
        }

        // Set default values
        $data['user_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'pending';
        $data['payment_status'] = $data['payment_status'] ?? 'unpaid';
        $data['gross_amount'] = $data['total_price'];
        $data['packaging_fee_per_item'] = $usePackaging ? 1000 : 0;
        $data['packaging_fee_total'] = $packagingFee;

        // Cache payment method untuk digunakan di afterCreate
        $this->paymentMethod = $data['payment_method'] ?? 'cash';

        // Remove items dari data karena akan disimpan terpisah
        unset($data['items']);

        return $data;
    }

    /**
     * Handle record creation
     * Create order dan order items
     */
    protected function handleRecordCreation(array $data): Model
    {
        // Create order record
        $order = parent::handleRecordCreation($data);
        $this->createdOrder = $order;

        // Create order items
        if (!empty($this->cachedItems)) {
            $vegetable = $data['vegetable'] ?? 'none';
            $topping = $data['topping'] ?? 'none';
            $sauce = $data['sauce'] ?? 'none';

            foreach ($this->cachedItems as $item) {
                // Add customization to each item
                $item['vegetable'] = $vegetable;
                $item['topping'] = $topping;
                $item['sauce'] = $sauce;

                // Generate product name dengan customization
                $productName = $this->generateProductName($item);
                $unitPrice = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $subtotal = $unitPrice * $quantity;

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => null,
                    'product_name' => $productName,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }
        }

        // Clear draft setelah berhasil create order
        $this->clearDraft();

        return $order;
    }

    /**
     * After create lifecycle hook
     * Handle payment method dan tampilkan modal jika perlu
     */
    protected function afterCreate(): void
    {
        $order = $this->record->fresh();
        $this->createdOrder = $order;

        // Jika payment method QRIS, tampilkan modal QRIS
        if ($this->paymentMethod === 'qris') {
            $this->halt();
            $this->mountAction('confirmQrisPayment');
            return;
        }

        // Jika payment method Transfer, tampilkan modal Transfer
        if ($this->paymentMethod === 'transfer') {
            $this->halt();
            $this->mountAction('confirmTransferPayment');
            return;
        }

        // Jika Cash, langsung tampilkan notifikasi sukses
        Notification::make()
            ->title('Pesanan berhasil dibuat!')
            ->success()
            ->send();
    }

    /**
     * Get page actions
     * Define modal actions untuk QRIS dan Transfer payment
     */
    protected function getActions(): array
    {
        return [
            // Modal action untuk QRIS payment
            Action::make('confirmQrisPayment')
                ->modalHeading('Scan QRIS untuk Pembayaran')
                ->modalDescription(function () {
                    $order = $this->createdOrder ?? $this->getRecord();
                    return 'Total Pembayaran: Rp ' . number_format($order?->total_price ?? 0, 0, ',', '.');
                })
                ->modalContent(function () {
                    $order = $this->createdOrder ?? $this->getRecord();
                    return view('filament.pages.qris-payment', [
                        'order_id' => $order?->id ?? 0,
                        'total' => $order?->total_price ?? 0,
                    ]);
                })
                ->modalSubmitActionLabel('Sudah Scan & Bayar')
                ->modalCancelAction(
                    fn ($action) => $action
                        ->label('Batalkan')
                        ->action(function () {
                            // Clear draft saat payment dibatalkan
                            $this->clearDraft();
                        })
                )
                ->modalWidth('lg')
                ->action(function () {
                    $order = $this->createdOrder ?? $this->getRecord();

                    if ($order) {
                        // Update payment status
                        $order->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pembayaran QRIS berhasil!')
                            ->success()
                            ->send();
                    }
                })
                ->closeModalByClickingAway(false),

            // Modal action untuk Transfer payment
            Action::make('confirmTransferPayment')
                ->modalHeading('Transfer Bank untuk Pembayaran')
                ->modalDescription(function () {
                    $order = $this->createdOrder ?? $this->getRecord();
                    return 'Total Pembayaran: Rp ' . number_format($order?->total_price ?? 0, 0, ',', '.');
                })
                ->modalContent(function () {
                    $order = $this->createdOrder ?? $this->getRecord();
                    return view('filament.pages.transfer-payment', [
                        'order_id' => $order?->id ?? 0,
                        'total' => $order?->total_price ?? 0,
                    ]);
                })
                ->modalSubmitActionLabel('Sudah Transfer')
                ->modalCancelAction(
                    fn ($action) => $action
                        ->label('Batalkan')
                        ->action(function () {
                            // Clear draft saat payment dibatalkan
                            $this->clearDraft();
                        })
                )
                ->modalWidth('lg')
                ->action(function () {
                    $order = $this->createdOrder ?? $this->getRecord();

                    if ($order) {
                        // Update payment status
                        $order->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pembayaran Transfer berhasil dikonfirmasi!')
                            ->success()
                            ->send();
                    }
                })
                ->closeModalByClickingAway(false),
        ];
    }

    /**
     * Generate product name dengan customization
     * Format: Snack - Tomat - Mix Beef - Tar-Tar
     */
    protected function generateProductName(array $item): string
    {
        $type = $item['product_type'] ?? 'Item';

        if ($type === 'snack') {
            $parts = [ucfirst($type)];

            // Tambahkan vegetable jika ada
            if (!empty($item['vegetable']) && $item['vegetable'] !== 'none') {
                $parts[] = ucfirst($item['vegetable']);
            }

            // Tambahkan topping jika ada
            if (!empty($item['topping']) && $item['topping'] !== 'none') {
                $parts[] = ucfirst($item['topping']);
            }

            // Tambahkan sauce jika ada
            if (!empty($item['sauce']) && $item['sauce'] !== 'none') {
                $parts[] = ucfirst($item['sauce']);
            }

            return implode(' - ', $parts);
        }

        return ucfirst($type);
    }

    /**
     * Get redirect URL after create
     * Redirect ke index page dan clear draft
     */
    protected function getRedirectUrl(): string
    {
        // Clear draft setelah redirect
        $this->clearDraft();
        return $this->getResource()::getUrl('index');
    }

    /**
     * Override cancel form action
     * Clear draft saat tombol Batal diklik
     */
    public function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->action(function () {
                // Clear draft saat cancel
                $this->clearDraft();
                $this->redirect($this->getResource()::getUrl('index'));
            });
    }

    /**
     * Clear draft data dari session dan localStorage
     * Method ini dipanggil saat:
     * - Order berhasil dibuat
     * - User klik tombol Batal
     * - Payment dibatalkan
     */
    private function clearDraft(): void
    {
        session()->forget([
            self::SESSION_DRAFT_KEY,
        ]);
    }

    /**
     * Cached items untuk digunakan saat create order items
     */
    private array $cachedItems = [];
    
    /**
     * Payment method yang dipilih user
     */
    private string $paymentMethod = 'cash';
    
    /**
     * Created order instance
     */
    private ?Order $createdOrder = null;
}