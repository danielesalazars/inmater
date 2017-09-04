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
<form action="lista_pro_f.php" method="post" data-ajax="false" id="form1">
    <div data-role="page" class="ui-responsive-panel" id="lista_pro_f">
        <?php $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
        $rUser->execute(array($login));
        $user = $rUser->fetch(PDO::FETCH_ASSOC);

        if ($user['role'] == 2)
            if ($_GET['todo'] == 1) $todo = ''; else $todo = ' LIMIT 50';
        $rPaci = $db->prepare("SELECT SUBSTRING_INDEX(lab_aspira.pro,'-',1) AS p1,SUBSTRING_INDEX(lab_aspira.pro,'-',-1) AS p2,hc_paciente.dni,ape,nom,san,m_ets,don,hc_reprod.p_dni,hc_reprod.p_dni_het,hc_reprod.p_od,hc_reprod.p_cic,hc_reprod.p_fiv,hc_reprod.p_icsi,hc_reprod.p_cri,hc_reprod.p_iiu,hc_reprod.p_don,hc_reprod.des_don,hc_reprod.des_dia,hc_reprod.pago_extras,hc_reprod.med,lab_aspira.pro,lab_aspira.tip,lab_aspira.vec,lab_aspira.dias,lab_aspira.fec FROM hc_antece,hc_paciente,lab_aspira,hc_reprod WHERE hc_paciente.dni = hc_antece.dni AND hc_paciente.dni=lab_aspira.dni AND hc_reprod.id=lab_aspira.rep AND lab_aspira.f_fin<>'0000-00-00' AND lab_aspira.tip<>'T' ORDER BY ABS(p2) DESC,ABS(p1) DESC".$todo);

        $rPaci->execute();
        ?>

        <style>
            .ui-dialog-contain {
                max-width: 100%;
                margin: 1% auto 1%;
                padding: 0;
                position: relative;
                top: -35px;
            }

            .mayuscula {
                text-transform: uppercase;
                font-size: small;
            }

            #cargador {
                color: Red;
            }
        </style>

        <div data-role="header" data-position="fixed">
            <a href="lista_pro.php" rel="external"
               class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Regresar</a>
            <h2>Protocolos Finalizados</h2>
            <a href="lista_pro_f.php?todo=1" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all">Ver
                Todo</a>
        </div><!-- /header -->

        <div class="ui-content" role="main">

            <input id="filtro" data-type="search" placeholder="Filtro..">
            <table data-role="table" data-filter="true" data-input="#filtro"
                   class="table-stripe ui-responsive mayuscula">
                <thead>
                <tr>
                    <th align="center" width="110">Protocolo</th>
                    <th align="center">Paciente</th>
                    <th align="center">Pareja</th>
                    <th align="center">Donante</th>
                    <th align="center">Médico</th>
                    <th align="center">Procedimiento</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {

                    $rPare = $db->prepare("SELECT p_nom,p_ape,p_san,p_m_ets FROM hc_pareja WHERE p_dni=?");
                    $rPare->execute(array($paci['p_dni']));
                    $pare = $rPare->fetch(PDO::FETCH_ASSOC);

                    if ($paci['p_dni'] == "") $pareja = "SOLTERA"; else $pareja = $pare['p_ape'] . " " . $pare['p_nom'];
                    //$paci['dias']= es el proximo dia por lo tanto se resta 1 para tener el dia actual:
                    if ($paci['dias'] > 0) {
                        $paci['dias'] = $paci['dias'] - 1;
                        $diaActual = 'Dia ' . $paci['dias'];
                    } else $diaActual = 'Dia 0'; ?>

                    <tr>
                        <th><a href='<?php echo "le_aspi" . $paci['dias'] . ".php?id=" . $paci['pro']; ?>'
                               rel="external"><?php echo $paci['tip'] . '-' . $paci['pro'] . '-' . $paci['vec']; ?></a><br><span
                                    style="font-size:10px"><?php echo date("d-m-Y", strtotime($paci['fec'])); ?></span>
                        </th>
                        <td><?php echo $paci['ape'] . ' ' . $paci['nom']; ?>
                            <?php if (strpos($paci['san'], "-") !== false) echo " <b>(SANGRE NEGATIVA) </b>";
                            if (strpos($paci['m_ets'], "VIH") !== false) echo " <b>(VIH) </b>";
                            if (strpos($paci['m_ets'], "Hepatitis C") !== false) echo " <b>(Hepatitis C) </b>"; ?>
                            <br><span style="font-size:10px"><a
                                        href="info_r.php?a=<?php echo $paci['pro'] . "&b=" . $paci['dni'] . "&c=" . $paci['p_dni']; ?>"
                                        target="new" style="color:#48F06A">info</a> <a
                                        href="info_rm.php?a=<?php echo $paci['pro'] . "&b=" . $paci['dni'] . "&c=" . $paci['p_dni']; ?>"
                                        target="new" style="color:#F4AFB1">medico</a></span></td>
                        <td><?php echo $pareja; ?>
                            <?php if (strpos($pare['p_san'], "-") !== false) echo " <b>(SANGRE NEGATIVA) </b>";
                            if (strpos($pare['p_m_ets'], "VIH") !== false) echo " <b>(VIH) </b>";
                            if (strpos($pare['p_m_ets'], "Hepatitis C") !== false) echo " <b>(Hepatitis C) </b>";
                            if ($paci['p_dni_het'] <> "") echo " <b>(HETEROLOGO) </b>"; ?></td>
                        <td><?php if ($paci['p_od'] <> '') {
                                $rDon = $db->prepare("SELECT dni,nom,ape FROM hc_paciente WHERE dni=?");
                                $rDon->execute(array($paci['p_od']));
                                $don = $rDon->fetch(PDO::FETCH_ASSOC);
                                echo $don['ape'] . " " . $don['nom'];
                            } else if ($paci['don'] == 'D') echo 'Si'; else echo 'No'; ?></td>
                        <td><?php echo $paci['med']; ?></td>
                        <td><?php //echo $diaActual; ?>
                            <?php if ($paci['p_cic'] >= 1) echo "Ciclo Natural<br>";
                            if ($paci['p_fiv'] >= 1) echo "FIV<br>";
                            if ($paci['p_icsi'] >= 1) echo "ICSI<br>";
                            if ($paci['p_od'] <> '') echo "OD Fresco<br>";
                            if ($paci['p_cri'] >= 1) echo "Crio Ovulos<br>";
                            if ($paci['p_iiu'] >= 1) echo "IIU<br>";
                            if ($paci['p_don'] == 1) echo "Donación Fresco<br>";
                            if ($paci['des_don'] == null and $paci['des_dia'] >= 1) echo "TED<br>";
                            if ($paci['des_don'] == null and $paci['des_dia'] === 0) echo "<small>Descongelación Ovulos Propios</small><br>";
                            if ($paci['des_don'] <> null and $paci['des_dia'] >= 1) echo "EMBRIOADOPCIÓN<br>";
                            if ($paci['des_don'] <> null and $paci['des_dia'] === 0) echo "<small>Descongelación Ovulos Donados</small><br>";
                            if (strpos($paci['pago_extras'], "EMBRYOSCOPE") !== false) { ?>
                                <small>EMBRIOSCOPE
                                <?php if (file_exists("emb_pic/embryoscope_" . $paci['pro'] . ".mp4"))
                                    echo "<a href='emb_pic/embryoscope_" . $paci['pro'] . ".mp4' target='new'>(Video)</a>";

                                if (file_exists("emb_pic/embryoscope_" . $paci['pro'] . ".pdf"))
                                    echo "<a href='emb_pic/embryoscope_" . $paci['pro'] . ".pdf' target='new'>(PDF)</a>"; ?>
                                </small>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div><!-- /content -->
        <div data-role="footer" data-position="fixed" id="footer" style="text-align:center;">
            Número de protocólos finalizados: <?php echo $rPaci->rowCount(); ?>
        </div><!-- /footer -->
    </div><!-- /page -->
</form>

</body>
</html>
