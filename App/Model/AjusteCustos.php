<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class AjusteCustos extends Model
{
    private $table = 'ajustes_custos';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Tipo', $this->id_tabela)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (valor,id_tabela,id_tabela_complemento,data,status,id_centro_custo) VALUES (:valor,:id_tabela,:id_tabela_complemento,:data,:status,:id_centro_custo)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':valor', $this->valor, PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->id_tabela_complemento, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {


        $this->validator->set('Centro Custo', $this->id_centro_custo)->is_required();
        $this->validator->set('Data', $this->data)->is_required();
        $this->validator->set('Tipo', $this->id_tabela)->is_required();
        $this->validator->set('Complemento', $this->id_tabela_complemento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                valor = :valor,
                id_tabela = :id_tabela,
                id_tabela_complemento = :id_tabela_complemento,
                data = :data,
                id_centro_custo = :id_centro_custo,
                status = :status 
               WHERE id_centro_custo = :l_id_centro_custo and data = :l_data and id_tabela = :l_id_tabela and id_tabela_complemento = :l_id_tabela_complemento";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':valor', $this->valor, PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->id_tabela_complemento, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_centro_custo', $this->id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':l_id_centro_custo', $this->l_id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':l_data', $this->function->data_br_banco($this->l_data), PDO::PARAM_STR);
        $query->bindValue(':l_id_tabela', $this->l_id_tabela, PDO::PARAM_STR);
        $query->bindValue(':l_id_tabela_complemento', $this->l_id_tabela_complemento, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getById()
    {


        $this->validator->set('Centro Custo', $this->l_id_centro_custo)->is_required();
        $this->validator->set('Data', $this->l_data)->is_required();
        $this->validator->set('Tipo', $this->l_id_tabela)->is_required();
        $this->validator->set('Complemento', $this->l_id_tabela_complemento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT T1.* FROM `" . $this->table . "` T1
                WHERE T1.id_centro_custo = :id_centro_custo and T1.data = :data and T1.id_tabela = :id_tabela and T1.id_tabela_complemento = :id_tabela_complemento";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_centro_custo', $this->l_id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->l_data), PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->l_id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->l_id_tabela_complemento, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['valor'] = $linha['valor'];
                $array['id_tabela'] = $linha['id_tabela'];
                $array['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array['id_centro_custo'] = $linha['id_centro_custo'];
                $array['data'] = $this->function->data_banco_barra_mes_ano($this->function->data_banco_br($linha['data']));
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT T1.*,T2.divisao,T4.numero as numero_c,T3.numero as numero_p,T3.revisao,T5.centroCusto,T5.id as id_centro_custo FROM `" . $this->table . "` T1
                   left join sub_contratos T2
                   on T1.id_tabela_complemento = T2.id
                   left join contratos T4
                   on T2.id_contrato = T4.id
                   left join numero_orcamentos T3
                   on T1.id_tabela_complemento = T3.id
                   left join centro_custos T5
                   on T1.id_centro_custo = T5.id";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['divisao'] = $linha['divisao'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['centroCusto'] = $linha['centroCusto'];
                $array[$i]['numero'] = ($linha['id_tabela'] == 1) ? $linha['numero_c'] . "." . $linha['divisao'] : $linha['numero_p'] . '.' . $linha['revisao'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllDetalhado()
    {

         $sql = "select * from ajustes_custos where data >= :data_inicio and data <= :data_fim";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':data_inicio', $this->function->data_br_banco($this->data_inicio), PDO::PARAM_STR);
        $query->bindValue(':data_fim', $this->function->data_br_banco($this->data_fim), PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $data = explode('-',$linha['data']);
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['id_tabela'] = $linha['id_tabela'];
                $array[$i]['id_tabela_complemento'] = $linha['id_tabela_complemento'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['id_centro_custo'] = $linha['id_centro_custo'];
                $array[$i]['dia'] = $data[2];
                $array[$i]['mes'] = $data[1];
                $array[$i]['ano'] = $data[0];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function delete()
    {

        $this->validator->set('Centro Custo', $this->l_id_centro_custo)->is_required();
        $this->validator->set('Data', $this->l_data)->is_required();
        $this->validator->set('Tipo', $this->l_id_tabela)->is_required();
        $this->validator->set('Complemento', $this->l_id_tabela_complemento)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM `" . $this->table . "` 
                WHERE id_centro_custo = :id_centro_custo and data = :data and id_tabela = :id_tabela and id_tabela_complemento = :id_tabela_complemento";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_centro_custo', $this->l_id_centro_custo, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->l_data), PDO::PARAM_STR);
        $query->bindValue(':id_tabela', $this->l_id_tabela, PDO::PARAM_STR);
        $query->bindValue(':id_tabela_complemento', $this->l_id_tabela_complemento, PDO::PARAM_STR);



        $result = Database::executa($query);
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