<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class ControllerResolver implements ControllerResolverInterface
{
    protected $controllerPath;

    function __construct($controllerPath)
    {
        $this->controllerPath = $controllerPath;
    }

    public function getController(Request $request)
    {
        $attributes = $request->attributes->all();

        $filename = $this->controllerPath . $attributes['_controller_path'] . '_controller.php';

        if (!is_file($filename)) {
            throw new \InvalidArgumentException(sprintf('No existe el Controlador %s', $filename));
        }

        require_once $filename;

        $controllerClass = $this->camelize($attributes['_controller'] . '_controller');
        $controller = new $controllerClass();

        $callable = array($controller, $attributes['_action']);

        if (!is_callable($callable)) {
            throw new \InvalidArgumentException(sprintf('Controller "%s::%s" for URI "%s" is not callable.'
                , $controllerClass, $attributes['_action'], $request->getPathInfo()));
        }

        return $callable;
    }

    public function getArguments(Request $request, $controller)
    {
        $r = new \ReflectionMethod($controller[0], $controller[1]);

        return $this->doGetArguments($request, $controller, $r->getParameters());
    }


    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        $attributes = $request->attributes->get('_parameters');
        $arguments = array();

        $index = 0;
        $adjust = 0;

        foreach ($parameters as $param) {
            if ($param->getClass() && $param->getClass()->isInstance($request)) {
                $arguments[$index] = $request;
                $adjust = -1;
            } elseif (array_key_exists($index + $adjust, $attributes)) {
                $arguments[$index] = $attributes[$index + $adjust];
            } elseif ($param->isDefaultValueAvailable()) {
                $arguments[$index] = $param->getDefaultValue();
            } else {

                if (is_array($controller)) {
                    $repr = sprintf('%s::%s()', get_class($controller[0]), $controller[1]);
                } elseif (is_object($controller)) {
                    $repr = get_class($controller);
                } else {
                    $repr = $controller;
                }

                throw new \RuntimeException(sprintf('Controller "%s" requires that you provide a value for the "$%s" argument (because there is no default value or because there is a non optional argument after this one).', $repr, $param->name));
            }

            ++$index;
        }

        return $arguments;
    }

    protected function camelize($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }
} 