<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use App\Enums\Tickets\StatusTicketEnum;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Tickets\CategoryTicketEnum;
use App\Enums\Tickets\PriorityTicketEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
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


//Função para permitir que o Usuarui logado veja apenas os seus tickets
//Administrador poderá ver todos os tickes tanto no painel App quanto no painel Admin
protected static function booted()
    {
        static::addGlobalScope('user_tickets', function (Builder $builder) {
            // Aplica a lógica apenas para usuários não administradores
            if (Auth::check() && !Auth::user()->is_admin) {
                if ($builder instanceof \Illuminate\Database\Eloquent\Builder) {
                    $builder->where('user_id', Auth::user()->id);
                } else {
                    // Trata o caso em que $builder não é uma instância de Builder
                    // Por exemplo, você pode lançar uma exceção ou registrar um erro
                    throw new \Exception('Instância de construtor inválida');
                }
            }
        });
    }

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);

}

public function ticketresponses(): HasMany
{
    return $this->hasMany(TicketResponse::class, 'ticket_id');
}


}
