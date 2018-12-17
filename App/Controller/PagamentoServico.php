<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'PagamentoServico.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\PagamentoServico as PagamentoServico_Model;
use App\View\PagamentoServico as PagamentoServico_View;

class PagamentoServico extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new PagamentoServico_Model();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function getAllCliente()
    {
        $result = $this->oModel->getAllCliente();

        echo json_encode($result);
    }


}