<?php

namespace App\TodoList\Shared\Domain;


interface UserIdProviderInterface
{
    public function byUuid(string $uuid): string;
}