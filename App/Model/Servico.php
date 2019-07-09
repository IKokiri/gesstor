<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Servico extends Model
{
    private $table = 'servicos';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
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

        $sql = "INSERT INTO " . $this->table . " (servico,valor,descricao,status,icone) VALUES (:servico,:valor,:descricao,:status,:icone)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':servico', $this->servico, PDO::PARAM_STR);
        $query->bindValue(':valor', $this->valor, PDO::PARAM_STR);
        $query->bindValue(':icone', $this->icone, PDO::PARAM_STR);
        $query->bindValue(':descricao', $this->descricao, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
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


        $sql = "UPDATE " . $this->table . " 
                SET 
                servico = :servico,
                valor = :valor,
                descricao = :descricao,
                icone = :icone,
                status = :status
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':servico', $this->servico, PDO::PARAM_STR);
        $query->bindValue(':valor', $this->valor, PDO::PARAM_STR);
        $query->bindValue(':descricao', $this->descricao, PDO::PARAM_STR);
        $query->bindValue(':icone', $this->icone, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);


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

        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);


        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['servico'] = $linha['servico'];
                $array['valor'] = $linha['valor'];
                $array['icone'] = $linha['icone'];
                $array['status'] = $linha['status'];
                $array['descricao'] = $linha['descricao'];
            }

            $result['result'] = $array;
        }

        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT * FROM " . $this->table;

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);


        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['icone'] = $linha['icone'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllActive()
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE status ='A'";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['icone'] = $linha['icone'];
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