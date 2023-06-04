<?php

declare(strict_types=1);

use App\Entity\Day;
use JakubBoucek\Escape\Escape as E;

require __DIR__ . '/../app/bootstrap.php';

$daysEvents = (new \App\Model\Events())->getDaysEvents();
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
            margin: 0;
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
        foreach ($day as $i => $dayEvent) :

            ?>
            <tr>
                <?php if (!$i): ?>
                    <td rowspan="<?= $rowspan ?>" style="text-align: right"><?= $day->getDate()->format(
                            'D j. n. Y'
                        ) ?></td>
                <?php endif; ?>

                <?php if ($dayEvent->isStart()): ?>
                <td style="font-weight: bold; text-align: right">
                    <?= $dayEvent->getFrom()->format('H:i') ?>
                </td>
                <?php else: ?>
                <td style="color:gray; text-align: center">
                    ↑
                </td>
                <?php endif; ?>

                <?php if ($dayEvent->isEnd()): ?>
                    <td style="font-weight: bold; text-align: right">
                        <?= $dayEvent->getTo()->format('H:i') ?>
                    </td>
                <?php else: ?>
                    <td style="color:gray; text-align: center">
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
                <td style="text-align: right"><?= $day->getDate()->format('D j. n. Y') ?></td>
                <td colspan="3" style="text-align: center; font-style: italic; color: gray">
                    (volno)
                    <?php if ($range > 3): ?><span style="color: darkred">*</span> <?php endif; ?></td>
            </tr>
        <?php
        endif;
        ?>

    <?php endforeach; ?>
    </tbody>
</table>

<p><small><span style="color: darkred">*</span>
        směny se plánují někdy jen 3 dny dopředu, volno není garantováno.
    </small></p>
<p><a href="/calendar.html">Celý kalendář směn</a></p>
</body>
</html>

