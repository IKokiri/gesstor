<?php


header('Access-Control-Allow-Origin: *');
$mysqli = mysqli_connect("localhost", "root", "", "gesstor");

// if (!$link) {
//     echo "Error: Unable to connect to MySQL." . PHP_EOL;
//     echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
//     exit;
// }

$query = "SELECT con.numero,con.id,scon.id as id_scon,scon.divisao FROM `sub_contratos` scon
inner join `contratos` con
    on scon.id_contrato =  con.id order by numero asc, divisao asc";
$arrayFunc;
if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        $arrayFunc[$row["id_scon"]]["contrato"] = $row["numero"].".".$row["divisao"];
        $arrayFunc[$row["id_scon"]]["id_scon"] = $row["id_scon"];
    }

    /* free result set */
    $result->close();
}



mysqli_close($mysqli);

echo json_encode($arrayFunc);
?>