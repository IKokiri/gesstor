<?php
header('Access-Control-Allow-Origin: *');
//echo json_encode(1);
$versao_atual = '5.5';
//$array['texto'] = "<li>Adiconado informação de carregamento de dados</li>";
$versao = $_REQUEST['versao'];
$array = array();
if($versao_atual != $versao){
    $array['tipo'] = "info";
    $array['texto'] = "<li>Remoção campo buscar na tela de inicio</li><hr>" .
        "<li>Ausências futuras marcadas de vermelho </li><hr>";
    $array['download'] = 1;

}
$array['versao'] = $versao_atual;
echo json_encode($array);