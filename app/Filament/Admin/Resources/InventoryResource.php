<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InventoryResource\{Pages};
use App\Models\{Inventory};
use Filament\Forms\Components\{DatePicker, Fieldset, Select, TextInput, Textarea};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\{Tables};
use Leandrocfe\FilamentPtbrFormFields\Money;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'fas-truck-moving';

    protected static ?string $navigationGroup = 'Produtos';

    protected static ?string $navigationLabel = 'Estoque';

    protected static ?string $modelLabel = 'Estoque';

    protected static ?string $modelLabelPlural = "Estoque";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('Foto')
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->label('Produto')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantidade')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Money::make('unit_price')
                            ->label('Valor Unitário')
                            ->default('0,00')
                            ->required(),

                        DatePicker::make('puchase_date')
                            ->required()
                            ->label('Data da Compra'),
                    ])->columns(4),

                Fieldset::make('Descrição Opcional')
                    ->schema([
                        Textarea::make('reason')
                            ->label('Descrição')
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantidade em Estoque')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Valor Unitário')
                    ->numeric()
                    ->alignCenter()
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock_value')
                    ->label('Valor em Estoque')
                    ->numeric()
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        // Calcula o valor do estoque multiplicando a quantidade pelo preço unitário
                        return $record->quantity * $record->unit_price;
                    })
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('puchase_date')
                    ->label('Data da Compra')
                    ->alignCenter()
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInventory::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view'   => Pages\ViewInventory::route('/{record}'),
            'edit'   => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
