<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Application;

use Pimple\ServiceProviderInterface;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
abstract class ServiceProvider implements ServiceProviderInterface
{
    abstract public function boot(Application $app);

    public function getFacades()
    {
        return array();
    }
} 