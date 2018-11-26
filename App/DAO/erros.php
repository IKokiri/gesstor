<?php

function verificarErro($numero) {
    $arrayErro['erro'] = "";
    $arrayErro['cliente'] = "";

    if ($numero == 23000) {
        $arrayErro['erro'] = "ERRO FK";
        $arrayErro['msnErro'] = "Existe Vinculos Com Este Registro";
        $arrayErro['cliente'] = true;
        return $arrayErro;
    }

    if ($numero == 42000) {
        $arrayErro['erro'] = "ERRO QUERY";
        $arrayErro['msnErro'] = "ERRO QUERY";
        $arrayErro['cliente'] = false;
        return $arrayErro;
    }
}
