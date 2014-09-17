<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\View\Helper;

use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class BaseHelper
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    function __construct($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    protected function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function getBasePath()
    {
        return $this->getRequest()->getBasePath();
    }
} 