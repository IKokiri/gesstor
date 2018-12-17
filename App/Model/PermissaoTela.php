<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class PermissaoTela extends Model
{
    private $table = 'permissoes_tela';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Grupo', $this->id_grupo)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (id_grupo,id_sub_menu) VALUES " .
            "(:id_grupo,:id_sub_menu)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_grupo', $this->id_grupo, PDO::PARAM_STR);
        $query->bindValue(':id_sub_menu', $this->id_sub_menu, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('menu', $this->subMenu)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                id_grupo = :id_grupo,
                id_sub_menu = :id_sub_menu,
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_grupo', $this->id_grupo, PDO::PARAM_STR);
        $query->bindValue(':id_sub_menu', $this->id_sub_menu, PDO::PARAM_STR);

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
                $array['id_grupo'] = $linha['id_grupo'];
                $array['id_sub_menu'] = $linha['id_sub_menu'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getByIdGrupos()
    {
        $this->validator->set('Id', $this->id_grupo)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.* FROM `" . $this->table . "` T1
        WHERE T1.id_grupo = :id_grupo";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_grupo', $this->id_grupo, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_grupo'] = $linha['id_grupo'];
                $array[$i]['id_sub_menu'] = $linha['id_sub_menu'];
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
                $array[$i]['id_grupo'] = $linha['id_grupo'];
                $array[$i]['id_sub_menu'] = $linha['id_sub_menu'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoin()
    {

        $sql = "SELECT T1.*,T2.grupo FROM `" . $this->table . "` T1" .
            " inner join grupo_permissoes T2" .
            " on T1.id_grupo = T2.id group by id_grupo";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['grupo'] = $linha['grupo'];
                $array[$i]['id_grupo'] = $linha['id_grupo'];
                $array[$i]['id_sub_menu'] = $linha['id_sub_menu'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function deleteGrupo()
    {

        $this->validator->set('Id', $this->id_grupo)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM `" . $this->table . "` 
                WHERE id_grupo = :id_grupo";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_grupo', $this->id_grupo, PDO::PARAM_STR);

        $result = Database::executa($query);

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