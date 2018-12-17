<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class ServicoArea extends Model
{
    protected $table = 'servicos_areas';

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
        $sql = "INSERT INTO `" . $this->table . "` (id_servico,id_area,identificador,tipo_taxa,dia_vencimento,numero_meses,area) VALUES (:id_servico,:id_area,:identificador,:tipo_taxa,:dia_vencimento,:numero_meses,:area)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_servico', $this->id_servico, PDO::PARAM_STR);
        $query->bindValue(':id_area', $this->id_area, PDO::PARAM_STR);
        $query->bindValue(':identificador', $this->identificador, PDO::PARAM_STR);
        $query->bindValue(':tipo_taxa', $this->tipo_taxa, PDO::PARAM_STR);
        $query->bindValue(':dia_vencimento', $this->function->data_br_banco($this->dia_vencimento), PDO::PARAM_STR);
        $query->bindValue(':numero_meses', $this->tipo_taxa, PDO::PARAM_STR);
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

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                id_servico = :id_servico,
                id_area = :id_area,
                tipo_taxa = :tipo_taxa,
                dia_vencimento = :dia_vencimento,
                area = :area,
                numero_meses = :numero_meses,
                identificador = :identificador
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_servico', $this->id_servico, PDO::PARAM_STR);
        $query->bindValue(':id_area', $this->id_area, PDO::PARAM_STR);
        $query->bindValue(':identificador', $this->identificador, PDO::PARAM_STR);
        $query->bindValue(':area', $this->area, PDO::PARAM_STR);
        $query->bindValue(':numero_meses', $this->numero_meses, PDO::PARAM_STR);
        $query->bindValue(':dia_vencimento', $this->function->data_br_banco($this->dia_vencimento), PDO::PARAM_STR);
        $query->bindValue(':tipo_taxa', $this->tipo_taxa, PDO::PARAM_STR);


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

        $sql = "SELECT * FROM `" . $this->table . "` WHERE id = :id";

        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        $linha = $query->fetch(PDO::FETCH_ASSOC);
        $array['id'] = $linha['id'];
        $array['id_servico'] = $linha['id_servico'];
        $array['id_area'] = $linha['id_area'];
        $array['dia_vencimento'] = $this->function->data_banco_br($linha['dia_vencimento']);
        $array['numero_meses'] = $linha['numero_meses'];
        $array['identificador'] = $linha['identificador'];
        $array['tipo_taxa'] = $linha['tipo_taxa'];
        $array['area'] = $linha['area'];


        $result['result'] = $array;


        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT * FROM `" . $this->table;

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        Database::comitar($this->dbh);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $array[$i]['id'] = $linha['id'];

                $array[$i]['servico'] = $linha['servico'];

                $array[$i]['valor'] = $linha['valor'];

                $array[$i]['area'] = $linha['area'];

                $array[$i]['status'] = $linha['status'];

            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getServicoArea()
    {

             $sql = "SELECT T1.*,T2.servico,T2.icone FROM `".$this->table."` T1
                inner JOIN servicos T2
                ON T1.id_servico = T2.id
                where T1.area = :area and T1.id_area = :id_area";

        $query = $this->dbh->prepare($sql);
//echo  $this->id_area;
//echo  $this->area;
        $query->bindValue(':id_area', $this->id_area, PDO::PARAM_STR);
        $query->bindValue(':area', $this->area, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $array[$i]['id'] = $linha['id'];

                $array[$i]['identificador'] = $linha['identificador'];

                $array[$i]['servico'] = $linha['servico'];

                $array[$i]['icone'] = $linha['icone'];

            }

            $result['result'] = $array;
        }
        return $result;
    }
    public function getServicoUsuario()
    {
        $table_area = 'funcionarios';

            $sql = "SELECT T1.*,T2.servico,T2.icone FROM `".$this->table."` T1
                inner JOIN servicos T2
                ON T1.id_servico = T2.id
                inner join ".$table_area." T3
                ON T1.id_area = T3.id
                where T3.id_usuario_responsavel = :id_usuario";

        $query = $this->dbh->prepare($sql);
//echo  $this->id_area;
//echo  $this->area;
//        $query->bindValue(':id_area', $this->id_area, PDO::PARAM_STR);
        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);
//        $query->bindValue(':area', $this->area, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $array[$i]['id'] = $linha['id'];

                $array[$i]['identificador'] = $linha['identificador'];

                $array[$i]['servico'] = $linha['servico'];

                $array[$i]['icone'] = $linha['icone'];

            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllActive()
    {

        $sql = "SELECT * FROM `" . $this->table . "` WHERE status ='A'";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['servico'] = $linha['servico'];
                $array[$i]['valor'] = $linha['valor'];
                $array[$i]['area'] = $linha['area'];
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