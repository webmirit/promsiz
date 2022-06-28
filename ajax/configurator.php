<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

const STATISTIC_SKIP_ACTIVITY_CHECK = true;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$fileLocator = new FileLocator([dirname(__DIR__)]);
$loader = new PhpFileLoader($fileLocator);
$routes = $loader->load('local/configs/routes.php');

$request = Request::createFromGlobals();
$dispatcher = container()->get('event_dispatcher');
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

/** @var ControllerResolver $controllerResolver */
$controllerResolver = container()->get('controller_resolver');
/** @var ArgumentResolver $argumentResolver */
$argumentResolver = container()->get(ArgumentResolver::class);

$request->attributes->add($matcher->match($request->getPathInfo()));
$controller = $controllerResolver->getController($request);

$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

try {
    $response = $kernel->handle($request);
} catch (Exception $e) {
    $response = new Response('An error occurred', 500);
    AddMessage2Log($e->getMessage());
    dump($e->getMessage());
}

// send the headers and echo the content
$response->send();

// trigger the kernel.terminate event
$kernel->terminate($request, $response);


/*try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $response = $matcher->match($context->getPathInfo());
    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);
    $response = call_user_func_array($controller, $arguments);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Exception $exception) {
    dd($exception->getMessage());
    $response = new Response('An error occurred', 500);
}

$response->send();*/
