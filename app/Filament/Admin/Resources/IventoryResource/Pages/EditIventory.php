<?php

namespace App\Filament\Admin\Resources\IventoryResource\Pages;

use App\Filament\Admin\Resources\IventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIventory extends EditRecord
{
    protected static string $resource = IventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
