<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class UsuarioGrupo extends Model
{
    private $table = 'usuario_grupos';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Usuario', $this->id_usuario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();
        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (id_usuario,id_grupo_senha,status) VALUES (:id_usuario,:id_grupo_senha,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);
        $query->bindValue(':id_grupo_senha', $this->id_grupo_senha, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('Usuario', $this->id_usuario)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                id_usuario = :id_usuario,
                id_grupo_senha = :id_grupo_senha,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);
        $query->bindValue(':id_grupo_senha', $this->id_grupo_senha, PDO::PARAM_STR);
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
                $array['id_usuario'] = $linha['id_usuario'];
                $array['id_grupo_senha'] = $linha['id_grupo_senha'];
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
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_grupo_senha'] = $linha['id_grupo_senha'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoin()
    {

        $sql = "SELECT T1.id,T1.grupo,T2.servico,T2.usuario,T2.senha,T3.id_usuario,T3.id_grupo_senha 
                    FROM grupo_senhas T1
                    left JOIN registros_senha T2 ON T1.id = T2.id_grupo_senha
                    LEFT JOIN usuario_grupos T3 ON T1.id = T3.id_grupo_senha
                    WHERE T3.id_usuario = :id
                    OR T1.id_usuario = :id order by T1.id ASC";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_grupo_senha'] = $linha['id_grupo_senha'];
                $array[$i]['grupo'] = $linha['grupo'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['usuario'] = $linha['usuario'];
                $array[$i]['senha'] = $linha['senha'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function getAllWhere()
    {

        $sql = "SELECT T1.id,T1.grupo,T2.servico,T2.usuario,T2.senha,T3.id_usuario,T3.id_grupo_senha 
                    FROM grupo_senhas T1
                    left JOIN registros_senha T2 ON T1.id = T2.id_grupo_senha
                    LEFT JOIN usuario_grupos T3 ON T1.id = T3.id_grupo_senha
                    WHERE (T3.id_usuario = :id
                    OR T1.id_usuario = :id) and servico like :servico order by T1.id ASC";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':servico', "%" . $this->servico . "%", PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_usuario'] = $linha['id_usuario'];
                $array[$i]['id_grupo_senha'] = $linha['id_grupo_senha'];
                $array[$i]['grupo'] = $linha['grupo'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['usuario'] = $linha['usuario'];
                $array[$i]['senha'] = $linha['senha'];
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