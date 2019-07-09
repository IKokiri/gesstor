<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Usuario extends Model
{
    private $table = 'usuarios';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }


    public function create()
    {
        $this->validator->set('E-Mail', $this->email)->is_email();
        $this->validator->set('Senha', $this->senha)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " (email,senha,status,id_grupo_permissao) VALUES (:email,:senha,:status,:id_grupo_permissao)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':email', $this->email, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_grupo_permissao', $this->id_grupo_permissao, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('E-Mail', $this->email)->is_email();
        $this->validator->set('Senha', $this->senha)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE " . $this->table . " 
                SET 
                email = :email,
                senha = :senha,
                id_grupo_permissao = :id_grupo_permissao,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':email', $this->email, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_grupo_permissao', $this->id_grupo_permissao, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function updateFoto()
    {

        $this->validator->set('Foto', $this->imagem)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE " . $this->table . " 
                SET 
                imagem = :imagem
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':imagem', $this->imagem, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function alterarSenha()
    {

        $this->validator->set('ID', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE " . $this->table . " 
                SET 
                senha = :senha
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getLogin()
    {

        $this->validator->set('E-Mail', $this->email)->is_email();
        $this->validator->set('Senha', $this->senha)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.id as id_usuario,T1.*,T2.nome,T2.fantasia,T2.id as id_area,T3.id as id_funcionario,T3.nome as nomeFuncionario,T3.sobrenome,T3.sigla  FROM " . $this->table . " T1 
                left JOIN clientes T2
                on T1.id = T2.id_usuario_responsavel
                left JOIN funcionarios T3
                on T1.id = T3.id_usuario_responsavel 
                WHERE email = :email and senha = :senha and T1.status = 'A'";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':email', $this->email, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            $linha = $query->fetch(PDO::FETCH_ASSOC);
            $array['id'] = $linha['id_usuario'];
            $array['id_area'] = $linha['id_funcionario'] . $linha['id_area'];
            $array['identificador'] = $linha['nome'] . $linha['fantasia'];
            $array['funcionario'] = $linha['nomeFuncionario'] . ' ' . $linha['sobrenome'];
            $array['email'] = $linha['email'];
            $array['senha'] = $linha['senha'];
            $array['sigla'] = $linha['sigla'];
            $array['imagem'] = $linha['imagem'];
            $array['id_grupo_permissao'] = $linha['id_grupo_permissao'];
            $array['status'] = $linha['status'];


            $result['result'] = $array;
        }

        return $result;
    }

    public function getAllInfo()
    {

        $this->validator->set('id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.id as id_usuario,T1.*,T2.nome,T2.fantasia,T2.id as id_area,T3.id as id_funcionario,T3.nome as nomeFuncionario,T3.sobrenome  FROM " . $this->table . " T1 
                left JOIN clientes T2
                on T1.id = T2.id_usuario_responsavel
                left JOIN funcionarios T3
                on T1.id = T3.id_usuario_responsavel 
                WHERE T1.id = :id and T1.status = 'A'";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            $linha = $query->fetch(PDO::FETCH_ASSOC);
            $array['id'] = $linha['id_usuario'];
            $array['id_area'] = $linha['id_funcionario'] . $linha['id_area'];
            $array['identificador'] = $linha['nome'] . $linha['fantasia'];
            $array['funcionario'] = $linha['nomeFuncionario'] . ' ' . $linha['sobrenome'];
            $array['email'] = $linha['email'];
            $array['imagem'] = $linha['imagem'];
            $array['id_grupo_permissao'] = $linha['id_grupo_permissao'];
            $array['status'] = $linha['status'];


            $result['result'] = $array;
        }

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

        $sql = "SELECT T1.id as id_usuario,T1.*,T2.id as id_area FROM " . $this->table . " T1
        LEFT JOIN clientes T2
                on T1.id = T2.id_usuario_responsavel
        WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id_usuario'];
                $array['email'] = $linha['email'];
                $array['id_area'] = $linha['id_area'];
                $array['status'] = $linha['status'];
                $array['id_grupo_permissao'] = $linha['id_grupo_permissao'];
                $array['senha'] = $linha['senha'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT T1.*, T2.grupo FROM " . $this->table . " T1 " .
            " left join grupo_permissoes T2" .
            " on T1.id_grupo_permissao = T2.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['email'] = $linha['email'];
                $array[$i]['grupo'] = $linha['grupo'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['id_grupo_permissao'] = $linha['id_grupo_permissao'];
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