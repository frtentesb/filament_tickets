<?php

namespace App\Enums\Products;

use Filament\Support\Contracts\HasLabel;

enum ManufacturerProductEnum: string implements HasLabel

{
        //


    case ACER = 'acer';
    case KINGSTON = 'kingston';
    case WESTEN_DIGITAL = 'westendigital';
    case GIGABYTE = 'gigabyte';
    case NVIDIA = 'nvidia';
    case ASUS = 'asus';
    case SAMSUNG = 'samsung';
    case INTEL = 'intel';
    //

    public function getLabel(): ?string
    {

        return match ($this) {
            self::ACER => 'Acer',
            self::KINGSTON => 'Kingston',
            self::WESTEN_DIGITAL => 'Westen Digital',
            self::GIGABYTE => 'Gigabyte',
            self::NVIDIA => 'Nvidia',
            self::ASUS => 'Asus',
            self::SAMSUNG => 'Samsung',
            self::INTEL => 'Intel',
        };
    }
}
