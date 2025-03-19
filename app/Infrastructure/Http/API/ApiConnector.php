<?php

namespace App\Infrastructure\Http\API;

interface ApiConnector
{
    public function get(string $endpoint): array;
}
