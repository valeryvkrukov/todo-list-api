<?php

namespace TodoList\Shared\ValueObject;


class UserValueObject extends AggregateRootId
{
    protected function ensureIsUuidValid(string $uuid): void
    {
        if (!preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid)) {
            throw new \InvalidArgumentException('UUID is not valid');
        }
    }
}