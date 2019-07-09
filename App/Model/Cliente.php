<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Cliente extends Model
{
    private $table = 'clientes';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {


//        $this->validator->set('CNPJ', $this->cnpj)->is_required();
        $this->validator->set('Tipo Pessoa', $this->tipo_pessoa)->is_required();
        $this->validator->set('NOME REDUZIDO', $this->nome_reduzido)->is_required();
        $this->validator->set('Razão Social', $this->razao_social)->is_required();

        $validate = $this->validator->validate();

        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $consultaCnpj = $this->verificarCnpj($this->cnpj);
        if ($consultaCnpj['count']) {

            $arrayErro['status'] = "false";
            $arrayErro['MSN'] = "MSN";
            $arrayErro['msnErro'] = "CNPJ Já Existe";
            $arrayErro['cliente'] = true;
            return $arrayErro;
            die;
        }

        $sql = "INSERT INTO " . $this->table . " (numero_sapiens,nome_reduzido,tipo_pessoa,razao_social,nome,fantasia,sobrenome,rg,ie,cpf,cnpj,cep,rua,numero,bairro,cidade,uf,status,id_usuario_responsavel) " .
            " VALUES " .
            " (:numero_sapiens,:nome_reduzido,:tipo_pessoa,:razao_social,:nome,:fantasia,:sobrenome,:rg,:ie,:cpf,:cnpj,:cep,:rua,:numero,:bairro,:cidade,:uf,:status,:id_usuario_responsavel)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':tipo_pessoa', $this->tipo_pessoa, PDO::PARAM_STR);
        $query->bindValue(':razao_social', $this->razao_social, PDO::PARAM_STR);
        $query->bindValue(':numero_sapiens', $this->razao_social, PDO::PARAM_STR);
        $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);
        $query->bindValue(':nome_reduzido', $this->nome_reduzido, PDO::PARAM_STR);
        $query->bindValue(':fantasia', $this->fantasia, PDO::PARAM_STR);
        $query->bindValue(':sobrenome', $this->sobrenome, PDO::PARAM_STR);
        $query->bindValue(':rg', $this->function->remove_char_spec($this->rg), PDO::PARAM_STR);
        $query->bindValue(':ie', $this->function->remove_char_spec($this->ie), PDO::PARAM_STR);
        $query->bindValue(':cpf', $this->function->remove_char_spec($this->cpf), PDO::PARAM_STR);
        $query->bindValue(':cnpj', $this->function->remove_char_spec($this->cnpj), PDO::PARAM_STR);
        $query->bindValue(':cep', $this->function->remove_char_spec($this->cep), PDO::PARAM_STR);
        $query->bindValue(':rua', $this->rua, PDO::PARAM_STR);
        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);
        $query->bindValue(':bairro', $this->bairro, PDO::PARAM_STR);
        $query->bindValue(':cidade', $this->cidade, PDO::PARAM_STR);
        $query->bindValue(':uf', $this->uf, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_usuario_responsavel', $this->id_usuario_responsavel, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function verificarCnpj($cnpj)
    {

        $this->validator->set('CNPJ', $cnpj)->is_required();

        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT * FROM " . $this->table . " WHERE cnpj = :cnpj";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':cnpj', $this->function->remove_char_spec($cnpj), PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['cnpj'] = $linha['cnpj'];
            }

            $result['result'] = $array;
        }

        return $result;
    }

    public function update()
    {

        $this->validator->set('Identificador', $this->id)->is_required();
        $this->validator->set('Tipo Pessoa', $this->tipo_pessoa)->is_required();

        $consultaCnpj = $this->verificarCnpj($this->cnpj);

        if ($consultaCnpj['count'] && $consultaCnpj['result'][0]['id'] != $this->id) {

            $arrayErro['status'] = "false";
            $arrayErro['MSN'] = "MSN";
            $arrayErro['msnErro'] = "CNPJ Já Existe";
            $arrayErro['cliente'] = true;
            return $arrayErro;
            die;
        }

        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }


        $sql = "UPDATE " . $this->table . " 
                SET 
                razao_social = :razao_social,
                nome = :nome,
                nome_reduzido = :nome_reduzido,
                fantasia = :fantasia,
                sobrenome = :sobrenome,
                numero_sapiens = :numero_sapiens,
                rg = :rg,
                ie = :ie,
                cpf = :cpf,
                cnpj = :cnpj,
                tipo_pessoa = :tipo_pessoa,
                status = :status,
                cep = :cep,
                rua = :rua,
                numero = :numero,
                bairro = :bairro,
                cidade = :cidade,
                uf = :uf 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':numero_sapiens', $this->numero_sapiens, PDO::PARAM_STR);
        $query->bindValue(':razao_social', $this->razao_social, PDO::PARAM_STR);
        $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);
        $query->bindValue(':nome_reduzido', $this->nome_reduzido, PDO::PARAM_STR);
        $query->bindValue(':fantasia', $this->fantasia, PDO::PARAM_STR);
        $query->bindValue(':sobrenome', $this->sobrenome, PDO::PARAM_STR);
        $query->bindValue(':rg', $this->function->remove_char_spec($this->rg), PDO::PARAM_STR);
        $query->bindValue(':ie', $this->function->remove_char_spec($this->ie), PDO::PARAM_STR);
        $query->bindValue(':cpf', $this->function->remove_char_spec($this->cpf), PDO::PARAM_STR);
        $query->bindValue(':cnpj', $this->function->remove_char_spec($this->cnpj), PDO::PARAM_STR);
        $query->bindValue(':cep', $this->function->remove_char_spec($this->cep), PDO::PARAM_STR);
        $query->bindValue(':tipo_pessoa', $this->tipo_pessoa, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':rua', $this->rua, PDO::PARAM_STR);
        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);
        $query->bindValue(':bairro', $this->bairro, PDO::PARAM_STR);
        $query->bindValue(':cidade', $this->cidade, PDO::PARAM_STR);
        $query->bindValue(':uf', $this->uf, PDO::PARAM_STR);

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

        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email and senha = :senha";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':email', $this->email, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['email'] = $linha['email'];
                $array[$i]['senha'] = $linha['senha'];
                $array[$i]['status'] = $linha['status'];
            }

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

        $sql = "SELECT T1.*,T2.email,T2.senha FROM " . $this->table . " T1 
                LEFT JOIN usuarios T2
                on T1.id_usuario_responsavel = T2.id
                WHERE T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['razao_social'] = $linha['razao_social'];
                $array['nome'] = $linha['nome'];
                $array['nome_reduzido'] = $linha['nome_reduzido'];
                $array['fantasia'] = $linha['fantasia'];
                $array['sobrenome'] = $linha['sobrenome'];
                $array['numero_sapiens'] = $linha['numero_sapiens'];
                $array['rg'] = $linha['rg'];
                $array['ie'] = $linha['ie'];
                $array['cpf'] = $linha['cpf'];
                $array['cnpj'] = $linha['cnpj'];
                $array['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array['status'] = $linha['status'];
                $array['cep'] = $linha['cep'];
                $array['rua'] = $linha['rua'];
                $array['numero'] = $linha['numero'];
                $array['bairro'] = $linha['bairro'];
                $array['cidade'] = $linha['cidade'];
                $array['uf'] = $linha['uf'];
                $array['email'] = $linha['email'];
                $array['senha'] = $linha['senha'];

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
                $array[$i]['razao_social'] = $linha['razao_social'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['fantasia'] = $linha['fantasia'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['rg'] = $linha['rg'];
                $array[$i]['nome_reduzido'] = $linha['nome_reduzido'];
                $array[$i]['numero_sapiens'] = $linha['numero_sapiens'];
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                if ($linha['tipo_pessoa'] == "Jurídica") {
                    $array[$i]['identificador'] = $linha['razao_social'] . " - " . $linha['cnpj'];
                } else {
                    $array[$i]['identificador'] = $linha['nome'] . " " . $linha['sobrenome'] . " - " . $linha['cpf'];
                }

                $array[$i]['uf'] = $linha['uf'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllAtivos()
    {

        $sql = "SELECT * FROM " . $this->table." WHERE status = 'A'";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['razao_social'] = $linha['razao_social'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['fantasia'] = $linha['fantasia'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['rg'] = $linha['rg'];
                $array[$i]['nome_reduzido'] = $linha['nome_reduzido'];
                $array[$i]['numero_sapiens'] = $linha['numero_sapiens'];
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];

                if ($linha['tipo_pessoa'] == "Jurídica") {

                    $array[$i]['identificador'] = $linha['razao_social'] . " - " . $linha['cnpj'];

                } else {

                    $array[$i]['identificador'] = $linha['nome'] . " " . $linha['sobrenome'] . " - " . $linha['cpf'];

                }

                $array[$i]['uf'] = $linha['uf'];
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