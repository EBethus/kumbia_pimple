<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class UserController
{
    public function index()
    {
        View::select('lista');
    }

    public function redirect()
    {
        return Redirect::to('/');
    }
}