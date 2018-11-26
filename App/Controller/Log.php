<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'Log.php';
require_once VIEW . DS . 'Log.php';


use App\Core\Controller;
use App\Model\Log as Log_Model;
use App\View\Log as Log_View;


class Log extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new Log_Model();

        $this->oView = new Log_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {


        if ($object['operacao'] == "UPDATE") {

            $anterior = $object['anterior'];

            foreach ($object['campo'] as $key => $value) {
                if ($value != $anterior[$key]) {

                    $log['tabela'] = $object['tabela'];
                    $log['campo'] = $key;
                    $log['de'] = $anterior[$key];
                    $log['para'] = $value;
                    $log['id_registro'] = $object['id_registro'];
                    $log['usuario_alteracao'] = $object['usuario_alteracao'];
                    $log['operacao'] = "UPDATE";

                    $this->oModel->populate($log);

                    $result = $this->oModel->create();

                }
            }
        } else if ($object['operacao'] == "INSERT") {

            $this->oModel->populate($object);

            $result = $this->oModel->create();
        }



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


    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}