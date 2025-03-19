<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\OrderRepository;

class DeleteOrder
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $id): void
    {
        $order = $this->orderRepository->findById($id);
        if (!$order) {
            throw new \Exception("Order with ID $id not found.");
        }

        $this->orderRepository->delete($id);
    }
}
