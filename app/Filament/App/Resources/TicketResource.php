<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Field;
use App\Enums\Tickets\StatusTicketEnum;
use Filament\Forms\Components\Fieldset;
use App\Enums\Tickets\CategoryTicketEnum;
use App\Enums\Tickets\PriorityTicketEnum;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\TicketResource\Pages;
use App\Filament\App\Resources\TicketResource\RelationManagers;
use App\Filament\App\Resources\TicketResource\RelationManagers\TicketresponsesRelationManager;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        Forms\Components\Select::make('priority')
                            ->label('Prioridade')
                            ->searchable()
                            ->required()
                            ->options(PriorityTicketEnum::class),
                        Forms\Components\Select::make('category')
                            ->label('Categoria')
                            ->searchable()
                            ->required()
                            ->options(CategoryTicketEnum::class),
                    ])->columns(3),

                Fieldset::make('Detalhe do problema')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Detalhes')
                            ->required(),
                    ])->columns(1),

                Fieldset::make('Anexos do problema')
                    ->schema([
                        FileUpload::make('attachment_path')
                            ->label('Anexos')
                            ->disk('public')
                            ->directory('tickets')
                            ->multiple()
                            ->uploadingMessage('Uploading attachment...')
                            ->maxParallelUploads(1),
                    ])->columns(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
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

            TicketresponsesRelationManager::class,



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
