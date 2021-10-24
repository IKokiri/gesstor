<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Contato.php';

use App\Core\Controller;
use App\Model\Contato as Contato_Model;

class Contato extends Controller
{

    private $oModel;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Contato_Model();
    }

    public function render()
    {
//        $this->oView->render();
    }

    public function create($object)
    {
        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->create();


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

    public function delete($object)
    {

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->delete();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function getAll()
    {
        $result = $this->oModel->getAll();

        echo json_encode($result);
    }

    public function getAllBy($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAllBy();

        echo json_encode($result);
    }

    public function getAllArea($object)
    {
        $this->oModel->populate($object);

        $result = $this->oModel->getAllArea();

        echo json_encode($result);
    }



    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }


    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}