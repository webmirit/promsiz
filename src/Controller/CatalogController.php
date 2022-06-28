<?php

namespace App\Controller;

use App\Repository\Configurator\CatalogRepository;
use App\Request\Form;
use App\Request\FormAndTech;
use App\Request\FormTechPattern;
use App\Request\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends AbstractController
{
    /** @var CatalogRepository */
    private $catalogRepository;

    public function __construct(CatalogRepository $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
    }

    public function getProduct(Product $request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->catalogRepository
                ->findProduct(
                    $request->getCategory(),
                    $request->getFormId(),
                    $request->getTechIds()
                ),
        ]);
    }

    public function getCategoryByFormOrTech(FormAndTech $request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->catalogRepository
                ->findCategoriesByFilter(
                    $request->getFormId(),
                    $request->getTechId()
                ),
        ]);
    }

    public function getSetsByForm(FormTechPattern $form): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->catalogRepository->findSetsByForm($form->getFormId(), $form->getTechId(), $form->getPattern()),
        ]);
    }

    public function getCategoriesWithSets(Request $request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->catalogRepository->findSectionsBySetsCount($request->get('count', 0)),
        ]);
    }

    public function getCategoriesByPackSection(Request $request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->catalogRepository->findSectionsByPacks($request->get('packSection', 0), $request->get('count', 0)),
        ]);
    }

    public function getFormByProductSectionAndPack(Request $request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->catalogRepository->findByProductSectionAndPack(
                $request->get('productSectionId', 0),
                $request->get('packCount', 0),
                $request->get('packSection', 0)
            )
        ]);
    }
}
