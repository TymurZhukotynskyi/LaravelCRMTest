<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): Customer;

    public function findById(int $id): ?Customer;

    public function delete(int $id): void;

    public function getAll(): array;
}
