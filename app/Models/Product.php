<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Products\CategoryProductEnum;
use App\Enums\Products\ManufacturerProductEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [

        'description',
        'price',
        'category',
        'image',
        'manufacturer',
    ];

    protected $casts = [
        'category' => CategoryProductEnum::class,
        'image' => 'array',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function iventories():HasMany
    {
        return $this->hasMany(Iventory::class);
    }

    public function getTotalstockAttribute():int

    {
    return $this->iventories->sum('quantity');
    }

    public function getAveragePriceAttribute():float

    {
    $inventories = $this->inventories ?? collect();
    $weightedSum = $inventories->sum(fn($inventory) => $inventory->unit_price * $inventory->quantity);
    $totalQuantity = $this->total_stock;

    return $totalQuantity > 0 ? $weightedSum / $totalQuantity : 0;
    }

    public function invetorytransaction()
    {
        return $this->hasMany(IventoryTransaction::class);
    }
}
