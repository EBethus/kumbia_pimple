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

/**
 * Helper base para creacion de Tags
 *
 * @category   KumbiaPHP
 * @package    Helpers
 */
class Tag extends BaseHelper
{

    /**
     * Hojas de estilo
     *
     * @var array
     * */
    protected $css = array();

    /**
     * Convierte los argumentos de un metodo de parametros por nombre a un string con los atributos
     *
     * @param array $params argumentos a convertir
     *
     * @return string
     */
    public function getAttrs($params)
    {
        $data = '';
        foreach ($params as $k => $v) {
            $data .= " $k=\"$v\"";
        }

        return $data;
    }

    /**
     * Incluye un archivo javascript
     *
     * @param string  $src   archivo javascript
     * @param boolean $cache indica si se usa cache de navegador
     */
    public function js($src, $cache = true)
    {
        $src = "javascript/$src.js";
        if (!$cache) {
            $src .= '?nocache=' . uniqid();
        }

        return '<script type="text/javascript" src="' . $this->getBasePath() . $src . '"></script>';
    }

    /**
     * Incluye un archivo de css
     *
     * @param string $src   archivo css
     * @param string $media medio de la hoja de estilo
     */
    public function css($src, $media = 'screen')
    {
        $this->css[] = array('src' => $src, 'media' => $media);
    }

    /**
     * Obtiene el array de hojas de estilo
     *
     * @return array
     */
    public function getCss()
    {
        return $this->css;
    }
}
