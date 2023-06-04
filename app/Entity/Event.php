<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

interface Event
{
    public function getId(): string;

    public function getFrom(): DateTimeInterface;

    public function getTo(): DateTimeInterface;

    public function getLength(): int;

    public function getTitle(): string;

    public function getDescription(): string;

    public function isAllDayEvent(): bool;

    public function isOverMidnight(): bool;

    public function toArray(): array;
}
