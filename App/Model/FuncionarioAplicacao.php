<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class FuncionarioAplicacao extends Model
{
    private $table = 'funcionarios_aplicacao';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Funcionario', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (id_funcionario,id_aplicacao,status) VALUES (:id_funcionario,:id_aplicacao,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao', $this->id_aplicacao, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

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
                id_aplicacao = :id_aplicacao,
                status = :status 
                WHERE id_funcionario = :id_funcionario_tela and id_aplicacao = :id_aplicacao_tela";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao', $this->id_aplicacao, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario_tela', $this->id_funcionario_tela, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao_tela', $this->id_aplicacao_tela, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getById()
    {
        $this->validator->set('Aplicação', $this->id_aplicacao)->is_required();
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT * FROM `" . $this->table . "` 
        WHERE id_funcionario = :id_funcionario_tela and id_aplicacao = :id_aplicacao_tela";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario_tela', $this->id_funcionario_tela, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao_tela', $this->id_aplicacao_tela, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['id_aplicacao'] = $linha['id_aplicacao'];
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
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAplicacaoFuncionario()
    {

        $sql = "SELECT * FROM `" . $this->table . "` " .
            " WHERE id_funcionario = :id_funcionario ";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function getAllJoin()
    {

        $sql = "SELECT T1.*,T2.nome,T2.sobrenome,T3.aplicacao FROM `" . $this->table . "` T1" .
            " inner join funcionarios T2" .
            " on T1.id_funcionario = T2.id" .
            " inner join aplicacoes T3" .
            " on T1.id_aplicacao = T3.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['aplicacao'] = $linha['aplicacao'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoinFuncionario()
    {

         $sql = "SELECT T1.*,T2.nome,T2.sobrenome,T3.aplicacao FROM `" . $this->table . "` T1" .
            " inner join funcionarios T2" .
            " on T1.id_funcionario = T2.id" .
            " inner join aplicacoes T3" .
            " on T1.id_aplicacao = T3.id " .
            " where T1.id_funcionario = :id_funcionario";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['aplicacao'] = $linha['aplicacao'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function delete()
    {

        $this->validator->set('Aplicação', $this->id_aplicacao)->is_required();
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM `" . $this->table . "` 
                WHERE id_funcionario = :id_funcionario_tela and id_aplicacao = :id_aplicacao_tela";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_funcionario_tela', $this->id_funcionario_tela, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao_tela', $this->id_aplicacao_tela, PDO::PARAM_STR);

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