<?php

namespace App\Shared\Aggregate;


use App\Shared\Event\DomainEventInterface;

abstract class AggregateRoot
{
    protected array $domainEvents;

    public function addDomainEvent(DomainEventInterface $event): self
    {
        $this->domainEvents[] = $event;

        return $this;
    }

    public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        
        $this->domainEvents = [];
        
        return $domainEvents;
    }
}