<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    protected $fillable = [

        'product_id',
        'inventory_id',
        'movement_type',
        'sale_price',
        'date_sale',
        'purchase_price',
        'date_purchase',
    ];

    protected $casts = [
        'sale_price'    => 'integer',
        'date_sale'     => 'datetime',
        'date_purchase' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
