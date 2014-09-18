<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\View\Facade;

use Kumbia\Facades\AbstractFacade;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class ViewFacade extends AbstractFacade
{
    protected static $view = true;
    protected static $template = 'default';

    public static function getName()
    {
        return 'view';
    }

    public static function select($view, $template = false)
    {
        self::$view = $view;

        if ($template !== false) {
            self::$template = $template;
        }
    }

    public static function template($template)
    {
        self::$template = $template;
    }

    public static function getView()
    {
        return self::$view;
    }

    public static function getTemplate()
    {
        return self::$template;
    }
}