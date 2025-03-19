<?php

namespace App\Domain\UseCases;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepository;

class UpdateOrder
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $id, int $customerId, int $statusId, float $totalAmount, int $totalProducts): Order
    {
        $order = $this->orderRepository->findById($id);
        if (!$order) {
            throw new \Exception("Order with ID $id not found.");
        }

        $order->update($customerId, $statusId, $totalAmount, $totalProducts);
        return $this->orderRepository->save($order);
    }
}
