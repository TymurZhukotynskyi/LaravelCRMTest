<?php

namespace App\Infrastructure\Observers;

use App\Infrastructure\Models\Order as EloquentOrder;
use App\Infrastructure\Services\DummyJsonService;
use App\Domain\Entities\OrderProduct;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\OrderProductRepository;

class OrderObserver
{
    private DummyJsonService $dummyJsonService;
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;

    public function __construct(
        DummyJsonService $dummyJsonService,
        OrderRepository $orderRepository,
        OrderProductRepository $orderProductRepository
    ) {
        $this->dummyJsonService = $dummyJsonService;
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    public function created(EloquentOrder $eloquentOrder): void
    {
        $productCount = rand(1, 5);
        $products = $this->dummyJsonService->fetchProducts($productCount);

        $totalAmount = 0.0;
        $totalProducts = 0;

        foreach ($products as $product) {
            $quantity = rand(1, 3); // Випадкова кількість для кожного продукту
            $price = (float) $product['price'];
            $orderProduct = new OrderProduct(
                id: 0, // ID буде присвоєно після збереження
                orderId: $eloquentOrder->id,
                externalProductId: (int) $product['id'],
                name: $product['title'],
                price: $price,
                description: $product['description'] ?? null,
                quantity: $quantity
            );

            $this->orderProductRepository->save($orderProduct);

            $totalAmount += $price * $quantity;
            $totalProducts += $quantity;
        }

        // Оновлюємо Order
        $order = $this->orderRepository->findById($eloquentOrder->id);
        $order->update(
            $order->getCustomerId(),
            $order->getStatusId(),
            $totalAmount,
            $totalProducts
        );
        $this->orderRepository->save($order);
    }
}
