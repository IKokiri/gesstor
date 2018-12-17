<?php

session_start();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action == 'logout') {
    $_SESSION['gesstor'] = [];
}

if (isset($_SESSION['gesstor']['login']['id'])) {

    include 'App/Template/template/corpo.php';

} else {

    $_SESSION['gesstor'] = [];

    include 'App/Template/template/login.php';

}


