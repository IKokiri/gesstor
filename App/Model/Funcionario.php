<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Funcionario extends Model
{
    private $table = 'funcionarios';

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
        $this->validator->set('Cep', $this->cep)->is_required();
        $this->validator->set('Rua', $this->rua)->is_required();
        $this->validator->set('Numero', $this->numero)->is_required();
        $this->validator->set('Bairro', $this->bairro)->is_required();
        $this->validator->set('Cidade', $this->cidade)->is_required();
        $this->validator->set('Uf', $this->uf)->is_required();

        $validate = $this->validator->validate();

        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (tipo_pessoa,razao_social,nome,fantasia,sobrenome,rg,ie,cpf,cnpj,cep,rua,numero,bairro,cidade,uf,status,id_usuario_responsavel,sigla) VALUES (:tipo_pessoa,:razao_social,:nome,:fantasia,:sobrenome,:rg,:ie,:cpf,:cnpj,:cep,:rua,:numero,:bairro,:cidade,:uf,:status,:id_usuario_responsavel,:sigla)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':tipo_pessoa', $this->tipo_pessoa, PDO::PARAM_STR);
        $query->bindValue(':razao_social', $this->razao_social, PDO::PARAM_STR);
        $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);
        $query->bindValue(':fantasia', $this->fantasia, PDO::PARAM_STR);
        $query->bindValue(':sobrenome', $this->sobrenome, PDO::PARAM_STR);
        $query->bindValue(':rg', $this->function->remove_char_spec($this->rg), PDO::PARAM_STR);
        $query->bindValue(':ie', $this->function->remove_char_spec($this->ie), PDO::PARAM_STR);
        $query->bindValue(':cpf', $this->function->remove_char_spec($this->cpf), PDO::PARAM_STR);
        $query->bindValue(':cnpj', $this->function->remove_char_spec($this->cnpj), PDO::PARAM_STR);
        $query->bindValue(':cep', $this->function->remove_char_spec($this->cep), PDO::PARAM_STR);
        $query->bindValue(':rua', $this->rua, PDO::PARAM_STR);
        $query->bindValue(':sigla', $this->sigla, PDO::PARAM_STR);
        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);
        $query->bindValue(':bairro', $this->bairro, PDO::PARAM_STR);
        $query->bindValue(':cidade', $this->cidade, PDO::PARAM_STR);
        $query->bindValue(':uf', $this->uf, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_usuario_responsavel', $this->id_usuario_responsavel, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Identificador', $this->id)->is_required();
        $this->validator->set('E-Mail', $this->email)->is_email();
        $this->validator->set('Senha', $this->senha)->is_required();
        $this->validator->set('Cep', $this->cep)->is_required();
        $this->validator->set('Rua', $this->rua)->is_required();
        $this->validator->set('Numero', $this->numero)->is_required();
        $this->validator->set('Bairro', $this->bairro)->is_required();
        $this->validator->set('Cidade', $this->cidade)->is_required();
        $this->validator->set('Uf', $this->uf)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }


        $sql = "UPDATE `" . $this->table . "` 
                SET 
                razao_social = :razao_social,
                nome = :nome,
                fantasia = :fantasia,
                sobrenome = :sobrenome,
                rg = :rg,
                ie = :ie,
                cpf = :cpf,
                cnpj = :cnpj,
                sigla = :sigla,
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
        $query->bindValue(':razao_social', $this->razao_social, PDO::PARAM_STR);
        $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);
        $query->bindValue(':fantasia', $this->fantasia, PDO::PARAM_STR);
        $query->bindValue(':sobrenome', $this->sobrenome, PDO::PARAM_STR);
        $query->bindValue(':sigla', $this->sigla, PDO::PARAM_STR);
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

        $sql = "SELECT * FROM `" . $this->table . "` WHERE email = :email and senha = :senha";

        $query = $this->dbh->prepare($sql);


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

        $sql = "SELECT T1.*,T2.email,T2.senha FROM `" . $this->table . "` T1 
                INNER JOIN usuarios T2
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
                $array['fantasia'] = $linha['fantasia'];
                $array['sobrenome'] = $linha['sobrenome'];
                $array['rg'] = $linha['rg'];
                $array['ie'] = $linha['ie'];
                $array['cpf'] = $linha['cpf'];
                $array['cnpj'] = $linha['cnpj'];
                $array['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array['sigla'] = $linha['sigla'];
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

        $sql = "SELECT * FROM `" . $this->table;

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
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['razao_social'];
                $array[$i]['uf'] = $linha['uf'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getEste()
    {

        $sql = "SELECT * FROM `" . $this->table . "` where id_usuario_responsavel =" . $_SESSION['gesstor']['login']['id'] . " limit 1";

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
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['razao_social'];
                $array[$i]['uf'] = $linha['uf'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getSemec()
    {

        $sql = "SELECT T2.* FROM funcionarios_centro_custos T1
                inner join funcionarios T2
                on T1.id_funcionario = T2.id
                inner join centro_custos T3
                on T1.id_centro_custo = T3.id
                where T3.id = 32 or T3.id = 16 or T3.id = 33";

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
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['razao_social'];
                $array[$i]['uf'] = $linha['uf'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllDepartamento()
    {

        $sql = "SELECT T2.* FROM funcionarios_centro_custos T1
                inner join funcionarios T2
                on T1.id_funcionario = T2.id
                inner join centro_custos T3
                on T1.id_centro_custo = T3.id
                where T3.id in $this->id_centro_custo";

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
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['razao_social'];
                $array[$i]['uf'] = $linha['uf'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getDepro()
    {

        $sql = "SELECT T2.* FROM funcionarios_centro_custos T1
                inner join funcionarios T2
                on T1.id_funcionario = T2.id
                inner join centro_custos T3
                on T1.id_centro_custo = T3.id
                where T3.id = 5";

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
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['razao_social'];
                $array[$i]['uf'] = $linha['uf'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllTemp()
    {

        $sql = "SELECT * FROM `" . $this->table;

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
                $array[$i]['ie'] = $linha['ie'];
                $array[$i]['cpf'] = $linha['cpf'];
                $array[$i]['cnpj'] = $linha['cnpj'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['tipo_pessoa'] = $linha['tipo_pessoa'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cep'] = $linha['cep'];
                $array[$i]['rua'] = $linha['rua'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['bairro'] = $linha['bairro'];
                $array[$i]['cidade'] = $linha['cidade'];
                $array[$i]['identificador'] = $linha['nome'] . $linha['razao_social'];
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