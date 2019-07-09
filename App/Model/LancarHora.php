<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class LancarHora extends Model
{
    private $table = 'horas';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Data', $this->data)->is_required();
        $this->validator->set('Tipo', $this->id_tabela)->is_required();
        $this->validator->set('Complemento', $this->id_tabela_complemento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO " . $this->table . " (data,id_funcionario,id_tabela,id_tabela_complemento,id_aplicacao) VALUES (:data,:id_funcionario,:id_tabela,:id_tabela_complemento,:id_aplicacao)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':data', $this->data, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->id_tabela_complemento, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao', $this->id_aplicacao, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Data', $this->data)->is_required();
        $this->validator->set('Funcionário', $this->id_funcionario)->is_required();
        $this->validator->set('Tabela', $this->id_tabela)->is_required();
        $this->validator->set('Complemento', $this->id_tabela_complemento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE " . $this->table . " 
                SET 
                tempo = :tempo,
                id_motivo_ausencia = :id_motivo_ausencia
                WHERE data = :data and id_funcionario = :id_funcionario and id_tabela = :id_tabela and id_tabela_complemento = :id_tabela_complemento and id_aplicacao = :id_aplicacao";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':data', $this->data, PDO::PARAM_STR);
        $query->bindValue(':tempo', $this->tempo, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->id_tabela_complemento, PDO::PARAM_STR);
        $query->bindValue(':id_motivo_ausencia', $this->id_motivo_ausencia, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao', $this->id_aplicacao, PDO::PARAM_STR);

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
                $array['menu'] = $linha['menu'];
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
                $array[$i]['menu'] = $linha['menu'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllData()
    {

        $sql = "select T1.*,T2.nome,T2.sobrenome,T3.ausencia,T5.centroCusto,T5.departamento,T6.aplicacao,T6.alias from  " . $this->table . "  T1
                inner join funcionarios T2
                on T1.id_funcionario = T2.id
                left join motivos_ausencia T3
                on T1.id_motivo_ausencia = T3.id
                left join funcionarios_centro_custos T4
                on T2.id = T4.id_funcionario
                left join centro_custos T5
                on T4.id_centro_custo = T5.id
                left join aplicacoes T6
                on T1.id_aplicacao = T6.id
                where T1.data BETWEEN :dataInicio AND :dataFim and T1.id_funcionario = :id_funcionario ORDER BY T1.id_tabela desc,T1.id_tabela_complemento asc,T1.id_aplicacao asc,T1.data asc";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['data'] = $linha['data'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['departamento'] = $linha['departamento'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['ausencia'] = $linha['ausencia'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['tempo'] = $linha['tempo'];
                $array[$i]['id_aplicacao'] = $linha['id_aplicacao'];
                $array[$i]['aplicacao'] = $linha['aplicacao'];
                $array[$i]['alias'] = $linha['alias'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

//    public function verificarFinalizado()
//    {
//
//        $sql = "select * from  " . $this->table . "
//                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario AND status = 'FINALIZADO'";
//
//
//        $query = $this->dbh->prepare($sql);
//
//
//        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
//        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
//        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
//
//        $result = Database::executa($query);
//
//        if ($result['status'] && $result['count']) {
//            return true;
//        } else {
//            return false;
//        }
//
//    }

    public function verificarAprovado()
    {

        $sql = "select * from  " . $this->table . " 
                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario AND status = 'APROVADO'";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            return true;
        } else {
            return false;
        }

    }

    public function verificarFinalizado()
    {

        $sql = "select * from  " . $this->table . " 
                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario AND status = 'FINALIZADO'";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            return true;
        } else {
            return false;
        }

    }

    public function finalizar()
    {

        $sql = "update  " . $this->table . "
                set status = 'FINALIZADO'
                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function situacaoHoras()
    {

        $sql = "select T1.status,T1.id_funcionario,T3.nome,T3.sobrenome from " . $this->table . " T1
                    right join funcionarios_horas T2
                    on T1.id_funcionario =  T2.id_funcionario and T1.data between :dataInicio and :dataFim
                    inner join funcionarios T3 
                    on T2.id_funcionario = T3.id
                    group by T2.id_funcionario order by T1.status desc,T3.nome asc";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function aprovar()
    {

        $sql = "update  " . $this->table . "
                set status = 'APROVADO'
                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function cancelar()
    {

        $sql = "update  " . $this->table . "
                set status = ''
                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function desaprovar()
    {

        $sql = "update  " . $this->table . "
                set status = ''
                where data BETWEEN :dataInicio AND :dataFim and id_funcionario = :id_funcionario";


        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

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

        $sql = "DELETE FROM " . $this->table . " 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function deleteHoras()
    {

        $this->validator->set('dataInicio', $this->dataInicio)->is_required();
        $this->validator->set('dataFim', $this->dataFim)->is_required();
        $this->validator->set('id_funcionario', $this->id_funcionario)->is_required();
        $this->validator->set('id_tabela', $this->id_tabela)->is_required();
        $this->validator->set('id_tabela_complemento', $this->id_tabela_complemento)->is_required();
        $this->validator->set('id_aplicacao', $this->id_aplicacao)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM " . $this->table . " 
                WHERE data between :dataInicio and :dataFim and id_funcionario = :id_funcionario and id_tabela = :id_tabela and id_tabela_complemento = :id_tabela_complemento and id_aplicacao = :id_aplicacao";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':dataInicio', $this->function->data_br_banco($this->dataInicio), PDO::PARAM_STR);
        $query->bindValue(':dataFim', $this->function->data_br_banco($this->dataFim), PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->id_tabela_complemento, PDO::PARAM_STR);
        $query->bindValue(':id_aplicacao', $this->id_aplicacao, PDO::PARAM_STR);

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