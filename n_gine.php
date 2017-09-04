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
        .scroll_h {
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
        }

        #alerta {
            background-color: #FF9;
            margin: 0 auto;
            text-align: center;
            padding: 4px;
        }

        .ui-tabs-panel {
            background-color: #FFF;
            padding: 5px;
        }

        .controlgroup-textinput {
            padding-top: 0.5px;
            padding-bottom: 0.5px;
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

            $('.numeros').keyup(function () {

                var $th = $(this);
                $th.val($th.val().replace(/[^0-9]/g, function (str) {
                    //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');

                    return '';
                }));

                //$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
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


            //---- vacia el valor de "mot" para hacer submit sin restriccion en proxima cita ---------------------------------------
            $('.ui-icon-calendar').click(function (e) {

                $('#mot').val('xxx');

            });

            $('.ui-icon-edit').click(function (e) {

                $('#mot').val('');

            });
        });

        function anular(x) {
            if (confirm("Esta apunto de eliminar esta consulta, esta seguro?")) {
                document.form2.borrar.value = x;
                document.form2.submit();
            }
            else
                return false;
        }
    </script>
</head>

<body>


<?php
if ($_POST['borrar'] <> "") {
    $stmt = $db->prepare("DELETE FROM hc_gineco WHERE id=?");
    $stmt->execute(array($_POST['borrar']));
}

if ($_POST['boton_datos'] == "AGENDAR CONSULTA" and isSet($_POST['dni']) and isSet($_POST['fec']) and isSet($_POST['fec_h'])) {

    insertGine($_POST['dni'], $_POST['fec'], $login, $_POST['fec_h'], $_POST['fec_m'], $_POST['mot'], 0);

}
if (isSet($_POST['dni']) and $_POST['graba_nota'] == 'GRABAR') {

    $stmt = $db->prepare("UPDATE hc_paciente SET nota=? WHERE dni=?");
    $stmt->execute(array($_POST['nota'], $_POST['dni']));

}

if ($_GET['id'] <> "") {
$id = $_GET['id'];
$rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

$rPaci = $db->prepare("SELECT dni,nom,ape,fnac,nota FROM hc_paciente WHERE dni=?");
$rPaci->execute(array($id));
$paci = $rPaci->fetch(PDO::FETCH_ASSOC);

$rGine = $db->prepare("SELECT id,fec,mot,cupon,repro,legal FROM hc_gineco WHERE dni=? ORDER BY fec DESC");
$rGine->execute(array($id));


if (!file_exists("paci/" . $paci['dni'] . "/foto.jpg")) $foto_url = "_images/foto.gif"; else $foto_url = "paci/" . $paci['dni'] . "/foto.jpg?v=" . mt_rand(); ?>
<form action="n_gine.php?id=<?php echo $paci['dni']; ?>" method="post" data-ajax="false" name="form2">
    <div data-role="page" class="ui-responsive-panel" id="n_gine">
        <div data-role="panel" id="indice_paci">
            <img src="_images/logo.jpg"/>
            <ul data-role="listview" data-inset="true" data-theme="a">
                <?php if ($user['role'] == 1) { ?>
                    <li data-icon="bars"><a href="lista.php" rel="external">Lista de Pacientes</a></li>
                    <li data-icon="plus"><a href="n_paci.php" rel="external">Nuevo Paciente</a></li>
                    <li data-icon="calendar"><a href="agenda_frame.php" rel="external">Agenda</a></li>
                    <li data-icon="bullets"><a href="r_pap.php" rel="external">Reporte PAP</a></li>
                    <li data-icon="bullets"><a href="r_parto.php" rel="external">Reporte Partos</a></li>
                    <li data-icon="bullets"><a href="lista_pro_b.php?med=1" rel="external">Lista Betas</a></li>

                <?php } else { ?>
                    <li data-icon="back"><a href="lista_pro.php" rel="external">Regresar</a></li>
                <?php } ?>
                <li data-role="list-divider" style="height:50px"><img src="<?php echo $foto_url; ?>">
                    <div style="float:right;">
                        <small><?php echo $paci['ape'] . "<br>" . $paci['nom']; ?></small>
                    </div>
                </li>
                <li data-theme="b"><a href="<?php echo "e_paci.php?id=" . $paci['dni']; ?>" rel="external">Datos y
                        Antecedentes</a></li>
                <li data-theme="b"><a href="<?php echo "n_pare.php?id=" . $paci['dni']; ?>" rel="external">Pareja</a></li>
                <li class="ui-disabled" data-theme="b"><a href="<?php echo "n_gine.php?id=" . $paci['dni']; ?>"
                                                          rel="external">Ginecología</a></li>
                <li data-theme="b"><a href="<?php echo "n_obst.php?id=" . $paci['dni']; ?>" rel="external">Obstetricia</a>
                </li>
                <li data-theme="b"><a href="<?php echo "n_repro.php?id=" . $paci['dni']; ?>" rel="external">Repro.
                        Asistida</a></li>
                <li data-icon="info"><a href="ayuda.php" rel="external">Ayuda</a></li>
            </ul>
        </div><!-- /panel -->

        <div data-role="header" data-position="fixed">
            <a href="#indice_paci" data-icon="bars" id="b_indice" class="ui-icon-alt" data-theme="a">MENU
                <small>> Ginecología</small>
            </a>
            <h2><?php echo $paci['ape']; ?>
                <small><?php echo $paci['nom'];
                    if ($paci['fnac'] <> "0000-00-00") echo ' <a href="#popupBasic" data-rel="popup" data-transition="pop">(' . date_diff(date_create($paci['fnac']), date_create('today'))->y . ')</a>'; ?></small>
            </h2>
            <a href="index.php"
               class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power"
               rel="external"> Salir</a>
        </div><!-- /header -->
        <div data-role="popup" id="popupBasic" data-arrow="true">
            <textarea name="nota" id="nota" data-mini="true"><?php echo $paci['nota']; ?></textarea>
            <input type="Submit" value="GRABAR" name="graba_nota" data-mini="true"/>
        </div>

        <div class="ui-content" role="main">


            <input type="hidden" name="dni" value="<?php echo $paci['dni']; ?>">
            <input type="hidden" name="borrar">
            <div data-role="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#one" data-ajax="false" class="ui-btn-active ui-btn-icon-left ui-icon-bullets">Historial
                                de consultas</a></li>
                        <li><a href="#two" data-ajax="false" class="ui-btn-icon-left ui-icon-edit">Agendar nueva
                                consulta</a></li>
                    </ul>
                </div>
                <div id="one">
                    <ol data-role="listview" data-theme="a" data-split-icon="delete" data-inset="true">
                        <?php while ($gine = $rGine->fetch(PDO::FETCH_ASSOC)) { ?>
                            <li>
                                <a href='<?php echo "e_gine.php?id=" . $gine['id']; ?>' rel="external">
                                    <small><?php echo $gine['mot']; ?></small>
                                    <?php $estado = '';
                                    if ($gine['repro'] <> '' and $gine['repro'] <> 'NINGUNA') $estado .= 'REPRO. ASISTIDA  ';
                                    if ($gine['cupon'] == 1) $estado .= 'ConoNORTE  ';
                                    if ($gine['cupon'] == 2) $estado .= 'ConoSUR  ';
                                    if ($gine['cupon'] == 3) $estado .= 'Tacna  ';
                                    if ($gine['cupon'] == 4) $estado .= 'Arequipa  ';
                                    if ($gine['fec'] > date("Y-m-d")) $estado .= 'PENDIENTE PARA '; ?>

                                    <span class="ui-li-count"><?php echo $estado . date("d-m-Y", strtotime($gine['fec'])); ?></span>
                                </a>
                                <?php if ($gine['legal'] == 0) { ?>
                                    <a href="javascript:anular(<?php echo $gine["id"]; ?>);">Eliminar</a>
                                <?php } ?>
                            </li>

                        <?php }
                        if ($rGine->rowCount() < 1) echo '<p><h3>¡ No hay consultas pasadas !</h3></p>'; ?>
                    </ol>
                </div>
                <div id="two">
                    <h4>Aquí podra agendar la próxima consulta, la cual aparecerá en Historial de Consulta como
                        "pendiente".</h4>
                    <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                        <tr>
                            <td width="11%">Fecha:</td>
                            <td width="50%">
                                <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                    <input name="fec" type="date" id="fec" value="<?php echo date("Y-m-d"); ?>"
                                           data-wrapper-class="controlgroup-textinput ui-btn">
                                    <select name="fec_h" id="fec_h">
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
                                        <option value="20">20 hrs</option>
                                    </select>
                                    <select name="fec_m" id="fec_m">
                                        <option value="">Min</option>
                                        <option value="00">00 min</option>
                                        <option value="15">15 min</option>
                                        <option value="30">30 min</option>
                                        <option value="45">45 min</option>
                                    </select>
                                </div>
                            </td>
                            <td width="39%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3">Motivo de Consulta <textarea name="mot" id="mot"
                                                                         data-mini="true"></textarea></td>
                        </tr>
                    </table>
                    <?php if ($user['role'] == 1) { ?>
                        <input type="Submit" value="AGENDAR CONSULTA" name="boton_datos" data-icon="check"
                               data-iconpos="left" data-mini="true" class="show-page-loading-msg"
                               data-textonly="false" data-textvisible="true" data-msgtext="Agregando datos.."
                               data-theme="b" data-inline="true"/>
                    <?php } ?>
                </div>
            </div>
            <!--end TABS ------------------------------------------------------------------------------------- -->


        </div><!-- /content -->

        <?php } ?>
    </div><!-- /page -->
</form>
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
        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>

</script>
</body>
</html>
