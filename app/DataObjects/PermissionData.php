<?php

namespace App\DataObjects;

final readonly class PermissionData
{
    public function __construct(
        public bool $hasPermission,
        public ?string $permission
    ) {}
}
