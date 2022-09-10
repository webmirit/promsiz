<?php

declare(strict_types=1);

namespace App\Controller;

use App\Event\NewOrder;
use App\Repository\Configurator\LetterRepository;
use App\Request\Order;
use App\Service\TemplateService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OrderController extends AbstractController
{
    /**
     * @var LetterRepository
     */
    private $letterRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /** @var TemplateService @ */
    private $templateService;

    public function __construct(
        TemplateService          $templateService,
        LetterRepository         $letterRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->letterRepository = $letterRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->templateService = $templateService;
    }

    /**
     * @throws Exception
     */
    public function handle(Order $request): JsonResponse
    {
        $template = $this->templateService->render('order/new.php', $request->toArray());
        $this->letterRepository->addLetter($template);
        $this->eventDispatcher->dispatch((new NewOrder(compact('template')))->mail(), NewOrder::class);
        return new JsonResponse(['success' => true]);
    }
}
