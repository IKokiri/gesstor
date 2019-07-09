<?php
namespace App\DAO;
/**
 * INICIO DA CLASSE DE NOME INFODB.
 * CLASSE RESPONSAVEL POR SEGURAR AS INFORMAÇOES RELACIONADAS À CONEXAO COM O
 * BANCO DE DADOS.
 * EST�? CLASSE DEVE SER ALTERADA DE ACORDO COM CADA PROJETO QUE FOR CRIADO.
 * AS VARIAVEIS DA CLASSE DEVEM SER PREENCHIDAS MANUALMENTE.
 */
abstract class InfoDB {
    /**
     * VARIAVEL PRIVADA RESPONSAVEL POR IDENTIFICAR O HOST AO QUAL O BANCO DE
     * DADOS SER�? ACESSADO
     */
    private $host = 'localhost';
    /**
     * VARIAVEL PRIVADA RESPONSAVEL POR IDENTIFICAR O NOME DO BANCO DE DADOS
     * REFERENTE AO PROJETO.
     */
    private $database = 'gesstor';

    /**
     * VARIAVEL PRIVADA RESPONSAVEL POR IDENTIFICAR O USUARIO, O QUAL SER�? USADO
     * PARA FAZER A CONEXAO COM O BANCO DE DADOS
     */
    private $user = 'root';

    /**
     * VARIAVEL PRIVADA RESPONSAVEL POR IDENTIFICAR A SENHA REFERENTE AO USUARIO
     */
    private $password = '';

    /**
     * SEQUENCIA DE METODOS ACESSORES ÀS VARIAVEIS DA CLASSE.
     * APENAS OS METODOS DE LEITURA SÃO APRESENTADOS
     */
    function getHost() {
        return $this->host;
    }

    function getDatabase() {
        return $this->database;
    }

    function getUser() {
        return $this->user;
    }

    function getPassword() {
        return $this->password;
    }

}

