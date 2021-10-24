<?php


header('Access-Control-Allow-Origin: *');
$mysqli = mysqli_connect("localhost", "root", "", "gesstor");

// if (!$link) {
//     echo "Error: Unable to connect to MySQL." . PHP_EOL;
//     echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
//     exit;
// }

$query = "SELECT * FROM funcionarios";
$arrayFunc;
if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        $arrayFunc[$row["id"]]["nome"] = utf8_encode($row["nome"]." ".$row["sobrenome"]);
        $arrayFunc[$row["id"]]["id"] = $row["id"];
    }

    /* free result set */
    $result->close();
}



mysqli_close($mysqli);

// echo json_encode($_REQUEST);
echo json_encode($arrayFunc);
?>