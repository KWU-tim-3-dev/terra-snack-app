<?php

namespace App\Filament\Stand\Resources\Orders\Pages;

use App\Filament\Stand\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public function mount(): void
    {
        parent::mount();
        
        $draftData = session('order_draft_data');
        if ($draftData && is_array($draftData)) {
            $this->form->fill($draftData);
        }
    }

    public function updatedData(): void
    {
        $this->saveFormDraft();
    }

    public function saveFormDraft(): void
    {
        try {
            $formData = $this->data;
            session(['order_draft_data' => $formData]);
        } catch (\Exception $e) {
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
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

        // Hitung total price jika kosong
        if (empty($data['total_price']) && !empty($this->cachedItems)) {
            $totalPrice = 0;
            foreach ($this->cachedItems as $item) {
                $totalPrice += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
            $data['total_price'] = $totalPrice + $toppingFee + $packagingFee;
        }

        $data['user_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'pending';
        $data['payment_status'] = $data['payment_status'] ?? 'unpaid';
        $data['gross_amount'] = $data['total_price'];
        $data['packaging_fee_per_item'] = $usePackaging ? 1000 : 0;
        $data['packaging_fee_total'] = $packagingFee;

        $this->paymentMethod = $data['payment_method'] ?? 'cash';

        unset($data['items']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $order = parent::handleRecordCreation($data);
        $this->createdOrder = $order;

        if (!empty($this->cachedItems)) {
            $vegetable = $data['vegetable'] ?? 'none';
            $topping = $data['topping'] ?? 'none';
            $sauce = $data['sauce'] ?? 'none';

            foreach ($this->cachedItems as $item) {
                $item['vegetable'] = $vegetable;
                $item['topping'] = $topping;
                $item['sauce'] = $sauce;

                $productName = $this->generateProductName($item);
                $unitPrice = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $subtotal = $unitPrice * $quantity;

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

        // Hapus draft setelah berhasil dibuat
        session()->forget('order_draft_data');

        return $order;
    }

    protected function afterCreate(): void
    {
        $order = $this->record->fresh();
        $this->createdOrder = $order;

        if ($this->paymentMethod === 'qris') {
            $this->halt();
            $this->mountAction('confirmQrisPayment');
            return;
        }

        if ($this->paymentMethod === 'transfer') {
            $this->halt();
            $this->mountAction('confirmTransferPayment');
            return;
        }

        Notification::make()
            ->title('Pesanan berhasil dibuat!')
            ->success()
            ->send();
    }

    protected function getActions(): array
    {
        return [
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
                            // Hapus draft ketika dibatalkan
                            session()->forget('order_draft_data');
                        })
                )
                ->modalWidth('lg')
                ->action(function () {
                    $order = $this->createdOrder ?? $this->getRecord();

                    if ($order) {
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
                            session()->forget('order_draft_data');
                        })
                )
                ->modalWidth('lg')
                ->action(function () {
                    $order = $this->createdOrder ?? $this->getRecord();

                    if ($order) {
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

    protected function generateProductName(array $item): string
    {
        $type = $item['product_type'] ?? 'Item';

        if ($type === 'snack') {
            $parts = [ucfirst($type)];

            if (!empty($item['vegetable']) && $item['vegetable'] !== 'none') {
                $parts[] = ucfirst($item['vegetable']);
            }

            if (!empty($item['topping']) && $item['topping'] !== 'none') {
                $parts[] = ucfirst($item['topping']);
            }

            if (!empty($item['sauce']) && $item['sauce'] !== 'none') {
                $parts[] = ucfirst($item['sauce']);
            }

            return implode(' - ', $parts);
        }

        return ucfirst($type);
    }

    protected function getRedirectUrl(): string
    {
        session()->forget('order_draft_data');
        return $this->getResource()::getUrl('index');
    }

    public function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->action(function () {
                session()->forget('order_draft_data');
                $this->redirect($this->getResource()::getUrl('index'));
            });
    }

    private array $cachedItems = [];
    private string $paymentMethod = 'cash';
    private ?Order $createdOrder = null;
}