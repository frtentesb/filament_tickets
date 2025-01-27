<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;
use Filament\Tables\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Filament\Admin\Resources\UserResource\RelationManagers\UseraddressesRelationManager;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('document_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('avatar_url')
                    ->maxLength(255),
                Forms\Components\TextInput::make('settings'),
                Forms\Components\Toggle::make('is_admin')
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('avatar_url')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean(),
                Tables\Columns\TextColumn::make('email_verified_at')
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

                    ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    Action::make('Resetar Senha')
                        ->requiresConfirmation()
                        ->action(function (User $user) {
                            $newPassword = Str::random(8);
                            // Define a nova senha criptografada
                            $user->password = Hash::make($newPassword);
                            $user->save();
                            // Envia o e-mail com a nova senha
                            Mail::to($user->email)->queue(new PasswordResetMail($newPassword, $user->name));

                            Notification::make()
                                ->title('Senha Alterada com Sucesso')
                                ->body('Um Email foi enviado para o usuário com a nova senha')
                                ->success()
                                ->send();
                        })
                        ->color('warning') // Defina a cor, como amarelo para chamar atenção
                        ->icon('heroicon-o-key'), // Ícone da chave
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
            UseraddressesRelationManager::class,
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
