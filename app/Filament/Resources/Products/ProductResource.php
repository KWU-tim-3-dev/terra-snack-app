<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\ManageProducts;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $set) {
                        if (! empty($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->hint('Slug akan terisi otomatis dari nama produk'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp.'),

                Select::make('customizationOptions')
                    ->label('Customization Options')
                    ->multiple()
                    ->preload()
                    ->relationship('customizationOptions', 'name')
                    ->placeholder('Pilih opsi kustomisasi...')
                    ->helperText('Kamu bisa memilih lebih dari satu opsi.')
                    ->searchable(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image_url')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('customizationOptions')
                    ->label('Opsi Kustomisasi')
                    ->getStateUsing(function (Product $record) {
                        return $record->customizationOptions->pluck('name')->join(', ');
                    })
                    ->wrap(),
                ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->size(70)
                    ->extraImgAttributes(['class' => 'object-cover']),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProducts::route('/'),
        ];
    }
}
