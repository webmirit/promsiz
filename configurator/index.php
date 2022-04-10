<?php

use App\Service\Configurator;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Конфигуратор");

$asset = \Bitrix\Main\Page\Asset::getInstance();
$asset->addCss('/local/templates/aspro_next/build/css/main.css');
$asset->addJs('/local/templates/aspro_next/build/js/chunk-vendors-legacy.js');
$asset->addJs('/local/templates/aspro_next/build/js/chunk-vendors.js');
$asset->addJs('/local/templates/aspro_next/build/js/main-legacy.js');
$asset->addJs('/local/templates/aspro_next/build/js/main.js');
?>

    <div id="app-configurator">
        <g-configurator></g-configurator>
    </div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>