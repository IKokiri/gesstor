<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'AjusteHoras.php';
require_once VIEW . DS . 'AjusteHoras.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\AjusteHoras as AjusteHoras_Model;
use App\View\AjusteHoras as AjusteHoras_View;

class AjusteHoras extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new AjusteHoras_Model();

        $this->oView = new AjusteHoras_View();
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