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

            $('.alfanumerico').keyup(function () {

                var $th = $(this);
                $th.val($th.val().replace(/[^a-zA-Z0-9]/g, function (str) {
                    //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');

                    return '';
                }));

                //$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
            });
        });
    </script>
</head>

<body>


<?php
$fec = date("Y-m-d");
if (isSet($_POST['dni']) and $_POST['boton_datos'] == "GUARDAR DATOS") {

    insertPareja($_POST['dni'], $_POST['p_dni'], $_POST['p_tip'], $_POST['p_nom'], $_POST['p_ape'], $_POST['p_fnac'], $_POST['p_tcel'], $_POST['p_tcas'], $_POST['p_tofi'], $_POST['p_mai'], $_POST['p_dir'], $_POST['p_prof'], $_POST['p_san'], $_POST['p_raz'], $login, '', '');

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

$rPP = $db->prepare("SELECT p_dni FROM hc_pare_paci WHERE dni=? ORDER BY p_fec DESC");
$rPP->execute(array($id));

if (!file_exists("paci/" . $paci['dni'] . "/foto.jpg")) $foto_url = "_images/foto.gif"; else $foto_url = "paci/" . $paci['dni'] . "/foto.jpg?v=" . mt_rand(); ?>

<form action="n_pare.php?id=<?php echo $paci['dni']; ?>" method="post" data-ajax="false">
    <div data-role="page" class="ui-responsive-panel" id="n_pare">
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
                <li data-theme="b" class="ui-disabled"><a href="<?php echo "n_pare.php?id=" . $paci['dni']; ?>"
                                                          rel="external">Pareja</a></li>
                <li data-theme="b"><a href="<?php echo "n_gine.php?id=" . $paci['dni']; ?>" rel="external">Ginecología</a>
                </li>
                <li data-theme="b"><a href="<?php echo "n_obst.php?id=" . $paci['dni']; ?>" rel="external">Obstetricia</a>
                </li>
                <li data-theme="b"><a href="<?php echo "n_repro.php?id=" . $paci['dni']; ?>" rel="external">Repro.
                        Asistida</a></li>
                <li data-icon="info"><a href="ayuda.php" rel="external">Ayuda</a></li>
            </ul>
        </div><!-- /panel -->

        <div data-role="header" data-position="fixed">
            <a href="#indice_paci" data-icon="bars" id="b_indice" class="ui-icon-alt" data-theme="a">MENU
                <small>> Pareja</small>
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
            <div data-role="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#one" data-ajax="false" class="ui-btn-active ui-btn-icon-left ui-icon-bullets">Historial
                                de parejas</a></li>
                        <li><a href="#two" data-ajax="false" class="ui-btn-icon-left ui-icon-edit">Nueva Pareja</a></li>
                    </ul>
                </div>
                <div id="one" class="ui-body-d ui-content">
                    <ol data-role="listview" data-theme="a" data-inset="true">
                        <?php $c = 0;
                        while ($pp = $rPP->fetch(PDO::FETCH_ASSOC)) {
                            $rPare = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
                            $rPare->execute(array($pp['p_dni']));
                            $pare = $rPare->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <li>
                                <a href='<?php echo "e_pare.php?id=" . $paci['dni'] . "&ip=" . $pp['p_dni']; ?>'
                                   rel="external">
                                    <?php echo $pare['p_ape']; ?>
                                    <small><?php echo $pare['p_nom']; ?></small>
                                    <?php if ($c == 0) { ?><span class="ui-li-count">Actual</span><?php } ?>
                                </a>
                            </li>

                            <?php $c++;
                        }
                        if ($rPP->rowCount() < 1) echo '<p><h3>¡ No hay parejas !</h3></p>'; ?>
                    </ol>
                </div>
                <div id="two">
                    <div class="scroll_h">
                        <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                            <tr>
                                <td width="10%">Nombre(s)</td>
                                <td width="17%"><input name="p_nom" type="text" id="p_nom" data-mini="true"/></td>
                                <td width="8%">Apellidos</td>
                                <td width="22%"><input name="p_ape" type="text" id="p_ape" data-mini="true"/></td>
                                <td><select name="p_raz" id="p_raz" data-mini="true">
                                        <option value="">Raza:</option>
                                        <option value="Blanca">Blanca</option>
                                        <option value="Morena">Morena</option>
                                        <option value="Mestiza">Mestiza</option>
                                        <option value="Asiatica">Asiatica</option>
                                    </select></td>
                                <td><select name="p_san" id="p_san" data-mini="true">
                                        <option value="">G. Sangre:</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td><select name="p_tip" id="p_tip" data-mini="true">
                                        <option value="DNI" selected>DNI</option>
                                        <option value="PAS">PAS</option>
                                        <option value="CEX">CEX</option>
                                    </select></td>
                                <td><input name="p_dni" type="text" id="p_dni" data-mini="true" class="alfanumerico"/>
                                </td>
                                <td>F. Nac</td>
                                <td><input name="p_fnac" type="date" id="p_fnac" data-mini="true"/></td>
                                <td>Ocupación</td>
                                <td><input name="p_prof" type="text" id="p_prof" data-mini="true"/></td>
                            </tr>
                            <tr>
                                <td>Celular</td>
                                <td><input name="p_tcel" type="number" step="any" id="p_tcel" data-mini="true"
                                           class="numeros"/></td>
                                <td>T. Casa</td>
                                <td><input name="p_tcas" type="number" step="any" id="p_tcas" data-mini="true"
                                           class="numeros"/></td>
                                <td width="6%">E-mail</td>
                                <td><input name="p_mai" type="email" id="p_mai" data-mini="true"></td>
                            </tr>
                            <tr>
                                <td>T. Oficina</td>
                                <td><input name="p_tofi" type="number" step="any" id="p_tofi" data-mini="true"/></td>
                                <td>Dirección</td>
                                <td colspan="3"><input name="p_dir" type="text" id="p_dir" data-mini="true"/></td>
                            </tr>
                        </table>
                        <?php if ($user['role'] == 1) { ?>
                            <input type="Submit" value="GUARDAR DATOS" name="boton_datos" data-icon="check"
                                   data-iconpos="left" data-mini="true" class="show-page-loading-msg"
                                   data-textonly="false" data-textvisible="true" data-msgtext="Agregando datos.."
                                   data-theme="b" data-inline="true"/>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!--end TABS ------------------------------------------------------------------------------------- -->


        </div><!-- /content -->

        <?php } ?>
    </div><!-- /page -->
</form>
<script>
    $(document).on("click", ".show-page-loading-msg", function () {

        if (document.getElementById("p_nom").value == "") {
            alert("Debe llenar el campo 'Nombre'");
            return false;
        }
        if (document.getElementById("p_ape").value == "") {
            alert("Debe llenar el campo 'Apellidos'");
            return false;
        }
        if (document.getElementById("p_tip").value == "") {
            alert("Debe llenar el campo 'Tipo de Documento'");
            return false;
        }
        if (document.getElementById("p_dni").value == "") {
            alert("Debe llenar el campo 'DNI'");
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
