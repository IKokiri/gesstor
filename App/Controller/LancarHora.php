<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'LancarHora.php';
require_once MODEL . DS . 'MotivoAusencia.php';
require_once MODEL . DS . 'NumeroOrcamento.php';
require_once MODEL . DS . 'SubContrato.php';
require_once MODEL . DS . 'CentroCusto.php';
require_once MODEL . DS . 'FuncionarioCentroCusto.php';
require_once VIEW . DS . 'LancarHora.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\FuncionarioCentroCusto;
use App\Model\LancarHora as LancarHora_Model;
use App\Model\MotivoAusencia as MotivoAusencia_Model;
use App\Model\NumeroOrcamento as NumeroOrcamento_Model;
use App\Model\SubContrato as SubContrato_Model;
use App\Model\CentroCusto as CentroCusto_Model;
use App\Model\FuncionarioCentroCusto as FuncionarioCentroCusto_Model;
use App\Model\MotivoAusencia;
use App\Model\SubContrato;
use App\View\LancarHora as LancarHora_View;

class LancarHora extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new LancarHora_Model();

        $this->oView = new LancarHora_View();
    }

    public function render()
    {
        $this->oView->render();
    }

    public function create($object)
    {
        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);


        if ($this->oModel->verificarFinalizado() || $this->oModel->verificarAprovado()) {
            if (!isset($object['localChamada'])) {
                $result['MSN'] = "Atenção";
                $result['msnErro'] = "<h1>Não disponivel inclusão</h1>";
                echo json_encode($result);
                die;
            }

        }

        $mesAno = explode("/", $object['mesAno']);

        $totalDiasMes = date("t", mktime(0, 0, 0, $mesAno[0], '01', $mesAno[1]));

        for ($i = 1; $i <= $totalDiasMes; $i++) {

            $this->oModel->transection();

            $object['data'] = $this->function->data_br_banco(str_pad($i, 2, 0, STR_PAD_LEFT) . '/' . $object['mesAno']);

            $this->oModel->populate($object);

            $result = $this->oModel->create();

            $this->oModel->commit();

        }

        /**
         * SE FOR UMA CHAMADA DE OUTRA CLASSE NÃO DEVE TER RETORNO
         */

        if (!isset($object['localChamada'])) {
            echo json_encode($result);
        }

    }

    public function importarDados($object)
    {
        $mesAnoAtual = $object['mesAno'];

        $mesAno = $this->function->buscarMesAnterior($object['mesAno']);

        $object['mesAno'] = $mesAno;

        $result = $this->getAllDataInterno($object);

        $result = $result['result'];

        unset($result['tempoCusto']);


        $dadosFiltrados = array();

        $tabela_comp_apli = '';

        foreach ($result as $valor) {

            $tabela = $valor['id_tabela'];
            $comp = $valor['id_tabela_complemento'];
            $apl = $valor['id_aplicacao'];

            $temp = $tabela . "_" . $comp . "_" . $apl;

            if ($tabela_comp_apli != $temp) {
                $dadosFiltrados[] = $valor;
            }

            $tabela_comp_apli = $temp;

        }

        $mesAno = explode("/", $mesAnoAtual);

        $totalDiasMes = date("t", mktime(0, 0, 0, $mesAno[0], '01', $mesAno[1]));

        foreach ($dadosFiltrados as $valor1) {

            for ($i = 1; $i <= $totalDiasMes; $i++) {

                $this->oModel->transection();

                $valor1['data'] = $this->function->data_br_banco(str_pad($i, 2, 0, STR_PAD_LEFT) . '/' . $mesAnoAtual);

                $this->oModel->populate($valor1);

                $result = $this->oModel->create();

                $this->oModel->commit();

            }
        }
        echo json_encode($result);
    }

    private function getAllDataInterno($object)
    {

        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        $result = $this->oModel->getAllData();
        $resultAlterado = [];
        $totais = [];
        $totaisMes = [];
        $totalGeral = 0;
        if ($result['count']) {
            foreach ($result['result'] as $linha) {

                $result['dadosFunc']['nome'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $result['dadosFunc']['centroCusto'] = $linha['centroCusto'] . ' ' . $linha['departamento'];

                $totalGeral += $linha['tempo'];

                $linha['nomeCusto'] = ($this->dadosTipoCusto($linha['id_tabela'], $linha['id_tabela_complemento'])) ? $this->dadosTipoCusto($linha['id_tabela'], $linha['id_tabela_complemento']) . " " . $linha['alias'] : "FOLGA";

                if (isset($totais[$linha['data']])) {
                    $totais[$linha['data']] += $linha['tempo'];

                } else {
                    $totais[$linha['data']] = $linha['tempo'];
                }

                if (isset($resultAlterado['tempoCusto'][$linha['nomeCusto']])) {
                    $resultAlterado['tempoCusto'][$linha['nomeCusto']] += $linha['tempo'];

                } else {
                    $resultAlterado['tempoCusto'][$linha['nomeCusto']] = $linha['tempo'];
                }

                $resultAlterado[] = $linha;
            }
        }
        $result['dadosFunc']['data'] = $object['mesAno'];
        $result['result'] = $resultAlterado;
        $result['totais']['totalDias'] = $totais;


        $result['totais']['totalGeral'] = $totalGeral;

        return $result;
    }

    public function dadosTipoCusto($tabela, $id)
    {
        $object['id'] = $id;
        $nome = '';

        if ($tabela == 1) {

            $oSubContrato = new SubContrato_Model();
            $oSubContrato->populate($object);
            $result = $oSubContrato->getJoinId();
            $nome = $result['result']['sub_contrato']."1 - ".$result['result']['nome_cliente'];

        } else if ($tabela == 2) {

            $oNumeroOrcamento = new NumeroOrcamento_Model();
            $oNumeroOrcamento->populate($object);
            $result = $oNumeroOrcamento->getJoinId();
            $nome = $result['result']['proposta'];
        } else if ($tabela == 3) {

            $oCentroCusto = new CentroCusto_Model();
            $oCentroCusto->populate($object);
            $result = $oCentroCusto->getById();
            $nome = $result['result']['centroCusto'];
        }

        return $nome;
    }

    public function getAllData($object)
    {

        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        $result = $this->oModel->getAllData();
        
        
        $resultAlterado = [];
        $totais = [];
        $totaisMes = [];
        $totalGeral = 0;
        if ($result['count']) {
            foreach ($result['result'] as $linha) {

                $result['dadosFunc']['nome'] = $linha['nome'] . ' ' . $linha['sobrenome'];
                $result['dadosFunc']['centroCusto'] = $linha['centroCusto'] . ' ' . $linha['departamento'];

                $totalGeral += $linha['tempo'];
                
                $linha['nomeCusto'] = ($this->dadosTipoCusto($linha['id_tabela'], $linha['id_tabela_complemento'])) ? $this->dadosTipoCusto($linha['id_tabela'], $linha['id_tabela_complemento']) . " " . $linha['alias'] : "FOLGA";

                if (isset($totais[$linha['data']])) {
                    $totais[$linha['data']] += $linha['tempo'];

                } else {
                    $totais[$linha['data']] = $linha['tempo'];
                }

                if (isset($resultAlterado['tempoCusto'][$linha['nomeCusto']])) {
                    $resultAlterado['tempoCusto'][$linha['nomeCusto']] += $linha['tempo'];

                } else {
                    $resultAlterado['tempoCusto'][$linha['nomeCusto']] = $linha['tempo'];
                }

                $resultAlterado[] = $linha;
            }
        }
        $result['dadosFunc']['data'] = $object['mesAno'];
        $result['result'] = $resultAlterado;
        $result['totais']['totalDias'] = $totais;


        $result['totais']['totalGeral'] = $totalGeral;
        
        echo json_encode($result);
    }

    public function update($object)
    {
//        print_r($object);
//        die;
//        if ($_SESSION['gesstor']['login']['id_area'] == $object["id_funcionario"]) {
        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        if ($this->oModel->verificarFinalizado() || $this->oModel->verificarAprovado()) {
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Não disponivel para alteração</h1>";
            echo json_encode($result);
            die;
        }

        if (is_numeric($object['tempo'])) {
            $object['id_motivo_ausencia'] = '';
        } else {

            $oMotivoAusencia = new MotivoAusencia_Model();

            $objectMotivoAusencia['ausencia'] = $object['tempo'];

            $oMotivoAusencia->populate($objectMotivoAusencia);

            $resultMotivoAusencia = $oMotivoAusencia->getByName();

            $object['tempo'] = 0;

            $object['id_motivo_ausencia'] = $resultMotivoAusencia['result']['id'];
        }
        $identificador = explode("_", $object['identificador']);

        $object['data'] = $identificador[0];
        $object['id_funcionario'] = $identificador[1];
        $object['id_tabela'] = $identificador[2];
        if ($identificador[2] == 4) {
            if ($object['tempo'] != 0) {
                $result['MSN'] = "Atenção";
                $result['msnErro'] = "<h1>Apenas GRs são aceitas neste campo</h1>";
                echo json_encode($result);
                die;
            }
        }
        $object['id_tabela_complemento'] = $identificador[3];
        $object['id_aplicacao'] = $identificador[4];

        $oSubContrato = new SubContrato_Model();
        $oSubContrato->populate($object);
        
        if($oSubContrato->verificarBloqueioHoras()){

            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Bloqueado para lançamento de Horas</h1>";
            echo json_encode($result);
            die;
         }

        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->update();

        $this->oModel->commit();
//        } else {
//
//            $result = [];
//            $result['MSN'] = "Atenção";
//            $result['msnErro'] = "<h1>Apenas o próprio funcionario pode finalizar</h1>";
//
//        }
        echo json_encode($result);
    }

    public function delete($object)
    {
        $this->oModel->transection();

        $this->oModel->populate($object);

        $result = $this->oModel->delete();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function deleteHoras($object)
    {


        $ids = explode('-', $object['idComp']);

        $ano = $ids[0];
        $mes = $ids[1];
        $dia = $ids[2];
        $id_funcionario = $ids[3];
        $id_tabela = $ids[4];
        $id_complemento = $ids[5];
        $id_aplicacao = $ids[6];

        $object['dataInicio'] = '01-' . $mes . '-' . $ano;
        $object['dataFim'] = '31-' . $mes . '-' . $ano;
        $object['id_funcionario'] = $id_funcionario;
        $object['id_tabela'] = $id_tabela;
        $object['id_tabela_complemento'] = $id_complemento;
        $object['id_aplicacao'] = $id_aplicacao;

        $this->oModel->transection();

        $this->oModel->populate($object);

        if ($this->oModel->verificarFinalizado() || $this->oModel->verificarAprovado()) {

            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Não disponivel para alteração</h1>";
            echo json_encode($result);
            die;
        }

        $result = $this->oModel->deleteHoras();

        $this->oModel->commit();

        echo json_encode($result);
    }

    public function getAll()
    {
        $result = $this->oModel->getAll();

        echo json_encode($result);
    }

    public function finalizar($object)
    {

//        if ($_SESSION['gesstor']['login']['id_area'] == $object["id_funcionario"]) {

        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        if ($this->oModel->verificarFinalizado() || $this->oModel->verificarAprovado()) {

            $result = [];
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Já Finalizado</h1>";
            echo json_encode($result);

            die;

        }
        $result = $this->oModel->finalizar();

//        } else {
//
//            $result = [];
//            $result['MSN'] = "Atenção";
//            $result['msnErro'] = "<h1>Apenas o próprio funcionario pode finalizar</h1>";
//
//        }


        echo json_encode($result);
    }

    public function situacaoHoras($object)
    {


        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        $result = $this->oModel->situacaoHoras();


        echo json_encode($result);
    }

    public function aprovar($object)
    {
        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        if (!$this->oModel->verificarFinalizado()) {

            $result = [];
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Ainda não finalizado</h1>";
            echo json_encode($result);

            die;

        }
        $object_custos = $object;

        $oFuncionarioCentroCusto = new FuncionarioCentroCusto();

        $oFuncionarioCentroCusto->populate($object_custos);

        /**
         * BUSCA TODOS OS CENTRO DE CUSTOS DO FUNCIONARIO
         */
        $result = $oFuncionarioCentroCusto->getCentroCustosFuncionario();

        $centroCustos = [];
        $centroCustoSql = '';

        if ($result['count']) {
            foreach ($result['result'] as $linha) {
                $centroCustos[] = $linha['id_centro_custo'];
            }

            $centroCustoSql = implode(',', $centroCustos);
        }

        $object_custos['ids_centro_custos'] = $centroCustoSql;

        $object_custos['id_funcionario'] = $_SESSION['gesstor']['login']['id_area'];

        $oFuncionarioCentroCusto->populate($object_custos);

        $result = $oFuncionarioCentroCusto->verificaGerenteCentroCusto();

        if ($result['count']) {

            $object['dataInicio'] = '01/' . $object['mesAno'];
            $object['dataFim'] = '31/' . $object['mesAno'];

            $this->oModel->populate($object);

            $result = $this->oModel->aprovar();


        } else {
            $result = [];
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Apenas o gerente de centro de custo tem essa permissão</h1>";
            echo json_encode($result);

            die;
        }

        echo json_encode($result);
    }

    public function cancelar($object)
    {
        $object['dataInicio'] = '01/' . $object['mesAno'];
        $object['dataFim'] = '31/' . $object['mesAno'];

        $this->oModel->populate($object);

        if ($this->oModel->verificarAprovado()) {

            $result = [];
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Já foi aprovada. Consultar IJ</h1>";
            echo json_encode($result);

            die;

        }

        $object_custos = $object;

        $oFuncionarioCentroCusto = new FuncionarioCentroCusto();

        $oFuncionarioCentroCusto->populate($object_custos);

        /**
         * BUSCA TODOS OS CENTRO DE CUSTOS DO FUNCIONARIO
         */
        $result = $oFuncionarioCentroCusto->getCentroCustosFuncionario();

        $centroCustos = [];
        $centroCustoSql = '';

        if ($result['count']) {

            foreach ($result['result'] as $linha) {
                $centroCustos[] = $linha['id_centro_custo'];
            }

            $centroCustoSql = implode(',', $centroCustos);
        }

        $object_custos['ids_centro_custos'] = $centroCustoSql;

        $object_custos['id_funcionario'] = $_SESSION['gesstor']['login']['id_area'];

        $oFuncionarioCentroCusto->populate($object_custos);

        $result = $oFuncionarioCentroCusto->verificaGerenteCentroCusto();

        if ($result['count']) {

            $object['dataInicio'] = '01/' . $object['mesAno'];
            $object['dataFim'] = '31/' . $object['mesAno'];

            $this->oModel->populate($object);

            $result = $this->oModel->cancelar();


        } else {
            $result = [];
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Apenas o gerente de centro de custo tem essa permissão</h1>";
            echo json_encode($result);

            die;
        }

        echo json_encode($result);
    }

    public function desaprovar($object)
    {
        $object_custos = $object;

        $oFuncionarioCentroCusto = new FuncionarioCentroCusto();

        $oFuncionarioCentroCusto->populate($object_custos);

        /**
         * BUSCA TODOS OS CENTRO DE CUSTOS DO FUNCIONARIO
         */
        $result = $oFuncionarioCentroCusto->getCentroCustosFuncionario();

        $centroCustos = [];
        $centroCustoSql = '';

        if ($result['count']) {
            foreach ($result['result'] as $linha) {
                $centroCustos[] = $linha['id_centro_custo'];
            }

            $centroCustoSql = implode(',', $centroCustos);
        }

        $object_custos['ids_centro_custos'] = $centroCustoSql;

        $object_custos['id_funcionario'] = $_SESSION['gesstor']['login']['id_area'];

        $oFuncionarioCentroCusto->populate($object_custos);

        $result = $oFuncionarioCentroCusto->verificaGerenteCentroCusto();

        if ($_SESSION['gesstor']['login']['id'] == 143) {

            $object['dataInicio'] = '01/' . $object['mesAno'];

            $object['dataFim'] = '31/' . $object['mesAno'];

            $this->oModel->populate($object);

            $result = $this->oModel->desaprovar();

        } else {
            $result = [];
            $result['MSN'] = "Atenção";
            $result['msnErro'] = "<h1>Apenas IJ essa permissão</h1>";
            echo json_encode($result);

            die;
        }

        echo json_encode($result);
    }

    public function getById($object)
    {

        $this->oModel->populate($object);

        $result = $this->oModel->getById();

        echo json_encode($result);
    }

    public function getLogin()
    {
        $result = $this->oModel->getLogin();

        return $result;
    }

    public function getLoginCliente()
    {
        $result = $this->oModel->getLoginCliente();

        return $result;
    }

    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}