<?php

namespace App\View;

require_once CORE . DS . 'View.php';
require_once APP . '/vendor/autoload.php';

use Twig_Autoloader as Twig_Autoloader;
use Twig_Loader_Filesystem as Twig_Loader_Filesystem;
use Twig_Environment as Twig_Environment;
use App\Core\View;

class Menu extends View
{
    public function __construct()
    {
        parent::__construct();

    }
}