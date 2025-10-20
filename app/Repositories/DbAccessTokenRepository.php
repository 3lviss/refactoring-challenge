<?php

namespace App\Repositories;

use App\DataObjects\AccessTokenData;
use App\Contracts\AccessTokenRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DbAccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function findByToken(string $token): ?AccessTokenData
    {
        $accessToken = DB::table('access_tokens')
            ->where('token', $token)
            ->first();

        if (!$accessToken) {
            return null;
        }

        return AccessTokenData::fromArray(
            [
                'token' => $accessToken->token,
                'permissions' => $accessToken->permissions,
            ]
        );
    }
}
