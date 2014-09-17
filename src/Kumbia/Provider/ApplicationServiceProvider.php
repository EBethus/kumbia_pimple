<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Provider;

use Kumbia\Application\Application;
use Kumbia\Application\ControllerResolver;
use Kumbia\Application\RouteListener;
use Kumbia\Application\ServiceProvider;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernel;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class ApplicationServiceProvider extends ServiceProvider
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
        $pimple['app.controller_path'] = realpath($pimple['root_dir'] . 'controllers') . '/';

        $pimple['event_dispatcher'] = function () {
            return new EventDispatcher();
        };

        $pimple['controller_resolver'] = function ($c) {
            return new ControllerResolver($c['app.controller_path']);
        };

        $pimple['request_stack'] = function () {
            return new RequestStack();
        };

        $pimple['kernel'] = function (Container $c) {
            return new HttpKernel($c['event_dispatcher'], $c['controller_resolver'], $c['request_stack']);
        };
    }

    public function boot(Application $app)
    {
        $app['event_dispatcher']->addSubscriber(new RouteListener($app['app.controller_path']));
    }


}