<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Status.php';


use App\Core\Controller;
use App\Core\Model;
use App\Model\Status as Status_Model;

class Status extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Status_Model();
    }

    public function render()
    {
        $this->oView->render();
    }


    public function getAll()
    {
        $result = $this->oModel->getAll();

        echo json_encode($result);
    }
    public function getHistory($object)
    {
        $this->oModel->populate($object);

        $result = $this->oModel->getHistory();

        echo json_encode($result);
    }

    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}