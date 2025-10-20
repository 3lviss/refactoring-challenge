<?php

namespace App\Contracts;

use App\DataObjects\AccessTokenData;

interface AccessTokenRepositoryInterface
{
    public function findByToken(string $token): ?AccessTokenData;
}
