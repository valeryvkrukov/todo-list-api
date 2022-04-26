<?php

namespace TodoList\Shared\ValueObject;


abstract class AggregateRootId
{
    protected string $uuid;

    public function __construct(string $uuid)
    {
        $this->ensureIsUuidValid($uuid);

        $this->uuid = $uuid;
    }

    /**
     * @throws \InvalidArgumentException
     */
    abstract protected function ensureIsUuidValid(string $uuid): void;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}