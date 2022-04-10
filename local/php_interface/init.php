<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/vendor/autoload.php');
$eventManager = new \XFive\Events\EventManager();
$eventManager->initEvents();

function p($array,$ignore=false){
    global $USER;
    if ($USER->IsAdmin() || $ignore) {
        echo "<pre>";
            print_r($array);
        echo "</pre>";
    }
}