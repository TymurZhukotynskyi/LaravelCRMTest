<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepository;
use App\Infrastructure\Models\Order as EloquentOrder;
use App\Infrastructure\Models\Customer as EloquentCustomer;

class EloquentOrderRepository implements OrderRepository
{
    public function save(Order $order): Order
    {
        $eloquentOrder = $order->getId() > 0
            ? EloquentOrder::findOrFail($order->getId())
            : new EloquentOrder();

        $eloquentOrder->customer_id = $order->getCustomerId();
        $eloquentOrder->status_id = $order->getStatusId();
        $eloquentOrder->unique_identifier = $order->getUniqueIdentifier();
        $eloquentOrder->total_amount = $order->getTotalAmount();
        $eloquentOrder->total_products = $order->getTotalProducts();
        $eloquentOrder->save();

        return new Order(
            $eloquentOrder->id,
            $eloquentOrder->customer_id,
            $eloquentOrder->status_id,
            $eloquentOrder->unique_identifier,
            $eloquentOrder->total_amount,
            $eloquentOrder->total_products
        );
    }

    public function findById(int $id): ?Order
    {
        $eloquentOrder = EloquentOrder::find($id);
        if (!$eloquentOrder) {
            return null;
        }

        return new Order(
            $eloquentOrder->id,
            $eloquentOrder->customer_id,
            $eloquentOrder->status_id,
            $eloquentOrder->unique_identifier,
            $eloquentOrder->total_amount,
            $eloquentOrder->total_products
        );
    }

    public function delete(int $id): void
    {
        EloquentOrder::destroy($id);
    }

    public function getAll(): array
    {
        return EloquentOrder::all()->map(function (EloquentOrder $eloquentOrder) {
            return new Order(
                $eloquentOrder->id,
                $eloquentOrder->customer_id,
                $eloquentOrder->status_id,
                $eloquentOrder->unique_identifier,
                $eloquentOrder->total_amount,
                $eloquentOrder->total_products
            );
        })->toArray();
    }

//    public function getByCustomerId(int $customerId)
//    {
//        $eloquentCustomer = EloquentCustomer::where('id', $customerId)->first();
//        if (!$eloquentCustomer) {
//            return null;
//        }
//
//        return new Customer(
//            $eloquentCustomer->id,
//            $eloquentCustomer->external_id,
//            $eloquentCustomer->first_name,
//            $eloquentCustomer->last_name,
//            $eloquentCustomer->username,
//            $eloquentCustomer->email,
//            $eloquentCustomer->age,
//            $eloquentCustomer->phone,
//            $eloquentCustomer->birth_date
//        );
//    }

    public function getByStatusId(int $statusId): array
    {
        $query = EloquentOrder::query();
        if ($statusId !== null) {
            $query->where('status_id', $statusId);
        }

        return $query->get()->map(function (EloquentOrder $eloquentOrder) {
            return new Order(
                $eloquentOrder->id,
                $eloquentOrder->customer_id,
                $eloquentOrder->status_id,
                $eloquentOrder->unique_identifier,
                $eloquentOrder->total_amount,
                $eloquentOrder->total_products
            );
        })->toArray();
    }

    public function findByCustomerId(int $customerId): array
    {
        return EloquentOrder::where('customer_id', $customerId)
            ->get()
            ->map(function (EloquentOrder $eloquentOrder) {
                return new Order(
                    $eloquentOrder->id,
                    $eloquentOrder->customer_id,
                    $eloquentOrder->status_id,
                    $eloquentOrder->unique_identifier,
                    $eloquentOrder->total_amount,
                    $eloquentOrder->total_products
                );
            })->toArray();
    }
}
