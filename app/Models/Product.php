<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Products\CategoryProductEnum;
use App\Enums\Products\ManufacturerProductEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'name',
        'description',
        'price',
        'category',
        'image',

    ];

    protected $casts = [
        'category' => CategoryProductEnum::class,
        'image' => 'array',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function getTotalstockAttribute(): int

    {
        return $this->inventories->sum('quantity');
    }

    public function getAveragePriceAttribute(): float
    {
        // Certifique-se de carregar o relacionamento corretamente
        $inventories = $this->inventories;

        // Verifique se o relacionamento existe e não está vazio
        if (!$inventories || $inventories->isEmpty()) {
            return 0;
        }

        // Calcula a soma ponderada (preço unitário * quantidade)
        $weightedSum = $inventories->sum(fn($inventory) => $inventory->unit_price * $inventory->quantity);

        // Soma das quantidades
        $totalQuantity = $inventories->sum('quantity');

        // Retorna o preço médio ou 0 se não houver estoque
        return $totalQuantity > 0 ? round($weightedSum / $totalQuantity, 2) : 0;
    }

    public function invetorytransaction()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
