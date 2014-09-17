<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Facades;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
abstract class AbstractFacade
{
    private static $container;

    abstract public static function getName();

    public static function setContainer($container)
    {
        self::$container = $container;
    }

    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array(array(self::$container[static::getName()], $method), $arguments);
    }
} 