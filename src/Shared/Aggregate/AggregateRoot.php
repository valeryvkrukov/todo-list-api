<?php

namespace TodoList\Shared\Aggregate;


use TodoList\Shared\Event\DomainEventInterface;

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