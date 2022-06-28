<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Validator\Exception\ValidatorException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$throwable = $event->getThrowable()) {
            return;
        }

        if ($throwable instanceof ValidatorException) {
            $errors = $throwable->getErrors();
            $success = false;
            $event->setResponse(new JsonResponse(compact('success', 'errors')));
            return;
        }

        $event->setResponse(new JsonResponse(['success' => false, 'message' => $throwable->getMessage()]));
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$this->isJson($event)) {
            return;
        }

        $data = json_decode((string)$event->getRequest()->getContent(), true);

        if (is_array($data)) {
            $event->getRequest()->request->replace($data);
        }
    }

    private function isJson(RequestEvent $event): bool
    {
        $request = $event->getRequest();

        return 'application/json' === $request->headers->get('Content-Type') && !$request->isMethod('GET') && $request->getContent();
    }
}
