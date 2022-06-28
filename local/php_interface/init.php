<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');

use Prokl\ServiceProvider\LoadEnvironment;
use Prokl\ServiceProvider\ServiceProvider;
use XFive\Events\EventManager as MuchCrapEventManager;

$loader = new LoadEnvironment($_SERVER['DOCUMENT_ROOT']);
$loader->load();
$loader->process();

try {
    $serviceProvider = new ServiceProvider('local/configs/services.yaml');
} catch (Throwable $e) {
    ShowError($e->getMessage());
}

$eventManager = new MuchCrapEventManager();
$eventManager->initEvents();

