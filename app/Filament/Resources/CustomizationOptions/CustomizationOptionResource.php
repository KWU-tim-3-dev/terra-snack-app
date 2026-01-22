<?php

namespace App\Filament\Resources\CustomizationOptions;

use App\Filament\Resources\CustomizationOptions\Pages\ManageCustomizationOptions;
use App\Models\CustomizationOption;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Str;

class CustomizationOptionResource extends Resource
{
    protected static ?string $model = CustomizationOption::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->afterStateUpdated(function ($state, $set) {
                        if (!empty($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->unique(CustomizationOption::class, 'slug', ignoreRecord: true),
                Select::make('type')
                    ->options([
                        'radio' => 'Radio (Single selection)',
                        'checkbox' => 'Checkbox (Multiple selection)',
                    ])
                    ->required(),
                Repeater::make('optionValues')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('price_modifier')->numeric()->default(0),
                        KeyValue::make('details')->keyLabel('Label')->valueLabel('Value'),
                    ])
                    ->collapsible()
                    ->label('Option Values'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('type')->searchable(),
                TextColumn::make('optionValues_count')
                    ->counts('optionValues')
                    ->label('Option Values'),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
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
            'index' => ManageCustomizationOptions::route('/'),
        ];
    }
}
