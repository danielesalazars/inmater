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
    <style>
        #alerta {
            background-color: #FF9;
            margin: 0 auto;
            text-align: center;
            padding: 4px;
        }

        .scroll_h {
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
        }

        .peke .ui-input-text {
            width: 100px !important;
        }

        .peke2 .ui-input-text {
            width: 50px !important;
        }

        .controlgroup-textinput {
            padding-top: 0.5px;
            padding-bottom: 0.5px;
        }

        .bg_C {
            background-color: rgba(124, 203, 231, 0.30);
        }

        .bg_D {
            background-color: rgba(236, 215, 107, 1.30);
        }

        .bg_N {
            background-color: rgba(240, 131, 132, 0.30);
        }

        .enlinea div {
            display: inline-block;
            vertical-align: middle;
        }
        .libro .ui-input-text {
            width: 70px !important;
            background-color: rgba(124, 203, 231, 0.30);
        }
    </style>
    <script>
        $(document).ready(function () {

            $('#form1').submit(function () {

                $("#cargador").popup("open", {positionTo: "window"});
                return true;

            });

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

            $(".val_defect").change(function () {
                var med = $(this).attr("title");
                var items = $(this).val();

                if (items == "MII") {
                    $('#mor' + med).val('N,');
                    $('#mor' + med).textinput("refresh", true);
                    $('#z_pel' + med + '-button').show();
                    $('#z_pel' + med).val('N');
                    $('#z_pel' + med).selectmenu("refresh", true);
                    $('#rot' + med + '-button').show();
                    $('#rot' + med).val('RP');
                    $('#rot' + med).selectmenu("refresh", true);
                    $('#inte' + med + '-button').show();
                    $('#inte' + med).val(1);
                    $('#inte' + med).selectmenu("refresh", true);

                    $('#mor' + med).prop("required", true);
                    $('#z_pel' + med).prop("required", true);
                    $('#rot' + med).prop("required", true);
                    $('#inte' + med).prop("required", true);

                } else {
                    $('#mor' + med).val('');
                    $('#mor' + med).textinput("refresh", true);
                    //$('#z_pel'+med).val(''); $('#z_pel'+med).textinput( "refresh", true );
                    //$('#rot'+med).val(''); $('#rot'+med).selectmenu( "refresh", true );
                    //$('#inte'+med).val(''); $('#inte'+med).selectmenu( "refresh", true );

                    $('#mor' + med).prop("required", false);
                    $('#z_pel' + med).prop("required", false);
                    $('#z_pel' + med + '-button').hide();
                    $('#rot' + med).prop("required", false);
                    $('#rot' + med + '-button').hide();
                    $('#inte' + med).prop("required", false);
                    $('#inte' + med + '-button').hide();
                }

                $(this).selectmenu("refresh", true);
            });

            $(".med_insert").change(function () {
                var med = $(this).attr("title");
                var str = $('#' + med).val();
                var items = $(this).val();

                var n = str.indexOf(items);

                if (n == -1 || items == "N") {	// no agrega duplicados -----------------------------------------------------
                    $('#' + med).val(items + ", " + str);
                    if (items == "N") $('#' + med).val("N");
                    if (items == "Borrar") $('#' + med).val("");
                    $('#' + med).textinput('refresh');
                }

                $(this).prop('selectedIndex', 0);
                $(this).selectmenu("refresh", true);
            });

            $(".f_cic").change(function () {
                var med = $(this).attr("title");
                var items = $(this).val();
                var id = $(this).attr("id");
                $('#fila' + id).removeClass();
                if (items == "D") $('#fila' + id).addClass('bg_D');
                if (items == "N") $('#fila' + id).addClass('bg_N');

                if (items == "C") {
                    $('#crio' + med).show();
                    $('#fila' + id).addClass('bg_C');
                } else {
                    $('#crio' + med).hide();
                    $('#T' + med + ',#C' + med + ',#G' + med + ',#P' + med).val('');
                }

            });

            $("#don_todo").change(function () {

                if ($(this).prop('checked')) {
                    $(".scroll_h").hide();
                    $(".enlinea .peke").hide();
                    $(".enlinea .peke2").show();
                    $("#nuevo_pro,#n_ovo,#n_ins,#o_ovo,#emb0,#emb_a,#f_pun,#inc").prop('required', false);
                } else {
                    $(".scroll_h").show();
                    $(".enlinea .peke").show();
                    $(".enlinea .peke2").hide();
                    $("#nuevo_pro,#n_ovo,#n_ins,#o_ovo,#emb0,#emb_a,#f_pun,#inc").prop('required', true);
                }
            });

            $("#p_cri").change(function () {

                if ($(this).prop('checked')) {
                    $("#hra0,#n_ins,#emb0-button").hide();
                    $("#hra0,#n_ins,#emb0").prop('required', false);
                } else {
                    $("#hra0,#n_ins,#emb0-button").show();
                    $("#hra0,#n_ins,#emb0").prop('required', true);
                }
            });

            $(".fotox").change(function () {
                var idfoto = $(this).attr("name");
                if ($(this).val() == '') {
                    $("#l" + idfoto).removeClass("bg_N");
                } else {
                    $("#l" + idfoto).addClass("bg_N");
                }
            });
        });

    </script>
</head>

<body>
<?php $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($user['role'] == 2) {

    if ((isSet($_POST['n_ovo']) or $_POST['don_todo'] == 1) and $_POST['guardar'] == "GUARDAR DATOS") {
        $cancela = 0;
        $c = $_POST['c'];

        if ($c > 0) {
            if ($_POST['don'] == 'D') $don = 1; else $don = 0;

            for ($i = 1; $i <= $c; $i++) {

                if ($_POST['f_cic' . $i] == "O") {
                    if ($_POST['anu' . $i] == 1) $anu = 0; else $anu = $_POST['anu' . $i];
                } else {
                    $anu = 1;
                    $cancela++;
                }

                lab_updateAspi_d0($_POST['pro'], $i, $anu, $_POST['est' . $i], $_POST['mor' . $i], $_POST['z_pel' . $i], $_POST['rot' . $i], $_POST['inte' . $i], $_POST['f_cic' . $i], $_POST['obs' . $i], $_POST['T' . $i], $_POST['C' . $i], $_POST['G' . $i], $_POST['P' . $i], $_POST['col' . $i], $don, $_FILES['i' . $i]);
            }
        }

        $f_fin = "";
        if ($_POST['n_ovo'] == 0) $f_fin = date("Y-m-d");


        if ($c > 0) {
            $dia = 1;
            $dia_sta = 'Dia 1';
        } else {
            $dia = 0;
            $dia_sta = 'Dia 0';
        }

        if ($_POST['pro'] == "") { //No hay protocolo , solo id de reproducion------------------------------------------------------------------

            if ($_POST['don_todo'] == 1)
                lab_don_todo($_POST['rep']);
            else
                lab_insertAspi($_POST['nuevo_pro'] . "-" . date("y"), $_POST['rep'], $_POST['tip'], $_POST['dni'], $_POST['f_pun'], $_POST['o_ovo'], $_POST['pen'], $_POST['end'], $_POST['n_ovo'], $_POST['obs'], $_POST['obs_med'], $_POST['s_pun'], $_POST['s_cum'], $dia_sta, $dia, $_POST['n_ins'], $_POST['hra0'], $_POST['emb0'], $_POST['hra_a'], $_POST['emb_a'], $f_fin, $_POST['p_cic'], $_POST['p_fiv'], $_POST['p_icsi'], $_POST['p_cri'], $_POST['p_extras'], $_POST['inc']);

        } else { // Ya existe protocolo ------------------------------------------

            if ($_POST['dias'] <= 1)
                lab_updateAspi($_POST['pro'], $dia_sta, $dia, $f_fin);

            if ($c > 0 and $cancela == $c) {
                if ($_POST['dias'] > 1)
                    lab_updateAspi_sta($_POST['pro'], 'Dia 0', 1, $_POST['hra0'], $_POST['emb0'], $_POST['hra0c'], $_POST['emb0c']);
                lab_updateAspi_fin($_POST['pro']);
            }
            lab_updateRepro($_POST['rep'], $_POST['p_cic'], $_POST['p_fiv'], $_POST['p_icsi'], $_POST['p_cri'], $_POST['p_extras'], $dia, $_POST['o_ovo'], $_POST['pen'], $_POST['end'], $_POST['s_pun'], $_POST['s_cum'], $_POST['n_ins'], $_POST['hra0'], $_POST['emb0'], $_POST['hra0c'], $_POST['emb0c'], $_POST['hra_a'], $_POST['emb_a'], $_POST['obs'], $_POST['obs_med'], $_POST['book'], $_POST['hoja'], $_POST['inc']);
        }

    }

    if ($_GET['rep'] <> '') { // si aun esta en fase de repdroduccion ------------
        $rPaci = $db->prepare("SELECT id AS rep,eda,p_cic,p_fiv,p_icsi,p_od,p_don,p_cri,p_extras,pago_extras,dni,p_dni,id,med,des_dia FROM hc_reprod WHERE id=?");
        $rPaci->execute(array($_GET['rep']));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);
    }

    if ($_GET['id'] <> '') { // si ya existe el protocolo ------------------------
        $rPaci = $db->prepare("SELECT lab_aspira.*,hc_reprod.id,hc_reprod.eda,hc_reprod.p_cic,hc_reprod.p_fiv,hc_reprod.p_icsi,hc_reprod.p_od,hc_reprod.p_don,hc_reprod.p_cri,hc_reprod.p_extras,hc_reprod.pago_extras,hc_reprod.p_dni,hc_reprod.p_dni_het,hc_reprod.med,hc_reprod.des_dia FROM lab_aspira LEFT JOIN hc_reprod ON hc_reprod.id=lab_aspira.rep WHERE lab_aspira.pro=?");
        $rPaci->execute(array($_GET['id']));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);

        $campos = "ovo,anu,d0est,d0mor,d0z_pel,d0rot,d0inte,d0f_cic,obs,T,C,G,P,col,des,don";
        $rAspi = $db->prepare("SELECT " . $campos . " FROM lab_aspira_dias WHERE pro=?");
        $rAspi->execute(array($_GET['id']));

        if ($rAspi->rowCount() == 0) { // inserta los ovulos por primera vez

            for ($i = 1; $i <= $paci['n_ovo']; $i++) {
                lab_insertAspi_ovos($paci['pro'], $i);
            }
            $fec0 = $paci['f_pun'];
            $fec1 = endCycle($fec0, 1);
            $fec2 = endCycle($fec0, 2);
            $fec3 = endCycle($fec0, 3);
            $fec4 = endCycle($fec0, 4);
            $fec5 = endCycle($fec0, 5);
            $fec6 = endCycle($fec0, 6);
            lab_updateAspi_fec_dia($paci['pro'], $fec0, $fec1, $fec2, $fec3, $fec4, $fec5, $fec6);
            $rAspi = $db->prepare("SELECT " . $campos . " FROM lab_aspira_dias WHERE pro=?");
            $rAspi->execute(array($_GET['id']));
        }

    }

    $rMujer = $db->prepare("SELECT nom,ape,don FROM hc_paciente WHERE dni=?");
    $rMujer->execute(array($paci['dni']));
    $mujer = $rMujer->fetch(PDO::FETCH_ASSOC);

    $rHombre = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
    $rHombre->execute(array($paci['p_dni']));
    $hombre = $rHombre->fetch(PDO::FETCH_ASSOC);
    if ($paci['p_dni'] == "") $pareja = "SOLTERA"; else $pareja = $hombre['p_ape'] . " " . $hombre['p_nom'];

    $rEmb = $db->prepare("SELECT id,nom FROM lab_user WHERE sta=0");
    $rEmb->execute();
    $rEmb->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $rEmb->fetchAll();

if ($paci['tip'] == 'T') { // Traslado ?>
    <script>
        $(document).ready(function () {
            $('.no_traslado').hide();
            $(".f_cic option[value='O']").remove();
        });
    </script>
<?php } ?>

<?php if ($paci['p_cri'] == 1) { ?>
    <script>
        $(document).ready(function () {
            $("#hra0,#n_ins,#emb0-button").hide();
            $("#hra0,#n_ins,#emb0").prop('required', false);
        });
    </script>
<?php } ?>
    <form action="le_aspi0.php" method="post" enctype="multipart/form-data" data-ajax="false" id="form1">

        <div data-role="page" class="ui-responsive-panel" id="le_aspi0">
            <div data-role="panel" id="indice_paci">
                <img src="_images/logo.jpg"/>
                <ul data-role="listview" data-inset="true" data-theme="a">
                    <li data-role="list-divider"><h1><a href="lista_pro.php" rel="external" style="color:#000000">Lista
                                de Procedimientos</a></h1></li>
                    <li data-theme="b" class="ui-disabled"><a href="<?php echo "le_aspi0.php?id=" . $paci['pro']; ?>"
                                                              rel="external">Dia 0</a></li>
                    <?php if ($paci['dias'] >= 1) { ?>
                        <li><a href="<?php echo "le_aspi1.php?id=" . $paci['pro']; ?>" rel="external">Dia 1</a>
                        </li> <?php } ?>
                    <?php if ($paci['dias'] >= 2) { ?>
                        <li><a href="<?php echo "le_aspi2.php?id=" . $paci['pro']; ?>" rel="external">Dia 2</a>
                        </li> <?php } ?>
                    <?php if ($paci['dias'] >= 3) { ?>
                        <li><a href="<?php echo "le_aspi3.php?id=" . $paci['pro']; ?>" rel="external">Dia 3</a>
                        </li> <?php } ?>
                    <?php if ($paci['dias'] >= 4) { ?>
                        <li><a href="<?php echo "le_aspi4.php?id=" . $paci['pro']; ?>" rel="external">Dia 4</a>
                        </li> <?php } ?>
                    <?php if ($paci['dias'] >= 5) { ?>
                        <li><a href="<?php echo "le_aspi5.php?id=" . $paci['pro']; ?>" rel="external">Dia 5</a>
                        </li> <?php } ?>
                    <?php if ($paci['dias'] >= 6) { ?>
                        <li><a href="<?php echo "le_aspi6.php?id=" . $paci['pro']; ?>" rel="external">Dia 6</a>
                        </li> <?php } ?>
                </ul>
                <div data-role="collapsible" data-mini="true">
                    <h3>Historia Clínica</h3>
                    <ul data-role="listview">
                        <li data-theme="b"><a href="<?php echo "e_paci.php?id=" . $paci['dni']; ?>" rel="external">Datos y
                                Antecedentes</a></li>
                        <li data-theme="b"><a href="<?php echo "n_pare.php?id=" . $paci['dni']; ?>"
                                              rel="external">Pareja</a></li>
                        <li data-theme="b"><a href="<?php echo "n_gine.php?id=" . $paci['dni']; ?>" rel="external">Ginecología</a>
                        </li>
                        <li data-theme="b"><a href="<?php echo "n_obst.php?id=" . $paci['dni']; ?>" rel="external">Obstetricia</a>
                        </li>
                        <li data-theme="b"><a href="<?php echo "n_repro.php?id=" . $paci['dni']; ?>" rel="external">Repro.
                                Asistida</a></li>
                    </ul>
                </div>
            </div><!-- /panel -->

            <div data-role="header" data-position="fixed">
                <a href="#indice_paci" data-icon="bars" id="b_indice" class="ui-icon-alt" data-theme="a">MENU
                    <small>> Dia 0 </small>
                </a>
                <h2><?php if ($paci['tip'] == 'T') echo "(" . $paci['pro'] . ")"; else echo "(" . $paci['tip'] . "-" . $paci['pro'] . "-" . $paci['vec'] . ")";
                    echo " Dia 0"; if ($paci['fec0'] and $paci['fec0'] <> '0000-00-00') echo ': <small>'.date("d-m-Y", strtotime($paci['fec0'])).'</small>'; ?></h2>
                <a href="index.php"
                   class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power"
                   rel="external"> Salir</a>
                <div style="background-color:#d7e5e5; width:100%; font-size:13px; text-align:center;"><?php echo $mujer['ape'] . " " . $mujer['nom'] . " (" . $paci['eda'] . ") / " . $pareja . " (Medico: " . $paci['med'] . ")" ?></div>
            </div><!-- /header -->

            <div class="ui-content" role="main">
                <input type="hidden" name="pro" id="pro" value="<?php echo $paci['pro']; ?>">
                <!--id="pro" se usa en el javascript-->
                <input type="hidden" name="rep" value="<?php echo $paci['rep']; ?>">
                <input type="hidden" name="dni" value="<?php echo $paci['dni']; ?>">
                <input type="hidden" name="don" value="<?php echo $mujer['don']; ?>">
                <input type="hidden" name="dias" value="<?php echo $paci['dias']; ?>">

                <?php if ($_GET['rep'] <> '') {
                    $tip = "P";
                    if ($paci['p_od'] <> '') $tip = "R";
                    if ($paci['p_don'] == 1) $tip = "D"; ?>
                    <div class="enlinea ui-bar-a"
                         style="margin: 0 auto;max-width:350px;font-size:small;text-align:center;">
<span class="peke">
N. Protocólo 
<input type="hidden" name="tip" value="<?php echo $tip; ?>"><?php echo $tip; ?>-<input type="number" name="nuevo_pro"
                                                                                 id="nuevo_pro" min="0"
                                                                                 required><?php echo "-" . date("y"); ?></span>
                        <?php if ($tip == "D") { ?>
                            <span class="peke2" style="display:none;">Sin N. Protocólo</span>
                            <input type="checkbox" name="don_todo" id="don_todo" data-mini="true" value=1><label
                                    for="don_todo">Donar Todos</label>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="scroll_h" style="background-color:rgba(189,213,211,1.00)">
                    <table width="100%" align="center" style="margin: 0 auto;font-size:small;">
                        <tr>
                            <td width="13%" rowspan="3" valign="top" class="no_traslado">
                                <div data-role="controlgroup" data-mini="true">
                                    <input type="checkbox" name="p_cic" id="p_cic" data-mini="true"
                                           value=1 <?php if ($paci['p_cic'] == 1) echo "checked"; ?>>
                                    <label for="p_cic">Ciclo Natural</label>
                                    <input type="checkbox" name="p_fiv" id="p_fiv" data-mini="true"
                                           value=1 <?php if ($paci['p_fiv'] == 1) echo "checked"; ?>>
                                    <label for="p_fiv">FIV</label>
                                    <input type="checkbox" name="p_icsi" id="p_icsi" data-mini="true"
                                           value=1 <?php if ($paci['p_icsi'] == 1) echo "checked"; ?>>
                                    <label for="p_icsi">ICSI</label>
                                    <input type="checkbox" name="p_cri" id="p_cri" data-mini="true"
                                           value=1 <?php if ($paci['p_cri'] == 1) echo "checked"; ?>>
                                    <label for="p_cri">Crio Ovos</label>
                                    <?php if ($paci['p_od'] <> '') echo '(OD Fresco)<input type="hidden" name="p_od" value="' . $paci['p_od'] . '">';
                                    if ($paci['p_don'] == 1) echo '(Donación Fresco)<input type="hidden" name="p_don" value=' . $paci['p_don'] . '>'; ?>
                                    <select name="select" class="med_insert" title="p_extras" data-mini="true">
                                        <option value="" selected>EXTRAS:</option>
                                        <option value="Borrar">- Borrar Datos -</option>

                                        <option value="TRANSFERENCIA FRESCO">TRANSFERENCIA FRESCO</option>

                                        <option value="NGS">NGS</option>
                                        <option value="CRIO TOTAL">CRIO TOTAL</option>
                                        <option value="EMBRYOGLUE">EMBRYOGLUE</option>
                                        <option value="EMBRYOSCOPE">EMBRIOSCOPE</option>
                                        <option value="PICSI">PICSI</option>
                                        <option value="BANKING EMBRIONES">BANKING EMBRIONES</option>
                                    </select>
                                    <textarea name="p_extras" readonly id="p_extras"
                                              data-mini="true"><?php echo $paci['pago_extras']; ?></textarea>
                                    <?php if ($paci['p_extras'] <> "") echo "<small>Selección del Médico: " . $paci['p_extras'] . "</small>"; ?>
                                </div>
                            </td>
                            <td width="12%" bgcolor="#F4AEB0">
                                <?php if ($paci['des_dia'] === 0) { ?>
                                    <input type="hidden" name="f_pun"
                                           value=""><?php echo '<b>Fecha Descongelación<br> ' . date("d-m-Y", strtotime($paci['fec0'])) . '</b>'; ?>
                                <?php } else if ($paci['des_dia'] >= 1) { ?>
                                    <input type="hidden" name="f_pun" value="">
                                <?php } else { ?>
                                    <strong>Fecha Punción </strong>
                                    <input name="f_pun" type="date" required id="f_pun"
                                           value="<?php if ($paci['f_pun'] and $paci['f_pun'] <> "0000-00-00") echo $paci['f_pun']; ?>"
                                           data-mini="true" <?php if ($paci['f_pun'] and $paci['f_pun'] <> "0000-00-00") echo "readonly"; ?>/>
                                <?php } ?>
                            </td>
                            <td width="11%">Embriologo
                                Aspiración
                                <select name="emb_a" required id="emb_a" data-mini="true">
                                    <option value="">---</option>
                                    <?php foreach ($rows as $embrio) { ?>
                                        <option value=<?php echo $embrio['id'];
                                        if ($paci['emb_a'] == $embrio['id']) echo " selected"; ?>><?php echo $embrio['nom']; ?></option>
                                    <?php } ?>
                                </select></td>
                            <td width="12%" class="peke">Hora Aspiración
                                <input name="hra_a" type="time" data-mini="true" id="hra_a"
                                       value="<?php if ($paci['hra_a'] <> "") echo $paci['hra_a']; else echo date("H:i"); ?>">
                            </td>
                            <td width="17%"><?php if ($paci['des_dia'] == "" and $_GET['id'] <> '') { ?>
                                    <a href="#cap" data-rel="popup" data-position-to="window"
                                       class="ui-btn ui-mini ui-btn-inline ui-icon-user ui-btn-icon-left">CAPACITACIÓN</a>
                                    <div data-role="popup" id="cap" data-overlay-theme="b" class="ui-content"
                                         style="padding-bottom:2em;"><a
                                                href="le_andro_cap.php?dni=<?php echo $paci['dni'] . "&ip=" . $paci['p_dni'] . "&pro=" . $paci['pro'] . "&het=" . $paci['p_dni_het'] . "&id="; ?>"
                                                rel="external" class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>
                                        <table width="100%" style="margin: 0 auto;max-width:800px;"
                                               class="ui-responsive table-stroke">
                                            <thead>
                                            <tr>
                                                <th colspan="3" align="center">Fresco</th>
                                                <th colspan="2" align="center">Capacitación</th>
                                                <th align="left">&nbsp;</th>
                                            </tr>
                                            <tr>
                                                <th width="8%" align="left">Vol.</th>
                                                <th width="15%" align="left">Con.</th>
                                                <th width="14%" align="left">Moti.</th>
                                                <th width="13%" align="left">Con.</th>
                                                <th width="19%" align="left">Spz/Ins</th>
                                                <th width="31%" align="left">Fecha</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $Cap = $db->prepare("SELECT * FROM lab_andro_cap WHERE pro=? ORDER BY fec DESC");
                                            $Cap->execute(array($paci['pro']));
                                            while ($cap = $Cap->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr style="font-size:small">
                                                    <td><?php echo $cap['vol_f'] . 'ml'; ?></td>
                                                    <td><?php echo $cap['con_f'] . 'x10<sup>6'; ?></td>
                                                    <td><?php echo ($cap['pl_f'] + $esp['pnl_f']) . '%'; ?></td>
                                                    <td><?php echo $cap['con_c'] . 'x10<sup>6'; ?></td>
                                                    <td><?php echo round(($cap['con_c'] * 0.3), 2); ?></td>
                                                    <td>
                                                        <a href="le_andro_cap.php?dni=<?php echo $paci['dni'] . "&ip=" . $paci['p_dni'] . "&id=" . $cap['id']; ?>"
                                                           rel="external"><?php echo date("d-m-Y", strtotime($cap['fec']));
                                                            if ($cap['mue'] == 2 or $cap['mue'] == 4) echo " (Heterólogo)"; ?></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php if ($Cap->rowCount() < 1) echo '<p><h3>¡ No hay Capacitaciones aún !</h3></p>'; ?>
                                    </div>
                                <?php } ?></td>
                            <td width="35%">CONCLUSIONES
                                <textarea name="obs" id="obs" data-mini="true"><?php echo $paci['obs']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td bgcolor="#F4AEB0" class="peke2 enlinea"><strong>Aspirados - Inseminados</strong><br>
                                <input name="n_ovo" type="number" required id="n_ovo" min="0"
                                       value="<?php echo $paci['n_ovo']; ?>"
                                       data-mini="true" <?php if ($paci['n_ovo']) echo "readonly"; ?>/>
                                -
                                <input name="n_ins" type="number" required id="n_ins" min="0"
                                       value="<?php echo $paci['n_ins']; ?>" data-mini="true"/></td>
                            <td>Embriologo
                                Inseminación
                                <select name="emb0" required id="emb0" data-mini="true">
                                    <option value="">---</option>
                                    <?php foreach ($rows as $embrio) { ?>
                                        <option value=<?php echo $embrio['id'];
                                        if ($paci['emb0'] == $embrio['id']) echo " selected"; ?>><?php echo $embrio['nom']; ?></option>
                                    <?php } ?>
                                </select></td>
                            <td class="peke">Hora Inseminación
                                <input name="hra0" type="time" data-mini="true" id="hra0"
                                       value="<?php if ($paci['hra0'] <> "") echo $paci['hra0']; else echo date("H:i"); ?>">
                            </td>
                            <td rowspan="2">
                                <div data-role="controlgroup" data-mini="true">
                                    <input type="checkbox" name="pen" id="pen" data-mini="true"
                                           value=1 <?php if ($paci['pen'] == 1) echo "checked"; ?>>
                                    <label for="pen">Pentoxifilina</label>
                                    <input type="checkbox" name="s_pun" id="s_pun" data-mini="true"
                                           value=1 <?php if ($paci['s_pun'] == 1) echo "checked"; ?>>
                                    <label for="s_pun">San. punción</label>
                                    <input type="checkbox" name="s_cum" id="s_cum" data-mini="true"
                                           value=1 <?php if ($paci['s_cum'] == 1) echo "checked"; ?>>
                                    <label for="s_cum">San. cúmulos</label>
                                    <input type="checkbox" name="end" id="end" data-mini="true"
                                           value=1 <?php if ($paci['end'] == 1) echo "checked"; ?>>
                                    <label for="end">Endometriosis</label>
                                </div>
                            </td>
                            <td width="25%" rowspan="2">OBSERVACIONES
                                <textarea name="obs_med" id="obs_med"
                                          data-mini="true"><?php echo $paci['obs_med']; ?></textarea>
                            <div class="peke2 enlinea">
                                INCUBADORA: <input type="number" min="0" max="99" name="inc"
                                       id="inc" value="<?php echo $paci['inc']; ?>" required
                                       data-mini="true">
                            </div></td>
                        </tr>
                        <tr>
                            <td>Origen ovocitos
                                <select name="o_ovo" required id="o_ovo" data-mini="true">
                                    <option value="">---</option>
                                    <option value="Fresco" <?php if ($paci['o_ovo'] == "Fresco") echo "selected"; ?>>
                                        Fresco
                                    </option>
                                    <option value="Vitrificado" <?php if ($paci['o_ovo'] == "Vitrificado") echo "selected"; ?>>
                                        Vitrificado
                                    </option>
                                </select></td>
                            <td>Embriologo
                                Crio
                                <select name="emb0c" id="emb0c" data-mini="true">
                                    <option value="">---</option>
                                    <?php foreach ($rows as $embrio) { ?>
                                        <option value=<?php echo $embrio['id'];
                                        if ($paci['emb0c'] == $embrio['id']) echo " selected"; ?>><?php echo $embrio['nom']; ?></option>
                                    <?php } ?>
                                </select></td>
                            <td class="peke">Hora Crio
                                <input name="hra0c" type="time" data-mini="true" id="hra0c"
                                       value="<?php if ($paci['hra0c'] <> "") echo $paci['hra0c']; else echo date("H:i"); ?>">
                            </td>
                        </tr>
                    </table>
                </div>

                <script>
                    $(document).ready(function () {
                        <?php if ($paci['des_dia'] >= 1) { ?>
                        $('#p_fiv,#p_icsi,#p_cri').addClass('ui-disabled');

                        <?php } if ($paci['des_dia'] === 0) { ?>
                        $('#p_cri,#f_pun,#s_cum,#s_pun,#end').addClass('ui-disabled');
                        <?php } ?>
                    });
                </script>
                <?php if ($_GET['id'] <> '' and $rAspi->rowCount() > 0) { ?>
                    <div class="enlinea libro">
                        Cuaderno: <input name="book" min="0" max="999" type="number" data-mini="true" id="book" value="<?php echo $paci['book']; ?>">
                        Hoja: <input name="hoja" min="0" max="99999" type="number" data-mini="true" id="hoja" value="<?php echo $paci['hoja']; ?>">
                    </div>
                    <div class="scroll_h">
                        <table data-role="table" style="margin: 0 auto;font-size:small;"
                               class="ui-responsive table-stroke">
                            <thead>
                            <tr>
                                <th>Ovo</th>
                                <th><?php if ($paci['p_fiv'] == 1 and $paci['p_icsi'] <> 1) echo "Proceso"; else echo "Estadio"; ?></th>
                                <th>Morfología</th>
                                <th>Z. Pelu</th>
                                <th>Rotura</th>
                                <th>Inten.</th>
                                <th>Fin Ciclo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <?php $c = 0;
                            while ($aspi = $rAspi->fetch(PDO::FETCH_ASSOC)) {
                                $c++; ?>
                                <tr <?php if ($aspi['anu'] > 0) {
                                    if ($aspi['d0f_cic'] == 'C') echo 'class="bg_C"';
                                    if ($aspi['d0f_cic'] == 'D') echo 'class="bg_D"';
                                    if ($aspi['d0f_cic'] == 'N') echo 'class="bg_N"';
                                } ?> id="fila<?php echo $c; ?>">
                                    <td><input type="hidden" name="anu<?php echo $c; ?>"
                                               value="<?php echo $aspi['anu']; ?>"><?php echo $aspi['ovo']; ?></td>
                                    <td class="peke2">
                                        <select name="est<?php echo $c; ?>" id="est<?php echo $c; ?>" required
                                                class="val_defect" title="<?php echo $c; ?>" data-mini="true">
                                            <?php if ($paci['p_fiv'] == 1) { ?>
                                                <option value="FIV" <?php if ($aspi['d0est'] == "FIV" or $paci['p_fiv'] == 1) echo "selected"; ?>>
                                                    FIV
                                                </option>
                                            <?php } ?>
                                            <option value="MII" <?php if ($aspi['d0est'] == "MII") echo "selected"; ?>>M
                                                II
                                            </option>
                                            <option value="MI" <?php if ($aspi['d0est'] == "MI") echo "selected"; ?>>M I
                                            </option>
                                            <option value="VG" <?php if ($aspi['d0est'] == "VG") echo "selected"; ?>>VG
                                            </option>
                                            <option value="ATR" <?php if ($aspi['d0est'] == "ATR") echo "selected"; ?>>
                                                ATR
                                            </option>
                                            <option value="DV" <?php if ($aspi['d0est'] == "DV") echo "selected"; ?>>DV
                                            </option>
                                            <option value="CT" <?php if ($aspi['d0est'] == "CT") echo "selected"; ?>>CT
                                            </option>
                                        </select>

                                    </td>

                                    <td>
                                        <div data-role="controlgroup" data-type="horizontal" data-mini="true"
                                             class="peke">
                                            <select class="med_insert" data-mini="true" title="mor<?php echo $c; ?>">
                                                <option value="">---</option>
                                                <option value="Borrar">- Borrar Datos -</option>
                                                <option value="N">N</option>
                                                <option value="GR">GR</option>
                                                <option value="VES">VES</option>
                                                <option value="REL">REL</option>
                                                <option value="CR">CR</option>
                                                <option value="CN">CN</option>
                                                <option value="VAC">VAC</option>
                                                <option value="CPf">CPf</option>
                                                <option value="CPg">CPg</option>
                                                <option value="CLU">CLU</option>
                                            </select>
                                            <input name="mor<?php echo $c; ?>" type="text" id="mor<?php echo $c; ?>"
                                                   value="<?php if ($aspi['d0mor'] <> "") echo $aspi['d0mor']; else if ($paci['p_icsi'] == 1) echo "N,"; ?>"
                                                   readonly data-mini="true"
                                                   data-wrapper-class="controlgroup-textinput ui-btn"/>
                                        </div>
                                    </td>
                                    <td>
                                        <select data-mini="true" name="z_pel<?php echo $c; ?>" id="z_pel<?php echo $c; ?>">
                                            <option value="">---</option>
                                            <option value="N" <?php if ($aspi['d0z_pel'] == "N" or $paci['p_icsi'] == 1) echo "selected"; ?>>
                                                N
                                            </option>
                                            <option value="ZPf" <?php if ($aspi['d0z_pel'] == "ZPf") echo "selected"; ?>>
                                                ZPf
                                            </option>
                                            <option value="ZPgr" <?php if ($aspi['d0z_pel'] == "ZPgr") echo "selected"; ?>>
                                                ZPgr
                                            </option>
                                            <option value="ZPp" <?php if ($aspi['d0z_pel'] == "ZPp") echo "selected"; ?>>
                                                ZPp
                                            </option>
                                            <option value="ZPt" <?php if ($aspi['d0z_pel'] == "ZPt") echo "selected"; ?>>
                                                ZPt
                                            </option>
                                            <option value="ZPml" <?php if ($aspi['d0z_pel'] == "ZPml") echo "selected"; ?>>
                                                ZPml
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="rot<?php echo $c; ?>" id="rot<?php echo $c; ?>" data-mini="true">
                                            <option value="">---</option>
                                            <option value="RP" <?php if ($aspi['d0rot'] == "RP" or $paci['p_icsi'] == 1) echo "selected"; ?>>
                                                RP
                                            </option>
                                            <option value="SS" <?php if ($aspi['d0rot'] == "SS") echo "selected"; ?>>SS
                                            </option>
                                            <option value="STA1" <?php if ($aspi['d0rot'] == "STA1") echo "selected"; ?>>
                                                STA1
                                            </option>
                                            <option value="STA2" <?php if ($aspi['d0rot'] == "STA2") echo "selected"; ?>>
                                                STA2
                                            </option>
                                            <option value="STA3" <?php if ($aspi['d0rot'] == "STA3") echo "selected"; ?>>
                                                STA3
                                            </option>
                                            <option value="STrp" <?php if ($aspi['d0rot'] == "STrp") echo "selected"; ?>>
                                                STrp
                                            </option>
                                        </select></td>
                                    <td>
                                        <select name="inte<?php echo $c; ?>" id="inte<?php echo $c; ?>" data-mini="true">
                                            <option value="">---</option>
                                            <option value=1 <?php if ($aspi['d0inte'] == 1 or $paci['p_icsi'] == 1) echo "selected"; ?>>
                                                1
                                            </option>
                                            <option value=2 <?php if ($aspi['d0inte'] == 2) echo "selected"; ?>>2</option>
                                            <option value=3 <?php if ($aspi['d0inte'] == 3) echo "selected"; ?>>3</option>
                                        </select></td>
                                    <td class="enlinea">
                                        <script>$(document).ready(function () {
                                                <?php if ($aspi['d0f_cic'] == "C") { ?>
                                                $('#crio<?php echo $c; ?>').show();
                                                <?php } else { ?>
                                                $('#crio<?php echo $c; ?>').hide();
                                                <?php } ?>
                                            });</script>
                                        <select name="f_cic<?php echo $c; ?>" class="f_cic"
                                                title="<?php echo $aspi['ovo']; ?>" id="<?php echo $c; ?>" data-mini="true"
                                                required>
                                            <option value="" selected>---</option>
                                            <?php if ($paci['p_cri'] <> 1) { ?>
                                                <option value="O" <?php if ($aspi['d0f_cic'] == "O" or $aspi['d0f_cic'] == "") echo "selected"; ?>>
                                                    Obs
                                                </option>
                                            <?php } ?>
                                            <?php if ($paci['p_don'] == 1) { ?>
                                                <option value="D" <?php if ($aspi['d0f_cic'] == "D") echo "selected"; ?>>
                                                    Donado
                                                </option>
                                            <?php } ?>
                                            <option value="C" <?php if ($aspi['d0f_cic'] == "C") echo "selected"; ?>>Crio
                                            </option>
                                            <option value="N" <?php if ($aspi['d0f_cic'] == "N") echo "selected"; ?>>NV
                                            </option>
                                        </select>
                                        <div data-role="controlgroup" data-type="horizontal" data-mini="true"
                                             id="crio<?php echo $c; ?>" class="peke2">
                                            <input name="T<?php echo $c; ?>" id="T<?php echo $c; ?>" type="number" min="0"
                                                   value="<?php echo $aspi['T']; ?>" placeholder="T"
                                                   data-wrapper-class="controlgroup-textinput ui-btn">
                                            <input name="C<?php echo $c; ?>" id="C<?php echo $c; ?>" type="number" min="0"
                                                   value="<?php echo $aspi['C']; ?>" placeholder="C"
                                                   data-wrapper-class="controlgroup-textinput ui-btn">
                                            <input name="G<?php echo $c; ?>" id="G<?php echo $c; ?>" type="number" min="0"
                                                   value="<?php echo $aspi['G']; ?>" placeholder="G"
                                                   data-wrapper-class="controlgroup-textinput ui-btn">
                                            <input name="P<?php echo $c; ?>" id="P<?php echo $c; ?>" type="number" min="0"
                                                   value="<?php echo $aspi['P']; ?>" placeholder="P"
                                                   data-wrapper-class="controlgroup-textinput ui-btn">
                                            <select name="col<?php echo $c; ?>" id="col<?php echo $c; ?>">
                                                <option value="">---</option>
                                                <option value=1 <?php if ($aspi['col'] == 1) echo "selected"; ?>>Azul
                                                </option>
                                                <option value=2 <?php if ($aspi['col'] == 2) echo "selected"; ?>>Amarillo
                                                </option>
                                                <option value=3 <?php if ($aspi['col'] == 3) echo "selected"; ?>>Blanco
                                                </option>
                                                <option value=4 <?php if ($aspi['col'] == 4) echo "selected"; ?>>Rosado
                                                </option>
                                                <option value=5 <?php if ($aspi['col'] == 5) echo "selected"; ?>>Verde
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td><a href="#f<?php echo $c; ?>" data-rel="popup" data-transition="pop"
                                           id="li<?php echo $c; ?>">Detalles <?php if ($aspi['obs'] <> "") echo " (Obs)"; ?></a>
                                        <?php if (file_exists("emb_pic/p" . $paci['pro'] . "d0_" . $aspi['ovo'] . ".jpg"))
                                            echo "<br><a href='emb_pic/p" . $paci['pro'] . "d0_" . $aspi['ovo'] . ".jpg' target='new'> (Ver foto)</a>"; ?>
                                        <div data-role="popup" id="f<?php echo $c; ?>" class="ui-content"> Subir/Cambiar
                                            Foto (Ovulo <?php echo $aspi['ovo']; ?>)
                                            <input name="i<?php echo $c; ?>" type="file" accept="image/jpeg"
                                                   data-mini="true" class="fotox"/> Observaciones<textarea
                                                    name="obs<?php echo $c; ?>" id="obs"
                                                    data-mini="true"><?php echo $aspi['obs']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>

                            <?php if ($aspi['d0est'] <> "MII" and $aspi['d0est'] <> "") { ?>
                                <script>
                                    $(document).ready(function () {
                                        //if ($('#est<?php // echo $c; ?>').val() != 'MII') {
                                        $('#z_pel<?php echo $c; ?>-button').hide();
                                        $('#rot<?php echo $c; ?>-button').hide();
                                        $('#inte<?php echo $c; ?>-button').hide();
                                        //}
                                    });
                                </script>
                            <?php }
                            } ?>
                        </table>
                    </div>
                <?php } ?>

                <input type="hidden" name="c" value="<?php echo $c; ?>">
                <?php //if ($_GET['rep']<>'' or ($paci['f_fin']=="0000-00-00" or $paci['f_fin']==date("Y-m-d"))) { ?>
                <input name="guardar" type="Submit" id="guardar" value="GUARDAR DATOS" data-icon="check"
                       data-iconpos="left" data-inline="true" data-theme="b" data-mini="true"/>
                <?php // } ?>
                <div data-role="popup" id="cargador" data-overlay-theme="b" data-dismissible="false"><p>GUARDANDO
                        DATOS..</p></div>
            </div><!-- /content -->
        </div><!-- /page -->
    </form>

    <script>
        $(function () {
            $('#alerta').delay(3000).fadeOut('slow');

        });//]]>
    </script>
<?php } ?>
</body>
</html>
