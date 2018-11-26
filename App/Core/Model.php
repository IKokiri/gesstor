<?php
namespace App\Core;


use App\Complement\Functions;
use App\DAO\Database;

require_once DAO . DS . 'Database.php';

require_once VENDOR_APP . DS . 'datavalidator' . DS . 'Model' . DS . 'DataValidator.php';
require_once COMPLEMENT . DS . 'Functions.php';


class Model extends Database
{
    protected $dbh;
    protected $function;


    public function __construct()
    {
        $this->dbh = Database::getConnect();
        $this->function = new Functions();
    }

    function commit()
    {
        Database::comitar($this->dbh);
    }

    function rollback()
    {
        Database::rollbackar($this->dbh);
    }

    function transection()
    {
        Database::init_transection($this->dbh);
    }


}