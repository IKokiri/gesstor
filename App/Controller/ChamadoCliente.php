<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'ChamadoCliente.php';
require_once VIEW . DS . 'ChamadoCliente.php';
require_once MODEL . DS . 'ImagemChamado.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\ChamadoCliente as ChamadoCliente_Model;
use App\View\ChamadoCliente as ChamadoCliente_View;
use App\Model\ImagemChamado as ImagemChamado_Model;

class ChamadoCliente extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new ChamadoCliente_Model();

        $this->oView = new ChamadoCliente_View();
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

        if ($result['result']) {

            if (count($object['file'])) {

                $object['file'] = array_values($object['file']);

                $extensao = (explode('.', $object['file'][0]['name']))[1];

                $new_name = date('dmYHis');

                $oImagemChamado = new ImagemChamado_Model();

                $object['file'][0]['new_name'] = $new_name . '.' . $extensao;

                $object['file'][0]['id_chamado'] = $result['lastId'];

                $oImagemChamado->populate($object['file'][0]);

                $oImagemChamado->create();

                move_uploaded_file($object['file'][0]['tmp_name'], '../imagens/chamados/' . $new_name . "." . $extensao);
            }

//            $array_status['id'] =
//            $array_status[''] =
//            $this->oModel->update_status();

            $this->oModel->commit();

        } else {

            $this->oModel->rollback();

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

    public function update_status($object)
    {
        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->update_status();

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

    public function getAllArea($object)
    {
        $this->oModel->populate($object);

        $result = $this->oModel->getAllArea();

        echo json_encode($result);
    }

    public function getAllActive()
    {
        $result = $this->oModel->getAllActive();

        echo json_encode($result);
    }

    public function getAll()
    {
        $result = $this->oModel->getAll();

        echo json_encode($result);
    }
    public function getAllFilter($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getAllFilter();

        echo json_encode($result);
    }

    public function getHistory($object)
    {
        $this->oModel->populate($object);

        $result = $this->oModel->getHistory();

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