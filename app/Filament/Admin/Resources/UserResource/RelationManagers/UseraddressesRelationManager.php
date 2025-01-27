<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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
                ->label('CEP')
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

                    ])
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Verifica se o CEP foi preenchido corretamente
                        $address = "{$get('street')}, {$get('number')}, {$get('city')}, {$get('state')}";

                        // Faz a chamada ao Nominatim
                        $nominatimResponse = Http::withHeaders([
                            'User-Agent' => 'MinhaAplicacao/1.0 (seu-email@dominio.com)', // Substitua pelo seu e-mail
                        ])->get('https://nominatim.openstreetmap.org/search', [
                            'q' => $address,
                            'format' => 'json',
                            'addressdetails' => 1,
                            'limit' => 1,
                        ]);

                        if ($nominatimResponse->ok() && isset($nominatimResponse[0])) {
                            $location = $nominatimResponse[0];

                            // Atualiza latitude e longitude
                            $set('latitude', $location['lat']);
                            $set('longitude', $location['lon']);
                        }
                    }),

                TextInput::make('street')->label('Rua'),
                TextInput::make('number')->label('Número')->required(),
                TextInput::make('complement')->label('Complemento'),
                TextInput::make('district')->label('Bairro'),
                TextInput::make('city')->label('Cidade'),
                TextInput::make('state')->label('Estado'),
                TextInput::make('latitude')->label('Latitude')->required()->readOnly(),
                TextInput::make('longitude')->label('Longitude')->required()->readOnly(),
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
