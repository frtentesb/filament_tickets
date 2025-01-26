<?php

namespace App\Filament\Admin\Resources\IventoryResource\Pages;

use App\Filament\Admin\Resources\IventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIventories extends ListRecords
{
    protected static string $resource = IventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
