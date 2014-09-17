<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\View;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class GetControllerPropertiesListener implements EventSubscriberInterface
{
    protected $controller;

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $callable = $event->getController();
        $this->controller = $callable[0];
    }

    public function getProperties()
    {
        return is_object($this->controller) ? get_object_vars($this->controller) : array();
    }
}