<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseController;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class ControllerResolver extends BaseController
{

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
} 