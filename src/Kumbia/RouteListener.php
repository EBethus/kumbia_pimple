<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class RouteListener implements EventSubscriberInterface
{

    private $defaultController = 'indexController::index';

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 256),
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        //buscamos un controller para esta ruta
        $request = $event->getRequest();

        $url = $request->getPathInfo();
        $controller = 'index';
        $action = 'index';
        $parameters = array();

        $request->attributes->set('_parameters', array());

        if ($url != '/') {
            $url_items = explode('/', trim($url, '/'));

            $controller = current($url_items);

            if (next($url_items) === false) {
                goto set_attributes;
            }

            $action = current($url_items);

            if (next($url_items) === false) {
                goto set_attributes;
            }

            $parameters = array_slice($url_items, key($url_items));
        }

        set_attributes:

        $request->attributes->set('_controller', "{$controller}Controller::{$action}");
        $request->attributes->set('_parameters', $parameters);
        $request->attributes->set('_route_controller', $controller);
        $request->attributes->set('_route_action', $action);
    }
}