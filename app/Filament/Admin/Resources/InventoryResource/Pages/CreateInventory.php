<?php

namespace App\Filament\Admin\Resources\InventoryResource\Pages;

use App\Enums\Products\MovimentProductEnum;
use App\Filament\Admin\Resources\InventoryResource;
use App\Models\Product;
use App\Services\Inventory\InventoryTransactionService;
use Filament\Resources\Pages\CreateRecord;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;

    protected function afterCreate(): void
    {
        // $this->record é o objeto Inventory recém-criado
        $inventory = $this->record;

        // Carregar o objeto Product associado ao Inventory
        $product = $inventory->product;  // Assumindo que você tenha um relacionamento 'product' no modelo Inventory

        // Verifique se o produto foi encontrado
        if ($product) {

            $purchase_price = $product->price;
            // Garantir que a data de compra seja convertida para string (formato Y-m-d)
            $purchaseDate = $product->purchase_date
                ? $product->purchase_date->toDateString()  // Se existir, formate a data
                : now()->toDateString();  // Se não, use a data atual como padrão

            // Agora, passamos o objeto Product e os outros valores para o serviço
            $inventoryTransactionService = new InventoryTransactionService();

            // Chame o serviço para registrar a transação
            $inventoryTransactionService->recordTransaction(
                $product,  // Passando o objeto Product
                MovimentProductEnum::IN->value,  // Tipo de movimento (entrada)
                $purchase_price,  // Preço de compra (garantido como int)
                $purchaseDate,  // Data de compra (garantido como string no formato Y-m-d)
                $inventory->id  // Passando o ID do inventory recém-criado
            );
        }
    }
}
