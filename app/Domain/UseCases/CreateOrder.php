<?php

namespace App\Domain\UseCases;

use App\Domain\Entities\Order;
use App\Domain\Repositories\CustomerRepository;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\OrderStatusRepository;

class CreateOrder
{
    private OrderRepository $orderRepository;

    private OrderStatusRepository $orderStatusRepository;

    private CustomerRepository $customerRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderStatusRepository $orderStatusRepository,
        CustomerRepository $customerRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->customerRepository = $customerRepository;
    }

    public function execute(int $customerId, int $statusId): Order
    {
        $customer = $this->customerRepository->findById($customerId);
        if (!$customer) {
            throw new \Exception("Customer with username {$request->input('username')} not found.");
        }

        if (!$this->orderStatusRepository->findById($statusId)) {
            throw new \InvalidArgumentException("Status with ID $statusId does not exist.");
        }

        $order = Order::createNew(
            0,
            $customerId,
            $statusId
        );
        return $this->orderRepository->save($order);
    }
}
