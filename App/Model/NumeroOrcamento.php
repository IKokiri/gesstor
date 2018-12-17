<?php

namespace App\Model;

require_once CORE . DS . 'Model.php';
require_once DAO . DS . 'Database.php';
//CLOG
require_once CONTROLLER . DS . 'Log.php';
use App\Core\Model;
use App\DAO\Database;
use PDO;
use validator\Data_Validator;
//CLOG
use App\Controller\Log as Log_Controller;

class NumeroOrcamento extends Model
{
    private $table = 'numero_orcamentos';

    private $validator;

    public function __construct()
    {
        parent::__construct();
        //CLOG
        $this->log = new Log_Controller();

        $this->validator = new Data_Validator();
    }

    public function create()
    {
        $this->validator->set('Tipo', $this->tipo)->is_required()->is_num();
        $this->validator->set('Numero', $this->numero)->is_required();
        $this->validator->set('Funcionario', $this->id_funcionario)->is_required();
        $this->validator->set('Cliente', $this->id_cliente)->is_required();
        $this->validator->set('Data', $this->data)->is_required();
        $this->validator->set('Objeto', $this->id_objeto)->is_required();

        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['result'] = '';
            $result['validar'] = $erros;
            return $result;
        }

        $sql = "INSERT INTO `" . $this->table . "` (tipo,numero,revisao,data,id_cliente,id_cliente_final,id_objeto,id_representante,proposta_venda,id_status_orcamento,numero_pedido,status,observacao,id_funcionario) 
                VALUES 
                (:tipo,:numero,:revisao,curdate(),:id_cliente,:id_cliente_final,:id_objeto,:id_representante,:proposta_venda,:id_status_orcamento,:numero_pedido,:status,:observacao,:id_funcionario)";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);
        $query->bindValue(':revisao', $this->revisao, PDO::PARAM_STR);
//        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_STR);
        $query->bindValue(':id_cliente_final', $this->id_cliente_final, PDO::PARAM_STR);
        $query->bindValue(':id_objeto', $this->id_objeto, PDO::PARAM_STR);
        $query->bindValue(':id_representante', $this->id_representante, PDO::PARAM_STR);
        $query->bindValue(':proposta_venda', $this->proposta_venda, PDO::PARAM_STR);
        $query->bindValue(':id_status_orcamento', $this->id_status_orcamento, PDO::PARAM_STR);
        $query->bindValue(':numero_pedido', $this->numero_pedido, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);

        $result = Database::executa($query);
//CLOG
        if ($result['result']) {
            $log['tabela'] = $this->table;
            $log['campo'] = '';
            $log['de'] = '';
            $log['para'] = '';
            $log['id_registro'] = $result['lastId'];
            $log['usuario_alteracao'] = $result['lastId'];
            $log['usuario_alteracao'] = $_SESSION['gesstor']['login']['id'];
            $log['operacao'] = "INSERT";
            $this->log->create($log);
        }
        return $result;
    }

    public function update()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }
        //CLOG
        $anterior = $this->getById();
        $anterior = $anterior['result'];

        $sql = "UPDATE `" . $this->table . "` 
                SET 
                revisao = :revisao,
                data = :data,
                id_cliente = :id_cliente,
                id_cliente_final = :id_cliente_final,
                id_objeto = :id_objeto,
                id_representante = :id_representante,
                proposta_venda = :proposta_venda,
                id_status_orcamento = :id_status_orcamento,
                numero_pedido = :numero_pedido,
                observacao = :observacao,
                id_funcionario = :id_funcionario,
                status = :status 
                WHERE id = :id";


        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':revisao', $this->revisao, PDO::PARAM_STR);
        $query->bindValue(':data', $this->function->data_br_banco($this->data), PDO::PARAM_STR);
        $query->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_STR);
        $query->bindValue(':id_cliente_final', $this->id_cliente_final, PDO::PARAM_STR);
        $query->bindValue(':id_objeto', $this->id_objeto, PDO::PARAM_STR);
        $query->bindValue(':id_representante', $this->id_representante, PDO::PARAM_STR);
        $query->bindValue(':proposta_venda', $this->proposta_venda, PDO::PARAM_STR);
        $query->bindValue(':id_status_orcamento', $this->id_status_orcamento, PDO::PARAM_STR);
        $query->bindValue(':numero_pedido', $this->numero_pedido, PDO::PARAM_STR);
        $query->bindValue(':status', $this->status, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $this->id_funcionario, PDO::PARAM_STR);
        $query->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);

        $result = Database::executa($query);
//CLOG
        if ($result['result']) {
            $campo['revisao'] = $this->revisao;
            $campo['data'] = $this->data;
            $campo['id_cliente'] = $this->id_cliente;
            $campo['id_cliente_final'] = $this->id_cliente_final;
            $campo['id_objeto'] = $this->id_objeto;
            $campo['id_representante'] = $this->id_representante;
            $campo['proposta_venda'] = $this->proposta_venda;
            $campo['id_status_orcamento'] = $this->id_status_orcamento;
            $campo['numero_pedido'] = $this->numero_pedido;
            $campo['observacao'] = $this->observacao;
            $campo['id_funcionario'] = $this->id_funcionario;
            $campo['status'] = $this->status;


            $log['tabela'] = $this->table;
            $log['campo'] = $campo;
            $log['anterior'] = $anterior;
            $log['de'] = '';
            $log['para'] = '';
            $log['id_registro'] = $this->id;
            $log['usuario_alteracao'] = $_SESSION['gesstor']['login']['id'];
            $log['operacao'] = "UPDATE";
            $this->log->create($log);
        }
        return $result;
    }

    public function getAllRelatorio()
    {
        $sql = "SELECT 
                    T1.id, T1.numero, T1.revisao, T1.data, T2.sigla
                FROM
                    numero_orcamentos T1
                        INNER JOIN
                    funcionarios T2 ON T1.id_funcionario = T2.id
                    ORDER BY T1.numero asc";

        $query = $this->dbh->prepare($sql);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {


                $dataAno = $this->function->data_banco_br($linha['data']);
                $data = explode('/', $dataAno);
                $mes = $data[1];
                $ano = substr($data[2], 2, 2);
                $mesAno = $mes . $ano;

                $id = $linha['id'];
                $array[$id]['id'] = $id;
                $array[$id]['numero'] = $linha['numero'];
                $array[$id]['revisao'] = $linha['revisao'];
                $array[$id]['id_contrato'] = $linha['id'];
                $array[$id]['sigla'] = $linha['sigla'];
                $array[$id]['data'] = $mesAno;

                $array[$id]['alias'] = $linha['numero'].'.'.$linha['revisao'].'-'.$linha['sigla'].'-'.$mesAno;
            }

            $result['result'] = $array;
        }
        
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
                $array['tipo'] = $linha['tipo'];
                $array['numero'] = $linha['numero'];
                $array['revisao'] = $linha['revisao'];
                $array['data'] = $this->function->data_banco_br($linha['data']);
                $array['id_cliente'] = $linha['id_cliente'];
                $array['id_cliente_final'] = $linha['id_cliente_final'];
                $array['id_objeto'] = $linha['id_objeto'];
                $array['id_representante'] = $linha['id_representante'];
                $array['proposta_venda'] = $linha['proposta_venda'];
                $array['id_status_orcamento'] = $linha['id_status_orcamento'];
                $array['numero_pedido'] = $linha['numero_pedido'];
                $array['observacao'] = $linha['observacao'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['status'] = $linha['status'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function verificaSeUpdate()
    {

        $this->validator->set('Id', $this->id)->is_required();
        $validate = $this->validator->validate();
        $erros = $this->validator->get_errors();

        if (!$validate) {

            $result['validar'] = $erros;
            return $result;
        }

        $sql = "Select * from `" . $this->table . "`
                WHERE id = :id and id_funcionario = :id_funcionario";


        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_funcionario', $_SESSION['gesstor']['login']['id_area'], PDO::PARAM_STR);

        $result = Database::executa($query);

        return $result;
    }

    public function getAllGrid()
    {

        $where = '';

        if (isset($this->tipo_filtro)) {
            $where .= " where tipo = :tipo ";
        } else {
            $where .= " where tipo = '3' ";
        }

        if (isset($this->data_filtro) && $this->data_filtro && $this->data_filtro != "Todos") {

            $where .= " and YEAR(data) = :data ";

        } else if ($this->data_filtro == "Todos") {

        } else {

            $where .= " and YEAR(data) = YEAR(curdate()) ";

        }


        $sql = "SELECT T1.*,T2.sigla,T2.nome,T2.sobrenome,T3.cnpj,T3.cpf,T3.razao_social,T4.razao_social as razao_final,T4.tipo_pessoa,T3.nome as nome_cliente,T3.nome as sobrenome_cliente,T4.nome as nome_final,T5.objeto,T6.representante,T7.statusOrcamento FROM `" . $this->table . "` T1
                    inner join funcionarios T2
                    on T1.id_funcionario = T2.id
                    left join clientes T3
                    on T1.id_cliente = T3.id
                    left join clientes T4
                    on T1.id_cliente_final = T4.id
                    left join objetos T5
                    on T1.id_objeto = T5.id
                    left join representantes T6
                    on T1.id_representante = T6.id
                    left join statusorcamentos T7
                    on T1.id_status_orcamento = T7.id 
                     " . $where . " 
                    order by T1.data desc,T1.numero desc";

        $query = $this->dbh->prepare($sql);


        if (isset($this->tipo_filtro)) {

            $query->bindValue(':tipo', $this->tipo_filtro, PDO::PARAM_STR);
        }

        if (isset($this->data_filtro) && $this->data_filtro != "Todos") {

            $query->bindValue(':data', $this->data_filtro, PDO::PARAM_STR);
        }


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['numeroPad'] = str_pad($linha['numero'], $linha['tipo'], 0, STR_PAD_LEFT);
                $array[$i]['revisao'] = $linha['revisao'];
                $array[$i]['revisaoPad'] = str_pad($linha['revisao'], 2, 0, STR_PAD_LEFT);
                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['id_cliente'] = $linha['id_cliente'];
                $array[$i]['id_cliente_final'] = $linha['id_cliente_final'];
                $array[$i]['id_objeto'] = $linha['id_objeto'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['proposta_venda'] = $linha['proposta_venda'];
                $array[$i]['id_status_orcamento'] = $linha['id_status_orcamento'];
                $array[$i]['data_gerado'] = $linha['data_gerado'];
                $array[$i]['numero_pedido'] = $linha['numero_pedido'];
                $array[$i]['observacao'] = $linha['observacao'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['razao_social'] = $linha['razao_social'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['razao_final'] = $linha['razao_final'];
                $array[$i]['nome_final'] = $linha['nome_final'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['representante'] = $linha['representante'];
                $array[$i]['statusOrcamento'] = $linha['statusOrcamento'];
                $array[$i]['cliente'] = $linha['razao_social'];

                if ($linha['tipo_pessoa'] == "Jurídica") {
                    $array[$i]['identificador'] = $linha['razao_social'] . " - " . $linha['cnpj'];
                } else {
                    $array[$i]['identificador'] = $linha['nome_cliente'] . " " . $linha['sobrenome_cliente'] . " - " . $linha['cpf'];
                }
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAll()
    {


        $sql = "SELECT T1.*,T2.sigla,T2.nome,T2.sobrenome,T3.cnpj,T3.cpf,T3.razao_social,T4.razao_social as razao_final,T4.tipo_pessoa,T3.nome as nome_cliente,T3.nome as sobrenome_cliente,T4.nome as nome_final,T5.objeto,T6.representante,T7.statusOrcamento FROM `" . $this->table . "` T1
                    inner join funcionarios T2
                    on T1.id_funcionario = T2.id
                    left join clientes T3
                    on T1.id_cliente = T3.id
                    left join clientes T4
                    on T1.id_cliente_final = T4.id
                    left join objetos T5
                    on T1.id_objeto = T5.id
                    left join representantes T6
                    on T1.id_representante = T6.id
                    left join statusorcamentos T7
                    on T1.id_status_orcamento = T7.id 
                    order by T1.data desc";

        $query = $this->dbh->prepare($sql);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['numeroPad'] = str_pad($linha['numero'], $linha['tipo'], 0, STR_PAD_LEFT);
                $array[$i]['revisao'] = $linha['revisao'];
                $array[$i]['revisaoPad'] = str_pad($linha['revisao'], 2, 0, STR_PAD_LEFT);
                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['id_cliente'] = $linha['id_cliente'];
                $array[$i]['id_cliente_final'] = $linha['id_cliente_final'];
                $array[$i]['id_objeto'] = $linha['id_objeto'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['proposta_venda'] = $linha['proposta_venda'];
                $array[$i]['id_status_orcamento'] = $linha['id_status_orcamento'];
                $array[$i]['data_gerado'] = $linha['data_gerado'];
                $array[$i]['numero_pedido'] = $linha['numero_pedido'];
                $array[$i]['observacao'] = $linha['observacao'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['razao_social'] = $linha['razao_social'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['razao_final'] = $linha['razao_final'];
                $array[$i]['nome_final'] = $linha['nome_final'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['representante'] = $linha['representante'];
                $array[$i]['statusOrcamento'] = $linha['statusOrcamento'];
                $array[$i]['cliente'] = $linha['razao_social'];

                if ($linha['tipo_pessoa'] == "Jurídica") {
                    $array[$i]['identificador'] = $linha['razao_social'] . " - " . $linha['cnpj'];
                } else {
                    $array[$i]['identificador'] = $linha['nome_cliente'] . " " . $linha['sobrenome_cliente'] . " - " . $linha['cpf'];
                }
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getAllNumero()
    {


        $sql = "SELECT T1.*,T2.sigla,T2.nome,T2.sobrenome,T3.cnpj,T3.cpf,T3.razao_social,T4.razao_social as razao_final,T4.tipo_pessoa,T3.nome as nome_cliente,T3.nome as sobrenome_cliente,T4.nome as nome_final,T5.objeto,T6.representante,T7.statusOrcamento FROM `" . $this->table . "` T1
                    inner join funcionarios T2
                    on T1.id_funcionario = T2.id
                    left join clientes T3
                    on T1.id_cliente = T3.id
                    left join clientes T4
                    on T1.id_cliente_final = T4.id
                    left join objetos T5
                    on T1.id_objeto = T5.id
                    left join representantes T6
                    on T1.id_representante = T6.id
                    left join statusorcamentos T7
                    on T1.id_status_orcamento = T7.id 
                    order by T1.numero asc";

        $query = $this->dbh->prepare($sql);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['id'];
                $array[$i]['tipo'] = $linha['tipo'];
                $array[$i]['sigla'] = $linha['sigla'];
                $array[$i]['numero'] = $linha['numero'];
                $array[$i]['numeroPad'] = str_pad($linha['numero'], $linha['tipo'], 0, STR_PAD_LEFT);
                $array[$i]['revisao'] = $linha['revisao'];
                $array[$i]['revisaoPad'] = str_pad($linha['revisao'], 2, 0, STR_PAD_LEFT);
                $array[$i]['data'] = $this->function->data_banco_br($linha['data']);
                $array[$i]['id_cliente'] = $linha['id_cliente'];
                $array[$i]['id_cliente_final'] = $linha['id_cliente_final'];
                $array[$i]['id_objeto'] = $linha['id_objeto'];
                $array[$i]['id_representante'] = $linha['id_representante'];
                $array[$i]['proposta_venda'] = $linha['proposta_venda'];
                $array[$i]['id_status_orcamento'] = $linha['id_status_orcamento'];
                $array[$i]['data_gerado'] = $linha['data_gerado'];
                $array[$i]['numero_pedido'] = $linha['numero_pedido'];
                $array[$i]['observacao'] = $linha['observacao'];
                $array[$i]['id_funcionario'] = $linha['id_funcionario'];
                $array[$i]['status'] = $linha['status'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['sobrenome'] = $linha['sobrenome'];
                $array[$i]['razao_social'] = $linha['razao_social'];
                $array[$i]['nome'] = $linha['nome'];
                $array[$i]['razao_final'] = $linha['razao_final'];
                $array[$i]['nome_final'] = $linha['nome_final'];
                $array[$i]['objeto'] = $linha['objeto'];
                $array[$i]['representante'] = $linha['representante'];
                $array[$i]['statusOrcamento'] = $linha['statusOrcamento'];
                $array[$i]['cliente'] = $linha['razao_social'];

                if ($linha['tipo_pessoa'] == "Jurídica") {
                    $array[$i]['identificador'] = $linha['razao_social'] . " - " . $linha['cnpj'];
                } else {
                    $array[$i]['identificador'] = $linha['nome_cliente'] . " " . $linha['sobrenome_cliente'] . " - " . $linha['cpf'];
                }
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function anosPropostas()
    {


        $sql = "select distinct YEAR(data) as data from numero_orcamentos order by data desc";

        $query = $this->dbh->prepare($sql);


        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[] = $linha['data'];

            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getJoinId()
    {

        $sql = "SELECT T1.*,T2.sigla,T2.nome as nome_funcionario,T2.sobrenome as sobrenome_funcionario,T3.razao_social,T4.nome_reduzido,T4.razao_social as razao_final,T3.nome,
                    T4.nome as nome_final,T5.objeto,T6.representante,T7.statusOrcamento FROM `" . $this->table . "` T1
                    inner join funcionarios T2
                    on T1.id_funcionario = T2.id
                    left join clientes T3
                    on T1.id_cliente = T3.id
                    left join clientes T4
                    on T1.id_cliente_final = T4.id
                    left join objetos T5
                    on T1.id_objeto = T5.id
                    left join representantes T6
                    on T1.id_representante = T6.id
                    left join statusorcamentos T7
                    on T1.id_status_orcamento = T7.id where T1.id = :id";

        $query = $this->dbh->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $dataGerado = explode(' ', $linha['data_gerado']);
                $array['id'] = $linha['id'];
                $array['tipo'] = $linha['tipo'];
                $array['nome_funcionario'] = $linha['nome_funcionario'];
                $array['sobrenome_funcionario'] = $linha['sobrenome_funcionario'];
                $array['sigla'] = $linha['sigla'];
                $array['numero'] = $linha['numero'];
                $array['numeroPad'] = str_pad($linha['numero'], $linha['tipo'], 0, STR_PAD_LEFT);
                $array['revisao'] = $linha['revisao'];
                $array['revisaoPad'] = str_pad($linha['revisao'], 2, 0, STR_PAD_LEFT);
                $array['data'] = $this->function->data_banco_br($linha['data']);
                $array['id_cliente'] = $linha['id_cliente'];
                $array['id_cliente_final'] = $linha['id_cliente_final'];
                $array['id_objeto'] = $linha['id_objeto'];
                $array['id_representante'] = $linha['id_representante'];
                $array['proposta_venda'] = $linha['proposta_venda'];
                $array['id_status_orcamento'] = $linha['id_status_orcamento'];
                $array['data_gerado'] = $linha['data_gerado'];
                $array['data_gerado_data'] = $this->function->data_banco_br($dataGerado[0]);
                $array['data_gerado_hora'] = $dataGerado[1];
                $array['numero_pedido'] = $linha['numero_pedido'];
                $array['observacao'] = $linha['observacao'];
                $array['id_funcionario'] = $linha['id_funcionario'];
                $array['status'] = $linha['status'];
                $array['nome'] = $linha['nome'];
                $array['sobrenome'] = $linha['sobrenome'];
                $array['razao_social'] = $linha['razao_social'];
                $array['nome_reduzido'] = $linha['nome_reduzido'];
                $array['nome'] = $linha['nome'];
                $array['razao_final'] = $linha['razao_final'];
                $array['nome_final'] = $linha['nome_final'];
                $array['objeto'] = $linha['objeto'];
                $array['representante'] = $linha['representante'];
                $array['statusOrcamento'] = $linha['statusOrcamento'];
                $array['cliente'] = $linha['razao_social'] . $linha['nome'];
                $array['proposta'] = $array['numeroPad'] . '.' . $linha['revisao'] . '-' . $linha['sigla'] . '-'
                    . $this->function->en_mes_ano_kuttner($linha['data']).'-'.$linha['razao_social'];
            }

            $result['result'] = $array;
        }
        return $result;
    }

    public function getNext()
    {

        if ($this->tipo == 3) {
            $sql = "SELECT * FROM `" . $this->table . "` " .
                "WHERE tipo = :tipo and YEAR(data_gerado) = YEAR(curdate())" .
                "order by id desc limit 1";

        } else {
            $sql = "SELECT * FROM `" . $this->table . "` " .
                "WHERE tipo = :tipo " .
                "order by id desc limit 1";
        }


        $query = $this->dbh->prepare($sql);

        $query->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);

        $result = Database::executa($query);

        if ($result['status'] && $result['count']) {
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array['id'] = $linha['id'];
                $array['revisao'] = $linha['revisao'];

                if ($linha['numero'] == '999' && $linha['tipo'] == '3') {
                    $array['numeroPad'] = str_pad(1, $linha['tipo'], 0, STR_PAD_LEFT);
                    $array['numero'] = 1;
                } else {

                    $array['numero'] = $linha['numero'] + 1;
                    $array['numeroPad'] = str_pad($linha['numero'] + 1, $linha['tipo'], 0, STR_PAD_LEFT);
                }

            }

            $result['result'] = $array;
        } else {
            $array['numero'] = 1;
            $array['numeroPad'] = str_pad(1, $this->tipo, 0, STR_PAD_LEFT);
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