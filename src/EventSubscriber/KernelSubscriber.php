<?php

namespace App\EventSubscriber;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class KernelSubscriber implements EventSubscriberInterface
{

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }
    
    public function onKernelResponse(ResponseEvent $event)
    {
        if($event->getResponse()->getStatusCode() == '403'){
            $route = 'meeting.index';
            $url = $this->router->generate($route);
            $response = new RedirectResponse($url);
            $event->setResponse($response);
            return;
        }
        return;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
