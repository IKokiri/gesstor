<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'UsuarioGrupo.php';
require_once VIEW . DS . 'UsuarioGrupo.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\UsuarioGrupo as UsuarioGrupo_Model;
use App\View\UsuarioGrupo as UsuarioGrupo_View;

class UsuarioGrupo extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new UsuarioGrupo_Model();

        $this->oView = new UsuarioGrupo_View();
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

    public function getAllJoin($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAllJoin();

        echo json_encode($result);
    }

    public function getAllWhere($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAllWhere();

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