<?php

namespace App\Complement;

use App\Core\Controller;
use App\Core\Model;
use App\Model\ChamadoCliente as ChamadoCliente_Model;
use App\View\ChamadoCliente as ChamadoCliente_View;
use App\Model\ImagemChamado as ImagemChamado_Model;

class Functions
{

    public function __construct()
    {

    }

    function dia_da_semana($dia)
    {
        $ret = '';

        if ($dia == 0) {
            $ret = "Dom";
        }
        if ($dia == 1) {
            $ret = "Seg";
        }
        if ($dia == 2) {
            $ret = "Ter";
        }
        if ($dia == 3) {
            $ret = "Qua";
        }
        if ($dia == 4) {
            $ret = "Qui";
        }
        if ($dia == 5) {
            $ret = "Sex";
        }
        if ($dia == 6) {
            $ret = "Sab";
        }

        return $ret;
    }

    function data_banco_br($data)
    {

        if ($data) {

            $ano = substr($data, 0, 4);

            $mes = substr($data, 5, 2);

            $dia = substr($data, 8, 2);

            $data = $dia . "/" . $mes . "/" . $ano;

        }

        return $data;
    }
    /**
     * UMA DATA NO PADRA AAAA*AA*AA É RECEBIDA E É RETORNADO UM ARRAY DE 3 POSIÇÕES
     */
    function data_banco_array($data)
    {
        
        $retorno = array();
        if ($data) {

            $ano = substr($data, 0, 4);

            $mes = substr($data, 5, 2);

            $dia = substr($data, 8, 2);

            $retorno[] = $dia;
            $retorno[] = $mes;
            $retorno[] = $ano;

        }
        return $retorno;
    }

    function en_mes_ano_kuttner($data)
    {

        if ($data) {

            $ano = substr($data, 2, 2);

            $mes = substr($data, 5, 2);

            $data = $mes . $ano;

        }

        return $data;
    }

    function data_br_banco($data)
    {

        if ($data) {

            $dia = substr($data, 0, 2);

            $mes = substr($data, 3, 2);

            $ano = substr($data, 6, 4);

            $data = $ano . "/" . $mes . "/" . $dia;

        }

        return $data;
    }

    function data_dia_mes_escrito($data)
    {

        if ($data) {

            $dia = substr($data, 0, 2);

            $mes = substr($data, 3, 2);

            $ano = substr($data, 6, 4);

            $data = $dia . " - " . $this->mes_nome($mes);

        }
        return $data;
    }

    function mes_nome($mes)
    {

        if ($mes == '01') {
            $mes = "JAN";
        } else if ($mes == '02') {
            $mes = "FEV";
        } else if ($mes == '03') {
            $mes = "MAR";
        } else if ($mes == '04') {
            $mes = "ABR";
        } else if ($mes == '05') {
            $mes = "MAI";
        } else if ($mes == '06') {
            $mes = "JUN";
        } else if ($mes == '07') {
            $mes = "JUL";
        } else if ($mes == '08') {
            $mes = "AGO";
        } else if ($mes == '09') {
            $mes = "SET";
        } else if ($mes == '10') {
            $mes = "OUT";
        } else if ($mes == '11') {
            $mes = "NOV";
        } else if ($mes == '12') {
            $mes = "DEZ";
        }

        return $mes;

    }

    function data_banco_mes_ano($data)
    {
        if ($data) {

            $ano = substr($data, 0, 4);

            $mes = substr($data, 5, 2);

            $mes = $this->mes_nome($mes);

        }

        return $mes . " - " . $ano;
    }


    function data_banco_barra_mes_ano($data)
    {
        if ($data) {

            $ano = substr($data, 6, 4);

            $mes = substr($data, 3, 2);


        }

        return $mes . "/" . $ano;
    }

    function telefone_tela($telefone)
    {
        if ($telefone) {
            $ddd = substr($telefone, 0, 2);

            $bloco1 = substr($telefone, 2, 5);

            $bloco2 = substr($telefone, 7, 4);

            $telefone = "(" . $ddd . ") " . $bloco1 . "-" . $bloco2;

            return $telefone;
        } else {
            return "";
        }

    }

    function time_tela($time)
    {
        if ($time) {

            $time = substr($time, 0, 5);

            if ($time == "00:00") {

                $time = '';

            }

            return $time;
        } else {
            return "";
        }

    }

    function buscarMesAnterior($mesAno)
    {

        $mesAno = explode("/", $mesAno);

        $mes = $mesAno[0];
        $ano = $mesAno[1];

        if ($mes == 1) {
            $mes = 12;
            $ano = $ano - 1;
        } else {
            $mes = $mes - 1;
        }
        return str_pad($mes, 2, 0, STR_PAD_LEFT) . "/" . $ano;

    }

    function ano_mes_dia_to_mes_ano($mesAnoDia)
    {

        $ano = substr($mesAnoDia, 0, 4);

        $mes = substr($mesAnoDia, 5, 2);

        $dia = substr($mesAnoDia, 8, 2);

        $data = $this->mes_nome($mes) . " " . $ano;

        return $data;

    }

    function ano_mes_dia_to_mes_ano_n($mesAnoDia)
    {

        $ano = substr($mesAnoDia, 0, 4);

        $mes = substr($mesAnoDia, 5, 2);

        $dia = substr($mesAnoDia, 8, 2);

        $data = $mes . "/" . $ano;

        return $data;

    }

    function limparValoresArray($array)
    {
        $arrayNovo = array();
        foreach ($array as $key => $value) {
            $arrayNovo[$key] = '0_0';
        }
        return $arrayNovo;
    }

    function comparar_datas_banco($data1, $data2)
    {
        return ($this->remove_char_spec($data1) < $this->remove_char_spec($data2)) ? 1 : 0;
    }

    function remove_char_spec($valor)
    {
        $valor = str_replace(" ", "", $valor);
        $valor = str_replace("\"", "", $valor);
        $valor = str_replace("'", "", $valor);
        $valor = str_replace("!", "", $valor);
        $valor = str_replace("@", "", $valor);
        $valor = str_replace("#", "", $valor);
        $valor = str_replace("$", "", $valor);
        $valor = str_replace("%", "", $valor);
        $valor = str_replace("¨", "", $valor);
        $valor = str_replace("&", "", $valor);
        $valor = str_replace("*", "", $valor);
        $valor = str_replace("(", "", $valor);
        $valor = str_replace(")", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("_", "", $valor);
        $valor = str_replace("=", "", $valor);
        $valor = str_replace("+", "", $valor);
        $valor = str_replace("§", "", $valor);
        $valor = str_replace("\\", "", $valor);
        $valor = str_replace("|", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("<", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(">", "", $valor);
        $valor = str_replace(":", "", $valor);
        $valor = str_replace(";", "", $valor);
        $valor = str_replace("~", "", $valor);
        $valor = str_replace("^", "", $valor);
        $valor = str_replace("]", "", $valor);
        $valor = str_replace("}", "", $valor);
        $valor = str_replace("º", "", $valor);
        $valor = str_replace("[", "", $valor);
        $valor = str_replace("{", "", $valor);
        $valor = str_replace("ª", "", $valor);
        $valor = str_replace("´", "", $valor);
        $valor = str_replace("`", "", $valor);
        $valor = str_replace("?", "", $valor);
        $valor = str_replace("/", "", $valor);
        $valor = str_replace("°", "", $valor);
        return $valor;
    }

    function remove_char_spec2($valor)
    {
        $valor = str_replace("\"", "", $valor);
        $valor = str_replace("'", "", $valor);
        $valor = str_replace("!", "", $valor);
        $valor = str_replace("@", "", $valor);
        $valor = str_replace("#", "", $valor);
        $valor = str_replace("$", "", $valor);
        $valor = str_replace("%", "", $valor);
        $valor = str_replace("¨", "", $valor);
        $valor = str_replace("&", "", $valor);
        $valor = str_replace("*", "", $valor);
        $valor = str_replace("(", "", $valor);
        $valor = str_replace(")", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("_", "", $valor);
        $valor = str_replace("=", "", $valor);
        $valor = str_replace("+", "", $valor);
        $valor = str_replace("§", "", $valor);
        $valor = str_replace("\\", "", $valor);
        $valor = str_replace("|", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("<", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(">", "", $valor);
        $valor = str_replace(":", "", $valor);
        $valor = str_replace(";", "", $valor);
        $valor = str_replace("~", "", $valor);
        $valor = str_replace("^", "", $valor);
        $valor = str_replace("]", "", $valor);
        $valor = str_replace("}", "", $valor);
        $valor = str_replace("º", "", $valor);
        $valor = str_replace("[", "", $valor);
        $valor = str_replace("{", "", $valor);
        $valor = str_replace("ª", "", $valor);
        $valor = str_replace("´", "", $valor);
        $valor = str_replace("`", "", $valor);
        $valor = str_replace("?", "", $valor);
        $valor = str_replace("/", "", $valor);
        $valor = str_replace("°", "", $valor);
        return $valor;
    }


}