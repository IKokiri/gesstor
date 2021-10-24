<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Status extends Model
{
    private $table = 'status';

    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Data_Validator();
    }

    public function getAll()
    {

        $sql = "SELECT * FROM " . $this->table;

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);


        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {

                $array[$i]['id'] = $linha['id'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['cor'] = $linha['cor'];
                $array[$i]['descricao'] = $linha['descricao'];

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