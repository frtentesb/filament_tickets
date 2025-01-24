<?php

namespace App\Enums\Products;

use Filament\Support\Contracts\HasLabel;

enum CategoryProductEnum: string implements HasLabel
{
        //


    case HARD_DISK = 'hard_disk';
    case MEMORY = 'memory';
    case PROCESSATOR = 'processator';
    case SSD = 'ssd';
    case VIDEO_CARD = 'video_card';
    case HEADPHONES = 'headphones';



    //

    public function getLabel(): ?string
    {

        return match ($this) {
            self::HARD_DISK => 'HD',
            self::MEMORY => 'Memória',
            self::PROCESSATOR => 'Processador',
            self::SSD => 'SSD',
            self::VIDEO_CARD => 'Placa de Vídeo',
            self::HEADPHONES => 'Fones',
        };
    }
}
