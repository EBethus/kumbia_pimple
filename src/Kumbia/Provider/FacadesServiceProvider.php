<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Provider;

use Kumbia\InputService;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class FacadesServiceProvider implements ServiceProviderInterface
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
        $pimple['input_service'] = function ($c) {
            return new InputService($c['request_stack']);
        };

        $pimple->registerFacade('Input', __DIR__ . '/../Facades/Input.php');
    }
}