<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Cardapio.php';
require_once VIEW . DS . 'Cardapio.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Cardapio as Cardapio_Model;
use App\View\Cardapio as Cardapio_View;

class Cardapio extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Cardapio_Model();

        $this->oView = new Cardapio_View();
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

    public function getAtual()
    {
        $result = $this->oModel->getAtual();

        echo json_encode($result);
    }

    public function getAllJoin()
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