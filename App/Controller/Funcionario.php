<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Funcionario.php';
require_once MODEL . DS . 'FuncionarioCentroCustoResponsavel.php';
require_once MODEL . DS . 'Usuario.php';

use App\Core\Controller;
use App\Model\Funcionario as Funcionario_Model;
use App\Model\FuncionarioCentroCustoResponsavel as FuncionarioCentroCustoResponsavel_Model;
use App\Model\Usuario as Usuario_Model;

class Funcionario extends Controller
{

    private $oModel;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Funcionario_Model();
    }

    public function create($object)
    {
        $this->oModel->transection();

        $oUsuario = new Usuario_Model();

        $array['email'] = $object['email'];
        $array['senha'] = $object['senha'];
        $array['id_grupo_permissao'] = '';
        $array['status'] = 'A';

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

    public function getAllTemp()
    {

        $object['id_usuario'] = $_SESSION['gesstor']['login']['id'];

        $oFuncionarioCentroCustoResponsavel = new FuncionarioCentroCustoResponsavel_Model();

        $oFuncionarioCentroCustoResponsavel->populate($object);

        $result = $oFuncionarioCentroCustoResponsavel->getAllJoinId();

        $centroCustosUsuario = $result['result'];


        if ($result['count']) {
            $in = "";
            foreach ($centroCustosUsuario as $valor) {
                $in .= $valor['id_centro_custo'];

                $ultimo = end($centroCustosUsuario);

                $final = $ultimo['id_centro_custo'];

                if ($valor['id_centro_custo'] == $final) {

                } else {
                    $in .= ",";
                }

            }
            $object["id_centro_custo"] = '(' . $in . ')';

            $this->oModel->populate($object);

            $result = $this->oModel->getAllDepartamento();

        } else {
            $result = $this->oModel->getEste();
        }



////ana
//        } else if ($_SESSION['gesstor']['login']['id'] == 113) {
//
//            $result = $this->oModel->getSemec();
//
//        }else if ($_SESSION['gesstor']['login']['id'] == 159) {
//
//            $result = $this->oModel->getDepro();
//
//        } else {
//
//            $result = $this->oModel->getEste();
//        }

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