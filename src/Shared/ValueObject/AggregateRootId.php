<?php

namespace App\Shared\ValueObject;


abstract class AggregateRootId
{
    protected string $uuid;

    public function __construct(string $uuid)
    {
        $this->ensureIsUuidValid($uuid);

        $this->uuid = $uuid;
    }

    protected function ensureIsUuidValid(string $uuid): void
    {
        if (!preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid)) {
            throw new \InvalidArgumentException('UUID is not valid');
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}