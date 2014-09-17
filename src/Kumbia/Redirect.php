<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class Redirect
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

    public function to($route, $seconds = null, $statusCode = 302)
    {
        $url = $this->getRequest()->getBaseUrl() . '/' . ltrim($route, '/');

        return RedirectResponse::create($url, $statusCode);
    }

    public function toAction($route, $seconds = null, $statusCode = 302)
    {
        $controller = $this->getRequest()->attributes->get('_route_controller');
        $route = $controller . '/' . ltrim($route, '/');

        return $this->to($route, $seconds, $statusCode);
    }
}