<?php

namespace App\Filament\Admin\Resources\TicketResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\{Tables};
use Leandrocfe\FilamentPtbrFormFields\Cep;

class UseraddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'useraddresses';

    public function form(Form $form): Form
    {
        return $form

            ->schema([
                Cep::make('zip_code')
                    ->viaCep(
                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.
                        setFields: [
                            'street'     => 'logradouro',
                            'number'     => 'numero',
                            'complement' => 'complemento',
                            'district'   => 'bairro',
                            'city'       => 'localidade',
                            'state'      => 'uf',

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
                Tables\Columns\TextColumn::make('state'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('exibirmapa')
                    ->label('Exibir Mapa')
                    ->icon('fas-map-pin')
                    ->url(fn ($record): string => 'https://www.google.com/maps/search/?api=1&query=' . $record->street . '+' . $record->number . ',' . $record->city . '-' . $record->state)
                    ->openUrlInNewTab(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
