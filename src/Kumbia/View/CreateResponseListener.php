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

        if (\View::getView() === true) {
            //si es true, no se establecó
            $attrs = $request->attributes->all();

            \View::select($attrs['_controller_path'] . '/' . $attrs['_action']);
        }

        $content = $this->view->render(\View::getView()
            , \View::getTemplate()
            , $this->controllerProperties->getProperties());

//        var_dump(\View::getView(),$content, \View::getTemplate(), $this->controllerProperties->getProperties());

        $event->setResponse(new Response($content));
    }
}