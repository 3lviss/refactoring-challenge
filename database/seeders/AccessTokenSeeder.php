<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessTokenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('access_tokens')->upsert([
            [
                'token'       => 'test-token-01',
                'permissions' => json_encode(["read"]),
            ],
            [
                'token'       => 'test-token-02',
                'permissions' => json_encode(["write","read"]),
            ],
            [
                'token'       => 'test-token-03',
                'permissions' => json_encode([]),
            ],
            [
                'token'       => 'test-token-04',
                'permissions' => json_encode(["all"]),
            ],
        ], ['token'], ['permissions']);
    }
}
