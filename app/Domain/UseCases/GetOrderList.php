<?php

namespace App\Domain\UseCases;

use App\Domain\DTO\OrderListItemDTO;
use App\Domain\Repositories\CustomerRepository;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\OrderStatusRepository;

class GetOrderList
{
    private OrderRepository $orderRepository;
    private CustomerRepository $customerRepository;
    private OrderStatusRepository $statusRepository;

    public function __construct(
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        OrderStatusRepository $statusRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->statusRepository = $statusRepository;
    }

    public function execute(?int $statusId = null): array
    {
        $orders = [];

        if ($statusId === null) {
            $orders = $this->orderRepository->getAll();
        } else {
            $orders = $this->orderRepository->getByStatusId($statusId);
        }
        $customers = $this->customerRepository->getAll();
        $statuses = $this->statusRepository->getAll();

        $result = [];

        foreach ($orders as $order) {
            $customerEmail = 'Unknown';
            $statusName = 'Unknown';

            foreach ($customers as $customer) {
                if ($customer->getId() === $order->getCustomerId()) {
                    $customerEmail = $customer->getEmail();
                    break;
                }
            }

            foreach ($statuses as $status) {
                if ($status->getId() === $order->getStatusId()) {
                    $statusName = $status->getName();
                    break;
                }
            }

            $result[] = new OrderListItemDTO(
                id: $order->getId(),
                uniqueIdentifier: $order->getUniqueIdentifier(),
                customerEmail: $customerEmail,
                statusName: $statusName,
                totalAmount: $order->getTotalAmount(),
                totalProducts: $order->getTotalProducts()
            );
        }

        return $result;
    }
}
