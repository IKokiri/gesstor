<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class ChamadoCliente extends Model
{
    private $table = 'chamados';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {

        $sql = "INSERT INTO `" . $this->table . "` (id_usuario,id_servico_cliente,descricao,assunto,status,data_criado,hora_criado,id_chamado) VALUES (:id_usuario,:id_servico_cliente,:descricao,:assunto,'1',curdate(),curtime(),:id_chamado)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_usuario', $_SESSION['gesstor']['login']['id'], PDO::PARAM_STR);
        $query->bindValue(':id_servico_cliente', $this->id_servico_cliente, PDO::PARAM_STR);
        $query->bindValue(':descricao', $this->descricao, PDO::PARAM_STR);
        $query->bindValue(':assunto', $this->assunto, PDO::PARAM_STR);
        $query->bindValue(':id_chamado', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getAll()
    {

        $sql = "SELECT T1.*,T3.servico,T4.nome,T4.fantasia as fantasia_f,T6.nome as nome_f,T6.fantasia,T5.cor,T5.status as descricao_status FROM `" . $this->table . "` T1 
                   left join servicos_areas T2
                    on T1.id_servico_cliente = T2.id
                  left join servicos T3
                    on T2.id_servico = T3.id
                  left join clientes T4
					on T2.id_area = T4.id and T1.id_chamado = 0
                  left join funcionarios T6
					on T2.id_area = T6.id and T1.id_chamado = 0
                  left join status T5
					on T1.status = T5.id where T1.id_chamado = 0";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);


        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_servico_cliente'] = $linha['id_servico_cliente'];
                $array[$i]['assunto'] = $linha['assunto'];
                $array[$i]['identifica'] = $linha['nome'] . $linha['fantasia'] . $linha['nome_f'] . $linha['fantasia_f'];
                $array[$i]['descricao'] = $linha['descricao'];
                $array[$i]['descricao_status'] = $linha['descricao_status'];
                $array[$i]['cor'] = $linha['cor'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['data_criado'] = $this->function->data_banco_br($linha['data_criado']);
                $array[$i]['hora_criado'] = $linha['hora_criado'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllFilter()
    {
//        $and = " and T1.data_criado >= '" . $this->function->data_br_banco($this->data_inicio) . "' and '" . $this->function->data_br_banco($this->data_fim) . "' >= T1.data_criado";
        $and = " and T1.data_criado between '" . $this->function->data_br_banco($this->data_inicio) . "' and '" . $this->function->data_br_banco($this->data_fim) . "' ";

        $and = ($this->data_inicio && $this->data_fim) ? $and : "";

        $sql = "SELECT T1.*,T3.servico,T4.nome,T4.fantasia as fantasia_f,T6.nome as nome_f,T6.fantasia,T5.cor,T5.status as descricao_status FROM `" . $this->table . "` T1 
                   left join servicos_areas T2
                    on T1.id_servico_cliente = T2.id
                  left join servicos T3
                    on T2.id_servico = T3.id
                  left join clientes T4
					on T2.id_area = T4.id and T1.id_chamado = 0
                  left join funcionarios T6
					on T2.id_area = T6.id and T1.id_chamado = 0
                  left join status T5
					on T1.status = T5.id where T1.id_chamado = 0
					 " . $and;

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);


        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_servico_cliente'] = $linha['id_servico_cliente'];
                $array[$i]['assunto'] = $linha['assunto'];
                $array[$i]['identifica'] = $linha['nome'] . $linha['fantasia'] . $linha['nome_f'] . $linha['fantasia_f'];
                $array[$i]['descricao'] = $linha['descricao'];
                $array[$i]['descricao_status'] = $linha['descricao_status'];
                $array[$i]['cor'] = $linha['cor'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['data_criado'] = $this->function->data_banco_br($linha['data_criado']);
                $array[$i]['hora_criado'] = $linha['hora_criado'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function update_status()
    {

//        $this->validator->set('Id', $this->id)->is_required();
//        $this->validator->set('E-Mail', $this->email)->is_email();
//        $this->validator->set('Senha', $this->senha)->is_required();
//        $validate = $this->validator->validate();
//        $erros = $this->validator->get_errors();
//
//        if (!$validate) {
//
//            $result['validar'] = $erros;
//            return $result;
//        }


        $sql = "UPDATE `" . $this->table . "` 
                SET 
                status = :status
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);


        $result = Database::executa($query);

        return $result;
    }


    public function getAllArea()
    {

        $sql = "SELECT T1.*,T3.servico,T5.cor,T5.status as descricao_status,T6.new_name  FROM `" . $this->table . "` T1 
                 left join servicos_areas T2
                    on T1.id_servico_cliente = T2.id
                  left join servicos T3
                    on T2.id_servico = T3.id
                left join status T5
					on T1.status = T5.id
                    left join imagens_chamado T6
                    on T1.id = T6.id_chamado
                WHERE id_usuario = :id_usuario and T1.id_chamado = 0";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_usuario', $_SESSION['gesstor']['login']['id'], PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_servico_cliente'] = $linha['id_servico_cliente'];
                $array[$i]['assunto'] = $linha['assunto'];
                $array[$i]['descricao'] = $linha['descricao'];
                $array[$i]['descricao_status'] = $linha['descricao_status'];
                $array[$i]['cor'] = $linha['cor'];
                $array[$i]['data_criado'] = $this->function->data_banco_br($linha['data_criado']);
                $array[$i]['hora_criado'] = $linha['hora_criado'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['new_name'] = $linha['new_name'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getHistory()
    {

        $sql = "select T1.*,T3.nome,T3.fantasia,T3.sobrenome,T4.new_name from `" . $this->table . "` T1 
                left join usuarios T2
                on T1.id_usuario = T2.id
                left join clientes T3 
                on T2.id = T3.id_usuario_responsavel
                    left join imagens_chamado T4
                    on T1.id = T4.id_chamado
                where T1.id = :id or T1.id_chamado = :id order by id asc";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_servico_cliente'] = $linha['id_servico_cliente'];
                $array[$i]['assunto'] = $linha['assunto'];
                $array[$i]['identifica'] = $linha['nome'] . " " . $linha['sobrenome'] . $linha['fantasia'];
                $array[$i]['descricao'] = $linha['descricao'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['data_criado'] = $linha['data_criado'];
                $array[$i]['new_name'] = $linha['new_name'];
                $array[$i]['hora_criado'] = $linha['hora_criado'];
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