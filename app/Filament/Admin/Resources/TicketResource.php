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
use Filament\Forms\Components\Fieldset;
use App\Enums\Tickets\CategoryTicketEnum;
use App\Enums\Tickets\PriorityTicketEnum;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
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
                Select::make('user_id')
                ->searchable()
                ->required()
                ->options(User::all()->pluck('name', 'id')),
                Fieldset::make('Detalhe do problema')
                ->schema([
                    Forms\Components\RichEditor::make('description')
                        ->required(),
                ])->columns(1),
                Fieldset::make('Classificação do problema')
                ->schema([
                    Forms\Components\Select::make('priority')
                    ->searchable()
                    ->required()
                    ->options(PriorityTicketEnum::class),
                Forms\Components\Select::make('category')
                    ->searchable()
                    ->required()
                    ->options(CategoryTicketEnum::class),


                ])->columns(2),
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
                Forms\Components\DateTimePicker::make('start_date'),
                Forms\Components\DateTimePicker::make('end_date'),
                Forms\Components\DateTimePicker::make('closed_at'),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                ->badge()
                ->searchable(),
                Tables\Columns\TextColumn::make('category')
                ->badge()
                ->searchable(),
                Tables\Columns\ImageColumn::make('attachment_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('closed_at')
                    ->dateTime()
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
