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
    <!--<script src="jquery.maskedinput.js" type="text/javascript"></script> Mascara para input-->
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <style>
        .controlgroup-textinput {
            padding-top: .10em;
            padding-bottom: .10em;
        }
    </style>
</head>
<body>
<div data-role="page" class="ui-responsive-panel" id="e_repro" data-dialog="true">
    <?php
    if (isset($_POST['idx'])) {
        $con_fec = "";
        if ($_POST['con_fec0'] <> "") {
            $con_fec = $_POST['con_fec0'];
            for ($i = 1; $i <= 29; $i++) {

                $con_fec = $con_fec . "|" . endCycle($_POST['con_fec0'], $i);
            }
        }
        $con_od = $_POST['con_od0'] . "|" . $_POST['con_od1'] . "|" . $_POST['con_od2'] . "|" . $_POST['con_od3'] . "|" . $_POST['con_od4'] . "|" . $_POST['con_od5'] . "|" . $_POST['con_od6'] . "|" . $_POST['con_od7'] . "|" . $_POST['con_od8'] . "|" . $_POST['con_od9'] . "|" . $_POST['con_od10'] . "|" . $_POST['con_od11'] . "|" . $_POST['con_od12'] . "|" . $_POST['con_od13'] . "|" . $_POST['con_od14'] . "|" . $_POST['con_od15'] . "|" . $_POST['con_od16'] . "|" . $_POST['con_od17'] . "|" . $_POST['con_od18'] . "|" . $_POST['con_od19'] . "|" . $_POST['con_od20'] . "|" . $_POST['con_od21'] . "|" . $_POST['con_od22'] . "|" . $_POST['con_od23'] . "|" . $_POST['con_od24'] . "|" . $_POST['con_od25'] . "|" . $_POST['con_od26'] . "|" . $_POST['con_od27'] . "|" . $_POST['con_od28'] . "|" . $_POST['con_od29'];
        $con_oi = $_POST['con_oi0'] . "|" . $_POST['con_oi1'] . "|" . $_POST['con_oi2'] . "|" . $_POST['con_oi3'] . "|" . $_POST['con_oi4'] . "|" . $_POST['con_oi5'] . "|" . $_POST['con_oi6'] . "|" . $_POST['con_oi7'] . "|" . $_POST['con_oi8'] . "|" . $_POST['con_oi9'] . "|" . $_POST['con_oi10'] . "|" . $_POST['con_oi11'] . "|" . $_POST['con_oi12'] . "|" . $_POST['con_oi13'] . "|" . $_POST['con_oi14'] . "|" . $_POST['con_oi15'] . "|" . $_POST['con_oi16'] . "|" . $_POST['con_oi17'] . "|" . $_POST['con_oi18'] . "|" . $_POST['con_oi19'] . "|" . $_POST['con_oi20'] . "|" . $_POST['con_oi21'] . "|" . $_POST['con_oi22'] . "|" . $_POST['con_oi23'] . "|" . $_POST['con_oi24'] . "|" . $_POST['con_oi25'] . "|" . $_POST['con_oi26'] . "|" . $_POST['con_oi27'] . "|" . $_POST['con_oi28'] . "|" . $_POST['con_oi29'];
        $con_end = $_POST['con_end0'] . "|" . $_POST['con_end1'] . "|" . $_POST['con_end2'] . "|" . $_POST['con_end3'] . "|" . $_POST['con_end4'] . "|" . $_POST['con_end5'] . "|" . $_POST['con_end6'] . "|" . $_POST['con_end7'] . "|" . $_POST['con_end8'] . "|" . $_POST['con_end9'] . "|" . $_POST['con_end10'] . "|" . $_POST['con_end11'] . "|" . $_POST['con_end12'] . "|" . $_POST['con_end13'] . "|" . $_POST['con_end14'] . "|" . $_POST['con_end15'] . "|" . $_POST['con_end16'] . "|" . $_POST['con_end17'] . "|" . $_POST['con_end18'] . "|" . $_POST['con_end19'] . "|" . $_POST['con_end20'] . "|" . $_POST['con_end21'] . "|" . $_POST['con_end22'] . "|" . $_POST['con_end23'] . "|" . $_POST['con_end24'] . "|" . $_POST['con_end25'] . "|" . $_POST['con_end26'] . "|" . $_POST['con_end27'] . "|" . $_POST['con_end28'] . "|" . $_POST['con_end29'];
        $con1_med = $_POST['con1_med0'] . "|" . $_POST['con1_med1'] . "|" . $_POST['con1_med2'] . "|" . $_POST['con1_med3'] . "|" . $_POST['con1_med4'] . "|" . $_POST['con1_med5'] . "|" . $_POST['con1_med6'] . "|" . $_POST['con1_med7'] . "|" . $_POST['con1_med8'] . "|" . $_POST['con1_med9'] . "|" . $_POST['con1_med10'] . "|" . $_POST['con1_med11'] . "|" . $_POST['con1_med12'] . "|" . $_POST['con1_med13'] . "|" . $_POST['con1_med14'] . "|" . $_POST['con1_med15'] . "|" . $_POST['con1_med16'] . "|" . $_POST['con1_med17'] . "|" . $_POST['con1_med18'] . "|" . $_POST['con1_med19'] . "|" . $_POST['con1_med20'] . "|" . $_POST['con1_med21'] . "|" . $_POST['con1_med22'] . "|" . $_POST['con1_med23'] . "|" . $_POST['con1_med24'] . "|" . $_POST['con1_med25'] . "|" . $_POST['con1_med26'] . "|" . $_POST['con1_med27'] . "|" . $_POST['con1_med28'] . "|" . $_POST['con1_med29'] . "|" . $_POST['con1_med30'];
        $con2_med = $_POST['con2_med0'] . "|" . $_POST['con2_med1'] . "|" . $_POST['con2_med2'] . "|" . $_POST['con2_med3'] . "|" . $_POST['con2_med4'] . "|" . $_POST['con2_med5'] . "|" . $_POST['con2_med6'] . "|" . $_POST['con2_med7'] . "|" . $_POST['con2_med8'] . "|" . $_POST['con2_med9'] . "|" . $_POST['con2_med10'] . "|" . $_POST['con2_med11'] . "|" . $_POST['con2_med12'] . "|" . $_POST['con2_med13'] . "|" . $_POST['con2_med14'] . "|" . $_POST['con2_med15'] . "|" . $_POST['con2_med16'] . "|" . $_POST['con2_med17'] . "|" . $_POST['con2_med18'] . "|" . $_POST['con2_med19'] . "|" . $_POST['con2_med20'] . "|" . $_POST['con2_med21'] . "|" . $_POST['con2_med22'] . "|" . $_POST['con2_med23'] . "|" . $_POST['con2_med24'] . "|" . $_POST['con2_med25'] . "|" . $_POST['con2_med26'] . "|" . $_POST['con2_med27'] . "|" . $_POST['con2_med28'] . "|" . $_POST['con2_med29'] . "|" . $_POST['con2_med30'];
        $con3_med = $_POST['con3_med0'] . "|" . $_POST['con3_med1'] . "|" . $_POST['con3_med2'] . "|" . $_POST['con3_med3'] . "|" . $_POST['con3_med4'] . "|" . $_POST['con3_med5'] . "|" . $_POST['con3_med6'] . "|" . $_POST['con3_med7'] . "|" . $_POST['con3_med8'] . "|" . $_POST['con3_med9'] . "|" . $_POST['con3_med10'] . "|" . $_POST['con3_med11'] . "|" . $_POST['con3_med12'] . "|" . $_POST['con3_med13'] . "|" . $_POST['con3_med14'] . "|" . $_POST['con3_med15'] . "|" . $_POST['con3_med16'] . "|" . $_POST['con3_med17'] . "|" . $_POST['con3_med18'] . "|" . $_POST['con3_med19'] . "|" . $_POST['con3_med20'] . "|" . $_POST['con3_med21'] . "|" . $_POST['con3_med22'] . "|" . $_POST['con3_med23'] . "|" . $_POST['con3_med24'] . "|" . $_POST['con3_med25'] . "|" . $_POST['con3_med26'] . "|" . $_POST['con3_med27'] . "|" . $_POST['con3_med28'] . "|" . $_POST['con3_med29'] . "|" . $_POST['con3_med30'];
        $con4_med = $_POST['con4_med0'] . "|" . $_POST['con4_med1'] . "|" . $_POST['con4_med2'] . "|" . $_POST['con4_med3'] . "|" . $_POST['con4_med4'] . "|" . $_POST['con4_med5'] . "|" . $_POST['con4_med6'] . "|" . $_POST['con4_med7'] . "|" . $_POST['con4_med8'] . "|" . $_POST['con4_med9'] . "|" . $_POST['con4_med10'] . "|" . $_POST['con4_med11'] . "|" . $_POST['con4_med12'] . "|" . $_POST['con4_med13'] . "|" . $_POST['con4_med14'] . "|" . $_POST['con4_med15'] . "|" . $_POST['con4_med16'] . "|" . $_POST['con4_med17'] . "|" . $_POST['con4_med18'] . "|" . $_POST['con4_med19'] . "|" . $_POST['con4_med20'] . "|" . $_POST['con4_med21'] . "|" . $_POST['con4_med22'] . "|" . $_POST['con4_med23'] . "|" . $_POST['con4_med24'] . "|" . $_POST['con4_med25'] . "|" . $_POST['con4_med26'] . "|" . $_POST['con4_med27'] . "|" . $_POST['con4_med28'] . "|" . $_POST['con4_med29'] . "|" . $_POST['con4_med30'];
        $con5_med = $_POST['con5_med0'] . "|" . $_POST['con5_med1'] . "|" . $_POST['con5_med2'] . "|" . $_POST['con5_med3'] . "|" . $_POST['con5_med4'] . "|" . $_POST['con5_med5'] . "|" . $_POST['con5_med6'] . "|" . $_POST['con5_med7'] . "|" . $_POST['con5_med8'] . "|" . $_POST['con5_med9'] . "|" . $_POST['con5_med10'] . "|" . $_POST['con5_med11'] . "|" . $_POST['con5_med12'] . "|" . $_POST['con5_med13'] . "|" . $_POST['con5_med14'] . "|" . $_POST['con5_med15'] . "|" . $_POST['con5_med16'] . "|" . $_POST['con5_med17'] . "|" . $_POST['con5_med18'] . "|" . $_POST['con5_med19'] . "|" . $_POST['con5_med20'] . "|" . $_POST['con5_med21'] . "|" . $_POST['con5_med22'] . "|" . $_POST['con5_med23'] . "|" . $_POST['con5_med24'] . "|" . $_POST['con5_med25'] . "|" . $_POST['con5_med26'] . "|" . $_POST['con5_med27'] . "|" . $_POST['con5_med28'] . "|" . $_POST['con5_med29'] . "|" . $_POST['con5_med30'];
        $con_iny = $_POST['con_iny0'] . "|" . $_POST['con_iny1'] . "|" . $_POST['con_iny2'] . "|" . $_POST['con_iny3'] . "|" . $_POST['con_iny4'] . "|" . $_POST['con_iny5'] . "|" . $_POST['con_iny6'] . "|" . $_POST['con_iny7'] . "|" . $_POST['con_iny8'] . "|" . $_POST['con_iny9'] . "|" . $_POST['con_iny10'] . "|" . $_POST['con_iny11'] . "|" . $_POST['con_iny12'] . "|" . $_POST['con_iny13'] . "|" . $_POST['con_iny14'] . "|" . $_POST['con_iny15'] . "|" . $_POST['con_iny16'] . "|" . $_POST['con_iny17'] . "|" . $_POST['con_iny18'] . "|" . $_POST['con_iny19'] . "|" . $_POST['con_iny20'] . "|" . $_POST['con_iny21'] . "|" . $_POST['con_iny22'] . "|" . $_POST['con_iny23'] . "|" . $_POST['con_iny24'] . "|" . $_POST['con_iny25'] . "|" . $_POST['con_iny26'] . "|" . $_POST['con_iny27'] . "|" . $_POST['con_iny28'] . "|" . $_POST['con_iny29'] . "|" . $_POST['con_iny30'];
        $con_obs = $_POST['con_obs0'] . "|" . $_POST['con_obs1'] . "|" . $_POST['con_obs2'] . "|" . $_POST['con_obs3'] . "|" . $_POST['con_obs4'] . "|" . $_POST['con_obs5'] . "|" . $_POST['con_obs6'] . "|" . $_POST['con_obs7'] . "|" . $_POST['con_obs8'] . "|" . $_POST['con_obs9'] . "|" . $_POST['con_obs10'] . "|" . $_POST['con_obs11'] . "|" . $_POST['con_obs12'] . "|" . $_POST['con_obs13'] . "|" . $_POST['con_obs14'] . "|" . $_POST['con_obs15'] . "|" . $_POST['con_obs16'] . "|" . $_POST['con_obs17'] . "|" . $_POST['con_obs18'] . "|" . $_POST['con_obs19'] . "|" . $_POST['con_obs20'] . "|" . $_POST['con_obs21'] . "|" . $_POST['con_obs22'] . "|" . $_POST['con_obs23'] . "|" . $_POST['con_obs24'] . "|" . $_POST['con_obs25'] . "|" . $_POST['con_obs26'] . "|" . $_POST['con_obs27'] . "|" . $_POST['con_obs28'] . "|" . $_POST['con_obs29'];
        
        updateRepro($_POST['p_dnix'],$_POST['t_muex'],$_POST['idx'], $_POST['eda'], $_POST['p_dni_het'], $_POST['p_cic'], $_POST['p_fiv'], $_POST['p_icsi'], $_POST['p_od'], $_POST['p_don'], $_POST['p_cri'], $_POST['p_iiu'], $_POST['p_extras'], $_POST['n_fol'], $_POST['fur'], $_POST['f_aco'], $_POST['fsh'], $_POST['lh'], $_POST['est'], $_POST['prol'], $_POST['ins'], $_POST['amh'], $_POST['inh'], $_POST['t3'], $_POST['t4'], $_POST['tsh'], $_POST['m_agh'], $_POST['m_vdrl'], $_POST['m_clam'], $_POST['m_his'], $_POST['m_hsg'], $_POST['f_fem'], $_POST['f_mas'], $con_fec, $con_od, $con_oi, $con_end, $con1_med, $con2_med, $con3_med, $con4_med, $con5_med, $con_iny, $con_obs, $_POST['obs'], $_POST['f_iny'], $_POST['h_iny'], $_POST['f_asp'], $_POST['cancela'], $_POST['repro']);

        if ($_POST['f_asp'] <> '') {
            $titcal = '';
            if ($_POST['p_fiv'] == 1) $titcal .= 'FIV ';
            if ($_POST['p_icsi'] == 1) $titcal .= 'ICSI ';
            if ($_POST['p_od'] == 1) $titcal .= 'OD Fresco ';
            if ($_POST['p_don'] == 1) $titcal .= 'DONACION Fresco ';
            if ($_POST['p_cri'] == 1) $titcal .= 'CRIO OVOS ';
            if ($_POST['des_dia'] === 0) $titcal .= 'DESCONGEA OVO ';
            if ($_POST['des_dia'] > 0) $titcal .= 'DESCONGELA EMBRION ';
            google_cal($titcal . $_POST['nombre'] . ' (' . $login . ')', 'Sala INMATER', $_POST['f_asp'] . ':00.000-05:00', 'bovcnii8fc3jharfgm31veg3vg@group.calendar.google.com');
        }

        if ($_POST['p_iiu'] > 0 and $_POST['f_cap'] and $_POST['fec_h'] and $_POST['fec_m']) {
            $h_cap = $_POST['fec_h'] . ':' . $_POST['fec_m'];
            $stmt2 = $db->prepare("INSERT INTO lab_andro_cap (p_dni,fec,h_cap,iiu) VALUES (?,?,?,?)");
            $stmt2->execute(array($_POST['p_dni'], $_POST['f_cap'], $h_cap, $_POST['idx']));
        }

        if ($_POST['p_don'] == 1 and $_POST['f_asp'] <> '' and $_POST['recep_num'] > 0) {
            for ($p = 1; $p <= $_POST['recep_num']; $p++) {
                $stmt2 = $db->prepare("UPDATE hc_reprod SET f_iny=?,h_iny=?,f_asp=? WHERE id=?");
                $stmt2->execute(array($_POST['f_iny'], $_POST['h_iny'], $_POST['f_asp'], $_POST['recep' . $p])); // ----Fija la f_iny y f_asp para las receptoras
            }
        } ?>
        <script type="text/javascript">
            var x = "<?php echo $_POST['dni']; ?>";
            window.parent.location.href = "n_repro.php?id=" + x;
        </script>
    <?php }
    if ($_GET['id'] <> "") {

        $id = $_GET['id'];
        $rRepro = $db->prepare("SELECT * FROM hc_reprod WHERE id=?");
        $rRepro->execute(array($id));
        $repro = $rRepro->fetch(PDO::FETCH_ASSOC);

        $rPaci = $db->prepare("SELECT hc_paciente.san,nom,ape,m_ets,g_agh,g_his,don,fnac FROM hc_antece,hc_paciente WHERE hc_paciente.dni = hc_antece.dni AND hc_paciente.dni=?");
        $rPaci->execute(array($repro['dni']));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);

        $Rperfi = $db->prepare("SELECT * FROM hc_antece_perfi WHERE dni=? ORDER BY fec ASC");
        $Rperfi->execute(array($repro['dni']));

        while ($perfi = $Rperfi->fetch(PDO::FETCH_ASSOC)) {
            if ($perfi['fsh'] <> "") $fsh = $perfi['fsh'];
            if ($perfi['lh'] <> "") $lh = $perfi['lh'];
            if ($perfi['est'] <> "") $est = $perfi['est'];
            if ($perfi['prol'] <> "") $prol = $perfi['prol'];
            if ($perfi['ins'] <> "") $ins = $perfi['ins'];
            if ($perfi['t3'] <> "") $t3 = $perfi['t3'];
            if ($perfi['t4'] <> "") $t4 = $perfi['t4'];
            if ($perfi['tsh'] <> "") $tsh = $perfi['tsh'];
            if ($perfi['amh'] <> "") $amh = $perfi['amh'];
            if ($perfi['inh'] <> "") $inh = $perfi['inh'];
        }

        $hsghes = $db->prepare("SELECT con FROM hc_antece_hsghes WHERE dni=? AND tip='HSG' ORDER BY fec DESC LIMIT 1");
        $hsghes->execute(array($repro['dni']));
        $hsg = $hsghes->fetch(PDO::FETCH_ASSOC);

        $rPare = $db->prepare("SELECT p_dni,p_nom,p_ape FROM hc_pareja WHERE p_dni=? ORDER BY p_ape DESC");
        $rPare->execute(array($repro['p_dni']));
        $pare = $rPare->fetch(PDO::FETCH_ASSOC);

        if ($repro['p_dni'] == "") $pareja = "SOLTERA"; else $pareja = $pare['p_ape'] . " " . $pare['p_nom'];

        $rHete = $db->prepare("SELECT hc_pareja.p_dni,p_nom,p_ape,p_san,p_raz,p_pes,p_tal,p_ojo,p_cab,p_ins,p_icq FROM hc_pareja,hc_pare_paci WHERE hc_pareja.p_dni=hc_pare_paci.p_dni AND hc_pare_paci.p_het=? ORDER BY hc_pare_paci.p_fec DESC");
        $rHete->execute(array(1));

        $rAspi = $db->prepare("SELECT pro FROM lab_aspira WHERE lab_aspira.rep=?");
        $rAspi->execute(array($id));
        if ($rAspi->rowCount() > 0) $lock = 1; else $lock = 0;
        ?>
        <style>
            .ui-dialog-contain {
                max-width: 100%;
                margin: 1% auto 1%;
                padding: 0;
                position: relative;
                top: -35px;
            }

            #wrap {
                width: 85%;
                overflow: auto;
                overflow-y: hidden;
                white-space: nowrap;

            }

            #wrap::-webkit-scrollbar {
                width: 12px;
            }

            #wrap::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(63, 95, 95, 0.3);
                border-radius: 10px;
            }

            #wrap::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(63, 95, 95, 0.5);
            }

            .ui-tabs-panel {
                background-color: #FFF;
                padding: 5px;
            }

            .peke .ui-input-text {
                width: 140px !important;

            }

            .peke2 .ui-input-text {
                width: 80px !important;
            }

            .ui-slider-track {
                margin-left: 15px;
            }

            .enlinea div {
                display: inline-block;
                vertical-align: middle;
            }

            .sel_het {
                color: #F04F52 !important;
            }
        </style>
        <script>
            $(document).ready(function () {
                $("#repro_lista").change(function () {
                    var str = $('#repro').val();
                    var items = $(this).val();
                    var n = str.indexOf(items);
                    if (n == -1) {
                        // no agrega duplicados -----------------------------------------------------
                        $('#repro').val(items + ", " + str);
                        $('#repro').textinput('refresh');
                    }
                    if (items == "borrar_p") {
                        $('#repro').val("");
                    }
                    if (items == "NINGUNA") {
                        $('#repro').val("NINGUNA");
                    }
                    $(this).prop('selectedIndex', 0);
                    $(this).selectmenu("refresh", true);
                });

                $("#aspira_block").hide();
                // No close unsaved windows --------------------
                var unsaved = false;
                $(":input").change(function () {

                    unsaved = true;

                });

                $(window).on('beforeunload', function () {
                    if (unsaved) {
                        return 'UD. HA REALIZADO CAMBIOS';
                    }
                });

                // Form Submit
                $(document).on("submit", "form", function (event) {
                    // disable unload warning
                    $(window).off('beforeunload');
                });

                $('.numeros').keyup(function () {

                    var $th = $(this);
                    $th.val($th.val().replace(/[^0-9,.]/g, function (str) {
                        //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');

                        return '';
                    }));

                    //$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
                });
                $("#p_iiu").on('click', function () {
                    $(this).prop('checked', !$(this).is(':checked'));
                });
                $("#con_iny0").change(function () {
                    if ($(this).val() == "") {
                        $("#fec_iny_activo").val(0);
                        $("#aspira_block").hide();
                    } else {
                        if ($('#p_iiu').prop('checked')) {
                        } else {
                            alert("Ahora debe ingresar la Fecha de Inyección y revisar la disponibilidad en la Sala de Aspiraciones!");
                            $("#fec_iny_activo").val(1);
                            $("#aspira_block").show();
                        }
                    }
                });

                $(".med_insert").change(function () {
                    var med = $(this).attr("title");
                    var str = $('#' + med).val();
                    var items = $(this).val();

                    var n = str.indexOf(items);

                    if (n == -1) {	// no agrega duplicados -----------------------------------------------------
                        $('#' + med).val(items + ", " + str);
                        $('#' + med).textinput('refresh');
                    }

                    if (items == "borrar_p") {
                        $('#' + med).val("");
                        $("#f_asp").val(''); // fec descongelacion -----
                    }

                    $(this).prop('selectedIndex', 0);
                    $(this).selectmenu("refresh", true);
                });
                //$(".mascara").mask("99/99",{placeholder:"__/__"});

// -------------------------- calculo de fechas de aspiracion o descogelacion ------------------------------

                $(".inyeccion").on("change", function () {

                    var date = new Date($("#f_iny").val() + " " + $("#h_iny").val());

                    if (!isNaN(date.getTime())) {

                        var dia = parseInt($("#des_dia").val());

                        if (isNaN(dia)) {
                            date.setHours(date.getHours() + 36); // 36 horas
                        } else {
                            //if (dia==0 && $("#blasto").val()==1) date.setHours(date.getHours()-120); // -5 dias (5 x24) horas
                            //if (dia==0 && $("#blasto").val()!=1) date.setHours(date.getHours()-72); // -3 dias (3 x24) horas
                            if (dia === 0 || dia == 4 || dia == 4) date.setHours(date.getHours()); // El mismo dia Inseminacion/Ocultar
                            if (dia == 1) date.setHours(date.getHours() - 96); // -4 dias (4 x24) horas
                            if (dia == 2) date.setHours(date.getHours() - 72); // -3 dias (3 x24) horas
                            if (dia == 3) date.setHours(date.getHours() - 48); // -2 dias (2 x24) horas
                            if (dia == 4) date.setHours(date.getHours() - 24); // -1 dias (1 x24) horas
                        }

                        var hoy = new Date();
                        hoy.setDate(hoy.getDate() + 1);
                        // format a date
                        var dia_next = hoy.getDate() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getFullYear();
                        var dia_aspi = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                        //alert (dia_next+' XXX '+dia_aspi);
                        if (hoy.getHours() >= 15 && dia_next == dia_aspi) {
                            alert("Solo puede agendar para mañana hasta las 3pm de hoy");
                            $("#f_asp").val("");
                        } else {
                            $("#f_asp").val(date.toInputFormat());
                        }

                        $("#f_asp").focus();
                    } else {
                        $("#f_asp").val("");
                    }
                });

                Date.prototype.toInputFormat = function () {
                    var yyyy = this.getFullYear().toString();
                    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
                    var dd = this.getDate().toString();
                    var hh = this.getHours().toString();
                    var mi = this.getMinutes().toString();
                    return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]) + "T" + (hh[1] ? hh : "0" + hh[0]) + ":" + (mi[1] ? mi : "0" + mi[0]);
                };

//------ Andrologia --------------------

                $(".hetes").hide();

                $("#hete_chk").change(function () {

                    if ($(this).prop('checked')) {
                        $(".hetes").show();
                        $(".hetes2,.ui-input-search").show();
                        $(".sel_het").show();
                        $(this).val(1);
                    } else {
                        $(".hetes").hide();
                        $("#p_dni_het").val("");
                        $(this).val(0);
                        //$("#vol,#met,#c_tan,#c_can").prop('required',false);
                    }
                });

                $(".sel_het").click(function () {

                    $(".hetes2,.ui-input-search").hide();
                    hete_id = $(this).attr("title");
                    $("#" + hete_id).show();
                    $(this).hide();
                    $("#p_dni_het").val(hete_id);

                });
                <?php if ($repro['p_iiu'] > 0) { ?>
                $('#p_fiv,#p_icsi,#p_cri,#p_don').checkboxradio("disable");
                $('#p_od,#p_des').selectmenu("disable");
                <?php } ?>
                <?php if (!is_null($repro['des_dia']) and $repro['des_dia'] >= 0) { ?>
                $("#aspira_block").show();
                <?php } ?>

                <?php if ($lock == 1) { ?>
                $("#form1 :input").attr("disabled", true);
                <?php } ?>
                <?php if ($repro['f_asp'] <> "") { ?>
                $("#aspira_block").show();
                $("#fec_iny_activo").val(1);
                <?php } ?>
                <?php if ($repro['p_dni_het'] <> "") { ?>
                $(".hetes").show();
                $(".hetes2,.sel_het,.ui-input-search").hide();
                $("#<?php echo $repro['p_dni_het'];?>").show();
                <?php } ?>

            });
        </script>
        <div data-role="header" data-position="fixed">
            <h2><?php echo "<small>(" . date("d-m-Y", strtotime($repro['fec'])) . ")</small> " . $paci['ape'] . " " . $paci['nom'] . " / <small>" . $pareja . "</small>"; ?></h2>
        </div>
        <!-- /header -->
        <div class="ui-content" role="main">
            <form action="e_repro.php" method="post" data-ajax="false" id="form1">
                <input type="hidden" name="idx" value="<?php echo $repro['id']; ?>">
                <input type="hidden" name="dni" value="<?php echo $repro['dni']; ?>">
                <input type="hidden" name="nombre" value="<?php echo $paci['ape'] . " " . $paci['nom']; ?>">
                <input type="hidden" name="fec_iny_activo" id="fec_iny_activo">
                <!--id="fec_iny_activo" se usa en el javascript-->
                <input type="hidden" name="des_dia" id="des_dia" value="<?php echo $repro['des_dia']; ?>">
                <!--id="des_dia" se usa en el javascript-->

                <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">
                    <div data-role="collapsible" data-collapsed="false"><h3>Procedimientos / Extras</h3>
                        <table width="100%" align="center" style="margin: 0 auto;">
                            <tr>
                                <td>
                                    <select name="p_dnix" id="p_dnix" data-mini="true" data-inline="true">
                                        <option value="">Seleccione Pareja</option>
                                        <option value="1">---SOLTERA---</option>
                                        <?php
                                            $rPP = $db->prepare("SELECT p_dni FROM hc_pare_paci WHERE dni=? ORDER BY p_fec DESC");
                                            $rPP->execute(array($repro['dni']));
                                            $p_dni_selected="";
                                            while ($pp = $rPP->fetch(PDO::FETCH_ASSOC)) {
                                                $rPare = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
                                                $rPare->execute(array($pp['p_dni']));
                                                $pare = $rPare->fetch(PDO::FETCH_ASSOC);
                                                if ($repro['p_dni'] == $pp['p_dni']) {
                                                    $p_dni_selected="selected";
                                                }
                                                print ("<option value=" . $pp['p_dni'] . " $p_dni_selected>" . var_dump($rPP)  . $pare['p_ape'] . " " . $pare['p_nom'] . "</option>");
                                            }
                                        ?>
                                    </select>
                                    <select name="t_muex" id="t_muex" data-mini="true" data-inline="true">
                                        <option value="">Tipo de Muestra</option>
                                        <option value=1 <?php if ($repro['t_mue'] == 1) {print("selected");} ?>>Muestra: Fresca</option>
                                        <option value=2 <?php if ($repro['t_mue'] == 2) {print("selected");} ?>>Muestra: Congelada</option>
                                        <option value=3 <?php if ($repro['t_mue'] == 3) {print("selected");} ?>>No Aplica</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="select" id="repro_lista" data-mini="true" data-inline="true">
                                        <option value="" selected>Reproducción Asistida:</option>
                                        <option value="NINGUNA">*** NINGUNA ***</option>
                                        <option value="borrar_p">*** BORRAR TODO ***</option>
                                        <optgroup label="Agrege Procedimientos:">
                                            <option value="FIV">FIV</option>
                                            <option value="OD">OD</option>
                                            <option value="SD">SD</option>
                                            <option value="EMBRYOAPOCION">EMBRYOAPOCION</option>
                                            <option value="TED">TED</option>
                                            <option value="CRIO OVOS">CRIO OVOS</option>
                                            <option value="IIU">IIU</option>
                                        </optgroup>
                                        <optgroup label="Agrege Extras">
                                            <option value="TRANSFERENCIA FRESCO">TRANSFERENCIA FRESCO</option>
                                            <option value="NGS">NGS</option>
                                            <option value="CRIO TOTAL">CRIO TOTAL</option>
                                            <option value="EMBRYOGLUE">EMBRYOGLUE</option>
                                            <option value="EMBRYOSCOPE">EMBRIOSCOPE</option>
                                            <option value="PICSI">PICSI</option>
                                            <option value="BANKING EMBRIONES">BANKING EMBRIONES</option>
                                        </optgroup>
                                    </select>
                                    <textarea name="repro" required id="repro" data-mini="true"><?php echo $repro['repro']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="63%">
                                    <div class="enlinea">
                                        <!-- C. Natural -->
                                        <input type="checkbox" name="p_cic" id="p_cic" data-mini="true" value=1 <?php if ($repro['p_cic'] == 1) echo "checked"; ?>>
                                        <label for="p_cic">C. Natural</label>
                                        <!-- FIV -->
                                        <input type="checkbox" name="p_fiv" id="p_fiv" data-mini="true" value=1 <?php if ($repro['p_fiv'] == 1) echo "checked";
                                        if ($repro['des_dia'] >= 1) echo " disabled"; ?>><label for="p_fiv">FIV</label>
                                        <!-- ICSI -->
                                        <input type="checkbox" name="p_icsi" id="p_icsi" data-mini="true" value=1 <?php if ($repro['p_icsi'] == 1) echo "checked";
                                        if ($repro['des_dia'] >= 1) echo " disabled"; ?>><label for="p_icsi">ICSI</label>
                                        <!-- Crio Ovos -->
                                        <input type="checkbox" name="p_cri" id="p_cri" data-mini="true" value=1 <?php if ($repro['p_cri'] == 1) echo "checked";
                                        if (!is_null($repro['des_dia']) and $repro['des_dia'] >= 0) echo " disabled"; ?>><label for="p_cri">Crio Ovos</label>
                                        <?php if ($repro['p_iiu'] == 1) { ?>
                                            <input type="checkbox" name="p_iiu" id="p_iiu" data-mini="true" value=1
                                                   checked><label for="p_iiu">IIU</label>
                                        <?php } ?>
                                        <?php if ($paci['don'] == 'D') { ?>
                                            <input type="checkbox" name="p_don" id="p_don" data-mini="true"
                                                   value=1 <?php if ($repro['p_don'] == 1) echo "checked";
                                            if (!is_null($repro['des_dia']) and $repro['des_dia'] >= 0) echo " disabled"; ?>>
                                            <label for="p_don">Donación Fresco</label>
                                        <?php } else { // si es paciente puede ser receptora ---------
                                            $rDon = $db->prepare("SELECT dni,nom,ape,don,med FROM hc_paciente WHERE don=? ORDER BY ape ASC");
                                            $rDon->execute(array('D')); ?>
                                            <!-- OD Fresco -->
                                            <select name="p_od" id="p_od" data-mini="true" <?php if (!is_null($repro['des_dia']) and $repro['des_dia'] >= 0) echo " disabled"; ?>>
                                                <option value="">OD Fresco:</option>
                                                <optgroup label="Seleccione la Donante:">
                                                    <?php
                                                        while ($don = $rDon->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <option value=<?php echo $don['dni'];
                                                                if ($repro['p_od'] == $don['dni'])
                                                                    echo " selected"; ?>><?php echo 'OD Fresco: ' . $don['ape'] . ' ' . $don['nom'] . ' (' . $don['med'] . ')'; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    ?>
                                                </optgroup>
                                            </select>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td width="37%">
                                    <select name="select" class="med_insert" title="p_extras" data-mini="true" data-inline="true">
                                        <option value="" selected>Seleccione Extras..</option>
                                        <option value="borrar_p">- Borrar Datos -</option>
                                        <option value="TRANSFERENCIA FRESCO">TRANSFERENCIA FRESCO</option>
                                        <option value="NGS">NGS</option>
                                        <option value="CRIO TOTAL">CRIO TOTAL</option>
                                        <option value="EMBRYOGLUE">EMBRYOGLUE</option>
                                        <option value="EMBRYOSCOPE">EMBRIOSCOPE</option>
                                        <option value="PICSI">PICSI</option>
                                        <option value="BANKING EMBRIONES">BANKING EMBRIONES</option>
                                    </select>
                                    <textarea name="p_extras" readonly id="p_extras" data-mini="true"><?php echo $repro['p_extras']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php if ($repro['p_don'] == 1) {
                                        $rRecep = $db->prepare("SELECT hc_reprod.id,hc_paciente.nom,hc_paciente.ape FROM hc_reprod,hc_paciente WHERE hc_reprod.p_od=? AND hc_reprod.f_asp=? AND hc_paciente.dni=hc_reprod.dni ORDER BY hc_paciente.ape ASC");
                                        $rRecep->execute(array($repro['dni'], $repro['f_asp']));
                                        $recep_num = 0;
                                        echo 'RECEPTORA(S):<br>';
                                        if ($rRecep->rowCount() > 0) {
                                            while ($recep = $rRecep->fetch(PDO::FETCH_ASSOC)) {
                                                $recep_num++;
                                                echo '<b>' . $recep['ape'] . ' ' . $recep['nom'] . '</b><input type="hidden" name="recep' . $recep_num . '" value="' . $recep['id'] . '"><br>';
                                            }
                                        }
                                        if ($recep_num == 0) echo ' Vacio';
                                        echo '<input type="hidden" name="recep_num" id="recep_num" value="' . $recep_num . '">';
                                    }

                                    if (!is_null($repro['des_dia']) and $repro['des_dia'] >= 0) {

                                        if ($repro['des_don'] == null and $repro['des_dia'] >= 1) {
                                            echo "<b>Descongelación:</b> TED (Dia " . $repro['des_dia'] . ")";
                                        }
                                        if ($repro['des_don'] == null and $repro['des_dia'] === 0) {
                                            echo "<b>Descongelación:</b> ÓVULOS PROPIOS";
                                        }
                                        if ($repro['des_don'] <> null) { // si son donandos
                                            if ($repro['des_dia'] === 0) echo "<b>Descongelación:</b> ÓVULOS DONADOS";
                                            if ($repro['des_dia'] >= 1) echo "<b>Descongelación:</b> EMBRIOADOPCIÓN (Dia " . $repro['des_dia'] . ")";
                                            $rPaciDon = $db->prepare("SELECT nom,ape FROM hc_paciente WHERE dni=?");
                                            $rPaciDon->execute(array($repro['des_don']));
                                            $paciDon = $rPaciDon->fetch(PDO::FETCH_ASSOC);
                                            echo " <b>Donante</b>: " . $paciDon['ape'] . " " . $paciDon['nom'];
                                        }
                                    }
                                    ?></td>
                            </tr>

                        </table>
                    </div>
                    <div data-role="collapsible"><h3>Perfil Hormonal / Etiologías</h3>
                        <table width="100%" align="center" style="margin: 0 auto;" class="peke">
                            <tr>
                                <td width="24%">FSH
                                    <input name="fsh" type="text" id="fsh"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['fsh']; else echo $fsh; ?>"
                                           readonly data-mini="true"></td>
                                <td width="28%">Prolac
                                    <input name="prol" type="text" id="prol"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['prol']; else echo $prol; ?>"
                                           readonly data-mini="true"></td>
                                <td width="27%">Tiroides T3
                                    <input name="t3" type="text" id="t3"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['t3']; else echo $t3; ?>"
                                           readonly data-mini="true"></td>
                                <td width="27%" rowspan="3" bgcolor="#E7E7E7"><p>Etiología Femenina
                                        <input type="text" name="f_fem" id="f_fem" value="<?php echo $repro['f_fem']; ?>"
                                               data-mini="true"></p>
                                    <p>Etiología Masculina
                                        <input type="text" name="f_mas" id="f_mas" value="<?php echo $repro['f_mas']; ?>"
                                               data-mini="true"></p></td>
                            </tr>
                            <tr>
                                <td> LH
                                    <input name="lh" type="text" id="lh"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['lh']; else echo $lh; ?>"
                                           readonly data-mini="true"></td>
                                <td>AMH
                                    <input name="amh" type="text" id="amh"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['amh']; else echo $amh; ?>"
                                           readonly data-mini="true"></td>
                                <td>Tiroides T4
                                    <input name="t4" type="text" id="t4"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['t4']; else echo $t4; ?>"
                                           readonly data-mini="true"></td>
                            </tr>
                            <tr>
                                <td>Estradiol
                                    <input name="est" type="text" id="est"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['est']; else echo $est; ?>"
                                           readonly data-mini="true"></td>
                                <td>Inhibina B
                                    <input name="inh" type="text" id="inh"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['inh']; else echo $inh; ?>"
                                           readonly data-mini="true"></td>
                                <td>Tiroides Tsh
                                    <input name="tsh" type="text" id="tsh"
                                           value="<?php if ($repro['f_asp'] <> "") echo $repro['tsh']; else echo $tsh; ?>"
                                           readonly data-mini="true"></td>
                            </tr>

                        </table>
                    </div>

                    <?php if ($repro['des_dia'] < 1) {
                        if ($repro['t_mue'] == 1) $t_mue = '(Muestra Fresca)';
                        if ($repro['t_mue'] == 2) $t_mue = '(Muestra Congelada)'; ?>

                        <div data-role="collapsible"><h3>Andrología <?php echo $t_mue; ?></h3>
                            <?php if ($repro['p_dni'] <> "") { ?>
                                <div data-role="collapsible" data-mini="true" data-collapsed-icon="user"
                                     data-expanded-icon="user" data-theme="c" data-content-theme="a">
                                        <h4>PAREJA: <?php echo $pare['p_ape'] . " " . $pare['p_nom']; ?> </h4>
                                        <?php $Esp = $db->prepare("SELECT * FROM lab_andro_esp WHERE p_dni=? ORDER BY fec DESC");
                                    $Esp->execute(array($repro['p_dni']));
                                    if ($Esp->rowCount() > 0) { ?>
                                        <table width="80%" style="margin: 0 auto;" class="peke">
                                            <tr>
                                                <th width="11%" align="left">Vol.</th>
                                                <th width="11%" align="left">Con.</th>
                                                <th width="11%" align="left">Viabi.</th>
                                                <th width="11%" align="left">Ph</th>
                                                <th width="11%" align="left">Morfo.</th>
                                                <th width="11%" align="left">Moti.</th>
                                                <th width="11%" align="left">Fecha</th>
                                            </tr>
                                            <?php while ($esp = $Esp->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr style="font-size:small">
                                                    <td><?php if ($esp['emb'] > 0) echo $esp['vol_f'] . 'ml'; ?></td>
                                                    <td><?php if ($esp['emb'] > 0) {
                                                            echo $esp['con_f'];
                                                            if ($esp['esp'] == 1) echo " Spz/Camp"; else echo " x10<sup>6";
                                                        } ?></td>
                                                    <td><?php if ($esp['emb'] > 0) echo $esp['via'] . '%'; ?></td>
                                                    <td><?php if ($esp['emb'] > 0) echo $esp['ph']; ?></td>
                                                    <td><?php if ($esp['emb'] > 0 and $esp['m_a'] > 0) echo round(100 - (($esp['m_a'] * 100) / ($esp['m_a'] + $esp['m_n'])), 2) . '%'; // % normal = pm_n ?></td>
                                                    <td><?php if ($esp['emb'] > 0) echo ($esp['pl_f'] + $esp['pnl_f']) . '%'; ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($esp['fec'])); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } else  echo 'No tiene Espermatograma';
                                    $rCon = $db->prepare("SELECT tip FROM lab_tanque_res WHERE sta=?");
                                    $rCon->execute(array($repro['p_dni']));
                                    if ($rCon->rowCount() > 0) {
                                        $c_bio = 0;
                                        $c_cri = 0;
                                        while ($con = $rCon->fetch(PDO::FETCH_ASSOC)) {
                                            if ($con['tip'] == 1) $c_bio++;
                                            if ($con['tip'] == 2) $c_cri++;
                                        }
                                        echo "<p>Congelados Biopsia: " . $c_bio . "<br>Congelados Criopreservación: " . $c_cri . "</p>";
                                    }

                                    $rDes = $db->prepare("SELECT des,des_tip,pro FROM lab_andro_cap WHERE des_dni=? ORDER BY des_tip");
                                    $rDes->execute(array($repro['p_dni']));
                                    if ($rDes->rowCount() > 0) {
                                        while ($des = $rDes->fetch(PDO::FETCH_ASSOC)) {
                                            if ($des['des_tip'] > 0) {
                                                $n_des = explode('|', $des['des']);
                                                $total = count($n_des) - 1;
                                                if ($des['des_tip'] == 1) $des_tip = "Descongelado Biopsia: ";
                                                if ($des['des_tip'] == 2) $des_tip = "Descongelado Criopreservación: ";
                                                if ($des['pro'] <> "" and $des['pro'] <> 0) $des_pro = " (Protocolo " . $des['pro'] . ")";
                                                echo $des_tip . $total . $des_pro . "<br>";
                                            }
                                        }
                                    } ?>
                                </div>
                            <?php } ?>

                            <div data-role="controlgroup" data-mini="true">

                                <label for="hete_chk">DONANTE (Heterólogo)</label>
                                <input type="checkbox" name="hete_chk" id="hete_chk" data-mini="true" <?php if ($repro['p_dni_het'] <> "") echo "checked"; ?> data-inline="true">
                                <input type="hidden" name="p_dni_het" id="p_dni_het" value="<?php echo $repro['p_dni_het']; ?>">
                                <input type="hidden" name="p_dni" id="p_dni" value="<?php echo $repro['p_dni']; ?>">
                                <div class="hetes">
                                    <input id="searchForCollapsibleSet" data-type="search" data-inline="true">
                                    <div data-role="collapsibleset" data-filter="true" data-inset="true"
                                         data-input="#searchForCollapsibleSet" data-theme="c" data-content-theme="a"
                                         data-mini="true" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">

                                        <?php while ($hete = $rHete->fetch(PDO::FETCH_ASSOC)) {

                                            $p_raz = $p_san = $p_cab = $p_ojo = $p_tal = $p_pes = $p_ins = $p_icq = "";

                                            if ($hete['p_cab'] == 1) $p_cab = ", Pelo Negro";
                                            if ($hete['p_cab'] == 2) $p_cab = ", Pelo Castaño";
                                            if ($hete['p_cab'] == 3) $p_cab = ", Pelo Rubio";
                                            if ($hete['p_cab'] == 4) $p_cab = ", Pelo Pelirojo";
                                            if ($hete['p_ojo'] == 1) $p_ojo = ", Ojos Negro";
                                            if ($hete['p_ojo'] == 2) $p_ojo = ", Ojos Pardo";
                                            if ($hete['p_ojo'] == 3) $p_ojo = ", Ojos Verde";
                                            if ($hete['p_ojo'] == 4) $p_ojo = ", Ojos Azul";
                                            if ($hete['p_ojo'] == 5) $p_ojo = ", Ojos Gris";
                                            if ($hete['p_ins'] == 1) $p_ins = "Instrucción Incial";
                                            if ($hete['p_ins'] == 2) $p_ins = "Instrucción Secundaria";
                                            if ($hete['p_ins'] == 3) $p_ins = "Instrucción Tecnico";
                                            if ($hete['p_ins'] == 4) $p_ins = "Instrucción Universitaria";
                                            if ($hete['p_ins'] == 5) $p_ins = "Instrucción Postgrado";

                                            if ($hete['p_raz'] <> '') $p_raz = $hete['p_raz'];
                                            if ($hete['p_san'] <> '') $p_san = ", " . $hete['p_san'];
                                            if ($hete['p_tal'] <> '') $p_tal = ", " . $hete['p_tal']."m";
                                            if ($hete['p_pes'] <> '') $p_pes = ", " . $hete['p_pes']."kg";
                                            if ($hete['p_icq'] <> '') $p_icq = ", IQ: ".$hete['p_icq']; ?>
                                            <div data-role="collapsible" class="hetes2" id="<?php echo $hete['p_dni']; ?>">
                                                <h4><?php echo $p_raz . $p_san . $p_cab . $p_ojo . $p_tal . $p_pes; ?>
                                                    <span class="ui-li-count"><?php $arr = str_split($hete['p_dni']); $arrayLength = count($arr); $arr_dni='';
                                                        for ($i = 0; $i < $arrayLength-2; $i++){
                                                            $arr_dni = $arr_dni.$arr[$i];
                                                        }
                                                        echo $hete['p_ape'].$hete['p_nom'].'-'.$arr_dni.$arr[$arrayLength-1].$arr[$arrayLength-2]; ?></span>
                                                </h4>

                                                <?php $foto1 = "pare/" . $hete['p_dni'] . "/foto1.jpg";
                                                $foto2 = "pare/" . $hete['p_dni'] . "/foto2.jpg";

                                                if (file_exists($foto1)) {
                                                    echo "<a href='#foto1' data-rel='popup' data-position-to='window' style='float:left'><img src='" . $foto1 . "?v=" . mt_rand() . "' width='60px' height='60px' /></a>";
                                                    echo '<div data-role="popup" id="foto1" data-overlay-theme="a" style="max-width:1000px;"><img src="' . $foto1 . '"/></div>';
                                                }
                                                if (file_exists($foto2)) {
                                                    echo "<a href='#foto2' data-rel='popup' data-position-to='window' style='float:left'><img src='" . $foto2 . "?v=" . mt_rand() . "' width='60px' height='60px' /></a>";
                                                    echo ' <div data-role="popup" id="foto2" data-overlay-theme="a" style="max-width:1000px;"><img src="' . $foto2 . '"/></div>';
                                                }

                                                echo $p_ins.$p_icq."<br>";

                                                $Esp = $db->prepare("SELECT * FROM lab_andro_esp WHERE p_dni=? ORDER BY fec DESC");
                                                $Esp->execute(array($hete['p_dni']));
                                                if ($Esp->rowCount() > 0) { ?>

                                                    <table width="50%" style="margin: 0 auto;" class="peke">
                                                        <tr>
                                                            <td colspan="4"
                                                                style="text-transform: uppercase;border: 1px solid #000000;">
                                                                ESPERMATOGRAMA
                                                            </td>
                                                            <td colspan="3" align="center"><a href="#" class="sel_het"
                                                                                              title="<?php echo $hete['p_dni']; ?>">SELECCIONAR</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Vol.</th>
                                                            <th>Con.</th>
                                                            <th>Viabi.</th>
                                                            <th>Ph</th>
                                                            <th>Morfo.</th>
                                                            <th>Moti.</th>
                                                            <th>Fecha</th>
                                                        </tr>

                                                        <?php while ($esp = $Esp->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr style="font-size:small">
                                                                <td><?php if ($esp['emb'] > 0) echo $esp['vol_f'] . 'ml'; ?></td>
                                                                <td><?php if ($esp['emb'] > 0) {
                                                                        echo $esp['con_f'];
                                                                        if ($esp['esp'] == 1) echo " Spz/Camp"; else echo " x10<sup>6";
                                                                    } ?></td>
                                                                <td><?php if ($esp['emb'] > 0) echo $esp['via'] . '%'; ?></td>
                                                                <td><?php if ($esp['emb'] > 0) echo $esp['ph']; ?></td>
                                                                <td><?php if ($esp['emb'] > 0 and $esp['m_a'] > 0) echo round(100 - (($esp['m_a'] * 100) / ($esp['m_a'] + $esp['m_n'])), 2) . '%'; // % normal = pm_n ?></td>
                                                                <td><?php if ($esp['emb'] > 0) echo ($esp['pl_f'] + $esp['pnl_f']) . '%'; ?></td>
                                                                <td><?php echo date("d-m-Y", strtotime($esp['fec'])); ?></td>
                                                            </tr>
                                                        <?php } ?>

                                                    </table>
                                                <?php } else echo 'No tiene Espermatograma';
                                                $rCon = $db->prepare("SELECT tip FROM lab_tanque_res WHERE sta=?");
                                                $rCon->execute(array($hete['p_dni']));
                                                if ($rCon->rowCount() > 0) {
                                                    $c_bio = 0;
                                                    $c_cri = 0;
                                                    while ($con = $rCon->fetch(PDO::FETCH_ASSOC)) {
                                                        if ($con['tip'] == 1) $c_bio++;
                                                        if ($con['tip'] == 2) $c_cri++;
                                                    }
                                                    echo "<p>Congelados Biopsia: " . $c_bio . "<br>Congelados Criopreservación: " . $c_cri . "</p>";
                                                }
                                                ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php } ?>

                    <div data-role="collapsible"><h3>Mujer antecedentes</h3>
                        <table width="100%" align="center" style="margin: 0 auto;" class="peke">
                            <tr>
                                <td>AgHbs<input type="text" name="m_agh" id="m_agh"
                                                value="<?php if ($repro['f_asp'] <> "") echo $repro['m_agh']; else echo $paci['g_agh']; ?>"
                                                readonly data-mini="true"></td>
                                <td width="26%">Histero.<input type="text" name="m_his" id="m_his"
                                                               value="<?php if ($repro['f_asp'] <> "") echo $repro['m_his']; else echo $paci['g_his']; ?>"
                                                               readonly data-mini="true"></td>
                                <td width="24%">HSG<input type="text" name="m_hsg" id="m_hsg"
                                                          value="<?php if ($repro['f_asp'] <> "") echo $repro['m_hsg']; else echo $hsg['con']; ?>"
                                                          readonly data-mini="true"></td>
                                <td width="18%">VDRL
                                    <select name="m_vdrl" id="m_vdrl" data-mini="true">
                                        <option value="">---</option>
                                        <option value="Positivo" <?php if ($repro['m_vdrl'] == "Positivo") echo "selected"; ?>>
                                            Positivo
                                        </option>
                                        <option value="Negativo" <?php if ($repro['m_vdrl'] == "Negativo") echo "selected"; ?>>
                                            Negativo
                                        </option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td width="20%">Grupo Sanguineo: <b><?php echo $paci['san']; ?></b></td>
                                <td>
                                    HIV <?php if (strpos($paci['m_ets'], "VIH") !== false) echo '<font color="#F8080C">Positivo</font>'; else echo 'Negativo'; ?></td>
                                <td>Clamidia<input type="text" name="m_clam"
                                                   id="m_clam" <?php if (strpos($paci['m_ets'], "Clamidiasis") !== false) echo 'value="Positivo"'; else echo 'value="Negativo"'; ?>
                                                   readonly data-mini="true"></td>
                                <td>Edad
                                    <input type="text" name="eda" id="eda" value="<?php if ($repro['eda']==0) echo date_diff(date_create($paci['fnac']), date_create('today'))->y; else echo $repro['eda']; ?>"
                                           data-mini="true"></td>
                            </tr>

                        </table>
                    </div>

                    <div data-role="collapsible"><h3>Ciclo de Estimulación</h3>
                        <table width="100%" align="center" style="margin: 0 auto;" class="peke">
                            <tr>
                                <td width="43%"></td>
                                <?php if (is_null($repro['des_dia'])) { ?>
                                    <td width="11%">Número Folículos</td>
                                    <td width="12%" class="peke2"><input name="n_fol" type="number" id="n_fol" min="0"
                                                                         value="<?php echo $repro['n_fol']; ?>"
                                                                         data-mini="true"></td>
                                <?php } ?>
                                <td width="3%">FUR</td>
                                <td width="12%"><input type="date" name="fur" id="fur" value="<?php echo $repro['fur']; ?>"
                                                       data-mini="true"></td>
                                <td width="7%">1era ACO</td>
                                <td width="12%"><input type="date" name="f_aco" id="f_aco"
                                                       value="<?php echo $repro['f_aco']; ?>" data-mini="true"></td>
                            </tr>
                        </table>
                        <?php $con_fec = explode("|", $repro['con_fec']);
                        $con_od = explode("|", $repro['con_od']);
                        $con_oi = explode("|", $repro['con_oi']);
                        $con_end = explode("|", $repro['con_end']);
                        $con1_med = explode("|", $repro['con1_med']);
                        $con2_med = explode("|", $repro['con2_med']);
                        $con3_med = explode("|", $repro['con3_med']);
                        $con4_med = explode("|", $repro['con4_med']);
                        $con5_med = explode("|", $repro['con5_med']);
                        $con_iny = explode("|", $repro['con_iny']);
                        $con_obs = explode("|", $repro['con_obs']);

                        $Tcon1_med = (int)$con1_med[1] + (int)$con1_med[2] + (int)$con1_med[3] + (int)$con1_med[4] + (int)$con1_med[5] + (int)$con1_med[6] + (int)$con1_med[7] + (int)$con1_med[8] + (int)$con1_med[9] + (int)$con1_med[10] + (int)$con1_med[11] + (int)$con1_med[12] + (int)$con1_med[13] + (int)$con1_med[14] + (int)$con1_med[15] + (int)$con1_med[16] + (int)$con1_med[17] + (int)$con1_med[18] + (int)$con1_med[19] + (int)$con1_med[20] + (int)$con1_med[21] + (int)$con1_med[22] + (int)$con1_med[23] + (int)$con1_med[24] + (int)$con1_med[25] + (int)$con1_med[26] + (int)$con1_med[27] + (int)$con1_med[28] + (int)$con1_med[29] + (int)$con1_med[30];
                        $Tcon2_med = (int)$con2_med[1] + (int)$con2_med[2] + (int)$con2_med[3] + (int)$con2_med[4] + (int)$con2_med[5] + (int)$con2_med[6] + (int)$con2_med[7] + (int)$con2_med[8] + (int)$con2_med[9] + (int)$con2_med[10] + (int)$con2_med[11] + (int)$con2_med[12] + (int)$con2_med[13] + (int)$con2_med[14] + (int)$con2_med[15] + (int)$con2_med[16] + (int)$con2_med[17] + (int)$con2_med[18] + (int)$con2_med[19] + (int)$con2_med[20] + (int)$con2_med[21] + (int)$con2_med[22] + (int)$con2_med[23] + (int)$con2_med[24] + (int)$con2_med[25] + (int)$con2_med[26] + (int)$con2_med[27] + (int)$con2_med[28] + (int)$con2_med[29] + (int)$con2_med[30];
                        $Tcon3_med = (int)$con3_med[1] + (int)$con3_med[2] + (int)$con3_med[3] + (int)$con3_med[4] + (int)$con3_med[5] + (int)$con3_med[6] + (int)$con3_med[7] + (int)$con3_med[8] + (int)$con3_med[9] + (int)$con3_med[10] + (int)$con3_med[11] + (int)$con3_med[12] + (int)$con3_med[13] + (int)$con3_med[14] + (int)$con3_med[15] + (int)$con3_med[16] + (int)$con3_med[17] + (int)$con3_med[18] + (int)$con3_med[19] + (int)$con3_med[20] + (int)$con3_med[21] + (int)$con3_med[22] + (int)$con3_med[23] + (int)$con3_med[24] + (int)$con3_med[25] + (int)$con3_med[26] + (int)$con3_med[27] + (int)$con3_med[28] + (int)$con3_med[29] + (int)$con3_med[30];
                        $Tcon4_med = (int)$con4_med[1] + (int)$con4_med[2] + (int)$con4_med[3] + (int)$con4_med[4] + (int)$con4_med[5] + (int)$con4_med[6] + (int)$con4_med[7] + (int)$con4_med[8] + (int)$con4_med[9] + (int)$con4_med[10] + (int)$con4_med[11] + (int)$con4_med[12] + (int)$con4_med[13] + (int)$con4_med[14] + (int)$con4_med[15] + (int)$con4_med[16] + (int)$con4_med[17] + (int)$con4_med[18] + (int)$con4_med[19] + (int)$con4_med[20] + (int)$con4_med[21] + (int)$con4_med[22] + (int)$con4_med[23] + (int)$con4_med[24] + (int)$con4_med[25] + (int)$con4_med[26] + (int)$con4_med[27] + (int)$con4_med[28] + (int)$con4_med[29] + (int)$con4_med[30];
                        $Tcon5_med = (int)$con5_med[1] + (int)$con5_med[2] + (int)$con5_med[3] + (int)$con5_med[4] + (int)$con5_med[5] + (int)$con5_med[6] + (int)$con5_med[7] + (int)$con5_med[8] + (int)$con5_med[9] + (int)$con5_med[10] + (int)$con5_med[11] + (int)$con5_med[12] + (int)$con5_med[13] + (int)$con5_med[14] + (int)$con5_med[15] + (int)$con5_med[16] + (int)$con5_med[17] + (int)$con5_med[18] + (int)$con5_med[19] + (int)$con5_med[20] + (int)$con5_med[21] + (int)$con5_med[22] + (int)$con5_med[23] + (int)$con5_med[24] + (int)$con5_med[25] + (int)$con5_med[26] + (int)$con5_med[27] + (int)$con5_med[28] + (int)$con5_med[29] + (int)$con5_med[30];
                        $Tcon_iny = (int)$con_iny[1] + (int)$con_iny[2] + (int)$con_iny[3] + (int)$con_iny[4] + (int)$con_iny[5] + (int)$con_iny[6] + (int)$con_iny[7] + (int)$con_iny[8] + (int)$con_iny[9] + (int)$con_iny[10] + (int)$con_iny[11] + (int)$con_iny[12] + (int)$con_iny[13] + (int)$con_iny[14] + (int)$con_iny[15] + (int)$con_iny[16] + (int)$con_iny[17] + (int)$con_iny[18] + (int)$con_iny[19] + (int)$con_iny[20] + (int)$con_iny[21] + (int)$con_iny[22] + (int)$con_iny[23] + (int)$con_iny[24] + (int)$con_iny[25] + (int)$con_iny[26] + (int)$con_iny[27] + (int)$con_iny[28] + (int)$con_iny[29] + (int)$con_iny[30];
                        ?>
                        <table cellspacing="0" cellpadding="0" style="width:15%;float:left;font-size: small;">
                            <tr height="20">
                                <td>DIA CICLO</td>
                                <td></td>
                            </tr>
                            <tr height="40">
                                <td>DIA MES</td>
                                <td></td>
                            </tr>
                            <?php if (is_null($repro['des_dia'])) { ?>
                                <tr height="45">
                                    <td>O.D.</td>
                                    <td></td>
                                </tr>
                                <tr height="45">
                                    <td>O.I.</td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            <tr height="45">
                                <td>ENDOMETRIO</td>
                            </tr>
                            <tr>
                                <td><input type="text" name="con1_med0" id="con1_med0" value="<?php echo $con1_med[0]; ?>"
                                           data-mini="true" placeholder="Medicamento 1.."></td>
                                <td><?php echo $Tcon1_med; ?></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="con2_med0" id="con2_med0" value="<?php echo $con2_med[0]; ?>"
                                           data-mini="true" placeholder="Medicamento 2.."></td>
                                <td><?php echo $Tcon2_med; ?></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="con3_med0" id="con3_med0" value="<?php echo $con3_med[0]; ?>"
                                           data-mini="true" placeholder="Medicamento 3.."></td>
                                <td><?php echo $Tcon3_med; ?></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="con4_med0" id="con4_med0" value="<?php echo $con4_med[0]; ?>"
                                           data-mini="true" placeholder="Medicamento 4.."></td>
                                <td><?php echo $Tcon4_med; ?></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="con5_med0" id="con5_med0" value="<?php echo $con5_med[0]; ?>"
                                           data-mini="true" placeholder="Medicamento 5.."></td>
                                <td><?php echo $Tcon5_med; ?></td>
                            </tr>
                            <?php if ($repro['p_od'] == '' and is_null($repro['des_dia'])) { ?>
                                <tr>
                                    <td><select name="con_iny0" id="con_iny0" data-mini="true">
                                            <option value="" selected>Inyección..</option>
                                            <option value="OVIDREL" <?php if ($con_iny[0] == "OVIDREL") echo "selected"; ?>>
                                                OVIDREL
                                            </option>
                                            <option value="GONAPEPTIL" <?php if ($con_iny[0] == "GONAPEPTIL") echo "selected"; ?>>
                                                GONAPEPTIL
                                            </option>
                                            <option value="CHORAGON" <?php if ($con_iny[0] == "CHORAGON") echo "selected"; ?>>
                                                CHORAGON
                                            </option>
                                        </select></td>
                                    <td><?php echo $Tcon_iny; ?></td>
                                </tr>
                            <?php } ?>
                            <tr height="45">
                                <td>OBSERVACION</td>
                            </tr>
                        </table>
                        <div id="wrap">
                            <table id="data" cellspacing="0" cellpadding="0" align="center"
                                   style="margin: 0 auto;font-size: small;" class="peke">
                                <colgroup>
                                    <col <?php // if ($con_od[0] <> "") echo 'style="background-color:#d7e5e5"'; ?>>
                                </colgroup>

                                <tr>
                                    <td align="center"><strong>1</strong></td>
                                    <td align="center"><strong>2</strong></td>
                                    <td align="center"><strong>3</strong></td>
                                    <td align="center"><strong>4</strong></td>
                                    <td align="center"><strong>5</strong></td>
                                    <td align="center"><strong>6</strong></td>
                                    <td align="center"><strong>7</strong></td>
                                    <td align="center"><strong>8</strong></td>
                                    <td align="center"><strong>9</strong></td>
                                    <td align="center"><strong>10</strong></td>
                                    <td align="center"><strong>11</strong></td>
                                    <td align="center"><strong>12</strong></td>
                                    <td align="center"><strong>13</strong></td>
                                    <td align="center"><strong>14</strong></td>
                                    <td align="center"><strong>15</strong></td>
                                    <td align="center"><strong>16</strong></td>
                                    <td align="center"><strong>17</strong></td>
                                    <td align="center"><strong>18</strong></td>
                                    <td align="center"><strong>19</strong></td>
                                    <td align="center"><strong>20</strong></td>
                                    <td align="center"><strong>21</strong></td>
                                    <td align="center"><strong>22</strong></td>
                                    <td align="center"><strong>23</strong></td>
                                    <td align="center"><strong>24</strong></td>
                                    <td align="center"><strong>25</strong></td>
                                    <td align="center"><strong>26</strong></td>
                                    <td align="center"><strong>27</strong></td>
                                    <td align="center"><strong>28</strong></td>
                                    <td align="center"><strong>29</strong></td>
                                    <td align="center"><strong>30</strong></td>
                                </tr>
                                <tr>
                                    <td><input type="date" data-mini="true" name="con_fec0" id="con_fec0"
                                               value="<?php echo $con_fec[0]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec1" id="con_fec1"
                                               value="<?php echo $con_fec[1]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec2" id="con_fec2"
                                               value="<?php echo $con_fec[2]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec3" id="con_fec3"
                                               value="<?php echo $con_fec[3]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec4" id="con_fec4"
                                               value="<?php echo $con_fec[4]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec5" id="con_fec5"
                                               value="<?php echo $con_fec[5]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec6" id="con_fec6"
                                               value="<?php echo $con_fec[6]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec7" id="con_fec7"
                                               value="<?php echo $con_fec[7]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec8" id="con_fec8"
                                               value="<?php echo $con_fec[8]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec9" id="con_fec9"
                                               value="<?php echo $con_fec[9]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec10" id="con_fec10"
                                               value="<?php echo $con_fec[10]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec11" id="con_fec11"
                                               value="<?php echo $con_fec[11]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec12" id="con_fec12"
                                               value="<?php echo $con_fec[12]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec13" id="con_fec13"
                                               value="<?php echo $con_fec[13]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec14" id="con_fec14"
                                               value="<?php echo $con_fec[14]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec15" id="con_fec15"
                                               value="<?php echo $con_fec[15]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec16" id="con_fec16"
                                               value="<?php echo $con_fec[16]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec17" id="con_fec17"
                                               value="<?php echo $con_fec[17]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec18" id="con_fec18"
                                               value="<?php echo $con_fec[18]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec19" id="con_fec19"
                                               value="<?php echo $con_fec[19]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec20" id="con_fec20"
                                               value="<?php echo $con_fec[20]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec21" id="con_fec21"
                                               value="<?php echo $con_fec[21]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec22" id="con_fec22"
                                               value="<?php echo $con_fec[22]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec23" id="con_fec23"
                                               value="<?php echo $con_fec[23]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec24" id="con_fec24"
                                               value="<?php echo $con_fec[24]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec25" id="con_fec25"
                                               value="<?php echo $con_fec[25]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec26" id="con_fec26"
                                               value="<?php echo $con_fec[26]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec27" id="con_fec27"
                                               value="<?php echo $con_fec[27]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec28" id="con_fec28"
                                               value="<?php echo $con_fec[28]; ?>"></td>
                                    <td><input type="date" readonly data-mini="true" name="con_fec29" id="con_fec29"
                                               value="<?php echo $con_fec[29]; ?>"></td>
                                </tr>
                                <?php if (is_null($repro['des_dia'])) { ?>
                                    <tr>
                                        <td><input type="text" class="numeros" name="con_od0" id="con_od0"
                                                   value="<?php echo $con_od[0]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od1" id="con_od1"
                                                   value="<?php echo $con_od[1]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od2" id="con_od2"
                                                   value="<?php echo $con_od[2]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od3" id="con_od3"
                                                   value="<?php echo $con_od[3]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od4" id="con_od4"
                                                   value="<?php echo $con_od[4]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od5" id="con_od5"
                                                   value="<?php echo $con_od[5]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od6" id="con_od6"
                                                   value="<?php echo $con_od[6]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od7" id="con_od7"
                                                   value="<?php echo $con_od[7]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od8" id="con_od8"
                                                   value="<?php echo $con_od[8]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od9" id="con_od9"
                                                   value="<?php echo $con_od[9]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od10" id="con_od10"
                                                   value="<?php echo $con_od[10]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od11" id="con_od11"
                                                   value="<?php echo $con_od[11]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od12" id="con_od12"
                                                   value="<?php echo $con_od[12]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od13" id="con_od13"
                                                   value="<?php echo $con_od[13]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od14" id="con_od14"
                                                   value="<?php echo $con_od[14]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od15" id="con_od15"
                                                   value="<?php echo $con_od[15]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od16" id="con_od16"
                                                   value="<?php echo $con_od[16]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od17" id="con_od17"
                                                   value="<?php echo $con_od[17]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od18" id="con_od18"
                                                   value="<?php echo $con_od[18]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od19" id="con_od19"
                                                   value="<?php echo $con_od[19]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od20" id="con_od20"
                                                   value="<?php echo $con_od[20]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od21" id="con_od21"
                                                   value="<?php echo $con_od[21]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od22" id="con_od22"
                                                   value="<?php echo $con_od[22]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od23" id="con_od23"
                                                   value="<?php echo $con_od[23]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od24" id="con_od24"
                                                   value="<?php echo $con_od[24]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od25" id="con_od25"
                                                   value="<?php echo $con_od[25]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od26" id="con_od26"
                                                   value="<?php echo $con_od[26]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od27" id="con_od27"
                                                   value="<?php echo $con_od[27]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od28" id="con_od28"
                                                   value="<?php echo $con_od[28]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_od29" id="con_od29"
                                                   value="<?php echo $con_od[29]; ?>" data-mini="true"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="numeros" name="con_oi0" id="con_oi0"
                                                   value="<?php echo $con_oi[0]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi1" id="con_oi1"
                                                   value="<?php echo $con_oi[1]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi2" id="con_oi2"
                                                   value="<?php echo $con_oi[2]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi3" id="con_oi3"
                                                   value="<?php echo $con_oi[3]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi4" id="con_oi4"
                                                   value="<?php echo $con_oi[4]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi5" id="con_oi5"
                                                   value="<?php echo $con_oi[5]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi6" id="con_oi6"
                                                   value="<?php echo $con_oi[6]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi7" id="con_oi7"
                                                   value="<?php echo $con_oi[7]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi8" id="con_oi8"
                                                   value="<?php echo $con_oi[8]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi9" id="con_oi9"
                                                   value="<?php echo $con_oi[9]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi10" id="con_oi10"
                                                   value="<?php echo $con_oi[10]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi11" id="con_oi11"
                                                   value="<?php echo $con_oi[11]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi12" id="con_oi12"
                                                   value="<?php echo $con_oi[12]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi13" id="con_oi13"
                                                   value="<?php echo $con_oi[13]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi14" id="con_oi14"
                                                   value="<?php echo $con_oi[14]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi15" id="con_oi15"
                                                   value="<?php echo $con_oi[15]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi16" id="con_oi16"
                                                   value="<?php echo $con_oi[16]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi17" id="con_oi17"
                                                   value="<?php echo $con_oi[17]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi18" id="con_oi18"
                                                   value="<?php echo $con_oi[18]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi19" id="con_oi19"
                                                   value="<?php echo $con_oi[19]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi20" id="con_oi20"
                                                   value="<?php echo $con_oi[20]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi21" id="con_oi21"
                                                   value="<?php echo $con_oi[21]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi22" id="con_oi22"
                                                   value="<?php echo $con_oi[22]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi23" id="con_oi23"
                                                   value="<?php echo $con_oi[23]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi24" id="con_oi24"
                                                   value="<?php echo $con_oi[24]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi25" id="con_oi25"
                                                   value="<?php echo $con_oi[25]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi26" id="con_oi26"
                                                   value="<?php echo $con_oi[26]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi27" id="con_oi27"
                                                   value="<?php echo $con_oi[27]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi28" id="con_oi28"
                                                   value="<?php echo $con_oi[28]; ?>" data-mini="true"></td>
                                        <td><input type="text" class="numeros" name="con_oi29" id="con_oi29"
                                                   value="<?php echo $con_oi[29]; ?>" data-mini="true"></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><input type="text" name="con_end0" id="con_end0" value="<?php echo $con_end[0]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end1" id="con_end1" value="<?php echo $con_end[1]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end2" id="con_end2" value="<?php echo $con_end[2]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end3" id="con_end3" value="<?php echo $con_end[3]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end4" id="con_end4" value="<?php echo $con_end[4]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end5" id="con_end5" value="<?php echo $con_end[5]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end6" id="con_end6" value="<?php echo $con_end[6]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end7" id="con_end7" value="<?php echo $con_end[7]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end8" id="con_end8" value="<?php echo $con_end[8]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end9" id="con_end9" value="<?php echo $con_end[9]; ?>"
                                               data-mini="true"></td>
                                    <td><input type="text" name="con_end10" id="con_end10"
                                               value="<?php echo $con_end[10]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end11" id="con_end11"
                                               value="<?php echo $con_end[11]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end12" id="con_end12"
                                               value="<?php echo $con_end[12]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end13" id="con_end13"
                                               value="<?php echo $con_end[13]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end14" id="con_end14"
                                               value="<?php echo $con_end[14]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end15" id="con_end15"
                                               value="<?php echo $con_end[15]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end16" id="con_end16"
                                               value="<?php echo $con_end[16]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end17" id="con_end17"
                                               value="<?php echo $con_end[17]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end18" id="con_end18"
                                               value="<?php echo $con_end[18]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end19" id="con_end19"
                                               value="<?php echo $con_end[19]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end20" id="con_end20"
                                               value="<?php echo $con_end[20]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end21" id="con_end21"
                                               value="<?php echo $con_end[21]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end22" id="con_end22"
                                               value="<?php echo $con_end[22]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end23" id="con_end23"
                                               value="<?php echo $con_end[23]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end24" id="con_end24"
                                               value="<?php echo $con_end[24]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end25" id="con_end25"
                                               value="<?php echo $con_end[25]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end26" id="con_end26"
                                               value="<?php echo $con_end[26]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end27" id="con_end27"
                                               value="<?php echo $con_end[27]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end28" id="con_end28"
                                               value="<?php echo $con_end[28]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con_end29" id="con_end29"
                                               value="<?php echo $con_end[29]; ?>" data-mini="true"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="con1_med1" id="con1_med1"
                                               value="<?php echo $con1_med[1]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med2" id="con1_med2"
                                               value="<?php echo $con1_med[2]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med3" id="con1_med3"
                                               value="<?php echo $con1_med[3]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med4" id="con1_med4"
                                               value="<?php echo $con1_med[4]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med5" id="con1_med5"
                                               value="<?php echo $con1_med[5]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med6" id="con1_med6"
                                               value="<?php echo $con1_med[6]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med7" id="con1_med7"
                                               value="<?php echo $con1_med[7]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med8" id="con1_med8"
                                               value="<?php echo $con1_med[8]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med9" id="con1_med9"
                                               value="<?php echo $con1_med[9]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med10" id="con1_med10"
                                               value="<?php echo $con1_med[10]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med11" id="con1_med11"
                                               value="<?php echo $con1_med[11]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med12" id="con1_med12"
                                               value="<?php echo $con1_med[12]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med13" id="con1_med13"
                                               value="<?php echo $con1_med[13]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med14" id="con1_med14"
                                               value="<?php echo $con1_med[14]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med15" id="con1_med15"
                                               value="<?php echo $con1_med[15]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med16" id="con1_med16"
                                               value="<?php echo $con1_med[16]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med17" id="con1_med17"
                                               value="<?php echo $con1_med[17]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med18" id="con1_med18"
                                               value="<?php echo $con1_med[18]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med19" id="con1_med19"
                                               value="<?php echo $con1_med[19]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med20" id="con1_med20"
                                               value="<?php echo $con1_med[20]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med21" id="con1_med21"
                                               value="<?php echo $con1_med[21]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med22" id="con1_med22"
                                               value="<?php echo $con1_med[22]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med23" id="con1_med23"
                                               value="<?php echo $con1_med[23]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med24" id="con1_med24"
                                               value="<?php echo $con1_med[24]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med25" id="con1_med25"
                                               value="<?php echo $con1_med[25]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med26" id="con1_med26"
                                               value="<?php echo $con1_med[26]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med27" id="con1_med27"
                                               value="<?php echo $con1_med[27]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med28" id="con1_med28"
                                               value="<?php echo $con1_med[28]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med29" id="con1_med29"
                                               value="<?php echo $con1_med[29]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con1_med30" id="con1_med30"
                                               value="<?php echo $con1_med[30]; ?>" data-mini="true"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="con2_med1" id="con2_med1"
                                               value="<?php echo $con2_med[1]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med2" id="con2_med2"
                                               value="<?php echo $con2_med[2]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med3" id="con2_med3"
                                               value="<?php echo $con2_med[3]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med4" id="con2_med4"
                                               value="<?php echo $con2_med[4]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med5" id="con2_med5"
                                               value="<?php echo $con2_med[5]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med6" id="con2_med6"
                                               value="<?php echo $con2_med[6]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med7" id="con2_med7"
                                               value="<?php echo $con2_med[7]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med8" id="con2_med8"
                                               value="<?php echo $con2_med[8]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med9" id="con2_med9"
                                               value="<?php echo $con2_med[9]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med10" id="con2_med10"
                                               value="<?php echo $con2_med[10]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med11" id="con2_med11"
                                               value="<?php echo $con2_med[11]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med12" id="con2_med12"
                                               value="<?php echo $con2_med[12]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med13" id="con2_med13"
                                               value="<?php echo $con2_med[13]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med14" id="con2_med14"
                                               value="<?php echo $con2_med[14]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med15" id="con2_med15"
                                               value="<?php echo $con2_med[15]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med16" id="con2_med16"
                                               value="<?php echo $con2_med[16]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med17" id="con2_med17"
                                               value="<?php echo $con2_med[17]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med18" id="con2_med18"
                                               value="<?php echo $con2_med[18]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med19" id="con2_med19"
                                               value="<?php echo $con2_med[19]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med20" id="con2_med20"
                                               value="<?php echo $con2_med[20]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med21" id="con2_med21"
                                               value="<?php echo $con2_med[21]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med22" id="con2_med22"
                                               value="<?php echo $con2_med[22]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med23" id="con2_med23"
                                               value="<?php echo $con2_med[23]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med24" id="con2_med24"
                                               value="<?php echo $con2_med[24]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med25" id="con2_med25"
                                               value="<?php echo $con2_med[25]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med26" id="con2_med26"
                                               value="<?php echo $con2_med[26]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med27" id="con2_med27"
                                               value="<?php echo $con2_med[27]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med28" id="con2_med28"
                                               value="<?php echo $con2_med[28]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med29" id="con2_med29"
                                               value="<?php echo $con2_med[29]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con2_med30" id="con2_med30"
                                               value="<?php echo $con2_med[30]; ?>" data-mini="true"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="con3_med1" id="con3_med1"
                                               value="<?php echo $con3_med[1]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med2" id="con3_med2"
                                               value="<?php echo $con3_med[2]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med3" id="con3_med3"
                                               value="<?php echo $con3_med[3]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med4" id="con3_med4"
                                               value="<?php echo $con3_med[4]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med5" id="con3_med5"
                                               value="<?php echo $con3_med[5]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med6" id="con3_med6"
                                               value="<?php echo $con3_med[6]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med7" id="con3_med7"
                                               value="<?php echo $con3_med[7]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med8" id="con3_med8"
                                               value="<?php echo $con3_med[8]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med9" id="con3_med9"
                                               value="<?php echo $con3_med[9]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med10" id="con3_med10"
                                               value="<?php echo $con3_med[10]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med11" id="con3_med11"
                                               value="<?php echo $con3_med[11]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med12" id="con3_med12"
                                               value="<?php echo $con3_med[12]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med13" id="con3_med13"
                                               value="<?php echo $con3_med[13]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med14" id="con3_med14"
                                               value="<?php echo $con3_med[14]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med15" id="con3_med15"
                                               value="<?php echo $con3_med[15]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med16" id="con3_med16"
                                               value="<?php echo $con3_med[16]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med17" id="con3_med17"
                                               value="<?php echo $con3_med[17]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med18" id="con3_med18"
                                               value="<?php echo $con3_med[18]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med19" id="con3_med19"
                                               value="<?php echo $con3_med[19]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med20" id="con3_med20"
                                               value="<?php echo $con3_med[20]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med21" id="con3_med21"
                                               value="<?php echo $con3_med[21]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med22" id="con3_med22"
                                               value="<?php echo $con3_med[22]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med23" id="con3_med23"
                                               value="<?php echo $con3_med[23]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med24" id="con3_med24"
                                               value="<?php echo $con3_med[24]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med25" id="con3_med25"
                                               value="<?php echo $con3_med[25]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med26" id="con3_med26"
                                               value="<?php echo $con3_med[26]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med27" id="con3_med27"
                                               value="<?php echo $con3_med[27]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med28" id="con3_med28"
                                               value="<?php echo $con3_med[28]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med29" id="con3_med29"
                                               value="<?php echo $con3_med[29]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con3_med30" id="con3_med30"
                                               value="<?php echo $con3_med[30]; ?>" data-mini="true"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="con4_med1" id="con4_med1"
                                               value="<?php echo $con4_med[1]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med2" id="con4_med2"
                                               value="<?php echo $con4_med[2]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med3" id="con4_med3"
                                               value="<?php echo $con4_med[3]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med4" id="con4_med4"
                                               value="<?php echo $con4_med[4]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med5" id="con4_med5"
                                               value="<?php echo $con4_med[5]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med6" id="con4_med6"
                                               value="<?php echo $con4_med[6]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med7" id="con4_med7"
                                               value="<?php echo $con4_med[7]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med8" id="con4_med8"
                                               value="<?php echo $con4_med[8]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med9" id="con4_med9"
                                               value="<?php echo $con4_med[9]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med10" id="con4_med10"
                                               value="<?php echo $con4_med[10]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med11" id="con4_med11"
                                               value="<?php echo $con4_med[11]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med12" id="con4_med12"
                                               value="<?php echo $con4_med[12]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med13" id="con4_med13"
                                               value="<?php echo $con4_med[13]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med14" id="con4_med14"
                                               value="<?php echo $con4_med[14]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med15" id="con4_med15"
                                               value="<?php echo $con4_med[15]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med16" id="con4_med16"
                                               value="<?php echo $con4_med[16]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med17" id="con4_med17"
                                               value="<?php echo $con4_med[17]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med18" id="con4_med18"
                                               value="<?php echo $con4_med[18]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med19" id="con4_med19"
                                               value="<?php echo $con4_med[19]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med20" id="con4_med20"
                                               value="<?php echo $con4_med[20]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med21" id="con4_med21"
                                               value="<?php echo $con4_med[21]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med22" id="con4_med22"
                                               value="<?php echo $con4_med[22]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med23" id="con4_med23"
                                               value="<?php echo $con4_med[23]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med24" id="con4_med24"
                                               value="<?php echo $con4_med[24]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med25" id="con4_med25"
                                               value="<?php echo $con4_med[25]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med26" id="con4_med26"
                                               value="<?php echo $con4_med[26]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med27" id="con4_med27"
                                               value="<?php echo $con4_med[27]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med28" id="con4_med28"
                                               value="<?php echo $con4_med[28]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med29" id="con4_med29"
                                               value="<?php echo $con4_med[29]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con4_med30" id="con4_med30"
                                               value="<?php echo $con4_med[30]; ?>" data-mini="true"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="con5_med1" id="con5_med1"
                                               value="<?php echo $con5_med[1]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med2" id="con5_med2"
                                               value="<?php echo $con5_med[2]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med3" id="con5_med3"
                                               value="<?php echo $con5_med[3]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med4" id="con5_med4"
                                               value="<?php echo $con5_med[4]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med5" id="con5_med5"
                                               value="<?php echo $con5_med[5]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med6" id="con5_med6"
                                               value="<?php echo $con5_med[6]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med7" id="con5_med7"
                                               value="<?php echo $con5_med[7]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med8" id="con5_med8"
                                               value="<?php echo $con5_med[8]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med9" id="con5_med9"
                                               value="<?php echo $con5_med[9]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med10" id="con5_med10"
                                               value="<?php echo $con5_med[10]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med11" id="con5_med11"
                                               value="<?php echo $con5_med[11]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med12" id="con5_med12"
                                               value="<?php echo $con5_med[12]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med13" id="con5_med13"
                                               value="<?php echo $con5_med[13]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med14" id="con5_med14"
                                               value="<?php echo $con5_med[14]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med15" id="con5_med15"
                                               value="<?php echo $con5_med[15]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med16" id="con5_med16"
                                               value="<?php echo $con5_med[16]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med17" id="con5_med17"
                                               value="<?php echo $con5_med[17]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med18" id="con5_med18"
                                               value="<?php echo $con5_med[18]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med19" id="con5_med19"
                                               value="<?php echo $con5_med[19]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med20" id="con5_med20"
                                               value="<?php echo $con5_med[20]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med21" id="con5_med21"
                                               value="<?php echo $con5_med[21]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med22" id="con5_med22"
                                               value="<?php echo $con5_med[22]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med23" id="con5_med23"
                                               value="<?php echo $con5_med[23]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med24" id="con5_med24"
                                               value="<?php echo $con5_med[24]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med25" id="con5_med25"
                                               value="<?php echo $con5_med[25]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med26" id="con5_med26"
                                               value="<?php echo $con5_med[26]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med27" id="con5_med27"
                                               value="<?php echo $con5_med[27]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med28" id="con5_med28"
                                               value="<?php echo $con5_med[28]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med29" id="con5_med29"
                                               value="<?php echo $con5_med[29]; ?>" data-mini="true"></td>
                                    <td><input type="text" name="con5_med30" id="con5_med30"
                                               value="<?php echo $con5_med[30]; ?>" data-mini="true"></td>
                                </tr>
                                <?php if ($repro['p_od'] == '' and is_null($repro['des_dia'])) { ?>
                                    <tr height="45">
                                        <td><input type="number" step="any" name="con_iny1" id="con_iny1"
                                                   value="<?php echo $con_iny[1]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny2" id="con_iny2"
                                                   value="<?php echo $con_iny[2]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny3" id="con_iny3"
                                                   value="<?php echo $con_iny[3]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny4" id="con_iny4"
                                                   value="<?php echo $con_iny[4]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny5" id="con_iny5"
                                                   value="<?php echo $con_iny[5]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny6" id="con_iny6"
                                                   value="<?php echo $con_iny[6]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny7" id="con_iny7"
                                                   value="<?php echo $con_iny[7]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny8" id="con_iny8"
                                                   value="<?php echo $con_iny[8]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny9" id="con_iny9"
                                                   value="<?php echo $con_iny[9]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny10" id="con_iny10"
                                                   value="<?php echo $con_iny[10]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny11" id="con_iny11"
                                                   value="<?php echo $con_iny[11]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny12" id="con_iny12"
                                                   value="<?php echo $con_iny[12]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny13" id="con_iny13"
                                                   value="<?php echo $con_iny[13]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny14" id="con_iny14"
                                                   value="<?php echo $con_iny[14]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny15" id="con_iny15"
                                                   value="<?php echo $con_iny[15]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny16" id="con_iny16"
                                                   value="<?php echo $con_iny[16]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny17" id="con_iny17"
                                                   value="<?php echo $con_iny[17]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny18" id="con_iny18"
                                                   value="<?php echo $con_iny[18]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny19" id="con_iny19"
                                                   value="<?php echo $con_iny[19]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny20" id="con_iny20"
                                                   value="<?php echo $con_iny[20]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny21" id="con_iny21"
                                                   value="<?php echo $con_iny[21]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny22" id="con_iny22"
                                                   value="<?php echo $con_iny[22]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny23" id="con_iny23"
                                                   value="<?php echo $con_iny[23]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny24" id="con_iny24"
                                                   value="<?php echo $con_iny[24]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny25" id="con_iny25"
                                                   value="<?php echo $con_iny[25]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny26" id="con_iny26"
                                                   value="<?php echo $con_iny[26]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny27" id="con_iny27"
                                                   value="<?php echo $con_iny[27]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny28" id="con_iny28"
                                                   value="<?php echo $con_iny[28]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny29" id="con_iny29"
                                                   value="<?php echo $con_iny[29]; ?>" data-mini="true"></td>
                                        <td><input type="number" step="any" name="con_iny30" id="con_iny30"
                                                   value="<?php echo $con_iny[30]; ?>" data-mini="true"></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><textarea name="con_obs0" id="con_obs0"
                                                  data-mini="true"><?php echo $con_obs[0]; ?></textarea></td>
                                    <td><textarea name="con_obs1" id="con_obs1"
                                                  data-mini="true"><?php echo $con_obs[1]; ?></textarea></td>
                                    <td><textarea name="con_obs2" id="con_obs2"
                                                  data-mini="true"><?php echo $con_obs[2]; ?></textarea></td>
                                    <td><textarea name="con_obs3" id="con_obs3"
                                                  data-mini="true"><?php echo $con_obs[3]; ?></textarea></td>
                                    <td><textarea name="con_obs4" id="con_obs4"
                                                  data-mini="true"><?php echo $con_obs[4]; ?></textarea></td>
                                    <td><textarea name="con_obs5" id="con_obs5"
                                                  data-mini="true"><?php echo $con_obs[5]; ?></textarea></td>
                                    <td><textarea name="con_obs6" id="con_obs6"
                                                  data-mini="true"><?php echo $con_obs[6]; ?></textarea></td>
                                    <td><textarea name="con_obs7" id="con_obs7"
                                                  data-mini="true"><?php echo $con_obs[7]; ?></textarea></td>
                                    <td><textarea name="con_obs8" id="con_obs8"
                                                  data-mini="true"><?php echo $con_obs[8]; ?></textarea></td>
                                    <td><textarea name="con_obs9" id="con_obs9"
                                                  data-mini="true"><?php echo $con_obs[9]; ?></textarea></td>
                                    <td><textarea name="con_obs10" id="con_obs10"
                                                  data-mini="true"><?php echo $con_obs[10]; ?></textarea></td>
                                    <td><textarea name="con_obs11" id="con_obs11"
                                                  data-mini="true"><?php echo $con_obs[11]; ?></textarea></td>
                                    <td><textarea name="con_obs12" id="con_obs12"
                                                  data-mini="true"><?php echo $con_obs[12]; ?></textarea></td>
                                    <td><textarea name="con_obs13" id="con_obs13"
                                                  data-mini="true"><?php echo $con_obs[13]; ?></textarea></td>
                                    <td><textarea name="con_obs14" id="con_obs14"
                                                  data-mini="true"><?php echo $con_obs[14]; ?></textarea></td>
                                    <td><textarea name="con_obs15" id="con_obs15"
                                                  data-mini="true"><?php echo $con_obs[15]; ?></textarea></td>
                                    <td><textarea name="con_obs16" id="con_obs16"
                                                  data-mini="true"><?php echo $con_obs[16]; ?></textarea></td>
                                    <td><textarea name="con_obs17" id="con_obs17"
                                                  data-mini="true"><?php echo $con_obs[17]; ?></textarea></td>
                                    <td><textarea name="con_obs18" id="con_obs18"
                                                  data-mini="true"><?php echo $con_obs[18]; ?></textarea></td>
                                    <td><textarea name="con_obs19" id="con_obs19"
                                                  data-mini="true"><?php echo $con_obs[19]; ?></textarea></td>
                                    <td><textarea name="con_obs20" id="con_obs20"
                                                  data-mini="true"><?php echo $con_obs[20]; ?></textarea></td>
                                    <td><textarea name="con_obs21" id="con_obs21"
                                                  data-mini="true"><?php echo $con_obs[21]; ?></textarea></td>
                                    <td><textarea name="con_obs22" id="con_obs22"
                                                  data-mini="true"><?php echo $con_obs[22]; ?></textarea></td>
                                    <td><textarea name="con_obs23" id="con_obs23"
                                                  data-mini="true"><?php echo $con_obs[23]; ?></textarea></td>
                                    <td><textarea name="con_obs24" id="con_obs24"
                                                  data-mini="true"><?php echo $con_obs[24]; ?></textarea></td>
                                    <td><textarea name="con_obs25" id="con_obs25"
                                                  data-mini="true"><?php echo $con_obs[25]; ?></textarea></td>
                                    <td><textarea name="con_obs26" id="con_obs26"
                                                  data-mini="true"><?php echo $con_obs[26]; ?></textarea></td>
                                    <td><textarea name="con_obs27" id="con_obs27"
                                                  data-mini="true"><?php echo $con_obs[27]; ?></textarea></td>
                                    <td><textarea name="con_obs28" id="con_obs28"
                                                  data-mini="true"><?php echo $con_obs[28]; ?></textarea></td>
                                    <td><textarea name="con_obs29" id="con_obs29"
                                                  data-mini="true"><?php echo $con_obs[29]; ?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div data-role="collapsible" id="aspira_block">
                        <h3><?php if (is_null($repro['des_dia'])) echo "Fecha de Inyección"; else if ($repro['des_dia'] === 0) echo "Fecha de Inseminación"; else echo "Fecha de Transferencia"; ?></h3>
                        <div class="enlinea">
                            <?php if (is_null($repro['des_dia'])) echo "Fecha de Inyección:"; else if ($repro['des_dia'] === 0) echo "Fecha de Inseminación:"; else echo "Fecha de Transferencia:"; ?>
                            <div data-role="controlgroup" data-type="horizontal" data-mini="true" class="peke">
                                <input type="date" name="f_iny" id="f_iny" value="<?php echo $repro['f_iny']; ?>"
                                       data-wrapper-class="controlgroup-textinput ui-btn" class="inyeccion">

                                <select name="h_iny" id="h_iny" class="inyeccion">
                                    <option value="">Hora</option>
                                    <?php if (!is_null($repro['des_dia'])) { ?>
                                        <option value="10:15" <?php if ($repro['h_iny'] == "10:15") echo "selected"; ?>>
                                            10:15 hrs
                                        </option>
                                        <option value="11:00" <?php if ($repro['h_iny'] == "11:00") echo "selected"; ?>>
                                            11:00 hrs
                                        </option>
                                        <option value="11:45" <?php if ($repro['h_iny'] == "11:45") echo "selected"; ?>>
                                            11:45 hrs
                                        </option>
                                        <option value="12:30" <?php if ($repro['h_iny'] == "12:30") echo "selected"; ?>>
                                            12:30 hrs
                                        </option>
                                        <option value="13:15" <?php if ($repro['h_iny'] == "13:15") echo "selected"; ?>>
                                            13:15 hrs
                                        </option>
                                        <option value="14:00" <?php if ($repro['h_iny'] == "14:00") echo "selected"; ?>>
                                            14:00 hrs
                                        </option>
                                        <option value="14:45" <?php if ($repro['h_iny'] == "14:45") echo "selected"; ?>>
                                            14:45 hrs
                                        </option>
                                        <option value="15:30" <?php if ($repro['h_iny'] == "15:30") echo "selected"; ?>>
                                            15:30 hrs
                                        </option>
                                        <option value="16:15" <?php if ($repro['h_iny'] == "16:15") echo "selected"; ?>>
                                            16:15 hrs
                                        </option>
                                        <option value="17:00" <?php if ($repro['h_iny'] == "17:00") echo "selected"; ?>>
                                            17:00 hrs
                                        </option>
                                        <option value="17:45" <?php if ($repro['h_iny'] == "17:45") echo "selected"; ?>>
                                            17:45 hrs
                                        </option>
                                        <option value="18:30" <?php if ($repro['h_iny'] == "18:30") echo "selected"; ?>>
                                            18:30 hrs
                                        </option>
                                        <option value="19:15" <?php if ($repro['h_iny'] == "19:15") echo "selected"; ?>>
                                            19:15 hrs
                                        </option>
                                        <option value="20:00" <?php if ($repro['h_iny'] == "20:00") echo "selected"; ?>>
                                            20:00 hrs
                                        </option>
                                    <?php } else { ?>
                                        <option value="19:15" <?php if ($repro['h_iny'] == "19:15") echo "selected"; ?>>
                                            19:15 hrs
                                        </option>
                                        <option value="20:00" <?php if ($repro['h_iny'] == "20:00") echo "selected"; ?>>
                                            20:00 hrs
                                        </option>
                                        <option value="20:45" <?php if ($repro['h_iny'] == "20:45") echo "selected"; ?>>
                                            20:45 hrs
                                        </option>
                                        <option value="21:30" <?php if ($repro['h_iny'] == "21:30") echo "selected"; ?>>
                                            21:30 hrs
                                        </option>
                                        <option value="22:15" <?php if ($repro['h_iny'] == "22:15") echo "selected"; ?>>
                                            22:15 hrs
                                        </option>
                                        <option value="23:00" <?php if ($repro['h_iny'] == "23:00") echo "selected"; ?>>
                                            23:00 hrs
                                        </option>
                                        <option value="23:45" <?php if ($repro['h_iny'] == "23:45") echo "selected"; ?>>
                                            23:45 hrs
                                        </option>
                                        <option value="0:30" <?php if ($repro['h_iny'] == "0:30") echo "selected"; ?>>0:30
                                            hrs
                                        </option>
                                        <option value="1:15" <?php if ($repro['h_iny'] == "1:15") echo "selected"; ?>>1:15
                                            hrs
                                        </option>
                                        <option value="2:00" <?php if ($repro['h_iny'] == "2:00") echo "selected"; ?>>2:00
                                            hrs
                                        </option>
                                        <option value="2:45" <?php if ($repro['h_iny'] == "2:45") echo "selected"; ?>>2:45
                                            hrs
                                        </option>
                                        <option value="3:30" <?php if ($repro['h_iny'] == "3:30") echo "selected"; ?>>3:30
                                            hrs
                                        </option>
                                        <option value="4:15" <?php if ($repro['h_iny'] == "4:15") echo "selected"; ?>>4:15
                                            hrs
                                        </option>
                                        <option value="5:00" <?php if ($repro['h_iny'] == "5:00") echo "selected"; ?>>5:00
                                            hrs
                                        </option>
                                        <option value="5:45" <?php if ($repro['h_iny'] == "5:45") echo "selected"; ?>>5:45
                                            hrs
                                        </option>
                                        <option value="6:30" <?php if ($repro['h_iny'] == "6:30") echo "selected"; ?>>6:30
                                            hrs
                                        </option>
                                        <option value="7:15" <?php if ($repro['h_iny'] == "7:15") echo "selected"; ?>>7:15
                                            hrs
                                        </option>
                                        <option value="8:00" <?php if ($repro['h_iny'] == "8:00") echo "selected"; ?>>8:00
                                            hrs
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (is_null($repro['des_dia'])) echo "Fecha de Aspiración (en 36 hrs):"; else echo "Fecha de Descongelación:"; ?>
                            <input name="f_asp" type="datetime-local" id="f_asp" value="<?php echo $repro['f_asp']; ?>"
                                   readonly/>
                            <font color="#E34446"> (REVISAR DISPONIBILIDAD EN SALA) <b>Solo puede agendar para mañana
                                    hasta las 3pm de hoy</b></font>
                        </div>
                        <iframe src="agenda.php" width="100%" height="800" seamless></iframe>
                    </div>

                </div>

                <?php if ($repro['p_iiu'] > 0) {
                    $Rcap = $db->prepare("SELECT id,fec,p_dni,emb,h_cap FROM lab_andro_cap WHERE iiu=?");
                    $Rcap->execute(array($repro['id']));
                    $cap = $Rcap->fetch(PDO::FETCH_ASSOC); ?>
                    <div class="ui-block-b" style="width:200px">
                        <div class="ui-bar ui-bar-b" align="center">
                            Fecha de Capacitación:
                            <?php if ($Rcap->rowCount() > 0) {
                                echo date("d-m-Y", strtotime($cap['fec'])) . ' <small>' . $cap['h_cap'] . '</small>';

                                if ($cap['emb'] > 0) echo '<a href="info.php?T=cap&a=' . $cap['p_dni'] . '&b=' . $cap['id'] . '&c=' . $repro['dni'] . '" target="new">Ver Informe</a>'; else echo '<br>Resultado Pendiente..';
                            } else { ?>
                                <input type="date" name="f_cap" id="f_cap">
                                <select name="fec_h" id="fec_h" data-mini="true">
                                    <option value="08">08
                                        hrs
                                    </option>
                                    <option value="09">09
                                        hrs
                                    </option>
                                    <option value="10">10
                                        hrs
                                    </option>
                                    <option value="11">11
                                        hrs
                                    </option>
                                    <option value="12">12
                                        hrs
                                    </option>
                                    <option value="13">13
                                        hrs
                                    </option>
                                    <option value="14">14
                                        hrs
                                    </option>
                                    <option value="15">15
                                        hrs
                                    </option>
                                    <option value="16">16
                                        hrs
                                    </option>
                                </select>
                                <select name="fec_m" id="fec_m" data-mini="true">
                                    <option value="00">00
                                        min
                                    </option>
                                    <option value="15">15
                                        min
                                    </option>
                                    <option value="30">30
                                        min
                                    </option>
                                    <option value="45">45
                                        min
                                    </option>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <h3>Observaciones:</h3><textarea name="obs" id="obs"><?php echo $repro['obs']; ?></textarea>

                <?php if ($repro['med'] == $login) {
                    if ($lock <> 1 and $repro['cancela'] <> 2) { //Puede editar hasta la fecha de inyeccion ?>
                        <div class="enlinea">
                            <input type="Submit" value="GUARDAR DATOS" data-icon="check" data-iconpos="left" data-mini="true" class="show-page-loading-msg" data-textonly="false" data-textvisible="true" data-msgtext="Actualizando datos.." data-theme="b" data-inline="true"/>
                            <input type="checkbox" name="cancela" id="cancela" data-mini="true" value=1 <?php if ($repro['cancela'] == 1) echo "checked"; ?>>
                            <label for="cancela">Cancelar Reproducción</label>
                        </div>
                    <?php } else {
                        if (is_null($repro['des_dia'])) $titulo = "Aspiración"; else $titulo = "Descongelación";
                        echo '<font color="#E34446"><b>SOLO LECTURA!</b> ' . $titulo . ' programada, para modificaciones llamar a Jefa de Sala</font>';
                    }
                } else {
                    echo '<font color="#E34446"><b>PERMISO DE EDICION SOLO PARA: </b> ' . $repro['med'] . '</font>';
                } ?>
            </form>
        </div><!-- /content -->
    <?php } ?>
</div><!-- /page -->
<script>
    $(document).on("click", ".show-page-loading-msg", function () {
        if (document.getElementById("repro").value == "") {
            alert("Debe ingresar la Reproducción Asistida");
            return false;
        }        
        if (document.getElementById("p_dnix").value == "") {
            alert("Debe ingresar la Pareja");
            return false;
        }
        if (document.getElementById("t_muex").value == "") {
            alert("Debe ingresar el tipo de Muestra");
            return false;
        }
        if (document.getElementById("cancela").checked == true && document.getElementById("obs").value == "") {
            alert("Debe ingresar en Observaciones el motivo de la cancelación");
            return false;
        }
        if (document.getElementById("eda").value == 0) {
            alert("Debe llenar el campo EDAD (en Mujer Antecedentes)");
            return false;
        }
        /*if (document.getElementById("f_fem").value == "" || document.getElementById("f_mas").value == "") {
         alert ("Debe ingresar la Etiología Femenina y Masculina!");
         return false;
         }
         */
        if (document.getElementById("recep_num")) {
            if (document.getElementById("recep_num").value == 0) {
                alert("Debe asociar al menos 1 Receptora!");
                return false;
            }
        }

        if (document.getElementById("des_dia").value === "") {

            if (document.getElementById("hete_chk").value == 1) { // esto se repite mas abajo porque si se ponen arriba genera error porque el valor hete_chk no existe cuando des_dia mayor que 1
                if (document.getElementById("p_dni_het").value === "") {
                    alert("Debe ingresar un Donante (Heterólogo)");
                    return false;
                }
            }

            if (document.getElementById("fec_iny_activo").value == 1) {

                if (document.getElementById("n_fol").value == 0) {
                    alert("Debe llenar Número de Folículos");
                    return false;
                }
                if (document.getElementById("f_asp").value == "") {
                    alert("Debe ingresar la Fecha de Aspiración!");
                    return false;
                }
            }
        } else {
            if (document.getElementById("des_dia").value == 0) {

                if (document.getElementById("hete_chk").value == 1) {
                    if (document.getElementById("p_dni_het").value === "") {
                        alert("Debe ingresar un Donante (Heterólogo)");
                        return false;
                    }
                }
            }
            if (document.getElementById("f_iny").value != "" || document.getElementById("h_iny").value != "-") {

                if (document.getElementById("f_asp").value == "") {
                    alert("Debe ingresar la Fecha de Descongelación!");
                    return false;
                }
            }

        }
        var $this = $(this),
            theme = $this.jqmData("theme") || $.mobile.loader.prototype.options.theme,
            msgText = $this.jqmData("msgtext") || $.mobile.loader.prototype.options.text,
            textVisible = $this.jqmData("textvisible") || $.mobile.loader.prototype.options.textVisible,
            textonly = !!$this.jqmData("textonly");
        html = $this.jqmData("html") || "";
        $.mobile.loading("show", {
            text: msgText,
            textVisible: textVisible,
            theme: theme,
            textonly: textonly,
            html: html
        });
    })
        .on("click", ".hide-page-loading-msg", function () {
            $.mobile.loading("hide");
        });
</script>
</body>
</html>