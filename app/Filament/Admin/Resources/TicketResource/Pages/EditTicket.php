<?php

namespace App\Filament\Admin\Resources\TicketResource\Pages;

use App\Filament\Admin\Resources\TicketResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        $ticket = $this->record->fresh(); // Recarrega o ticket atualizado do banco de dados
        $user   = $ticket->user;
        $status = strtolower(trim($ticket->status->value)); // Normaliza o valor do enum

        if (in_array($status, ['resolved', 'closed'])) {
            $ticket->update(['closed_at' => now()]); // Atualiza diretamente o campo 'closed_at' no banco de dados
        }

        // Buscar a instância do usuário relacionado ao ticket
        $user = $ticket->user;

        if ($user) { // Certifique-se de que o usuário existe
            Notification::make()
                ->title('Chamado Atualizado@@')
                ->body("Seu Chamado de N. {$ticket->id} foi atualizado. Confira as atualizações.")
                ->success()
                ->actions([
                    Action::make('Visualizar')
                        ->url(route('filament.app.resources.tickets.view', ['record' => $ticket->id]))
                        ->button(),
                ])
                ->sendToDatabase($user);
        }
    }
}
