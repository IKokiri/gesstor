<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'FuncionarioAplicacao.php';
require_once VIEW . DS . 'FuncionarioAplicacao.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\FuncionarioAplicacao as FuncionarioAplicacao_Model;
use App\View\FuncionarioAplicacao as FuncionarioAplicacao_View;

class FuncionarioAplicacao extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new FuncionarioAplicacao_Model();

        $this->oView = new FuncionarioAplicacao_View();
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

    public function getAllJoin()
    {
        $result = $this->oModel->getAllJoin();

        echo json_encode($result);
    }

    public function getAllJoinFuncionario($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAllJoinFuncionario();

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