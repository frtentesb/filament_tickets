<?php

namespace App\Enums\Tickets;

use Filament\Support\Contracts\{HasLabel};

enum AppoitmentTicketEnum: string implements HasLabel
{
    case PRESENCIAL = 'presencial';
    case REMOTE     = 'remote';

    //

    public function getLabel(): ?string
    {

        return match ($this) {
            self::PRESENCIAL => 'Presencial',
            self::REMOTE     => 'Remoto',

        };
    }

}
