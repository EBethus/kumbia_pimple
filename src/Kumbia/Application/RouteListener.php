<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Application;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class RouteListener implements EventSubscriberInterface
{

    private $controllerPath;

    function __construct($controllerPath)
    {
        $this->controllerPath = $controllerPath;
    }


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
        $module = false;
        $controller = 'index';
        $action = 'index';
        $parameters = array();

        if ($url != '/') {
            $url_items = explode('/', trim($url, '/'));

            // El primer parametro de la url es un módulo?
            if (is_dir($this->controllerPath . $url_items[0])) {
                $module = $url_items[0];

                // Si no hay mas parametros sale
                if (next($url_items) === false) {
                    goto set_attributes;
                }
            }

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

        $request->attributes->set('_module', $module);
        $request->attributes->set('_controller', $controller);
        $request->attributes->set('_controller_path', $module ? $module . '/' . $controller : $controller);
        $request->attributes->set('_action', $action);
        $request->attributes->set('_parameters', $parameters);
    }
}