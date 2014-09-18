<?php
/**
 * 18/09/14
 * kumbia_pimple
 */

namespace Kumbia\Debugbar;

use DebugBar\StandardDebugBar;
use Kumbia\Application\Application;
use Kumbia\Application\ServiceProvider;
use Kumbia\Debugbar\EventListener\DebugbarListener;
use Pimple\Container;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class DebugbarServiceProvider extends ServiceProvider
{

    public function boot(Application $app)
    {
//        if(isset($app['debug']) and $app['debug']){
            $app['event_dispatcher']->addSubscriber($app['debugbar_listener']);
//        }
    }


    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $p An Container instance
     */
    public function register(Container $p)
    {
        $p['debugbar'] = function ($p) {
            return new StandardDebugBar();
        };

        $p['debugbar_listener'] = function ($p) {
            return new DebugbarListener($p['debugbar']);
        };
    }

}