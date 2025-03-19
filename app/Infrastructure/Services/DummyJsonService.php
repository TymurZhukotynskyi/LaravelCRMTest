<?php

namespace App\Infrastructure\Services;

use App\Domain\Services\CustomerDataProvider;
use App\Infrastructure\Http\API\ApiConnector;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DummyJsonService implements CustomerDataProvider
{
    private ApiConnector $connector;

    public function __construct(ApiConnector $connector)
    {
        $this->connector = $connector;
    }

    public function fetchRandomUserData(): array
    {
        $data = $this->connector->get('users?limit=1&skip=' . rand(0, 99));
        if (empty($data['users'])) {
            return [
                'username' => null,
                'age' => null,
                'phone' => null,
                'birthDate' => null,
            ];
        }

        $user = $data['users'][0];
        return [
            'username' => $user['username'] . '_' . Str::random(8),
            'age' => $user['age'],
            'phone' => formatPhoneNumber($user['phone']),
            'birthDate' => Carbon::make($user['birthDate'])->format('Y-m-d'),
        ];
    }

    public function fetchProducts(int $limit = 10): array
    {
        $attrsString = 'limit=' . $limit . '&skip=' . rand(0, 100);
        $response = $this->connector->get("products?" . $attrsString);
        return $response['products'] ?? [];
    }
}
