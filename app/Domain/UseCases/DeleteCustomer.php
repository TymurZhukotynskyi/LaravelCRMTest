<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\CustomerRepository;

class DeleteCustomer
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function execute(int $id): void
    {
        // Перевіряємо, чи існує клієнт
        $customer = $this->customerRepository->findById($id);
        if (!$customer) {
            throw new \Exception("Customer with ID $id not found.");
        }

        // Видаляємо клієнта
        $this->customerRepository->delete($id);
    }
}
