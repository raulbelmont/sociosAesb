<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 26/01/2019
 * Time: 10:12
 */

class autoloadController
{

    private $permitidos;

    public function __construct()
    {
        spl_autoload_register([$this,'Paginas']);
    }

    private function Paginas($classes)
    {
        $this->permitidos = (['../model/'.$classes.'.php']);
        foreach ($this->permitidos as $classes)
        {
            if(!file_exists($classes)){
                echo 'Essa classe não existe no sistema';
            }else{
                require_once($classes);
            }
        }
    }

}