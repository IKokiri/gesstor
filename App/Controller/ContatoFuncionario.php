<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'ContatoFuncionario.php';
require_once VIEW . DS . 'ContatoFuncionario.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\ContatoFuncionario as ContatoFuncionario_Model;
use App\View\ContatoFuncionario as ContatoFuncionario_View;

class ContatoFuncionario extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new ContatoFuncionario_Model();

        $this->oView = new ContatoFuncionario_View();
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
        $result = $this->oModel->getAll();

        echo json_encode($result);
    }
    
    public function getAllJoinApp()
    {
        $result = $this->oModel->getAllJoinApp();

        $rTemp = $result['result'];
        
        $aContent = array();

        foreach($rTemp as $key => $value){
            
            $dados = [];
            $contatos = [];
            $idFuncionario = $value['id_funcionario'];

            $dados['id'] = $value['id'];
            $dados['nome'] = $value['nome'];
            $dados['sobrenome'] = $value['sobrenome'];
            $dados['id_funcionario'] = $value['id_funcionario'];
            $dados['email'] = $value['email'];

            $contatos['observacao'] = $value['observacao'];
            $contatos['contato'] = $value['contato'];
            $contatos['contato_app'] = $value['contato_app'];

            $aContent["d".$idFuncionario]['dados'] = $dados;
            $aContent["d".$idFuncionario]['contatos'][] = $contatos;

        }

        $result['result'] = $aContent;
        // echo "<pre>";
        // print_r($aContent);
        // echo "</pre>";

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