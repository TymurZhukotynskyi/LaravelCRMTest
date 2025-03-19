<?php

namespace App\Domain\UseCases;

use App\Domain\Entities\Customer;
use App\Domain\Repositories\CustomerRepository;

class CreateCustomer
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function execute(string $firstName, string $lastName, string $email): Customer
    {
        // Створюємо клієнта з мінімальними даними
        $customer = Customer::createWithMinimalData(
            0, // ID буде згенеровано репозиторієм
            $firstName,
            $lastName,
            $email
        );

        // Зберігаємо клієнта через репозиторій
        return $this->customerRepository->save($customer);
    }
}
