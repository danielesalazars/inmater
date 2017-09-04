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

<div data-role="page" class="ui-responsive-panel" id="n_adju" data-dialog="true">
    <?php if ($_POST['dni'] <> '' and $_POST['guardar'] == 'GUARDAR') {
        if ($_POST['cont'] >= 1) {
            for ($p = 1; $p <= $_POST['cont']; $p++) {
                $tan = explode("|", $_POST['c' . $p]);
                $stmt2 = $db->prepare("UPDATE lab_aspira_dias SET adju=? WHERE pro=? AND ovo=?");
                $stmt2->execute(array($_POST['adju' . $p], $tan[0], $tan[1])); // Adjudica el dni de la paciente al ovo/embrion
            } ?>
            <script type="text/javascript">
                var x = "<?php echo $_POST['dni']; ?>";
                window.parent.location.href = "n_repro.php?id=" + x;
            </script>
        <?php } else echo "<div id='alerta'>NO hay nada para adjudicar</div>";
    }
    if ($_GET['id'] <> "") {
        $id = $_GET['id'];

        $rDon = $db->prepare("SELECT dni,nom,ape,don,med FROM hc_paciente WHERE don='D' ORDER BY ape ASC");
        $rDon->execute();
        $rDon->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $rDon->fetchAll();
        ?>
        <script>
            $(document).ready(function () {

                $("#donante").change(function () {
                    if ($(this).val() != '' && $("#p_des").val() != '') {
                        $(".lista_des2").remove();
                        var h = $("#p_des").val();
                        var dni = $(this).val();
                        var paci = $("#dni").val();
                        $('.lista_des').html('<h3>CARGANDO DATOS...</h3>');
                        $.post("le_tanque.php", {h:h, dni:dni, paci:paci, btn_guarda:2}, function (data) {
                            $('.lista_des').html('');
                            $(".lista_des").append('<div class="lista_des2">' + data + '</div>');
                            $('.ui-page').trigger('create'); // ------ recarga los css del jqm ----------------------------
                        });
                    }
                });

                $("#p_des").change(function () {
                    $("#donante").val("");
                    $("#donante").prop('selectedIndex', 0);
                    $("#donante").selectmenu("refresh", true);
                });

            });
        </script>
        <style>
            .ui-dialog-contain {
                max-width: 700px;
                margin: 1% auto 1%;
                padding: 0;
                position: relative;
                top: -35px;
            }

            .color {
                color: #F4062B !important;
            }

            #alerta {
                background-color: #FF9;
                margin: 0 auto;
                text-align: center;
                padding: 4px;
            }
        </style>

        <div data-role="header" data-position="fixed">
            <h2>RESERVA OVULOS - EMBRIONES</h2>
        </div><!-- /header -->

        <div class="ui-content" role="main">

            <form action="n_adju.php?id=<?php echo $id; ?>" method="post" data-ajax="false" name="form2">
                <input type="hidden" name="dni" id="dni" value="<?php echo $id; ?>">

                <div data-role="controlgroup" data-type="horizontal" class="ui-mini">
                    <select name="p_des" id="p_des" data-mini="true">
                        <option value="" selected>Seleccione Tipo:</option>
                        <option value=1>Embriones</option>
                        <option value=2>Ovulos</option>
                    </select>
                    <select name="donante" id="donante">
                        <option value="">Seleccione Donante:</option>
                        <?php foreach ($rows as $don) { ?>
                            <option value="<?php echo $don['dni']; ?>"><?php echo $don['ape'] . ' ' . $don['nom'] . ' (' . $don['med'] . ')'; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="lista_des"></div>
            </form>
        </div><!-- /content -->
    <?php } ?>
</div><!-- /page -->
<script>
    $(function () {
        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>
</script>
</body>
</html>
