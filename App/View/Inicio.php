<?php

namespace App\View;

require_once CORE . DS . 'View.php';
require_once APP . '/vendor/autoload.php';

use Twig_Autoloader as Twig_Autoloader;
use Twig_Loader_Filesystem as Twig_Loader_Filesystem;
use Twig_Environment as Twig_Environment;
use App\Core\View;

class Inicio extends View
{
    public function __construct()
    {
        parent::__construct();

    }

    public function render()
    {
        parent::render();

        $show = array(
            'title' =>
                'Inicio',
            'sidebar' => $this->sidebar,
            'header' => $this->header,
            'footer' => $this->footer,
            'welcome' => $this->wellcome,
            'home' => $this->home,
            'footer_menu' => $this->footer_menu,
            'top_nav' => $this->top_nav,
            'footer_html' => $this->footer_html
        );

        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APP . DS . 'Template/template/');
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate('inicio.php');
        echo $template->render($show);
    }

}