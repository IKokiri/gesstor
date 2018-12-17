<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once VIEW.DS.'Inicio.php';

use App\Core\Controller;
use App\View\Inicio as Inicio_Model;

class Inicio extends Controller
{

    private $oView;

    public function __construct()
    {
        parent::__construct();
        $this->oView = new Inicio_Model();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->create();

        echo json_encode($result);
    }

    public function getLogin()
    {
        return $this->oModel->getLogin();
    }

    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}