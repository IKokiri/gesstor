<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Ausencia.php';
require_once VIEW . DS . 'Ausencia.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\Ausencia as Ausencia_Model;
use App\View\Ausencia as Ausencia_View;

class Ausencia extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Ausencia_Model();

        $this->oView = new Ausencia_View();
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

    public function troca_status($object)
    {

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        $status = $result['result']['status'];


        if($status == "A"){
            $status = "D";
        }else{
            $status = "A";
        }

        $object["status"] = $status;

        $this->oModel->populate($object);

        $result = $this->oModel->troca_status();

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


    public function getAllAusenciaApp()
    {
        $result = $this->oModel->getAllAusenciaApp();


        echo json_encode($result);
    }

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getLast($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getLast();

        echo json_encode($result);
    }

    public function getLogin()
    {
        $result = $this->oModel->getLogin();

        return $result;
    }

    public function getAllOrder()
    {
        $result = $this->oModel->getAllOrder();

        $listaOrdenada = array();

        foreach($result['result'] as $value){

            $tipo = $value['tipo'];

            unset($value['tipo']);

            $listaOrdenada[$tipo][] = $value;

        }

        $result['result'] = $listaOrdenada;

        echo json_encode($result);
    }
    public function getAllOrderApp()
    {
        $result = $this->oModel->getAllOrderApp();

        // $listaOrdenada = array();

        // foreach($result['result'] as $value){

        //     $tipo = $value['tipo'];

        //     unset($value['tipo']);

        //     $listaOrdenada[$tipo][] = $value;

        // }

        // $result['result'] = $listaOrdenada;

        echo json_encode($result);
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