<?php

namespace App\Filament\Resources\OptionValues;

use App\Filament\Resources\OptionValues\Pages\ManageOptionValues;
use App\Models\OptionValue;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OptionValueResource extends Resource
{
    protected static ?string $model = OptionValue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customization_option_id')
                    ->relationship('customizationOption', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Textarea::make('details')
                    ->label('Details')
                    ->rows(3)
                    ->nullable(),
                TextInput::make('price_modifier')
                    ->required()
                    ->numeric()
                    ->prefix('Rp.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customization_option_id')
                    ->label('Customization Option')
                    ->getStateUsing(function (OptionValue $record) {
                        return $record->customizationOption->name;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('details')
                    ->label('Details')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('price_modifier')
                    ->label('Price Modifier')
                    ->money('idr', true)
                    ->sortable(),
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
            'index' => ManageOptionValues::route('/'),
        ];
    }
}
