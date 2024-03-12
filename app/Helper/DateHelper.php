<?php

declare(strict_types=1);

namespace App\Helper;

use DateTimeInterface;

class DateHelper
{
    public const CzechWeekDays = ['Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota'];

    public static function formatCzechDate(DateTimeInterface $date):string
    {
        $weekDay = self::formatCzechDay((int)$date->format('w'));
        $stringDate = $date->format('j. n.');

        return "{$weekDay} {$stringDate}";
    }

    public static function formatCzechDay(int $weekDay): string
    {
        if (!isset(self::CzechWeekDays[$weekDay])) {
            throw new \InvalidArgumentException("{$weekDay} is no valid week day number (expected 0-6).");
        }
        return self::CzechWeekDays[$weekDay];
    }
}
