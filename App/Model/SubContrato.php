<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';
//CLOG
require_once CONTROLLER . DS . 'Log.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;
//CLOG
use App\Controller\Log as Log_Controller;

class SubContrato extends Model
{
    private $table = 'sub_contratos';

    private $validator;

    public function __construct()
    {
        parent::__construct();
        //CLOG
        $this->log = new Log_Controller();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Divisao', $this->divisao)->is_required();
        $this->validator->set('Funcionario', $this->id_funcionario)->is_required();

        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " " .
            "(divisao,id_contrato,id_funcionario,id_objeto,id_gerente,id_responsavel,status,observacao,bloquear_em_horas) 
                VALUES 
                (:divisao,:id_contrato,:id_funcionario,:id_objeto,:id_gerente,:id_responsavel,:status,:observacao,:bloquear_em_horas)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':divisao', $this->divisao, PDO::PARAM_STR);
        $query->bindValue(':id_contrato', $this->id_contrato, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_objeto', $this->id_objeto, PDO::PARAM_STR);
        $query->bindValue(':id_gerente', $this->id_gerente, PDO::PARAM_STR);
        $query->bindValue(':id_responsavel', $this->id_responsavel, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':bloquear_em_horas', $this->bloquear_em_horas, PDO::PARAM_STR);

        $result = Database::executa($query);
//CLOG
        if ($result['result']) {

            $log['tabela'] = $this->table;
            $log['campo'] = '';
            $log['de'] = '';
            $log['para'] = '';
            $log['id_registro'] = $result['lastId'];
            $log['usuario_alteracao'] = $result['lastId'];
            $log['usuario_alteracao'] = $_SESSION['gesstor']['login']['id'];
            $log['operacao'] = "INSERT";
            $this->log->create($log);
        }
        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

//CLOG
        $anterior = $this->getById();
        $anterior = $anterior['result'];

        $sql = "UPDATE " . $this->table . " 
                SET 
                divisao = :divisao,
                observacao = :observacao,
                id_funcionario = :id_funcionario,
                id_objeto = :id_objeto,
                id_gerente = :id_gerente,
                id_responsavel = :id_responsavel,
                bloquear_em_horas = :bloquear_em_horas,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':divisao', $this->divisao, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
        $query->bindValue(':id_objeto', $this->id_objeto, PDO::PARAM_STR);
        $query->bindValue(':id_gerente', $this->id_gerente, PDO::PARAM_STR);
        $query->bindValue(':id_responsavel', $this->id_responsavel, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':bloquear_em_horas', $this->bloquear_em_horas, PDO::PARAM_STR);

        $result = Database::executa($query);
//CLOG
        if ($result['result']) {

            $campo['divisao'] = $this->divisao;
            $campo['observacao'] = $this->observacao;
            $campo['id_funcionario'] = $this->id_funcionario;
            $campo['id_objeto'] = $this->id_objeto;
            $campo['id_gerente'] = $this->id_gerente;
            $campo['id_responsavel'] = $this->id_responsavel;
            $campo['status'] = $this->status;


            $log['tabela'] = $this->table;
            $log['campo'] = $campo;
            $log['anterior'] = $anterior;
            $log['de'] = '';
            $log['para'] = '';
            $log['id_registro'] = $this->id;
            $log['usuario_alteracao'] = $_SESSION['gesstor']['login']['id'];
            $log['operacao'] = "UPDATE";
            $this->log->create($log);
        }
        return $result;
    }

    public function getAllRelatorio()
    {
        $sql = "SELECT 
                    T1.id,T1.id_contrato,T1.divisao, T2.numero, T2.data_contrato, T3.sigla
                FROM
                    sub_contratos T1
                        INNER JOIN
                    contratos T2 ON T1.id_contrato = T2.id
                        INNER JOIN
                    funcionarios T3 ON T1.id_funcionario = T3.id
                    ORDER BY T2.numero asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {


                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $id = $linha['id'];

                $array[$id]['id'] = $id;
                $array[$id]['numero'] = $linha['numero'];
                $array[$id]['divisao'] = $linha['divisao'];
                $array[$id]['id_contrato'] = $linha['id_contrato'];
                $array[$id]['sigla'] = $linha['sigla'];
                $array[$id]['data'] = $mesAno;

                $array[$id]['alias'] = $linha['numero'].'.'.$linha['divisao'].'-'.$linha['sigla'].'-'.$mesAno;
            }

            $result['result'] = $array;
        }
        
        return $result;
    }


    public function verificarBloqueioHoras(){
        
         $sql = "SELECT T1.* FROM " . $this->table . " T1
        WHERE id = :id_tabela_complemento and bloquear_em_horas = 'A'";
    
        $query = $this->dbh->prepare($sql);
    
        $query->bindValue(':id_tabela_complemento', $this->id_tabela_complemento, PDO::PARAM_STR);
    
    
        $result = Database::executa($query);

        if($result['count']){
            return true;
        }
            return false;
        

        
    }

    public function getById()
    {
        $this->validator->set('Id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.* FROM " . $this->table . " T1
        WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['divisao'] = $linha['divisao'];
                $array['id_contrato'] = $linha['id_contrato'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['id_objeto'] = $linha['id_objeto'];
                $array['observacao'] = $linha['observacao'];
                $array['id_gerente'] = $linha['id_gerente'];
                $array['bloquear_em_horas'] = $linha['bloquear_em_horas'];
                $array['id_responsavel'] = $linha['id_responsavel'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {
        $sql = "SELECT 
                T1.id,
                T1.divisao,
                T1.id_contrato,
                T1.id_funcionario,
                T1.id_objeto,
                T1.id_gerente,
                T1.id_responsavel,
                T1.bloquear_em_horas,
                T1.status,
                T2.numero,
                T2.divisao as divisao_contrato,
                T2.data_contrato,
                T3.nome,
                T3.sobrenome,
                T3.sigla,
                T4.objeto,
                T5.nome as nome_gerente,
                T5.sobrenome as sobrenome_gerente,
                T6.nome as nome_responsavel,
                T6.sobrenome as sobrenome_responsavel,
                T7.sigla as sigla_contrato
                FROM " . $this->table . " T1
                inner join contratos T2
                on T1.id_contrato = T2.id
                LEFT join funcionarios T3
                on T1.id_funcionario = T3.id
                LEFT join objetos T4
                on T1.id_objeto = T4.id
                LEFT join funcionarios T5
                on T1.id_gerente = T5.id
                LEFT join funcionarios T6
                on T1.id_responsavel = T6.id
                LEFT join funcionarios T7
                on T2.id_funcionario = T7.id
                order by T2.numero asc,T1.divisao asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {


                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array[$i]['id'] = $linha['id'];
                $array[$i]['divisao'] = $linha['divisao'];
                $array[$i]['id_contrato'] = $linha['id_contrato'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_objeto'] = $linha['id_objeto'];
                $array[$i]['id_gerente'] = $linha['id_gerente'];
                $array[$i]['id_responsavel'] = $linha['id_responsavel'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['bloquear_em_horas'] = $linha['bloquear_em_horas'];
                $array[$i]['funcionario'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $array[$i]['gerente'] = $linha['nome_gerente'] . ' ' . $linha['sobrenome_gerente'];
                $array[$i]['responsavel'] = $linha['nome_responsavel'] . ' ' . $linha['sobrenome_responsavel'];
                $array[$i]['contrato'] = $linha['numero'] . "." . $linha['divisao_contrato'] . "-" . $linha['sigla_contrato'] . "-" . $mesAno;
                $array[$i]['sub_contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno;


            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllHoras()
    {
        $sql = "SELECT 
                T1.id,
                T1.divisao,
                T1.id_contrato,
                T1.id_funcionario,
                T1.id_objeto,
                T1.id_gerente,
                T1.id_responsavel,
                T1.status,
                T2.numero,
                c.nome as cliente,
                T2.divisao as divisao_contrato,
                T2.data_contrato,
                T3.nome,
                T3.sobrenome,
                T3.sigla,
                T4.objeto,
                T5.nome as nome_gerente,
                T5.sobrenome as sobrenome_gerente,
                T6.nome as nome_responsavel,
                T6.sobrenome as sobrenome_responsavel,
                T7.sigla as sigla_contrato
                FROM " . $this->table . " T1
                inner join contratos T2
                on T1.id_contrato = T2.id and if(T2.tipo = 1, T1.divisao != '00', T1.divisao >= '00')
                LEFT JOIN clientes c
                on T2.id_cliente = c.id
                LEFT join funcionarios T3
                on T1.id_funcionario = T3.id
                LEFT join objetos T4
                on T1.id_objeto = T4.id
                LEFT join funcionarios T5
                on T1.id_gerente = T5.id
                LEFT join funcionarios T6
                on T1.id_responsavel = T6.id
                LEFT join funcionarios T7
                on T2.id_funcionario = T7.id
                order by T2.numero asc,T1.divisao asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {


                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array[$i]['id'] = $linha['id'];
                $array[$i]['divisao'] = $linha['divisao'];
                $array[$i]['id_contrato'] = $linha['id_contrato'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_objeto'] = $linha['id_objeto'];
                $array[$i]['id_gerente'] = $linha['id_gerente'];
                $array[$i]['id_responsavel'] = $linha['id_responsavel'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['funcionario'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $array[$i]['gerente'] = $linha['nome_gerente'] . ' ' . $linha['sobrenome_gerente'];
                $array[$i]['responsavel'] = $linha['nome_responsavel'] . ' ' . $linha['sobrenome_responsavel'];
                $array[$i]['contrato'] = $linha['numero'] . "." . $linha['divisao_contrato'] . "-" . $linha['sigla_contrato'] . "-" . $mesAno;
                $array[$i]['sub_contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno. "-" . $linha['cliente'];
                


            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getJoinId()
    {
        $sql = "SELECT 
                T1.id,
                T1.divisao,
                T1.id_contrato,
                T1.id_funcionario,
                T1.id_objeto,
                T1.id_gerente,
                T1.id_responsavel,
                T1.status,
                T2.numero,
                T2.divisao as divisao_contrato,
                T2.data_contrato,
                T3.nome,
                T3.sobrenome,
                T3.sigla,
                T4.objeto,
                T5.nome as nome_gerente,
                T5.sobrenome as sobrenome_gerente,
                T6.nome as nome_responsavel,
                T6.sobrenome as sobrenome_responsavel,
                T7.sigla as sigla_contrato,
                T8.nome as nome_cliente
                FROM " . $this->table . " T1
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
                left join clientes T8
                on T2.id_cliente = T8.id
               WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);
        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {


                $dataAno = $this->function->data_banco_br($linha['data_contrato']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $array['id'] = $linha['id'];
                $array['divisao'] = $linha['divisao'];
                $array['id_contrato'] = $linha['id_contrato'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['id_objeto'] = $linha['id_objeto'];
                $array['id_gerente'] = $linha['id_gerente'];
                $array['id_responsavel'] = $linha['id_responsavel'];
                $array['status'] = $linha['status'];
                $array['nome_cliente'] = $linha['nome_cliente'];
                $array['objeto'] = $linha['objeto'];
                $array['funcionario'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $array['gerente'] = $linha['nome_gerente'] . ' ' . $linha['sobrenome_gerente'];
                $array['responsavel'] = $linha['nome_responsavel'] . ' ' . $linha['sobrenome_responsavel'];
                $array['contrato'] = $linha['numero'] . "." . $linha['divisao_contrato'] . "-" . $linha['sigla_contrato'] . "-" . $mesAno;
                $array['sub_contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno;


            }
            $result['result'] = $array;
        }
        return $result;
    }

    public function getSubContratoContrato()
    {
        $sql = "SELECT 
                T1.id,
                T1.divisao,
                T1.id_contrato,
                T1.id_funcionario,
                T1.id_objeto,
                T1.id_gerente,
                T1.id_responsavel,
                T1.status,
                T2.numero,
                T2.divisao as divisao_contrato,
                T2.data_contrato,
                T3.nome,
                T3.sobrenome,
                T3.sigla,
                T4.objeto,
                T5.nome as nome_gerente,
                T5.sobrenome as sobrenome_gerente,
                T6.nome as nome_responsavel,
                T6.sobrenome as sobrenome_responsavel,
                T7.sigla as sigla_contrato
                FROM " . $this->table . " T1
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
                WHERE T2.id = :id_contrato";

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

                $array['id'] = $linha['id'];
                $array['divisao'] = $linha['divisao'];
                $array['id_contrato'] = $linha['id_contrato'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['id_objeto'] = $linha['id_objeto'];
                $array['id_gerente'] = $linha['id_gerente'];
                $array['id_responsavel'] = $linha['id_responsavel'];
                $array['status'] = $linha['status'];
                $array['objeto'] = $linha['objeto'];
                $array['funcionario'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $array['gerente'] = $linha['nome_gerente'] . ' ' . $linha['sobrenome_gerente'];
                $array['responsavel'] = $linha['nome_responsavel'] . ' ' . $linha['sobrenome_responsavel'];
                $array['contrato'] = $linha['numero'] . "." . $linha['divisao_contrato'] . "-" . $linha['sigla_contrato'] . "-" . $mesAno;
                $array['sub_contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno;


            }
            $result['result'] = $array;
        }
        return $result;
    }

    public function getSubContratosContrato()
    {
        $sql = "SELECT 
                T1.id,
                T1.divisao,
                T1.id_contrato,
                T1.id_funcionario,
                T1.id_objeto,
                T1.id_gerente,
                T1.id_responsavel,
                T1.status,
                T2.numero,
                T2.divisao as divisao_contrato,
                T2.data_contrato,
                T3.nome,
                T3.sobrenome,
                T3.sigla,
                T4.objeto,
                T5.nome as nome_gerente,
                T5.sobrenome as sobrenome_gerente,
                T6.nome as nome_responsavel,
                T6.sobrenome as sobrenome_responsavel,
                T7.sigla as sigla_contrato
                FROM " . $this->table . " T1
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
                WHERE T2.id = :id_contrato";

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

                $array[$i]['id'] = $linha['id'];
                $array[$i]['divisao'] = $linha['divisao'];
                $array[$i]['id_contrato'] = $linha['id_contrato'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_objeto'] = $linha['id_objeto'];
                $array[$i]['id_gerente'] = $linha['id_gerente'];
                $array[$i]['id_responsavel'] = $linha['id_responsavel'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['funcionario'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $array[$i]['gerente'] = $linha['nome_gerente'] . ' ' . $linha['sobrenome_gerente'];
                $array[$i]['responsavel'] = $linha['nome_responsavel'] . ' ' . $linha['sobrenome_responsavel'];
                $array[$i]['contrato'] = $linha['numero'] . "." . $linha['divisao_contrato'] . "-" . $linha['sigla_contrato'] . "-" . $mesAno;
                $array[$i]['sub_contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno;


            }
            $result['result'] = $array;
        }
        return $result;
    }

    public function delete()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM " . $this->table . " 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    function populate($object)
    {
        foreach ($object as $key => $attrib) {
            $this->$key = $attrib;
        }
    }


}