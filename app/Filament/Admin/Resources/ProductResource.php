<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Manufacturer;
use Filament\Resources\Resource;
use Filament\Forms\Components\Fieldset;
use App\Enums\Tickets\CategoryTicketEnum;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Products\CategoryProductEnum;
use Filament\Support\View\Components\Modal;
use Leandrocfe\FilamentPtbrFormFields\Money;
use App\Enums\Products\ManufacturerProductEnum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'fas-building-columns';
    protected static ?string $navigationGroup = 'Produtos';
    protected static ?string $navigationLabel = 'Produto';
    protected static ?string $modelLabel = 'Protudo';
    protected static ?string $modelLabelPlural = "Produtos";
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Money::make('price')
                    ->default('100,00')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->searchable()
                    ->required()
                    ->validationMessages([
                        'required' => 'O campo categoria é obrigatório.',
                    ])
                    ->options(CategoryProductEnum::class),
                Fieldset::make('Foto do Produto')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Fotos Produto')
                            ->disk('public')
                            ->directory('products')
                            ->uploadingMessage('Carregando fotos...')
                            ->image()
                            ->imageEditor(),

                    ])->columns(1),
                Forms\Components\Select::make('manufacturer')
                    ->searchable()
                    ->required()
                    ->validationMessages([
                        'required' => 'O campo Fabricante é obrigatório.',
                    ])
                    ->options(function () {
                        return Manufacturer::all()->pluck('name', 'name');
                    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('price')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('manufacturer')
                    ->searchable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
