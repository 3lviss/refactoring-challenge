<?php

namespace App\Services;

class Permissions
{
    const READ = 'read';
    const WRITE = 'write';
    const ALL = 'all';

    private array $permissions;

    public function __construct(array $permissions = [])
    {
        $this->permissions = $permissions;
    }

    public function toArray(): array
    {
        return $this->permissions;
    }

    public static function create(array $permissions): self
    {
        return new self($permissions);
    }

    public static function serialize($permissions)
    {
        if ($permissions instanceof self) {
            return serialize($permissions);
        }
        return serialize(new self($permissions));
    }

    public static function fromString($data)
    {
        if (empty($data)) {
            return new self([]);
        }

        $unserialized = @unserialize($data);
        if ($unserialized !== false) {
            if ($unserialized instanceof self) {
                return $unserialized;
            }
            if (is_array($unserialized)) {
                return new self($unserialized);
            }
        }

        return new self([]);
    }
}
