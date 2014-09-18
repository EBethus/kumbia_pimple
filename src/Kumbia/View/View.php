<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

namespace Kumbia\View;

use Kumbia\Util;

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class View
{
    protected $viewPath;
    protected $content = null;

    function __construct($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function render($view, $template = null, array $parameters = array())
    {
        if (!$view and !$template) {
            return '';
        }

        if ($view and !$template) {
            return $this->getView($view, $parameters);
        }

        $__template = $template;

        $view and $this->content = $this->getView($view, $parameters);

        ob_start();
        extract($parameters, EXTR_OVERWRITE);
        // carga el template
        if (!include $this->viewPath . "_shared/templates/$__template.phtml") {
            throw new \Exception("Template $__template no encontrado");
        }

        return ob_get_clean();
    }

    public function content($return = false, $preserve = false)
    {
        $content = $this->content;

        $preserve || $this->content = null;

        if ($return) {
            return $content;
        }

        echo $content;
    }

    protected function getView($view, array $parameters = array())
    {
        $___file = $this->viewPath . $view . '.phtml';

        ob_start();

        extract($parameters, EXTR_OVERWRITE);

        // carga la vista
        if (!include $___file) {
            throw new \Exception('Vista "' . $view . '" no encontrada');
        }

        return ob_get_clean();
    }

    public function partial($partial, $__time = false, $params = null, $group = 'kumbia.partials')
    {
//        if (PRODUCTION && $__time && !Cache::driver()->start($__time, $partial, $group)) {
//            return;
//        }

        //Verificando el partials en el dir app
        $__file = $this->viewPath . "/_shared/partials/$partial.phtml";

//        if (!is_file($__file)) {
//            //Verificando el partials en el dir core
//            $__file = CORE_PATH . "views/partials/$partial.phtml";
//        }

        if ($params) {
            if (is_string($params)) {
                $params = Util::getParams(explode(',', $params));
            }

            // carga los parametros en el scope
            extract($params, EXTR_OVERWRITE);
        }

        // carga la vista parcial
        if (!include $__file) {
            throw new \Exception('Vista Parcial "' . $__file . '" no se encontro');
        }

        // se guarda en la cache de ser requerido
//        if (PRODUCTION && $__time) {
//            Cache::driver()->end();
//        }
    }
} 