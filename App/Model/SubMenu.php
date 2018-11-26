<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class SubMenu extends Model
{
    private $table = 'sub_menus';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('SubMenu', $this->subMenu)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (id_menu,subMenu,nomeArquivo,status) VALUES " .
            "(:id_menu,:subMenu,:nomeArquivo,:status)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_menu', $this->id_menu, PDO::PARAM_STR);
        $query->bindValue(':subMenu', $this->subMenu, PDO::PARAM_STR);
        $query->bindValue(':nomeArquivo', $this->nomeArquivo, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

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
                id_menu = :id_menu,
                subMenu = :subMenu,
                nomeArquivo = :nomeArquivo,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_menu', $this->id_menu, PDO::PARAM_STR);
        $query->bindValue(':subMenu', $this->subMenu, PDO::PARAM_STR);
        $query->bindValue(':nomeArquivo', $this->nomeArquivo, PDO::PARAM_STR);
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
                $array['id_menu'] = $linha['id_menu'];
                $array['subMenu'] = $linha['subMenu'];
                $array['nomeArquivo'] = $linha['nomeArquivo'];
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
                $array[$i]['id_menu'] = $linha['id_menu'];
                $array[$i]['subMenu'] = $linha['subMenu'];
                $array[$i]['nomeArquivo'] = $linha['nomeArquivo'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function getAllJoin()
    {

        $sql = "SELECT T1.*,T2.menu FROM `" . $this->table . "` T1 " .
            " left join menus T2 " .
            " on T1.id_menu = T2.id order by T2.menu asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_menu'] = $linha['id_menu'];
                $array[$i]['subMenu'] = $linha['subMenu'];
                $array[$i]['menu'] = $linha['menu'];
                $array[$i]['nomeArquivo'] = $linha['nomeArquivo'];
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