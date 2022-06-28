<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

use App\Controller\{CatalogController, GladyeController, OrderController, PackController};

const API_CONFIGURATOR = 'api_configurator_';

return function (RoutingConfigurator $routes) {
    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_product', '/api/configurator/catalog/getProduct/')
        ->controller([CatalogController::class, 'getProduct'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_sets', '/api/configurator/catalog/getSetsByForm/')
        ->controller([CatalogController::class, 'getSetsByForm'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_category_by_form_or_tech', '/api/configurator/catalog/getCategoryByFormOrTech/')
        ->controller([CatalogController::class, 'getCategoryByFormOrTech'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_sets', '/api/configurator/catalog/getSetsByForm/')
        ->controller([CatalogController::class, 'getSetsByForm'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_sections_for_sets_by_count', '/api/configurator/catalog/getCategoriesWithSets/')
        ->controller([CatalogController::class, 'getCategoriesWithSets'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_sections_by_pack_section', '/api/configurator/catalog/getCategoriesByPackSection/')
        ->controller([CatalogController::class, 'getCategoriesByPackSection'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('form_get_by_category', '/api/configurator/gladye/getByCategory/')
        ->controller([GladyeController::class, 'getByCategory'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('catalog_get_product_cat_and_pack_count', '/api/configurator/catalog/getFormByProductSectionAndPack/')
        ->controller([CatalogController::class, 'getFormByProductSectionAndPack'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('pack_get_by_form', '/api/configurator/pack/getByForm/')
        ->controller([PackController::class, 'getByForm'])
    ;

    $routes
        ->collection(API_CONFIGURATOR)
        ->add('order_handle', '/api/configurator/order/handle/')
        ->controller([OrderController::class, 'handle'])
    ;
};
