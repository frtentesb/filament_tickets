<?php

namespace App\Enums\Products;

use Filament\Support\Contracts\HasLabel;

enum MovimentProductEnum: string implements HasLabel
{
    case IN = 'in';
    case OUT = 'out';
    public function getLabel(): ?string
    {
        return match ($this) {
            self::IN => 'Entrada',
            self::OUT => 'Saída',

        };
    }
}
