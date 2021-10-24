<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'PagSeguro.php';
require_once MODEL . DS . 'Cobranca.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\PagSeguro as PagSeguro_Model;
use App\View\PagSeguro as PagSeguro_View;
use App\Model\Cobranca as Cobranca_Model;

class PagSeguro extends Controller
{

    private $oModel;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new PagSeguro_Model();

    }

    public function getSessionId()
    {
        $result = $this->oModel->getSessionId();

        echo json_encode($result);
    }

    public function gerarBoleto($object)
    {
        $oCobranca =  new Cobranca_Model();

        $array['id'] = $object['id_cobranca'];

        $oCobranca->populate($array);

        $result = $oCobranca->getById();

        $result['result']['hash'] = $object['hash'];

        $dados_gera_boleto = $result['result'];

        $this->oModel->populate($dados_gera_boleto);

        $result_pag = $this->oModel->gerarBoleto();

        $array['paymentLink'] = (string)$result_pag->paymentLink;

        $array['id'] = $object['id_cobranca'];

        $oCobranca = new Cobranca_Model();

        $oCobranca->transection();

        $oCobranca->populate($array);

        $oCobranca->update_link($array);

        $oCobranca->commit();

        echo json_encode($result_pag);
    }



    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}