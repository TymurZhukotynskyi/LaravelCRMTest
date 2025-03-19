<?php

namespace App\Domain\Services;

interface CustomerDataProvider
{
    public function fetchRandomUserData(): array;

    public function fetchProducts(int $limit = 10): array;
}
