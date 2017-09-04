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
            mywindow.document.write('<style> @page {size:A5;margin: 0px 0px 0px 0px;} .noPrint { display: none !important; } table, th, td { border: 0.5px solid black; border-collapse: collapse; } </style>');
            mywindow.document.write('</head><body><div style="margin: 0 auto;width:500px"><br><br><br><br><br><br><br><br><br>');
            if (tipo == 1) mywindow.document.write('<h2>Medicamentos</h2><p><i style="float:right">Fecha: ' + fec + '</i><br><b>PACIENTE:</b><br> ' + paci + '</p>');
            if (tipo == 2) mywindow.document.write('<h2>Orden de Análisis Clínicos</h2><p><i style="float:right">Fecha: ' + fec + '</i><br>Paciente: ' + paci + '</p>');
            mywindow.document.write(data);
            mywindow.document.write('<script type="text/javascript">window.print();<' + '/script>');
            mywindow.document.write('</div></body></html>');
            return true;
        }
    </script>

    <style>
        .controlgroup-textinput {
            padding-top: .10em;
            padding-bottom: .10em;
        }
    </style>
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="e_urolo" data-dialog="true">
    <?php if ($_POST['p_dni'] <> "" and $_POST['fec']) {
        $hora = explode(":", $_POST['in_hora']);
        updateUrolo($_POST['idx'], $_POST['fec'], $_POST['fec_h'], $_POST['fec_m'], $_POST['mot'], $_POST['dig'], $_POST['medi'], $_POST['aux'], $_POST['e_sol'],  $_POST['in_t'], $_POST['in_f2'], $hora[0], $hora[1]);
    }
    if ($_POST['in_t'] <> '' and $_POST['in_f2'] <> '' and $_POST['in_hora'] <> '')
       google_cal($_POST['in_t'] . ': ' . $_POST['nombre'] . ' (' . $login . ')', 'Urologia INMATER', $_POST['in_f2'] . 'T' . $hora[0] . ':' . $hora[1] . ':00.000-05:00', 'bovcnii8fc3jharfgm31veg3vg@group.calendar.google.com');


    if ($_GET['ip'] <> "") {

        $dni = $_GET['dni'];
        $p_dni = $_GET['ip'];

        if ($_GET['id'] == '') {
            $stmt = $db->prepare("INSERT INTO hc_urolo (p_dni,med) VALUES (?,?)");
            $stmt->execute(array($_GET['ip'], $login));
            $id = $db->lastInsertId();
        } else {
            $id = $_GET['id'];
        }


        $rUro = $db->prepare("SELECT * FROM hc_urolo WHERE id=?");
        $rUro->execute(array($id));
        $uro = $rUro->fetch(PDO::FETCH_ASSOC);

        $rPaci = $db->prepare("SELECT p_nom,p_ape,p_fnac FROM hc_pareja WHERE p_dni=?");
        $rPaci->execute(array($p_dni));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);

        $rAnal = $db->prepare("SELECT * FROM hc_analisis WHERE a_dni=? AND lab<>'legal' ORDER BY a_fec DESC");
        $rAnal->execute(array($p_dni));
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

            });

        </script>

        <div data-role="header" data-position="fixed">
            <a href="e_pare.php?id=<?php echo $dni . '&ip=' . $p_dni; ?>" rel="external" class="ui-btn">Cerrar</a>
            <h2>Urología:
                <small><?php echo $paci['p_ape'] . " " . $paci['p_nom'];
                    if ($paci['p_fnac'] <> "0000-00-00") echo ' (' . date_diff(date_create($paci['p_fnac']), date_create('today'))->y . ')'; ?></small>
            </h2>
            <?php if ($dni <> '') { ?>
                <a href="#popupVideo" data-rel="popup" data-position-to="window" class="ui-btn">Antecedentes Pareja</a>
            <?php } ?>
        </div><!-- /header -->
    <?php if ($dni <> '') { ?>
        <div data-role="popup" id="popupVideo" data-overlay-theme="b" data-theme="a" data-tolerance="15,15"
             class="ui-content">
            <a href="#" data-rel="back"
               class="ui-btn ui-btn-b ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-left">Close</a>
                
            <iframe src="e_paci.php?id=<?php echo $dni; ?>&pop=1" seamless></iframe>
        </div>
    <?php } ?>
        <div class="ui-content" role="main">

            <form action="e_urolo.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $id; ?>" method="post"
                  data-ajax="false">
                <input type="hidden" name="nombre" value="<?php echo $paci['p_ape'] . " " . $paci['p_nom']; ?>">
                <input type="hidden" name="idx" value="<?php echo $id; ?>">
                <input type="hidden" name="dni" value="<?php echo $dni; ?>">
                <input type="hidden" name="p_dni" value="<?php echo $p_dni; ?>">
                <table width="100%" align="center" style="margin: 0 auto;">
                    <tr>
                        <td width="6%">Fecha</td>
                        <td width="94%">
                            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                <input name="fec" type="date" id="fec" value="<?php echo $uro['fec']; ?>"
                                       data-wrapper-class="controlgroup-textinput ui-btn">
                                <select name="fec_h" id="fec_h">
                                    <option value="">Hra</option>
                                    <option value="07" <?php if ($uro['fec_h'] == "07") echo "selected"; ?>>07 hrs
                                    </option>
                                    <option value="08" <?php if ($uro['fec_h'] == "08") echo "selected"; ?>>08 hrs
                                    </option>
                                    <option value="09" <?php if ($uro['fec_h'] == "09") echo "selected"; ?>>09 hrs
                                    </option>
                                    <option value="10" <?php if ($uro['fec_h'] == "10") echo "selected"; ?>>10 hrs
                                    </option>
                                    <option value="11" <?php if ($uro['fec_h'] == "11") echo "selected"; ?>>11 hrs
                                    </option>
                                    <option value="12" <?php if ($uro['fec_h'] == "12") echo "selected"; ?>>12 hrs
                                    </option>
                                    <option value="13" <?php if ($uro['fec_h'] == "13") echo "selected"; ?>>13 hrs
                                    </option>
                                    <option value="14" <?php if ($uro['fec_h'] == "14") echo "selected"; ?>>14 hrs
                                    </option>
                                    <option value="15" <?php if ($uro['fec_h'] == "15") echo "selected"; ?>>15 hrs
                                    </option>
                                    <option value="16" <?php if ($uro['fec_h'] == "16") echo "selected"; ?>>16 hrs
                                    </option>
                                    <option value="17" <?php if ($uro['fec_h'] == "17") echo "selected"; ?>>17 hrs
                                    </option>
                                    <option value="18" <?php if ($uro['fec_h'] == "18") echo "selected"; ?>>18 hrs
                                    </option>
                                    <option value="19" <?php if ($uro['fec_h'] == "19") echo "selected"; ?>>19 hrs
                                    </option>
                                    <option value="20" <?php if ($uro['fec_h'] == "20") echo "selected"; ?>>20 hrs
                                    </option>
                                </select>
                                <select name="fec_m" id="fec_m">
                                    <option value="">Min</option>
                                    <option value="00" <?php if ($uro['fec_m'] == "00") echo "selected"; ?>>00 min
                                    </option>
                                    <option value="15" <?php if ($uro['fec_m'] == "15") echo "selected"; ?>>15 min
                                    </option>
                                    <option value="30" <?php if ($uro['fec_m'] == "30") echo "selected"; ?>>30 min
                                    </option>
                                    <option value="45" <?php if ($uro['fec_m'] == "45") echo "selected"; ?>>45 min
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
                <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">

                    <div data-role="collapsible" data-collapsed="false"><h3>Consulta</h3>
                        <div class="scroll_h">
                            <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                                <tr>
                                    <td>Motivo de Consulta
                                        <textarea name="mot" id="mot"
                                                  data-mini="true"><?php echo $uro['mot']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>Diagnóstico
                                        <textarea name="dig" id="dig"
                                                  data-mini="true"><?php echo $uro['dig']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>
                                        <!--<ul data-role="listview" data-theme="c" data-inset="true" data-filter="true" data-filter-reveal="true" data-filter-placeholder="Agregar medicamentos..." data-mini="true" class="fil_med" data-icon="false">
            <?php //while($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
            <li><a href="#" class="med_insert" data="<?php //echo $med['des']; ?>"><?php //echo $med['nom']; ?></a></li>
            <?php //} ?>
        </ul>-->
                                        <label for="medi">Medicamentos:</label>
                                        <div id="print_med">
                                        <textarea name="medi" id="medi" data-mini="true"><?php echo $uro['medi']; ?></textarea>
                                        </div>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <div data-role="collapsible"><h3>Orden de Análisis Clínicos</h3>

                        <label for="aux">Exámenes Auxiliares:</label>
                        <div id="print_aux">
                            <textarea name="aux" id="aux" data-mini="true"><?php echo $uro['aux']; ?></textarea>
                        </div>
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
                        OTROS <textarea name="e_sol" id="e_sol" data-mini="true"><?php echo $uro['e_sol']; ?></textarea>

                    </div>

                    <div data-role="collapsible"><h3>Orden de Internamiento</h3>

                        <table width="100%" align="center" style="margin: 0 auto;">
                            <tr>
                                <td>Tipo:</td>
                                <td width="23%">
                                    <select name="in_t" id="in_t" data-mini="true">
                                        <option value="">---</option>
                                        <option value="Biopsia testicular" <?php if ($uro['in_t'] == "Biopsia testicular") echo "selected"; ?>>Biopsia testicular
                                        </option>
                                        <option value="Aspiración de epidídimo" <?php if ($uro['in_t'] == "Aspiración de epidídimo") echo "selected"; ?>>Aspiración de epidídimo
                                        </option>
                                    </select>
                                    </td>
                                <td>Fecha/Hora de Intervención</td>
                                <td>
                                    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                        <input type="date" name="in_f2" id="in_f2" value="<?php echo $uro['in_f2']; ?>"
                                               data-mini="true" data-wrapper-class="controlgroup-textinput ui-btn">
                                        <select name="in_hora" id="in_hora">
                                            <option value="">Hra</option>
                                            <option value="10:15" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "10:15") echo "selected"; ?>>
                                                10:15 hrs
                                            </option>
                                            <option value="11:00" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "11:00") echo "selected"; ?>>
                                                11:00 hrs
                                            </option>
                                            <option value="11:45" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "11:45") echo "selected"; ?>>
                                                11:45 hrs
                                            </option>
                                            <option value="12:30" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "12:30") echo "selected"; ?>>
                                                12:30 hrs
                                            </option>
                                            <option value="13:15" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "13:15") echo "selected"; ?>>
                                                13:15 hrs
                                            </option>
                                            <option value="14:00" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "14:00") echo "selected"; ?>>
                                                14:00 hrs
                                            </option>
                                            <option value="14:45" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "14:45") echo "selected"; ?>>
                                                14:45 hrs
                                            </option>
                                            <option value="15:30" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "15:30") echo "selected"; ?>>
                                                15:30 hrs
                                            </option>
                                            <option value="16:15" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "16:15") echo "selected"; ?>>
                                                16:15 hrs
                                            </option>
                                            <option value="17:00" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "17:00") echo "selected"; ?>>
                                                17:00 hrs
                                            </option>
                                            <option value="17:45" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "17:45") echo "selected"; ?>>
                                                17:45 hrs
                                            </option>
                                            <option value="18:30" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "18:30") echo "selected"; ?>>
                                                18:30 hrs
                                            </option>
                                            <option value="19:15" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "19:15") echo "selected"; ?>>
                                                19:15 hrs
                                            </option>
                                            <option value="20:00" <?php if ($uro['in_h2'] . ':' . $uro['in_m2'] == "20:00") echo "selected"; ?>>
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
                <?php if ($uro['med'] == $login) { ?>
                    <input type="Submit" value="GUARDAR DATOS" data-icon="check" data-iconpos="left" data-mini="true"
                           class="show-page-loading-msg" data-textonly="false" data-textvisible="true"
                           data-msgtext="Actualizando datos.." data-theme="b" data-inline="true"/>

                    <a href="javascript:PrintElem('#print_med','<?php echo $paci['p_ape'] . " " . $paci['p_nom']; ?>',1,'<?php echo date("d-m-Y", strtotime($uro['fec'])); ?>')"
                       data-role="button" data-mini="true" data-inline="true" rel="external">Imprimir Medicamentos</a>
                    <?php if ($uro['aux'] <> '') { ?>
                        <a href="javascript:PrintElem('#print_aux','<?php echo $paci['p_ape'] . " " . $paci['p_nom']; ?>',2,'<?php echo date("d-m-Y", strtotime($uro['fec'])); ?>')"
                           data-role="button" data-mini="true" data-inline="true" rel="external">Imprimir Orden de
                            Análisis Clínicos</a>
                    <?php } ?>

                <?php } else {
                    echo '<font color="#E34446"><b>PERMISO DE EDICION SOLO PARA: </b> ' . $uro['med'] . '</font>';
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
        if (document.getElementById("in_t").value != "") {
            if (document.getElementById("in_f2").value == "" || document.getElementById("in_hora").value == "") {
                alert("Debe ingresar la fecha Intervención");
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
        $('#alerta').delay(4000).fadeOut('slow');

    });//]]>
</script>
</body>
</html>
