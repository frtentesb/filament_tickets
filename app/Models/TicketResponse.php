<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketResponse extends Model
{

    protected $fillable = [
        'ticket_id',
        'user_id',
        'description',
        'file',
    ];

    protected $casts = [
        'file' => 'array',
    ];

    protected static function booted()
    {
        // Preenche o user_id apenas no momento da criação
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });

        // Sobrescreve o user_id durante a atualização do modelo
        static::updating(function ($model) {
            $model->user_id = Auth::id();
        });
    }
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
