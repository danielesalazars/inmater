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
    <script src="jstickytableheaders.js"></script>
    <style>
        .controlgroup-textinput {
            padding-top: .10em;
            padding-bottom: .10em;
        }

        .enlinea div {
            display: inline-block;
            vertical-align: middle;
        }

        #ser {
            font-size: 12px;
        }
    </style>
</head>

<body>
<div data-role="page" class="ui-responsive-panel" id="r_inv_ngs" data-dialog="true">
    <script>
        $(document).ready(function () {

            $(".table-stripe").stickyTableHeaders(); // Cabecera flotante o fija en la tabla
        });

    </script>
    <?php $rPare = $db->prepare("SELECT nom,ape,lab_aspira_dias.pro,lab_aspira_dias.ovo,ngs1,ngs3,beta,lab_aspira_T.med,lab_aspira.f_fin FROM hc_paciente,lab_aspira,lab_aspira_dias,lab_aspira_T WHERE hc_paciente.dni=lab_aspira.dni and lab_aspira.pro=lab_aspira_dias.pro and lab_aspira_T.pro=lab_aspira_dias.pro and lab_aspira_dias.ngs1>0 ORDER BY lab_aspira.fec DESC");
    $rPare->execute(); ?>
    <style>
        .ui-dialog-contain {
            max-width: 1200px;
            margin: 1% auto 1%;
            padding: 0;
            position: relative;
            top: -5px;
        }

        .peke2 .ui-input-text {
            width: 60px !important;
        }

    </style>

    <div data-role="header">
        <a href="lista.php" rel="external"
           class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
        <h3>INVESTIGACION: NGS</h3>
    </div><!-- /header -->

    <div class="ui-content" role="main">

        <form action="r_inv_ngs.php" method="post" data-ajax="false" id="form2">

            <input id="filtro" data-type="search" placeholder="Filtro..">
            <table width="100%" class="table-stripe" style="font-size: small" data-filter="true" data-input="#filtro">
                <thead>
                <tr class="ui-bar-b">
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>PROTOCOLO</th>
                    <th>ID EMBRION</th>
                    <th>NGS</th>
                    <th>BETA</th>
                    <th>MEDICO</th>
                    <th>FECHA</th>
                </tr>
                </thead>
                <tbody>

                <?php while ($pare = $rPare->fetch(PDO::FETCH_ASSOC)) {
                    if($pare['beta']==0) $beta='Pendiente';
                    if($pare['beta']==1) $beta='Positivo';
                    if($pare['beta']==2) $beta='Negativo';
                    if($pare['beta']==3) $beta='Bioquimico';
                    if($pare['beta']==4) $beta='Aborto';
                    if ($pare['ngs1'] == 1) $ngs = 'Normal';
                    if ($pare['ngs1'] == 2) $ngs = '<font color="red">Anormal</font>';
                    if ($pare['ngs1'] == 3) $ngs = 'NR';
                    if ($pare['ngs3'] == 1) $ngs3 = ' (H)';
                    if ($pare['ngs3'] == 2) $ngs3 = ' (M)';

                        echo '<tr>';
                        echo '<td>'.$pare['ape'].' '.$pare['nom'].'</td>';
                        echo '<td align="center">'.$pare['pro'].'</td>';
                        echo '<td align="center">'.$pare['ovo'].'</td>';
                        echo '<td>'.$ngs.$ngs3.'</td>';
                        echo '<td>'.$beta.'</td>';
                    echo '<td>'.$pare['med'].'</td>';
                    echo '<td>'.date("d-m-Y", strtotime($pare['f_fin'])).'</td>';
                        echo '</tr>';

                } ?>
                </tbody>
            </table>
        </form>

    </div><!-- /content -->

</div><!-- /page -->

</body>
</html>