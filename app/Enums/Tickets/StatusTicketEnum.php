<?php

namespace App\Enums\Tickets;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusTicketEnum: string implements HasLabel,HasColor

{

case OPEN = 'open';
case INPROGRESS = 'in_progress';
case PENDING = 'pending';
case CANCELED= 'canceled';
case RESOLVED = 'resolved';
    //

    public function getLabel(): ?string
    {

            return match ($this) {
            self::OPEN => 'Aberto',
            self::INPROGRESS => 'Em Progresso',
            self::PENDING => 'Pendente',
            self::CANCELED => 'Cancelado',
            self::RESOLVED => 'Resolvido',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::OPEN => 'primary',
            self::INPROGRESS => 'warning',
            self::PENDING => 'secondary',
            self::CANCELED => 'danger',
            self::RESOLVED => 'success',
        };
    }
}



