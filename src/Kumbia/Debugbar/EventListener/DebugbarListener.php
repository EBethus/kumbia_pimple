<?php
/**
 * 18/09/14
 * kumbia_pimple
 */

namespace Kumbia\Debugbar\EventListener;

use DebugBar\DebugBar;
use DebugBar\JavascriptRenderer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class DebugbarListener implements EventSubscriberInterface
{
    /**
     * @var DebugBar
     */
    protected $debugbar;

    function __construct($debugbar)
    {
        $this->debugbar = $debugbar;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'onKernelResponse',
        );
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()
            //OR '_debugbar' == $request->attributes->get('_route')
        ) {
            return;
        }

        $response = $event->getResponse();

        if ($request->isXmlHttpRequest()) {
            $this->debugbar->sendDataInHeaders();

            return;
        }

//        if ($response->isRedirection()
//            OR !$response->headers->has('content-type')
//            OR false === strpos($response->headers->get('content-type'), 'text/html')
//        ) {
//            if ($this->debugbar->hasStackedData()) {
//                //esto es para que solo guarde la ultima
//                $this->debugbar->getStackedData();
//            }
//            $this->debugbar->stackData();
//
//            return;
//        }

        $base = $request->getBasePath() . '/debugbar/';

        $debugbarRenderer = $this->debugbar->getJavascriptRenderer($base);

        $this->injectScripts($response, $debugbarRenderer);
    }

    /**
     * Injects the js scripts into the given Response.
     *
     * @param Response $response A Response instance
     */
    protected function injectScripts(Response $response, JavascriptRenderer $renderer)
    {
        if (function_exists('mb_stripos')) {
            $posrFunction = 'mb_strripos';
            $substrFunction = 'mb_substr';
        } else {
            $posrFunction = 'strripos';
            $substrFunction = 'substr';
        }

        $content = $response->getContent();

        if (false !== $pos = $posrFunction($content, '</body>')) {

            $scripts = $renderer->renderHead() . $renderer->render();

//            if ($this->debugbar->getStorage()) {
//                $scripts .= sprintf('<script > phpdebugbar . setOpenHandler(new PhpDebugBar.OpenHandler({ url: "%s" }));</script
//            > ', $this->router->generate('_debugbar'));
//            }

            $content = $substrFunction($content, 0, $pos)
                . $scripts . $substrFunction($content, $pos);
            $response->setContent($content);
        }
    }
} 