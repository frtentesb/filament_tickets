<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Iventory extends Model
{
   protected $fillable = [
        'product_id',
        'name',
        'type',
        'quantity',
        'unit_price',
        'puchase_date',
        'reason',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


}

