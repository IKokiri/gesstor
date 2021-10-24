<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';
require_once MODEL . DS . 'ServicoArea.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;
use App\Model\ServicoArea;

class PagamentoServico extends ServicoArea
{
    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function getAllCliente()
    {

        $sql = "SELECT T1.*,T2.servico,T2.icone,T3.valor_servico,T3.link_pagamento_gerado,T3.id as id_cobranca,T3.id_servico_cliente,T3.dia_vencimento,T3.status as status_cobranca  FROM " . $this->table . " T1
                 INNER JOIN servicos T2
                    on T1.id_servico = T2.id
                INNER JOIN cobrancas T3
                    on T1.ID = T3.id_servico_cliente
                 WHERE T1.id_area = :id";

        $query = $this->dbh->prepare($sql);
//        echo $_SESSION['gesstor']['login']['id_area'];

        $query->bindValue(':id', $_SESSION['gesstor']['login']['id_area'], PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['id_servico'] = $linha['id_servico'];
                $array[$i]['link_pagamento_gerado'] = $linha['link_pagamento_gerado'];
                $array[$i]['id_cobranca'] = $linha['id_cobranca'];
                $array[$i]['valor_servico'] = $linha['valor_servico'];
                $array[$i]['id_servico_cliente'] = $linha['id_servico_cliente'];
                $array[$i]['identificador'] = $linha['identificador'];
                $array[$i]['icone'] = $linha['icone'];
                $array[$i]['id_area'] = $linha['id_area'];
                $array[$i]['dia_vencimento'] = $this->function->data_banco_br($linha['dia_vencimento']);
                $array[$i]['status_cobranca'] = $linha['status_cobranca'];
            }

                $arrayR = [];

                $temp = [];

            foreach ($array as $campos) {

                if(!in_array($campos['id_servico_cliente'],$temp)){

                    $status = 0;
                    $xml = '';
                    $service = "https://ws.pagseguro.uol.com.br/v2/transactions/?email=financeiro@softwarestella.com&token=2210B41B40D14735BE5476C91875741D&reference=" . $campos['id_cobranca'];

                    $xml = simplexml_load_file($service);

                    if ($xml->resultsInThisPage != 0) {
                        $status = (string) $xml->transactions->transaction->status;
                    }
                    $campos['status_cobranca'] = $status;
                    $arrayR[] = $campos;
                    $temp[] = $campos['id_servico_cliente'];

                }

            }
//            print_r($temp);
            $result['result'] = $arrayR;
        }
        return $result;
    }




}