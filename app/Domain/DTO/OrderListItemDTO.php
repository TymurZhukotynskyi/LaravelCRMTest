<?php

namespace App\Domain\DTO;

class OrderListItemDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $uniqueIdentifier,
        public readonly string $customerEmail,
        public readonly string $statusName,
        public readonly float $totalAmount,
        public readonly int $totalProducts
    ) {}
}
