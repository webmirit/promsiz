<?php

namespace App\Controller;

use App\Repository\Configurator\FormRepository;
use App\Request\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GladyeController extends AbstractController
{
    private $gladyeRepository;

    public function __construct(FormRepository $repository)
    {
        $this->gladyeRepository = $repository;
    }

    public function getByCategory(Category $request): JsonResponse
    {
        return new JsonResponse(['data' => $this->gladyeRepository->findByCategoryCache($request->getCategory())]);
    }
}
