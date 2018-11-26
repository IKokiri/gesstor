<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'PermissaoTela.php';
require_once VIEW . DS . 'PermissaoTela.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\PermissaoTela as PermissaoTela_Model;
use App\View\PermissaoTela as PermissaoTela_View;

class PermissaoTela extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new PermissaoTela_Model();

        $this->oView = new PermissaoTela_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function update($object)
    {


        $this->oModel->populate($object);

        $result = $this->oModel->deleteGrupo();

        $this->create($object);


    }

    public function create($object)
    {
        $subMenus = explode(',', $object['subMenus']);

        $id_grupo = $object['id_grupo'];

        $this->oModel->transection();

        foreach ($subMenus as $subMenu) {

            $object['id_grupo'] = $id_grupo;

            $object['id_sub_menu'] = $subMenu;

            $this->oModel->populate($object);

            $result = $this->oModel->create();
        }


        $this->oModel->commit();

        echo json_encode($result);
    }

    public function deleteGrupo($object)
    {
        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->deleteGrupo();

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

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getByIdGrupos($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getByIdGrupos();

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