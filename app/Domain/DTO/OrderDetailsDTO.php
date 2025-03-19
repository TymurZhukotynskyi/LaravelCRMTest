<?php

namespace App\Domain\DTO;

use App\Domain\Entities\OrderProduct;

class OrderDetailsDTO
{
    /**
     * @param OrderProduct[] $products
     */
    public function __construct(
        public readonly int $id,
        public readonly string $uniqueIdentifier,
        public readonly string $customerEmail,
        public readonly string $statusName,
        public readonly float $totalAmount,
        public readonly int $totalProducts,
        public readonly array $products
    ) {}
}
