<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'CustoHoraDepartamento.php';
require_once VIEW . DS . 'CustoHoraDepartamento.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\CustoHoraDepartamento as CustoHoraDepartamento_Model;
use App\View\CustoHoraDepartamento as CustoHoraDepartamento_View;

class CustoHoraDepartamento extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new CustoHoraDepartamento_Model();

        $this->oView = new CustoHoraDepartamento_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {
        $object['data'] = "01/" . $object['data'];
        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->create();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function update($object)
    {
        $object['data'] = "01/" . $object['data'];

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

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getByValor($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getByValor();

        echo json_encode($result);
    }

    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}