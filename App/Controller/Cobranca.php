<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Cobranca.php';
//require_once VIEW . DS . 'Cobranca.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Cobranca as Cobranca_Model;


class Cobranca extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Cobranca_Model();

//        $this->oView = new Cobranca_View();
    }


    public function create($object)
    {

        $this->oModel->transection();


        $this->oModel->populate($object);

        $result = $this->oModel->create();


        $this->oModel->commit();

        echo json_encode($result);
    }

    public function delete($object)
    {

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->delete();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function update($object)
    {

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->update();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function update_link($object)
    {

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->update_link();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function populate($object)
    {
        $this->oModel->populate($object);
    }

}