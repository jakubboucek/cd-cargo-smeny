<?php

declare(strict_types=1);

use App\Entity\Day;
use App\Entity\DayEvent;
use App\Helper\DateHelper;
use App\Model\Events;
use JakubBoucek\Escape\Escape as E;

require __DIR__ . '/../app/bootstrap.php';

$daysEvents = (new Events())->getDaysEvents();
bdump($daysEvents);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jakub Bouček - ČD Cargo směny</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0 1em;
            font-family: Arial, sans-serif;
            flex-direction: column;
        }

        table {
            border-collapse: collapse;
            min-width: 300px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>ČD Cargo směny – Jakub Bouček</h1>

<table>
    <thead>
    <tr>
        <th>Den</th>
        <th>Od</th>
        <th>Do</th>
        <th>Popis</th>
    </tr>
    </thead>
    <tbody>
    <?php
    /** @var Day $day */
    foreach ($daysEvents as $range => $day) :
        $rowspan = count($day);
        ?>
        <?php
        /** @var DayEvent $dayEvent */
        foreach ($day as $i => $dayEvent) :
            ?>
            <tr>
                <?php if (!$i): ?>
                    <td rowspan="<?= $rowspan ?>" style="text-align: right">
                        <?= DateHelper::formatCzechDate($day->getDate()) ?>
                    </td>
                <?php endif; ?>

                <?php if ($dayEvent->isAllDayEvent()): ?>
                    <td colspan="2" style="color:gray; text-align: center; cursor: help"
                        title="Celocenní událost a nebo ještě není stanoven čas">
                        ~ ~ ~
                    </td>
                <?php elseif ($dayEvent->isStart()): ?>
                    <td style="font-weight: bold; text-align: right">
                        <?= $dayEvent->getFrom()->format('H:i') ?>
                    </td>
                <?php else: ?>
                    <?php $hmtlTitle = "Vícedenní událost, která má počátek od "
                        . $dayEvent->getFrom()->format('d. n. Y')
                        . " v "
                        . $dayEvent->getFrom()->format('H:i'); ?>
                    <td style="color:gray; text-align: center; cursor: help" title="<?= E::html($hmtlTitle) ?>">
                        ↑
                    </td>
                <?php endif; ?>

                <?php if ($dayEvent->isAllDayEvent()): ?>
                <?php elseif ($dayEvent->isEnd()): ?>
                    <td style="font-weight: bold; text-align: right">
                        <?= $dayEvent->getTo()->format('H:i') ?>
                    </td>
                <?php else: ?>
                    <?php $hmtlTitle = "Vícedenní událost, která má konec až "
                        . $dayEvent->getTo()->format('d. n. Y')
                        . " v "
                        . $dayEvent->getTo()->format('H:i'); ?>
                    <td style="color:gray; text-align: center; cursor: help" title="<?= E::html($hmtlTitle) ?>">
                        ↓
                    </td>
                <?php endif; ?>
                <td><?= E::html($dayEvent->getTitle()) ?></td>
            </tr>
        <?php
        endforeach;
        if (!$rowspan):
            ?>
            <tr>
                <td style="text-align: right"><?= DateHelper::formatCzechDate($day->getDate()) ?></td>
                <td colspan="3" style="text-align: center; font-style: italic; color: gray">
                    (volno)
                </td>
            </tr>
        <?php
        endif;
        ?>

    <?php endforeach; ?>
    </tbody>
</table>

<p><a href="/calendar.html">Celý kalendář směn</a></p>
</body>
</html>

