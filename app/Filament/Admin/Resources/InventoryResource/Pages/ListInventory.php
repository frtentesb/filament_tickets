<?php

namespace App\Filament\Admin\Resources\InventoryResource\Pages;

use App\Filament\Admin\Resources\InventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventory extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
