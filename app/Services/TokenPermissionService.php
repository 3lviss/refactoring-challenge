<?php

namespace App\Services;

use App\DataObjects\PermissionData;

final class TokenPermissionService
{
    /**
     * @param string[] $permissions
     */
    public function hasPermission(array $permissions, string $requestedPermission): PermissionData
    {
        $allowed = match ($requestedPermission) {
            'read'  => in_array('read',  $permissions, true),
            'write' => in_array('write',  $permissions, true),
            'all'   => in_array('all',  $permissions, true),
            default => false,
        };

        return new PermissionData($allowed, $allowed ? $requestedPermission : null);
    }
}
