<?php
/**
 * KumbiaPHP web & app Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://wiki.kumbiaphp.com/Licencia
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@kumbiaphp.com so we can send you a copy immediately.
 *
 * @category   KumbiaPHP
 * @package    Helpers
 * @copyright  Copyright (c) 2005-2014 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license    http://wiki.kumbiaphp.com/Licencia     New BSD License
 */

namespace Kumbia\View\Helper;

use Kumbia\View\Helper\BaseHelper;
use Kumbia\View\Helper\Tag;

/**
 * Helper para Tags Html
 *
 * @category   KumbiaPHP
 * @package    Helpers
 */
class Html extends BaseHelper
{

    /**
     * @var  Tag
     */
    protected $tagHelper;

    function __construct($requestStack, $tagHelper)
    {
        parent::__construct($requestStack);
        $this->tagHelper = $tagHelper;
    }

    /**
     * Crea un enlace usando la constante $this->getBasePath(), para que siempre funcione
     *
     * @example Html::link
     * echo Html::link('controller/action','Enlace')
     * Crea un enlace a ese controller y acción con el nombre Enlace
     *
     * @param string       $action Ruta a la acción
     * @param string       $text   Texto a mostrar
     * @param string|array $attrs  Atributos adicionales
     *
     * @return string
     */
    public function link($action, $text, $attrs = null)
    {
        if (is_array($attrs)) {
            $attrs = $this->tagHelper->getAttrs($attrs);
        }

        return '<a href="' . $this->getBasePath() . "/$action\" $attrs >$text</a>";
    }

    /**
     * Crea un enlace a una acción del mismo controller que estemos
     *
     * @example Html::linkAction
     * echo Html::linkAction('accion/','Enlace a la acción del mismo controller')
     *
     * @param string       $action
     * @param string       $text  Texto a mostrar
     * @param string|array $attrs Atributos adicionales
     *
     * @return string
     */
    public function linkAction($action, $text, $attrs = null)
    {
        if (is_array($attrs)) {
            $attrs = $this->tagHelper->getAttrs($attrs);
        }

        $prefix = $this->getRequest()->attributes->get('_controller_path');

        return '<a href="' . $this->getBasePath() . '/' . $prefix . "/$action\" $attrs >$text</a>";
    }

    /**
     * Permite incluir una imagen
     *
     * @param string       $src   Atributo src
     * @param string       $alt   Atributo alt
     * @param string|array $attrs Atributos adicionales
     *
     * @return string
     */
    public function img($src, $alt = null, $attrs = null)
    {
        if (is_array($attrs)) {
            $attrs = $this->tagHelper->getAttrs($attrs);
        }

        return '<img src="' . $this->getBasePath() . "/img/$src\" alt=\"$alt\" $attrs />";
    }

    /**
     * Incluye los CSS
     *
     * @return string
     */
    public function includeCss()
    {
        $code = '';

        foreach ($this->tagHelper->getCss() as $css) {
            $code .= '<link href="' . $this->getBasePath()
                . "/css/{$css['src']}.css\" rel=\"stylesheet\" type=\"text/css\" media=\"{$css['media']}\" />" . PHP_EOL;
        }

        return $code;
    }

}
