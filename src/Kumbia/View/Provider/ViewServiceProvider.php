<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\View\Provider;

use Kumbia\Application\Application;
use Kumbia\Application\ServiceProvider;
use Kumbia\View\CreateResponseListener;
use Kumbia\View\GetControllerPropertiesListener;
use Kumbia\View\View;
use Pimple\Container;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class ViewServiceProvider extends ServiceProvider
{

    public function boot(Application $app)
    {
        $app['event_dispatcher']->addSubscriber($app['controller_properties_listener']);
        $app['event_dispatcher']->addSubscriber($app['response_listener']);
    }

    public function register(Container $pimple)
    {
        $pimple['app.view_path'] = realpath($pimple['root_dir'] . 'views') . '/';

        $pimple['view'] = function ($c) {
            return new View($c['app.view_path']);
        };

        $pimple['controller_properties_listener'] = function () {
            return new GetControllerPropertiesListener();
        };

        $pimple['response_listener'] = function ($c) {
            return new CreateResponseListener($c['controller_properties_listener'], $c['view']);
        };
    }

    public function getFacades()
    {
        return array(
            'View' => __DIR__ . '/../Facade/View.php',
        );
    }


}