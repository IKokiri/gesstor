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

class Contrato extends Model
{
    private $table = 'contratos';

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
        $this->validator->set('Tipo', $this->tipo)->is_required()->is_num();

        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " " .
            "(numero,divisao,id_funcionario,id_cliente,id_objeto,data_fim,id_gerente,id_responsavel," .
            "data_inicio,data_contrato,id_proposta,tipo,status,observacao) 
                VALUES 
                (:numero,:divisao,:id_funcionario,:id_cliente,:id_objeto,:data_fim,:id_gerente,:id_responsavel," .
            ":data_inicio,:data_contrato,:id_proposta,:tipo,:status,:observacao)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);
        $query->bindValue(':divisao', $this->divisao, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_STR);
        $query->bindValue(':id_objeto', $this->id_objeto, PDO::PARAM_STR);
        $query->bindValue(':data_fim', $this->function->data_br_banco($this->data_fim), PDO::PARAM_STR);
        $query->bindValue(':id_gerente', $this->id_gerente, PDO::PARAM_STR);
        $query->bindValue(':id_responsavel', $this->id_responsavel, PDO::PARAM_STR);
        $query->bindValue(':data_inicio', $this->function->data_br_banco($this->data_inicio), PDO::PARAM_STR);
        $query->bindValue(':data_contrato', $this->function->data_br_banco($this->data_contrato), PDO::PARAM_STR);
        $query->bindValue(':id_proposta', $this->id_proposta, PDO::PARAM_STR);
        $query->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

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


    public function getNext()
    {

        $sql = "SELECT * FROM " . $this->table . " " .
            "WHERE tipo = :tipo " .
            "order by numero desc limit 1";

        $query = $this->dbh->prepare($sql);
        $query->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['numero'] = $linha['numero'] + 1;
            }

        } else {
            $array['numero'] = 1;
        }

        $result['result'] = $array;

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
//        "(numero,divisao,id_funcionario,id_cliente,id_objeto,data_fim,id_gerente,id_responsavel," .
//        "data_inicio,data_contrato,id_proposta,tipo,status,observacao)
//CLOG
        $anterior = $this->getById();
        $anterior = $anterior['result'];

        $sql = "UPDATE " . $this->table . " 
                SET 
                divisao = :divisao,
                id_funcionario = :id_funcionario,
                id_cliente = :id_cliente,
                id_objeto = :id_objeto,
                data_fim = :data_fim,
                id_gerente = :id_gerente,
                id_responsavel = :id_responsavel,
                data_inicio = :data_inicio,
                data_contrato = :data_contrato,
                id_proposta = :id_proposta,
                observacao = :observacao,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
        $query->bindValue(':divisao', $this->divisao, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_STR);
        $query->bindValue(':id_objeto', $this->id_objeto, PDO::PARAM_STR);
        $query->bindValue(':data_fim', $this->function->data_br_banco($this->data_fim), PDO::PARAM_STR);
        $query->bindValue(':id_gerente', $this->id_gerente, PDO::PARAM_STR);
        $query->bindValue(':id_responsavel', $this->id_responsavel, PDO::PARAM_STR);
        $query->bindValue(':data_inicio', $this->function->data_br_banco($this->data_inicio), PDO::PARAM_STR);
        $query->bindValue(':data_contrato', $this->function->data_br_banco($this->data_contrato), PDO::PARAM_STR);
        $query->bindValue(':id_proposta', $this->id_proposta, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);
//CLOG
        if ($result['result']) {

            $campo['divisao'] = $this->divisao;
            $campo['id_funcionario'] = $this->id_funcionario;
            $campo['id_cliente'] = $this->id_cliente;
            $campo['id_objeto'] = $this->id_objeto;
            $campo['data_fim'] = $this->data_fim;
            $campo['id_gerente'] = $this->id_gerente;
            $campo['id_responsavel'] = $this->id_responsavel;
            $campo['data_inicio'] = $this->data_inicio;
            $campo['data_contrato'] = $this->data_contrato;
            $campo['id_proposta'] = $this->id_proposta;
            $campo['observacao'] = $this->observacao;
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
                $array['numero'] = $linha['numero'];
                $array['divisao'] = $linha['divisao'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['id_cliente'] = $linha['id_cliente'];
                $array['id_objeto'] = $linha['id_objeto'];
                $array['data_fim'] = $this->function->data_banco_br($linha['data_fim']);
                $array['observacao'] = $linha['observacao'];
                $array['id_gerente'] = $linha['id_gerente'];
                $array['id_responsavel'] = $linha['id_responsavel'];
                $array['data_inicio'] = $this->function->data_banco_br($linha['data_inicio']);
                $array['data_contrato'] = $this->function->data_banco_br($linha['data_contrato']);
                $array['id_proposta'] = $linha['id_proposta'];
                $array['tipo'] = $linha['tipo'];
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
                T1.numero,
                T1.divisao,
                T1.data_fim,
                T1.data_inicio,
                T1.data_contrato,
                T1.tipo,
                T1.status,
                T2.nome,
                T2.sobrenome,
                T2.sigla,
                T3.razao_social,
                T3.tipo_pessoa,
                T3.cpf,
                T3.cnpj,
                T3.nome as nome_cliente,
                T3.nome_reduzido as nome_reduzido,
                T3.sobrenome as sobrenome_cliente,
                T4.objeto,
                T5.numero as numero_proposta,
                T5.revisao as revisao_proposta,
                T5.tipo as tipo_proposta,
                T6.nome as nome_gerente,
                T6.sobrenome as sobrenome_gerente,
                T6.sigla as sigla_gerente,
                T7.nome as nome_responsavel,
                T7.sobrenome as sobrenome_responsavel,
                T7.sigla as sigla_responsavel
                FROM " . $this->table . " T1
                LEFT JOIN funcionarios T2
                on T1.id_funcionario = T2.id
                LEFT JOIN clientes T3
                on T1.id_cliente = T3.id
                LEFT JOIN objetos T4
                on T1.id_objeto = T4.id
                LEFT JOIN numero_orcamentos T5
                on T1.id_proposta = T5.id
                LEFT JOIN funcionarios T6
                on T1.id_gerente = T6.id
                LEFT JOIN funcionarios T7
                on T1.id_responsavel = T7.id ";

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
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['divisao'] = $linha['divisao'];
                $array[$i]['data_fim'] = $this->function->data_banco_br($linha['data_fim']);
                $array[$i]['data_inicio'] = $this->function->data_banco_br($linha['data_inicio']);
                $array[$i]['data_contrato'] = $this->function->data_banco_br($linha['data_contrato']);
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['tipoTela'] = ($linha['tipo'] * 1000);
                $array[$i]['status'] = $linha['status'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['nome_reduzido'] = $linha['nome_reduzido'];
                $array[$i]['razao_social'] = $linha['razao_social'];
                $array[$i]['sigla_responsavel'] = $linha['sigla_responsavel'];
                $array[$i]['sigla_gerente'] = $linha['sigla_gerente'];
                $array[$i]['nome_cliente'] = $linha['nome_cliente'];
                $array[$i]['numero_proposta'] = $linha['numero_proposta'];
                $array[$i]['numero_proposta_tela'] = str_pad($linha['numero_proposta'], $linha['tipo_proposta'], 0, STR_PAD_LEFT);
                $array[$i]['revisao_proposta'] = $linha['revisao_proposta'];
                $array[$i]['revisao_proposta_tela'] = str_pad($linha['revisao_proposta'], 2, 0, STR_PAD_LEFT);
                $array[$i]['nome_gerente'] = $linha['nome_gerente'];
                $array[$i]['sobrenome_gerente'] = $linha['sobrenome_gerente'];
                $array[$i]['nome_responsavel'] = $linha['nome_responsavel'];
                $array[$i]['sobrenome_responsavel'] = $linha['sobrenome_responsavel'];
                if ($linha['tipo_pessoa'] == "Jurídica") {
                    $array[$i]['identificador'] = $linha['razao_social'] . " - " . $linha['cnpj'];
                } else {
                    $array[$i]['identificador'] = $linha['nome_cliente'] . " " . $linha['sobrenome_cliente'] . " - " . $linha['cpf'];
                }

                $array[$i]['mesAno'] = $mesAno;
                $array[$i]['contrato'] = $linha['numero'] . "." . $linha['divisao'] . "-" . $linha['sigla'] . "-" . $mesAno;


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