<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Produto extends Model
{
    private $table = 'produtos';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Produto', $this->produto)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (produto,codigo,id_unidade,status) VALUES 
        (:produto,:codigo,:id_unidade,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':produto', $this->produto, PDO::PARAM_STR);
        $query->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
        $query->bindValue(':id_unidade', $this->id_unidade, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('produto', $this->produto)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                produto = :produto,
                codigo = :codigo,
                id_unidade = :id_unidade,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':produto', $this->produto, PDO::PARAM_STR);
        $query->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
        $query->bindValue(':id_unidade', $this->id_unidade, PDO::PARAM_STR);
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

        $sql = "SELECT T1.* FROM `" . $this->table . "` T1
        WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['produto'] = $linha['produto'];
                $array['codigo'] = $linha['codigo'];
                $array['id_unidade'] = $linha['id_unidade'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT T1.*,T2.unidade FROM `" . $this->table ."` T1
        INNER JOIN unidades_medida T2
         on T1.id_unidade = T2.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['produto'] = $linha['produto'];
                $array[$i]['unidade'] = $linha['unidade'];
                $array[$i]['codigo'] = $linha['codigo'];
                $array[$i]['id_unidade'] = $linha['id_unidade'];
                $array[$i]['status'] = $linha['status'];
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