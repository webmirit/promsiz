<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Environment;

class AbstractController implements ServiceSubscriberInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @inheritDoc
     */
    public static function getSubscribedServices(): array
    {
        return [
            'router' => '?' . RouterInterface::class,
            'request_stack' => '?' . RequestStack::class,
            'http_kernel' => '?' . HttpKernelInterface::class,
            'serializer' => '?' . SerializerInterface::class,
            'session' => '?' . SessionInterface::class,
            //'security.authorization_checker' => '?'.AuthorizationCheckerInterface::class,
            'twig' => '?' . Environment::class,
            //'doctrine' => '?'.ManagerRegistry::class, // to be removed in 6.0
            //'form.factory' => '?'.FormFactoryInterface::class,
            //'security.token_storage' => '?'.TokenStorageInterface::class,
            //'security.csrf.token_manager' => '?'.CsrfTokenManagerInterface::class,
            'parameter_bag' => '?' . ContainerBagInterface::class,
            //'//message_bus' => '?'.MessageBusInterface::class, // to be removed in 6.0
            //'messenger.default_bus' => '?'.MessageBusInterface::class, // to be removed in 6.0
        ];
    }

    /**
     * @required
     */
    public function setContainer(ContainerInterface $container): ?ContainerInterface
    {
        $previous = $this->container;
        $this->container = $container;

        return $previous;
    }
}
