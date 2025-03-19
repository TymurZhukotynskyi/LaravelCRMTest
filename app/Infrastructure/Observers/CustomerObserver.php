<?php

namespace App\Infrastructure\Observers;

use App\Infrastructure\Models\Customer as EloquentCustomer;
use App\Domain\UseCases\UpdateCustomer;
use App\Infrastructure\Services\DummyJsonService;

class CustomerObserver
{
    private UpdateCustomer $updateCustomer;
    private DummyJsonService $dummyJsonService;

    public function __construct(UpdateCustomer $updateCustomer, DummyJsonService $dummyJsonService)
    {
        $this->updateCustomer = $updateCustomer;
        $this->dummyJsonService = $dummyJsonService;
    }

    public function created(EloquentCustomer $customer): void
    {
        $additionalData = $this->dummyJsonService->fetchRandomUserData();

        $this->updateCustomer->execute(
            $customer->id,
            $customer->first_name,
            $customer->last_name,
            $additionalData['username'],
            $customer->email,
            $additionalData['age'],
            $additionalData['phone'],
            $additionalData['birthDate']
        );
    }
}
