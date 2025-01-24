<?php

namespace App\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\TicketResource;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
