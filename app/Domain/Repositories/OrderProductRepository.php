<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\OrderProduct;

interface OrderProductRepository
{
    public function save(OrderProduct $orderProduct): OrderProduct;

//    public function findById(int $id): ?OrderProduct;
//
//    public function delete(int $id): void;

    public function findByOrderId(int $orderId): array;
}
