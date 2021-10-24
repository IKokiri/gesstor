<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'ServicoArea.php';
require_once MODEL . DS . 'Cobranca.php';
//require_once VIEW . DS . 'ServicoArea.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Cobranca;
use App\Model\ServicoArea as ServicoArea_Model;
use App\Model\Cobranca as Cobranca_Model;

//use App\View\ServicoArea as ServicoArea_View;

class ServicoArea extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new ServicoArea_Model();

//        $this->oView = new ServicoArea_View();
    }

    public function render()
    {
//        $this->oView->render();
    }

    public function create($object)
    {

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->create();

        $id = $result['lastId'];

        $array['id_servico_cliente'] = $id;

        $oCobranca = new Cobranca_Model();

        $oCobranca->populate($array);

        $oCobranca->delete();

        for ($i = 0; $i < $object['numero_meses']; $i++) {

            $oCobranca = new Cobranca_Model();

            $array['id_servico_cliente'] = $array['id_servico_cliente'];

            $array['valor_servico'] = $object['valor_servico'];

            $data = date('Y/m/d', strtotime("+" . $i . " month", strtotime($this->function->data_br_banco($object['dia_vencimento']))));

            $array['dia_vencimento'] = $this->function->data_banco_br($data);

            $oCobranca->populate($array);

            $oCobranca->create();

        }

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function update($object)
    {

        $this->oModel->transection();

        $oCobranca = new Cobranca();

        $array['id_servico_cliente'] = $object['id_servico_cliente'];

        $oCobranca = new Cobranca_Model();

        $oCobranca->populate($array);

        $oCobranca->delete();

        for ($i = 0; $i < $object['numero_meses']; $i++) {

            $oCobranca = new Cobranca_Model();

            $array['id_servico_cliente'] = $array['id_servico_cliente'];

            $array['valor_servico'] = $object['valor_servico'];

            $data = date('Y/m/d', strtotime("+" . $i . " month", strtotime($this->function->data_br_banco($object['dia_vencimento']))));

            $array['dia_vencimento'] = $this->function->data_banco_br($data);

            $oCobranca->populate($array);

            $oCobranca->create();

        }

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

    public function getAllActive()
    {
        $result = $this->oModel->getAllActive();

        echo json_encode($result);
    }

    public function getServicoArea($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getServicoArea();

        echo json_encode($result);

    }
    public function getServicoUsuario($object)
    {

        $this->oModel->populate($object);

        $array['area'] = $_SESSION['gesstor']['login']['permissao'];
        $array['id_usuario'] = $_SESSION['gesstor']['login']['id'];

        $this->oModel->populate($array);

        $result = $this->oModel->getServicoUsuario();

        echo json_encode($result);

    }

    public function getServicoAreaSession($object)
    {
        $this->oModel->populate($object);

        $array['id_area'] = $_SESSION['gesstor']['login']['id'];

        $this->oModel->populate($array);

        $result = $this->oModel->getServicoArea();

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