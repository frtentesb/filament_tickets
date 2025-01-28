<?php

namespace App\Models;

use App\Enums\Tickets\AppoitmentTicketEnum;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'ticket_id',
        'date',
        'type_service',

    ];

    protected $casts = [

        'date'         => 'datetime',
        'type_service' => AppoitmentTicketEnum::class,
    ];
}
