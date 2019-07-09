<?php

define('DS', DIRECTORY_SEPARATOR);
// define('RAIZ', DS . 'opt' . DS . 'lampp' . DS . 'htdocs' . DS . 'gesstor');
// define('RAIZ', 'C:' . DS . 'xampp' . DS . 'htdocs' . DS . 'gesstor');
// define('RAIZ', 'C:' .  DS . 'xampp' . DS . 'htdocs' . DS . 'gesstor');
define('RAIZ', DS . 'home' . DS . 'mendes' . DS . 'Documents'. DS .'Projetos'. DS .'gesstor');
define('APP', RAIZ . DS . 'App');
define('CONFIG', APP . DS . 'Config');
define('DAO', APP . DS . 'DAO');
define('CONTROLLER', RAIZ . DS . 'App' . DS . 'Controller');
define('COMPLEMENT', RAIZ . DS . 'App' . DS . 'Complement');
define('MODEL', RAIZ . DS . 'App' . DS . 'Model');
define('VIEW', RAIZ . DS . 'App' . DS . 'View');
define('CORE', RAIZ . DS . 'App' . DS . 'Core');
define('NAMESPACE_CONTROLLER', '\\' . 'App' . '\\' . 'Controller');
define('VENDOR_APP', APP . DS . 'vendor');
define('TWIG_LIB', VENDOR_APP . DS . 'twig/twig/lib/Twig');
define('PAGSEGURO', VENDOR_APP . DS . 'Pag_Seguro/source/PagSeguroLibrary');
