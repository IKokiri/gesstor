<?php

// error_reporting(0);

header('Access-Control-Allow-Origin: *');

session_start();

require_once '../Config/constants.php';

require_once MODEL . DS . 'Usuario.php';

use App\Model\Usuario;


$action = (isset($_SESSION['gesstor']['action']) && $_SESSION['gesstor']['action']) ? $_SESSION['gesstor']['action'] : 'login';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : $action;

$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'render';

$_SESSION['gesstor']['action'] = $action;

unset($_REQUEST['action']);

unset($_REQUEST['method']);

if (isset($_REQUEST['dados'])) {

    $param = isset($_REQUEST) ? json_decode($_REQUEST['dados']) : [];

} else {

    $param = isset($_REQUEST) ? $_REQUEST : [];
    $param['file'] = isset($_FILES) ? $_FILES : [];

}

require APP . DS . 'autoload.php';

require_once TWIG_LIB . DS . 'Autoloader.php';


$method = ($method) ? $method : 'render';

if (file_exists(CONTROLLER . DS . $action . '.php')) {

    require CONTROLLER . DS . $action . '.php';

    $controller = NAMESPACE_CONTROLLER . '\\' . $action;

    $class = new $controller;

    call_user_func_array(array($class, $method), array($param));
    
} else {
//    header("location:App/Template/template/404.php");
    $_SESSION['gesstor']['action'] = $action;
}


