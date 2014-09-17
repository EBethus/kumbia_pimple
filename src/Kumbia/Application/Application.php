<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\Application;

use Composer\Autoload\ClassLoader;
use Kumbia\Facades\AbstractFacade;
use Kumbia\Provider\ApplicationServiceProvider;
use Kumbia\Provider\FacadesServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class Application extends Container
{
    protected $booted = false;
    protected $serviceProviders = array();

    public function __construct(ClassLoader $loader, $rootDir, $debug = false)
    {
        $this['loader'] = $loader;
        $this['root_dir'] = $rootDir;

        $this->register(new ApplicationServiceProvider());
        $this->register(new FacadesServiceProvider());

        AbstractFacade::setContainer($this);

        parent::__construct();
    }

    protected function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;

        foreach ($this->serviceProviders as $provider) {
            $provider->boot($this);
        }
    }

    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        parent::register($provider, $values);

        $this['loader']->addClassMap($provider->getFacades());

        $this->serviceProviders[] = $provider;

        return $this;
    }

    public function run(Request $request)
    {
        $this->boot();

        return $this['kernel']->handle($request);
    }
} 