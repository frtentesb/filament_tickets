<?php

namespace App\Models;

use App\Enums\Tickets\StatusTicketEnum;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Tickets\CategoryTicketEnum;
use App\Enums\Tickets\PriorityTicketEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
protected $fillable = [
    'user_id',
    'status',
    'priority',
    'category',
    'description',
    'attachment_path',
    'start_date',
    'end_date',
    'closed_at',

];

protected $casts = [

    'attachment_path' => 'array',
    'status' => StatusTicketEnum::class,
    'priority' => PriorityTicketEnum::class,
    'category' => CategoryTicketEnum::class,


];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);

}

public function ticketresponses(): HasMany
{
    return $this->hasMany(TicketResponse::class, 'ticket_id');
}

    //
}
