<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Models\Customer as EloquentCustomer;
use App\Domain\Entities\Customer as CustomerEntity;
use App\Domain\Repositories\CustomerRepository;

class EloquentCustomerRepository implements CustomerRepository
{
    public function save(CustomerEntity $customer): CustomerEntity
    {
        $eloquentCustomer = $customer->getId() > 0
            ? EloquentCustomer::findOrFail($customer->getId())
            : new EloquentCustomer();

        $eloquentCustomer->external_id = $customer->getExternalId();
        $eloquentCustomer->first_name = $customer->getFirstName();
        $eloquentCustomer->last_name = $customer->getLastName();
        $eloquentCustomer->username = $customer->getUsername();
        $eloquentCustomer->email = $customer->getEmail();
        $eloquentCustomer->age = $customer->getAge();
        $eloquentCustomer->phone = $customer->getPhone();
        $eloquentCustomer->birth_date = $customer->getBirthDate();
        $eloquentCustomer->save();

        return new CustomerEntity(
            $eloquentCustomer->id,
            $eloquentCustomer->external_id,
            $eloquentCustomer->first_name,
            $eloquentCustomer->last_name,
            $eloquentCustomer->username,
            $eloquentCustomer->email,
            $eloquentCustomer->age,
            $eloquentCustomer->phone,
            $eloquentCustomer->birth_date
        );
    }

    public function findById(int $id): ?CustomerEntity
    {
        $eloquentCustomer = EloquentCustomer::find($id);

        if (!$eloquentCustomer) {
            return null;
        }

        return new CustomerEntity(
            $eloquentCustomer->id,
            $eloquentCustomer->external_id,
            $eloquentCustomer->first_name,
            $eloquentCustomer->last_name,
            $eloquentCustomer->username,
            $eloquentCustomer->email,
            $eloquentCustomer->age,
            $eloquentCustomer->phone,
            $eloquentCustomer->birth_date
        );
    }

    public function delete(int $id): void
    {
        EloquentCustomer::destroy($id);
    }

    public function getAll(): array
    {
        $eloquentCustomers = EloquentCustomer::all();
        return $eloquentCustomers->map(function (EloquentCustomer $eloquentCustomer) {
            return new CustomerEntity(
                $eloquentCustomer->id,
                $eloquentCustomer->external_id,
                $eloquentCustomer->first_name,
                $eloquentCustomer->last_name,
                $eloquentCustomer->username,
                $eloquentCustomer->email,
                $eloquentCustomer->age,
                $eloquentCustomer->phone,
                $eloquentCustomer->birth_date
            );
        })->toArray();
    }
}
