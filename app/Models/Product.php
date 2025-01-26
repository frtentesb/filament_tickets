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
    public function iventories(): HasMany
    {
        return $this->hasMany(Iventory::class);
    }

    public function getTotalstockAttribute(): int

    {
        return $this->iventories->sum('quantity');
    }

    public function getAveragePriceAttribute(): float
    {
        // Certifique-se de carregar o relacionamento corretamente
        $iventories = $this->iventories;

        // Verifique se o relacionamento existe e não está vazio
        if (!$iventories || $iventories->isEmpty()) {
            return 0;
        }

        // Calcula a soma ponderada (preço unitário * quantidade)
        $weightedSum = $iventories->sum(fn($iventory) => $iventory->unit_price * $iventory->quantity);

        // Soma das quantidades
        $totalQuantity = $iventories->sum('quantity');

        // Retorna o preço médio ou 0 se não houver estoque
        return $totalQuantity > 0 ? round($weightedSum / $totalQuantity, 2) : 0;
    }

    public function invetorytransaction()
    {
        return $this->hasMany(IventoryTransaction::class);
    }
}
