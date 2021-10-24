<!DOCTYPE html>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> GESCON </title>

    <!-- Bootstrap -->
    <link href="App/Template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="App/Template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="App/Template/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="App/Template/build/css/custom.min.css" rel="stylesheet">

    <link href="App/Template/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="App/Template/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <link href="App/Template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <link href="App/Template/production/css/animate.min.css" rel="stylesheet">

    <link href="App/Template/vendors/pnotify/dist/pnotify.css" rel="stylesheet">

    <link href="App/Template/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">

    <link href="App/Template/vendors/pnotify/dist/pnotify.brighttheme.css   " rel="stylesheet">
    <!-- Select2 -->
    <link href="App/Template/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <link href="App/Template/vendors/tour/css/bootstrap-tour.min.css" rel="stylesheet">


    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .marcarTour {
            border: 3px solid red;
        }

    </style>

</head>

<body class="nav-sm">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <?php include 'App/Template/template/include/top_title.php' ?>

                <div class="clearfix"></div>
                <!-- menu profile quick info -->

                <?php include 'App/Template/template/include/profile.php' ?>
                <!-- /menu profile quick info -->
                <br/>

                <!-- sidebar menu -->
                <?php include 'App/Template/template/include/sidebar.php' ?>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->

                <?php include 'App/Template/template/include/footer_button.php' ?>
                <!-- /menu footer buttons -->
            </div>

        </div>

        <!-- top navigation -->
        <?php include 'App/Template/template/include/top_nav.php' ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3></h3>
                    </div>

                    <!--                    <div class="title_right">-->
                    <!--                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">-->
                    <!--                            <div class="input-group">-->
                    <!--                                <input type="text" class="form-control" placeholder="Buscar por . . .">-->
                    <!--                                <span class="input-group-btn">-->
                    <!--                      <button class="btn btn-default" type="button">Buscar</button>-->
                    <!--                    </span>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
                <div class="clearfix"></div>

                <?php

                $pagina = file_exists("App/Template/template/" . $_SESSION['gesstor']['action'] . ".php") ? $_SESSION['gesstor']['action'] : 'inicio';

                include 'App/Template/template/' . $pagina . '.php';

                ?>

            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php include 'App/Template/template/include/footer.php' ?>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="App/Template/vendors/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="App/Template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="App/Template/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="App/Template/vendors/nprogress/nprogress.js"></script>

<script src="App/Template/vendors/tour/js/bootstrap-tour.min.js"></script>
<!-- Custom Theme Scripts -->
<span id="customJs">
<!--<script src="App/Template/build/js/custom.min.js"></script>-->
</span>
<script src="App/Template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="App/Template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="App/Template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

<script src="App/Template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script src="App/Template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>

<script src="App/Template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

<script src="App/Template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>


<script src="App/Template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>

<script src="App/Template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

<script src="App/Template/vendors/Chart.js/dist/Chart.min.js"></script>

<script src="App/Template/vendors/echarts/dist/echarts.min.js"></script>

<script src="App/Template/vendors/iCheck/icheck.min.js"></script>

<script src="App/Template/vendors/pnotify/dist/pnotify.js"></script>

<script src="App/Template/vendors/pnotify/dist/pnotify.confirm.js"></script>

<script src="App/Template/vendors/pnotify/dist/pnotify.buttons.js"></script>

<script src="App/Template/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

<script src="App/Template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>

<script src="App/Template/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>

<script src="App/Template/vendors/google-code-prettify/src/prettify.js"></script>

<!-- Select2 -->
<script src="App/Template/vendors/select2/dist/js/select2.full.min.js"></script>

<script src="App/Template/vendors/maskmoney/maskmoney.js"></script>

<script src="App/Template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

<script src="App/Template/template/js/datepicker/daterangepicker.js"></script>

<!-- jQuery autocomplete -->
<script src="App/Template/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<?php

$js = "App/Listener/" . $_SESSION['gesstor']['action'] . ".js";

if (file_exists($js)) {
    echo "<script src=" . $js . "></script>";
} else {
}

?>

<script src="App/Listener/nav.js"></script>
<script src="App/Template/template/js/geral.js"></script>

</body>
</html>
