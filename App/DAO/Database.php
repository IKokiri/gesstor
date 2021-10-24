<?php
namespace App\DAO;
/**
 * INCLUSAO DA CLASSE QUE SEGURA AS INFORMAÇOES PARA CONEXÃO COM O BANCO
 */
require_once 'InfoDB.php';
require_once 'erros.php';
use PDO;

/**
 * INICIO DA CLASSE CHAMADA DATABASE.
 * A CLASSE FAZ EXTENSAO DA INFODB PARA ACESSAR AS INFORMAÇOES REFERENTES À CONEXAO
 * COM O BANCO DE DADOS.
 */
class Database extends InfoDB
{

    /**
     * VARIAVEL RESPONSAVEL POR SEGURAR O OBJETO DA CONEXAO COM O BANCO DE DADOS
     * DEFINIDA COMO STATICA PARA SEJA ACESSADA DE QUALQUER LUGAR DO SOFTWARE
     */
    private static $con = null;

    /**
     * METODO ACESSOR ALTERADO PARA VERIFICAR SE JA EXISTE UMA INSTANCIA DO
     * OBJETO DE CONEXAO.
     */
    static function getConnect()
    {
        /**
         * VERIFICA SE A VARIAVEL ESTATICA QUE SEGURA A CONEXAO ESTA NULA, CASO
         * NAO SEJA NULA, ISSO EQUIVALE À UMA VARIAVEL QUE JA POSSUI UM OBJETO COM
         * CONEXAO COM O BANCO
         */
        if (self::$con == null) {
            /**
             * FAZ INSTANCIA DA CLASSE DATABASE
             */
            $data = new Database();
            /**
             * CHAMA O METODO QUE ATRIBUI À VARIAVEL ESTATICA UM OBJETO DE
             * CONEXAO COM O BANCO
             */
            $data->connect();
        }

        /**
         * RETORNA O OBJETO DE CONEXAO COM O BANCO
         */
        return self::$con;
    }

    /**
     * METODO PARA CRIAR O OBJETO DE CONEXAO COM O BANCO E ATRIBUI-LO NA
     * VARIAVEL ESTATICA RESPPONSAVEL PELO MESMO
     */
    private function connect()
    {

        /**
         * A TENTATIVA DE CRIAR UM OBJETO COM A CONEXAO DO BANCO É FEITA
         */
        try {
            /**
             * SALVA NA VARIAVEL ESTATICA O OBJETO REFERENTE A CONEXÃO COM O BANCO.
             * AS VARIAVEIS QUE SAO USADAS PARA CONEXAO SÃO DA CLASSE PAI
             */
            self::$con = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getDatabase() . '', $this->getUser(), $this->getPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            /**
             * DEFINE O TIPO DE MANIPULAÇÃO DE ERRO SERÁ USADO PELO PDO
             */
            self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            /**
             * CAPTURA O ERRO, SE GERADO
             */
        } catch (\PDOException $error) {
            /**
             * O ERRO É IMPRESSO NA TELA
             */
            echo $error->getMessage();
        }
    }

    /**
     * METODO PARA CRIAR O OBJETO DE CONEXAO COM O BANCO E ATRIBUI-LO NA
     * VARIAVEL ESTATICA RESPPONSAVEL PELO MESMO
     */
    static function init_transection($dbh)
    {

        $dbh->beginTransaction();

    }

//CENTRALIZANDO A EXECUÇÃO DE QUERY TODA QUERY DO SISTEMA DEVE SER ENVIADA PARA ESSA FUNÇÃO

    static function executa($sql)
    {


        try {

            $arrayRetorno['status'] = true;
            $arrayRetorno['result'] = $sql->execute();
            $arrayRetorno['count'] = $sql->rowCount();
            if ($num = Database::$con->lastInsertId()) {
                $arrayRetorno['lastId'] = self::criptografar($num);
            }
            $arrayRetorno['MSN'] = "";

        } catch (\PDOException $Exception) {
            // print_r($Exception);

            $arrayErro = verificarErro($Exception->getCode());
            $arrayRetorno['status'] = false;
            $arrayRetorno['result'] = "";
            $arrayRetorno['msnErro'] = $Exception;
            $arrayRetorno['MSN'] = $arrayErro['erro'];
            $arrayRetorno['cliente'] = $arrayErro['cliente'];
            Database::sendMailerror($Exception);
        }

        return $arrayRetorno;

    }

    //CENTRALIZANDO A EXECUÇÃO DE QUERY TODA QUERY DO SISTEMA DEVE SER ENVIADA PARA ESSA FUNÇÃO

    function criptografar($string)
    {
        return $string;
    }

    private static function sendMailerror($Exception)
    {
        $erro = $Exception->getMessage();
        return $erro;
    }

    static function comitar($dbh)
    {

        $dbh->commit();

    }

    static function rollbackar($dbh)
    {

        $dbh->rollBack();

    }

}
