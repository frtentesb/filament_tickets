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
                TextInput::make('zip_code')
                    ->label('CEP')
                    ->required()
                    ->reactive() // Torna o campo dinâmico
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Faz a chamada para o ViaCEP ao atualizar o CEP
                        $viaCepResponse = Http::get("https://viacep.com.br/ws/{$state}/json/");

                        if ($viaCepResponse->ok() && !$viaCepResponse->json('erro')) {
                            $data = $viaCepResponse->json();

                            // Define os valores automaticamente nos campos
                            $set('street', $data['logradouro'] ?? '');
                            $set('district', $data['bairro'] ?? '');
                            $set('city', $data['localidade'] ?? '');
                            $set('state', $data['uf'] ?? '');

                            // Faz uma segunda chamada para obter latitude e longitude com base no endereço completo
                            $address = "{$data['logradouro']}, {$data['localidade']}, {$data['uf']}";
                            $nominatimResponse = Http::withHeaders([
                                'User-Agent' => 'MinhaAplicacao/1.0 (wallacemartinss@gmail.com)',
                            ])->get('https://nominatim.openstreetmap.org/search', [
                                'q' => $address,
                                'format' => 'json',
                                'addressdetails' => 1,
                                'limit' => 1,
                            ]);

                            if ($nominatimResponse->ok() && isset($nominatimResponse[0])) {
                                $location = $nominatimResponse[0];

                                $set('latitude', $location['lat']);
                                $set('longitude', $location['lon']);
                            }
                        }
                    }),
                TextInput::make('street')->label('Rua'),
                TextInput::make('number')->label('Número'),
                TextInput::make('complement')->label('Complemento'),
                TextInput::make('district')->label('Bairro'),
                TextInput::make('city')->label('Cidade'),
                TextInput::make('state')->label('Estado'),
                TextInput::make('latitude')->label('Latitude')->disabled(),
                TextInput::make('longitude')->label('Longitude')->disabled(),
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
