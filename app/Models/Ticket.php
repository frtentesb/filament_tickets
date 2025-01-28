<?php

namespace App\Models;

use App\Enums\Tickets\{CategoryTicketEnum, PriorityTicketEnum, StatusTicketEnum};
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasManyThrough, HasOne};
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
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
        'status'          => StatusTicketEnum::class,
        'priority'        => PriorityTicketEnum::class,
        'category'        => CategoryTicketEnum::class,
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
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /*

    Explicação detalhada comparando os dois métodos de relacionamento e o que foi feito:

    1. Relacionamento Original: useraddresses

    public function useraddresses(): HasMany
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }

    O relacionamento anterior relacionamento está incorreto, porque o campo user_id na tabela user_addresses não está diretamente relacionado
    à tabela tickets, mas sim à tabela users. Como resultado,
    não é possível acessar corretamente os endereços de um usuário a partir de um ticket,
    já que o modelo Ticket não tem uma relação direta com UserAddress.

    COrreção: Esse método define um relacionamento HasManyThrough entre o modelo Ticket e o modelo UserAddress,
    passando pelo modelo intermediário User. Ele informa ao Laravel que para encontrar os endereços (UserAddress)
    de um ticke

    O ajuste do relacionamento para hasManyThrough corrige o problema de tentar acessar endereços diretamente de Ticket,
    indicando que o caminho correto passa pelo modelo User. Essa mudança respeita a estrutura do banco de dados e
    permite que o Laravel recupere os dados de forma adequada.

    */
    public function userAddresses(): HasManyThrough
    {
        return $this->hasManyThrough(UserAddress::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
    public function appoitments(): HasOne
    {
        return $this->hasOne(Appointment::class);

    }

}
