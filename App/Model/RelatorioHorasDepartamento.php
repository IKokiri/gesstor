<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class RelatorioHorasDepartamento extends Model
{

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function getHorasFuncContrato(){
        $sql = "select * from gesstor.horas 
        where id_tabela = 1 and id_tabela_complemento = :id_contrato and id_funcionario = :id_funcionario and data >= :data_inicio and data <= :data_fim";
        
        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_contrato', $this->id_contrato, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':data_inicio', $this->function->data_br_banco($this->data_inicio), PDO::PARAM_STR);
        $query->bindValue(':data_fim', $this->function->data_br_banco($this->data_fim), PDO::PARAM_STR);
        
        
        $result = Database::executa($query);
     
        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['tempo'] = $linha['tempo'];

            }

            $result['result'] = $array;
        }
        return $result;

    }
    
    public function getAllHoras()
    {
            $and = '';

            if($this->dataInicio){
                $and .= " AND T1.data >= :dataInicio ";
            }

            if($this->dataFim){
                $and .= " AND T1.data <= :dataFim ";
            }
            
            if($this->id_funcionario){
                $and .= " AND T1.id_funcionario = :id_funcionario ";
            }
            
            if($this->id_tipo){
                $and .= " AND T1.id_tabela = :id_tipo ";
            }

            if($this->inContrato && $this->id_tipo == 1){
                 $and .= " AND T1.id_tabela_complemento IN(".$this->inContrato.") ";
            }
            
            if($this->id_centro_custo){
                /**
                 * QUANDO É SELECIONADO APENAS UM CENTRO DE CUSTO  4003 AS HORAS DO MESMO SÃO CHAMADAS
                 * AQUI VERIFICA SE É CHAMADO O 4003 SE FOR É ALTERADO PARA O ID DO 4053 PARA PUXAR AS HORAS DO MESMO
                 */
                $troca = false;
                if($this->id_centro_custo == 36){
                    /**
                     * ID 4053
                     * 435 974 148
                     */
                    $this->id_centro_custo =  32;
                    $troca = true;
                }
                
                $and .= " AND T5.id = :id_centro_custo ";
            }
            
            /**
             * BUSCA TODAS AS INFORMAÇÕES REFERENTES À HORAS NÃO CONSIDERANDO HORAS DE FOLGA ID_TABELA 4
             */
                 $sql = "SELECT 
                        T1.*,
                        T2.nome,
                        T2.sobrenome,
                        T3.aplicacao,
                        T3.alias,
                        T5.id AS idCentroCusto,
                        T5.departamento,
                        T5.centroCusto,
                        T6.valor,
                        T7.valor as valor4003
                    FROM
                        horas T1
                            INNER JOIN
                        funcionarios T2 ON T1.id_funcionario = T2.id
                            INNER JOIN
                        aplicacoes T3 ON T1.id_aplicacao = T3.id
                            LEFT JOIN
                        funcionarios_centro_custos T4 ON T1.id_funcionario = T4.id_funcionario
                            LEFT JOIN
                        centro_custos T5 ON T4.id_centro_custo = T5.id
                            LEFT JOIN
                        custos_hora_departamento T6 ON T5.id = T6.id_centro_custo
                            AND CONCAT(YEAR(T1.data),
                                '-',
                                MONTH(T1.data),
                                '-01') = T6.data
                            LEFT JOIN
                        custos_hora_departamento T7 ON T7.id_centro_custo = 36
                            AND CONCAT(YEAR(T1.data),
                                '-',
                                MONTH(T1.data),
                                '-01') = T7.data
                    WHERE
                        id_tabela != 4 and id_tabela != 3  " . $and . " ORDER BY T1.id_tabela asc, T1.id_tabela_complemento asc";

        $query = $this->dbh->prepare($sql);

        if($this->dataInicio){
            $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        }

        if($this->dataFim){
            $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        }

        if($this->id_funcionario){
            $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        }

        if($this->id_tipo){
            $query->bindValue(':id_tipo', $this->id_tipo, PDO::PARAM_STR);
        }

        if($this->inContrato){
            // $query->bindValue(':id_tabela_complemento', $this->inContrato, PDO::PARAM_STR);
            
        }
        
        
        /**
         * ATENÇÃO 4003 E 4053
         */
        if($this->id_centro_custo){

            /**
             * QUANDO É SELECIONADO APENAS UM CENTRO DE CUSTO  4003 AS HORAS DO MESMO SÃO CHAMADAS
             * AQUI VERIFICA SE É CHAMADO O 4003 SE FOR É ALTERADO PARA O ID DO 4053 PARA PUXAR AS HORAS DO MESMO
             */
            // echo $this->id_centro_custo;
            // if($this->id_centro_custo == '36'){
            //     /**
            //      * ID 4053
            //      */
            //     $this->id_centro_custo =  32;
            //     $troca = true; 
            // }

            $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);

        }
        
        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                /**
                 * DEFINIÇÃO SE É POROPOSTA CONTRATO OU CENTRO DE CUSTO
                 */
                $tipo = '';

                if($linha['id_tabela'] == 1){
                    $tipo = "SC";
                }else if($linha['id_tabela'] == 2){
                    $tipo = "PP";
                }else if($linha['id_tabela'] == 3){
                    $tipo = "CC";
                }

                if(!$troca){
                $id_centro_custo = $linha['idCentroCusto'];

                $data_array = $this->function->data_banco_array($linha['data']);

                $array[$i]['data'] = $linha['data'];

                $array[$i]['data_dia'] = $data_array[0];
                $array[$i]['data_mes'] = $data_array[1];
                $array[$i]['data_ano'] = $data_array[2];

                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_motivo_ausencia'] = $linha['id_motivo_ausencia'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['id_centro_custo'] = $linha['idCentroCusto'];
            
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['aplicacao'] = $linha['aplicacao'];
                $array[$i]['alias'] = $linha['alias'];
                $array[$i]['departamento'] = $linha['departamento'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['tipo'] = $tipo;
                }
                /**
                 * VERIFICA SE É HORA DO 4053 SE FOR É NECESSARIO REPLICAR AS LINHAS PARA QUE
                 * CRIE UM NOVO ARRAY PARA O 4003
                 */
                if(($id_centro_custo == 32 && !$this->id_centro_custo && $tipo != "CC") || $troca){
                
                    $i++;

                    $data_array = $this->function->data_banco_array($linha['data']);

                    $array[$i]['data'] = $linha['data'];
    
                    $array[$i]['data_dia'] = $data_array[0];
                    $array[$i]['data_mes'] = $data_array[1];
                    $array[$i]['data_ano'] = $data_array[2];
    
                    $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                    $array[$i]['id_tabela'] = $linha['id_tabela'];
                    $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                    $array[$i]['tempo'] = $linha['tempo'];
                    $array[$i]['id_motivo_ausencia'] = $linha['id_motivo_ausencia'];
                    $array[$i]['status'] = $linha['status'];
                    $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                
                    $array[$i]['nome'] = $linha['nome'];
                    $array[$i]['sobrenome'] = $linha['sobrenome'];
                    $array[$i]['aplicacao'] = $linha['aplicacao'];
                    $array[$i]['alias'] = $linha['alias'];
                    $array[$i]['valor'] = $linha['valor4003'];
                    $array[$i]['departamento'] = 'MANUT';
                    $array[$i]['centroCusto'] = '4003';                    
                    $array[$i]['tipo'] = $tipo;
                    $id_centro_custo ="";
                }
            }
                
            // print_r($array);

            $result['result'] = $array;
        }
        return $result;
    }


    public function getAllSubContrato()
    {

        $where = $this->buscarWhereData(1);

        $t = '';

        $centroCusto = '';

        if ($this->id_centro_custo) {
            $centroCusto = " and T3.id = " . $this->id_centro_custo . " ";
        }

        $where .= $centroCusto;

        $sql = "select T9.valor as valor4003, T1.data,T1.tempo,T1.id_tabela,T1.id_tabela_complemento,T1.id_aplicacao,T3.centroCusto,T3.departamento,T4.divisao,T5.numero,T5.data_contrato,T6.sigla,T7.aplicacao,T7.alias,T8.valor from horas T1 
                inner join funcionarios_centro_custos T2
                on T1.id_funcionario = T2.id_funcionario
                inner join centro_custos T3
                on T2.id_centro_custo = T3.id
                inner join sub_contratos T4
                on T1.id_tabela_complemento = T4.id
                inner join contratos T5
                on T4.id_contrato = T5.id
                inner join funcionarios T6
                on T4.id_funcionario = T6.id
                inner join aplicacoes T7
                on T1.id_aplicacao = T7.id  
                left join ajustes_custos T9
                on T4.id = T9.id_tabela_complemento and T9.id_centro_custo = '36' and T9.data = '" . $this->data_i . "'
                left join ajustes_custos T8 
                on T4.id = T8.id_tabela_complemento and T8.id_centro_custo = '" . $this->id_centro_custo . "' and T8.data = '" . $this->data_i . "'
                 " . $where . " order by T5.numero asc, T4.divisao asc";


        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array[$i]['numero'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno . " " . $linha['alias'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['valor4003'] = $linha['valor4003'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['alias'] = $linha['alias'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['departamento'] = $linha['centroCusto'] . '<br>' . $linha['departamento'];
                $array[$i]['data_inicio'] = $this->function->data_banco_br($this->data_i);
                $array[$i]['data_fim'] = $this->function->data_banco_br($this->data_f);

            }

            $result['result'] = $array;
        }
        return $result;
    }
    public function getAllBySubContrato()
    {

        $where = $this->buscarWhereData(1);

        $t = '';

        $centroCusto = '';

        if ($this->id_centro_custo) {
            $centroCusto = " and T3.id = " . $this->id_centro_custo . " ";
        }

        $where .= $centroCusto;

        $sql = "select T9.valor as valor4003, T1.data,T1.tempo,T1.id_tabela,T1.id_tabela_complemento,T1.id_aplicacao,T3.centroCusto,T3.departamento,T4.divisao,T5.numero,T5.data_contrato,T6.sigla,T7.aplicacao,T7.alias,T8.valor from horas T1 
                inner join funcionarios_centro_custos T2
                on T1.id_funcionario = T2.id_funcionario
                inner join centro_custos T3
                on T2.id_centro_custo = T3.id
                inner join sub_contratos T4
                on T1.id_tabela_complemento = T4.id
                inner join contratos T5
                on T4.id_contrato = T5.id
                inner join funcionarios T6
                on T4.id_funcionario = T6.id
                inner join aplicacoes T7
                on T1.id_aplicacao = T7.id  
                left join ajustes_custos T9
                on T4.id = T9.id_tabela_complemento and T9.id_centro_custo = '36' and T9.data = '" . $this->data_i . "'
                left join ajustes_custos T8 
                on T4.id = T8.id_tabela_complemento and T8.id_centro_custo = '" . $this->id_centro_custo . "' and T8.data = '" . $this->data_i . "'
                 " . $where . " and T5.id = ".$this->id_contrato."  order by T5.numero asc, T4.divisao asc";


        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array[$i]['numero'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno . " " . $linha['alias'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['valor4003'] = $linha['valor4003'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['alias'] = $linha['alias'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['departamento'] = $linha['centroCusto'] . '<br>' . $linha['departamento'];
                $array[$i]['data_inicio'] = $this->function->data_banco_br($this->data_i);
                $array[$i]['data_fim'] = $this->function->data_banco_br($this->data_f);

            }

            $result['result'] = $array;
        }
        return $result;
    }

    private function buscarWhereData($tabela)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('m/Y');

        $where = '';
        $data_i = '';
        $data_f = '';
        $centroCusto = '';

        if ($this->data_inicio) {
            $data_i = $this->function->data_br_banco($this->data_inicio);
        } else {
            $data_i = $this->function->data_br_banco('01/' . $date);
        }

        if ($this->data_fim) {
            $data_f = $this->function->data_br_banco($this->data_fim);
        } else {
            $data_f = $this->function->data_br_banco('31/' . $date);
        }


        $this->data_i = $data_i;
        $this->data_f = $data_f;
        return $where = " where T1.tempo > 0 and T1.id_tabela = " . $tabela . " and T1.data between '" . $data_i . "' and '" . $data_f . "'";
    }

    public function getSubContratoContrato()
    {
        $sql = "SELECT 
                T1.id,
                T2.id as id_contrato,
                T1.divisao,
                T2.numero,
                T2.divisao as divisao_contrato,
                T2.data_contrato,
                T3.sigla,
                T7.sigla as sigla_contrato,
                T8.tempo,
                T8.data,
                T8.id_funcionario,
                T10.valor,
                (tempo*valor) as total,
                T11.id as id_centro_custo,
                T11.centroCusto
                FROM sub_contratos T1
                inner join contratos T2
                on T1.id_contrato = T2.id
                left join funcionarios T3
                on T1.id_funcionario = T3.id
                left join objetos T4
                on T1.id_objeto = T4.id
                left join funcionarios T5
                on T1.id_gerente = T5.id
                left join funcionarios T6
                on T1.id_responsavel = T6.id
                left join funcionarios T7
                on T2.id_funcionario = T7.id
                inner join horas T8
                on T1.id = T8.id_tabela_complemento
                inner join funcionarios_centro_custos T9
                on T8.id_funcionario = T9.id_funcionario
                left join custos_hora_departamento T10
                on T9.id_centro_custo = T10.id_centro_custo and YEAR(T8.data) = YEAR(T10.data) and MONTH(T8.data) = MONTH(T10.data)
                left join centro_custos T11
                on T9.id_centro_custo = T11.id
                WHERE T2.id = :id_contrato and T8.id_tabela = 1 and tempo != 0 order by T1.divisao asc";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_contrato', $this->id_contrato, PDO::PARAM_STR);

        $result = Database::executa($query);
        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {


                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['divisao'] = $linha['divisao'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['total'] = $linha['total'];
                $array[$i]['contrato'] = $linha['numero'] . "." . $linha['divisao_contrato'] . "-" . $linha['sigla_contrato'] . "-" . $mesAno;
                $array[$i]['sub_contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno;


            }
            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllContrato()
    {

        $where = $this->buscarWhereData(1);

           $sql = "select T1.data,T1.tempo,T1.id_tabela,T1.id_tabela_complemento,T1.id_aplicacao,T3.id as 
                id_centro_custo,T3.centroCusto,T3.departamento,T4.divisao,T5.numero,T5.data_contrato,T6.sigla,
                T7.aplicacao,T7.alias, T9.valor as ajuste4003,T8.valor as ajuste,T4.divisao 
                from horas T1                
                inner join funcionarios_centro_custos T2
                on T1.id_funcionario = T2.id_funcionario
                inner join centro_custos T3
                on T2.id_centro_custo = T3.id
                inner join sub_contratos T4
                on T1.id_tabela_complemento = T4.id
                inner join contratos T5
                on T4.id_contrato = T5.id
                inner join funcionarios T6
                on T4.id_funcionario = T6.id
                inner join aplicacoes T7
                on T1.id_aplicacao = T7.id
                left join ajustes_custos T9
                on T4.id = T9.id_tabela_complemento and T9.id_centro_custo = '36' and T9.data = '" . $this->data_i . "'
                left join ajustes_custos T8
                on T4.id = T8.id_tabela_complemento and T8.id_centro_custo = T2.id_centro_custo and T8.data = '" . $this->data_i . "'
                 " . $where . "  order by T1.data asc,T5.numero asc, T4.divisao asc ";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;


                $array[$i]['divisao'] = $linha['ajusteCustos'];
                $array[$i]['ajuste4003'] = $linha['ajuste4003'];
                $array[$i]['ajuste'] = $linha['ajuste'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['alias'] = $linha['alias'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['departamento'] = $linha['centroCusto'] . '<br>' . $linha['departamento'];
                $array[$i]['data_inicio'] = $this->function->data_banco_br($this->data_i);
                $array[$i]['data_fim'] = $this->function->data_banco_br($this->data_f);

            }

            

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllContratoDetalhado()
    {

        $where = $this->buscarWhereData(1);

        $sql = "select T1.data,T1.tempo,T1.id_tabela,T1.id_tabela_complemento,T1.id_aplicacao,T3.id as 
                id_centro_custo,T3.centroCusto,T3.departamento,T4.divisao,T5.numero,T5.data_contrato,T6.sigla,
                T7.aplicacao,T7.alias from horas T1 
                inner join funcionarios_centro_custos T2
                on T1.id_funcionario = T2.id_funcionario
                inner join centro_custos T3
                on T2.id_centro_custo = T3.id
                inner join sub_contratos T4
                on T1.id_tabela_complemento = T4.id
                inner join contratos T5
                on T4.id_contrato = T5.id
                inner join funcionarios T6
                on T4.id_funcionario = T6.id
                inner join aplicacoes T7
                on T1.id_aplicacao = T7.id
                 " . $where . " order by T1.data asc,T5.numero asc, T4.divisao asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['alias'] = $linha['alias'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['departamento'] = $linha['centroCusto'] . '<br>' . $linha['departamento'];
                $array[$i]['data_inicio'] = $this->function->data_banco_br($this->data_i);
                $array[$i]['data_fim'] = $this->function->data_banco_br($this->data_f);

            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllProposta()
    {
        $where = $this->buscarWhereData(2);

        $t = '';

        $centroCusto = '';

        if ($this->id_centro_custo) {
            $centroCusto = " and T3.id = " . $this->id_centro_custo . " ";
        }

        $where .= $centroCusto;

        $sql = "select  T9.valor as valor4003,T1.data,T1.tempo,T1.id_tabela,T1.id_tabela_complemento,T4.revisao,T3.centroCusto,T3.departamento,T4.numero,T5.sigla,T4.data as data_proposta,T6.razao_social,T7.aplicacao,T8.valor from horas T1 
                inner join funcionarios_centro_custos T2
                on T1.id_funcionario = T2.id_funcionario
                inner join centro_custos T3
                on T2.id_centro_custo = T3.id
                inner join numero_orcamentos T4
                on T1.id_tabela_complemento = T4.id
                inner join funcionarios T5
                on T4.id_funcionario = T5.id
                inner join clientes T6
                on T4.id_cliente = T6.id  
                inner join aplicacoes T7
                on T1.id_aplicacao = T7.id
                left join ajustes_custos T9
                on T4.id = T9.id_tabela_complemento and T9.id_centro_custo = '36' and T9.data = '" . $this->data_i . "'
                left join ajustes_custos T8
                on T4.id = T8.id_tabela_complemento and T8.id_centro_custo = '" . $this->id_centro_custo . "' and T8.data = '" . $this->data_i . "'
                 " . $where . " order by T4.numero asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $dataAno = $this->function->data_banco_br($linha['data_proposta']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

//                $array[$i]['numero'] = $linha['numero'] . '.' . $linha['revisao'] . '-' . $linha['sigla'] . '-' . $mesAno . '-' . $linha['razao_social'];
                $array[$i]['numero'] = $linha['numero'] . '.' . $linha['revisao'] . '-' . $linha['sigla'] . '-' . $mesAno . " " . $linha['alias'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['valor4003'] = $linha['valor4003'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['departamento'] = $linha['centroCusto'] . '<br>' . $linha['departamento'];
                $array[$i]['data_inicio'] = $this->function->data_banco_br($this->data_i);
                $array[$i]['data_fim'] = $this->function->data_banco_br($this->data_f);
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllCentroCusto()
    {
        $where = $this->buscarWhereData(3);

        $t = '';

        $centroCusto = '';

        if ($this->id_centro_custo) {
            $centroCusto = " and T3.id = " . $this->id_centro_custo . " ";
        }

        $where .= $centroCusto;

        $sql = "select T1.data,T1.tempo,T1.id_tabela,T1.id_tabela_complemento,T3.centroCusto,T3.departamento,T4.departamento as numero,T4.centroCusto as numeroCentroCusto,T5.aplicacao from horas T1 
                inner join funcionarios_centro_custos T2
                on T1.id_funcionario = T2.id_funcionario
                inner join centro_custos T3
                on T2.id_centro_custo = T3.id
                inner join centro_custos T4
                on T1.id_tabela_complemento = T4.id  
                inner join aplicacoes T5
                on T1.id_aplicacao = T5.id
                 " . $where . " order by T4.centroCusto asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['numero'] = $linha['numeroCentroCusto'] . " " . $linha['numero'] . " " . $linha['alias'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['numeroCentroCusto'] = $linha['numeroCentroCusto'];
                $array[$i]['departamento'] = $linha['centroCusto'] . '<br>' . $linha['departamento'];
                $array[$i]['data_inicio'] = $this->function->data_banco_br($this->data_i);
                $array[$i]['data_fim'] = $this->function->data_banco_br($this->data_f);
            }

            $result['result'] = $array;
        }
        return $result;
    }


    function populate($object)
    {
        foreach ($object as $key => $attrib) {
            $this->$key = $attrib;
        }
    }


}