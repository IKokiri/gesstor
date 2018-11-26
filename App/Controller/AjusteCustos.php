<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'AjusteCustos.php';
require_once VIEW . DS . 'AjusteCustos.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\AjusteCustos as AjusteCustos_Model;
use App\View\AjusteCustos as AjusteCustos_View;

class AjusteCustos extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new AjusteCustos_Model();

        $this->oView = new AjusteCustos_View();
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



    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}