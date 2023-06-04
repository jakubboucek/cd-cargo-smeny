<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

class DayEvent implements Event
{
    private SingleEvent $event;
    private bool $isStart;
    private bool $isEnd;

    public function __construct(SingleEvent $event, bool $isStart, bool $isEnd)
    {
        $this->event = $event;
        $this->isStart = $isStart;
        $this->isEnd = $isEnd;
    }

    public function getEvent(): SingleEvent
    {
        return $this->event;
    }

    public function isStart(): bool
    {
        return $this->isStart;
    }

    public function isEnd(): bool
    {
        return $this->isEnd;
    }

    public function getId(): string
    {
        return $this->event->getId();
    }

    public function getFrom(): DateTimeInterface
    {
        return $this->event->getFrom();
    }

    public function getTo(): DateTimeInterface
    {
        return $this->event->getTo();
    }

    public function getLength(): int
    {
        return $this->event->getLength();
    }

    public function getTitle(): string
    {
        return $this->event->getTitle();
    }

    public function getDescription(): string
    {
        return $this->event->getDescription();
    }

    public function isAllDayEvent(): bool
    {
        return $this->event->isAllDayEvent();
    }

    public function isOverMidnight(): bool
    {
        return $this->event->isOverMidnight();
    }

    public function toArray(): array
    {
        return $this->event->toArray();
    }
}
