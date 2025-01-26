<?php

namespace App\Services\Inventory;


use App\Models\Product;
use App\Models\InventoryTransaction;
use App\Enums\Products\MovimentProductEnum;

class InventoryTransactionService
{
    public function recordTransaction($product, $movementType, $price, $date, $inventoryId)
    {
        if ($product && $inventoryId) {
            InventoryTransaction::create([
                'product_id' => $product->id,
                'inventory_id' => $inventoryId,
                'movement_type' => $movementType,
                'purchase_price' => $price,
                'date_purchase' => $date,
            ]);
        }
    }

}
