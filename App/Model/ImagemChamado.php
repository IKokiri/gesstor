<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class ImagemChamado extends Model
{
    private $table = 'imagens_chamado';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        //move_uploaded_file($this->file['file']['tmp_name'], '../imagens/chamados/'.$this->file['file']['name']);

        $sql = "INSERT INTO `" . $this->table . "` (name,type,tmp_name,error,size,new_name,id_chamado) VALUES (:name,:type,:tmp_name,:error,:size,:new_name,:id_chamado)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':name', $this->name, PDO::PARAM_STR);
        $query->bindValue(':type', $this->type, PDO::PARAM_STR);
        $query->bindValue(':tmp_name', $this->tmp_name, PDO::PARAM_STR);
        $query->bindValue(':error', $this->error, PDO::PARAM_STR);
        $query->bindValue(':size', $this->size, PDO::PARAM_STR);
        $query->bindValue(':new_name', $this->new_name, PDO::PARAM_STR);
        $query->bindValue(':id_chamado', $this->id_chamado, PDO::PARAM_STR);

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