<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Order;

interface OrderRepository
{
    public function save(Order $order): Order;

    public function findById(int $id): ?Order;

    public function delete(int $id): void;

    public function getAll(): array;

//    public function getByCustomerId(int $customerId);

    public function getByStatusId(int $statusId): array;

    public function findByCustomerId(int $customerId): array;
}
