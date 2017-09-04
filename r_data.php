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

    </style>
</head>

<body>
<?php if ($login == 'lab') { ?>

    <div data-role="page" class="ui-responsive-panel">

        <div data-role="header">
            <div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
                <a href='lista.php' class="ui-btn ui-btn-c ui-icon-home ui-btn-icon-left" rel="external">Inicio</a>
            </div>
            <h1>DATA</h1>
            <a href="index.php"
               class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power"
               rel="external">Salir</a>
        </div><!-- /header -->

        <div class="ui-content" role="main">
            <form action="r_data.php" method="post" data-ajax="false" id="form1">
                <div class="enlinea">
                    Mostrar Desde<input name="ini" type="date" id="ini" value="<?php echo $_POST['ini']; ?>"
                                        data-mini="true" required>
                    Hasta<input name="fin" type="date" id="fin" value="<?php echo $_POST['fin']; ?>" data-mini="true"
                                required>
                    <input type="Submit" name="Mostrar" value="Mostrar" data-mini="true" data-theme="b"
                           data-inline="true"/>
                </div>
                <?php if ($_POST['Mostrar'] == 'Mostrar' and $_POST['ini'] <> "" and $_POST['fin'] <> "") { ?>
                    <div class="scroll_h">
                        <table style="margin:0 auto;text-align: center; border: 1px solid;" cellpadding="5">
                            <thead>
                            <tr>
                                <th colspan="5" bgcolor="#ffe4e1">Aspiración</th>
                                <th colspan="2" bgcolor="#ffe4c4">Inseminación</th>
                                <th colspan="2" bgcolor="#e6e6fa">Desarrollo embrionario Extras</th>
                                <th colspan="2" bgcolor="#f5f5dc">Crio preservación</th>
                                <th colspan="2" bgcolor="#add8e6">Transferencia</th>
                            </tr>
                            <tr align="center">
                                <td bgcolor="#ffe4e1">Paciente</td>
                                <td bgcolor="#ffe4e1">Donante</td>
                                <td bgcolor="#ffe4e1">Receptora</td>
                                <td bgcolor="#ffe4e1">Crio ovos Paciente</td>
                                <td bgcolor="#ffe4e1">Crio ovos Donante</td>
                                <td bgcolor="#ffe4c4">FIV</td>
                                <td bgcolor="#ffe4c4">ICSI</td>
                                <td bgcolor="#e6e6fa">NGS</td>
                                <td bgcolor="#e6e6fa">Embryoscope</td>
                                <td bgcolor="#f5f5dc">Ovulos</td>
                                <td bgcolor="#f5f5dc">Embriones</td>
                                <td bgcolor="#add8e6">Propios</td>
                                <td bgcolor="#add8e6">Embrioadopción</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $asp1 = $asp2 = $asp3 = $asp4 = $asp5 = $ins1 = $ins2 = $des1 = $des2 = $cri1 = $cri2 = $tra1 = $tra2 = 0;

                            $rPaci = $db->prepare("SELECT lab_aspira.tip,don_todo,p_cri,p_fiv,p_icsi,pago_extras FROM hc_reprod LEFT JOIN lab_aspira ON hc_reprod.id = lab_aspira.rep WHERE cancela=0 AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "'");
                            $rPaci->execute();
                            while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {
                                if ($paci['tip'] == 'P' and $paci['p_cri'] <> 1)
                                    $asp1++;
                                if (($paci['tip'] == 'D' or $paci['don_todo'] == 1) and $paci['p_cri'] <> 1)
                                    $asp2++;
                                if ($paci['tip'] == 'R')
                                    $asp3++;
                                if ($paci['tip'] == 'P' and $paci['p_cri'] == 1)
                                    $asp4++;
                                if ($paci['tip'] == 'D' and $paci['p_cri'] == 1)
                                    $asp5++;
                                if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and $paci['p_fiv'] == 1)
                                    $ins1++;
                                if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and $paci['p_icsi'] == 1)
                                    $ins2++;
                                if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and strpos($paci['pago_extras'], "NGS") !== false)
                                    $des1++;
                                if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and strpos($paci['pago_extras'], "EMBRYOSCOPE") !== false)
                                    $des2++;
                            }

                            $Rcri1 = $db->prepare("SELECT lab_aspira_dias.pro FROM lab_aspira_dias,lab_aspira WHERE lab_aspira_dias.pro=lab_aspira.pro AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "' AND d0f_cic='C' GROUP BY pro");
                            $Rcri1->execute();
                            $cri1 = $Rcri1->rowCount();
                            $Rcri2 = $db->prepare("SELECT lab_aspira_dias.pro FROM lab_aspira_dias,lab_aspira WHERE lab_aspira_dias.pro=lab_aspira.pro AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "' AND (d6f_cic='C' OR d5f_cic='C' OR d4f_cic='C' OR d3f_cic='C' OR d2f_cic='C') GROUP BY pro");
                            $Rcri2->execute();
                            $cri2 = $Rcri2->rowCount();

                            $rTra = $db->prepare("SELECT lab_aspira_T.pro,des_dia,des_don FROM hc_reprod,lab_aspira,lab_aspira_T WHERE lab_aspira_T.pro=lab_aspira.pro AND hc_reprod.id=lab_aspira.rep AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "'");
                            $rTra->execute();
                            while ($tra = $rTra->fetch(PDO::FETCH_ASSOC)) {
                                if ($tra['des_don'] <> null and $tra['des_dia'] >= 1) $tra2++; else $tra1++;
                            }

                            echo '<tr align="center"><td bgcolor="#ffe4e1">' . $asp1 . '</td><td bgcolor="#ffe4e1">' . $asp2 . '</td><td bgcolor="#ffe4e1">' . $asp3 . '</td><td bgcolor="#ffe4e1">' . $asp4 . '</td><td bgcolor="#ffe4e1">' . $asp5 . '</td><td bgcolor="#ffe4c4">' . $ins1 . '</td><td bgcolor="#ffe4c4">' . $ins2 . '</td><td bgcolor="#e6e6fa">' . $des1 . '</td><td bgcolor="#e6e6fa">' . $des2 . '</td><td bgcolor="#f5f5dc">' . $cri1 . '</td><td bgcolor="#f5f5dc">' . $cri2 . '</td><td bgcolor="#add8e6">' . $tra1 . '</td><td bgcolor="#add8e6">' . $tra2 . '</td></tr>';
                            ?>
                            <tr>
                                <td colspan="5" bgcolor="#ffe4e1"><?php echo $asp1 + $asp2 + $asp3 + $asp4 + $asp5; ?></td>
                                <td colspan="2" bgcolor="#ffe4c4"><?php echo $ins1 + $ins2; ?></td>
                                <td colspan="2" bgcolor="#e6e6fa"><?php echo $des1 + $des2; ?></td>
                                <td colspan="2" bgcolor="#f5f5dc"><?php echo $cri1 + $cri2; ?></td>
                                <td colspan="2" bgcolor="#add8e6"><?php echo $tra1 + $tra2; ?></td>
                            </tr>
                            </tbody>
                        </table><br/><br/>
                        <?php $rUser = $db->prepare("SELECT user,nom FROM usuario WHERE role=1");
                        $rUser->execute();
                        while ($user = $rUser->fetch(PDO::FETCH_ASSOC)) { ?>

                            <table style="margin:0 auto;text-align: center; border: 1px solid;" cellpadding="5">
                                <thead>
                                <tr><th colspan="13"><?php echo $user['nom']; ?></th></tr>
                                <tr>
                                    <th colspan="5" bgcolor="#ffe4e1">Aspiración</th>
                                    <th colspan="2" bgcolor="#ffe4c4">Inseminación</th>
                                    <th colspan="2" bgcolor="#e6e6fa">Desarrollo embrionario Extras</th>
                                    <th colspan="2" bgcolor="#f5f5dc">Crio preservación</th>
                                    <th colspan="2" bgcolor="#add8e6">Transferencia</th>
                                </tr>
                                <tr align="center">

                                    <td bgcolor="#ffe4e1">Paciente</td>
                                    <td bgcolor="#ffe4e1">Donante</td>
                                    <td bgcolor="#ffe4e1">Receptora</td>
                                    <td bgcolor="#ffe4e1">Crio ovos Paciente</td>
                                    <td bgcolor="#ffe4e1">Crio ovos Donante</td>
                                    <td bgcolor="#ffe4c4">FIV</td>
                                    <td bgcolor="#ffe4c4">ICSI</td>
                                    <td bgcolor="#e6e6fa">NGS</td>
                                    <td bgcolor="#e6e6fa">Embryoscope</td>
                                    <td bgcolor="#f5f5dc">Ovulos</td>
                                    <td bgcolor="#f5f5dc">Embriones</td>
                                    <td bgcolor="#add8e6">Propios</td>
                                    <td bgcolor="#add8e6">Embrioadopción</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $asp1 = $asp2 = $asp3 = $asp4 = $asp5 = $ins1 = $ins2 = $des1 = $des2 = $cri1 = $cri2 = $tra1 = $tra2 = 0;

                                $rPaci = $db->prepare("SELECT lab_aspira.tip,don_todo,p_cri,p_fiv,p_icsi,pago_extras FROM hc_reprod LEFT JOIN lab_aspira ON hc_reprod.id = lab_aspira.rep WHERE cancela=0 AND hc_reprod.med='".$user['user']."' AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "'");
                                $rPaci->execute();
                                while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {
                                    if ($paci['tip'] == 'P' and $paci['p_cri'] <> 1)
                                        $asp1++;
                                    if (($paci['tip'] == 'D' or $paci['don_todo'] == 1) and $paci['p_cri'] <> 1)
                                        $asp2++;
                                    if ($paci['tip'] == 'R')
                                        $asp3++;
                                    if ($paci['tip'] == 'P' and $paci['p_cri'] == 1)
                                        $asp4++;
                                    if ($paci['tip'] == 'D' and $paci['p_cri'] == 1)
                                        $asp5++;
                                    if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and $paci['p_fiv'] == 1)
                                        $ins1++;
                                    if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and $paci['p_icsi'] == 1)
                                        $ins2++;
                                    if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and strpos($paci['pago_extras'], "NGS") !== false)
                                        $des1++;
                                    if (($paci['tip'] == 'P' or $paci['tip'] == 'R') and strpos($paci['pago_extras'], "EMBRYOSCOPE") !== false)
                                        $des2++;
                                }

                                $Rcri1 = $db->prepare("SELECT lab_aspira_dias.pro FROM hc_reprod,lab_aspira_dias,lab_aspira WHERE lab_aspira_dias.pro=lab_aspira.pro AND hc_reprod.id=lab_aspira.rep AND hc_reprod.med='".$user['user']."' AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "' AND d0f_cic='C' GROUP BY pro");
                                $Rcri1->execute();
                                $cri1 = $Rcri1->rowCount();
                                $Rcri2 = $db->prepare("SELECT lab_aspira_dias.pro FROM hc_reprod,lab_aspira_dias,lab_aspira WHERE lab_aspira_dias.pro=lab_aspira.pro AND hc_reprod.id=lab_aspira.rep AND hc_reprod.med='".$user['user']."' AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "' AND (d6f_cic='C' OR d5f_cic='C' OR d4f_cic='C' OR d3f_cic='C' OR d2f_cic='C') GROUP BY pro");
                                $Rcri2->execute();
                                $cri2 = $Rcri2->rowCount();

                                $rTra = $db->prepare("SELECT lab_aspira_T.pro,des_dia,des_don FROM hc_reprod,lab_aspira,lab_aspira_T WHERE lab_aspira_T.pro=lab_aspira.pro AND hc_reprod.id=lab_aspira.rep AND hc_reprod.med='".$user['user']."' AND CONVERT(lab_aspira.fec,DATE) BETWEEN '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "'");
                                $rTra->execute();
                                while ($tra = $rTra->fetch(PDO::FETCH_ASSOC)) {
                                    if ($tra['des_don'] <> null and $tra['des_dia'] >= 1) $tra2++; else $tra1++;
                                }

                                echo '<tr align="center"><td bgcolor="#ffe4e1">' . $asp1 . '</td><td bgcolor="#ffe4e1">' . $asp2 . '</td><td bgcolor="#ffe4e1">' . $asp3 . '</td><td bgcolor="#ffe4e1">' . $asp4 . '</td><td bgcolor="#ffe4e1">' . $asp5 . '</td><td bgcolor="#ffe4c4">' . $ins1 . '</td><td bgcolor="#ffe4c4">' . $ins2 . '</td><td bgcolor="#e6e6fa">' . $des1 . '</td><td bgcolor="#e6e6fa">' . $des2 . '</td><td bgcolor="#f5f5dc">' . $cri1 . '</td><td bgcolor="#f5f5dc">' . $cri2 . '</td><td bgcolor="#add8e6">' . $tra1 . '</td><td bgcolor="#add8e6">' . $tra2 . '</td></tr>';
                                ?>
                                <tr>
                                    <td colspan="5"
                                        bgcolor="#ffe4e1"><?php echo $asp1 + $asp2 + $asp3 + $asp4 + $asp5; ?></td>
                                    <td colspan="2" bgcolor="#ffe4c4"><?php echo $ins1 + $ins2; ?></td>
                                    <td colspan="2" bgcolor="#e6e6fa"><?php echo $des1 + $des2; ?></td>
                                    <td colspan="2" bgcolor="#f5f5dc"><?php echo $cri1 + $cri2; ?></td>
                                    <td colspan="2" bgcolor="#add8e6"><?php echo $tra1 + $tra2; ?></td>
                                </tr>
                                </tbody>
                            </table><br/>

                        <?php } ?>
                    </div>
                <?php } ?>

            </form>
        </div><!-- /content -->

    </div><!-- /page -->
<?php } ?>
<script>
    $(function () {
        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>
</script>
</body>
</html>
