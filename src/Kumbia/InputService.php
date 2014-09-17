<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia;

use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class InputService
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    public function __construct(RequestStack $rs)
    {
        $this->requestStack = $rs;
    }

    private function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function get($name)
    {
        return $this->getRequest()->query->get($name);
    }

    public function post($name)
    {
        return $this->getRequest()->request->get($name);
    }

    public function hasPost($name)
    {
        return $this->getRequest()->request->has($name);
    }


    public function hasGet($name)
    {
        return $this->getRequest()->query->has($name);
    }

    public function hasRequest($name)
    {
        return $this->getRequest()->get($name, false) === false ? false : true;
    }

    public function is($method)
    {
        return $this->getRequest()->isMethod($method);
    }

    public function isAjax()
    {
        return $this->getRequest()->isXmlHttpRequest();
    }

    public function request($name)
    {
        return $this->getRequest()->get($name);
    }
}