<?php
/**
 * 17/09/14
 * kumbia_pimple
 */

/**
 * @autor Manuel Aguirre <programador.manuel@gmail.com>
 */
class userController
{
    public function index()
    {
        View::select('manuel');

        return 'Hola';
    }

    public function redirect()
    {
        return Redirect::to('/');
    }
}