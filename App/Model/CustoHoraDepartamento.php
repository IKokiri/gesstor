<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class CustoHoraDepartamento extends Model
{
    private $table = 'custos_hora_departamento';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('id_centro_custo', $this->id_centro_custo)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " (id_centro_custo,data,valor,status) VALUES (:id_centro_custo,:data,:valor,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':valor', $this->valor, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Centro Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('Data', $this->data)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE " . $this->table . " 
                SET 
                id_centro_custo = :id_centro_custo,
                data = :data,
                valor = :valor,
                status = :status 
                WHERE id_centro_custo = :id_centro_custo and data = :data";


        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':valor', $this->valor, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getById()
    {
        $this->validator->set('Centro Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('data', $this->data)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.* FROM " . $this->table . " T1
        WHERE T1.id_centro_custo = :id_centro_custo and T1.data = :data";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $data = $this->function->data_banco_br($linha['data']);
                $data = explode('/', $data);
                $data = $data[1] . '/' . $data[2];

                $array['id_centro_custo'] = $linha['id_centro_custo'];
                $array['data'] = $data;
                $array['valor'] = $linha['valor'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }

        return $result;
    }

    public function getByValor()
    {
        $this->validator->set('Centro Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('data', $this->data)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.* FROM " . $this->table . " T1
        WHERE T1.id_centro_custo = :id_centro_custo and T1.data = :data";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $data = $this->function->data_banco_br($linha['data']);
                $data = explode('/', $data);
                $data = $data[1] . '/' . $data[2];

                $array['id_centro_custo'] = $linha['id_centro_custo'];
                $array['data'] = $data;
                $array['valor'] = $linha['valor'];
                $array['valorBR'] = number_format($linha['valor'], 2, ',', '.');
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }

        return $result;
    }

    public function getByData()
    {
        $this->validator->set('data', $this->data_inicio)->is_required();
        $this->validator->set('data', $this->data_fim)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.* FROM " . $this->table . " T1
        WHERE T1.data BETWEEN :dataInicio and :dataFim";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->data_inicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->data_fim), PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $data = $this->function->data_banco_br($linha['data']);
                $data = explode('/', $data);
                $data = $data[1] . '/' . $data[2];

                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['data'] = $data;
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['valorBR'] = number_format($linha['valor'], 2, ',', '.');
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }

        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT * FROM " . $this->table . " T1" .
            " INNER JOIN centro_custos T2 " .
            " ON T1.id_centro_custo = T2.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['departamento'] = $linha['departamento'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function delete()
    {

        $this->validator->set('Centro Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('Data', $this->data)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM " . $this->table . " 
                WHERE id_centro_custo = :id_centro_custo and data = :data";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);

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