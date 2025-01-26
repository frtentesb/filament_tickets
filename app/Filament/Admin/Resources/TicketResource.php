<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use App\Enums\Tickets\StatusTicketEnum;
use Filament\Forms\Components\Fieldset;
use App\Enums\Tickets\CategoryTicketEnum;
use App\Enums\Tickets\PriorityTicketEnum;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Products\CategoryProductEnum;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\TicketResource\Pages;
use App\Filament\Admin\Resources\TicketResource\RelationManagers;

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
                    ])->columns(4),

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
                            ->maxParallelUploads(1)
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
                    ->numeric()
                    ->sortable(),
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

            TicketResource\RelationManagers\TicketresponsesRelationManager::class,
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
