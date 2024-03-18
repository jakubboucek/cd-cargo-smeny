<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;
use Redbitcz\DebugMode\Detector;
use Tracy\Debugger;


class Bootstrap
{
    public static function boot(): Configurator
    {
        $configurator = new Configurator;
        $rootDir = dirname(__DIR__);

        $configurator->setDebugMode(Detector::detect());
        $configurator->enableTracy($rootDir . '/log');

        $configurator->setTempDirectory($rootDir . '/temp');

        $configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();

        $configurator->addConfig($rootDir . '/config/common.neon');
        $configurator->addConfig($rootDir . '/config/services.neon');

        return $configurator;
    }
}
