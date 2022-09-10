<?php

define('NEED_AUTH', true);

use App\Repository\Configurator\{
    PackRepository,
    CatalogRepository,
    FormRepository,
    TechRepository
};

use App\Service\Configurator;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Конфигуратор");

$asset = \Bitrix\Main\Page\Asset::getInstance();
$asset->addCss('/local/templates/aspro_next/build/css/main.css');
$asset->addJs('/local/templates/aspro_next/build/js/chunk-vendors-legacy.js');
$asset->addJs('/local/templates/aspro_next/build/js/chunk-vendors.js');
$asset->addJs('/local/templates/aspro_next/build/js/main-legacy.js');
$asset->addJs('/local/templates/aspro_next/build/js/main.js');

$catalogRepository = container()->get(CatalogRepository::class);
$formRepository = container()->get(FormRepository::class);
$techRepository = container()->get(TechRepository::class);
$packRepository = container()->get(PackRepository::class);
//dd($packRepository->findAllPacks());
?>
    <div id="app-configurator">
        <g-configurator
            :categories="<?= htmlspecialchars(json_encode($catalogRepository->findSectionsForConfigurator())); ?>"
            :tech-list="<?= htmlspecialchars(json_encode($techRepository->findAllWithCache())); ?>"
            :form-list="<?= htmlspecialchars(json_encode($formRepository->findAllWithCache())); ?>"
            :pack-type-list="<?= htmlspecialchars(json_encode($packRepository->findTypesOfPack())); ?>"
            :pack-list="<?= htmlspecialchars(json_encode($packRepository->findAllPacks())); ?>"
        ></g-configurator>
    </div>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
