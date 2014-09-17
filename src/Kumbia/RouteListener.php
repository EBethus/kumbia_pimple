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

        $request->attributes->set('_parameters', array());

        if ($url == '/') {
            $request->attributes->set('_controller', $this->defaultController);
        } else {
            $url_items = explode('/', trim($url, '/'));

            $controller = current($url_items);

            if (next($url_items) === false) {
                $request->attributes->set('_controller', "{$controller}Controller::index");
                return;
            }

            $action = current($url_items);
            $request->attributes->set('_controller', "{$controller}Controller::{$action}");

            if (next($url_items) === false) {
                return;
            }

            $request->attributes->set('_parameters', array_slice($url_items, key($url_items)));
        }
    }
}