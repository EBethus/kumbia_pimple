<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Provider;

use Kumbia\Application\Application;
use Kumbia\Application\ServiceProvider;
use Kumbia\InputService;
use Kumbia\Redirect;
use Pimple\Container;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class FacadesServiceProvider extends ServiceProvider
{
    public function register(Container $pimple)
    {
        $pimple['input_service'] = function ($c) {
            return new InputService($c['request_stack']);
        };

        $pimple['redirect'] = function ($c) {
            return new Redirect($c['request_stack']);
        };
    }

    public function getFacades()
    {
        return array(
            'Input' => 'Kumbia\Facades\InputFacade',
            'Redirect' => 'Kumbia\Facades\RedirectFacade',
        );
    }

    public function boot(Application $app)
    {

    }
}