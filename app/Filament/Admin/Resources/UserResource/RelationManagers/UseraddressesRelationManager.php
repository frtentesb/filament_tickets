<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class UseraddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'useraddresses';
    protected static ?string $modelLabel = 'Endereço';
    protected static ?string $modelLabelPlural = "Endereços";
    protected static ?string $title = 'Endereço do Cliente';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Cep::make('zip_code')
                ->viaCep(
                    mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                    errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.
                    setFields: [
                        'street' => 'logradouro',
                        'number' => 'numero',
                        'complement' => 'complemento',
                        'district' => 'bairro',
                        'city' => 'localidade',
                        'state' => 'uf'

                    ]
                ),
            TextInput::make('street'),
            TextInput::make('number'),
            TextInput::make('complement'),
            TextInput::make('district'),
            TextInput::make('city'),
            TextInput::make('state'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('zip_code')
            ->columns([
                    Tables\Columns\TextColumn::make('zip_code')
                    ->searchable()
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('street')
                    ->searchable()
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('complement')
                    ->searchable()
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('district')
                    ->searchable()
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->alignCenter(),
                    Tables\Columns\TextColumn::make('state')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
