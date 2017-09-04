<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $login = $_SESSION['login'];
    $dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
    if (!$login) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://" . $dir . "'>";
    }
    require("_database/db_tools.php"); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="_themes/tema_inmater.min.css"/>
    <link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css"/>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="ayuda" data-dialog="true">
    <style>
        .ui-dialog-contain {
            max-width: 1200px;
            margin: 1% auto 1%;
            padding: 0;
            position: relative;
            top: -35px;
        }
        .enlinea div {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    <script>
        $(document).ready(function () {

            $('#form1').submit(function () {

                if ($("#archivo").val() != '') {
                    $("#cargador").popup("open", {positionTo: "window"});
                    return true;
                }
            });
        });
        function anular(x) {
            document.form1.borra.value = x;
            document.form1.archivo.value = ""; //para que no inserte registros
            document.form1.submit();
        }

    </script>
    <?php
    if ($_POST['guardar']=='CARGAR') {

        if ($_FILES['archivo']['name'] <> "") {
            if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                $ruta = 'paci/' . $_FILES['archivo']['name'];
                move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
            }
        }
    }

    if ($_POST['borra']<>'')
        unlink("paci/".$_POST['borra']);


        $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
        $rUser->execute(array($login));
        $user = $rUser->fetch(PDO::FETCH_ASSOC);

 ?>

    <div data-role="header" data-position="fixed">
        <a href="lista.php" rel="external"
           class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
        <h1>AYUDA</h1>
    </div><!-- /header -->

        <div class="ui-content" role="main">

            <form action="ayuda.php" method="post" enctype="multipart/form-data" data-ajax="false" id="form1" name="form1">
                <input type="hidden" name="borra">
                <?php if ($user['role'] == 2) { ?>
                    <div class="enlinea">
                <input name="archivo" id="archivo" type="file" accept="video/mp4" required data-mini="true" data-inline="true"/>
                    <input name="guardar" type="Submit" id="guardar" value="CARGAR" data-icon="check"
                           data-iconpos="left" data-inline="true" data-theme="b" data-mini="true"/>
                </div>
                <?php }

                $path = "paci/";

                $files = array_diff(scandir($path), array('.', '..'));
                echo "<ol>";
                foreach ($files as $value) {
                    if (!is_dir("paci/".$value)) {
                    echo "<li><a href='http://".$dir."/paci/".$value."' target='_blank' >".$value."</a> ";
                    if ($user['role'] == 2) { ?>
                        <small><a href="javascript:anular('<?php echo $value; ?>');">(borrar)</a></small>

                <?php } echo "</li>";} }
                echo "</ol>";
                ?>

            </form>
            <div data-role="popup" id="cargador" data-overlay-theme="b" data-dismissible="false"><p>SUBIENDO ARCHIVO..</p></div>
        </div><!-- /content -->


</div><!-- /page -->

</body>
</html>
