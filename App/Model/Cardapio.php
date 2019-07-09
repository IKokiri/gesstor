<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Cardapio extends Model
{
    private $table = 'cardapios';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Data', $this->data)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " (data,id_categoria,id_alimento,status) VALUES (:data,:id_categoria,:id_alimento,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':id_categoria', $this->id_categoria, PDO::PARAM_STR);
        $query->bindValue(':id_alimento', $this->id_alimento, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

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

        $sql = "UPDATE " . $this->table . " 
                SET 
                data = :data,
                id_categoria = :id_categoria,
                id_alimento = :id_alimento,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':id_categoria', $this->id_categoria, PDO::PARAM_STR);
        $query->bindValue(':id_alimento', $this->id_alimento, PDO::PARAM_STR);
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

        $sql = "SELECT T1.* FROM " . $this->table . " T1
        WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['data'] = $this->function->data_banco_br($linha['data']);
                $array['id_categoria'] = $linha['id_categoria'];
                $array['id_alimento'] = $linha['id_alimento'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT T1.*,T2.categoria,T3.alimento FROM " . $this->table . " T1 " .
            " inner join categorias_cardapio T2 " .
            " on T1.id_categoria = T2.id " .
            " inner join alimentos T3" .
            " on T1.id_alimento = T3.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['id_categoria'] = $linha['id_categoria'];
                $array[$i]['id_alimento'] = $linha['id_alimento'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['categoria'] = $linha['categoria'];
                $array[$i]['alimento'] = $linha['alimento'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function getAtual()
    {

        $sql = "SELECT T1.*,T2.categoria,T3.alimento FROM " . $this->table . " T1 " .
            " inner join categorias_cardapio T2 " .
            " on T1.id_categoria = T2.id " .
            " inner join alimentos T3" .
            " on T1.id_alimento = T3.id" .
            " where T1.data >= curdate() order by T1.id_categoria";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$linha['data']][$i]['id'] = $linha['id'];
//                $array[$linha['data']][$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$linha['data']][$i]['data'] = $this->function->dia_da_semana(date('w',strtotime($linha['data'])));
                $array[$linha['data']][$i]['id_categoria'] = $linha['id_categoria'];
                $array[$linha['data']][$i]['id_alimento'] = $linha['id_alimento'];
                $array[$linha['data']][$i]['status'] = $linha['status'];
                $array[$linha['data']][$i]['categoria'] = $linha['categoria'];
                $array[$linha['data']][$i]['alimento'] = $linha['alimento'];
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

