<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernel;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class ApplicationServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple An Container instance
     */
    public function register(Container $pimple)
    {
        $pimple['event_dispatcher'] = function () {
            return new EventDispatcher();
        };

        $pimple['controller_resolver'] = function () {
            return new \Kumbia\ControllerResolver();
        };

        $pimple['request_stack'] = function () {
            return new RequestStack();
        };

        $pimple['kernel'] = function (Container $c) {
            return new HttpKernel($c['event_dispatcher'], $c['controller_resolver'], $c['request_stack']);
        };
    }
}