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
class IndexController
{
    public function index($otro = 'jeje')
    {
//        return Redirect::to('index/home');
//        return Redirect::toAction('home');

        $this->name = 'Manuel';

//        View::select(null);
    }

    public function home(Request $request)
    {
        return new Response('Hola Mundo!');
    }
}