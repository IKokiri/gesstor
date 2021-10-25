<?php

namespace App\Controller;

require_once CORE . DS . 'Controller.php';
require_once MODEL . DS . 'RelatorioHorasDepartamento.php';
require_once MODEL . DS . 'CustoHoraDepartamento.php';
require_once MODEL . DS . 'CentroCusto.php';
require_once MODEL . DS . 'NumeroOrcamento.php';
require_once MODEL . DS . 'SubContrato.php';
require_once MODEL . DS . 'AjusteCustos.php';
require_once MODEL . DS . 'AjusteHoras.php';
require_once VIEW . DS . 'RelatorioHorasDepartamento.php';

use App\Core\Controller;
use App\Core\Model;
use App\Model\CentroCusto;
use App\Model\NumeroOrcamento;
use App\Model\SubContrato;
use App\Model\CustoHoraDepartamento as CustoHoraDepartamento_Model;
use App\Model\CustoHoraDepartamento;
use App\Model\RelatorioHorasDepartamento as RelatorioHorasDepartamento_Model;
use App\Model\CentroCusto as CentroCusto_Model;
use App\Model\AjusteCustos as AjusteCustos_Model;
use App\Model\AjusteHoras as AjusteHoras_Model;
use App\View\RelatorioHorasDepartamento as RelatorioHorasDepartamento_View;
use phpDocumentor\Reflection\Types\Array_;

class RelatorioHorasDepartamento extends Controller
{

    private $oModel;
    private $oView;

    private $resultSubContrato;
    private $resultProposta;
    private $resultCentroCusto;
    private $ajustesCustos;
    private $ajustesHoras;

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

        /**
         * FAZ A BUSCA DE CONTRATOS CENTRO CUSTOS E PROPOSTAS
         * SE EXISTIR ALGUM RESULTADO APENAS AS LINHAS DAS TABELA SÃO COPIADAS
         * O STATUS É IGNORADO A CHAVE DE CADA UM DOS ARRAY É O ID DA TABELA DE CADA UM DELES
         */
        private function carregarComplementos(){
      
            $oSubContratos = new SubContrato();
            $result = $oSubContratos->getAllRelatorio();
            $this->resultSubContrato = $result['result'];

            $oPropostas = new NumeroOrcamento();
            $result = $oPropostas->getAllRelatorio();
            $this->resultProposta =  $result['result'];
        
            $oCentroCustos = new CentroCusto();
            $result = $oCentroCustos->getAllRelatorio();
            $this->resultCentroCusto =  $result['result'];
        }
        /**
         * DE ACORDO COM A TABELA A SER PESQUISADA RETORNA TODOS OS DADOS DA PROPOSTA SUB 
         * CONTRATO OU CENTRO DE CUSTO
         */
        private function retornarComplemento($id_tabela,$id_complemento){
    
            $resultado = '';
    
            if($id_tabela == 1){
                
                $resultado = $this->resultSubContrato[$id_complemento];
    
            }else if($id_tabela == 2){
    
                $resultado = $this->resultProposta[$id_complemento];
    
            }else if($id_tabela == 3){
    
                $resultado = $this->resultCentroCusto[$id_complemento];
    
            }
            
            return $resultado;
    
        }
        /**
         * ORGANIZA ARRAY DE ACORDO COM OS CAMPOS ENVIADOS
         */
        private function organizarTabela($array,$pri,$seg,$ter){
                
            $aPri = array();
            $aSeg = array();
            $aTer = array();

            foreach($array as $a){
                
                if($a['id_tabela'] == $pri){
                    $aPri[] = $a;
                }else if($a['id_tabela'] == $seg){
                    $aSeg[] = $a;
                }else if($a['id_tabela'] == $ter){
                    $aTer[] = $a;
                }

            }

            return $result = $aPri + $aSeg + $aTer;
        }

        public function carregarAjustesCustos($object){

            $oAjusteCustos = new AjusteCustos_Model();

            $oAjusteCustos->populate($object);

            $result = $oAjusteCustos->getAllDetalhado();

            $result = $result['result'];

            foreach($result as $value){
                
                $key = $value['id_tabela'].'_'.$value['id_tabela_complemento'].'_'.$value['id_centro_custo'].'_'.$value['mes'].'_'.$value['ano'];
                
                $this->ajustesCustos[$key] = $value;
            }
        }

        public function carregarAjustesHoras($object){
            
        
            $oAjusteHoras = new AjusteHoras_Model();

            $oAjusteHoras->populate($object);

            $result = $oAjusteHoras->getAllDetalhado();

            $result = $result['result'];
            
            foreach($result as $value){
                
                $key = $value['id_tabela'].'_'.$value['id_tabela_complemento'].'_'.$value['id_centro_custo'].'_'.$value['mes'].'_'.$value['ano'];
                
                $this->ajustesHoras[$key] = $value;
            }

            
        
        }

    public function horasFuncionarios($object)
    {
        /**
         * NA VIEW O USUARIO INDICA APENAS MES E ANO, NESSA AREA É ADICIONADO O DIA PARA QUE O SLQ FAÇA O INTERVALO DO
         * INICIO AO FIM DO MES
         */
        if($object['data_inicio'] && $object['data_fim']){
            $object['dataInicio'] =  $object['data_inicio'];
            $object['dataFim'] =  $object['data_fim'];
        }

        if($object['id_contrato']){

            $oSubContrato  = new SubContrato();
            $oSubContrato->populate($object);
            $result = $oSubContrato->getSubContratosContrato();
            
            $inContrato = "";
    
            foreach ($result['result'] as $l){
                $inContrato .= $l['id'].",";    
            }
            $inContrato = substr($inContrato,0,-1);
            $object['inContrato'] = $inContrato;
        }
        

        $this->oModel->populate($object);
        /**
         * FAZ A BUSCA DE TODAS AS HORAS DO BANCO DE DADOS QUE SASTISFAZEM AS RESTRIÇOES
         */
        $result = $this->oModel->getAllHoras();

        
        
        $resultHoras = $result['result'];
        
        //     $total = 0;
        // foreach($resultHoras as $value){
        //     $total += ($value['tempo']*$value['valor']);
            
        // }
        // echo $total;
        /**
         * CARREGA TODOS OS CONTRATOS PROPOSTAS E CENTRO CUSTOS COM SUAS INFORMAÇÕES E ARMAZENA EM MEMORIA
         */
        $this->carregarComplementos();

        /**
         * ARRAY ONDE SERÁ DEFINIDA AS HORAS
         */
        $alocarHoras = array();
        /**
         * FAZ A SEPARAÇÃO POR TIPO COLOCANDO TODOS OS REGISTROS DE SUBCONTRATOS DENTRO DE UM ARRAY
         * TODOS OS REGISTROS DE PROPOSTAS DENTRO DE OUTRO ARRAY
         * TODOS OS REGISTROS DE CENTRO CUSTOS DENTRO DE OUTRO ARRAY
         */

        foreach($resultHoras as $key => $horas){
            
            /**
             * RESPONSÁVEL POR MONTAR O INDICE DO ARRAY
             */
            $id_tabela = $horas['id_tabela'];
            $id_tabela_complemento = $horas['id_tabela_complemento'];
            $id_aplicacao = $horas['id_aplicacao'];

            /**
             * RESGATA A INFORMAÇÃO REFERENTE AO ID DA TABELA E ID COMPLEMENTO
             * BUSCA A INFORMAÇÃO DE UM E APENAS UM DADO REFERENTE A CONTRATO, PROPOSTA OU CENTRO DE CUSTO
             */
            $complemento = $this->retornarComplemento($id_tabela,$id_tabela_complemento);

            /**
             * ADICIONA JUNTO A CADA LANÇAMENTO DE HORAS OS DADOS DO COMPLEMENTO
             */
           $horas['dadosComplemento'] = $complemento;
           

            $chave = $id_tabela.'_'.$id_tabela_complemento.'_'.$id_aplicacao;

            $alocarHoras[$chave][] = $horas;
            
            
        }
        
        // $total = 0;
        // foreach($alocarHoras as $value){
        //     foreach($value as $value1){
                
        //         $total += $value1['valor']*$value1['tempo'];

        //     }
        // }

        // echo $total;
        
       return $alocarHoras;

    }

    /**
     * RETORNA OS AJUSTES DE CUSTOS E HORAS
     */
    function ajustes($object){
        
     /**
         * ADICIONA NA MEMÓRIA OS CUSTOS
         */
        $ajusteCustos = $this->carregarAjustesCustos($object);
        
          /**
         * ADICIONA NA MEMÓRIA OS AJUSTES DE HORAS
         */
        $ajusteHoras = $this->carregarAjustesHoras($object);

        
         /**
         * UNINDO OS AJUSTES DE HORAS E CUSTOS
         */
       $arrayAjustesHC = array();

        

       foreach($this->ajustesCustos as $value){
            // print_r($value);
        $tempTabela = $value['id_tabela'];
        $tempTabelaComplemento = $value['id_tabela_complemento'];
        
        $tempComp = $this->retornarComplemento($tempTabela,$tempTabelaComplemento);
           
        $aliasAjusteHC = $tempComp['alias']."_".$value['id_centro_custo']."_".$value['mes']."_".$value['ano'];

        $arrayAjustesHC[$aliasAjusteHC]['nome'] = 'Ajuste';
        $arrayAjustesHC[$aliasAjusteHC]['sobrenome'] = 'Custo';
        $arrayAjustesHC[$aliasAjusteHC]['valor'] = 0;
        $arrayAjustesHC[$aliasAjusteHC]['tipo'] = '';
        $arrayAjustesHC[$aliasAjusteHC]['ajuste'] = $value['valor'];
        $arrayAjustesHC[$aliasAjusteHC]['id_tabela'] = $value['id_tabela'];
        $arrayAjustesHC[$aliasAjusteHC]['id_tabela_complemento'] = $value['id_tabela_complemento'];
        $arrayAjustesHC[$aliasAjusteHC]['ajusteH'] = 0;
        $arrayAjustesHC[$aliasAjusteHC]['centroCustoCompleto'] = $this->retornarComplemento(3,$value['id_centro_custo']);
        $arrayAjustesHC[$aliasAjusteHC]['dadosCompleto'] = $this->retornarComplemento($value['id_tabela'],$value['id_tabela_complemento']);
        $arrayAjustesHC[$aliasAjusteHC]['centroCusto'] = $arrayAjustesHC[$aliasAjusteHC]['centroCustoCompleto']['departamento'];
        $arrayAjustesHC[$aliasAjusteHC]['tempo'] = 0;
        $arrayAjustesHC[$aliasAjusteHC]['totalLinha'] = '';
        $arrayAjustesHC[$aliasAjusteHC]['alias'] = $aliasAjusteHC;
        
        
       }
       

       foreach($this->ajustesHoras as $value){
            
        $tempTabela = $value['id_tabela'];
        $tempTabelaComplemento = $value['id_tabela_complemento'];
        
        $tempComp = $this->retornarComplemento($tempTabela,$tempTabelaComplemento);
           
        $aliasAjusteHC = $tempComp['alias']."_".$value['mes']."_".$value['ano'];

        $arrayAjustesHC[$aliasAjusteHC]['nome'] = 'Ajuste';
        $arrayAjustesHC[$aliasAjusteHC]['sobrenome'] = 'Hora';
        $arrayAjustesHC[$aliasAjusteHC]['valor'] = 0;
        $arrayAjustesHC[$aliasAjusteHC]['tipo'] = '';
        $arrayAjustesHC[$aliasAjusteHC]['ajuste'] = 0;
        $arrayAjustesHC[$aliasAjusteHC]['ajusteH'] = $value['tempo'];
        $arrayAjustesHC[$aliasAjusteHC]['id_tabela'] = $value['id_tabela'];
        $arrayAjustesHC[$aliasAjusteHC]['id_tabela_complemento'] = $value['id_tabela_complemento'];
        $arrayAjustesHC[$aliasAjusteHC]['centroCustoCompleto'] = $this->retornarComplemento(3,$value['id_centro_custo']);
        $arrayAjustesHC[$aliasAjusteHC]['dadosCompleto'] = $this->retornarComplemento($value['id_tabela'],$value['id_tabela_complemento']);
        $arrayAjustesHC[$aliasAjusteHC]['centroCusto'] = $arrayAjustesHC[$aliasAjusteHC]['centroCustoCompleto']['departamento'];
        $arrayAjustesHC[$aliasAjusteHC]['tempo'] = 0;
        $arrayAjustesHC[$aliasAjusteHC]['totalLinha'] = '';
        $arrayAjustesHC[$aliasAjusteHC]['alias'] = $aliasAjusteHC;
        
        
       }
        
        return $arrayAjustesHC;

    }

    function apuracaoHorasTrabalhadas($object){

        date_default_timezone_set('America/Sao_Paulo');

        $result = $this->horasFuncionarios($object);

        /**
         * DADOS PARA ADICIONAR NA TABELA PARA IMPRESSÃO
         */
        $dadosAdicionais['data_inicio'] = $object['data_inicio'];
        $dadosAdicionais['data_fim'] = $object['data_fim'];
        $dadosAdicionais['data_solicitacao'] = "Emitido EM ".date('d/m/Y H:i:s');

        /**
         * ARRAY DE RETORNO PARA USUARIO
         */
        $arrayTela = array();
        /**
         * GUARDA O ACUMULADO DE HORAS TOTAIS POR FUNCIONÁRIO
         */
        $arrayHoras = array();
        /**
         * GUARDA O TOTAL DA SOMA DE HORAS
         */ 
        $arrayTotal = array();

        // $arrayTotal['label'] = 'TOTAL';
        // $arrayTotal['label'] = 'TOTAL';

        $arrayTotal['funcionario'] = '';
        $arrayTotal['tempo'] = 0;
        $arrayTotal['valor'] = 0;
        
       

        $arrayAjustesHC = $this->ajustes($object);

        foreach($result as $value){

    
            foreach($value as $value1){

                $alias = $value1['dadosComplemento']['alias']."_".$value1['id_funcionario']."_".$value1['data_mes']."_".$value1['data_ano']."_".$value1['departamento'];
                // $alias = $value1['dadosComplemento']['alias']."_".$value1['alias']."_".$value1['id_funcionario']."_".$value1['data_mes']."_".$value1['data_ano'];
                $aliasAjuste = $value1['id_tabela'].'_'.$value1['id_tabela_complemento'].'_'.$value1['id_centro_custo'].'_'.$value1['data_mes'].'_'.$value1['data_ano'];
                

                if(isset($arrayHoras[$alias])){

                    $arrayHoras[$alias]['tempo'] += $value1['tempo'];

                }else{

                    $arrayHoras[$alias]['nome'] = $value1['nome'];
                    $arrayHoras[$alias]['sobrenome'] = $value1['sobrenome'];
                    $arrayHoras[$alias]['valor'] = $value1['valor'];
                    $arrayHoras[$alias]['tipo'] = $value1['tipo'];
                    // $arrayHoras[$alias]['ajuste'] = $this->ajustesCustos[$aliasAjuste];
                    // $arrayHoras[$alias]['ajusteH'] = $this->ajustesHoras[$aliasAjuste];
                    $arrayHoras[$alias]['centroCusto'] = $value1['centroCusto'];
                    $arrayHoras[$alias]['tempo'] = $value1['tempo'];
                    $arrayHoras[$alias]['totalLinha'] = 0;
                    $arrayHoras[$alias]['alias'] = $value1['dadosComplemento']['alias']." " . $value1['data_mes']."/".$value1['data_ano'];
                    
                }
               
                $arrayHoras[$alias]['totalLinha'] += $value1['valor'] * $value1['tempo'];

            }

        }
        
        $arrayHoras = array_merge($arrayHoras,$arrayAjustesHC);

        
        
        foreach($arrayHoras as $value){

            $arrayTotal['valor'] += $value['valor'] * $value['tempo'];

            $arrayTotal['tempo'] += $value['tempo'];

        }

        // $arrayTotal['valor'] = round($arrayTotal['valor'],2);

        // echo $total;
        
        /**
         * ADICIONA O RODAPE COM OS TOTAIS
         */
        $arrayTela['totais'] = $arrayTotal;
        $arrayTela['dados'] = $arrayHoras;
        $arrayTela['dadosAdicionais'] = $dadosAdicionais;
        // $arrayTela['dados'] = $this->organizarCPC($arrayHoras);

        echo json_encode($arrayTela);

    }

    function apuracaoDepartamento($object){

        date_default_timezone_set('America/Sao_Paulo');

        $result = $this->horasFuncionarios($object);

        /**
         * DADOS PARA ADICIONAR NA TABELA PARA IMPRESSÃO
         */
        $dadosAdicionais['data_inicio'] = $object['data_inicio'];
        $dadosAdicionais['data_fim'] = $object['data_fim'];
        $dadosAdicionais['data_solicitacao'] = "Emitido em ".date('d/m/Y H:i:s');

        /**
         * ARRAY DE RETORNO PARA USUARIO
         */
        $arrayTela = array();
        /**
         * GUARDA O ACUMULADO DE HORAS TOTAIS POR FUNCIONÁRIO
         */
        $arrayHoras = array();
        /**
         * GUARDA O TOTAL DA SOMA DE HORAS
         */ 
        $arrayTotal = array();

        // $arrayTotal['label'] = 'TOTAL';
        // $arrayTotal['label'] = 'TOTAL';

        $arrayTotal['funcionario'] = '';
        $arrayTotal['tempo'] = 0;
        $arrayTotal['valor'] = 0;
       
        

        $arrayAjustesHC = $this->ajustes($object);
// print_r($object);
        
        foreach($result as $value){
    
            foreach($value as $value1){

                $alias = $value1['dadosComplemento']['alias']."_".$value1['departamento']."_".$value1['aplicacao'];
                // $alias = $value1['dadosComplemento']['alias']."_".$value1['alias']."_".$value1['id_funcionario']."_".$value1['data_mes']."_".$value1['data_ano'];
               
                

                if(isset($arrayHoras[$alias])){

                    $arrayHoras[$alias]['tempo'] += $value1['tempo'];

                }else{

                    $arrayHoras[$alias]['nome'] = $value1['nome'];
                    $arrayHoras[$alias]['sobrenome'] = $value1['sobrenome'];
                    $arrayHoras[$alias]['valor'] = $value1['valor'];
                    $arrayHoras[$alias]['tipo'] = $value1['tipo'];
                    $arrayHoras[$alias]['centroCusto'] = $value1['centroCusto'];
                    $arrayHoras[$alias]['id_tabela'] = $value1['id_tabela'];
                    $arrayHoras[$alias]['id_tabela_complemento'] = $value1['id_tabela_complemento'];
                    // $arrayHoras[$alias]['id_centro_custo'] = $value1['id_centro_custo'];
                    $arrayHoras[$alias]['id_centro_custo'] = $object['id_centro_custo'];
                    $arrayHoras[$alias]['tempo'] = $value1['tempo'];
                    $arrayHoras[$alias]['departamento'] = $value1['departamento'];
                    $arrayHoras[$alias]['totalLinha'] = 0;
                    $arrayHoras[$alias]['alias'] = $alias;
                    
                }
               
                
                $arrayHoras[$alias]['totalLinha'] += $value1['valor'] * $value1['tempo'];

            }

        }
        
        // $arrayHoras = array_merge($arrayHoras,$arrayAjustesHC);

        // print_r($arrayHoras);
        /**
         * ALTERA A CHAVE DO ARRAY PARA id_tabela_id_tabela_complemento_id_centro custo
         */
        // print_r($arrayAjustesHC);
        $arrayTemp = array();

        foreach($arrayAjustesHC as $key => $value){
            
          $alias = $value['id_tabela']."_".$value['id_tabela_complemento']."_".$value['centroCustoCompleto']['id'];

            $arrayTemp[$alias][] = $value;
        }
        
        $arrayAjustesHC = $arrayTemp;

        $arrayHorasTemp = array();
/**
 * aplicando o ajuste
 */

        foreach($arrayAjustesHC as $value){
            
            foreach($value as $value1){
                
                $aliasAjuste = $value1['id_tabela']."_".$value1['id_tabela_complemento']."_".$value1['centroCustoCompleto']['id'];

                foreach($arrayHoras as $key => $value3){
                    
                    $aliasHoras = $value3['id_tabela']."_".$value3['id_tabela_complemento']."_".$value3['id_centro_custo'];
                
                    if($aliasAjuste == $aliasHoras){
                        
                        // echo $value3['totalLinha']."<br>";
                        // echo $value1['ajuste']."<br>";
                        // echo $value3['totalLinha'] = $value3['totalLinha'] + $value1['ajuste'];

                        $value3['totalLinha'] += $value1['ajuste'];
                        $value3['tempo'] += $value1['ajusteH'];
                        
                        $arrayHorasTemp[$key] = $value3; 
                    }else{
                        $arrayHorasTemp[$key] = $value3; 
                    }

                    $arrayHoras[$key] = $value3;
                    
                }
                
            }
        }

        // print_r($arrayAjustesHC);
        // print_r($arrayHoras);
        // $arrayHoras = $arrayHorasTemp;

        foreach($arrayHoras as  $key => $value){

            $arrayHoras[$key]['totalLinhaBr'] = number_format($value['totalLinha'],2,',','.');
            $arrayHoras[$key]['valorBr'] = number_format($value['valor'],2,',','.');
            if($value['totalLinha'] == 0){
                unset($arrayHoras[$key]);
            }
            
        }

        foreach($arrayHoras as $value){

            $arrayTotal['valor'] += $value['totalLinha'];

            $arrayTotal['tempo'] += $value['tempo'];

        }

        $arrayTotal['valor'] = number_format($arrayTotal['valor'],2,',','.');
        // echo $total;
        
        $arrayOrd = array();
        $arrayTempOrd = array();
        $arrayTempFinal = array();
        $arraySC = array();
        $arrayPP = array();

        $controle = 1;
        foreach($arrayHoras as $linha){

           $ex = explode("-",$linha['alias']);

            $numero = str_replace(".","",$ex[0]);

            if(in_array($numero,$arrayOrd)){
                
                $numero = $numero.".".$controle;
                $controle++;
            }

            $arrayOrd[] = $numero;
            $arrayTempOrd[$numero] = $linha;
        }

        sort($arrayOrd);        
        // $a = array("1"=>1,"2"=>1.2,"3"=>3);

        // sort($a);

        // print_r($arrayTempOrd);

        foreach($arrayOrd as $linha){
            $arrayTempFinal[$arrayTempOrd[$linha]['alias']] = $arrayTempOrd[$linha];
        }

        foreach($arrayTempFinal as $key => $linha){

            if($linha['tipo'] == "PP"){
                $arrayPP[$key] = $linha;
            }else{
                $arraySC[$key] = $linha;
            }
        }

        $arrayTempFinal = array_merge($arraySC,$arrayPP);
        // print_r($arrayTempFinal);

        // print_r($arrayHoras);
        /**
         * ADICIONA O RODAPE COM OS TOTAIS
         */
        $arrayTela['totais'] = $arrayTotal;
        // $arrayTela['dados'] = $arrayHoras;
        $arrayTela['dados'] = $arrayTempFinal;
        $arrayTela['dadosAdicionais'] = $dadosAdicionais;
        // $arrayTela['dados'] = $this->organizarCPC($arrayHoras);

        echo json_encode($arrayTela);

    }

    function acumuloHorasTrabalhadas($object){

        date_default_timezone_set('America/Sao_Paulo');

        $result = $this->horasFuncionarios($object);
        
        /**
         * DADOS PARA ADICIONAR NA TABELA PARA IMPRESSÃO
         */
        $dadosAdicionais['data_inicio'] = $object['data_inicio'];
        $dadosAdicionais['data_fim'] = $object['data_fim'];
        $dadosAdicionais['data_solicitacao'] = "Emitido EM ".date('d/m/Y H:i:s');

        /**
         * ARRAY DE RETORNO PARA USUARIO
         */
        $arrayTela = array();
        /**
         * GUARDA O ACUMULADO DE HORAS TOTAIS POR FUNCIONÁRIO
         */
        $arrayHoras = array();
        /**
         * GUARDA O TOTAL DA SOMA DE HORAS
         */ 
        $arrayTotal = array();

        // $arrayTotal['label'] = 'TOTAL';
        // $arrayTotal['label'] = 'TOTAL';

        $arrayTotal['funcionario'] = '';
        $arrayTotal['tempo'] = 0;
        $arrayTotal['valor'] = 0;

        
        
        foreach($result as $value){

           
    
            foreach($value as $value1){
              
                $alias = $value1['dadosComplemento']['numero'];
                // $alias = $value1['dadosComplemento']['alias']."_".$value1['id_funcionario']."_".$value1['data_mes']."_".$value1['data_ano']."_".$value1['departamento'];
                
                if(isset($arrayHoras[$alias])){

                    if($value1['departamento'] != "MANUT"){

                        $arrayHoras[$alias]['tempo'] += $value1['tempo'];
                        
                    };                   

                }else{

                    $arrayHoras[$alias]['nome'] = $value1['nome'];
                    $arrayHoras[$alias]['sobrenome'] = $value1['sobrenome'];
                    $arrayHoras[$alias]['valor'] = $value1['valor'];
                    $arrayHoras[$alias]['tipo'] = $value1['tipo'];
                    $arrayHoras[$alias]['id_tabela'] = $value1['id_tabela'];
                    $arrayHoras[$alias]['id_tabela_complemento'] = $value1['id_tabela_complemento'];
                    $arrayHoras[$alias]['tempo'] = $value1['tempo'];
                    $arrayHoras[$alias]['totalLinha'] = 0;
                    $arrayHoras[$alias]['alias'] = $value1['dadosComplemento']['numero']."-".$value1['dadosComplemento']['sigla']." ".$value1['dadosComplemento']['data'];
                    
                    if($value1['id_tabela'] == 1){
                        $arrayHoras[$alias]['id_contrato'] = $value1['dadosComplemento']['id_contrato'];
                    }else{
                        $arrayHoras[$alias]['id_contrato'] = $value1['id_tabela_complemento'];
                    }
                }

                $arrayHoras[$alias]['totalLinha'] += $value1['valor'] * $value1['tempo'];
                $arrayHoras[$alias]['totalBr'] = number_format($arrayHoras[$alias]['totalLinha'], 2, ',', '.');
                // $arrayHoras[$alias]['totalEn'] = number_format($arrayHoras[$alias]['totalLinha'], 2, '.', '');
                $arrayHoras[$alias]['totalEn'] = $arrayHoras[$alias]['totalLinha'];
				$arrayHoras[$alias]['totalEnv'] = number_format($arrayHoras[$alias]['totalEn'],6,',','.');

            }           

        }
        
        $arrayAjustes = $this->ajustes($object);
     

        $arrayTempAjuste = array();
        
        foreach ($arrayHoras as $key => $value){
        

             $aliasTabela = $value['id_tabela']."_".$value['id_contrato'];
            
            foreach($arrayAjustes as $value1){
                // print_r($value1);
                 $aliasAjusteTemp = $value1['id_tabela']."_".$value1['dadosCompleto']['id_contrato'];

                if($aliasTabela == $aliasAjusteTemp){
                    // print_r($value);
                    $value['totalEn'] = $value['totalEn']+$value1['ajuste'];
                    $value['totalBr'] = number_format($value['totalEn'], 2, ',', '.');
                    $value['tempo'] = $value['tempo']+$value1['ajusteH'];
                    $value['ajustado'] = "true";
                }

            }

            $arrayTempAjuste[$key] = $value;

        }

        $arrayHoras = $arrayTempAjuste;
        // print_r($arrayHoras);
        foreach($arrayHoras as $key => $value){

            $value['tempo'] = number_format($value['tempo'], 1, '.', '');

            $arrayHoras[$key] = $value;

        }

        foreach($arrayHoras as $value){

            $arrayTotal['valor'] += $value['totalEn'];
            $arrayTotal['valorBr'] = number_format($arrayTotal['valor'], 2, ',', '.');
            // $arrayTotal['valorBr'] = $arrayTotal['valor'];

            $arrayTotal['tempo'] += $value['tempo'];

        }


        foreach($arrayHoras as $key => $value){

        //    $value['totalBr'] = number_format($value['totalBr'], 2, ',', '.');
            // $arrayHoras[$key]['totalBr'] = number_format($arrayHoras[$key]['totalBr'], 2, ',', '.');
        }
        
        // print_r($arrayHoras);
        
        $arrayTotal['valorBr'] = number_format($arrayTotal['valor'], 2, ',', '.');
        $arrayTotal['valorEn'] = round($arrayTotal['valor'],6);
        // echo $total;
        
        /**
         * ADICIONA O RODAPE COM OS TOTAIS
         */
        $arrayTela['totais'] = $arrayTotal;
        $arrayTela['dados'] = $arrayHoras;
        $arrayTela['dadosAdicionais'] = $dadosAdicionais;
        // $arrayTela['dados'] = $this->organizarCPC($arrayHoras);

        echo json_encode($arrayTela);

    }

    function acumuloHorasFuncionarioContrato($object){
        
        $this->oModel->populate($object);

        $result = $this->oModel->getHorasFuncContrato();

        echo json_encode($result);

    }

    /**
     * ORGANIZA CONTRATOS PROPOSTAS E CENTRO CUSTOS POR ORDEM ALFABETICA / NUMERICA
     */
    function organizarCPC($array){

        $subContratos = array();
        $proposta = array();
        $centroCusto = array();

        foreach($array as $key => $linha){
            if($linha['id_tabela'] == 1){
                $subContratos[$key] = $linha;
            }else if($linha['id_tabela'] == 2){
                $proposta[$key] = $linha;
            }else if($linha['id_tabela'] == 3){
                $centroCusto[$key] = $linha;
            }
        }

        asort($subContratos);
        asort($proposta);
        asort($centroCusto);

        $result = array_merge($subContratos,$proposta,$centroCusto);

        return $result;
    }

function temp(){
    foreach($result as $array1){
        /**
         * RECEBE O CAMINHO DE CADA FOREACH PARA ACUMULAR O TOTAL DE VALOR * TEMPO
         */
        $aliasTemp = '';

        foreach($array1 as $subArray){
            /**
             * FORMA A KEY DO ARRAY NESSE CASO CONTRATO+ID FUNCIONARIO
             */
            $aliasTemp = $alias = $subArray['dadosComplemento']['alias'].' '.$subArray['alias'].' '.$subArray['id_funcionario'];
            /**
             * QUANDO A HORA É DO MESMO FUNCIONÁRIO É SOMADO
             */
            if(isset($arrayHoras[$alias]['tempo'])){

                $arrayHoras[$alias]['tempo'] += $subArray['tempo'];
            }else{

                $arrayHoras[$alias]['tempo'] = $subArray['tempo'];
            }
            

            $arrayHoras[$alias]['aliasAplicacao'] = $subArray['alias'];
            $arrayHoras[$alias]['departamento'] = $subArray['departamento'];
            $arrayHoras[$alias]['centroCusto'] = $subArray['centroCusto'];
            $arrayHoras[$alias]['id_tabela'] = $subArray['id_tabela'];
            $arrayHoras[$alias]['nome'] = $subArray['nome'];
            $arrayHoras[$alias]['sobrenome'] = $subArray['sobrenome'];
            $arrayHoras[$alias]['valor'] = $subArray['valor'];
            $arrayHoras[$alias]['totalLinha'] = $arrayHoras[$alias]['tempo'] * $subArray['valor'];
            
          /**
           * FAZ O ACUMULADO DE TEMPO
           */
            // $arrayTotal['tempo'] += $subArray['tempo'];
            
        }
// echo "--".$arrayHoras[$aliasTemp]['totalLinha']."--";
        // $arrayTotal['valor'] += $arrayHoras[$aliasTemp]['totalLinha'];
    }
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

    public function getAllContratos($object)
    {
        
        $this->oModel->populate($object);

        $subContrato = $this->oModel->getAllBySubContrato();

        $result['result'][0] = $subContrato['result'];

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
$valTemp = 0;

        foreach ($result as $value) {
           
            $mesAno = $this->function->ano_mes_dia_to_mes_ano($value['data']);


            $mesAnoN = $value['id_centro_custo'] . '_' . $this->function->ano_mes_dia_to_mes_ano_n($value['data']);


            if (!in_array($mesAno, $cabecalho)) {
                $cabecalho[] = $mesAno;

            }

            if (!isset($horas[$value['numero'] . $mesAno])) {
                    
                $horas[$value['numero'] . $mesAno]['tempo'] = $value['tempo'] * $custosDados[$mesAnoN]['valor'];
                // $horas[$value['numero'] . $mesAno]['tempo'] = round($value['tempo'] * $custosDados[$mesAnoN]['valor'], 2);
                /**
                 * HORAS REFERENTE A0 4003 NAO DEVEM SER SOMADAS
                 */
                if ($value['centroCusto'] != "4003") {

                    $horas[$value['numero'] . $mesAno]['tempoH'] = $value['tempo'];
                }
                $horas[$value['numero'] . $mesAno]['tempoBr'] = $horas[$value['numero'] . $mesAno]['tempo'];
                $horas[$value['numero'] . $mesAno]['mesAno'] = $mesAno;
                $horas[$value['numero'] . $mesAno]['numero'] = $value['numero'];


            } else {

                $horas[$value['numero'] . $mesAno]['tempo'] += $value['tempo'] * $custosDados[$mesAnoN]['valor'];
                // $horas[$value['numero'] . $mesAno]['tempo'] += round($value['tempo'] * $custosDados[$mesAnoN]['valor'], 2);
                /**
                 * HORAS REFERENTE A0 4003 NAO DEVEM SER SOMADAS
                 */
                if ($value['centroCusto'] != "4003") {

                    $horas[$value['numero'] . $mesAno]['tempoH'] += $value['tempo'];
                }

                $horas[$value['numero'] . $mesAno]['tempoBr'] =$horas[$value['numero'] . $mesAno]['tempo'];
                $horas[$value['numero'] . $mesAno]['mesAno'] = $mesAno;
                $horas[$value['numero'] . $mesAno]['numero'] = $value['numero'];

                 
            }

            if($value['numero'] == 1417){

                echo $value['numero'].";";
                echo $value['centroCusto'].";";
                echo $value['centroCusto'].";";
                
                
                echo str_replace (".",",",$value['tempo']).";";
                
                echo str_replace (".",",",$custosDados[$mesAnoN]['valor']).";";
                echo str_replace (".",",",$custosDados[$mesAnoN]['valor'])."<br>";
               
        
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




        $result['grid'] = $grid;
        $result['footer'][0] = $footer;

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








































































