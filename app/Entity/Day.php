<?php

declare(strict_types=1);

namespace App\Entity;

use Countable;
use DateTimeInterface;
use IteratorAggregate;
use Traversable;

class Day implements IteratorAggregate, Countable
{
    private DateTimeInterface $date;
    /** @var DayEvent[] */
    private array $events;

    /**
     * @param DateTimeInterface $date
     * @param DayEvent[] $events
     */
    public function __construct(DateTimeInterface $date, array $events)
    {
        $this->date = $date;
        $this->events = $events;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return iterable<DayEvent>
     */
    public function getEvents(): iterable
    {
        return $this->events;
    }

    /**
     * @return Traversable<DayEvent>
     */
    public function getIterator(): Traversable
    {
        yield from $this->getEvents();
    }

    public function count(): int
    {
        return count($this->events);
    }


}
