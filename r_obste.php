<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $login = $_SESSION['login'];
    $dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
    if ($login <> "lab") {
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
    <script src="jstickytableheaders.js"></script>
    <link rel="stylesheet" href="http://tablesorter.com/themes/blue/style.css" type="text/css"
          media="print, projection, screen">
    <script type="text/javascript" src="http://tablesorter.com/__jquery.tablesorter.min.js"></script>
    <style>
        .scroll_h {
            overflow: auto;
        }

        #alerta {
            background-color: #FF9;
            margin: 0 auto;
            text-align: center;
            padding: 4px;
        }

        .mayuscula {
            text-transform: uppercase;
            font-size: small;
        }

        .Mostrar {
            background-color: #F0DF96 !important;
        }

        .enlinea div {
            display: inline-block;
            vertical-align: middle;
        }

        #num_pro {
            color: red;
        }
    </style>
    <script>
        $(document).ready(function () {
            $(".Mostrar").click(function () {
                $("#reporte").val(1);
                $('#form1').submit();
            });

            $(".table-stripe").stickyTableHeaders(); // Cabecera flotante o fija en la tabla
            $(".table-stripe").tablesorter();  // table sort

        });
    </script>
</head>

<body>
<?php if ($login == 'lab') { ?>

    <script>
        $(function () {
            <?php if($_POST['reporte'] <> 1) { ?>
            $('.Cheqeados :checkbox').each(function () { //loop all checkbox in dvMain div
                $(this).prop("checked", true).checkboxradio("refresh");
            });
            <?php } ?>

        });
    </script>

    <div data-role="page" class="ui-responsive-panel">

        <div data-role="header">
            <div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
                <a href='lista.php' class="ui-btn ui-btn-c ui-icon-home ui-btn-icon-left" rel="external">Inicio</a>
            </div>
            <h1>Reporte Obstetricia</h1>
            <a href="index.php"
               class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power"
               rel="external">Salir</a>
        </div><!-- /header -->

        <div class="ui-content" role="main">
            <form action="r_obste.php" method="post" data-ajax="false" id="form1">
                <input type="hidden" name="reporte" id="reporte">
                <table style="margin: 0 auto;" width="100%">
                    <tr>
                        <td width="88%" align="center" valign="top">Medicos
                            <div class="Cheqeados enlinea">
                                <?php $rUser = $db->prepare("SELECT user FROM usuario WHERE role=1");
                                $rUser->execute();
                                $i = 0;
                                while ($user = $rUser->fetch(PDO::FETCH_ASSOC)) {
                                    $i++;
                                    if ($_POST['u' . $i] <> "") $check = "checked"; else $check = "";
                                    echo '<input type="checkbox" data-mini="true" name="u' . $i . '" id="u' . $i . '" ' . $check . ' value="' . $user['user'] . '"><label for="u' . $i . '">' . $user['user'] . '</label>';
                                } ?>
                                <input type="hidden" name="numUser" value=<?php echo $i; ?>>
                            </div>
                        </td>
                        <td width="12%" align="center" valign="top">
                            Mostrar Desde<input name="ini" type="date" id="ini" value="<?php echo $_POST['ini']; ?>"
                                                data-mini="true">
                            Hasta<input name="fin" type="date" id="fin" value="<?php echo $_POST['fin']; ?>"
                                        data-mini="true">
                            <h6>Dejar en blanco para mostrar todas las fechas</h6>
                            <p><a href="#" class="Mostrar ui-btn ui-icon-bullets ui-btn-icon-right ui-btn-inline"
                                  rel="external">Mostrar</a></p>
                        </td>
                    </tr>
                </table>
                <?php if ($_POST['reporte'] <> "" and $_POST['numUser'] > 0) {

                    $medico = " and (";
                    for ($i = 1; $i <= $_POST['numUser']; $i++) {
                        if ($_POST['u' . $i] <> "") $medico .= "hc_obste.med='" . $_POST['u' . $i] . "' OR ";
                    }
                    $medico .= "hc_obste.med='1')"; //es solo para cerrar la condicion y el OR no que vacio
                    $rango = "";
                    if ($_POST['ini'] <> "" and $_POST['fin'] <> "")
                        $rango = " and hc_obste.fec between '" . $_POST['ini'] . "' and '" . $_POST['fin'] . "'";

                    $rPaci = $db->prepare("SELECT ape,nom,hc_obste.dni,hc_obste.fec,hc_obste.med FROM hc_paciente,hc_obste WHERE hc_paciente.dni=hc_obste.dni " . $medico . $rango . " ORDER BY hc_obste.fec DESC");
                    $rPaci->execute();

                    if ($rPaci->rowCount() > 0) { ?>
                        <a href="#" id="exporta" data="<?php echo $_POST['reporte']; ?>" style="display:none;"
                           class="ui-btn ui-mini ui-btn-inline">Exportar a Excel</a>
                        <div class="scroll_h">
                            <table width="100%" bordercolor="#F0DF96" style="margin:0 auto;font-size:small;"
                                   class="table-stripe tablesorter">
                                <thead>
                                <tr class="ui-bar-b">
                                    <th bgcolor="#F0DF96"></th>
                                    <th>DNI (<span id="num_pro"></span> Consultas)</th>
                                    <th>APELLIDOS Y NOMBRES</th>
                                    <th>MEDICO</th>
                                    <th align="center">Fecha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $c = 0;
                                while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {

                                    $c++;

                                    echo '<tr bgcolor="#FFFFFF"><td>' . $c . '</td><td>' . $paci['dni'] . '</td><td class="mayuscula">' . $paci['ape'] . ' ' . $paci['nom'] . '</td><td>' . $paci['med'] . '</td><td>' . date("d-m-Y", strtotime($paci['fec'])) . '</td></tr>';

                                } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php }
                } ?>

            </form>
        </div><!-- /content -->

    </div><!-- /page -->
<?php } ?>
<script>
    $(function () {
        $('#num_pro').html(<?php echo $c; ?>);
        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>
</script>
</body>
</html>
