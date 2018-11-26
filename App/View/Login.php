<?php

namespace App\View;

require_once CORE . DS . 'View.php';
require_once APP . '/vendor/autoload.php';

use Twig_Autoloader as Twig_Autoloader;
use Twig_Loader_Filesystem as Twig_Loader_Filesystem;
use Twig_Environment as Twig_Environment;
use App\Core\View;

class Login extends View
{
    public function __construct()
    {
        parent::__construct();

    }

    public function render()
    {

        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APP . DS . 'Template/template/');
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate('login.php');
        echo $template->render(array());
    }

}