<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'SubContrato.php';
require_once CONTROLLER . DS . 'LancarHora.php';
require_once MODEL . DS . 'Contrato.php';
require_once VIEW . DS . 'Contrato.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Contrato as Contrato_Model;
use App\View\Contrato as Contrato_View;
use App\Model\SubContrato as SubContrato_Model;
use App\Controller\LancarHora as LancarHora_Controller;

class Contrato extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Contrato_Model();

        $this->oView = new Contrato_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {

        $this->oModel->populate($object);

        $this->oModel->transection();

        $numero = $this->oModel->getNext();

        $object['numero'] = $numero['result']['numero'];

        $this->oModel->populate($object);

        $result = $this->oModel->create();

        if (!$result['result']) {
            $this->oModel->rollback();
            echo json_encode($result);
            die;
        }

        $array['id'] = $result['lastId'];


        $this->oModel->populate($array);

        $arrayContrato = $this->oModel->getById();

        $arraySubContrato['id_contrato'] = $arrayContrato['result']['id'];
        $arraySubContrato['divisao'] = $arrayContrato['result']['divisao'];
        $arraySubContrato['id_funcionario'] = $arrayContrato['result']['id_funcionario'];
        $arraySubContrato['id_objeto'] = $arrayContrato['result']['id_objeto'];
        $arraySubContrato['id_gerente'] = $arrayContrato['result']['id_gerente'];
        $arraySubContrato['id_responsavel'] = $arrayContrato['result']['id_responsavel'];
        $arraySubContrato['status'] = $arrayContrato['result']['status'];
        $arraySubContrato['observacao'] = '';

        $oSubContrato = new SubContrato_Model();

        $oSubContrato->populate($arraySubContrato);

        $result = $oSubContrato->create();


        if (!$result['result']) {
            $this->oModel->rollback();
            echo json_encode($result);
            die;
        }

        $this->oModel->commit();

        if ($result['lastId'] && $object['addHoras'] == 'A') {

            $objectHora['mesAno'] = substr($object['data_contrato'], 3, 8);
            $objectHora['id_funcionario'] = $object['id_funcionario'];
            $objectHora['id_tabela'] = 1;
            $objectHora['id_tabela_complemento'] = $result['lastId'];
            $objectHora['id_aplicacao'] = 1;
            $objectHora['localChamada'] = "Contrato";

            $oLancarHora = new LancarHora_Controller();

            $oLancarHora->create($objectHora);
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

    public function getAll($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAll();

        echo json_encode($result);
    }

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getNext($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getNext();

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