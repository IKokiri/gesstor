<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';

use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;

class Cobranca extends Model
{
    protected $table = 'cobrancas';

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

        $sql = "INSERT INTO " . $this->table . " (id_servico_cliente,valor_servico,dia_vencimento) VALUES (:id_servico_cliente,:valor_servico,:dia_vencimento)";

        $query = $this->dbh->prepare($sql);


        $query->bindValue(':id_servico_cliente', $this->id_servico_cliente, PDO::PARAM_STR);
        $query->bindValue(':valor_servico', $this->valor_servico, PDO::PARAM_STR);
        $query->bindValue(':dia_vencimento', $this->function->data_br_banco($this->dia_vencimento), PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function delete()
    {

        $this->validator->set('id_servico_cliente', $this->id_servico_cliente)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "DELETE FROM " . $this->table . " 
                WHERE id_servico_cliente = :id_servico_cliente";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id_servico_cliente', $this->id_servico_cliente, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    function populate($object)
    {
        foreach ($object as $key => $attrib) {
            $this->$key = $attrib;
        }
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

        $sql = "SELECT T1.id as id_cobranca,T1.valor_servico,T1.dia_vencimento,T2.identificador,T3.nome,T3.sobrenome,T3.razao_social,T3.fantasia,T3.tipo_pessoa,
                T3.rua,T3.numero,T3.bairro,T3.cep,T3.cidade,T3.uf,T4.email FROM " . $this->table . " T1
                inner join servicos_areas T2
                    on T1.id_servico_cliente = T2.id
                inner join clientes T3
                    on T2.id_area = T3.id
                inner join usuarios T4
                    on T3.id_usuario_responsavel = T4.id
                    where T1.id = :id";

        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);


        $result = Database::executa($query);

        $linha = $query->fetch(PDO::FETCH_ASSOC);

        $array['valor_servico'] = $linha['valor_servico'];
        $array['dia_vencimento'] = $this->function->data_banco_br($linha['dia_vencimento']);
        $array['identificador'] = $linha['identificador'];
        $array['nome'] = $linha['nome'];
        $array['id_cobranca'] = $linha['id_cobranca'];
        $array['sobrenome'] = $linha['sobrenome'];
        $array['fantasia'] = $linha['fantasia'];
        $array['razao_social'] = $linha['razao_social'];
        $array['tipo_pessoa'] = $linha['tipo_pessoa'];
        $array['rua'] = $linha['rua'];
        $array['numero'] = $linha['numero'];
        $array['bairro'] = $linha['bairro'];
        $array['cep'] = $linha['cep'];
        $array['cidade'] = $linha['cidade'];
        $array['uf'] = $linha['uf'];
        $array['email'] = $linha['email'];

        $result['result'] = $array;


        return $result;
    }



    public function update_link()
    {

        $sql = "UPDATE " . $this->table . " 
                SET 
                link_pagamento_gerado = :link_pagamento_gerado
                WHERE id = :id";
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':link_pagamento_gerado', $this->paymentLink, PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

}