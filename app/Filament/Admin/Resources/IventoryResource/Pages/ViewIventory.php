<?php

namespace App\Filament\Admin\Resources\IventoryResource\Pages;

use App\Filament\Admin\Resources\IventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIventory extends ViewRecord
{
    protected static string $resource = IventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
