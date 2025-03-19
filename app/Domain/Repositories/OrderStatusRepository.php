<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\OrderStatus;

interface OrderStatusRepository
{
    public function findById(int $id): ?OrderStatus;
    public function getAll(): array;
}
