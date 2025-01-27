<?php

namespace App\Filament\App\Resources\TicketResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketresponsesRelationManager extends RelationManager
{
    protected static string $relationship = 'ticketresponses';
    protected static ?string $modelLabel = 'Tratativa';
    protected static ?string $modelLabelPlural = "Tratativas";
    protected static ?string $title = 'Tratativa do Ticket';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d/m/Y H:i'),


            ])

            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
