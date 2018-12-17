<?php

namespace App\Core;


use App\Complement\Functions;

require_once COMPLEMENT . DS . 'Functions.php';

class Controller
{

    protected $function;

    public function __construct()
    {
        $this->function = new Functions();
    }


}