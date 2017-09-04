<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $login = $_SESSION['login'];
    $dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
    if (!$login) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://" . $dir . "'>";
    } else {
    require("_database/db_tools.php");
        $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
        $rUser->execute(array($login));
        $user = $rUser->fetch(PDO::FETCH_ASSOC); } ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="_themes/tema_inmater.min.css"/>
    <link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css"/>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script>
        function anular(x, y, z) {
            document.form2.borrarX.value = x;
            document.form2.borrarY.value = y;
            document.form2.borrarTipo.value = z;
            document.form2.submit();
        }
        function borrar(x) {
            if (confirm("CONFIRMA BORRAR ESTA CONSULTA ?")) {
            document.form2.borrarUro.value = x;
            document.form2.submit();
                return true;
            } else return false;
        }
    </script>
</head>
<body>
<div data-role="page" class="ui-responsive-panel" id="e_pare" <?php if ($user['role'] <> 7) echo 'data-dialog="true"';?>>
    <?php if (isSet($_POST['p_dni'])) {

        if ($_POST['borrarTipo'] <> "" and $_POST['borrarX'] <> "" and $_POST['borrarY'] <> "") { // borra adndrologia = No capacitacion------
            $stmt = $db->prepare("DELETE FROM lab_andro_" . $_POST['borrarTipo'] . " WHERE p_dni=? and fec=?");
            $stmt->execute(array($_POST['borrarX'], $_POST['borrarY']));
        }
        if ($_POST['borrarTipo'] <> "" and $_POST['borrarX'] <> "" and $_POST['borrarY'] == "") { // borra capacitacion------
            $stmt = $db->prepare("DELETE FROM lab_andro_" . $_POST['borrarTipo'] . " WHERE id=?");
            $stmt->execute(array($_POST['borrarX']));
        }
        if ($_POST['borrarUro'] <> "") { // borra urologia------
            $stmt = $db->prepare("DELETE FROM hc_urolo WHERE id=?");
            $stmt->execute(array($_POST['borrarUro']));
        }
        if ($_POST['guardar'] == "GUARDAR DATOS") {
            updatePareja($_POST['dni'], $_POST['p_dni'], $_POST['p_tip'], $_POST['p_nom'], $_POST['p_ape'], $_POST['p_fnac'], $_POST['p_tcel'], $_POST['p_tcas'], $_POST['p_tofi'], $_POST['p_mai'], $_POST['p_dir'], $_POST['p_prof'], $_POST['p_san'], $_POST['p_raz'], $_POST['p_f_dia'], $_POST['p_f_hip'], $_POST['p_f_gem'], $_POST['p_f_hta'], $_POST['p_f_tbc'], $_POST['p_f_can'], $_POST['p_f_otr'], $_POST['p_m_dia'], $_POST['p_m_hip'], $_POST['p_m_inf1'], $_POST['p_m_ale1'], $_POST['p_m_tbc'], $_POST['p_m_can'], $_POST['p_m_otr'], $_POST['p_m_ets'], $_POST['p_h_str'], $_POST['p_h_dep'], $_POST['p_h_dro'], $_POST['p_h_tab'], $_POST['p_h_alc'], $_POST['p_h_otr'], $_POST['p_obs'], $_POST['p_pes'], $_POST['p_tal'], $_POST['p_ojo'], $_POST['p_cab'], $_POST['p_ins'], $_POST['p_icq'], $_FILES['foto'], $_FILES['foto1'], $_FILES['foto2'], $_FILES['doc1'], $_FILES['doc2'], $_FILES['doc3'], $_FILES['doc4'], $_POST['p_het'], $_POST['p_med'], $_POST['p_med_mai'], $_POST['p_med_cel'], $_POST['role']);
        }

        if ($_POST['p_Esp'] == "Solicitar") updateAndro_esp('', $_POST['dni'], $_POST['p_dni'], date("Y-m-d"), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
        if ($_POST['p_Tes_cap'] == "Solicitar") updateAndro_tes_cap('', $_POST['dni'], $_POST['p_dni'], date("Y-m-d"), '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
        if ($_POST['p_Tes_sob'] == "Solicitar") updateAndro_tes_sob('', $_POST['dni'], $_POST['p_dni'], date("Y-m-d"), '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
        if ($_POST['p_Bio_tes'] == "Solicitar") updateAndro_bio_tes('', $_POST['dni'], $_POST['p_dni'], date("Y-m-d"), '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '');
        if ($_POST['p_Crio_sem'] == "Solicitar") updateAndro_crio_sem('', $_POST['dni'], $_POST['p_dni'], date("Y-m-d"), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '');
        if ($_POST['p_Cap'] == "Solicitar") updateAndro_cap('', $_POST['dni'], $_POST['p_dni'], date("Y-m-d"), null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, '', '', '', 0);
    }

    if ($_GET['ip'] <> "") {

        $dni = $_GET['id'];
        $p_dni = $_GET['ip'];
        $rPare = $db->prepare("SELECT * FROM hc_pareja WHERE p_dni=?");
        $rPare->execute(array($p_dni));
        $pare = $rPare->fetch(PDO::FETCH_ASSOC);

        $rUro = $db->prepare("SELECT id,fec,mot FROM hc_urolo WHERE p_dni=? ORDER by fec DESC");
        $rUro->execute(array($p_dni));

        $rPP = $db->prepare("SELECT p_het FROM hc_pare_paci WHERE dni=? and p_dni=?");
        $rPP->execute(array($dni, $p_dni));
        $pp = $rPP->fetch(PDO::FETCH_ASSOC);

        $Quiru = $db->prepare("SELECT * FROM hc_antece_p_quiru WHERE p_dni=? ORDER by fec DESC");
        $Quiru->execute(array($p_dni));

        $Sero = $db->prepare("SELECT * FROM hc_antece_p_sero WHERE p_dni=? ORDER by fec DESC");
        $Sero->execute(array($p_dni));

        $Examp = $db->prepare("SELECT * FROM hc_antece_p_examp WHERE p_dni=? ORDER by fec DESC");
        $Examp->execute(array($p_dni));

        $Cap = $db->prepare("SELECT * FROM lab_andro_cap WHERE p_dni=? ORDER by fec DESC");
        $Cap->execute(array($p_dni));

        $Tes_cap = $db->prepare("SELECT * FROM lab_andro_tes_cap WHERE p_dni=? ORDER by fec DESC");
        $Tes_cap->execute(array($p_dni));

        $Tes_sob = $db->prepare("SELECT * FROM lab_andro_tes_sob WHERE p_dni=? ORDER by fec DESC");
        $Tes_sob->execute(array($p_dni));

        $Bio_tes = $db->prepare("SELECT * FROM lab_andro_bio_tes WHERE p_dni=? ORDER by fec DESC");
        $Bio_tes->execute(array($p_dni));

        $Crio_sem = $db->prepare("SELECT * FROM lab_andro_crio_sem WHERE p_dni=? ORDER by fec DESC");
        $Crio_sem->execute(array($p_dni));

        $Esp = $db->prepare("SELECT * FROM lab_andro_esp WHERE p_dni=? ORDER by fec DESC");
        $Esp->execute(array($p_dni));

        $rAnal = $db->prepare("SELECT * FROM hc_analisis WHERE a_dni=? and lab<>'legal' ORDER by a_fec DESC");
        $rAnal->execute(array($p_dni));

        $rLegal = $db->prepare("SELECT * FROM hc_legal WHERE a_dni=? ORDER by a_fec ASC");
        $rLegal->execute(array($p_dni));

        if (!file_exists("pare/" . $p_dni . "/foto.jpg")) $foto_url = "_images/foto.gif"; else $foto_url = "pare/" . $p_dni . "/foto.jpg?v=" . mt_rand();
        ?>

        <style>
            .ui-dialog-contain {
                max-width: 1200px;
                margin: 1% auto 1%;
                padding: 0;
                position: relative;
                top: -35px;
            }

            .enlinea div {
                display: inline-block;
                vertical-align: middle;
            }

            .color {
                color: #F4062B;
            }

            .ui-slider input {
                visibility: hidden
            }

            .ui-slider-track {
                margin: 0 15px 0 15px
            }

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
        </style>
        <script>
            $(document).ready(function () {
                $(window).keydown(function (event) { // inabilita la tecla enter ------
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
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

                $(".p_het").hide();

                $("#p_het").change(function () {

                    if ($(this).prop('checked')) {
                        $(".p_het").show();
                    } else {
                        $(".p_het").hide();
                    }
                });

                $('.numeros').keyup(function () {

                    var $th = $(this);
                    $th.val($th.val().replace(/[^0-9.]/g, function (str) {
                        //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');

                        return '';
                    }));

                    //$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
                });

                $('.chekes').change(function () {

                    var temp = '#' + $(this).attr("id") + '1';

                    if ($(this).prop('checked') || $(this).val() == "Medicamentada" || $(this).val() == "Otra" || $(this).val() == "Anormal") {

                        $(temp).prop('readonly', false);
                        //$(temp).placeholder=$(this).val();

                    } else {
                        $(temp).prop('readonly', true);
                        $(temp).val('');
                    }

                });

                $(".med_insert").change(function () {
                    var med = $(this).attr("title");
                    var str = $('#' + med).val();
                    var items = $(this).val();

                    var n = str.indexOf(items);

                    if (n == -1) {	// no agrega duplicados -----------------------------------------------------
                        $('#' + med).val(items + ", " + str);
                        if (items == "Borrar") $('#' + med).val("");
                        $('#' + med).textinput('refresh');
                    }

                    $(this).prop('selectedIndex', 0);
                    $(this).selectmenu("refresh", true);
                });

            });
        </script>
    <?php if ($pp['p_het'] >= 1 and $login == "lab") { ?>
        <script>
            $(document).ready(function () {
                $(".p_het").show();
            });
        </script>
    <?php } ?>

    <?php if ($_GET['pop'] <> "" or $login == "lab" or $login == "pagos") { ?>
        <script>
            $(document).ready(function () {

                var x = "<?php echo $_GET['pop']; ?>";
                var u = "<?php echo $login; ?>";

                if (u == "lab" || u == "pagos") {
                    $("#tab1").removeClass("ui-btn-active");
                    $("#tab2").addClass("ui-btn-active");
                    $("#tabx").tabs({active: 1});
                }

                $("#" + x).collapsible({collapsed: false});
            });
        </script>
    <?php } ?>

        <div data-role="header" data-position="fixed">
            <h2><?php echo $pare['p_ape']; ?>
                <small><?php echo $pare['p_nom']; ?></small><?php if ($dni == "") echo ' (Particular)';
                if ($pare['p_fnac'] <> "0000-00-00") echo ' (' . date_diff(date_create($pare['p_fnac']), date_create('today'))->y . ')'; ?></h2>
            <?php if ($user['role'] == 7) { ?>
            <a href="lista.php" rel="external" class="ui-btn">Lista de Pacientes</a>
            <?php } else { ?>
                <a href="<?php if ($login == "lab") echo "lista_and.php"; else if ($login == "pagos") echo "lista.php"; else echo "n_pare.php?id=" . $dni; ?>" rel="external" class="ui-btn">Cerrar</a>
        <?php } ?>
        </div><!-- /header -->

        <div class="ui-content" role="main">

            <form action="e_pare.php?id=<?php echo $dni . '&ip=' . $p_dni; ?>" method="post" enctype="multipart/form-data"
                  data-ajax="false" name="form2" novalidate>
                <input type="hidden" name="dni" value="<?php echo $dni; ?>">
                <input type="hidden" name="p_dni" value="<?php echo $p_dni; ?>">
                <input type="hidden" name="role" value="<?php echo $user['role']; ?>">
                <input type="hidden" name="borrarX">
                <input type="hidden" name="borrarY">
                <input type="hidden" name="borrarTipo">
                <input type="hidden" name="borrarUro">
                <div data-role="tabs" id="tabx">
                    <div data-role="navbar">
                        <ul>
                            <li><a href="#one" id="tab1" data-ajax="false" class="ui-btn-active">DATOS GENERALES Y ANTECEDENTES</a></li>
                            <li><a href="#two" id="tab2" data-ajax="false">ANDROLOGIA</a></li>
                            <li><a href="#tre" id="tab3" data-ajax="false"> CONSULTAS UROLOGIA</a></li>
                        </ul>
                    </div>
                    <div id="one">

                        <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">
                            <div data-role="collapsible" data-collapsed="false"><h3>Datos Generales</h3>
                                <div class="scroll_h">
                                    <table align="center" style="margin: 0 auto; font-size: small;">
                                        <tr>
                                            <td width="9%">Nombre(s)</td>
                                            <td width="22%"><input name="p_nom" type="text" id="p_nom" data-mini="true"
                                                                   value="<?php echo $pare['p_nom']; ?>"/></td>
                                            <td width="5%">Apellidos</td>
                                            <td width="32%"><input name="p_ape" type="text" id="p_ape" data-mini="true"
                                                                   value="<?php echo $pare['p_ape']; ?>"/></td>
                                            <td colspan="2">
                                                <fieldset data-role="controlgroup" data-type="horizontal">
                                                    <select name="p_raz" id="p_raz" data-mini="true">
                                                        <option value="">Raza:</option>
                                                        <option value="Blanca" <?php if ($pare['p_raz'] == "Blanca") echo "selected"; ?>>
                                                            Blanca
                                                        </option>
                                                        <option value="Morena" <?php if ($pare['p_raz'] == "Morena") echo "selected"; ?>>
                                                            Morena
                                                        </option>
                                                        <option value="Mestiza" <?php if ($pare['p_raz'] == "Mestiza") echo "selected"; ?>>
                                                            Mestiza
                                                        </option>
                                                        <option value="Asiatica" <?php if ($pare['p_raz'] == "Asiatica") echo "selected"; ?>>
                                                            Asiatica
                                                        </option>
                                                    </select> <select name="p_san" id="p_san" data-mini="true">
                                                        <option value="">G. Sangre:</option>
                                                        <option value="O+" <?php if ($pare['p_san'] == "O+") echo "selected"; ?>>
                                                            GS: O+
                                                        </option>
                                                        <option value="O-" <?php if ($pare['p_san'] == "O-") echo "selected"; ?>>
                                                            GS: O-
                                                        </option>
                                                        <option value="A+" <?php if ($pare['p_san'] == "A+") echo "selected"; ?>>
                                                            GS: A+
                                                        </option>
                                                        <option value="A-" <?php if ($pare['p_san'] == "A-") echo "selected"; ?>>
                                                            GS: A-
                                                        </option>
                                                        <option value="B+" <?php if ($pare['p_san'] == "B+") echo "selected"; ?>>
                                                            GS: B+
                                                        </option>
                                                        <option value="B-" <?php if ($pare['p_san'] == "B-") echo "selected"; ?>>
                                                            GS: B-
                                                        </option>
                                                        <option value="AB+" <?php if ($pare['p_san'] == "AB+") echo "selected"; ?>>
                                                            GS: AB+
                                                        </option>
                                                        <option value="AB-" <?php if ($pare['p_san'] == "AB-") echo "selected"; ?>>
                                                            GS: AB-
                                                        </option>
                                                    </select>
                                                    <?php if ($dni == "" and $login == "lab") { ?>
                                                        <label for="p_het">Donante</label>
                                                        <input <?php if ($pp['p_het']>=1) echo 'type="hidden"'; else echo 'type="checkbox"'; ?>
                                                                name="p_het" id="p_het" data-mini="true"
                                                                value=2 <?php if ($pp['p_het'] >= 1) echo "checked"; //por defecto se asiga 2=No Apto ?> >
                                                    <?php } ?>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><select name="p_tip" id="p_tip" data-mini="true">
                                                    <option value="DNI" <?php if ($pare['p_tip'] == "DNI") echo "selected"; ?>>
                                                        DNI
                                                    </option>
                                                    <option value="PAS" <?php if ($pare['p_tip'] == "PAS") echo "selected"; ?>>
                                                        PAS
                                                    </option>
                                                    <option value="CEX" <?php if ($pare['p_tip'] == "CEX") echo "selected"; ?>>
                                                        CEX
                                                    </option>
                                                </select></td>
                                            <td><?php echo $p_dni; ?></td>
                                            <td>F. Nac</td>
                                            <td><input name="p_fnac" type="date" id="p_fnac" data-mini="true"
                                                       value="<?php echo $pare['p_fnac']; ?>"/></td>
                                            <td colspan="2" rowspan="4">
                                                <a href="#popupPerfil" data-rel="popup" data-position-to="window"
                                                   data-transition="fade"><img src="<?php echo $foto_url; ?>" width="100px"
                                                                               height="100px" id="preview"/></a>
                                                <div data-role="popup" id="popupPerfil" data-overlay-theme="b"
                                                     data-theme="b" data-corners="false">
                                                        <a href="#" data-rel="back"
                                                           class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a><img
                                                            src="<?php echo $foto_url; ?>" style="max-height:512px;">
                                                </div>
                                                <input name="foto" type="file" onchange="previewImage(this)"
                                                       accept="image/jpeg" id="foto"/>
                                                </fieldset>
                                                <script type="text/javascript">
                                                    function previewImage(input) {
                                                        var preview = document.getElementById('preview');
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();
                                                            reader.onload = function (e) {
                                                                preview.setAttribute('src', e.target.result);
                                                            }
                                                            reader.readAsDataURL(input.files[0]);
                                                        } else {
                                                            preview.setAttribute('src', 'placeholder.png');
                                                        }
                                                    }
                                                </script>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Celular</td>
                                            <td><input name="p_tcel" type="number" step="any" id="p_tcel"
                                                       data-mini="true" class="numeros"
                                                       value="<?php echo $pare['p_tcel']; ?>"/></td>
                                            <td>T. Casa</td>
                                            <td><input name="p_tcas" type="number" step="any" id="p_tcas"
                                                       data-mini="true" class="numeros"
                                                       value="<?php echo $pare['p_tcas']; ?>"/></td>
                                        </tr>
                                        <tr>
                                            <td>T. Oficina</td>
                                            <td><input name="p_tofi" type="number" step="any" id="p_tofi"
                                                       data-mini="true" value="<?php echo $pare['p_tofi']; ?>"/></td>
                                            <td>Ocupación</td>
                                            <td><input name="p_prof" type="text" id="p_prof" data-mini="true"
                                                       value="<?php echo $pare['p_prof']; ?>"/></td>
                                        </tr>
                                        <tr>
                                            <td>E-Mail</td>
                                            <td><input name="p_mai" type="email" id="p_mai" data-mini="true"
                                                       value="<?php echo $pare['p_mai']; ?>"></td>
                                            <td>Dirección</td>
                                            <td><input name="p_dir" type="text" id="p_dir" data-mini="true"
                                                       value="<?php echo $pare['p_dir']; ?>"/></td>
                                        </tr>
                                        <?php if ($dni == "") { ?>
                                            <tr>
                                                <td colspan="6" align="center" class="ui-bar-a">Médico de procedencia
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nombre y Apellidos</td>
                                                <td><input name="p_med" type="text" required id="p_med"
                                                           value="<?php echo $pare['p_med']; ?>" data-mini="true"/></td>
                                                <td>E-mail</td>
                                                <td><input name="p_med_mai" type="email" id="p_med_mai"
                                                           value="<?php echo $pare['p_med_mai']; ?>" data-mini="true"></td>
                                                <td width="4%">Teléfono</td>
                                                <td width="28%"><input name="p_med_cel" type="number" step="any"
                                                                       id="p_med_cel"
                                                                       value="<?php echo $pare['p_med_cel']; ?>"
                                                                       data-mini="true"/></td>
                                            </tr>
                                        <?php } else {
                                            if ($login == 'lab') $medico = ''; else $medico = $login;
                                            echo '<input name="p_med" type="hidden" value="' . $medico . '" />';
                                        } ?>
                                    </table>
                                    <table width="100%" align="center" style="margin: 0 auto; font-size: small;"
                                           class="p_het">
                                        <tr>
                                            <td colspan="5" align="center" class="ui-bar-a">DONANTE</td>
                                        </tr>
                                        <tr>
                                            <td width="9%">ICQ</td>
                                            <td width="18%">
                                                <input name="p_icq" type="range" id="p_icq" min="80" max="160"
                                                       value="<?php echo $pare['p_icq']; ?>" data-show-value="true"
                                                       data-popup-enabled="true" data-highlight="true"></td>
                                            <td width="13%">Evaluación Sicológica</td>
                                            <td width="32%"><input name="doc1" type="file" accept="application/pdf"
                                                                   id="doc1"/></td>
                                            <td width="28%"><?php if (file_exists("pare/" . $p_dni . "/eval_sico.pdf"))
                                                    echo "<a href='pare/" . $p_dni . "/eval_sico.pdf' target='new'>eval_sico.pdf</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Color Cabello</td>
                                            <td align="center"><select name="p_cab" id="p_cab" data-mini="true"
                                                                       data-inline="true">
                                                    <option value="" selected>---</option>
                                                    <option value=1 <?php if ($pare['p_cab'] == 1) echo "selected"; ?>>
                                                        Negro
                                                    </option>
                                                    <option value=2 <?php if ($pare['p_cab'] == 2) echo "selected"; ?>>
                                                        Castaño
                                                    </option>
                                                    <option value=3 <?php if ($pare['p_cab'] == 3) echo "selected"; ?>>
                                                        Rubio
                                                    </option>
                                                    <option value=4 <?php if ($pare['p_cab'] == 4) echo "selected"; ?>>
                                                        Pelirojo
                                                    </option>
                                                </select></td>
                                            <td width="13%">Cariotipo</td>
                                            <td width="32%"><input name="doc2" type="file" accept="application/pdf"
                                                                   id="doc2"/></td>
                                            <td width="28%"><?php if (file_exists("pare/" . $p_dni . "/careotipo.pdf"))
                                                    echo "<a href='pare/" . $p_dni . "/careotipo.pdf' target='new'>careotipo.pdf</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Color Ojos</td>
                                            <td align="center"><select name="p_ojo" id="p_ojo" data-mini="true"
                                                                       data-inline="true">
                                                    <option value="" selected>---</option>
                                                    <option value=1 <?php if ($pare['p_ojo'] == 1) echo "selected"; ?>>
                                                        Negro
                                                    </option>
                                                    <option value=2 <?php if ($pare['p_ojo'] == 2) echo "selected"; ?>>
                                                        Pardo
                                                    </option>
                                                    <option value=3 <?php if ($pare['p_ojo'] == 3) echo "selected"; ?>>
                                                        Verde
                                                    </option>
                                                    <option value=4 <?php if ($pare['p_ojo'] == 4) echo "selected"; ?>>
                                                        Azul
                                                    </option>
                                                    <option value=5 <?php if ($pare['p_ojo'] == 5) echo "selected"; ?>>
                                                        Gris
                                                    </option>
                                                </select></td>
                                            <td width="13%">Fragmentación de ADN</td>
                                            <td width="32%"><input name="doc3" type="file" accept="application/pdf"
                                                                   id="doc3"/></td>
                                            <td width="28%"><?php if (file_exists("pare/" . $p_dni . "/frag_adn.pdf"))
                                                    echo "<a href='pare/" . $p_dni . "/frag_adn.pdf' target='new'>frag_adn.pdf</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nivel Instrucción</td>
                                            <td align="center"><select name="p_ins" id="p_ins" data-mini="true"
                                                                       data-inline="true">
                                                    <option value="" selected>---</option>
                                                    <option value=1 <?php if ($pare['p_ins'] == 1) echo "selected"; ?>>
                                                        Incial
                                                    </option>
                                                    <option value=2 <?php if ($pare['p_ins'] == 2) echo "selected"; ?>>
                                                        Secundaria
                                                    </option>
                                                    <option value=3 <?php if ($pare['p_ins'] == 3) echo "selected"; ?>>
                                                        Tecnico
                                                    </option>
                                                    <option value=4 <?php if ($pare['p_ins'] == 4) echo "selected"; ?>>
                                                        Universidad
                                                    </option>
                                                    <option value=5 <?php if ($pare['p_ins'] == 5) echo "selected"; ?>>
                                                        Postgrado
                                                    </option>
                                                </select></td>
                                            <td width="13%">Fish en esperma</td>
                                            <td width="32%"><input name="doc4" type="file" accept="application/pdf"
                                                                   id="doc4"/></td>
                                            <td width="28%"><?php if (file_exists("pare/" . $p_dni . "/fish_spz.pdf"))
                                                    echo "<a href='pare/" . $p_dni . "/fish_spz.pdf' target='new'>fish_spz.pdf</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Talla</td>
                                            <td><input name="p_tal" type="range" id="p_tal" min="160" max="210"
                                                       value="<?php echo $pare['p_tal']; ?>" data-show-value="true"
                                                       data-popup-enabled="true" data-highlight="true"></td>
                                            <td>Foto de infancia 1</td>
                                            <td><input name="foto1" type="file" accept="image/jpeg"/></td>
                                            <td width="28%" rowspan="2"><?php
                                                $foto1 = "pare/" . $p_dni . "/foto1.jpg";
                                                $foto2 = "pare/" . $p_dni . "/foto2.jpg";

                                                if (file_exists($foto1)) {
                                                    echo "<a href='#foto1' data-rel='popup' data-position-to='window' style='float:left'><img src='" . $foto1 . "?v=" . mt_rand() . "' width='60px' height='60px' /></a>";
                                                    echo '<div data-role="popup" id="foto1" data-overlay-theme="a" style="max-width:1000px;"><img src="' . $foto1 . '"/></div>';
                                                }
                                                if (file_exists($foto2)) {
                                                    echo "<a href='#foto2' data-rel='popup' data-position-to='window' style='float:left'><img src='" . $foto2 . "?v=" . mt_rand() . "' width='60px' height='60px' /></a>";
                                                    echo ' <div data-role="popup" id="foto2" data-overlay-theme="a" style="max-width:1000px;"><img src="' . $foto2 . '"/></div>';
                                                } ?></td>
                                        </tr>
                                        <tr>
                                            <td>Peso</td>
                                            <td><input name="p_pes" type="range" id="p_pes" min="60" max="120"
                                                       value="<?php echo $pare['p_pes']; ?>" data-show-value="true"
                                                       data-popup-enabled="true" data-highlight="true"></td>
                                            <td>Foto de infancia 2</td>
                                            <td><input name="foto2" type="file" accept="image/jpeg"/></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div data-role="collapsible"><h3>Familiares</h3>
                                <div class="scroll_h">
                                    <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                                        <tr>
                                            <td width="7%"><input type="checkbox" name="p_f_dia" id="p_f_dia"
                                                                  data-mini="true"
                                                                  value="Si" <?php if ($pare['p_f_dia'] == "Si") echo "checked"; ?>><label
                                                        for="p_f_dia">Diabetes</label></td>
                                            <td width="10%"><input type="checkbox" name="p_f_hip" id="p_f_hip"
                                                                   data-mini="true"
                                                                   value="Si" <?php if ($pare['p_f_hip'] == "Si") echo "checked"; ?>><label
                                                        for="p_f_hip">Hipertensión</label></td>
                                            <td width="17%"><input type="checkbox" name="p_f_gem" id="p_f_gem"
                                                                   data-mini="true"
                                                                   value="Si" <?php if ($pare['p_f_gem'] == "Si") echo "checked"; ?>><label
                                                        for="p_f_gem">Gemelares</label></td>
                                            <td width="5%"><input type="checkbox" name="p_f_hta" id="p_f_hta"
                                                                  data-mini="true"
                                                                  value="Si" <?php if ($pare['p_f_hta'] == "Si") echo "checked"; ?>><label
                                                        for="p_f_hta">HTA</label></td>
                                            <td width="61%"><select name="p_f_tbc" id="p_f_tbc" data-mini="true">
                                                    <option value="" selected="selected">TBC:</option>
                                                    <option value="NO" <?php if ($pare['p_f_tbc'] == "NO") echo "selected"; ?>>
                                                        TBC: NO
                                                    </option>
                                                    <optgroup label="TBC: SI">
                                                        <option value="Pulmonar" <?php if ($pare['p_f_tbc'] == "Pulmonar") echo "selected"; ?>>
                                                            TBC: Pulmonar
                                                        </option>
                                                        <option value="Extrapulmonar" <?php if ($pare['p_f_tbc'] == "Extrapulmonar") echo "selected"; ?>>
                                                            TBC: Extrapulmonar
                                                        </option>
                                                    </optgroup>

                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Cancer
                                                <textarea name="p_f_can" id="p_f_can"
                                                          data-mini="true"><?php echo $pare['p_f_can']; ?></textarea></td>
                                            <td>Otros
                                                <textarea name="p_f_otr" id="p_f_otr"
                                                          data-mini="true"><?php echo $pare['p_f_otr']; ?></textarea></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div data-role="collapsible"><h3>Médicos</h3>
                                <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                                    <tr>
                                        <td width="10%"><input type="checkbox" name="p_m_dia" id="p_m_dia"
                                                               data-mini="true"
                                                               value="Si" <?php if ($pare['p_m_dia'] == "Si") echo "checked"; ?>>
                                            <label for="p_m_dia">Diabetes</label></td>
                                        <td width="21%"><input type="checkbox" name="p_m_hip" id="p_m_hip"
                                                               data-mini="true"
                                                               value="Si" <?php if ($pare['p_m_hip'] == "Si") echo "checked"; ?>>
                                            <label for="p_m_hip">Hipertensión</label></td>
                                        <td colspan="2"><select name="p_m_tbc" id="p_m_tbc" data-mini="true">
                                                <option value="" selected="selected">TBC:</option>
                                                <option value="NO" <?php if ($pare['p_m_tbc'] == "NO") echo "selected"; ?>>
                                                    TBC: NO
                                                </option>
                                                <optgroup label="TBC: SI">
                                                    <option value="Pulmonar" <?php if ($pare['p_m_tbc'] == "Pulmonar") echo "selected"; ?>>
                                                        TBC: Pulmonar
                                                    </option>
                                                    <option value="Extrapulmonar" <?php if ($pare['p_m_tbc'] == "Extrapulmonar") echo "selected"; ?>>
                                                        TBC: Extrapulmonar
                                                    </option>
                                                </optgroup>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="p_m_inf" id="p_m_inf" data-mini="true"
                                                   class="chekes" <?php if ($pare['p_m_inf'] <> "") echo "checked"; ?>>
                                            <label for="p_m_inf">Infecciones</label></td>
                                        <td colspan="3"><input name="p_m_inf1" type="text" id="p_m_inf1"
                                                               data-mini="true" placeholder="Especifique.." readonly
                                                               value="<?php echo $pare['p_m_inf']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="p_m_ale" id="p_m_ale" data-mini="true"
                                                   class="chekes" <?php if ($pare['p_m_ale'] <> "") echo "checked"; ?>>
                                            <label for="p_m_ale">Alergias</label></td>
                                        <td colspan="3"><input name="p_m_ale1" type="text" id="p_m_ale1"
                                                               data-mini="true" placeholder="Especifique.." readonly
                                                               value="<?php echo $pare['p_m_ale']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Cancer
                                            <textarea name="p_m_can" id="p_m_can"
                                                      data-mini="true"><?php echo $pare['p_m_can']; ?></textarea></td>
                                        <td colspan="2">Otros
                                            <textarea name="p_m_otr" id="p_m_otr"
                                                      data-mini="true"><?php echo $pare['p_m_otr']; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td><select name="select" class="med_insert" title="p_m_ets" data-mini="true">
                                                <option value="" selected="selected">ETS:</option>
                                                <option value="Borrar">--- Borrar Datos ---</option>
                                                <option value="Clamidiasis">ETS: Clamidiasis</option>
                                                <option value="Gonorrea">ETS: Gonorrea</option>
                                                <option value="Chancroide">ETS: Chancroide</option>
                                                <option value="Sífilis">ETS: Sífilis</option>
                                                <option value="Mycoplasma genitalium">ETS: Mycoplasma genitalium
                                                </option>
                                                <option value="VIH">ETS: VIH</option>
                                                <option value="Herpes virus">ETS: Herpes virus</option>
                                                <option value="Tricomoniasis">ETS: Tricomoniasis</option>
                                                <option value="Ladillas">ETS: Ladillas</option>
                                                <option value="VPH">ETS: VPH</option>
                                                <option value="Hepatitis C">ETS: Hepatitis C</option>
                                                <option value="Enfermedad pélvica inflamatoria">ETS: Enfermedad pélvica
                                                    inflamatoria
                                                </option>
                                                <option value="Verrugas genitales por papiloma humano">ETS: Verrugas
                                                    genitales por papiloma humano
                                                </option>
                                            </select></td>
                                        <td colspan="3"><textarea name="p_m_ets" readonly id="p_m_ets"
                                                                  data-mini="true"><?php echo $pare['p_m_ets']; ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div data-role="collapsible"><h3>Hábitos</h3>
                                <div class="scroll_h">
                                    <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                                        <tr>
                                            <td><select name="p_h_str" id="p_h_str" data-mini="true">
                                                    <option value="">Stress</option>
                                                    <option value="NO" <?php if ($pare['p_h_str'] == "NO") echo "selected"; ?>>
                                                        Stress: NO
                                                    </option>
                                                    <optgroup label="Stress: SI">
                                                        <option value="Bajo" <?php if ($pare['p_h_str'] == "Bajo") echo "selected"; ?>>
                                                            Stress: Bajo
                                                        </option>
                                                        <option value="Medio" <?php if ($pare['p_h_str'] == "Medio") echo "selected"; ?>>
                                                            Stress: Medio
                                                        </option>
                                                        <option value="Alto" <?php if ($pare['p_h_str'] == "Alto") echo "selected"; ?>>
                                                            Stress: Alto
                                                        </option>
                                                    </optgroup>
                                                </select></td>
                                            <td width="9%"><select name="p_h_dep" id="p_h_dep" data-mini="true">
                                                    <option value="">Deportes</option>
                                                    <option value="NO" <?php if ($pare['p_h_dep'] == "NO") echo "selected"; ?>>
                                                        Deportes: NO
                                                    </option>
                                                    <optgroup label="Deportes: SI">
                                                        <option value="Bajo" <?php if ($pare['p_h_dep'] == "Bajo") echo "selected"; ?>>
                                                            Deportes: Bajo
                                                        </option>
                                                        <option value="Medio" <?php if ($pare['p_h_dep'] == "Medio") echo "selected"; ?>>
                                                            Deportes: Medio
                                                        </option>
                                                        <option value="Alto" <?php if ($pare['p_h_dep'] == "Alto") echo "selected"; ?>>
                                                            Deportes: Alto
                                                        </option>
                                                    </optgroup>
                                                </select></td>
                                            <td width="8%"><select name="p_h_dro" id="p_h_dro" data-mini="true">
                                                    <option value="">Drogas</option>
                                                    <option value="NO" <?php if ($pare['p_h_dro'] == "NO") echo "selected"; ?>>
                                                        Drogas: NO
                                                    </option>
                                                    <optgroup label="Drogas: SI">
                                                        <option value="Bajo" <?php if ($pare['p_h_dro'] == "Bajo") echo "selected"; ?>>
                                                            Drogas: Bajo
                                                        </option>
                                                        <option value="Medio" <?php if ($pare['p_h_dro'] == "Medio") echo "selected"; ?>>
                                                            Drogas: Medio
                                                        </option>
                                                        <option value="Alto" <?php if ($pare['p_h_dro'] == "Alto") echo "selected"; ?>>
                                                            Drogas: Alto
                                                        </option>
                                                    </optgroup>
                                                </select></td>
                                            <td width="9%"><select name="p_h_tab" id="p_h_tab" data-mini="true">
                                                    <option value="">Tabaco</option>
                                                    <option value="NO" <?php if ($pare['p_h_tab'] == "NO") echo "selected"; ?>>
                                                        Tabaco: NO
                                                    </option>
                                                    <optgroup label="Tabaco: SI">
                                                        <option value="Bajo" <?php if ($pare['p_h_tab'] == "Bajo") echo "selected"; ?>>
                                                            Tabaco: Bajo
                                                        </option>
                                                        <option value="Medio" <?php if ($pare['p_h_tab'] == "Medio") echo "selected"; ?>>
                                                            Tabaco: Medio
                                                        </option>
                                                        <option value="Alto" <?php if ($pare['p_h_tab'] == "Alto") echo "selected"; ?>>
                                                            Tabaco: Alto
                                                        </option>
                                                    </optgroup>
                                                </select></td>
                                            <td><select name="p_h_alc" id="p_h_alc" data-mini="true">
                                                    <option value="">Alcohol</option>
                                                    <option value="NO" <?php if ($pare['p_h_alc'] == "NO") echo "selected"; ?>>
                                                        Alcohol: NO
                                                    </option>
                                                    <optgroup label="Alcohol: SI">
                                                        <option value="Bajo" <?php if ($pare['p_h_alc'] == "Bajo") echo "selected"; ?>>
                                                            Alcohol: Bajo
                                                        </option>
                                                        <option value="Medio" <?php if ($pare['p_h_alc'] == "Medio") echo "selected"; ?>>
                                                            Alcohol: Medio
                                                        </option>
                                                        <option value="Alto" <?php if ($pare['p_h_alc'] == "Alto") echo "selected"; ?>>
                                                            Alcohol: Alto
                                                        </option>
                                                    </optgroup>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td width="9%">Otro</td>
                                            <td colspan="4">
                                                <input name="p_h_otr" type="text" id="p_h_otr" data-mini="true"
                                                       value="<?php echo $pare['p_h_otr']; ?>">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div data-role="collapsible" id="p_Quiru"><h3>Quirúrgicos</h3>
                                <?php if ($login <> "xxx") { ?>
                                    <a href="e_ante_p_quiru.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id="; ?>"
                                       rel="external" class="ui-btn ui-btn-inline ui-mini"
                                       style="float:left">Agregar</a> <?php } ?>
                                <div class="scroll_h">

                                    <table width="85%" style="margin:0 auto;font-size:small;"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>
                                            <th width="11%" align="left">Fecha</th>
                                            <th width="31%" align="left">Procedimiento</th>
                                            <th width="13%" align="left">Médico</th>
                                            <th width="33%" align="left">Diagnóstico</th>
                                            <th width="11%" align="left">Lugar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($quiru = $Quiru->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td>
                                                    <a href="e_ante_p_quiru.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $quiru['id']; ?>"
                                                       rel="external"><?php echo date("d-m-Y", strtotime($quiru['fec'])); ?></a><?php if (file_exists("analisis/p_quiru_" . $quiru['id'] . ".pdf")) echo "<br><a href='analisis/p_quiru_" . $quiru['id'] . ".pdf' target='new'>Descargar</a>"; ?>
                                                </td>
                                                <td><?php echo $quiru['pro']; ?></td>
                                                <td><?php echo $quiru['med']; ?></td>
                                                <td><?php echo $quiru['dia']; ?></td>
                                                <td><?php echo $quiru['lug']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($Quiru->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                                </div>
                            </div>

                            <div data-role="collapsible" id="p_Examp"><h3>Exámenes previos</h3>

                                <p>
                                    <?php if ($login <> "xxx") { ?>
                                        <a href="e_ante_p_examp.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id="; ?>"
                                           rel="external" class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a> <?php } ?>
                                <div class="scroll_h">

                                    <table width="85%" style="margin:0 auto;font-size:small;"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>

                                            <th width="5%" align="left">Fecha</th>
                                            <th width="5%" align="left">Tipo</th>
                                            <th width="90%" align="left">Conclusión</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($examp = $Examp->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td height="23"><a
                                                            href="e_ante_p_examp.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $examp['id']; ?>"
                                                            rel="external"><?php echo date("d-m-Y", strtotime($examp['fec'])); ?></a><?php if (file_exists("analisis/p_examp_" . $examp['id'] . ".pdf")) echo "<br><a href='analisis/p_examp_" . $examp['id'] . ".pdf' target='new'>Descargar</a>"; ?>
                                                </td>
                                                <td><?php echo $examp['tip']; ?></td>
                                                <td><?php echo $examp['con']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($Examp->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                                </div>
                                </p>

                            </div>

                            <div data-role="collapsible" id="p_Sero">
                                <h3>Resultados de Análisis Clínicos</h3>


                                <a href="e_ante_p_sero.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id="; ?>"
                                   rel="external" class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>

                                <table width="100%" style="margin:0 auto;font-size:small;text-align:center;"
                                       class="ui-responsive table-stroke">
                                    <thead>
                                    <tr>
                                        <th width="12%">Fecha</th>
                                        <th width="14%">Hepatitis B<br>
                                            HBs Ag
                                        </th>
                                        <th width="14%">Hepatitis C <br>
                                            HCV Ac
                                        </th>
                                        <th width="14%">HIV</th>
                                        <th width="14%">RPR</th>
                                        <th width="14%">Toxoplasma <br>
                                            IgG
                                        </th>
                                        <th width="14%">Clamidia<br>
                                            IgG
                                        </th>
                                        <th width="14%">clamidia
                                            <br>
                                            IgM
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($sero = $Sero->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td valign="top"><?php if ($sero['lab'] <> "") echo date("d-m-Y", strtotime($sero['fec'])) . ' (' . $sero['lab'] . ')'; else { ?>
                                                    <a
                                                    href="e_ante_p_sero.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $sero['fec']; ?>"
                                                    rel="external"><?php echo date("d-m-Y", strtotime($sero['fec'])); ?></a><?php } ?>
                                                <?php if (file_exists("analisis/sero_" . $p_dni . "_" . $sero['fec'] . ".pdf")) echo "<br><a href='analisis/sero_" . $p_dni . "_" . $sero['fec'] . ".pdf' target='new'>Descargar</a>"; ?>
                                            </td>
                                            <td valign="top" <?php if ($sero['hbs'] == 1) echo 'class="color"'; ?>><?php if ($sero['hbs'] == 1) echo "Positivo";
                                                if ($sero['hbs'] == 2) echo "Negativo";
                                                if ($sero['hbs'] == 3) echo "En proceso";
                                                if ($sero['hbs'] == 4) echo "Indeterminado";
                                                if ($sero['hbs'] == 0) echo "No Realizado"; ?></td>
                                            <td valign="top" <?php if ($sero['hcv'] == 1) echo 'class="color"'; ?>><?php if ($sero['hcv'] == 1) echo "Positivo";
                                                if ($sero['hcv'] == 2) echo "Negativo";
                                                if ($sero['hcv'] == 3) echo "En proceso";
                                                if ($sero['hcv'] == 4) echo "Indeterminado";
                                                if ($sero['hcv'] == 0) echo "No Realizado"; ?></td>
                                            <td valign="top" <?php if ($sero['hiv'] == 1) echo 'class="color"'; ?>><?php if ($sero['hiv'] == 1) echo "Positivo";
                                                if ($sero['hiv'] == 2) echo "Negativo";
                                                if ($sero['hiv'] == 3) echo "En proceso";
                                                if ($sero['hiv'] == 4) echo "Indeterminado";
                                                if ($sero['hiv'] == 0) echo "No Realizado"; ?></td>
                                            <td valign="top" <?php if ($sero['rpr'] == 1) echo 'class="color"'; ?>><?php if ($sero['rpr'] == 1) echo "Positivo";
                                                if ($sero['rpr'] == 2) echo "Negativo";
                                                if ($sero['rpr'] == 3) echo "En proceso";
                                                if ($sero['rpr'] == 4) echo "Indeterminado";
                                                if ($sero['rpr'] == 0) echo "No Realizado"; ?></td>
                                            <td valign="top" <?php if ($sero['tox'] == 1) echo 'class="color"'; ?>><?php if ($sero['tox'] == 1) echo "Positivo";
                                                if ($sero['tox'] == 2) echo "Negativo";
                                                if ($sero['tox'] == 3) echo "En proceso";
                                                if ($sero['tox'] == 4) echo "Indeterminado";
                                                if ($sero['tox'] == 0) echo "No Realizado"; ?></td>
                                            <td valign="top" <?php if ($sero['cla_g'] == 1) echo 'class="color"'; ?>><?php if ($sero['cla_g'] == 1) echo "Positivo";
                                                if ($sero['cla_g'] == 2) echo "Negativo";
                                                if ($sero['cla_g'] == 3) echo "En proceso";
                                                if ($sero['cla_g'] == 4) echo "Indeterminado";
                                                if ($sero['cla_g'] == 0) echo "No Realizado"; ?></td>
                                            <td valign="top" <?php if ($sero['cla_m'] == 1) echo 'class="color"'; ?>><?php if ($sero['cla_m'] == 1) echo "Positivo";
                                                if ($sero['cla_m'] == 2) echo "Negativo";
                                                if ($sero['cla_m'] == 3) echo "En proceso";
                                                if ($sero['cla_m'] == 4) echo "Indeterminado";
                                                if ($sero['cla_m'] == 0) echo "No Realizado"; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($Sero->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>
                                <hr>
                                <?php if ($rAnal->rowCount() > 0) { ?>
                                    <table style="font-size:small;" data-role="table"
                                           class="ui-responsive table-stroke">
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
                                                <td><?php echo $anal['a_exa']; ?></td>
                                                <td><?php echo $anal['a_sta']; ?></td>
                                                <td><?php echo $anal['a_obs']; ?></td>
                                                <td>
                                                    <a href='<?php echo "analisis/" . $anal['id'] . "_" . $anal['a_dni'] . ".pdf"; ?>'
                                                       target="new">Ver/Descargar</a></td>
                                                <td><?php echo date("d-m-Y", strtotime($anal['a_fec'])); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                            <div data-role="collapsible" id="Legal"><h3>Legal <span id="ultimo"></span></h3>
                                <?php if ($rLegal->rowCount() > 0) { ?>
                                    <table style="font-size:small;" data-role="table"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>
                                            <th>TIPO</th>
                                            <th>OBSERVACION</th>
                                            <th>INFORME</th>
                                            <th>FECHA</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($legal = $rLegal->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <th><?php echo $legal['a_exa']; ?></th>
                                                <td><?php echo $legal['a_obs']; ?></td>
                                                <td><?php $a_sta='';
                                                    if ($legal['a_sta']==1) $a_sta=' (APTO)';
                                                    if ($legal['a_sta']==2) $a_sta=' (OBSERVADO)';
                                                    if ($legal['a_sta']==3) $a_sta=' (NO APTO)'; ?>
                                                    <a href='<?php echo "legal/".$legal['id']."_".$legal['a_dni'].".pdf";?>' target="new">Ver/Descargar</a>
                                                    <?php echo $a_sta; ?>
                                                </td>
                                                <td><?php echo date("d-m-Y", strtotime($legal['a_fec'])); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        $(function(){
                                            $("#ultimo").html("<?php echo $a_sta; ?>");
                                        });</script>
                                <?php } else echo "<h5>No hay Documentos</h5>"; ?>
                            </div>
                            <div class="ui-field-contain">
                                        <label for="p_obs">Observaciones:</label>
                                        <textarea name="p_obs" id="p_obs"><?php echo $pare['p_obs']; ?></textarea>
                                    
                            </div>

                        </div> <!-- close collapse 1 -->
                        <div class="enlinea">
                            <input type="Submit" name="guardar" value="GUARDAR DATOS" data-icon="check" data-iconpos="left"
                                   data-mini="true" class="show-page-loading-msg" data-textonly="false" data-textvisible="true"
                                   data-msgtext="Actualizando datos.." data-theme="b" data-inline="true"/>

                            <?php if ($pp['p_het'] >= 1) { ?>
                                <label for="apto">APTO</label>
                                <input type="checkbox" name="p_het" id="apto" value=1 <?php if ($pp['p_het'] == 1) echo "checked"; //el name="p_het" para que chanque el valor de apto  ?>>
                            <?php } ?>
                        </div>

                    </div> <!-- close TAB 1 -->
                    <div id="two">

                        <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">
                            <div data-role="collapsible" id="p_Esp"><h3>Espermatograma</h3>
                                <?php if ($login == "lab") { ?>
                                    <input type="Submit" name="p_Esp" value="Solicitar" data-icon="check"
                                           data-iconpos="left" data-mini="true" data-inline="true" style="float:left"/>
                                <?php } ?>

                                <table width="85%" style="margin:0 auto;font-size:small;"
                                       class="ui-responsive table-stroke">
                                    <thead>
                                    <tr>
                                        <th width="8%" align="left">Vol.</th>
                                        <th width="20%" align="left">Con.</th>
                                        <th width="23%" align="left">Viabi.</th>
                                        <th width="13%" align="left">Ph</th>
                                        <th width="13%" align="left">Morfo.</th>
                                        <th width="10%" align="left">Moti.</th>
                                        <th width="13%" align="left">Fecha</th>
                                        <th width="13%" align="left">Ver/Imprimir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($esp = $Esp->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?php if ($esp['emb'] > 0) echo $esp['vol_f'] . 'ml'; ?></td>
                                            <td><?php if ($esp['emb'] > 0) {
                                                    echo $esp['con_f'];
                                                    if ($esp['esp'] == 1) echo " Spz/Camp"; else echo " x10<sup>6";
                                                } ?></td>
                                            <td><?php if ($esp['emb'] > 0) echo $esp['via'] . '%'; ?></td>
                                            <td><?php if ($esp['emb'] > 0) echo $esp['ph']; ?></td>
                                            <td><?php if ($esp['emb'] > 0 and ($esp['m_a'] + $esp['m_n']) > 0) echo round(100 - (($esp['m_a'] * 100) / ($esp['m_a'] + $esp['m_n'])), 2) . '%'; // % normal = pm_n ?></td>
                                            <td><?php if ($esp['emb'] > 0) echo ($esp['pl_f'] + $esp['pnl_f']) . '%'; ?></td>
                                            <td>
                                                <a href="le_andro_esp.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $esp['fec']; ?>"
                                                   rel="external"><?php echo date("d-m-Y", strtotime($esp['fec'])); ?></a>
                                            </td>
                                            <td><?php if ($esp['emb'] > 0) { ?><a
                                                    href="info.php?T=esp&a=<?php echo $p_dni . "&b=" . $esp['fec'] . "&c=" . $dni; ?>"
                                                    target="new">Informe</a>/<a
                                                        href="info_s.php?T=esp&a=<?php echo $p_dni . "&b=" . $esp['fec'] . "&c=" . $dni; ?>"
                                                        target="new">Sobre</a><?php } else {
                                                    echo '<b class="color">PENDIENTE</b>';
                                                    if ($login == "lab") echo '<a href="javascript:anular(\'' . $p_dni . '\',\'' . $esp['fec'] . '\',\'esp\');"> (Cancelar)</a>';
                                                } ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($Esp->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                            </div>

                            <?php if ($pp['p_het'] === 0 ) { // ------- Oculta estos Test para donantes ----------------------------------------------------- ?>

                                <div data-role="collapsible" id="p_Cap"><h3>Capacitación espermática</h3>

                                    <?php if ($login == "lab") { ?>
                                        <input type="Submit" name="p_Cap" value="Solicitar" data-icon="check"
                                               data-iconpos="left" data-mini="true" data-inline="true"
                                               style="float:left"/>
                                    <?php } ?>

                                    <table width="85%" style="margin:0 auto;font-size:small;"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>
                                            <th colspan="3" align="center">Fresco</th>
                                            <th colspan="2" align="center">Capacitación</th>
                                            <th align="left">&nbsp;</th>
                                            <th align="left">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <th width="15%" align="left">Vol.</th>
                                            <th width="15%" align="left">Con.</th>
                                            <th width="15%" align="left">Moti.</th>
                                            <th width="8%" align="left">Con.</th>
                                            <th width="21%" align="left">Spz/Ins</th>
                                            <th width="13%" align="left">Fecha</th>
                                            <th width="13%" align="left">Ver/Imprimir</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($cap = $Cap->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php if ($cap['emb'] > 0) echo $cap['vol_f'] . 'ml'; ?></td>
                                                <td><?php if ($cap['emb'] > 0) echo $cap['con_f'] . 'x10<sup>6'; ?></td>
                                                <td><?php if ($cap['emb'] > 0) echo ($cap['pl_f'] + $cap['pnl_f']) . '%'; ?></td>
                                                <td><?php if ($cap['emb'] > 0) echo $cap['con_c'] . 'x10<sup>6'; ?></td>
                                                <td><?php if ($cap['emb'] > 0) echo round(($cap['con_c'] * 0.3), 2); ?></td>
                                                <td>
                                                    <a href="le_andro_cap.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $cap['id']; ?>"
                                                       rel="external"><?php echo date("d-m-Y", strtotime($cap['fec']));
                                                        if ($cap['mue'] == 2 or $cap['mue'] == 4) echo " (Heterólogo)"; ?></a>
                                                </td>
                                                <td><?php if ($cap['emb'] > 0) { ?>
                                                        <a href="info.php?T=cap&a=<?php echo $p_dni . "&b=" . $cap['id'] . "&c=" . $dni; ?>"
                                                           target="new">Informe</a>/<a
                                                                href="info_s.php?T=cap&a=<?php echo $p_dni . "&b=" . $cap['id'] . "&c=" . $dni; ?>"
                                                                target="new">Sobre</a>
                                                    <?php } else {
                                                        echo '<b class="color">PENDIENTE</b>';
                                                        if ($login == "lab") echo '<a href="javascript:anular(\'' . $cap['id'] . '\',\'\',\'cap\');"> (Cancelar)</a>';
                                                    } ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($Cap->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                                </div>

                                <div data-role="collapsible" id="p_Tes_cap"><h3>Test de capacitación</h3>

                                    <?php if ($login == "lab") { ?>
                                        <input type="Submit" name="p_Tes_cap" value="Solicitar" data-icon="check"
                                               data-iconpos="left" data-mini="true" data-inline="true"
                                               style="float:left"/>
                                    <?php } ?>

                                    <table width="85%" style="margin:0 auto;font-size:small;"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>
                                            <th colspan="3" align="center">Fresco</th>
                                            <th colspan="2" align="center">Capacitación</th>
                                            <th align="left">&nbsp;</th>
                                            <th align="left">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <th width="12%" align="left">Vol.</th>
                                            <th width="17%" align="left">Con.</th>
                                            <th width="14%" align="left">Moti.</th>
                                            <th width="12%" align="left">Con.</th>
                                            <th width="20%" align="left">Spz/Ins</th>
                                            <th width="11%" align="left">Fecha</th>
                                            <th width="14%" align="left">Ver/Imprimir</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($tes_cap = $Tes_cap->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php if ($tes_cap['emb'] > 0) echo $tes_cap['vol_f'] . 'ml'; ?></td>
                                                <td><?php if ($tes_cap['emb'] > 0) echo $tes_cap['con_f'] . 'x10<sup>6'; ?></td>
                                                <td><?php if ($tes_cap['emb'] > 0) echo ($tes_cap['pl_f'] + $tes_cap['pnl_f']) . '%'; ?></td>
                                                <td><?php if ($tes_cap['emb'] > 0) echo $tes_cap['con_c'] . 'x10<sup>6'; ?></td>
                                                <td><?php if ($tes_cap['emb'] > 0) echo round(($tes_cap['con_c'] * 0.3), 2); ?></td>
                                                <td>
                                                    <a href="le_andro_tes_cap.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $tes_cap['fec']; ?>"
                                                       rel="external"><?php echo date("d-m-Y", strtotime($tes_cap['fec'])); ?></a>
                                                </td>
                                                <td><?php if ($tes_cap['emb'] > 0) { ?>
                                                        <a href="info.php?T=tes_cap&a=<?php echo $p_dni . "&b=" . $tes_cap['fec'] . "&c=" . $dni; ?>"
                                                           target="new">Informe</a>/<a
                                                                href="info_s.php?T=tes_cap&a=<?php echo $p_dni . "&b=" . $tes_cap['fec'] . "&c=" . $dni; ?>"
                                                                target="new">Sobre</a>
                                                    <?php } else {
                                                        echo '<b class="color">PENDIENTE</b>';
                                                        if ($login == "lab") echo '<a href="javascript:anular(\'' . $p_dni . '\',\'' . $tes_cap['fec'] . '\',\'tes_cap\');"> (Cancelar)</a>';
                                                    } ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($Tes_cap->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                                </div>

                                <div data-role="collapsible" id="p_Tes_sob"><h3>Test de sobrevivencia espermática</h3>
                                    <?php if ($login == "lab") { ?>
                                        <input type="Submit" name="p_Tes_sob" value="Solicitar" data-icon="check"
                                               data-iconpos="left" data-mini="true" data-inline="true"
                                               style="float:left"/>
                                    <?php } ?>

                                    <table width="85%" style="margin:0 auto;font-size:small;"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>
                                            <th colspan="3" align="center">Fresco</th>
                                            <th colspan="2" align="center">Post 24 horas</th>
                                            <th align="left">&nbsp;</th>
                                            <th align="left">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <th width="11%" align="left">Vol.</th>
                                            <th width="18%" align="left">Con.</th>
                                            <th width="13%" align="left">Moti.</th>
                                            <th width="10%" align="left">Con.</th>
                                            <th width="23%" align="left">Moti.</th>
                                            <th width="11%" align="left">Fecha</th>
                                            <th width="14%" align="left">Ver/Imprimir</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($tes_sob = $Tes_sob->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php if ($tes_sob['emb'] > 0) echo $tes_sob['vol_f'] . 'ml'; ?></td>
                                                <td><?php if ($tes_sob['emb'] > 0) echo $tes_sob['con_f'] . 'x10<sup>6'; ?></td>
                                                <td><?php if ($tes_sob['emb'] > 0) echo ($tes_sob['pl_f'] + $tes_sob['pnl_f']) . '%'; ?></td>
                                                <td><?php if ($tes_sob['emb'] > 0) echo $tes_sob['con_c'] . 'x10<sup>6'; ?></td>
                                                <td><?php if ($tes_sob['emb'] > 0) echo ($tes_sob['pl_c'] + $tes_sob['pnl_c']) . '%'; ?></td>
                                                <td>
                                                    <a href="le_andro_tes_sob.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $tes_sob['fec']; ?>"
                                                       rel="external"><?php echo date("d-m-Y", strtotime($tes_sob['fec'])); ?></a>
                                                </td>
                                                <td><?php if ($tes_sob['emb'] > 0) { ?>
                                                        <a href="info.php?T=tes_sob&a=<?php echo $p_dni . "&b=" . $tes_sob['fec'] . "&c=" . $dni; ?>"
                                                           target="new">Informe</a>/<a
                                                                href="info_s.php?T=tes_sob&a=<?php echo $p_dni . "&b=" . $tes_sob['fec'] . "&c=" . $dni; ?>"
                                                                target="new">Sobre</a>
                                                    <?php } else {
                                                        echo '<b class="color">PENDIENTE</b>';
                                                        if ($login == "lab") echo '<a href="javascript:anular(\'' . $p_dni . '\',\'' . $tes_sob['fec'] . '\',\'tes_sob\');"> (Cancelar)</a>';
                                                    } ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($Tes_sob->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                                </div>

                                <div data-role="collapsible" id="p_Bio_tes"><h3>Biopsia Testicular</h3>
                                    <?php if ($login == "lab") { ?>
                                        <input type="Submit" name="p_Bio_tes" value="Solicitar" data-icon="check"
                                               data-iconpos="left" data-mini="true" data-inline="true"
                                               style="float:left"/>
                                    <?php } ?>

                                    <table width="85%" style="margin:0 auto;font-size:small;"
                                           class="ui-responsive table-stroke">
                                        <thead>
                                        <tr>
                                            <th width="14%" align="left">Con.</th>
                                            <th width="7%" align="left">PL</th>
                                            <th width="7%" align="left">PNL</th>
                                            <th width="7%" align="left">IN</th>
                                            <th width="7%" align="left">NM</th>
                                            <th width="6%" align="left">Crio.</th>
                                            <th width="7%" align="left">Vol. Vial</th>
                                            <th width="20%" align="left"># Vial</th>
                                            <th width="11%" align="left">Fecha</th>
                                            <th width="14%" align="left">Ver/Imprimir</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($bio_tes = $Bio_tes->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php if ($bio_tes['emb'] > 0) {
                                                        echo $bio_tes['con_f'];
                                                        if ($bio_tes['esp'] == 1) echo " Spz/Camp"; else echo " x10<sup>6";
                                                    } ?></td>
                                                <td><?php if ($bio_tes['emb'] > 0) echo $bio_tes['pl_f'] . '%'; ?></td>
                                                <td><?php if ($bio_tes['emb'] > 0) echo $bio_tes['pnl_f'] . '%'; ?></td>
                                                <td><?php if ($bio_tes['emb'] > 0) echo $bio_tes['ins_f'] . '%'; ?></td>
                                                <td><?php if ($bio_tes['emb'] > 0) echo $bio_tes['inm_f'] . '%'; ?></td>
                                                <td><?php if ($bio_tes['emb'] > 0) {
                                                        if ($bio_tes['crio'] == 1) echo 'Si'; else echo 'No';
                                                    } ?></td>
                                                <td><?php if ($bio_tes['crio'] == 1 and $bio_tes['via'] > 0) echo round(($bio_tes['vol'] / $bio_tes['via']), 2); ?></td>
                                                <td><?php if ($bio_tes['emb'] > 0) echo $bio_tes['via']; ?></td>
                                                <td>
                                                    <a href="le_andro_bio_tes.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $bio_tes['fec']; ?>"
                                                       rel="external"><?php echo date("d-m-Y", strtotime($bio_tes['fec'])); ?></a>
                                                </td>
                                                <td><?php if ($bio_tes['emb'] > 0) { ?>
                                                        <a href="info.php?T=bio_tes&a=<?php echo $p_dni . "&b=" . $bio_tes['fec'] . "&c=" . $dni; ?>"
                                                           target="new">Informe</a>/<a
                                                                href="info_s.php?T=bio_tes&a=<?php echo $p_dni . "&b=" . $bio_tes['fec'] . "&c=" . $dni; ?>"
                                                                target="new">Sobre</a>
                                                    <?php } else {
                                                        echo '<b class="color">PENDIENTE</b>';
                                                        if ($login == "lab") echo '<a href="javascript:anular(\'' . $p_dni . '\',\'' . $bio_tes['fec'] . '\',\'bio_tes\');"> (Cancelar)</a>';
                                                    } ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($Bio_tes->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                                </div>
                            <?php } // ------- Oculta estos Test para donantes ----------------------------------------------------- ?>

                            <div data-role="collapsible" id="p_Crio_sem"><h3>Criopreservación Semen</h3>
                                <?php if ($login == "lab") { ?>
                                    <input type="Submit" name="p_Crio_sem" value="Solicitar" data-icon="check"
                                           data-iconpos="left" data-mini="true" data-inline="true" style="float:left"/>
                                <?php } ?>

                                <table width="85%" style="margin:0 auto;font-size:small;"
                                       class="ui-responsive table-stroke">
                                    <thead>
                                    <tr>
                                        <th colspan="3" align="center">Fresco</th>
                                        <th colspan="3" align="center">Capacitación</th>
                                        <th colspan="2" align="center">Criopreservación</th>
                                        <th align="center">&nbsp;</th>
                                        <th align="center">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th width="6%" align="left">Vol.</th>
                                        <th width="4%" align="left">Con.</th>
                                        <th width="6%" align="left">Moti</th>
                                        <th width="7%" align="left">Tipo</th>
                                        <th width="10%" align="left">Con.</th>
                                        <th width="7%" align="left">Moti.</th>
                                        <th width="9%" align="left">Vol. Vial</th>
                                        <th width="27%" align="left"># Vial</th>
                                        <th width="10%" align="left">Fecha</th>
                                        <th width="14%" align="left">Ver/Imprimir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($crio_sem = $Crio_sem->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?php if ($crio_sem['emb'] > 0) echo $crio_sem['vol_f'] . 'ml'; ?></td>
                                            <td><?php if ($crio_sem['emb'] > 0) echo $crio_sem['con_f'] . 'x10<sup>6'; ?></td>
                                            <td><?php if ($crio_sem['emb'] > 0) echo ($crio_sem['pl_f'] + $crio_sem['pnl_f']) . '%'; ?></td>
                                            <td><?php if ($crio_sem['cap'] == "") echo '-';
                                                if ($crio_sem['cap'] == 1) echo 'Gradiente densidad';
                                                if ($crio_sem['cap'] == 2) echo 'Lavado';
                                                if ($crio_sem['cap'] == 3) echo 'Swim up'; ?></td>
                                            <td><?php if ($crio_sem['emb'] > 0) echo $crio_sem['con_c'] . 'x10<sup>6'; ?></td>
                                            <td><?php if ($crio_sem['emb'] > 0) echo ($crio_sem['pl_c'] + $crio_sem['pnl_c']) . '%'; ?></td>
                                            <td><?php if ($crio_sem['emb'] > 0 and $crio_sem['via'] > 0) echo round(($crio_sem['vol'] / $crio_sem['via']), 2); ?></td>
                                            <td><?php if ($crio_sem['emb'] > 0) echo $crio_sem['via']; ?></td>
                                            <td>
                                                <a href="le_andro_crio_sem.php?dni=<?php echo $dni . "&ip=" . $p_dni . "&id=" . $crio_sem['fec']; ?>"
                                                   rel="external"><?php echo date("d-m-Y", strtotime($crio_sem['fec'])); ?></a>
                                            </td>
                                            <td><?php if ($crio_sem['emb'] > 0) { ?>
                                                    <a href="info.php?T=crio_sem&a=<?php echo $p_dni . "&b=" . $crio_sem['fec'] . "&c=" . $dni; ?>"
                                                       target="new">Informe</a>/<a
                                                            href="info_s.php?T=crio_sem&a=<?php echo $p_dni . "&b=" . $crio_sem['fec'] . "&c=" . $dni; ?>"
                                                            target="new">Sobre</a>
                                                <?php } else {
                                                    echo '<b class="color">PENDIENTE</b>';
                                                    if ($login == "lab") echo '<a href="javascript:anular(\'' . $p_dni . '\',\'' . $crio_sem['fec'] . '\',\'crio_sem\');"> (Cancelar)</a>';
                                                } ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($Crio_sem->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                            </div>
                        </div> <!-- close collapse 2 -->
                        <?php if ($Crio_sem->rowCount() > 0 or $Bio_tes->rowCount() > 0) {

                            $rCon = $db->prepare("SELECT tip FROM lab_tanque_res WHERE sta=?");
                            $rCon->execute(array($p_dni));
                            if ($rCon->rowCount() > 0) {
                                $c_bio = 0;
                                $c_cri = 0;
                                while ($con = $rCon->fetch(PDO::FETCH_ASSOC)) {
                                    if ($con['tip'] == 1) $c_bio++;
                                    if ($con['tip'] == 2) $c_cri++;
                                }
                                echo "<p>Congelados Biopsia: " . $c_bio . "<br>Congelados Criopreservación: " . $c_cri . "</p>";
                            }

                            $rDes = $db->prepare("SELECT des,des_tip,id,pro FROM lab_andro_cap WHERE des_dni=? and des<>'' ORDER BY des_tip");
                            $rDes->execute(array($p_dni));
                            if ($rDes->rowCount() > 0) {
                                while ($des = $rDes->fetch(PDO::FETCH_ASSOC)) {
                                    $n_des = explode('|', $des['des']);
                                    $total = count($n_des) - 1;
                                    if ($des['des_tip'] == 1) $des_tip = "Descongelado Biopsia: ";
                                    if ($des['des_tip'] == 2) $des_tip = "Descongelado Criopreservación: ";
                                    if ($des['pro'] <> "" and $des['pro'] <> 0) $des_pro = " (Protocolo " . $des['pro'] . ")";
                                    echo $des_tip . $total . $des_pro . "<br>";
                                }
                            }

                        } ?>

                    </div> <!-- close TAB 2 -->
                    <div id="tre"> <!-- close TAB 3 -->
                        <?php if ($user['role'] == 7) { ?>
                        <a href="e_urolo.php?dni=<?php echo $dni."&ip=".$p_dni."&id="; ?>"
                           rel="external" class="ui-btn ui-btn-inline ui-mini">Agregar Consulta</a>
                        <?php } ?>
                        <ol data-role="listview" data-theme="a" data-split-icon="delete" data-inset="true">
                            <?php while ($uro = $rUro->fetch(PDO::FETCH_ASSOC)) { ?>
                                <li>
                                    <a href="e_urolo.php?dni=<?php echo $dni."&ip=".$p_dni."&id=".$uro["id"]; ?>" rel="external">
                                        <small><?php echo $uro['mot']; ?></small>

                                        <span class="ui-li-count"><?php echo date("d-m-Y", strtotime($uro['fec'])); ?></span>
                                    </a>
                                    <a href="javascript:borrar(<?php echo $uro["id"]; ?>);">Eliminar</a>
                                </li>

                            <?php } ?>
                        </ol>
                        <?php  if ($rUro->rowCount() < 1) echo '<p><h3>¡ Aun no hay consultas !</h3></p>'; ?>
                    </div>

                </div>
                <!--end TABS ------------------------------------------------------------------------------------- -->


            </form>

        </div><!-- /content -->


    <?php } ?>
</div><!-- /page -->


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

        if ($('#p_m_inf').prop('checked')) {

            if (document.getElementById("p_m_inf1").value == "") {
                alert("Debe especificar la Infección");
                return false;
            }
        }

        if ($('#p_m_ale').prop('checked')) {

            if (document.getElementById("p_m_ale1").value == "") {
                alert("Debe especificar la alergia");
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
        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>


</script>
</body>
</html>
