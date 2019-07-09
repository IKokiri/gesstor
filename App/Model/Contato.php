<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Contato extends Model
{
    protected $table = 'contatos';

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

        $sql = "INSERT INTO " . $this->table . " (nome_contato,sobrenome_contato,email_contato,telefone_contato,id_area_contato,area) 
                VALUES 
                (:nome_contato,:sobrenome_contato,:email_contato,:telefone_contato,:id_area_contato,:area)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':nome_contato', $this->nome_contato, PDO::PARAM_STR);
        $query->bindValue(':sobrenome_contato', $this->sobrenome_contato, PDO::PARAM_STR);
        $query->bindValue(':email_contato', $this->email_contato, PDO::PARAM_STR);
        $query->bindValue(':telefone_contato', $this->function->remove_char_spec($this->telefone_contato), PDO::PARAM_STR);
        $query->bindValue(':id_area_contato', $this->id_area_contato, PDO::PARAM_STR);
        $query->bindValue(':area', $this->area, PDO::PARAM_STR);

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
                nome_contato = :nome_contato,
                sobrenome_contato = :sobrenome_contato,
                email_contato = :email_contato,
                telefone_contato = :telefone_contato,
                id_area_contato = :id_area_contato                
                WHERE id = :id and area = :area";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id_contato, PDO::PARAM_STR);
        $query->bindValue(':nome_contato', $this->nome_contato, PDO::PARAM_STR);
        $query->bindValue(':sobrenome_contato', $this->sobrenome_contato, PDO::PARAM_STR);
        $query->bindValue(':email_contato', $this->email_contato, PDO::PARAM_STR);
        $query->bindValue(':telefone_contato', $this->function->remove_char_spec($this->telefone_contato), PDO::PARAM_STR);
        $query->bindValue(':id_area_contato', $this->id_area_contato, PDO::PARAM_STR);
        $query->bindValue(':area', $this->area, PDO::PARAM_STR);


        $result = Database::executa($query);

        return $result;
    }

    public function getById()
    {
        $this->validator->set('id_contato', $this->id_contato)->is_required();

        $validate = $this->validator->validate();

        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;

            return $result;

        }

        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id_contato";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_contato', $this->id_contato, PDO::PARAM_STR);

        $result = Database::executa($query);

        $linha = $query->fetch(PDO::FETCH_ASSOC);
        $array['id'] = $linha['id'];
        $array['nome_contato'] = $linha['nome_contato'];
        $array['sobrenome_contato'] = $linha['sobrenome_contato'];
        $array['email_contato'] = $linha['email_contato'];
        $array['telefone_contato'] = $linha['telefone_contato'];
        $array['id_area_contato'] = $linha['id_area_contato'];


        $result['result'] = $array;


        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT T1.*,T2.nome,T2.fantasia FROM " . $this->table . " T1 
                LEFT JOIN clientes T2
                    on T1.id_area_contato = T2.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['nome_contato'] = $linha['nome_contato'];
                $array[$i]['sobrenome_contato'] = $linha['sobrenome_contato'];
                $array[$i]['email_contato'] = $linha['email_contato'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['fantasia'];
                $array[$i]['telefone_contato'] = $linha['telefone_contato'];
                $array[$i]['id_area_contato'] = $linha['id_area_contato'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllBy()
    {
        $this->busca = ($this->busca) ? '%' . $this->busca . '%' : '';

        $sql = "SELECT T1.*,T2.nome,T2.sobrenome,T2.fantasia FROM " . $this->table . " T1 
                LEFT JOIN clientes T2
                    on T1.id_area_contato = T2.id 
                where concat(T2.nome,' ',T2.sobrenome) like :busca or T2.fantasia like :busca";
        $query = $this->dbh->prepare($sql);

        $query->bindValue(':busca', $this->busca, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['nome_contato'] = $linha['nome_contato'];
                $array[$i]['sobrenome_contato'] = $linha['sobrenome_contato'];
                $array[$i]['email_contato'] = $linha['email_contato'];
                $array[$i]['identificador'] = $linha['nome'] ." ". $linha['fantasia'] ." ". $linha['sobrenome'];
                $array[$i]['telefone_contato'] = $linha['telefone_contato'];
                $array[$i]['id_area_contato'] = $linha['id_area_contato'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllArea()
    {

        $sql = "SELECT T1.*,T2.nome,T2.fantasia FROM " . $this->table . " T1 
                INNER JOIN clientes T2
                    on T1.id_area_contato = T2.id
                where id_area_contato = :id_area_contato and area = :area";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_area_contato', $this->id_area_contato, PDO::PARAM_STR);
        $query->bindValue(':area', $this->area, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['nome_contato'] = $linha['nome_contato'];
                $array[$i]['sobrenome_contato'] = $linha['sobrenome_contato'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['fantasia'];
                $array[$i]['email_contato'] = $linha['email_contato'];
                $array[$i]['telefone_contato'] = $this->function->remove_char_spec($linha['telefone_contato']);
                $array[$i]['id_area_contato'] = $linha['id_area_contato'];
            }

            $result['result'] = $array;
        }
        return $result;
    }


    public function delete()
    {

        $this->validator->set('id_contato', $this->id_contato)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM " . $this->table . " 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id_contato, PDO::PARAM_STR);

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