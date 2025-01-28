<?php

namespace App\Enums\Products;

use Filament\Support\Contracts\HasLabel;

enum CategoryProductEnum: string implements HasLabel
{
    // Wallace (Retidado os espaços em branco para economizar tamanho de arquivo)
    case PROCESSOR     = 'processor';
    case MOTHERBOARD   = 'motherboard';
    case SSD           = 'SSD';
    case NVME          = 'NVME';
    case GRAPHICS_CARD = 'graphic_card';
    case POWER_SUPPLY  = 'power_supply';
    case COOLING       = 'cooling';
    case HEADPHONES    = 'headphones';
    case MEMORY        = 'memory';
    case HARD_DISK     = 'hard_disk';
    case KEYBOARD      = 'keyboard';
    case MOUSE         = 'mouse';
    case MONITOR       = 'monitor';
    case SOFTWARE      = 'software';

    public function getLabel(): string
    {
        return match ($this) {
            self::PROCESSOR     => 'Processador',
            self::MOTHERBOARD   => 'Placa Mãe',
            self::SSD           => 'SSD',
            self::NVME          => 'NVME',
            self::GRAPHICS_CARD => 'Placa de Vídeo',
            self::POWER_SUPPLY  => 'Fonte de Alimentação',
            self::COOLING       => 'Cooling',
            self::HEADPHONES    => 'Fones de Ouvido',
            self::MEMORY        => 'Memoria',
            self::HARD_DISK     => 'Disco Rigido',
            self::KEYBOARD      => 'Teclado',
            self::MOUSE         => 'Mouse',
            self::MONITOR       => 'Monitor',
            self::SOFTWARE      => 'Software',
        };
    }
}
