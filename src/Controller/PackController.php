<?php

namespace App\Controller;

use App\Repository\Configurator\PackRepository;
use App\Request\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class PackController extends AbstractController
{
    private $packRepository;

    public function __construct(PackRepository $repository)
    {
        $this->packRepository = $repository;
    }

    public function getByForm(Form $request): JsonResponse
    {
        return new JsonResponse(['data' => $this->packRepository->findPacksByForm($request->getFormId())]);
    }
}
