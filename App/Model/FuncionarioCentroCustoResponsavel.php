<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class FuncionarioCentroCustoResponsavel extends Model
{
    private $table = 'funcionarios_centro_custos_responsavel';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Funcionario', $this->id_funcionario)->is_required();
        $this->validator->set('Centro Custo', $this->id_centro_custo)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (id_funcionario,id_centro_custo,gerente_centro_custo,status) VALUES (:id_funcionario,:id_centro_custo,:gerente_centro_custo,:status)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':gerente_centro_custo', $this->gerente_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Centro de Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;

            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                id_funcionario = :id_funcionario,
                id_centro_custo = :id_centro_custo,
                gerente_centro_custo = :gerente_centro_custo,
                status = :status 
                WHERE id_funcionario = :id_funcionario_tela and id_centro_custo = :id_centro_custo_tela";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario_tela', $this->id_funcionario_tela, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo_tela', $this->id_centro_custo_tela, PDO::PARAM_STR);
        $query->bindValue(':gerente_centro_custo', $this->gerente_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getById()
    {
        $this->validator->set('Centro de Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT * FROM `" . $this->table . "` 
        WHERE id_funcionario = :id_funcionario_tela and id_centro_custo = :id_centro_custo_tela";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario_tela', $this->id_funcionario_tela, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo_tela', $this->id_centro_custo_tela, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['id_centro_custo'] = $linha['id_centro_custo'];
                $array['gerente_centro_custo'] = $linha['gerente_centro_custo'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT * FROM `" . $this->table;

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['gerente_centro_custo'] = $linha['gerente_centro_custo'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getCentroCustosFuncionario()
    {

        $sql = "SELECT * FROM `" . $this->table . "` " .
            " WHERE id_funcionario = :id_funcionario ";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['gerente_centro_custo'] = $linha['gerente_centro_custo'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function verificaGerenteCentroCusto()
    {

        $sql = "SELECT * FROM `" . $this->table . "` " .
            " WHERE id_funcionario = :id_funcionario and gerente_centro_custo = 'A' and id_centro_custo in (:ids_centro_custos) ";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':ids_centro_custos', $this->ids_centro_custos, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['gerente_centro_custo'] = $linha['gerente_centro_custo'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoin()
    {

        $sql = "SELECT T1.*,T2.nome,T2.sobrenome,T3.centroCusto FROM `" . $this->table . "` T1" .
            " inner join funcionarios T2" .
            " on T1.id_funcionario = T2.id" .
            " inner join centro_custos T3" .
            " on T1.id_centro_custo = T3.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['gerente_centro_custo'] = $linha['gerente_centro_custo'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoinId()
    {

        $sql = "SELECT T1.*,T2.nome,T2.sobrenome,T3.centroCusto FROM `" . $this->table . "` T1" .
            " inner join funcionarios T2" .
            " on T1.id_funcionario = T2.id" .
            " inner join centro_custos T3" .
            " on T1.id_centro_custo = T3.id".
            " where T2.id_usuario_responsavel = :id_usuario";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function delete()
    {

        $this->validator->set('Centro de Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM `" . $this->table . "` 
                WHERE id_funcionario = :id_funcionario_tela and id_centro_custo = :id_centro_custo_tela";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_funcionario_tela', $this->id_funcionario_tela, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo_tela', $this->id_centro_custo_tela, PDO::PARAM_STR);

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