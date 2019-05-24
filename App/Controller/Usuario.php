<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Usuario.php';
require_once VIEW . DS . 'Usuario.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Usuario as Usuario_Model;
use App\View\Usuario as Usuario_View;

class Usuario extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Usuario_Model();

        $this->oView = new Usuario_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {   
        $object['id_grupo_permissao'] = 0;
            if($object['token'] != "LKJAS)&(*ASKSD&askjdha84"){

                echo json_encode(['msg'=>'TOKEN ERRO']);
            die;
        }
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

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getAllInfo($object)
    {

        $object['id'] = $_SESSION['gesstor']['login']['id'];

        $this->oModel->populate($object);

        $result = $this->oModel->getAllInfo();

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

    public function updateFoto($object)
    {

        $this->oModel->transection();
//
//        $this->oModel->populate($object);
//
//        $result = $this->oModel->create();
//
//        if ($result['result']) {

        if (count($object['file'])) {

            $object['file'] = array_values($object['file']);

            $extensao = (explode('.', $object['file'][0]['name']))[1];

            $new_name = date('dmYHis');

            $object['file'][0]['new_name'] = $new_name . '.' . $extensao;

            $object['imagem'] = $object['file'][0]['new_name'];
            $object['id'] = $_SESSION['gesstor']['login']['id'];

            $this->oModel->populate($object);
            $result = $this->oModel->updateFoto();
            move_uploaded_file($object['file'][0]['tmp_name'], '../imagens/usuarios/' . $new_name . "." . $extensao);
            $_SESSION['gesstor']['login']['imagem'] = $new_name . "." . $extensao;
        }

//            $array_status['id'] =
//            $array_status[''] =
//            $this->oModel->update_status();

        $this->oModel->commit();

//        } else {
//
//            $this->oModel->rollback();
//
//        }

        echo json_encode($result);
    }


    public function alterarSenha($object)
    {
        if ($object['senha'] != $object['confirmar']) {
            $result['MSN'] = "Erro";
            $result['msnErro'] = "Senhas Diferentes";

            echo json_encode($result);
            
            die;
        }
        $this->oModel->transection();

        $object['id'] = $_SESSION['gesstor']['login']['id'];

        $this->oModel->populate($object);

        $result = $this->oModel->alterarSenha();


        $this->oModel->commit();


        echo json_encode($result);
    }

}