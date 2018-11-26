<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Log extends Model
{
    private $table = 'logs';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('tabela', $this->tabela)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (tabela,campo,de,para,id_registro,data,hora,usuario_alteracao,operacao) VALUES (:tabela,:campo,:de,:para,:id_registro,curdate(),curtime(),:usuario_alteracao,:operacao)";


        $query = $this->dbh->prepare($sql);

        $query->bindValue(':tabela', $this->tabela, PDO::PARAM_STR);
        $query->bindValue(':campo', $this->campo, PDO::PARAM_STR);
        $query->bindValue(':de', $this->de, PDO::PARAM_STR);
        $query->bindValue(':para', $this->para, PDO::PARAM_STR);
        $query->bindValue(':id_registro', $this->id_registro, PDO::PARAM_STR);
        $query->bindValue(':usuario_alteracao', $this->usuario_alteracao, PDO::PARAM_STR);
        $query->bindValue(':operacao', $this->operacao, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }


    public function getAll()
    {

        $sql = "SELECT T1.*,T3.nome,T3.sobrenome FROM " . $this->table." T1 " .
            " LEFT JOIN usuarios T2 " .
            " on T1.usuario_alteracao = T2.id " .
            " LEFT JOIN funcionarios T3 " .
            " on T2.id = T3.id_usuario_responsavel";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $array[$i]['id'] = $linha['id'];
                $array[$i]['tabela'] = $linha['tabela'];
                $array[$i]['campo'] = $linha['campo'];
                $array[$i]['de'] = $linha['de'];
                $array[$i]['para'] = $linha['para'];
                $array[$i]['id_registro'] = $linha['id_registro'];
                $array[$i]['data'] = $linha['data'];
                $array[$i]['usuario_alteracao'] = $linha['usuario_alteracao'];
                $array[$i]['hora'] = $linha['hora'];
                $array[$i]['operacao'] = $linha['operacao'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];

            }

            $result['result'] = $array;
        }
        return $result;
    }

    function populate($object)
    {
        foreach ($object as $key => $attrib) {
            $this->$key = $attrib;
        }
    }


}