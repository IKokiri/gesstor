<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Ausencia extends Model
{
    private $table = 'ausencia';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }


    public function create()
    {
        $this->validator->set('Tipo', $this->id_tipo)->is_required();
        $this->validator->set('Colaborador', $this->id_colaborador)->is_required();
        $this->validator->set('Representante', $this->id_representante)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "`(id_tipo,id_colaborador,telefone,telefone_2,id_representante,empresa,ausencia_local,ausencia_de,ausencia_hora,retorno_de,retorno_hora,status,id_representante_2) VALUES 
                                                  (:id_tipo,:id_colaborador,:telefone,:telefone_2,:id_representante,:empresa,:ausencia_local,:ausencia_de,:ausencia_hora,:retorno_de,:retorno_hora,:status,:id_representante_2)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_tipo', $this->id_tipo, PDO::PARAM_STR);
        $query->bindValue(':id_colaborador', $this->id_colaborador, PDO::PARAM_STR);
        $query->bindValue(':telefone', $this->telefone, PDO::PARAM_STR);
        $query->bindValue(':telefone_2', $this->telefone_2, PDO::PARAM_STR);
        $query->bindValue(':id_representante', $this->id_representante, PDO::PARAM_STR);
        $query->bindValue(':id_representante_2', $this->id_representante_2, PDO::PARAM_STR);
        $query->bindValue(':empresa', $this->empresa, PDO::PARAM_STR);
        $query->bindValue(':ausencia_local', $this->ausencia_local, PDO::PARAM_STR);
        $query->bindValue(':ausencia_de', $this->function->data_br_banco($this->ausencia_de), PDO::PARAM_STR);
        $query->bindValue(':ausencia_hora', $this->ausencia_hora, PDO::PARAM_STR);
        $query->bindValue(':retorno_de', $this->function->data_br_banco($this->retorno_de), PDO::PARAM_STR);
        $query->bindValue(':retorno_hora', $this->retorno_hora, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $this->validator->set('Tipo', $this->id_tipo)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                id_tipo = :id_tipo,
                id_colaborador = :id_colaborador,
                telefone = :telefone,
                telefone_2 = :telefone_2,
                id_representante = :id_representante,
                id_representante_2 = :id_representante_2,
                empresa = :empresa,
                ausencia_local = :ausencia_local,
                ausencia_de = :ausencia_de,
                ausencia_hora = :ausencia_hora,
                retorno_de = :retorno_de,
                retorno_hora = :retorno_hora,
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_tipo', $this->id_tipo, PDO::PARAM_STR);
        $query->bindValue(':id_colaborador', $this->id_colaborador, PDO::PARAM_STR);
        $query->bindValue(':telefone', $this->telefone, PDO::PARAM_STR);
        $query->bindValue(':telefone_2', $this->telefone_2, PDO::PARAM_STR);
        $query->bindValue(':id_representante', $this->id_representante, PDO::PARAM_STR);
        $query->bindValue(':id_representante_2', $this->id_representante_2, PDO::PARAM_STR);
        $query->bindValue(':empresa', $this->empresa, PDO::PARAM_STR);
        $query->bindValue(':ausencia_local', $this->ausencia_local, PDO::PARAM_STR);
        $query->bindValue(':ausencia_de', $this->function->data_br_banco($this->ausencia_de), PDO::PARAM_STR);
        $query->bindValue(':ausencia_hora', $this->ausencia_hora, PDO::PARAM_STR);
        $query->bindValue(':retorno_de', $this->function->data_br_banco($this->retorno_de), PDO::PARAM_STR);
        $query->bindValue(':retorno_hora', $this->retorno_hora, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function troca_status()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "UPDATE `" . $this->table . "` 
                SET
                status = :status 
                WHERE id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

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
                $array['id_tipo'] = $linha['id_tipo'];
                $array['id_colaborador'] = $linha['id_colaborador'];
                $array['telefone'] = $linha['telefone'];
                $array['telefone_2'] = $linha['telefone_2'];
                $array['id_representante'] = $linha['id_representante'];
                $array['id_representante_2'] = $linha['id_representante_2'];
                $array['empresa'] = $linha['empresa'];
                $array['ausencia_local'] = $linha['ausencia_local'];
                $array['ausencia_de'] = $this->function->data_banco_br($linha['ausencia_de']);
                $array['ausencia_hora'] = $linha['ausencia_hora'];
                $array['retorno_de'] = $this->function->data_banco_br($linha['retorno_de']);
                $array['retorno_hora'] = $linha['retorno_hora'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getLast()
    {
        $this->validator->set('Id colaborador', $this->id_colaborador)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "SELECT * FROM  `" . $this->table . "` T1
                where id_colaborador = :id_colaborador order by id desc limit 1;";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_colaborador', $this->id_colaborador, PDO::PARAM_STR);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {

            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['id_tipo'] = $linha['id_tipo'];
                $array['id_colaborador'] = $linha['id_colaborador'];
                $array['telefone'] = $linha['telefone'];
                $array['telefone_2'] = $linha['telefone_2'];
                $array['id_representante'] = $linha['id_representante'];
                $array['id_representante_2'] = $linha['id_representante_2'];
                $array['empresa'] = $linha['empresa'];
                $array['ausencia_local'] = $linha['ausencia_local'];
                $array['ausencia_de'] = $this->function->data_banco_br($linha['ausencia_de']);
                $array['ausencia_hora'] = $linha['ausencia_hora'];
                $array['retorno_de'] = $this->function->data_banco_br($linha['retorno_de']);
                $array['retorno_hora'] = $linha['retorno_hora'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {

        $sql = "SELECT * FROM `" . $this->table."`";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['id_tipo'] = $linha['id_tipo'];
                $array[$i]['id_colaborador'] = $linha['id_colaborador'];
                $array[$i]['telefone'] = $linha['telefone'];
                $array[$i]['telefone_2'] = $linha['telefone_2'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['id_representante_2'] = $linha['id_representante_2'];
                $array[$i]['empresa'] = $linha['empresa'];
                $array[$i]['ausencia_local'] = $linha['ausencia_local'];
                $array[$i]['ausencia_de'] = $this->function->data_banco_br($linha['ausencia_de']);
                $array[$i]['ausencia_hora'] = $linha['ausencia_hora'];
                $array[$i]['retorno_de'] = $this->function->data_banco_br($linha['retorno_de']);
                $array[$i]['retorno_hora'] = $linha['retorno_hora'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllJoin()
    {

        $sql = "SELECT T2.tipo,T3.nome as nome_colaborador,T3.sobrenome as sobrenome_colaborador,T4.nome as nome_representante,T4.sobrenome as sobrenome_representante,T5.nome as nome_representante_2,T5.sobrenome as sobrenome_representante_2,T1.* FROM `" . $this->table . "`  T1
                INNER JOIN tipos T2
                    on T1.id_tipo = T2.id
                INNER JOIN funcionarios T3
                    on T1.id_colaborador = T3.id
                INNER JOIN funcionarios T4
                    on T1.id_representante = T4.id
                INNER JOIN funcionarios T5
                    on T1.id_representante_2 = T5.id WHERE T1.retorno_de >= curdate() order by T1.id desc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $aTempData = explode("/",$linha['ausencia_de']);
                $ausencia_de = $aTempData[2]."".$this->function->mes_nome($aTempData[1]);
                $aTempData = explode("/",$linha['retorno_de']);
                $retorno_de = $aTempData[2]."".$this->function->mes_nome($aTempData[1]);


                $array[$i]['id'] = $linha['id'];
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['nome_colaborador'] = $linha['nome_colaborador'];
                $array[$i]['sobrenome_colaborador'] = $linha['sobrenome_colaborador'];
                $array[$i]['nome_representante_2'] = $linha['nome_representante_2'];
                $array[$i]['nome_representante'] = $linha['nome_representante'];
                $array[$i]['sobrenome_representante_2'] = $linha['sobrenome_representante_2'];
                $array[$i]['sobrenome_representante'] = $linha['sobrenome_representante'];
                $array[$i]['id_tipo'] = $linha['id_tipo'];
                $array[$i]['id_colaborador'] = $linha['id_colaborador'];
                $array[$i]['telefone'] = $linha['telefone'];
                $array[$i]['telefone_2'] = $linha['telefone_2'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['id_representante_2'] = $linha['id_representante_2'];
                $array[$i]['empresa'] = $linha['empresa'];
                $array[$i]['ausencia_local'] = $linha['ausencia_local'];
                $array[$i]['ausencia_de'] = $ausencia_de;
                $array[$i]['ausencia_hora'] = $linha['ausencia_hora'];
                $array[$i]['retorno_de'] = $this->function->data_banco_br($linha['retorno_de']);
                $array[$i]['retorno_hora'] = $linha['retorno_hora'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllAusenciaApp()
    {

        $sql = "SELECT T2.tipo,T3.nome as nome_colaborador,T3.sobrenome as sobrenome_colaborador,T4.nome as nome_representante,T4.sobrenome as sobrenome_representante,T5.nome as nome_representante_2,T5.sobrenome as sobrenome_representante_2,T1.* FROM `" . $this->table . "`  T1
                INNER JOIN tipos T2
                    on T1.id_tipo = T2.id
                INNER JOIN funcionarios T3
                    on T1.id_colaborador = T3.id
                INNER JOIN funcionarios T4
                    on T1.id_representante = T4.id
                    INNER JOIN funcionarios T5
                    on T1.id_representante_2 = T5.id WHERE T1.retorno_de >= curdate() order by T1.id desc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['nome_colaborador'] = $linha['nome_colaborador'];
                $array[$i]['sobrenome_colaborador'] = $linha['sobrenome_colaborador'];
                $array[$i]['nome_representante_2'] = $linha['nome_representante_2'];
                $array[$i]['nome_representante'] = $linha['nome_representante'];
                $array[$i]['sobrenome_representante_2'] = $linha['sobrenome_representante_2'];
                $array[$i]['sobrenome_representante'] = $linha['sobrenome_representante'];
                $array[$i]['id_tipo'] = $linha['id_tipo'];
                $array[$i]['id_colaborador'] = $linha['id_colaborador'];
                $array[$i]['telefone'] = $linha['telefone'];
                $array[$i]['telefone_2'] = $linha['telefone_2'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['id_representante_2'] = $linha['id_representante_2'];
                $array[$i]['empresa'] = $linha['empresa'];
                $array[$i]['ausencia_local'] = $linha['ausencia_local'];
                $array[$i]['ausencia_de'] = $this->function->data_banco_br($linha['ausencia_de']);
                $array[$i]['ausencia_hora'] = $linha['ausencia_hora'];
                $array[$i]['retorno_de'] = $this->function->data_banco_br($linha['retorno_de']);
                $array[$i]['retorno_hora'] = $linha['retorno_hora'];
                $array[$i]['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllOrder()
    {

        $dataAtual = date('Y-m-d');

        $sql = "SELECT 
                    T2.tipo,
                    T3.nome as nome_colaborador,
                    T3.sobrenome as sobrenome_colaborador,
                    T4.nome as nome_representante,
                    T4.sobrenome as sobrenome_representante,
                    T5.nome as nome_representante_2,
                    T5.sobrenome as sobrenome_representante_2,
                    T1.* 
                FROM ausencia  T1
                    INNER JOIN tipos T2
                        on T1.id_tipo = T2.id
                    INNER JOIN funcionarios T3
                        on T1.id_colaborador = T3.id
                    INNER JOIN funcionarios T4
                        on T1.id_representante = T4.id
                        INNER JOIN funcionarios T5
                        on T1.id_representante_2 = T5.id
                        #WHERE concat(T1.retorno_de,' ',T1.retorno_hora) >= concat(curdate(),' ',curtime()) and T1.status = 'A'
                        WHERE T1.retorno_de >= curdate() and T1.status = 'A' and if(T1.retorno_de = curdate(), T1.retorno_hora <> 0, T1.retorno_de >= curdate())
                        #WHERE T1.retorno_de >= curdate() and T1.status = 'A'
                    order by T2.ordem asc, id_tipo asc, nome_colaborador asc, ausencia_de desc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['nome_colaborador'] = $linha['nome_colaborador'];
                $array[$i]['sobrenome_colaborador'] = $linha['sobrenome_colaborador'];
                $array[$i]['nome_representante_2'] = $linha['nome_representante_2'];
                $array[$i]['nome_representante'] = $linha['nome_representante'];
                $array[$i]['sobrenome_representante_2'] = $linha['sobrenome_representante_2'];
                $array[$i]['sobrenome_representante'] = $linha['sobrenome_representante'];
                $array[$i]['id_tipo'] = $linha['id_tipo'];
                $array[$i]['id_colaborador'] = $linha['id_colaborador'];
                $array[$i]['telefone'] = $linha['telefone'];
                $array[$i]['telefone_2'] = $linha['telefone_2'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['id_representante_2'] = $linha['id_representante_2'];
                $array[$i]['empresa'] = $linha['empresa'];
                $array[$i]['ausencia_local'] = $linha['ausencia_local'];
                $array[$i]['ausencia_de'] = $this->function->data_dia_mes_escrito($this->function->data_banco_br($linha['ausencia_de']));
                $array[$i]['ausencia_hora'] = $this->function->time_tela($linha['ausencia_hora']);
                $array[$i]['retorno_de'] = $this->function->data_dia_mes_escrito($this->function->data_banco_br($linha['retorno_de']));
                $array[$i]['retorno_hora'] = $this->function->time_tela($linha['retorno_hora']);
                $array[$i]['status'] = $linha['status'];
                $array[$i]['futuro'] = $this->function->comparar_datas_banco($dataAtual,$linha['ausencia_de']);
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