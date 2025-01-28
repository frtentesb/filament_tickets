<?php

namespace App\Services\Inventory;

use App\Models\{InventoryTransaction};

class InventoryTransactionService
{
    public function recordTransaction($product, $movementType, $price, $date, $inventoryId)
    {
        if ($product && $inventoryId) {
            InventoryTransaction::create([
                'product_id'     => $product->id,
                'inventory_id'   => $inventoryId,
                'movement_type'  => $movementType,
                'purchase_price' => $price,
                'date_purchase'  => $date,
            ]);
        }
    }

}
