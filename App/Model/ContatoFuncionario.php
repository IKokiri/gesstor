<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class ContatoFuncionario extends Model
{
    private $table = 'contato_funcionarios';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (id_funcionario,contato,observacao,status) VALUES (:id_funcionario,:contato,:observacao,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':contato', $this->contato, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('id_funcionario', $this->id_funcionario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                id_funcionario = :id_funcionario,
                contato = :contato,
                observacao = :observacao,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':contato', $this->contato, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);

        $result = Database::executa($query);

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

        $sql = "SELECT T1.* FROM `" . $this->table . "` T1
        WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['contato'] = $linha['contato'];
                $array['observacao'] = $linha['observacao'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT T1.id,T1.observacao,T1.id_funcionario,T1.status,T1.contato,T2.nome,T2.sobrenome FROM `" . $this->table . "` T1
                inner join funcionarios T2
                on T1.id_funcionario = T2.id order by T2.nome asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['contato'] = $linha['contato'];
                $array[$i]['observacao'] = $linha['observacao'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoin()
    {

        $sql = "SELECT T1.id,T1.id_funcionario,T1.observacao,T1.contato,T2.nome,T2.sobrenome FROM `" . $this->table . "` T1
                inner join funcionarios T2
                on T1.id_funcionario = T2.id order by T2.nome asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['observacao'] = $linha['observacao'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['contato'] = $linha['contato'];
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

        $sql = "DELETE FROM `" . $this->table . "` 
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