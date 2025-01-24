<?php

namespace App\Filament\Admin\Resources\ManufacturerResource\Pages;

use App\Filament\Admin\Resources\ManufacturerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageManufacturers extends ManageRecords
{
    protected static string $resource = ManufacturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
