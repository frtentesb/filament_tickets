<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
protected $filalable = [
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

protected $cast = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
    'closed_at' => 'datetime',
    'atachment_path' => 'array',
];
    //
}
