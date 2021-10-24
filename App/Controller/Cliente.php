<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Cliente.php';
require_once MODEL . DS . 'Usuario.php';
require_once VIEW . DS . 'Cliente.php';

use App\Core\Controller;
use App\Model\Cliente as Cliente_Model;
use App\Model\Usuario as Usuario_Model;

class Cliente extends Controller
{

    private $oModel;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Cliente_Model();
    }


    public function create($object)
    {
        $this->oModel->transection();

        $oUsuario = new Usuario_Model();

        $array['email'] = $object['email'];
        $array['senha'] = $object['senha'];
        $array['id_grupo_permissao'] = '';
        $array['status'] = 'D';

        $oUsuario->populate($array);

        $result = $oUsuario->create();

        $object['id_usuario_responsavel'] = isset($result['lastId']) ? $result['lastId'] : '';

        if ($result['result']) {

            $this->oModel->populate($object);

            $result = $this->oModel->create();

            if (isset($result['result'])) {

                $this->oModel->commit();

            }

        }

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

    public function getAllAtivos()
    {
        $result = $this->oModel->getAllAtivos();

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