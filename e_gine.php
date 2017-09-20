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
    <script>
        // popup PARA LA AGENDA ---------------------------------------------------
        $(document).on("pagecreate", function () {
            // The window width and height are decreased by 30 to take the tolerance of 15 pixels at each side into account
            function scale(width, height, padding, border) {
                var scrWidth = $(window).width() - 30,
                    scrHeight = $(window).height() - 30,
                    ifrPadding = 2 * padding,
                    ifrBorder = 2 * border,
                    ifrWidth = width + ifrPadding + ifrBorder,
                    ifrHeight = height + ifrPadding + ifrBorder,
                    h, w;

                if (ifrWidth < scrWidth && ifrHeight < scrHeight) {
                    w = ifrWidth;
                    h = ifrHeight;
                } else if (( ifrWidth / scrWidth ) > ( ifrHeight / scrHeight )) {
                    w = scrWidth;
                    h = ( scrWidth / ifrWidth ) * ifrHeight;
                } else {
                    h = scrHeight;
                    w = ( scrHeight / ifrHeight ) * ifrWidth;
                }

                return {
                    'width': w - ( ifrPadding + ifrBorder ),
                    'height': h - ( ifrPadding + ifrBorder )
                };
            };

            $(".ui-popup iframe")
                .attr("width", 0)
                .attr("height", "auto");

            $("#popupVideo").on({
                popupbeforeposition: function () {
                    // call our custom function scale() to get the width and height
                    var size = scale(1200, 600, 15, 1),
                        w = size.width,
                        h = size.height;

                    $("#popupVideo iframe")
                        .attr("width", w)
                        .attr("height", h);
                },
                popupafterclose: function () {
                    $("#popupVideo iframe")
                        .attr("width", 0)
                        .attr("height", 0);
                }
            });
        });
        function PrintElem(elem, paci, tipo, fec) {
            var data = $(elem).html();
            var mywindow = window.open('', 'Imprimir', 'height=400,width=800');
            mywindow.document.write('<html><head><title>Imprimir</title>');
            mywindow.document.write('<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />');
            mywindow.document.write('<style> @media print{@page {size:A5;margin: 0px 0px 0px 0px;}} .noPrint { display: none !important; } table, th, td { border: 0.5px solid black; border-collapse: collapse; } </style>');
            mywindow.document.write('</head><body><div style="margin: 0 auto;width:500px"><br><br><br><br><br><br><br><br><br>');
            if (tipo == 1) mywindow.document.write('<h2>Medicamentos</h2><p><i style="float:right">Fecha: ' + fec + '</i><br><b>PACIENTE:</b><br> ' + paci + '</p>');
            if (tipo == 2) mywindow.document.write('<h2>Orden de Análisis Clínicos</h2><p><i style="float:right">Fecha: ' + fec + '</i><br>Paciente: ' + paci + '</p>');
            mywindow.document.write(data);
            mywindow.document.write('<script type="text/javascript">window.print();<' + '/script>');
            mywindow.document.write('</div></body></html>');
            return true;
        }
    </script>
    <?php
    if ($_GET['pop'] <> "") { ?>
        <script>
            $(document).ready(function () {
                $("#Plan").collapsible({collapsed: false});
            });
        </script>
    <?php } ?>
    <style>
        .controlgroup-textinput {
            padding-top: .10em;
            padding-bottom: .10em;
        }
    </style>
</head>
<body>
<div data-role="page" class="ui-responsive-panel" id="e_gine" data-dialog="true">
    <?php
    if (isSet($_POST['idx'])) {
        $hora = explode(":", $_POST['in_hora']);
        updateGine($_POST['idx'], $_POST['fec'], $_POST['fec_h'], $_POST['fec_m'], $_POST['mot'], $_POST['dig'], $_POST['aux'], $_POST['efec'], $_POST['cic'], $_POST['vag'], $_POST['vul'], $_POST['cer'], $_POST['cer1'], $_POST['mam'], $_POST['mam1'], $_POST['t_vag'], $_POST['eco'], $_POST['e_sol'], $_POST['i_med'], $_POST['i_fec'], $_POST['i_obs'], $_POST['in_t'], $_POST['in_f1'], $_POST['in_h1'], $_POST['in_m1'], $_POST['in_f2'], $hora[0], $hora[1], $_POST['in_c'], $_POST['repro']);
    }
    if ($_POST['in_c'] == 1 and $_POST['in_t'] <> '' and $_POST['in_f2'] <> '' and $_POST['in_hora'] <> '')
        google_cal($_POST['in_t'] . ': ' . $_POST['nombre'] . ' (' . $login . ')', 'Ginecologia INMATER', $_POST['in_f2'] . 'T' . $hora[0] . ':' . $hora[1] . ':00.000-05:00', 'bovcnii8fc3jharfgm31veg3vg@group.calendar.google.com');

    if ($_POST['medi_add'] == "AGREGAR") {
        if ($_POST['medi_name'] <> '|' and $_POST['medi_dosis'] <> '' and $_POST['medi_frecuencia'] <> '' and $_POST['medi_cant_dias'] <> '' and $_POST['medi_init_fec'] <> '' and $_POST['medi_init_h'] <> '' and $_POST['medi_init_m'] <> '')
            updateMedi($_POST['idx'], $_POST['dni'], $_POST['medi_name'], $_POST['medi_dosis'], $_POST['medi_frecuencia'], $_POST['medi_cant_dias'], $_POST['medi_init_fec'], $_POST['medi_init_h'], $_POST['medi_init_m'], $_POST['medi_obs'], 0);
        else
            echo "<div id='alerta'> DEBE INGRESAR TODOS LOS CAMPOS DEL MEDICAMENTO </div>";
    }

    if ($_GET['id'] <> "") {

        $id = $_GET['id'];
        $rGine = $db->prepare("SELECT * FROM hc_gineco WHERE id=?");
        $rGine->execute(array($id));
        $gine = $rGine->fetch(PDO::FETCH_ASSOC);

        $rPaci = $db->prepare("SELECT nom,ape,fnac,talla,peso FROM hc_paciente WHERE dni=?");
        $rPaci->execute(array($gine['dni']));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);

        $rAmh = $db->prepare("SELECT amh FROM hc_antece_perfi WHERE dni=? and amh<>''");
        $rAmh->execute(array($gine['dni']));

        $a_medi = $db->prepare("SELECT * FROM hc_agenda WHERE id=?");
        $a_medi->execute(array($id));

        $a_plan = $db->prepare("SELECT * FROM hc_gineco_plan WHERE idp=?");
        $a_plan->execute(array($id));

        $rAux = $db->prepare("SELECT nom FROM hc_gineco_aux");
        $rAux->execute();

        $rMed = $db->prepare("SELECT nom,des FROM hc_gineco_med");
        $rMed->execute();

        $rInt = $db->prepare("SELECT id,med,esp FROM hc_gineco_int");
        $rInt->execute();

        $rAnal = $db->prepare("SELECT * FROM hc_analisis WHERE a_dni=? AND lab<>'legal' ORDER BY a_fec DESC");
        $rAnal->execute(array($gine['dni']));
        ?>

        <style>
            .ui-dialog-contain {
                max-width: 1400px;
                margin: 1% auto 1%;
                padding: 0;
                position: relative;
                top: -35px;
            }

            .aux_insert, .med_insert {
                font-size: small;
            }

            .scroll_h {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;
            }

            .truncate {
                width: 655px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            #alerta {
                background-color: #FF9;
                margin: 0 auto;
                text-align: center;
                padding: 4px;
            }

            .enlinea div {
                display: inline-block;
                vertical-align: middle;
            }

            .peke2 .ui-input-text {
                width: 100px !important;
            }
        </style>
        <script>

            $(document).ready(function () {
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

                $("#repro").on('keydown paste', function(e){ // otra forma de readonly porque este campo tiene q ser readonly y reuired
                    e.preventDefault();
                });

                $('.aux_insert').click(function (e) {
                    var tav = $('#aux').val(),
                        strPos = $('#aux')[0].selectionStart;
                    front = (tav).substring(0, strPos);
                    back = (tav).substring(strPos, tav.length);

                    $('#aux').val(front + '- ' + $(this).text() + '\n' + back);
                    $('#aux').textinput('refresh');
                    $('.fil_med li').addClass('ui-screen-hidden');
                    $('#aux').focus();
                });

                $('.med_insert').click(function (e) {
                    var tav = $('#medi').val(),
                        strPos = $('#medi')[0].selectionStart;
                    front = (tav).substring(0, strPos);
                    back = (tav).substring(strPos, tav.length);

                    $('#medi').val(front + '- ' + $(this).text() + ' ' + $(this).attr("data") + ' \n' + back);
                    $('#medi').textinput('refresh');
                    $('.fil_med li').addClass('ui-screen-hidden');
                    $('#medi').focus();
                });

                $("#repro_lista").change(function () {
                    var str = $('#repro').val();
                    var items = $(this).val();
                    var n = str.indexOf(items);

                    if (n == -1) {	// no agrega duplicados -----------------------------------------------------
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

                $('.chekes').change(function () {

                    var temp = '#' + $(this).attr("id") + '1';

                    if ($(this).prop('checked') || $(this).val() == "Anormal") {

                        $(temp).prop('readonly', false);
                        //$(temp).placeholder=$(this).val();

                    } else {
                        $(temp).prop('readonly', true);
                        $(temp).val('');
                    }

                });

                $("#in_f2").on("change", function () {
                    var hoy = new Date();
                    hoy.setDate(hoy.getDate() + 1);
                    // format a date
                    var dia_next = hoy.getFullYear() + '-' + ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + ("0" + hoy.getDate()).slice(-2);
                    var dia_aspi = $("#in_f2").val();
                    //alert (dia_next+' XXX '+dia_aspi);
                    if (hoy.getHours() >= 15 && dia_next == dia_aspi) {
                        alert("Solo puede agendar para mañana hasta las 3pm de hoy");
                        $("#in_f2").val("");
                    }
                });

                $('#in_c').change(function () {

                    if ($(this).val() == 1) {
                        $('#in_t1-button').show();
                        $('#in_t2').hide();
                        $('#in_t2').textinput('disable');
                    }
                    if ($(this).val() == 2) {
                        $('#in_t2').textinput('enable');
                        $('#in_t2').show();
                        $('#in_t2').val('');
                        $('#in_t1-button').hide();
                    }

                });
                <?php if ($gine['in_c'] == 1) { ?>
                $('#in_t1-button').show();
                $('#in_t2').hide();
                $('#in_t2').textinput('disable');
                <?php } if ($gine['in_c'] == 2) { ?>
                $('#in_t2').textinput('enable');
                $('#in_t2').show();
                $('#in_t1-button').hide();
                <?php } if ($gine['in_c'] == 0) { ?>
                $('#in_t2').hide();
                $('#in_t1-button').hide();
                <?php } ?>
            });

        </script>

        <div data-role="header" data-position="fixed">
            <a href="n_gine.php?id=<?php echo $gine['dni']; ?>" rel="external" class="ui-btn">Cerrar</a>
            <h2>Ginecología:
                <small><?php echo $paci['ape'] . " " . $paci['nom'];
                    if ($paci['fnac'] <> "0000-00-00") echo '(' . date_diff(date_create($paci['fnac']), date_create('today'))->y . ')'; ?></small>
            </h2>
            <a href="#popupVideo" data-rel="popup" data-position-to="window" class="ui-btn">Ver Antecedentes</a>
        </div><!-- /header -->
        <div data-role="popup" id="popupVideo" data-overlay-theme="b" data-theme="a" data-tolerance="15,15"
             class="ui-content">
            <a href="#" data-rel="back"
               class="ui-btn ui-btn-b ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-left">Close</a>
                
            <iframe src="e_paci.php?id=<?php echo $gine['dni']; ?>&pop=1" seamless></iframe>
        </div>
        <div class="ui-content" role="main">

            <form action="e_gine.php?id=<?php echo $gine['id']; ?>" method="post" data-ajax="false">
                <input type="hidden" name="nombre" value="<?php echo $paci['ape'] . " " . $paci['nom']; ?>">
                <input type="hidden" name="idx" value="<?php echo $gine['id']; ?>">
                <input type="hidden" name="dni" value="<?php echo $gine['dni']; ?>">
                <table width="100%" align="center" style="margin: 0 auto;">
                    <tr>
                        <td>Fecha</td>
                        <td>
                            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                <input name="fec" type="date" id="fec" value="<?php echo $gine['fec']; ?>"
                                       data-wrapper-class="controlgroup-textinput ui-btn">
                                <select name="fec_h" id="fec_h">
                                    <option value="">Hra</option>
                                    <option value="07" <?php if ($gine['fec_h'] == "07") echo "selected"; ?>>07 hrs
                                    </option>
                                    <option value="08" <?php if ($gine['fec_h'] == "08") echo "selected"; ?>>08 hrs
                                    </option>
                                    <option value="09" <?php if ($gine['fec_h'] == "09") echo "selected"; ?>>09 hrs
                                    </option>
                                    <option value="10" <?php if ($gine['fec_h'] == "10") echo "selected"; ?>>10 hrs
                                    </option>
                                    <option value="11" <?php if ($gine['fec_h'] == "11") echo "selected"; ?>>11 hrs
                                    </option>
                                    <option value="12" <?php if ($gine['fec_h'] == "12") echo "selected"; ?>>12 hrs
                                    </option>
                                    <option value="13" <?php if ($gine['fec_h'] == "13") echo "selected"; ?>>13 hrs
                                    </option>
                                    <option value="14" <?php if ($gine['fec_h'] == "14") echo "selected"; ?>>14 hrs
                                    </option>
                                    <option value="15" <?php if ($gine['fec_h'] == "15") echo "selected"; ?>>15 hrs
                                    </option>
                                    <option value="16" <?php if ($gine['fec_h'] == "16") echo "selected"; ?>>16 hrs
                                    </option>
                                    <option value="17" <?php if ($gine['fec_h'] == "17") echo "selected"; ?>>17 hrs
                                    </option>
                                    <option value="18" <?php if ($gine['fec_h'] == "18") echo "selected"; ?>>18 hrs
                                    </option>
                                    <option value="19" <?php if ($gine['fec_h'] == "19") echo "selected"; ?>>19 hrs
                                    </option>
                                    <option value="20" <?php if ($gine['fec_h'] == "20") echo "selected"; ?>>20 hrs
                                    </option>
                                </select>
                                <select name="fec_m" id="fec_m">
                                    <option value="">Min</option>
                                    <option value="00" <?php if ($gine['fec_m'] == "00") echo "selected"; ?>>00 min
                                    </option>
                                    <option value="15" <?php if ($gine['fec_m'] == "15") echo "selected"; ?>>15 min
                                    </option>
                                    <option value="30" <?php if ($gine['fec_m'] == "30") echo "selected"; ?>>30 min
                                    </option>
                                    <option value="45" <?php if ($gine['fec_m'] == "45") echo "selected"; ?>>45 min
                                    </option>
                                </select>
                            </div>
                        </td>
                        <td align="right">
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
                        </td>
                        <td><textarea name="repro" required id="repro" data-mini="true"><?php echo $gine['repro']; ?></textarea></td>
                    </tr>
                </table>
                <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">

                    <div data-role="collapsible" data-collapsed="false"><h3>Consulta</h3>
                        <div class="scroll_h">
                            <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                                <tr>
                                    <td>Motivo de Consulta
                                        <textarea name="mot" id="mot"
                                                  data-mini="true"><?php echo $gine['mot']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>Diagnóstico
                                        <textarea name="dig" id="dig"
                                                  data-mini="true"><?php echo $gine['dig']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>
                                        <!--<ul data-role="listview" data-theme="c" data-inset="true" data-filter="true" data-filter-reveal="true" data-filter-placeholder="Agregar medicamentos..." data-mini="true" class="fil_med" data-icon="false">
            <?php //while($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
            <li><a href="#" class="med_insert" data="<?php //echo $med['des']; ?>"><?php //echo $med['nom']; ?></a></li>
            <?php //} ?>
        </ul>-->
                                        <div class="enlinea" style="border:dotted"><i style="margin: 0 auto;">AGREGAR
                                                MEDICAMENTOS:</i><br>
                                            <?php //$farma = new PDO('mysql:host=localhost;dbname=farmacia;charset=utf8', 'root', '');
                                            $farma = new PDO('mysql:host=localhost;dbname=vigose5_farmacia;charset=utf8', 'vigose5_farma', 'f4rm4.2017');
                                            $farma->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $farma->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
                                            $Rmedi = $farma->prepare("SELECT id,producto FROM tblproducto"); $Rmedi->execute(); ?>
                                            <input name="medi_name" list="cate" placeholder="Medicamento..">
                                            <datalist id="cate">
                                                <?php while ($medic = $Rmedi->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="'.$medic['id'].'|'.$medic['producto'].'"></option>';
                                                } ?>
                                            </datalist>
                                            <input name="medi_dosis" type="text" data-mini="true"
                                                   placeholder="Dosis.."/>
                                            <span class="peke2">
        <input name="medi_frecuencia" type="number" data-mini="true" placeholder="Frecuencia.."/>
        <input name="medi_cant_dias" type="number" data-mini="true" placeholder="Dias.."/>
        </span>
                                            <br>
                                            <small>Fecha de inicio</small>
                                            <br><input name="medi_init_fec" type="date" data-mini="true"
                                                       placeholder="Fecha de inicio.."/>
                                            <span class="peke2">
        <input name="medi_init_h" type="number" data-mini="true" placeholder="Hora.."/>
        <input name="medi_init_m" type="number" data-mini="true" placeholder="Minutos.."/>
        </span>
                                            <div><textarea name="medi_obs" data-mini="true" data-inline="true"
                                                           placeholder="Observaciones.."></textarea></div>
                                            <input type="Submit" name="medi_add" value="AGREGAR" data-mini="true"
                                                   data-theme="b" data-inline="true"/>
                                        </div>
                                        <div id="print_med" style="border:dotted;">
                                            <?php if ($a_medi->rowCount() > 0) { // la tabla tiene 559px = ancho de hoja A5 ?>
                                                <table width="100%" cellspacing="4" style="margin: 0 auto;"
                                                       class="ui-responsive table-stroke">
                                                    <tr>
                                                        <th width="39%">Medicamento</th>
                                                        <th width="6%">Dosis</th>
                                                        <th width="11%">Frecuencia</th>
                                                        <th width="5%">Dias</th>
                                                        <th width="14%">Fecha de inicio</th>
                                                    </tr>
                                                    <?php while ($medi = $a_medi->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <tr style="font-size:small">
                                                            <td>
                                                                <a href="e_gine_medi.php?id=<?php echo $medi['id_agenda']; ?>"
                                                                   rel="external"><?php echo $medi['medi_name']; ?></a>
                                                                <?php if ($medi['medi_obs'] <> '') echo '<br>Observaciones: ' . $medi['medi_obs']; ?>
                                                            </td>
                                                            <td align="center"><?php echo $medi['medi_dosis']; ?></td>
                                                            <td align="center"><?php echo $medi['medi_frecuencia']; ?></td>
                                                            <td align="center"><?php echo $medi['medi_cant_dias']; ?></td>
                                                            <td align="center"><?php echo date("d-m-Y", strtotime($medi['medi_init_fec'])) . ' ' . $medi['medi_init_h'] . ':' . $medi['medi_init_m']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php } ?>
                                            <pre><?php echo $gine['medi']; ?></pre>
                                        </div>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div data-role="collapsible"><h3>Exámenes Realizados por el Médico</h3>
                        <div class="scroll_h">
                            <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                                <tr>
                                    <td width="4%">Fecha</td>
                                    <td width="11%"><input name="efec" type="date" id="efec" data-mini="true"
                                                           value="<?php echo $gine['efec']; ?>"/></td>
                                    <td width="8%">Ciclo</td>
                                    <td width="11%"><input name="cic" type="text" id="cic" data-mini="true"
                                                           value="<?php echo $gine['cic']; ?>"></td>
                                    <td colspan="2"><select name="eco" id="eco" data-mini="true">
                                            <option value="" selected="selected">Ecografía:</option>
                                            <option value="Normal" <?php if ($gine['eco'] == "Normal") echo "selected"; ?>>
                                                Normal
                                            </option>
                                            <optgroup label="Anormal: SI">
                                                <option value="Fondo saco vaginal" <?php if ($gine['eco'] == "Fondo saco vaginal") echo "selected"; ?>>
                                                    Anormal: Fondo saco vaginal
                                                </option>
                                                <option value="Cuerpo uterino" <?php if ($gine['eco'] == "Cuerpo uterino") echo "selected"; ?>>
                                                    Anormal: Cuerpo uterino
                                                </option>
                                                <option value="Anexo Derecho" <?php if ($gine['eco'] == "Anexo Derecho") echo "selected"; ?>>
                                                    Anormal: Anexo Derecho
                                                </option>
                                                <option value="Anexo Izquierdo" <?php if ($gine['eco'] == "Anexo Izquierdo") echo "selected"; ?>>
                                                    Anormal: Anexo Izquierdo
                                                </option>
                                            </optgroup>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><select name="vul" id="vul" data-mini="true">
                                            <option value="" selected="selected">Vulva:</option>
                                            <option value="Normal" <?php if ($gine['vul'] == "Normal") echo "selected"; ?>>
                                                Vulva: Normal
                                            </option>
                                            <option value="Anormal" <?php if ($gine['vul'] == "Anormal") echo "selected"; ?>>
                                                Vulva: Anormal
                                            </option>
                                        </select></td>
                                    <td colspan="2"><select name="vag" id="vag" data-mini="true">
                                            <option value="" selected="selected">Vagina:</option>
                                            <option value="tipo 1" <?php if ($gine['vag'] == "tipo 1") echo "selected"; ?>>
                                                Vagina: tipo 1
                                            </option>
                                            <option value="tipo 2" <?php if ($gine['vag'] == "tipo 2") echo "selected"; ?>>
                                                Vagina: tipo 2
                                            </option>
                                            <option value="tipo 3" <?php if ($gine['vag'] == "tipo 3") echo "selected"; ?>>
                                                Vagina: tipo 3
                                            </option>
                                            <option value="tipo 4" <?php if ($gine['vag'] == "tipo 4") echo "selected"; ?>>
                                                Vagina: tipo 4
                                            </option>
                                        </select></td>
                                    <td width="9%">
                                        <fieldset data-role="controlgroup" data-type="horizontal">
                                            <select name="mam" id="mam" data-mini="true" class="chekes">
                                                <option value="" selected="selected">Ex. Mama:</option>
                                                <option value="Normal" <?php if ($gine['mam'] == "Normal") echo "selected"; ?>>
                                                    Normal
                                                </option>
                                                <option value="Anormal" <?php if ($gine['mam'] == "Anormal") echo "selected"; ?>>
                                                    Anormal
                                                </option>
                                            </select>
                                        </fieldset>
                                    </td>
                                    <td width="57%"><input name="mam1" type="text" id="mam1" data-mini="true"
                                                           placeholder="Especifique.." readonly
                                                           value="<?php echo $gine['mam1']; ?>"></td>
                                </tr>

                                <tr>
                                    <td colspan="2">Tacto vaginal</td>
                                    <td colspan="2"><input name="t_vag" type="text" id="t_vag" data-mini="true"
                                                           value="<?php echo $gine['t_vag']; ?>"></td>
                                    <td>
                                        <fieldset data-role="controlgroup" data-type="horizontal">
                                            <select name="cer" id="cer" data-mini="true" class="chekes">
                                                <option value="" selected="selected">Cervix:</option>
                                                <option value="Normal" <?php if ($gine['cer'] == "Normal") echo "selected"; ?>>
                                                    Normal
                                                </option>
                                                <option value="Anormal" <?php if ($gine['cer'] == "Anormal") echo "selected"; ?>>
                                                    Anormal
                                                </option>
                                            </select>
                                        </fieldset>
                                    </td>
                                    <td><input name="cer1" type="text" id="cer1" data-mini="true"
                                               placeholder="Especifique.." readonly value="<?php echo $gine['cer1']; ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div data-role="collapsible"><h3>Orden de Análisis Clínicos</h3>
                        <ul data-role="listview" data-theme="c" data-inset="true" data-filter="true"
                            data-filter-reveal="true" data-filter-placeholder="Agregar exámenes auxiliares..."
                            data-mini="true" class="fil_med" data-icon="false">
                            <?php while ($aux = $rAux->fetch(PDO::FETCH_ASSOC)) { ?>
                                <li><a href="#" class="aux_insert"><?php echo $aux['nom']; ?></a></li>
                            <?php } ?>
                        </ul>
                        <label for="aux">Exámenes Auxiliares seleccionados:</label>
                        <div id="print_aux"><textarea name="aux" id="aux"
                                                      data-mini="true"><?php echo $gine['aux']; ?></textarea></div>
                    </div>

                    <div data-role="collapsible"><h3>Resultados de Análisis Clínicos</h3>
                        <?php if ($rAnal->rowCount() > 0) { ?>
                            <table style="font-size:small;" data-role="table" class="ui-responsive table-stroke">
                                <thead>
                                <tr>
                                    <th>OTROS EXAMENES</th>
                                    <th>RESULTADO</th>
                                    <th>OBSERVACION</th>
                                    <th>INFORME</th>
                                    <th>FECHA</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($anal = $rAnal->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <th><?php echo $anal['a_exa']; ?></th>
                                        <td><?php echo $anal['a_sta']; ?></td>
                                        <td><?php echo $anal['a_obs']; ?></td>
                                        <th>
                                            <a href='<?php echo "analisis/" . $anal['id'] . "_" . $anal['a_dni'] . ".pdf"; ?>'
                                               target="new">Ver/Descargar</a></th>
                                        <td><?php echo date("d-m-Y", strtotime($anal['a_fec'])); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                        OTROS <textarea name="e_sol" id="e_sol" data-mini="true"><?php echo $gine['e_sol']; ?></textarea>

                    </div>

                    <div data-role="collapsible" id="Plan"><h3>Plan de Trabajo</h3>
                        <a href="e_gine_plan.php?dni=<?php echo $gine['dni'] . "&idp=" . $gine['id'] . "&id="; ?>"
                           rel="external" class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>

                        <table width="800" style="margin: 0 auto;max-width:800px;" class="ui-responsive table-stroke">
                            <tr>
                                <th width="9%" align="left">Fecha</th>
                                <th width="83%" align="left">Plan Trabajo</th>
                                <th width="8%" align="left">Imagen</th>
                            </tr>
                            <?php while ($plan = $a_plan->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr style="font-size:small">
                                    <td>
                                        <a href="e_gine_plan.php?dni=<?php echo $gine['dni'] . "&idp=" . $gine['id'] . "&id=" . $plan['id']; ?>"
                                           rel="external"><?php echo date("d-m-Y", strtotime($plan['fec'])); ?></a></td>
                                    <td>
                                        <div class="truncate"><?php echo $plan['plan']; ?></div>
                                    </td>
                                    <td><?php $foto_url = 'paci/' . $gine['dni'] . '/' . $gine['id'] . '/' . $plan['id'] . '/foto.jpg';
                                        if (file_exists($foto_url)) echo "<a href=" . $foto_url . " target='_blank'>Ver</a>"; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <?php if ($a_plan->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>
                    </div>

                    <div data-role="collapsible"><h3>Interconsulta</h3>

                        <div class="ui-grid-a">
                            <div class="ui-block-a">

                                <label for="i_fec">Fecha:</label>
                                <input name="i_fec" type="date" id="i_fec" data-mini="true"
                                       value="<?php echo $gine['i_fec']; ?>">
                                <select name="i_med" id="i_med" data-mini="true">
                                    <option value="">Médico / Especialidad</option>
                                    <?php while ($int = $rInt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value=<?php echo $int['id']; ?> <?php if ($gine['i_med'] == $int['id']) echo " selected"; ?>><?php echo $int['med'] . " / " . $int['esp']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="ui-block-b">
                                <label for="i_obs">Observaciones:</label>
                                <textarea name="i_obs" id="i_obs"><?php echo $gine['i_obs']; ?></textarea>
                            </div>
                        </div><!-- /grid-a -->

                    </div>

                    <div data-role="collapsible"><h3>Orden de Internamiento</h3>

                        <table width="100%" align="center" style="margin: 0 auto;">
                            <tr>
                                <td width="5%">ClÍnica:</td>
                                <td width="23%"><select name="in_c" id="in_c" data-mini="true">
                                        <option value="">---</option>
                                        <option value=1 <?php if ($gine['in_c'] == 1) echo "selected"; ?>>Inmater</option>
                                        <option value=2 <?php if ($gine['in_c'] == 2) echo "selected"; ?>>Otra</option>
                                    </select></td>
                                <td width="21%">Fecha/Hora de Internamiento</td>
                                <td width="51%">
                                    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                        <input type="date" name="in_f1" id="in_f1" value="<?php echo $gine['in_f1']; ?>"
                                               data-mini="true" data-wrapper-class="controlgroup-textinput ui-btn">
                                        <select name="in_h1" id="in_h1">
                                            <option value="">Hora</option>
                                            <option value="07" <?php if ($gine['in_h1'] == "07") echo "selected"; ?>>07
                                                hrs
                                            </option>
                                            <option value="08" <?php if ($gine['in_h1'] == "08") echo "selected"; ?>>08
                                                hrs
                                            </option>
                                            <option value="09" <?php if ($gine['in_h1'] == "09") echo "selected"; ?>>09
                                                hrs
                                            </option>
                                            <option value="10" <?php if ($gine['in_h1'] == "10") echo "selected"; ?>>10
                                                hrs
                                            </option>
                                            <option value="11" <?php if ($gine['in_h1'] == "11") echo "selected"; ?>>11
                                                hrs
                                            </option>
                                            <option value="12" <?php if ($gine['in_h1'] == "12") echo "selected"; ?>>12
                                                hrs
                                            </option>
                                            <option value="13" <?php if ($gine['in_h1'] == "13") echo "selected"; ?>>13
                                                hrs
                                            </option>
                                            <option value="14" <?php if ($gine['in_h1'] == "14") echo "selected"; ?>>14
                                                hrs
                                            </option>
                                            <option value="15" <?php if ($gine['in_h1'] == "15") echo "selected"; ?>>15
                                                hrs
                                            </option>
                                            <option value="16" <?php if ($gine['in_h1'] == "16") echo "selected"; ?>>16
                                                hrs
                                            </option>
                                            <option value="17" <?php if ($gine['in_h1'] == "17") echo "selected"; ?>>17
                                                hrs
                                            </option>
                                            <option value="18" <?php if ($gine['in_h1'] == "18") echo "selected"; ?>>18
                                                hrs
                                            </option>
                                            <option value="19" <?php if ($gine['in_h1'] == "19") echo "selected"; ?>>19
                                                hrs
                                            </option>
                                            <option value="20" <?php if ($gine['in_h1'] == "20") echo "selected"; ?>>20
                                                hrs
                                            </option>
                                        </select>
                                        <select name="in_m1" id="in_m1">
                                            <option value="">Min</option>
                                            <option value="00" <?php if ($gine['in_m1'] == "00") echo "selected"; ?>>00
                                                min
                                            </option>
                                            <option value="15" <?php if ($gine['in_m1'] == "15") echo "selected"; ?>>15
                                                min
                                            </option>
                                            <option value="30" <?php if ($gine['in_m1'] == "30") echo "selected"; ?>>30
                                                min
                                            </option>
                                            <option value="45" <?php if ($gine['in_m1'] == "45") echo "selected"; ?>>45
                                                min
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipo:</td>
                                <td width="23%">
                                    <select name="in_t" id="in_t1" data-mini="true">
                                        <option value="">---</option>
                                        <option value="AMEU" <?php if ($gine['in_t'] == "AMEU") echo "selected"; ?>>AMEU
                                        </option>
                                        <?php if ($rAmh->rowCount() > 0 and $paci['talla']<>'' and $paci['peso']<>'') { ?>
                                        <option value="Colocación de plasma" <?php if ($gine['in_t'] == "Colocación de plasma") echo "selected"; ?>>Colocación de plasma
                                        </option>
                                        <?php } ?>
                                        <option value="Legrado" <?php if ($gine['in_t'] == "Legrado") echo "selected"; ?>>
                                            Legrado
                                        </option>
                                        <option value="Ecografia y/o tacto vaginal" <?php if ($gine['in_t'] == "Ecografia y/o tacto vaginal") echo "selected"; ?>>
                                            Ecografia y/o tacto vaginal
                                        </option>
                                        <option value="Biopsia endometrial" <?php if ($gine['in_t'] == "Biopsia endometrial") echo "selected"; ?>>
                                            Biopsia endometrial
                                        </option>
                                        <option value="Cono Leep" <?php if ($gine['in_t'] == "Cono Leep") echo "selected"; ?>>
                                            Cono Leep
                                        </option>
                                        <option value="Histeroscopia diagnostica" <?php if ($gine['in_t'] == "Histeroscopia diagnostica") echo "selected"; ?>>
                                            Histeroscopia diagnostica
                                        </option>
                                        <option value="Resectoscopia (Histeroscopia Quirurgica)" <?php if ($gine['in_t'] == "Resectoscopia (Histeroscopia Quirurgica)") echo "selected"; ?>>
                                            Resectoscopia (Histeroscopia Quirurgica)
                                        </option>
                                        <option value="Labioplastia ambulatoria" <?php if ($gine['in_t'] == "Labioplastia ambulatoria") echo "selected"; ?>>
                                            Labioplastia ambulatoria
                                        </option>
                                        <option value="Electrofulguración de condilomas" <?php if ($gine['in_t'] == "Electrofulguración de condilomas") echo "selected"; ?>>
                                            Electrofulguración de condilomas
                                        </option>
                                    </select>
                                    <input name="in_t" type="text" id="in_t2" data-mini="true"
                                           value="<?php echo $gine['in_t']; ?>"/></td>
                                <td>Fecha/Hora de Intervención</td>
                                <td>
                                    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                        <input type="date" name="in_f2" id="in_f2" value="<?php echo $gine['in_f2']; ?>"
                                               data-mini="true" data-wrapper-class="controlgroup-textinput ui-btn">
                                        <select name="in_hora" id="in_hora">
                                            <option value="">Hra</option>
                                            <option value="10:15" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "10:15") echo "selected"; ?>>
                                                10:15 hrs
                                            </option>
                                            <option value="11:00" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "11:00") echo "selected"; ?>>
                                                11:00 hrs
                                            </option>
                                            <option value="11:45" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "11:45") echo "selected"; ?>>
                                                11:45 hrs
                                            </option>
                                            <option value="12:30" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "12:30") echo "selected"; ?>>
                                                12:30 hrs
                                            </option>
                                            <option value="13:15" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "13:15") echo "selected"; ?>>
                                                13:15 hrs
                                            </option>
                                            <option value="14:00" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "14:00") echo "selected"; ?>>
                                                14:00 hrs
                                            </option>
                                            <option value="14:45" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "14:45") echo "selected"; ?>>
                                                14:45 hrs
                                            </option>
                                            <option value="15:30" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "15:30") echo "selected"; ?>>
                                                15:30 hrs
                                            </option>
                                            <option value="16:15" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "16:15") echo "selected"; ?>>
                                                16:15 hrs
                                            </option>
                                            <option value="17:00" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "17:00") echo "selected"; ?>>
                                                17:00 hrs
                                            </option>
                                            <option value="17:45" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "17:45") echo "selected"; ?>>
                                                17:45 hrs
                                            </option>
                                            <option value="18:30" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "18:30") echo "selected"; ?>>
                                                18:30 hrs
                                            </option>
                                            <option value="19:15" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "19:15") echo "selected"; ?>>
                                                19:15 hrs
                                            </option>
                                            <option value="20:00" <?php if ($gine['in_h2'] . ':' . $gine['in_m2'] == "20:00") echo "selected"; ?>>
                                                20:00 hrs
                                            </option>
                                        </select>
                                    </div>
                                    <font color="#E34446">Solo puede agendar para mañana hasta las 3pm de hoy</font>
                                </td>
                            </tr>

                        </table>
                        <iframe src="agenda.php" width="100%" height="800" seamless></iframe>
                    </div>

                </div> <!-- close collapse 1 --------------------------------------->
                <?php if ($gine['med'] == $login) { ?>
                    <input type="Submit" value="GUARDAR DATOS" data-icon="check" data-iconpos="left" data-mini="true"
                           class="show-page-loading-msg" data-textonly="false" data-textvisible="true"
                           data-msgtext="Actualizando datos.." data-theme="b" data-inline="true"/>

                    <a href="javascript:PrintElem('#print_med','<?php echo $paci['ape'] . " " . $paci['nom']; ?>',1,'<?php echo date("d-m-Y", strtotime($gine['fec'])); ?>')"
                       data-role="button" data-mini="true" data-inline="true" rel="external">Imprimir Medicamentos</a>
                    <?php if ($gine['aux'] <> '') { ?>
                        <a href="javascript:PrintElem('#print_aux','<?php echo $paci['ape'] . " " . $paci['nom']; ?>',2,'<?php echo date("d-m-Y", strtotime($gine['fec'])); ?>')"
                           data-role="button" data-mini="true" data-inline="true" rel="external">Imprimir Orden de
                            Análisis Clínicos</a>
                    <?php } ?>

                <?php } else {
                    echo '<font color="#E34446"><b>PERMISO DE EDICION SOLO PARA: </b> ' . $gine['med'] . '</font>';
                } ?>
            </form>

        </div><!-- /content -->
    <?php } ?>
</div><!-- /page -->
<script>
    $(document).on("click", ".show-page-loading-msg", function () {

        if (document.getElementById("mot").value == "") {
            alert("Debe llenar el campo 'Motivo de consulta'");
            return false;
        }
        if (document.getElementById("fec").value == "") {
            alert("Debe llenar el campo 'Fecha'");
            return false;
        }

        if (document.getElementById("fec_h").value == "") {
            alert("Debe llenar el campo 'Hora'");
            return false;
        }

        if (document.getElementById("fec_m").value == "") {
            alert("Debe llenar el campo 'Minuto'");
            return false;
        }

        if (document.getElementById("in_c").value != "" || document.getElementById("in_f2").value != "") {

            if (document.getElementById("in_f1").value == "" || document.getElementById("in_h1").value == "" || document.getElementById("in_m1").value == "" || document.getElementById("in_f2").value == "" || document.getElementById("in_hora").value == "") {
                alert("Debe ingresar las fechas de Internamiento e Intervención");
                return false;
            }

            if (document.getElementById("in_c").value == "") {
                alert("Debe ingresar la Clínica");
                return false;
            }
            if (document.getElementById("in_t").value == "") {
                alert("Debe ingresar el Tipo de Intervención");
                return false;
            }
        }

        if (document.getElementById("mam").value == "Anormal") {

            if (document.getElementById("mam1").value == "") {
                alert("Debe especificar el Ex. Mama Anormal");
                return false;
            }
        }
        if (document.getElementById("cer").value == "Anormal") {

            if (document.getElementById("cer1").value == "") {
                alert("Debe especificar el Cervix Anormal");
                return false;
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
    $(function () {
        $('#alerta').delay(10000).fadeOut('slow');
    });//]]>
</script>
</body>
</html>