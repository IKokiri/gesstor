<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Gesstor </title>

    <!-- Bootstrap -->
    <link href="../../../App/Template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../../App/Template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../../App/Template/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../../App/Template/build/css/custom.min.css" rel="stylesheet">

    <link href="../../../App/Template/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="../../../App/Template/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <link href="../../../App/Template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <link href="../../../App/Template/production/css/animate.min.css" rel="stylesheet">

    <link href="../../../App/Template/vendors/pnotify/dist/pnotify.css" rel="stylesheet">

    <link href="../../../App/Template/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">

    <link href="../../../App/Template/vendors/pnotify/dist/pnotify.brighttheme.css   " rel="stylesheet">
    <!-- Select2 -->
    <link href="../../../App/Template/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
    </style>

</head>

<body class="nav-md">

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Custom</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <select class="select2_single form-control" tabindex="-1">
            <option></option>
            <option value="AK">Alaska</option>
            <option value="HI">Hawaii</option>
            <option value="CA">California</option>
            <option value="NV">Nevada</option>
            <option value="OR">Oregon</option>
            <option value="WA">Washington</option>
            <option value="AZ">Arizona</option>
            <option value="CO">Colorado</option>
            <option value="ID">Idaho</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NM">New Mexico</option>
            <option value="ND">North Dakota</option>
            <option value="UT">Utah</option>
            <option value="WY">Wyoming</option>
            <option value="AR">Arkansas</option>
            <option value="IL">Illinois</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="OK">Oklahoma</option>
            <option value="SD">South Dakota</option>
            <option value="TX">Texas</option>
        </select>
    </div>
</div>

<!-- jQuery -->
<script src="../../../App/Template/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../../App/Template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../../App/Template/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../../../App/Template/vendors/nprogress/nprogress.js"></script>
<!-- Custom Theme Scripts -->
<script src="../../../App/Template/build/js/custom.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

<script src="../../../App/Template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>


<script src="../../../App/Template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>

<script src="../../../App/Template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

<script src="../../../App/Template/vendors/Chart.js/dist/Chart.min.js"></script>

<script src="../../../App/Template/vendors/echarts/dist/echarts.min.js"></script>

<script src="../../../App/Template/vendors/iCheck/icheck.min.js"></script>

<script src="../../../App/Template/vendors/pnotify/dist/pnotify.js"></script>

<script src="../../../App/Template/vendors/pnotify/dist/pnotify.confirm.js"></script>

<script src="../../../App/Template/vendors/pnotify/dist/pnotify.buttons.js"></script>

<script src="../../../App/Template/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

<script src="../../../App/Template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>

<script src="../../../App/Template/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>

<script src="../../../App/Template/vendors/google-code-prettify/src/prettify.js"></script>

<!-- Select2 -->
<script src="../../../App/Template/vendors/select2/dist/js/select2.full.min.js"></script>

<script src="../../../App/Template/vendors/maskmoney/maskmoney.js"></script>

<script src="../../../App/Template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

<script src="../../../App/Template/template/js/datepicker/daterangepicker.js"></script>

<script src="../../../App/Template/template/js/geral.js"></script>
<?php



?>

<script src="../../../App/Listener/nav.js"></script>
<script src="../../../App/Template/template/js/geral.js"></script>

</body>
</html>
<script>
    $(".select2_single").select2({
        placeholder: "Select a state",
        allowClear: true
    });
</script>