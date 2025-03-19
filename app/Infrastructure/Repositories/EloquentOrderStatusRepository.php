<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OrderStatus;
use App\Domain\Repositories\OrderStatusRepository;
use App\Infrastructure\Models\OrderStatus as EloquentOrderStatus;

class EloquentOrderStatusRepository implements OrderStatusRepository
{
    public function findById(int $id): ?OrderStatus
    {
        $eloquentStatus = EloquentOrderStatus::find($id);
        if (!$eloquentStatus) {
            return null;
        }

        return new OrderStatus(
            $eloquentStatus->id,
            $eloquentStatus->name
        );
    }

    public function getAll(): array
    {
        return EloquentOrderStatus::all()->map(function (EloquentOrderStatus $eloquentStatus) {
            return new OrderStatus(
                $eloquentStatus->id,
                $eloquentStatus->name
            );
        })->toArray();
    }
}
