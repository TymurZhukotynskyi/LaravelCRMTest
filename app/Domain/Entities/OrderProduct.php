<?php

namespace App\Domain\Entities;

class OrderProduct
{
    private int $id;
    private int $orderId;
    private int $externalProductId;
    private string $name;
    private float $price;
    private ?string $description;
    private int $quantity;

    public function __construct(
        int $id,
        int $orderId,
        int $externalProductId,
        string $name,
        float $price,
        ?string $description,
        int $quantity
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->externalProductId = $externalProductId;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;

        $this->validate();
    }

    // Геттери
    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getExternalProductId(): int
    {
        return $this->externalProductId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    // Метод для оновлення даних продукту
    public function update(
        string $name,
        float $price,
        ?string $description,
        int $quantity
    ): void {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;

        $this->validate();
    }

    // Приватний метод для валідації
    private function validate(): void
    {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Product name cannot be empty.');
        }

        if ($this->price < 0) {
            throw new \InvalidArgumentException('Price cannot be negative.');
        }

        if ($this->quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be a positive integer.');
        }

        if ($this->orderId <= 0) {
            throw new \InvalidArgumentException('Order ID must be a positive integer.');
        }

        if ($this->externalProductId <= 0) {
            throw new \InvalidArgumentException('External product ID must be a positive integer.');
        }
    }
}
