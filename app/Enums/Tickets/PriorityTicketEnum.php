<?php

namespace App\Enums\Tickets;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PriorityTicketEnum: string implements HasColor,HasLabel
{

    case VERY_LOW = 'very_low';
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';
        //

        public function getLabel(): ?string
        {

                return match ($this) {
                self::VERY_LOW => 'Muito Baixo',
                self::LOW => 'Baixo',
                self::MEDIUM => 'Medio',
                self::HIGH => 'Alto',
                self::URGENT => 'Urgente',
            };
        }

        public function getColor(): ?string
        {
            return match ($this) {
                self::VERY_LOW => 'success',
                self::LOW => 'primary',
                self::MEDIUM => 'warning',
                self::HIGH => 'danger',
                self::URGENT => 'danger',
            };
        }
    }
