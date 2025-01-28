<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Appointment;
use Filament\{Forms, Tables};

use App\Models\{Ticket, User};
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\{Builder};
use App\Filament\Admin\Resources\TicketResource\{Pages};
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Forms\Components\{DateTimePicker, Fieldset, FileUpload, Select, TextInput};
use Filament\Tables\Actions\{Action, ActionGroup, DeleteAction, EditAction, ViewAction};
use App\Filament\Admin\Resources\TicketResource\RelationManagers\UseraddressesRelationManager;
use App\Enums\Tickets\{AppoitmentTicketEnum, CategoryTicketEnum, PriorityTicketEnum, StatusTicketEnum};

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'fas-comment-dots';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Tickets';

    protected static ?string $modelLabel = 'Ticket';

    protected static ?string $modelLabelPlural = "Tickets";

    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Classificação do problema')
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->label('Assunto')
                            ->required()
                            ->maxLength(50),

                        Select::make('user_id')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->columns(1),

                        Select::make('priority')
                            ->searchable()
                            ->required()
                            ->options(PriorityTicketEnum::class),

                        Select::make('category')
                            ->searchable()
                            ->required()
                            ->options(CategoryTicketEnum::class),

                        Select::make('status')
                            ->searchable()
                            ->required()
                            ->options(StatusTicketEnum::class),
                    ])->columns(5),

                Fieldset::make('Detalhe do problema')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->required(),
                    ])->columns(1),

                Fieldset::make('Anexos do problema')
                    ->schema([
                        FileUpload::make('attachment_path')
                            ->label('Anexos')
                            ->disk('public')
                            ->directory('tickets')
                            ->multiple()
                            ->uploadingMessage('Carregando as fotos...')
                            ->maxParallelUploads(1),
                    ])->columns(1),

                Fieldset::make('Detalhe do problema')
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->readOnly(),
                        DateTimePicker::make('end_date')
                            ->readOnly(),
                        DateTimePicker::make('closed_at')
                            ->readOnly(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            // Busca as Enuns
                            foreach (StatusTicketEnum::cases() as $enumCase) {
                                // Verifica se a label contém o termo de busca
                                if (str_contains(strtolower($enumCase->getLabel()), strtolower($search))) {
                                    // Busca o valor da enum
                                    $q->orWhere('status', $enumCase->value);
                                }
                            }
                        });
                    }),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            // Busca as Enuns
                            foreach (PriorityTicketEnum::cases() as $enumCase) {
                                // Verifica se a label contém o termo de busca
                                if (str_contains(strtolower($enumCase->getLabel()), strtolower($search))) {
                                    // Busca o valor da enum
                                    $q->orWhere('priority', $enumCase->value);
                                }
                            }
                        });
                    }),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            // Busca as Enuns
                            foreach (CategoryTicketEnum::cases() as $enumCase) {
                                // Verifica se a label contém o termo de busca
                                if (str_contains(strtolower($enumCase->getLabel()), strtolower($search))) {
                                    // Busca o valor da enum
                                    $q->orWhere('category', $enumCase->value);
                                }
                            }
                        });
                    }),
                Tables\Columns\ImageColumn::make('attachment_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('closed_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    Action::make('exibirmapa')
                    ->label('Exibir Mapa')
                    ->icon('fas-map-pin')
                    ->url(function ($record) {
                        // Obter o endereço do usuário associado ao registro
                        $userAddress = $record->useraddresses;

                        // Verificar se o endereço existe
                        if ($userAddress) {
                            $street = urlencode($userAddress->street);
                            $number = urlencode($userAddress->number);
                            $city   = urlencode($userAddress->city);
                            $state  = urlencode($userAddress->state);

                            // Montar a URL do Google Maps
                            return 'https://www.google.com/maps/search/?api=1&query=' . $street . '+' . $number . ',' . $city . '-' . $state;
                        }

                    })
                    ->openUrlInNewTab(),

                    Action::make('criaragendamento')
                    ->label('Criar Agendamento')
                    ->icon('fas-map-pin')
                    ->requiresConfirmation()
                    ->form([
                        Select::make('type_service')
                            ->options(
                            AppoitmentTicketEnum::class
                            ),
                        DateTimePicker::make('date'),
                    ])
                    ->slideOver()
                    ->action(function (Ticket $record, array $data) {
                        $users= $record->user_id;
                       Appointment::create([
                            'ticket_id' => $record->id,
                            'type_service' => $data['type_service'],
                            'date' => $data['date'],
                        ]);

                   Notification::make()
                  ->title('Chamado agendado com sucesso')
                  ->body("Seu Chamado de N. {$record->id} Agendado para " . \Carbon\Carbon::parse($data['date'])->format('d/m/Y H:i:s') . " de forma " . AppoitmentTicketEnum::from($data['type_service'])->getLabel())

                  ->success()
                  ->actions([
                    NotificationAction::make('Visualizar')
                   ->url(route('filament.app.resources.tickets.view', ['record' => $record->id])),

            ])

                  ->sendToDatabase(User::find($users));

                    }),

                ]),

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

            TicketResource\RelationManagers\TicketresponsesRelationManager::class,
            UseraddressesRelationManager::class,
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view'   => Pages\ViewTicket::route('/{record}'),
            'edit'   => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
