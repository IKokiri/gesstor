<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';
require_once PAGSEGURO.DS."PagSeguroLibrary.php";


use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;
use App\Model\ServicoArea;
use PagSeguroConfig;
use PagSeguroSessionService;
use SimpleXMLElement;

class PagSeguro extends Model
{
    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    function getSessionId(){
        $sessionId = '';
        try {

            $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()
            $sessionId = PagSeguroSessionService::getSession($credentials);
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }

        $array['sessionId'] = $sessionId;

        return $array;
    }

    function gerarBoleto(){

        //NO PAGAMENTOCLIENTE TEM Q INSERIR O TOKEM TBM
        $postFields = array(
            "email"=>"financeiro@softwarestella.com",
            "token"=>"2210B41B40D14735BE5476C91875741D",
            "paymentMode"=>"default",
            "paymentMethod"=>"boleto",
            "receiverEmail"=>"financeiro@softwarestella.com",
            "currency"=>"BRL",
            "extraAmount"=>"0.00",
            "itemId1"=>"0001",
            "itemDescription1"=>$this->identificador,
            "itemAmount1"=>$this->valor_servico,
            "itemQuantity1"=>"1",
            "notificationURL"=>"https://softwarestella.com",
            "reference"=>$this->id_cobranca,
            "senderName"=>$this->nome.$this->razao_social." ".$this->sobrenome.$this->fantasia,
            "senderCPF"=>"09997060636",
            "senderAreaCode"=>"31",
            "senderPhone"=>"998956980",
            "senderEmail"=>$this->email,
            "senderHash"=>$this->hash,
            "shippingAddressStreet"=>$this->rua,
            "shippingAddressNumber"=>$this->numero,
            "shippingAddressComplement"=>$this->numero,
            "shippingAddressDistrict"=>$this->bairro,
            "shippingAddressPostalCode"=>$this->cep,
            "shippingAddressCity"=>$this->uf,
            "shippingAddressState"=>$this->uf,
            "shippingAddressCountry"=>"BRA",
            "shippingType"=>"3",
            "shippingCost"=>"0.00"
        );

        $charset = 'ISO-8859-1';
        $url = "https://ws.pagseguro.uol.com.br/v2/transactions/";

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded; charset=" . $charset
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_POST => false,
            CURLOPT_POSTFIELDS => http_build_query($postFields),
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $retorno = curl_exec ($curl);



        curl_close ($curl);

        $transaction = new SimpleXMLElement($retorno);

       return $transaction;
    }


    function populate($object)
    {
        foreach ($object as $key => $attrib) {
           $this->$key = $attrib;
        }
    }
}