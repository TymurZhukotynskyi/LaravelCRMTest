<?php

namespace App\Domain\Entities;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Order
{
    private int $id;
    private int $customerId;
    private int $statusId;
    private string $uniqueIdentifier;
    private float $totalAmount;
    private int $totalProducts;

    public function __construct(
        int $id,
        int $customerId,
        int $statusId,
        string $uniqueIdentifier,
        float $totalAmount,
        int $totalProducts
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->statusId = $statusId;
        $this->uniqueIdentifier = $uniqueIdentifier;
        $this->totalAmount = $totalAmount;
        $this->totalProducts = $totalProducts;
    }

    public function getId(): int { return $this->id; }
    public function getCustomerId(): int { return $this->customerId; }
    public function getStatusId(): int { return $this->statusId; }
    public function getUniqueIdentifier(): string { return $this->uniqueIdentifier; }
    public function getTotalAmount(): float { return $this->totalAmount; }
    public function getTotalProducts(): int { return $this->totalProducts; }

    public function update(int $customerId, int $statusId, float $totalAmount, int $totalProducts): void
    {
        $this->customerId = $customerId;
        $this->statusId = $statusId;
        $this->totalAmount = $totalAmount;
        $this->totalProducts = $totalProducts;

        $this->validate();
    }

    private function validate(): void
    {
        if ($this->customerId <= 0) {
            throw new \InvalidArgumentException('Customer ID must be a positive integer.');
        }

        if ($this->statusId <= 0) {
            throw new \InvalidArgumentException('Status ID must be a positive integer.');
        }

        if ($this->totalAmount < 0) {
            throw new \InvalidArgumentException('Total amount cannot be negative.');
        }

        if ($this->totalProducts < 0) {
            throw new \InvalidArgumentException('Total products cannot be negative.');
        }
    }

    public static function createNew(int $id, int $customerId, int $statusId): self
    {
        $order = new self(
            $id,
            $customerId,
            $statusId,
            'order_' . $customerId . '_' . Str::random(10),
            0.0,
            0
        );

        $order->validateOnCreation();
        return $order;
    }

    private function validateOnCreation(): void
    {
        if ($this->customerId <= 0) {
            throw new \InvalidArgumentException('Customer ID must be a positive integer.');
        }
    }
}
