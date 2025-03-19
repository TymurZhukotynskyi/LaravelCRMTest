<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OrderProduct;
use App\Domain\Repositories\OrderProductRepository;
use App\Infrastructure\Models\OrderProduct as EloquentOrderProduct;

class EloquentOrderProductRepository implements OrderProductRepository
{
    public function save(OrderProduct $orderProduct): OrderProduct
    {
        $eloquentOrderProduct = EloquentOrderProduct::find($orderProduct->getId()) ?? new EloquentOrderProduct();
        $eloquentOrderProduct->order_id = $orderProduct->getOrderId();
        $eloquentOrderProduct->external_product_id = $orderProduct->getExternalProductId();
        $eloquentOrderProduct->name = $orderProduct->getName();
        $eloquentOrderProduct->price = $orderProduct->getPrice();
        $eloquentOrderProduct->description = $orderProduct->getDescription();
        $eloquentOrderProduct->quantity = $orderProduct->getQuantity();
        $eloquentOrderProduct->save();

        return new OrderProduct(
            $eloquentOrderProduct->id,
            $eloquentOrderProduct->order_id,
            $eloquentOrderProduct->external_product_id,
            $eloquentOrderProduct->name,
            $eloquentOrderProduct->price,
            $eloquentOrderProduct->description,
            $eloquentOrderProduct->quantity
        );
    }

//    public function findById(int $id): ?OrderProduct;
//
//    public function delete(int $id): void;

    public function findByOrderId(int $orderId): array
    {
        return EloquentOrderProduct::where('order_id', $orderId)
            ->get()
            ->map(function (EloquentOrderProduct $eloquentOrderProduct) {
                return new OrderProduct(
                    $eloquentOrderProduct->id,
                    $eloquentOrderProduct->order_id,
                    $eloquentOrderProduct->external_product_id,
                    $eloquentOrderProduct->name,
                    $eloquentOrderProduct->price,
                    $eloquentOrderProduct->description,
                    $eloquentOrderProduct->quantity
                );
            })->toArray();
    }
}
