<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'NumeroOrcamento.php';
require_once CONTROLLER . DS . 'LancarHora.php';
require_once VIEW . DS . 'NumeroOrcamento.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\NumeroOrcamento as NumeroOrcamento_Model;
use App\Controller\LancarHora as LancarHora_Controller;
use App\View\NumeroOrcamento as NumeroOrcamento_View;

class NumeroOrcamento extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new NumeroOrcamento_Model();

        $this->oView = new NumeroOrcamento_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {
        $this->oModel->populate($object);

        $ultimoOrcamento = $this->oModel->getNext();

        $ultimo = $ultimoOrcamento['result']['numero'];

        $object['numero'] = $ultimo;

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->create();

        $this->oModel->commit();

        if ($result['lastId'] && $object['addHoras'] == 'A') {

            $objectHora['mesAno'] = substr($object['data'], 3, 8);
            $objectHora['id_funcionario'] = $object['id_funcionario'];
            $objectHora['id_tabela'] = 2;
            $objectHora['id_tabela_complemento'] = $result['lastId'];
            $objectHora['id_aplicacao'] = 1;
            $objectHora['localChamada'] = "NumeroOrcamento";

            $oLancarHora = new LancarHora_Controller();


            $oLancarHora->create($objectHora);
        }

        echo json_encode($result);
    }

    public function usuarioLogado($object)
    {
        echo json_encode($_SESSION['gesstor']['login']['id_area']);

    }

    public function update($object)
    {


        $this->oModel->transection();

        $this->oModel->populate($object);

        $dado = $this->oModel->verificaSeUpdate();

        if (!$dado['count']) {

            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Você não tem Permissão para alterar essa proposta</h1>";
            echo json_encode($result);

            die;
        }

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

    public function getAllNumero()
    {

        $result = $this->oModel->getAllNumero();

        echo json_encode($result);
    }

    public function anosPropostas()
    {

        $result = $this->oModel->anosPropostas();

        echo json_encode($result);
    }

    public function getAllGrid($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAllGrid();

        echo json_encode($result);
    }

    public function getLast()
    {
        $result = $this->oModel->getLast();

        echo json_encode($result);
    }

    public function getNext($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getNext();

        echo json_encode($result);
    }

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getJoinId($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getJoinId();

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