<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class indexController
{
    public function index(Request $request, $otro = 'jeje')
    {
        var_dump(Input::get('nombre'), Input::hasPost('nombre'));

        return new Response('Hola Mundo!');
    }
} 