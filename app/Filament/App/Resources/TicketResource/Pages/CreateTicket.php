<?php

namespace App\Filament\App\Resources\TicketResource\Pages;

use App\Filament\App\Resources\TicketResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }
    protected function afterCreate(): void
    {
        $ticket = $this->record; // Recupera o ticket recém-criado ou atualizado

        // Wallace (Notificação para o usuario logado)
        Notification::make()
            ->title('Chamado Registrado com Sucesso')
            ->body("Seu Chamado de N. {$ticket->id} foi registrado com sucesso. Em breve será respondido pela equipe.")
            ->success()
            ->actions([
                Action::make('Visualizar')
                    ->url(TicketResource::getUrl('view', ['record' => $ticket->id])),

            ])
            ->sendToDatabase(Auth::user()); // Envia para o usuário relacionado ao ticket

        // Wallace (Busca no banco de dados o Usuario administrador)
        $useradmin = User::where('is_admin', true)->first();

        // Wallace (Notificação para Administrador)
        Notification::make()
            ->title('Você recebeu um novo chamado')
            ->body("Seu Chamado de N. {$ticket->id} está aguardando resposta.")
            ->success()
            ->actions([
                Action::make('Visualizar')
                    // Usei o comando php artisan route:list para ver o namespace da rota do Filament.
                    ->url(route('filament.admin.resources.tickets.view', ['record' => $ticket->id])),
            ])
            ->sendToDatabase($useradmin);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
