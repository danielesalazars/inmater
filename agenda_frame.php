<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $login = $_SESSION['login'];
    $dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
    if (!$login) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://" . $dir . "'>";
    } else {
        if ($_GET['med'] <> '') $login=$_GET['med'];
    require("_database/db_tools.php");
    } ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="_themes/tema_inmater.min.css"/>
    <link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css"/>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script>
    function anular(x) {
        document.form1.borrar.value = x;
        document.form1.submit();
    }
</script>
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="agenda_frame" data-dialog="true">
    <style>
        .ui-dialog-contain {
            max-width: 900px;
            margin: 1% auto 1%;
            padding: 0;
            position: relative;
            top: -35px;
        }

        #alerta {
            background-color: #FF9;
            margin: 0 auto;
            text-align: center;
            padding: 4px;
        }
    </style>
    <?php if ($_POST['btn_consulta'] == "AGENDAR" and isSet($_POST['med']) and isSet($_POST['fec']) and $_POST['ini_h']<>"" and $_POST['ini_m']<>"" and $_POST['fin_h']<>"" and $_POST['fin_m']<>"") {
        $ini = $_POST['ini_h'] . ':' . $_POST['ini_m'];
        $fin = $_POST['fin_h'] . ':' . $_POST['fin_m'];

        insertDisponi($_POST['med'], $_POST['fec'], $ini, $fin, $_POST['obs']);

    }
    if ($_POST['borrar'] <> "") {
        $stmt = $db->prepare("DELETE FROM hc_disponible WHERE id=?");
        $stmt->execute(array($_POST['borrar']));
    }
    ?>

    <div data-role="header" data-position="fixed">
        <a href="lista.php" rel="external" class="ui-btn">Cerrar</a>

        <h1>Agenda <?php echo '(' . $login . ')'; ?></h1>

    </div><!-- /header -->

    <div class="ui-content" role="main">
        <?php if ($login <> 'lab') {
            $rDisponi = $db->prepare("SELECT * FROM hc_disponible WHERE med=? ORDER BY fec DESC LIMIT 200");
            $rDisponi->execute(array($login)); ?>
            <FORM ACTION="agenda_frame.php?med=<?php echo $login; ?>" method="post" data-ajax="false" name="form1"
                  id="form1">
                <input type="hidden" name="borrar">
                <input type="hidden" name="med" value="<?php echo $login; ?>">
                <table width="100%" align="center" style="margin: 0 auto;">
                    <tr>
                        <th>Fecha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Comentarios <small>(Opcional)</small></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            <input name="fec" type="date" id="fec" data-mini="true" required>
                        </td>
                        <td>
                            <select name="ini_h" id="ini_h" data-mini="true" required>
                                <option value="">Hra</option>
                                <option value="07">07 hrs</option>
                                <option value="08">08 hrs</option>
                                <option value="09">09 hrs</option>
                                <option value="10">10 hrs</option>
                                <option value="11">11 hrs</option>
                                <option value="12">12 hrs</option>
                                <option value="13">13 hrs</option>
                                <option value="14">14 hrs</option>
                                <option value="15">15 hrs</option>
                                <option value="16">16 hrs</option>
                                <option value="17">17 hrs</option>
                                <option value="18">18 hrs</option>
                                <option value="19">19 hrs</option>
                            </select>
                            <select name="ini_m" id="ini_m" data-mini="true" required>
                                <option value="">Min</option>
                                <option value="00">00 min</option>
                                <option value="15">15 min</option>
                                <option value="30">30 min</option>
                                <option value="45">45 min</option>
                            </select>
                        </td>
                        <td>
                            <select name="fin_h" id="fin_h" data-mini="true" required>
                                <option value="">Hra</option>
                                <option value="08">08 hrs</option>
                                <option value="09">09 hrs</option>
                                <option value="10">10 hrs</option>
                                <option value="11">11 hrs</option>
                                <option value="12">12 hrs</option>
                                <option value="13">13 hrs</option>
                                <option value="14">14 hrs</option>
                                <option value="15">15 hrs</option>
                                <option value="16">16 hrs</option>
                                <option value="17">17 hrs</option>
                                <option value="18">18 hrs</option>
                                <option value="19">19 hrs</option>
                                <option value="20">20 hrs</option>
                            </select>
                            <select name="fin_m" id="fin_m" data-mini="true" required>
                                <option value="">Min</option>
                                <option value="00">00 min</option>
                                <option value="15">15 min</option>
                                <option value="30">30 min</option>
                                <option value="45">45 min</option>
                            </select>
                        </td>
                        <td>
                            <input name="obs" type="text" id="obs" maxlength="50" data-mini="true">
                        </td>
                        <td>
                            <input type="Submit" value="AGENDAR" name="btn_consulta" data-icon="check" data-mini="true"
                                   data-theme="b" data-inline="true"/>
                        </td>
                        <td>
                            <a href="#historial" data-rel="popup" data-transition="pop">Borrar</a>
                            <div data-role="popup" id="historial" class="ui-content">
                                <table width="100%" align="center" style="margin: 0 auto; font-size: small;">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Comentarios</th>
                                        <th></th>
                                    </tr>
                                    <?php while ($dispo = $rDisponi->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?php echo date("d-m-Y", strtotime($dispo['fec'])); ?></td>
                                            <td><?php echo $dispo['ini']; ?></td>
                                            <td><?php echo $dispo['fin']; ?></td>
                                            <td><?php echo $dispo['obs']; ?></td>
                                            <td><a href="javascript:anular(<?php echo $dispo["id"]; ?>);">Borrar</a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </FORM>

        <?php } ?>

        <iframe src="agenda.php?med=<?php echo $_GET['med']; ?>" width="100%" height="800" seamless></iframe>
    </div><!-- /content -->
    <script>
        $(function () {

            $('#alerta').delay(3000).fadeOut('slow');

        });//]]>

    </script>
</div><!-- /page -->

</body>

</html>