<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Faixa.php';
require_once VIEW . DS . 'Faixa.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Faixa as Faixa_Model;
use App\View\Faixa as Faixa_View;

class Faixa extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Faixa_Model();

        $this->oView = new Faixa_View();
    }

    public function render()
    {
        $this->oView->render();
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

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getLogin()
    {
        $result = $this->oModel->getLogin();

        return $result;
    }

    public function getLoginCliente()
    {
        $result = $this->oModel->getLoginCliente();

        return $result;
    }

    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}