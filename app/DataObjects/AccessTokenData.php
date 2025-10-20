<?php

namespace App\DataObjects;

final readonly class AccessTokenData
{
    public function __construct(
        public string $token,
        /** @var string[] */
        public array $permissions = []
    ) {}

    public static function fromArray(array $data): AccessTokenData
    {
        $permissions = $data['permissions'] ?? [];

        if (is_string($permissions)) {
            $decoded = json_decode($permissions, true);
            $permissions = is_array($decoded) ? $decoded : [];
        } elseif (!is_array($permissions)) {
            $permissions = [];
        }

        return new self(
            $data['token'],
            $permissions,
        );
    }
}
