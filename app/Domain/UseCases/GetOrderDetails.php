<?php

namespace App\Domain\UseCases;

use App\Domain\DTO\OrderDetailsDTO;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\OrderProductRepository;
use App\Domain\Repositories\OrderStatusRepository;
use App\Domain\Repositories\CustomerRepository;

class GetOrderDetails
{
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private OrderStatusRepository $statusRepository;
    private CustomerRepository $customerRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderProductRepository $orderProductRepository,
        OrderStatusRepository $statusRepository,
        CustomerRepository $customerRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->statusRepository = $statusRepository;
        $this->customerRepository = $customerRepository;
    }

    public function execute(int $orderId): OrderDetailsDTO
    {
        $order = $this->orderRepository->findById($orderId);
        if (!$order) {
            throw new \Exception('Order not found');
        }

        $products = $this->orderProductRepository->findByOrderId($orderId);
        $status = $this->statusRepository->findById($order->getStatusId());
        $customer = $this->customerRepository->findById($order->getCustomerId());

        return new OrderDetailsDTO(
            id: $order->getId(),
            uniqueIdentifier: $order->getUniqueIdentifier(),
            customerEmail: $customer ? $customer->getEmail() : 'Unknown',
            statusName: $status ? $status->getName() : 'Unknown',
            totalAmount: $order->getTotalAmount(),
            totalProducts: $order->getTotalProducts(),
            products: $products
        );
    }
}
