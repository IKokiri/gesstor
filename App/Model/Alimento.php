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

class Alimento extends Model
{
    private $table = 'alimentos';
    private $log;

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
        $this->validator->set('Alimento', $this->alimento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " (alimento,status) VALUES (:alimento,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':alimento', $this->alimento, PDO::PARAM_STR);
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

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('alimento', $this->alimento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE " . $this->table . " 
                SET 
                alimento = :alimento,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':alimento', $this->alimento, PDO::PARAM_STR);
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
                $array['alimento'] = $linha['alimento'];
                $array['status'] = $linha['status'];
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
                $array[$i]['alimento'] = $linha['alimento'];
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