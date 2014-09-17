<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\View;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class CreateResponseListener implements EventSubscriberInterface
{

    /**
     * @var GetControllerPropertiesListener
     */
    protected $controllerProperties;
    /**
     * @var View
     */
    protected $view;

    function __construct($controllerProperties, $view)
    {
        $this->controllerProperties = $controllerProperties;
        $this->view = $view;
    }


    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => 'createResponse',
        );
    }

    public function createResponse(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $attrs = $request->attributes->all();

        if (\View::getView() === true) {
            //si es true, no se establecó
            $view = $attrs['_controller_path'] . '/' . $attrs['_action'];
        } else {
            $view = $attrs['_controller_path'] . '/' . \View::getView();
        }

        $content = $this->view->render($view, \View::getTemplate()
            , $this->controllerProperties->getProperties());

        $event->setResponse(new Response($content));
    }
}