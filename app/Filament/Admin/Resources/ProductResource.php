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
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Products\CategoryProductEnum;
use Leandrocfe\FilamentPtbrFormFields\Money;
use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use Faker\Provider\ar_EG\Text;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'fas-box-archive';
    protected static ?string $navigationGroup = 'Produtos';
    protected static ?string $navigationLabel = 'Produtos';
    protected static ?string $modelLabel = 'Produto';
    protected static ?string $modelLabelPlural = "Produtos";
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('Produtos')
                ->schema([
                    Forms\Components\Select::make('category')
                    ->searchable()
                    ->required()
                    ->validationMessages([
                        'required' => 'O campo categoria é obrigatório.',
                    ])
                    ->options(CategoryProductEnum::class),
                    Forms\Components\Select::make('manufacturer')
                    ->searchable()
                    ->required()
                    ->validationMessages([
                        'required' => 'O campo Fabricante é obrigatório.',
                    ])
                    ->options(function () {
                        return Manufacturer::all()->pluck('name', 'name');
                    }),
                ])->columns(2),
                Money::make('price')
                ->default('100,00')
                ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),


                Fieldset::make('Foto')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Fotos Produto')
                            ->disk('public')
                            ->directory('products')
                            ->uploadingMessage('Carregando fotos...')
                            ->image()
                            ->imageEditor(),

                    ])->columns(1),


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

                    // Wallace (Seguindo a documentação criei uma query builder para buscar os produtos com base na enum CategoryProductEnum)
                Tables\Columns\TextColumn::make('category')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            // Busca as Enuns
                            foreach (CategoryProductEnum::cases() as $enumCase) {
                                // Verifica se a label contém o termo de busca
                                if (str_contains(strtolower($enumCase->getLabel()), strtolower($search))) {
                                    // Busca o valor da enum
                                    $q->orWhere('category', $enumCase->value);
                                }
                            }
                        });
                    }),

                Tables\Columns\TextColumn::make('manufacturer')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('total_stock')
                    ->getStateUsing(fn ( $record) => $record->total_stock)
                    ->searchable(),

                    Tables\Columns\TextColumn::make('avarage_price')
                    ->getStateUsing(fn ($record) => 'R$ ' . number_format($record->average_price, 2, ',', '.'))



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

                // Wallace (Seguindo a documentação criei um filtro simples para vc ver como faz Filtros com Enum)
                SelectFilter::make('category')
                    ->options(CategoryProductEnum::class),
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
