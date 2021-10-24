<?php

namespace App\View;

require_once CORE . DS . 'View.php';
require_once APP . '/vendor/autoload.php';

use Twig_Autoloader as Twig_Autoloader;
use Twig_Loader_Filesystem as Twig_Loader_Filesystem;
use Twig_Environment as Twig_Environment;
use App\Core\View;

class ChamadoCliente extends View
{
    public function __construct()
    {
        parent::__construct();

    }

    public function render()
    {
        parent::render();

        $this->header .= '<link href="../Template/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
                            <link href="../Template/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
                            <link href="../Template/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
                            <link href="../Template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
                            <link href="../Template/production/css/animate.min.css" rel="stylesheet">
                            <link href="../Template/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
                            <link href="../Template/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
                            <link href="../Template/vendors/pnotify/dist/pnotify.brighttheme.css" rel="stylesheet">';

        $this->footer .= '   <script src="../Template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
                                <script src="../Template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
                                <script src="../Template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
                                <script src="../Template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
                                <script src="../Template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
                                <script src="../Template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
                                <script src="../Template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
                                <script src="../Template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>                     
                                <script src="../Template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
                                <script src="../Template/vendors/iCheck/icheck.min.js"></script>
                                <script src="../Template/template/js/geral.js"></script>
                                <script src="../Template/vendors/pnotify/dist/pnotify.js"></script>
                                <script src="../Template/vendors/pnotify/dist/pnotify.confirm.js"></script>
                                <script src="../Template/vendors/pnotify/dist/pnotify.buttons.js"></script>
                                <script src="../Template/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
                                <script src="../Template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
                                <script src="../Template/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
                                <script src="../Template/vendors/google-code-prettify/src/prettify.js"></script>
                                <script src="../Listener/chamadoCliente.js"></script>           
                                ';


        $show = array(
            'title' =>
                'Chamado',
            'sidebar' => $this->sidebar,
            'header' => $this->header,
            'footer' => $this->footer,
            'welcome' => $this->wellcome,
            'home' => $this->home,
            'footer_menu' => $this->footer_menu,
            'top_nav' => $this->top_nav,
            'footer_html' => $this->footer_html
        );

        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(APP . DS . 'Template/template/');
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate('chamadoCliente.php');
        echo $template->render($show);
    }

}