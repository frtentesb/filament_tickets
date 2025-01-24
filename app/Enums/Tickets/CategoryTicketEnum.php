<?php

namespace App\Enums\Tickets;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CategoryTicketEnum: string implements HasColor,HasLabel
{

    case SOFTWARE = 'software';
    case NOTEBOOK = 'notebook';
    case DESKTOP = 'desktop';
    case MOBILE_PHONE = 'mobile_phone';
    case NETWORK = 'network';


        //

        public function getLabel(): ?string
        {

                return match ($this) {
                self::SOFTWARE => 'Sistemas',
                self::NOTEBOOK => 'Notebook',
                self::DESKTOP => 'Computador',
                self::MOBILE_PHONE => 'Celular',
                self::NETWORK => 'Redes',
            };
        }

        public function getColor(): ?string
        {
            return match ($this) {
                self::SOFTWARE => 'primary',
                self::NOTEBOOK => 'info',
                self::DESKTOP => 'warning',
                self::MOBILE_PHONE => 'danger',
                self::NETWORK => 'success',


            };
        }
    }
