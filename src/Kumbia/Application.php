<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia;

use Composer\Autoload\ClassLoader;
use Kumbia\Facades\AbstractFacade;
use Kumbia\Provider\ApplicationServiceProvider;
use Kumbia\Provider\FacadesServiceProvider;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class Application extends Container
{
    public function __construct(ClassLoader $loader, $debug = false)
    {
        $this['loader'] = $loader;

        $this->register(new ApplicationServiceProvider());
        $this->register(new FacadesServiceProvider());

        AbstractFacade::setContainer($this);

        parent::__construct();
    }

    public function registerFacade($name, $filename)
    {
        $this['loader']->addClassMap(array($name => $filename));
    }

    public function run(Request $request)
    {
        return $this['kernel']->handle($request);
    }
} 