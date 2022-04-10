<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/vendor/autoload.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');

$eventManager = new \XFive\Events\EventManager();
$eventManager->initEvents();