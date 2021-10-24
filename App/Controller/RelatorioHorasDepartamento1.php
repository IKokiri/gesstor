<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'RelatorioHorasDepartamento.php';
require_once MODEL . DS . 'CustoHoraDepartamento.php';
require_once MODEL . DS . 'CentroCusto.php';
require_once VIEW . DS . 'RelatorioHorasDepartamento.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\CentroCusto;
use App\Model\CustoHoraDepartamento as CustoHoraDepartamento_Model;
use App\Model\CustoHoraDepartamento;
use App\Model\RelatorioHorasDepartamento as RelatorioHorasDepartamento_Model;
use App\Model\CentroCusto as CentroCusto_Model;
use App\View\RelatorioHorasDepartamento as RelatorioHorasDepartamento_View;
use phpDocumentor\Reflection\Types\Array_;

class RelatorioHorasDepartamento extends Controller
{

    private $oModel;
    private $oView;

    public function __construct()
    {
        parent::__construct();

        $this->oModel = new RelatorioHorasDepartamento_Model();

        $this->oView = new RelatorioHorasDepartamento_View();
    }

    public function render()
    {
        $this->oView->render();
    }


    public function getAll($object)
    {

        $this->oModel->populate($object);

        $subContrato = $this->oModel->getAllSubContrato();
        $proposta = $this->oModel->getAllProposta();
        $centroCusto = $this->oModel->getAllCentroCusto();

        $result['result'][0] = $subContrato['result'];
        $result['result'][1] = $proposta['result'];
        $result['result'][2] = $proposta['result'];

        $arrayDataResult = array();
        $arrayDados = array();
        $dadosTela = array();
        $arrayCentroCustos = array();
        $arrayTotalCentroCustos = array();
        $arrayCustosTela = array();
        $arrayCentroCustosKey = array();
        $dados = array();

        /**
         * JUNTA DIVISOES PROPOSTAS E CETRO CUSTOS EM UM UNICO ARRAY
         */
        if ($subContrato['count']) {
            foreach ($subContrato['result'] as $array) {
                $dados[] = $array;
                if (!in_array($array['departamento'], $arrayCentroCustos)) {
                    $arrayCentroCustos[] = $array['departamento'];
                }
                $arrayDataResult['data_inicio'] = $array['data_inicio'];
                $arrayDataResult['data_fim'] = $array['data_fim'];
            }

        }

        if ($proposta['count']) {
            foreach ($proposta['result'] as $array) {
                $dados[] = $array;
//                print_r($dados);
                if (!in_array($array['departamento'], $arrayCentroCustos)) {
                    $arrayCentroCustos[] = $array['departamento'];
                }
                $arrayDataResult['data_inicio'] = $array['data_inicio'];
                $arrayDataResult['data_fim'] = $array['data_fim'];
            }
        }

        if ($centroCusto['count']) {
            foreach ($centroCusto['result'] as $array) {
                $dados[] = $array;
                if (!in_array($array['departamento'], $arrayCentroCustos)) {
                    $arrayCentroCustos[] = $array['departamento'];
                }
                $arrayDataResult['data_inicio'] = $array['data_inicio'];
                $arrayDataResult['data_fim'] = $array['data_fim'];
            }
        }

        sort($arrayCentroCustos);
        $arrayCustosTela = $arrayCentroCustos;
        $arrayTotalCentroCustos = array_flip($arrayCentroCustos);
        $arrayCentroCustos = array_flip($arrayCentroCustos);

        foreach ($arrayCentroCustos as $key => $custo) {
            $arrayCentroCustosKey[$key] = 0;
        }
        foreach ($arrayTotalCentroCustos as $key => $custo) {
            $arrayTotalCentroCustos[$key] = 0;
        }

        foreach ($dados as $dado) {


            if (isset($arrayDados[$dado['numero']][$dado['departamento']]['tempo'])) {
                $arrayDados[$dado['numero']][$dado['departamento']]['tempo'] += $dado['tempo'];
                $arrayDados[$dado['numero']][$dado['departamento']]['numero'] = $dado['numero'];
            } else {
                $arrayDados[$dado['numero']][$dado['departamento']]['tempo'] = $dado['tempo'];
                $arrayDados[$dado['numero']][$dado['departamento']]['numero'] = $dado['numero'];
            }

            if (isset($arrayTotalCentroCustos[$dado['departamento']])) {


                $arrayTotalCentroCustos[$dado['departamento']] += $dado['tempo'];


            } else {
                $arrayTotalCentroCustos[$dado['departamento']] = $dado['tempo'];


            }

        }


        foreach ($arrayDados as $key => $value) {

            foreach ($value as $key1 => $v) {

                if (!isset($dadosTela[$key])) {

                    $dadosTela[$key] = $arrayCentroCustosKey;

                }

                $dadosTela[$key][$key1] = $v['tempo'];
            }

        }

        date_default_timezone_set('America/Sao_Paulo');
        $dataGerado = date('d/m/Y - h:i:s');
        $arrayDataResult['gerado'] = $dataGerado;
        $result['datas'] = $arrayDataResult;
        $result['centroCustos'] = $arrayCustosTela;
        $result['centroCustosTotais'] = $arrayTotalCentroCustos;
        $result['result'] = $dadosTela;
        $result['count'] = 1;
        echo json_encode($result);
    }

    public function getAllDepartamento($object)
    {

        /**
         * NA VIEW O USUARIO INDICA APENAS MES E ANO, NESSA AREA É ADICIONADO O DIA PARA QUE O SLQ FAÇA O INTERVALO DO
         * INICIO AO FIM DO MES
         */
        $object['data_inicio'] = '01/' . $object['data'];
        $object['data_fim'] = '31/' . $object['data'];
        /**
         * POPULO O OBJETO COM OS DADOS ENVIADOS PELO FIRMULARIO
         */
        if ($object['id_centro_custo'] == '36') {

            $object2 = $object;
            $object2['id_centro_custo'] = 32;
            $this->oModel->populate($object2);

        } else {

            $this->oModel->populate($object);

        }

//        $this->oModel->populate($object);
        $oCentroCusto = new CentroCusto_Model();

        $id_centro_custo['id'] = $object['id_centro_custo'];
        $oCentroCusto->populate($id_centro_custo);
        $centroCustoBusca = $oCentroCusto->getById();
        $numeroCentroCusto = $centroCustoBusca['result']['centroCusto'];
        $oCustoHoraDepartamento = new CustoHoraDepartamento_Model();

        $subContrato = $this->oModel->getAllSubContrato();
        $proposta = $this->oModel->getAllProposta();
        $centroCusto = $this->oModel->getAllCentroCusto();

        /**
         * BUSCA O CUSTO HORA DO DEPARTAMENTO SELECIONADO
         */
        $arrayCustoHora['data'] = $object['data_inicio'];
        $arrayCustoHora['id_centro_custo'] = $object['id_centro_custo'];
        $oCustoHoraDepartamento->populate($arrayCustoHora);
        $result = $custoHoraDepartamento = $oCustoHoraDepartamento->getByValor();
        $valorCustoHora = $result['result']['valor'];
        $totalCustoHora = 0;

        $result['result'][0] = $subContrato['result'];
        $result['result'][1] = $proposta['result'];
        $result['result'][2] = $proposta['result'];

        $arrayDataResult = array();
        $arrayDados = array();
        $dadosTela = array();
        $arrayCentroCustos = array();
        $arrayTotalCentroCustos = array();
        $arrayCustosTela = array();
        $arrayCentroCustosKey = array();
        $dados = array();

        /**
         * JUNTA DIVISOES PROPOSTAS E CETRO CUSTOS EM UM UNICO ARRAY
         */
        if ($subContrato['count']) {
            foreach ($subContrato['result'] as $array) {
                /**
                 * INDICA QUE SÃO ENTRADAS REFERENTES À CENTRO DE CUSTOS
                 */
                $array['tipo'] = 'SC';
                $dados[] = $array;
                if (!in_array($array['departamento'], $arrayCentroCustos)) {
                    $arrayCentroCustos[] = $array['departamento'];
                }
                $arrayDataResult['data_inicio'] = $array['data_inicio'];
                $arrayDataResult['data_fim'] = $array['data_fim'];
            }

        }

        if ($proposta['count']) {
            foreach ($proposta['result'] as $array) {
                /**
                 * INDICA QUE SÃO ENTRADAS REFERENTES À CENTRO DE CUSTOS
                 */
                $array['tipo'] = 'PP';
                $dados[] = $array;
                if (!in_array($array['departamento'], $arrayCentroCustos)) {
                    $arrayCentroCustos[] = $array['departamento'];
                }
                $arrayDataResult['data_inicio'] = $array['data_inicio'];
                $arrayDataResult['data_fim'] = $array['data_fim'];
            }
        }


        if ($centroCusto['count']) {
            foreach ($centroCusto['result'] as $array) {
                /**
                 * INDICA QUE SÃO ENTRADAS REFERENTES À CENTRO DE CUSTOS
                 */
                $array['tipo'] = 'CC';
                $dados[] = $array;
                if (!in_array($array['departamento'], $arrayCentroCustos)) {
                    $arrayCentroCustos[] = $array['departamento'];
                }
                $arrayDataResult['data_inicio'] = $array['data_inicio'];
                $arrayDataResult['data_fim'] = $array['data_fim'];
            }
        }

        $arrayCustosTela = $arrayCentroCustos;
        $arrayTotalCentroCustos = array_flip($arrayCentroCustos);
        $arrayCentroCustos = array_flip($arrayCentroCustos);

        foreach ($arrayCentroCustos as $key => $custo) {
            $arrayCentroCustosKey[$key] = 0;
        }
        foreach ($arrayTotalCentroCustos as $key => $custo) {
            $arrayTotalCentroCustos[$key] = 0;
        }

        foreach ($dados as $dado) {

            if (isset($arrayDados[$dado['numero']][$dado['departamento']]['tempo'])) {
                $arrayDados[$dado['numero']][$dado['departamento']]['tempo'] += $dado['tempo'];
                $arrayDados[$dado['numero']][$dado['departamento']]['numero'] = $dado['numero'];
                $arrayDados[$dado['numero']][$dado['departamento']]['centroCusto'] = $dado['centroCusto'];
                $arrayDados[$dado['numero']][$dado['departamento']]['tipo'] = $dado['tipo'];

                if ($object['id_centro_custo'] == '36') {
                    $arrayDados[$dado['numero']][$dado['departamento']]['valorAjuste'] = $dado['valor4003'];
                } else {
                    $arrayDados[$dado['numero']][$dado['departamento']]['valorAjuste'] = $dado['valor'];
                }


                if ($dado['tipo'] == "CC") {
                    $arrayDados[$dado['numero']][$dado['departamento']]['numeroCentroCusto'] = $dado['numeroCentroCusto'];
                }
            } else {
                $arrayDados[$dado['numero']][$dado['departamento']]['tempo'] = $dado['tempo'];
                $arrayDados[$dado['numero']][$dado['departamento']]['numero'] = $dado['numero'];
                $arrayDados[$dado['numero']][$dado['departamento']]['centroCusto'] = $dado['centroCusto'];
                $arrayDados[$dado['numero']][$dado['departamento']]['tipo'] = $dado['tipo'];
                if ($object['id_centro_custo'] == '36') {
                    $arrayDados[$dado['numero']][$dado['departamento']]['valorAjuste'] = $dado['valor4003'];
                } else {

                    $arrayDados[$dado['numero']][$dado['departamento']]['valorAjuste'] = $dado['valor'];
                }

                if ($dado['tipo'] == "CC") {
                    $arrayDados[$dado['numero']][$dado['departamento']]['numeroCentroCusto'] = $dado['numeroCentroCusto'];
                }
            }

            if (isset($arrayTotalCentroCustos[$dado['departamento']])) {

                $arrayTotalCentroCustos[$dado['departamento']] += $dado['tempo'];


            } else {

                $arrayTotalCentroCustos[$dado['departamento']] = $dado['tempo'];

            }

        }


        foreach ($arrayDados as $key => $value) {

            foreach ($value as $key1 => $v) {

                if (!isset($dadosTela[$key])) {

                    $dadosTela[$key] = $arrayCentroCustosKey;

                }

                $dadosTela[$key][$key1] = $v['tempo'];

                $dadosTela[$key]['valor'] = round($v['tempo'] * $valorCustoHora, 2) + $v['valorAjuste'];

                /**
                 * CENTRO DE CUSTO NÃO É MAIS SOMADO
                 */
                if ($v['tipo'] == "CC") {
                    continue;
                }

                if ($v['tipo'] == "CC" && $v['numeroCentroCusto'] > $numeroCentroCusto || $v['tipo'] != "CC") {


                    $totalCustoHora += $dadosTela[$key]['valor'];

                }

            }

        }


        $resultTela = array();

        foreach ($dadosTela as $key => $value) {
            $value['valor'] = number_format($value['valor'], 2, ',', '.');
            $resultTela[$key] = $value;
        }

        $dadosTela = $resultTela;

        $arrayCustosTela[] = 'CUSTO HORA <br><strong> ' . number_format($valorCustoHora, 2, ',', '.') . '</strong>';
        $arrayTotalCentroCustos['VALOR'] = "R$ " . number_format($totalCustoHora, 2, ',', '.');

        date_default_timezone_set('America/Sao_Paulo');
        $dataGerado = date('d/m/Y - h:i:s');
        $arrayDataResult['gerado'] = $dataGerado;
        $result['datas'] = $arrayDataResult;

        if ($object['id_centro_custo'] == '36') {
            $arrayCustosTela[0] = "4003<br>MANUT";
        }

        $result['centroCustos'] = $arrayCustosTela;
        $result['centroCustosTotais'] = $arrayTotalCentroCustos;
        $result['result'] = $dadosTela;

        $result['count'] = 1;
        echo json_encode($result);
    }


    public function getContratosApuracao($object)
    {
        /**
         * NA VIEW O USUARIO INDICA APENAS MES E ANO, NESSA AREA É ADICIONADO O DIA PARA QUE O SLQ FAÇA O INTERVALO DO
         * INICIO AO FIM DO MES
         */
        $object['data_inicio'] = $object['inicio'];
        $object['data_fim'] = $object['fim'];

        $this->oModel->populate($object);

        /**
         * BUSCA TODOS OS SUB CONTRATOS NO INTERVALO DETERMINADO DE DATAS
         */
        if($object['tipo'] == 2){
            $subContrato = $this->oModel->getAllProposta();
        }else{
            $subContrato = $this->oModel->getAllContrato();
        }
        
        
        $result = $subContrato['result'];
        $cabecalho = array();
        $horas = array();
        $meses = array();
        $grid = array();
        $corpo = array();
        $custosDados = array();

        $resultTemp4003 = array();

        /**
         * ALTERAÇÃO PARA QUE AS HORAS DO 4053 COPIE PARA O 4003
         */
        foreach ($result as $value) {
//            print_r($value);
            $resultTemp4003[] = $value;
            /*
             * id do centro de custo 4053
             */
            if ($value['id_centro_custo'] == 32) {
                /**
                 * BUSCA O ID DO 4003
                 */
                $oCentroCusto = new CentroCusto_Model();
                $objTemp['centro_custo'] = '4003';
                $oCentroCusto->populate($objTemp);
                $resultado = $oCentroCusto->buscarId();
                $id = $resultado['result']['id'];
                $departamento = $resultado['result']['departamento'];
                $centroCusto = $resultado['result']['centroCusto'];

                $arrayTemp = $value;

                $arrayTemp['id_centro_custo'] = $id;
                $arrayTemp['centroCusto'] = $centroCusto;
                $arrayTemp['departamento'] = $centroCusto . "<br>" . $departamento;

                $resultTemp4003[] = $arrayTemp;

            }


        }

        $result = $resultTemp4003;
//        print_r($resultTemp4003);
        $arrayTotais = Array();
        $oCustoHoraDepartamento = new CustoHoraDepartamento_Model();
        $oCustoHoraDepartamento->populate($object);
        $custos = $oCustoHoraDepartamento->getByData();
        $custos = $custos['result'];
        foreach ($custos as $value) {
            $custosDados[$value['id_centro_custo'] . '_' . $value['data']] = $value;
        }

        /**
         * VALORES REFERENTE AOS AJUSTES TABELA QUE A CHAVE É O CENTRO CUSTO + MES_ANO + ID_TABELA _ID_TABELA_COMPLEMENTO
         */
        $arrayAjustes = Array();

//        print_r($result);
        foreach ($result as $value) {
//            print_r($value);
            $mesAno = $this->function->ano_mes_dia_to_mes_ano($value['data']);


            $mesAnoN = $value['id_centro_custo'] . '_' . $this->function->ano_mes_dia_to_mes_ano_n($value['data']);


            if (!in_array($mesAno, $cabecalho)) {
                $cabecalho[] = $mesAno;

            }

            if (!isset($horas[$value['numero'] . $mesAno])) {

                $horas[$value['numero'] . $mesAno]['tempo'] = round($value['tempo'] * $custosDados[$mesAnoN]['valor'], 2);
                /**
                 * HORAS REFERENTE A0 4003 NAO DEVEM SER SOMADAS
                 */
                if ($value['centroCusto'] != "4003") {

                    $horas[$value['numero'] . $mesAno]['tempoH'] = $value['tempo'];
                }
                $horas[$value['numero'] . $mesAno]['tempoBr'] = number_format($horas[$value['numero'] . $mesAno]['tempo'], 2, ',', '.');
                $horas[$value['numero'] . $mesAno]['mesAno'] = $mesAno;
                $horas[$value['numero'] . $mesAno]['numero'] = $value['numero'];


            } else {

                $horas[$value['numero'] . $mesAno]['tempo'] += round($value['tempo'] * $custosDados[$mesAnoN]['valor'], 2);
                /**
                 * HORAS REFERENTE A0 4003 NAO DEVEM SER SOMADAS
                 */
                if ($value['centroCusto'] != "4003") {

                    $horas[$value['numero'] . $mesAno]['tempoH'] += $value['tempo'];
                }

                $horas[$value['numero'] . $mesAno]['tempoBr'] = number_format($horas[$value['numero'] . $mesAno]['tempo'], 2, ',', '.');
                $horas[$value['numero'] . $mesAno]['mesAno'] = $mesAno;
                $horas[$value['numero'] . $mesAno]['numero'] = $value['numero'];


            }
            $arrayAjustes[$value['id_tabela'] . '_' . $value['id_tabela_complemento'] . '_' . $value['centroCusto'] . $value['$mesAno']]['ajuste'] = ($value['ajuste']) ? $value['ajuste'] : $value['ajuste4003'];
            $arrayAjustes[$value['id_tabela'] . '_' . $value['id_tabela_complemento'] . '_' . $value['centroCusto'] . $value['$mesAno']]['numero'] = $value['numero'];
        }
        /**
         * Array que acumula os ajustes que devem ser feitos em cada contrato
         */
        $ajusteContratos = Array();
        $ii = 0;
        foreach ($arrayAjustes as $ajustes) {
            if (isset($ajusteContratos[$ajustes['numero']])) {
                $ajusteContratos[$ajustes['numero']] += ($ajustes['ajuste']);
            } else {
                $ajusteContratos[$ajustes['numero']] = $ajustes['ajuste'];
            }


        }

        $meses = array_flip($cabecalho);

        $meses = $this->function->limparValoresArray($meses);

//        $acumulado = 0;

        $arrayTotais = $meses;
        $arrayTotais['acumulado'] = "";

//        print_r($arrayTotais);

        foreach ($horas as $value) {
            $value['tempo'] += $ajusteContratos[$value['numero']];
            $value['tempoBr'] = number_format($value['tempo'], 2, ',', '.');

            if (!isset($grid[$value['numero']])) {

                $grid[$value['numero']]['meses'] = $meses;

                $acumulado = 0;

            }

            $grid[$value['numero']]['meses'][$value['mesAno']] = number_format($value['tempoH'], 1, ',', '.') . '_' . $value['tempoBr'];
            $grid[$value['numero']]['meses']['acumuladoEN'] += $value['tempo'];
            $grid[$value['numero']]['meses']['tempoH'] += $value['tempoH'];
            $grid[$value['numero']]['meses']['acumulado'] = number_format($grid[$value['numero']]['meses']['tempoH'], 2, ',', '.') . '_' . number_format($grid[$value['numero']]['meses']['acumuladoEN'], 2, ',', '.');

        }


        $colunas = Array();

        foreach ($grid as $key => $value) {

            unset($grid[$key]['meses']['acumuladoEN']);
            unset($grid[$key]['meses']['tempoH']);
            $colunas[] = $grid[$key]['meses'];

        }

        $totaisColunas = Array();

//        print_r($colunas);

        $i = 0;

        foreach ($colunas as $key => $value) {

            foreach ($value as $key1 => $value1) {

                $valor = explode('_', $value1);
                $valor[0] = str_replace(',', '.', str_replace('.', '', $valor[0]));
                $valor[1] = str_replace(',', '.', str_replace('.', '', $valor[1]));

                if (!isset($totaisColunas[$i])) {

                    $totaisColunas[$i] = $valor[0];
                } else {

                    $totaisColunas[$i] += $valor[0];
                }


                $i++;

                if (!isset($totaisColunas[$i])) {

                    $totaisColunas[$i] = $valor[1];
                } else {

                    $totaisColunas[$i] += $valor[1];
                }

                $i++;
            }

            $i = 0;

        }

        $tempoTotais = array();

        foreach ($totaisColunas as $value) {
            $tempoTotais[] = number_format($value, 2, ',', '.');
        }

        $cabecalho[] = "Acumulado";

        $resultFinal['totalRodape'] = $tempoTotais;

        $resultFinal['cabecalho'] = $cabecalho;
        $resultFinal['grid'] = $grid;

        echo json_encode($resultFinal);

    }


    public function getSubContratoContrato($object)
    {


        $this->oModel->populate($object);

        $result = $this->oModel->getSubContratoContrato();
//        print_r($result);
        $grid = array();
        $footer = array();

        $oCentroCusto = new CentroCusto_Model();
        $objTemp['centro_custo'] = '4003';
        $oCentroCusto->populate($objTemp);
        $resultado = $oCentroCusto->buscarId();
        $id4003 = $resultado['result']['id'];

        $oCustoHoraDepartamento = new CustoHoraDepartamento_Model();

        foreach ($result['result'] as $value) {

            if ($value['centroCusto'] == '4053') {

                $objectCusto['id_centro_custo'] = 36;

                $dataTemp = explode("-", $value['data']);

                $value['data'] = '01-' . $dataTemp[1] . '-' . $dataTemp[0];

                $objectCusto['data'] = $value['data'];

                $oCustoHoraDepartamento->populate($objectCusto);

                $valor = $oCustoHoraDepartamento->getByValor();

                $valorTemp = $value;
                $valorTemp['centroCusto'] = '4003';
                $valorTemp['divisao'] = $value['divisao'];
                $valorTemp['tempo'] = 0;
                $valorTemp['data'] = $value['data'];
                $valorTemp['valor'] = $valor['result']['valor'];
                $valorTemp['id_centro_custo'] = 36;
                $valorTemp['total'] = $valorTemp['valor'] * $value['tempo'];
                $valorTemp['contrato'] = $value['contrato'];
                $valorTemp['sub_contrato'] = $value['sub_contrato'];

                $result['result'][] = $valorTemp;
            }

        }

        foreach ($result['result'] as $value) {


            if (!isset($grid[$value['sub_contrato']]['tempo'])) {

                $grid[$value['sub_contrato']]['tempo'] = $value['tempo'];

            } else {

                $grid[$value['sub_contrato']]['tempo'] += $value['tempo'];

            }

            if (!isset($grid[$value['sub_contrato']]['valor'])) {

                $grid[$value['sub_contrato']]['valor'] = $value['valor'];

            } else {

                $grid[$value['sub_contrato']]['valor'] += $value['valor'];

            }

            if (!isset($grid[$value['sub_contrato']]['total'])) {

                $grid[$value['sub_contrato']]['total'] = $value['total'];

            } else {

                $grid[$value['sub_contrato']]['total'] += $value['total'];

            }


            if (!isset($footer['tempo'])) {

                $footer['tempo'] = $value['tempo'];

            } else {

                $footer['tempo'] += $value['tempo'];

            }

            if (!isset($footer['valor'])) {

                $footer['valor'] = $value['valor'];

            } else {

                $footer['valor'] += $value['valor'];

            }

            if (!isset($footer['total'])) {

                $footer['total'] = $value['total'];

            } else {

                $footer['total'] += $value['total'];

            }


        }

        foreach ($grid as $key => $value) {


            $value['tempo'] = number_format($value['tempo'], 1, ',', '.');
            $value['valor'] = number_format($value['valor'], 2, ',', '.');
            $value['total'] = number_format($value['total'], 2, ',', '.');

            $grid[$key] = $value;

        }


        $footer['tempo'] = number_format($footer['tempo'], 1, ',', '.');
        $footer['valor'] = number_format($footer['valor'], 2, ',', '.');
        $footer['total'] = number_format($footer['total'], 2, ',', '.');


//        print_r($grid);


        $result['grid'] = $grid;
        $result['footer'][0] = $footer;

//        print_r($result);
        echo json_encode($result);
    }


    public function getContratosDetalhado($object)
    {

        echo json_encode($resultFinal);

    }


    public function populate($object)
    {
        $this->oModel->populate($object);
    }


}








































































