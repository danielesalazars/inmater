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

<div data-role="page" class="ui-responsive-panel" id="e_repro_info" data-dialog="true">

    <?php if ($_POST['dni'] <> "" and $_POST['pro']) {
        $c = $_POST['pn2'] + 10;
        for ($i = 1; $i <= $c; $i++) {
            $ids = $ids . "|" . $_POST['id_' . $i];
            $d2 = $d2 . "|" . $_POST['d2_' . $i];
            $d3 = $d3 . "|" . $_POST['d3_' . $i];
            $d4 = $d4 . "|" . $_POST['d4_' . $i];
            $d5 = $d5 . "|" . $_POST['d5_' . $i];
            $d6 = $d6 . "|" . $_POST['d6_' . $i];
            $d7 = $d7 . "|" . $_POST['d7_' . $i];
            $biopsi = $biopsi . "|" . $_POST['bio_' . $i];
            $finout = $finout . "|" . $_POST['fin_' . $i];
        }
        if ($_POST['c_T']) $c_T = $_POST['c_T']; else $c_T = '';
        if ($_POST['c_C']) $c_C = $_POST['c_C']; else $c_C = '';

        if ($_POST['h_tra'] <> '') {
            google_cal('Transferencia: ' . $_POST['nombre'] . ' (' . $login . ')', 'Transferencia INMATER', $_POST['f_tra'] . 'T' . $_POST['h_tra'] . ':00.000-05:00', 'bovcnii8fc3jharfgm31veg3vg@group.calendar.google.com');
        }
        updateRepro_info($_POST['pro_info'], $_POST['dni'], $_POST['pro'], $_POST['rep'], $_POST['nom_pro'], $_POST['n_ovo'], $_POST['nof'], $_POST['ins'], $_POST['pn2'], $_POST['pn3'], $_POST['inm'], $_POST['atr'], $_POST['ct'], $ids, $d2, $d3, $d4, $d5, $d6, $d7, $c_T, $c_C, $biopsi, $finout, $_POST['obs'], $_POST['f_tra'], $_POST['h_tra']);
    }

    if ($_GET['a'] <> "" and $_GET['b'] <> "") {

        $pro = $_GET['a'];
        $dni = $_GET['b'];
        $rep = $_GET['c'];

        $rPaci = $db->prepare("SELECT nom,ape FROM hc_paciente WHERE dni=?");
        $rPaci->execute(array($dni));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);

        $Repro = $db->prepare("SELECT f_tra,h_tra,des_dia,des_don,f_iny,p_cri FROM hc_reprod WHERE id=?");
        $Repro->execute(array($rep));
        $repro = $Repro->fetch(PDO::FETCH_ASSOC);

        $Rpop = $db->prepare("SELECT * FROM lab_aspira WHERE pro=?");
        $Rpop->execute(array($pro));
        $pop = $Rpop->fetch(PDO::FETCH_ASSOC);

        $Info = $db->prepare("SELECT * FROM hc_reprod_info WHERE pro=?");
        $Info->execute(array($pro));
        $info = $Info->fetch(PDO::FETCH_ASSOC);
        ?>
        <style>
            .ui-dialog-contain {
                max-width: 1000px;
                margin: 1% auto 1%;
                padding: 0;
                position: relative;
                top: -35px;
            }

            .tabla table {
                border-collapse: collapse;
            }

            .tabla table, .tabla th, .tabla td {
                border: 1px solid #72a2aa;
            }

            .peke2 .ui-input-text {
                width: 100px !important;
            }

            .peke .ui-input-text {
                width: 140px !important;

            }

            .enlinea div {
                display: inline-block;
                vertical-align: middle;
            }
        </style>
        <script>
            $(document).ready(function () {
                $(".fectra").hide();

                $("#FecTra").change(function () {
                    if ($(this).prop('checked')) {
                        $("#f_tra,#h_tra").prop('required', true);
                        $(".fectra").show();
                    } else {
                        $("#f_tra").val('0000-00-00');
                        $("#h_tra").val('');
                        $("#f_tra,#h_tra").prop('required', false);
                        $(".fectra").hide();
                    }
                });

            });
        </script>


        <script>
            $(document).ready(function () {
                <?php if ($repro['h_tra'] <> '' or $repro['des_dia'] >= 1) { ?>
                $("#f_tra,#h_tra").prop('required', true);
                $(".fectra").show();
                <?php } if ($pop['dias'] <= 1) { ?>
                $(".Fecunda").hide();
                <?php } ?>
            });
        </script>
    <?php if ($repro['des_dia'] >= 1) // si es TED o embrioadpocion
        $N_OVOS = 'Embriones Desvitrificados:';
    else if ($repro['des_dia'] === 0) // si es Descongelacion Ovos
        $N_OVOS = 'Óvulos Desvitrificados:';
    else
        $N_OVOS = 'Óvulos Aspirados:';
    ?>
        <div data-role="header" data-position="fixed">
            <h3><?php echo $paci['ape'] . ' ' . $paci['nom']; ?></h3>
        </div><!-- /header -->

        <div class="ui-content" role="main">

            <form action="e_repro_info.php" method="post" data-ajax="false" name="form2">
                <input type="hidden" name="nombre" value="<?php echo $paci['ape'] . " " . $paci['nom']; ?>">
                <input type="hidden" name="rep" value="<?php echo $rep; ?>">
                <input type="hidden" name="dni" value="<?php echo $dni; ?>">
                <input type="hidden" name="pro" value="<?php echo $pro; ?>">
                <input type="hidden" name="pro_info" value="<?php echo $info['pro']; ?>">
                <table width="100%" align="center" style="margin: 0 auto;">
                    <tr>
                        <td width="17%"><strong><?php echo $N_OVOS; ?></strong></td>
                        <td width="12%" class="peke2"><input name="n_ovo" type="text" id="n_ovo" data-mini="true"
                                                             value="<?php if ($info['n_ovo'] <> "") echo $info['n_ovo']; else echo $pop['n_ovo']; ?>">
                        </td>
                        <td width="30%" align="right">Cambiar el nombre Procedimiento</td>
                        <td width="41%" align="right"><input name="nom_pro" type="text" id="nom_pro" data-mini="true"
                                                             placeholder="Dejar en blanco si desea mantener el Nombre Original"
                                                             value="<?php if ($info['nom_pro'] <> "") echo $info['nom_pro']; ?>">
                        </td>
                    </tr>
                </table>


                <?php if ($repro['p_cri'] >= 1) { //-----------------------------------Inicio de Crio Ovos -----------------------------------------------

                    $rAspi = $db->prepare("SELECT ovo,d0est FROM lab_aspira_dias WHERE pro=? ORDER by ovo ASC");
                    $rAspi->execute(array($pro));
                    $vitri = 0;
                    $m1 = 0;
                    $vg = 0;
                    $atr = 0;
                    while ($asp = $rAspi->fetch(PDO::FETCH_ASSOC)) {
                        if ($asp['d0est'] == 'MII') $vitri++; // Para crio ovos MII es Numero de Vitrificados
                        if ($asp['d0est'] == 'MI') $m1++;
                        if ($asp['d0est'] == 'VG') $vg++;
                        if ($asp['d0est'] == 'ATR') $atr++;
                    }
                    if ($info['nof'] <> "") $vitri = $info['nof'];
                    if ($info['pn2'] <> "") $m1 = $info['pn2'];
                    if ($info['pn3'] <> "") $vg = $info['pn3'];
                    if ($info['atr'] <> "") $atr = $info['atr'];

                    $html .= '<h4>DETALLE DE ÓVULOS</h4><blockquote><table style="text-align:center;" class="peke2">
<tr>
<th width="200" align="left">Vitrificados</th><td><input name="nof" type="text" data-mini="true" value="' . $vitri . '"></td>
</tr>
<tr>
<th align="left">MI</th><td><input name="pn2" type="text" data-mini="true" value="' . $m1 . '"></td>
</tr>
<tr>
<th align="left">VG</th><td><input name="pn3" type="text" data-mini="true" value="' . $vg . '"></td>
</tr>
<tr>
<th align="left">Atresicos</th><td><input name="atr" type="text" data-mini="true" value="' . $atr . '"></td>
</tr>
</table>
<input name="inm" type="hidden" data-mini="true" value="">
<input name="ins" type="hidden" data-mini="true" value="">
<input name="ct" type="hidden" data-mini="true" value="">
</blockquote>';
                }

                if ($pop['dias'] > 1) { //-----------------------------------Inicio de Fecundacion y desarrollo -----------------------------------------------
                    $html = '';
                    $ids = explode("|", $info['ids']);
                    $d2 = explode("|", $info['d2']);
                    $d3 = explode("|", $info['d3']);
                    $d4 = explode("|", $info['d4']);
                    $d5 = explode("|", $info['d5']);
                    $d6 = explode("|", $info['d6']);
                    $d7 = explode("|", $info['d7']);
                    $biopsi = explode("|", $info['bio']);
                    $finout = explode("|", $info['fin']);

                    $rAspi = $db->prepare("SELECT * FROM lab_aspira_dias WHERE pro=? ORDER by ovo ASC");
                    $rAspi->execute(array($pro));
                    $eval = '';
                    $c_C = 0;
                    $c_T = 0;
                    $no_fec = 0;
                    $pn2 = 0;
                    $pn3 = 0;
                    $inma = 0;
                    $atre = 0;
                    $ct = 0;
                    $c = 0;
                    while ($asp = $rAspi->fetch(PDO::FETCH_ASSOC)) {
//Fecundados: MII y OBS
                        if ($asp['d1est'] == 'MII' and $asp['d1f_cic'] == 'O' and $asp['d1c_pol'] == '2' and $asp['d1pron'] == '2') $pn2++;
//NO Fecundados: MII y NV
                        if ($asp['d1est'] == 'MII' and $asp['d1f_cic'] == 'N' and (($asp['d1c_pol'] == '0' or $asp['d1c_pol'] == '1' or $asp['d1c_pol'] == '2') and ($asp['d1pron'] == '0' or $asp['d1pron'] == '1' or $asp['d1pron'] == '2'))) $no_fec++;
//Triploides / multinucleado: MII y NV y ademas cp y pn mayor q 2 
                        if ($asp['d1est'] == 'MII' and $asp['d1f_cic'] == 'N' and (($asp['d1c_pol'] == '3' or $asp['d1c_pol'] == '4' or $asp['d1c_pol'] == 'mult' or $asp['d1pron'] == '3' or $asp['d1pron'] == '4' or $asp['d1pron'] == 'mult'))) $pn3++;
//Inmaduros: MI o VG
                        if ($asp['d1est'] == 'VG' or $asp['d1est'] == 'MI' or $asp['d0est'] == 'VG' or $asp['d0est'] == 'MI') $inma++;
//Atresicos: ATR
                        if ($asp['d1est'] == 'ATR' or $asp['d0est'] == 'ATR') $atre++;
//Citolizados: CT
                        if ($asp['d1est'] == 'CT' or $asp['d0est'] == 'CT') $ct++;

                        if (($asp['d1f_cic'] == 'O' or $pop['tip'] == 'T' or $repro['des_dia'] >= 1) and $pop['dias'] >= 3) { // todos los ovos q pasan el dia 1 entran a la evaluacion del desarrollo
                            $c++;
                            $bio = 'No';
                            $fin = '';
                            if ($ids[$c] <> "") $IDS = $ids[$c];
                            else {
                                if (is_null($repro['des_don']) and !is_null($repro['des_dia'])) // si es TED o desc Ovulos muestra el id original
                                    $IDS = $asp['ovo_c'];
                                else
                                    $IDS = $asp['ovo'];
                            }
                            $eval .= '<tr><td><input name="id_' . $c . '" type="number" min="0" data-mini="true" value="' . $IDS . '"></td>';

                            if ($pop['dias'] >= 3) {
                                if ($asp['d2f_cic'] == 'C') {
                                    $c_C++;
                                    $fin = 'CRIO';
                                }
                                if ($asp['d2f_cic'] == 'T') {
                                    $c_T++;
                                    $fin = 'Transferido';
                                }
                                if ($asp['d2f_cic'] == 'N') $fin = 'NV';
                                if ($asp['d2f_cic'] <> '') {
                                    if ($d2[$c] <> "") $D2 = $d2[$c]; else $D2 = $asp['d2cel'] . '-' . $asp['d2fra'] . '%-' . $asp['d2sim'];
                                    $eval .= '<td><input name="d2_' . $c . '" type="text" data-mini="true" value="' . $D2 . '"></td>';
                                } else $eval .= '<td>-</td>';
                            }
                            if ($pop['dias'] >= 4) {
                                if ($asp['d3f_cic'] == 'C') {
                                    $c_C++;
                                    $fin = 'CRIO';
                                }
                                if ($asp['d3f_cic'] == 'T') {
                                    $c_T++;
                                    $fin = 'Transferido';
                                }
                                if ($asp['d3f_cic'] == 'N') $fin = 'NV';
                                if ($asp['d3f_cic'] <> '') {
                                    if ($asp['d3c_bio'] > 0) $bio = 'Si';
                                    if ($d3[$c] <> "") $D3 = $d3[$c]; else $D3 = $asp['d3cel'] . '-' . $asp['d3fra'] . '%-' . $asp['d3sim'];
                                    $eval .= '<td><input name="d3_' . $c . '" type="text" data-mini="true" value="' . $D3 . '"></td>';
                                } else $eval .= '<td>-</td>';
                            }
                            if ($pop['dias'] >= 5) {
                                if ($asp['d4f_cic'] == 'C') {
                                    $c_C++;
                                    $fin = 'CRIO';
                                }
                                if ($asp['d4f_cic'] == 'T') {
                                    $c_T++;
                                    $fin = 'Transferido';
                                }
                                if ($asp['d4f_cic'] == 'N') $fin = 'NV';
                                if ($asp['d4f_cic'] <> '') {
                                    if ($d4[$c] <> "") $D4 = $d4[$c]; else $D4 = $asp['d4cel'] . '-' . $asp['d4fra'] . '%-' . $asp['d4sim'];
                                    $eval .= '<td><input name="d4_' . $c . '" type="text" data-mini="true" value="' . $D4 . '"></td>';
                                } else $eval .= '<td>-</td>';
                            }
                            if ($pop['dias'] >= 6) {
                                if ($asp['d5f_cic'] == 'C') {
                                    $c_C++;
                                    $fin = 'CRIO';
                                }
                                if ($asp['d5f_cic'] == 'T') {
                                    $c_T++;
                                    $fin = 'Transferido';
                                }
                                if ($asp['d5f_cic'] == 'N') $fin = 'NV';
                                if ($asp['d5f_cic'] <> '') {
                                    if ($asp['d5d_bio'] == 1) $bio = 'Si';
                                    if ($d5[$c] <> "") $D5 = $d5[$c]; else {
                                        if ($asp['d5cel']=='BC' or $asp['d5cel']=='BE' or $asp['d5cel']=='BHI' or $asp['d5cel']=='BH')
                                            $D5 = $asp['d5cel'] . '-' . $asp['d5mci'] . '-' . $asp['d5tro'];
                                        else
                                            $D5 = $asp['d5cel'];
                                    }
                                    $eval .= '<td><input name="d5_' . $c . '" type="text" data-mini="true" value="' . $D5 . '"></td>';
                                } else $eval .= '<td>-</td>';
                            }
                            if ($pop['dias'] >= 7) {
                                if ($asp['d6f_cic'] == 'C') {
                                    $c_C++;
                                    $fin = 'CRIO';
                                }
                                if ($asp['d6f_cic'] == 'T') {
                                    $c_T++;
                                    $fin = 'Transferido';
                                }
                                if ($asp['d6f_cic'] == 'N') $fin = 'NV';
                                if ($asp['d6f_cic'] <> '') {
                                    if ($asp['d6d_bio'] == 1) $bio = 'Si';
                                    if ($d6[$c] <> "") $D6 = $d6[$c]; else {
                                        if ($asp['d6cel']=='BC' or $asp['d6cel']=='BE' or $asp['d6cel']=='BHI' or $asp['d6cel']=='BH')
                                            $D6 = $asp['d6cel'] . '-' . $asp['d6mci'] . '-' . $asp['d6tro'];
                                        else
                                            $D6 = $asp['d6cel'];
                                    }
                                    $eval .= '<td><input name="d6_' . $c . '" type="text" data-mini="true" value="' . $D6 . '"></td>';
                                } else $eval .= '<td>-</td>';
                                $eval .= '<td><input name="d7_' . $c . '" type="text" data-mini="true" value="' . $d7[$c] . '"></td>';
                            }

                            if ($biopsi[$c] <> "") $BIO = $biopsi[$c]; else $BIO = $bio;
                            if ($finout[$c] <> "") $FIN = $finout[$c]; else {
                                if ($fin == 'CRIO') $tanque = ' (' . $asp['T'] . '-' . $asp['C'] . '-' . $asp['G'] . '-' . $asp['P'] . ')'; else $tanque = '';
                                $FIN = $fin . $tanque;
                            }
                            $eval .= '<td><input name="bio_' . $c . '" type="text" data-mini="true" value="' . $BIO . '"></td>';
                            $eval .= '<td><textarea name="fin_' . $c . '" data-mini="true">' . $FIN . '</textarea></td></tr>';
                        }
                    }

                    if ((is_null($repro['des_dia']) or $repro['des_dia'] === 0) and $pop['tip'] <> 'T') { // Para todos menos para descongelacion de embriones (des_dia>1) y Traslado

                        if ($info['ins'] <> "") $n_ins = $info['ins']; else {
                            if ($pop['n_ins'] == 0) $n_ins = $pop['n_ovo']; else $n_ins = $pop['n_ins'];
                        }
                        if ($info['nof'] <> "") $no_fec = $info['nof'];
                        if ($info['pn2'] <> "") $pn2 = $info['pn2'];
                        if ($info['pn3'] <> "") $pn3 = $info['pn3'];
                        if ($info['inm'] <> "") $inma = $info['inm'];
                        if ($info['atr'] <> "") $atre = $info['atr'];
                        if ($info['ct'] <> "") $ct = $info['ct'];

                        $html .= '<h4>INSEMINACIÓN</h4><div class="tabla"><table style="text-align:center;margin: 0 auto;" class="peke2">
<tr><th>Inseminados</th><th>Fecundados</th><th>No Fecundados</th><th>Triploides/Multinucleado</th><th>Inmaduros</th><th>Atresicos</th><th>Citolizados</th></tr><tr><td><input name="ins" type="text" data-mini="true" value="' . $n_ins . '"></td><td><input name="pn2" type="text" data-mini="true" value="' . $pn2 . '"></td><td><input name="nof" type="text" data-mini="true" value="' . $no_fec . '"></td><td><input name="pn3" type="text" data-mini="true" value="' . $pn3 . '"></td><td><input name="inm" type="text" data-mini="true" value="' . $inma . '"></td><td><input name="atr" type="text" data-mini="true" value="' . $atre . '"></td><td><input name="ct" type="text" data-mini="true" value="' . $ct . '"></td></tr></table></div>';
                    }

                    if ($pop['dias'] >= 3) {

                        $eval_extra = '';
                        for ($i = 1; $i <= 10; $i++) {    //hasta 10 embriones extras
                            $eval_extra .= '<tr><td><input name="id_' . ($c + $i) . '" type="number" min="0" data-mini="true" value="' . $ids[$c + $i] . '"></td>';
                            if ($pop['dias'] >= 3) $eval_extra .= '<td><input name="d2_' . ($c + $i) . '" type="text" data-mini="true" value="' . $d2[$c + $i] . '"></td>';
                            if ($pop['dias'] >= 4) $eval_extra .= '<td><input name="d3_' . ($c + $i) . '" type="text" data-mini="true" value="' . $d3[$c + $i] . '"></td>';
                            if ($pop['dias'] >= 5) $eval_extra .= '<td><input name="d4_' . ($c + $i) . '" type="text" data-mini="true" value="' . $d4[$c + $i] . '"></td>';
                            if ($pop['dias'] >= 6) $eval_extra .= '<td><input name="d5_' . ($c + $i) . '" type="text" data-mini="true" value="' . $d5[$c + $i] . '"></td>';
                            if ($pop['dias'] >= 7) $eval_extra .= '<td><input name="d6_' . ($c + $i) . '" type="text" data-mini="true" value="' . $d6[$c + $i] . '"></td><td><input name="d7_' . ($c + $i) . '" type="text" data-mini="true" value="' . $d7[$c + $i] . '"></td>';
                            $eval_extra .= '<td><input name="bio_' . ($c + $i) . '" type="text" data-mini="true" value="' . $biopsi[$c + $i] . '"></td>';
                            $eval_extra .= '<td><input name="fin_' . ($c + $i) . '" type="text" data-mini="true" value="' . $finout[$c + $i] . '"></td></tr>';
                        }
                        if ($pop['fec2'] == '0000-00-00') $fec2 = '-'; else $fec2 = date("d/m", strtotime($pop['fec2']));
                        if ($pop['fec3'] == '0000-00-00') $fec3 = '-'; else $fec3 = date("d/m", strtotime($pop['fec3']));
                        if ($pop['fec4'] == '0000-00-00') $fec4 = '-'; else $fec4 = date("d/m", strtotime($pop['fec4']));
                        if ($pop['fec5'] == '0000-00-00') $fec5 = '-'; else $fec5 = date("d/m", strtotime($pop['fec5']));
                        if ($pop['fec6'] == '0000-00-00') $fec6 = '-'; else { $fec6 = date("d/m", strtotime($pop['fec6'])); $fec7=date('d/m', strtotime($pop['fec6'] . ' + 1 days'));;}

                        $html .= '<h4>EVALUACIÓN DEL DESARROLLO</h4><blockquote class="tabla"><table cellpadding="5" style="text-align:center;">';
                        if ($pop['dias'] == 3)
                            $head_eval = '<th>DIA 2</th><th rowspan="2">Biopsia</th><th rowspan="2">OUT</th></tr><tr><td>' . $fec2 . '</td></tr>';
                        if ($pop['dias'] == 4)
                            $head_eval = '<th>DIA 2</th><th>DIA 3</th><th rowspan="2">Biopsia</th><th rowspan="2">OUT</th></tr><tr><td>' . $fec2 . '</td><td>' . $fec3 . '</td></tr>';
                        if ($pop['dias'] == 5)
                            $head_eval = '<th>DIA 2</th><th>DIA 3</th><th>DIA 4</th><th rowspan="2">Biopsia</th><th rowspan="2">OUT</th></tr><tr><td>' . $fec2 . '</td><td>' . $fec3 . '</td><td>' . $fec4 . '</td></tr>';
                        if ($pop['dias'] == 6)
                            $head_eval = '<th>DIA 2</th><th>DIA 3</th><th>DIA 4</th><th>DIA 5</th><th rowspan="2">Biopsia</th><th rowspan="2">OUT</th></tr><tr><td>' . $fec2 . '</td><td>' . $fec3 . '</td><td>' . $fec4 . '</td><td>' . $fec5 . '</td></tr>';
                        if ($pop['dias'] == 7)
                            $head_eval = '<th>DIA 2</th><th>DIA 3</th><th>DIA 4</th><th>DIA 5</th><th>DIA 6</th><th>DIA 7</th><th rowspan="2">Biopsia</th><th rowspan="2">OUT</th></tr><tr><td>' . $fec2 . '</td><td>' . $fec3 . '</td><td>' . $fec4 . '</td><td>' . $fec5 . '</td><td>' . $fec6 . '</td><td>' . $fec7 . '</td></tr>';

                        if ($info['c_T'] <> "") $c_T = $info['c_T'];
                        if ($info['c_C'] <> "") $c_C = $info['c_C'];

                        $html .= '<tr><th rowspan="2">ID<br>Embrión</th>' . $head_eval . $eval . $eval_extra . '</table><div class="enlinea" style="text-align:center;margin: 0 auto;">Total Transferidos: <input name="c_T" type="text" data-mini="true" value="' . $c_T . '"> &nbsp;&nbsp;&nbsp;Total Criopreservados: <input name="c_C" type="text" data-mini="true" value="' . $c_C . '"></div>';
                    }
                } //--------------------Fin de Fecundacion y desarrollo -----------------------------------------------------------------------------------

                if ($info['obs'] <> "") $obs = $info['obs']; else $obs = $pop['obs'];
                $html .= 'CONCLUSIONES<textarea name="obs" data-mini="true">' . $obs . '</textarea>';
                echo $html;
                ?>
                <div class="Fecunda" style="background-color:#F7F6D6;">
                    <label for="FecTra">Definir Fecha de TRANSFERENCIA</label>
                    <input type="checkbox" name="FecTra" id="FecTra" data-mini="true" data-inline="true"
                           value=1 <?php if ($repro['h_tra'] <> '' or $repro['des_dia'] >= 1) echo "checked"; ?>>
                    <div class="fectra enlinea peke">
                        Seleccione la fecha:
                        <input type="date" name="f_tra" id="f_tra"
                               value="<?php if ($repro['f_tra'] == '0000-00-00' and $repro['des_dia'] >= 1) echo $repro['f_iny']; else echo $repro['f_tra']; ?>"
                               data-mini="true">
                        <select name="h_tra" id="h_tra" data-mini="true">
                            <option value="">Hora</option>
                            <option value="10:15" <?php if ($repro['h_tra'] == "10:15") echo "selected"; ?>>10:15 hrs
                            </option>
                            <option value="11:00" <?php if ($repro['h_tra'] == "11:00") echo "selected"; ?>>11:00 hrs
                            </option>
                            <option value="11:45" <?php if ($repro['h_tra'] == "11:45") echo "selected"; ?>>11:45 hrs
                            </option>
                            <option value="12:30" <?php if ($repro['h_tra'] == "12:30") echo "selected"; ?>>12:30 hrs
                            </option>
                            <option value="13:15" <?php if ($repro['h_tra'] == "13:15") echo "selected"; ?>>13:15 hrs
                            </option>
                            <option value="14:00" <?php if ($repro['h_tra'] == "14:00") echo "selected"; ?>>14:00 hrs
                            </option>
                            <option value="14:45" <?php if ($repro['h_tra'] == "14:45") echo "selected"; ?>>14:45 hrs
                            </option>
                            <option value="15:30" <?php if ($repro['h_tra'] == "15:30") echo "selected"; ?>>15:30 hrs
                            </option>
                            <option value="16:15" <?php if ($repro['h_tra'] == "16:15") echo "selected"; ?>>16:15 hrs
                            </option>
                            <option value="17:00" <?php if ($repro['h_tra'] == "17:00") echo "selected"; ?>>17:00 hrs
                            </option>
                            <option value="17:45" <?php if ($repro['h_tra'] == "17:45") echo "selected"; ?>>17:45 hrs
                            </option>
                            <option value="18:30" <?php if ($repro['h_tra'] == "18:30") echo "selected"; ?>>18:30 hrs
                            </option>
                            <option value="19:15" <?php if ($repro['h_tra'] == "19:15") echo "selected"; ?>>19:15 hrs
                            </option>
                            <option value="20:00" <?php if ($repro['h_tra'] == "20:00") echo "selected"; ?>>20:00 hrs
                            </option>
                        </select>
                        <iframe src="agenda.php" width="100%" height="800" seamless
                                style="background-color:#FFF;"></iframe>
                    </div>
                </div>
                <input type="Submit" name="guardar" value="GUARDAR" data-icon="check" data-iconpos="left"
                       data-mini="true" data-theme="b" data-inline="true"/>
            </form>
        </div><!-- /content -->
    <?php } ?>
</div><!-- /page -->
</body>
</html>
