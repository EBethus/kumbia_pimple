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
use Kumbia\View\Helper\Html;
use Kumbia\View\Helper\Tag;
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

        $this->registerHelpers($pimple);
    }

    public function getFacades()
    {
        return array(
            'View' => __DIR__ . '/../Facade/View.php',
            //helpers
            'Tag' => __DIR__ . '/../Facade/Tag.php',
            'Html' => __DIR__ . '/../Facade/Html.php',
        );
    }

    protected function registerHelpers($app)
    {
        $app['tag_helper'] = function ($c) {
            return new Tag($c['request_stack']);
        };

        $app['html_helper'] = function ($c) {
            return new Html($c['request_stack'], $c['tag_helper']);
        };
    }


}