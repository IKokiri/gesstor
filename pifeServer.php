<?php
header('Access-Control-Allow-Origin: *');
error_reporting(0);

session_start();

$func = $_REQUEST['func'];
$sigla = strtoupper($_REQUEST['sigla']);
$pontos = $_REQUEST['pontos'];
$valor = $_REQUEST['valor'];


$mysqli = new mysqli("localhost", "root", "", "gesstor");

if($func == "adicionar"){

    $_SESSION['pife'][$sigla]['pontos']++;
    echo json_encode($_SESSION['pife']); 
}

if($func == "remover"){
    $_SESSION['pife'][$sigla]['pontos']--;
    echo json_encode($_SESSION['pife']); 
}

if($func == "addPlayer"){

    if(isset( $_SESSION['pife'][$sigla]) || $sigla == ""){
        
    }else{

    $sql = "INSERT INTO pife_players (sigla) values ('LZ')";
    $mysqli->query($sql);
        $_SESSION['pife'][$sigla]['pontos'] = $pontos;
        $_SESSION['pife'][$sigla]['total'] = 0;
    }
    
    echo json_encode($_SESSION['pife']); 

}

if($func == "limpar"){

    $_SESSION['pife'] = array();
    echo json_encode($_SESSION['pife']); 
}

if($func == "calcular"){    

    $nPlayer = count($_SESSION['pife']);
    
    $partidasTotais = 0;

    foreach($_SESSION['pife'] as $player){
        $partidasTotais += $player['pontos'];
    }

    foreach($_SESSION['pife'] as $key => $player){
        
        $_SESSION['pife'][$key]['total'] = ($player['pontos']*($nPlayer-1)*$valor)-(($partidasTotais-$player['pontos'])*$valor);
        
    }
     
    echo json_encode($_SESSION['pife']); 
}
?>
