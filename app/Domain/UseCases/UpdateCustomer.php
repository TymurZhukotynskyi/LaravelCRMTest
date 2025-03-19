<?php

namespace App\Domain\UseCases;

use App\Domain\Entities\Customer;
use App\Domain\Repositories\CustomerRepository;

class UpdateCustomer
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function execute(
        int $id,
        string $firstName,
        string $lastName,
        ?string $username,
        string $email,
        ?int $age,
        ?string $phone,
        ?string $birthDate
    ): Customer {
        // Знаходимо клієнта за ID
        $customer = $this->customerRepository->findById($id);
        if (!$customer) {
            throw new \Exception("Customer with ID $id not found.");
        }

        // Оновлюємо дані клієнта
        $customer->update(
            $firstName,
            $lastName,
            $username,
            $email,
            $age,
            $phone,
            $birthDate
        );

        // Зберігаємо оновленого клієнта
        return $this->customerRepository->save($customer);
    }
}
