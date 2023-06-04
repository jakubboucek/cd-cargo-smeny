<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class SingleEvent implements Event
{
    private string $id;
    private DateTimeInterface $from;
    private DateTimeInterface $to;
    private int $length;
    private string $title;
    private string $description;
    private bool $isAllDayEvent;
    private bool $isOverMidnight;

    public function __construct(
        string $id,
        DateTimeInterface $from,
        DateTimeInterface $to,
        int $length,
        string $title,
        string $description,
        bool $isAllDayEvent,
        bool $isOverMidnight
    ) {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->length = $length;
        $this->title = $title;
        $this->description = $description;
        $this->isAllDayEvent = $isAllDayEvent;
        $this->isOverMidnight = $isOverMidnight;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): DateTimeInterface
    {
        return $this->from;
    }

    public function getTo(): DateTimeInterface
    {
        return $this->to;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isAllDayEvent(): bool
    {
        return $this->isAllDayEvent;
    }

    public function isOverMidnight(): bool
    {
        return $this->isOverMidnight;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from->format(DateTimeInterface::ATOM),
            'to' => $this->from->format(DateTimeInterface::ATOM),
            'length' => $this->length,
            'title' => $this->title,
            'description' => $this->description,
            'isAllDayEvent' => $this->isAllDayEvent,
            'isOverMidnight' => $this->isOverMidnight,
        ];
    }

    public static function fromArray(array $data, DateTimeZone $tz ): self
    {
        return new self(
            $data['id'],
            (new DateTimeImmutable($data['from']))->setTimezone($tz),
            (new DateTimeImmutable($data['to']))->setTimezone($tz),
            $data['length'],
            $data['title'],
            $data['description'],
            $data['isAllDayEvent'],
            $data['isOverMidnight'],
        );
    }
}
