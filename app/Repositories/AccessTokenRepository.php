<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AccessTokenRepository
{
    public function findByToken($token)
    {
        return DB::table('access_tokens')
            ->where('token', $token)
            ->first();
    }
}
