<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'SubContrato.php';
require_once MODEL . DS . 'Contrato.php';
require_once CONTROLLER . DS . 'LancarHora.php';
require_once VIEW . DS . 'SubContrato.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\SubContrato as SubContrato_Model;
use App\Model\Contrato as Contrato_Model;
use App\Controller\LancarHora as LancarHora_Controller;
use App\View\SubContrato as SubContrato_View;

class SubContrato extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new SubContrato_Model();

        $this->oView = new SubContrato_View();
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


        if ($result['lastId'] && $object['addHoras'] == 'A') {

            $objectContrato['id'] = $object['id_contrato'];

            $oContrato = new Contrato_Model();

            $oContrato->populate($objectContrato);

            $resultContrato = $oContrato->getById();

            $objectHora['mesAno'] = substr($resultContrato['result']['data_contrato'], 3, 8);
            $objectHora['id_funcionario'] = $object['id_funcionario'];
            $objectHora['id_tabela'] = 1;
            $objectHora['id_tabela_complemento'] = $result['lastId'];
            $objectHora['id_aplicacao'] = 1;
            $objectHora['localChamada'] = "SubContrato";

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

    public function getAll()
    {
        $result = $this->oModel->getAll();

        echo json_encode($result);
    }

    public function getAllHoras()
    {
        $result = $this->oModel->getAllHoras();

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