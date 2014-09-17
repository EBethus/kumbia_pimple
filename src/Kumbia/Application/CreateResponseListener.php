<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Application;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class CreateResponseListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => 'createResponse',
        );
    }

    public function createResponse(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        $event->setResponse(new Response(is_string($result) ? $result : ''));
    }
}