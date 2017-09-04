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
        .color {
            color: #F4062B;
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

        /* Hide the number input */
        .ui-slider input[type=number] {
            display: none;
        }

        .ui-slider-track {
            margin-left: 0px;
        }

        .peke .ui-input-text {
            width: 70% !important

        }

        .peke2 .ui-input-text {
            width: 30px !important;
        }

        .peke2 span {
            float: left;
        }

        #ultimo {
            color: #9f2b1e;
        }

        .ui-tabs-panel {
            background-color: #FFF;
            padding: 5px;
        }

        .controlgroup-textinput {
                padding-top: .22em;
                padding-bottom: .22em;
        }
    </style>
    <script>
        //if (typeof history.pushState != 'undefined') history.pushState("", document.title, window.location.search); //---- restore original url when refresh --------------------------

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

            $("#depa").change(function () {

                $("#depa option:selected").each(function () {
                    var depa = $(this).val();
                    //$(".varillas").remove();
                    $.post("le_tanque.php", {depa: depa}, function (data) {
                        $("#prov").html(data);
                        $("#prov").selectmenu("refresh");
                    });
                });
            });

            $("#prov").change(function () {

                $("#prov option:selected").each(function () {
                    var prov = $(this).val();
                    //$(".varillas").remove();
                    $.post("le_tanque.php", {prov: prov}, function (data) {
                        $("#dist").html(data);
                        $("#dist").selectmenu("refresh");
                    });
                });
            });
        });

    </script>

    <?php if ($_GET['pop'] <> "") { ?>
        <script>
            $(document).ready(function () {

                var x = "<?php echo $_GET['pop']; ?>";
                $("#" + x).collapsible({collapsed: false});

            });
        </script>
    <?php } ?>

</head>

<body>
<?php
if (isSet($_POST['dni']) and $_POST['boton_datos'] = 'GUARDAR DATOS') {

    updatePaci($_POST['dni'], $_POST['tip'], $_POST['nom'], $_POST['ape'], $_POST['fnac'], $_POST['tcel'], $_POST['tcas'], $_POST['tofi'], $_POST['mai'], $_POST['dir'], $_POST['nac'], $_POST['depa'], $_POST['prov'], $_POST['dist'], $_POST['prof'], $_POST['san'], $_POST['don'], $_POST['raz'], $_POST['peso'], $_POST['talla'], $_FILES['foto'], $_POST['rem'], $_POST['sta']);

    updatePaciAnte($_POST['dni'], $_POST['f_dia'], $_POST['f_hip'], $_POST['f_gem'], $_POST['f_hta'], $_POST['f_tbc'], $_POST['f_can'], $_POST['f_otr'], $_POST['m_dia'], $_POST['m_hip'], $_POST['m_inf1'], $_POST['m_ale'], $_POST['m_ale1'], $_POST['m_tbc'], $_POST['m_ets'], $_POST['m_can'], $_POST['m_otr'], $_POST['h_str'], $_POST['h_dep'], $_POST['h_dro'], $_POST['h_tab'], $_POST['h_alc'], $_POST['h_otr'], $_POST['g_men'], $_POST['g_per'], $_POST['g_dur'], $_POST['g_vol'], $_POST['g_fur'], $_POST['g_ant'], $_POST['g_pap'], $_POST['g_pap1'], $_POST['g_pap2'], $_POST['g_dis'], $_POST['g_ges'], $_POST['g_abo'], $_POST['g_abo1'], $_POST['g_abo_ges'], $_POST['g_abo_com'], $_POST['g_pt'], $_POST['g_pp'], $_POST['g_vag'], $_POST['g_ces'], $_POST['g_nv'], $_POST['g_nm'], $_POST['g_neo'], $_POST['g_viv'], $_POST['g_fup'], $_POST['g_rn_men'], $_POST['g_rn_mul'], $_POST['g_rn_may'], $_POST['g_agh'], $_POST['g_his'], $_POST['g_obs'], $_POST['fe_exa']);

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

$rPaci = $db->prepare("SELECT * FROM hc_antece,hc_paciente WHERE hc_paciente.dni=? AND hc_antece.dni=?");
$rPaci->execute(array($id, $id));
$paci = $rPaci->fetch(PDO::FETCH_ASSOC);

$a_pap = $db->prepare("SELECT * FROM hc_antece_pap WHERE dni=? ORDER BY fec DESC");
$a_pap->execute(array($id));

$a_quiru = $db->prepare("SELECT * FROM hc_antece_quiru WHERE dni=? ORDER BY fec DESC");
$a_quiru->execute(array($id));

$a_hsghes = $db->prepare("SELECT * FROM hc_antece_hsghes WHERE dni=? ORDER BY fec DESC");
$a_hsghes->execute(array($id));

$a_perfi = $db->prepare("SELECT * FROM hc_antece_perfi WHERE dni=? ORDER BY fec DESC");
$a_perfi->execute(array($id));

$Sero = $db->prepare("SELECT * FROM hc_antece_p_sero WHERE p_dni=? ORDER BY fec DESC");
$Sero->execute(array($id));

$a_cirug = $db->prepare("SELECT * FROM hc_antece_cirug WHERE dni=? ORDER BY fec DESC");
$a_cirug->execute(array($id));

$a_trata = $db->prepare("SELECT * FROM hc_antece_trata WHERE dni=? ORDER BY fec DESC");
$a_trata->execute(array($id));

$rAnal = $db->prepare("SELECT * FROM hc_analisis WHERE a_dni=? AND lab<>'legal' AND lab<>'eco' ORDER BY a_fec DESC");
$rAnal->execute(array($id));

$rPago = $db->prepare("SELECT id,tip FROM recibos WHERE dni=? AND anglo LIKE '%Correcto%'");
$rPago->execute(array($id));
if ($rPago->rowCount() > 0) {
    include('nusoap/lib/nusoap.php');
    $client = new nusoap_client('http://www.anglolab.com:287/Service.svc?wsdl', 'wsdl');
    $client->soap_defencoding = 'UTF-8';
    $err = $client->getError();
    if ($err) {
        echo '<h4>Error conexion anglolab:</h4><pre>' . $err . '</pre>';
    }
    while ($pago = $rPago->fetch(PDO::FETCH_ASSOC)) {
        $param = array('dato' => $pago['id'] . '-' . $pago['tip']);

        $result = $client->call('Consulta_Resultado_Laboratorio_Inmater', $param);
// Check for a fault
        if ($client->fault) {
            echo '<h4>FALLO 1 anglolab:</h4><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            // Check for errors
            $err = $client->getError();
            if ($err) {
                // Display the error
                echo '<h2>FALLO 2 anglolab:</h2><pre>' . $err . '</pre>';
            } else { // Display the result
                $tablas = $result['Consulta_Resultado_Laboratorio_InmaterResult']['diffgram']['NewDataSet']['Table'];
                foreach ($tablas as $k => $v) {
                    //echo $v['ORDENCLIENTE']."-".$k;
                    try {

                        $stmt = $db->prepare("INSERT INTO lab_anglo (id,ORDENCLIENTE,ID_Sucursal,Orden,IDExterno,ProfesionalNombre,ID_Ninterno,Paciente,ID_TipDoc,NumDoc,FecNac,Sexo,Ubicacion,Edad,Orden1,VariableDescripcion,Resultado,Unidad,RangoMinimo,RangoMaximo,Rango,ID_Estudio,TipoTiempo,CantidadTiempo,VariableCapacidad,ObservacionFirma,Observacion,ID_CodigoUsuarioValidacion,ID_Sector,CMI,Microorganismo,ObsResultado,SerieFuncional,SerieHistorico,SerieHistograma,Antibiotico,Letra,FechaValidacion,Obs_Rango,EstudioDesc,Microbiologia,SectorDescripcion,Confidencial,Alias,Metodo,Fe_Resultado,Posicion,Medico,UbicacionP,Firma,IMPRESION,Validador,Colegio,CODIGOEXTERNO,Area,Cursiva,PERFIL,PERFIL_CODIGO,TIPO1,ESTADO,UbicHistCli) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $stmt->execute(array($k, $v['ORDENCLIENTE'], $v['ID_Sucursal'], $v['Orden'], $v['IDExterno'], $v['ProfesionalNombre'], $v['ID_Ninterno'], $v['Paciente'], $v['ID_TipDoc'], $v['NumDoc'], $v['FecNac'], $v['Sexo'], $v['Ubicacion'], $v['Edad'], $v['Orden1'], $v['VariableDescripcion'], $v['Resultado'], $v['Unidad'], $v['RangoMinimo'], $v['RangoMaximo'], $v['Rango'], $v['ID_Estudio'], $v['TipoTiempo'], $v['CantidadTiempo'], $v['VariableCapacidad'], $v['ObservacionFirma'], $v['Observacion'], $v['ID_CodigoUsuarioValidacion'], $v['ID_Sector'], $v['CMI'], $v['Microorganismo'], $v['ObsResultado'], $v['SerieFuncional'], $v['SerieHistorico'], $v['SerieHistograma'], $v['Antibiotico'], $v['Letra'], $v['FechaValidacion'], $v['Obs_Rango'], $v['EstudioDesc'], $v['Microbiologia'], $v['SectorDescripcion'], $v['Confidencial'], $v['Alias'], $v['Metodo'], $v['Fe_Resultado'], $v['Posicion'], $v['Medico'], $v['UbicacionP'], $v['Firma'], $v['IMPRESION'], $v['Validador'], $v['Colegio'], $v['CODIGOEXTERNO'], $v['Area'], $v['Cursiva'], $v['PERFIL'], $v['PERFIL_CODIGO'], $v['TIPO1'], $v['ESTADO'], $v['UbicHistCli']));

                    } catch (PDOException $e) {
                    }

                }
                $stmt = $db->prepare("UPDATE recibos SET anglo='ok' WHERE id=? AND tip=?");
                $stmt->execute(array($pago['id'], $pago['tip']));
            }
        }
    }
}

$rAglo = $db->prepare("SELECT VariableDescripcion,Resultado,Unidad,Observacion,FechaValidacion FROM lab_anglo WHERE NumDoc=? ORDER BY FechaValidacion DESC");
$rAglo->execute(array($id));

$rLegal = $db->prepare("SELECT * FROM hc_legal WHERE a_dni=? ORDER BY a_fec ASC");
$rLegal->execute(array($id));

$rEco = $db->prepare("SELECT * FROM hc_analisis WHERE a_dni=? AND lab='eco' ORDER BY a_fec DESC");
$rEco->execute(array($id));

if (!file_exists("paci/" . $paci['dni'] . "/foto.jpg")) $foto_url = "_images/foto.gif"; else $foto_url = "paci/" . $paci['dni'] . "/foto.jpg?v=" . mt_rand(); ?>

<form action="e_paci.php?id=<?php echo $paci['dni']; ?>" method="post" enctype="multipart/form-data" data-ajax="false"
      name="form2">
    <input type="hidden" name="dni" value="<?php echo $paci['dni']; ?>">

    <div data-role="page" class="ui-responsive-panel" id="e_paci">

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
                <li class="ui-disabled" data-theme="b"><a href="<?php echo "e_paci.php?id=" . $paci['dni']; ?>"
                                                          rel="external">Datos y Antecedentes</a></li>
                <li data-theme="b"><a href="<?php echo "n_pare.php?id=" . $paci['dni']; ?>" rel="external">Pareja</a></li>
                <li data-theme="b"><a href="<?php echo "n_gine.php?id=" . $paci['dni']; ?>" rel="external">Ginecología</a>
                </li>
                <li data-theme="b"><a href="<?php echo "n_obst.php?id=" . $paci['dni']; ?>" rel="external">Obstetricia</a>
                </li>
                <li data-theme="b"><a href="<?php echo "n_repro.php?id=" . $paci['dni']; ?>" rel="external">Repro.
                        Asistida</a></li>
                <li data-icon="info"><a href="ayuda.php" rel="external">Ayuda</a></li>
            </ul>
        </div><!-- /panel -->
        <?php if ($_GET['pop'] <> 1) { ?>
            <div data-role="header" data-position="fixed">
                <a href="#indice_paci" data-icon="bars" id="b_indice" class="ui-icon-alt" data-theme="a">MENU
                    <small>> Datos y Antecedentes</small>
                </a>
                <h2><?php echo $paci['ape']; ?>
                    <small><?php echo $paci['nom'];
                        if ($paci['fnac'] <> "0000-00-00") echo ' <a href="#popupBasic" data-rel="popup" data-transition="pop">(' . date_diff(date_create($paci['fnac']), date_create('today'))->y . ')</a>'; ?></small>
                </h2>
                <a href="index.php"
                   class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power"
                   rel="external">Salir</a>
            </div><!-- /header -->
            <div data-role="popup" id="popupBasic" data-arrow="true">
                <textarea name="nota" id="nota" data-mini="true"><?php echo $paci['nota']; ?></textarea>
                <input type="Submit" value="GRABAR" name="graba_nota" data-mini="true"/>
            </div>
        <?php } ?>
        <div class="ui-content" role="main">

            <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">
                <div data-role="collapsible" <?php if ($_GET['pop'] <> 1) echo 'data-collapsed="false"'; ?>><h3>Datos
                        Generales</h3>
                    <div class="scroll_h">
                        <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                            <tr>
                                <td width="9%">Nombre(s)</td>
                                <td width="19%"><input name="nom" type="text" id="nom" data-mini="true"
                                                       value="<?php echo $paci['nom']; ?>"/></td>
                                <td width="13%">Apellidos</td>
                                <td width="29%"><input name="ape" type="text" id="ape" data-mini="true"
                                                       value="<?php echo $paci['ape']; ?>"/></td>
                                <td rowspan="8">
                                    <fieldset data-role="controlgroup">
                                        <select name="nac" id="nac" data-mini="true">
                                            <option value="">Nacionalidad</option>
                                            <?php $rPais = $db->prepare("SELECT * FROM countries ORDER BY countryName ASC");
                                            $rPais->execute();
                                            while ($pais = $rPais->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $pais['countryCode']; ?>" <?php if ($paci['nac'] == $pais['countryCode']) echo " selected"; ?>><?php echo $pais['countryName']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select name="raz" id="raz" data-mini="true">
                                            <option value="">Raza:</option>
                                            <option value="Blanca" <?php if ($paci['raz'] == "Blanca") echo "selected"; ?>>
                                                Blanca
                                            </option>
                                            <option value="Morena" <?php if ($paci['raz'] == "Morena") echo "selected"; ?>>
                                                Morena
                                            </option>
                                            <option value="Mestiza" <?php if ($paci['raz'] == "Mestiza") echo "selected"; ?>>
                                                Mestiza
                                            </option>
                                            <option value="Asiatica" <?php if ($paci['raz'] == "Asiatica") echo "selected"; ?>>
                                                Asiatica
                                            </option>
                                        </select>
                                        <select name="san" id="san" data-mini="true">
                                            <option value="">Grupo Sanguineo:</option>
                                            <option value="O+" <?php if ($paci['san'] == "O+") echo "selected"; ?>>GS: O+
                                            </option>
                                            <option value="O-" <?php if ($paci['san'] == "O-") echo "selected"; ?>>GS: O-
                                            </option>
                                            <option value="A+" <?php if ($paci['san'] == "A+") echo "selected"; ?>>GS: A+
                                            </option>
                                            <option value="A-" <?php if ($paci['san'] == "A-") echo "selected"; ?>>GS: A-
                                            </option>
                                            <option value="B+" <?php if ($paci['san'] == "B+") echo "selected"; ?>>GS: B+
                                            </option>
                                            <option value="B-" <?php if ($paci['san'] == "B-") echo "selected"; ?>>GS: B-
                                            </option>
                                            <option value="AB+" <?php if ($paci['san'] == "AB+") echo "selected"; ?>>GS:
                                                AB+
                                            </option>
                                            <option value="AB-" <?php if ($paci['san'] == "AB-") echo "selected"; ?>>GS:
                                                AB-
                                            </option>
                                        </select>
                                        <select name="don" id="don" data-mini="true">
                                            <option value="P" <?php if ($paci['don'] == "P") echo "selected"; ?>>Paciente
                                            </option>
                                            <option value="D" <?php if ($paci['don'] == "D") echo "selected"; ?>>Donante
                                            </option>
                                        </select>
                                        <input name="talla" type="number" step="any" id="talla" data-mini="true"
                                               placeholder="Talla(Cm)" value="<?php echo $paci['talla']; ?>"/>
                                        <input name="peso" type="number" step="any" id="peso" data-mini="true"
                                               placeholder="Peso(Kg)" value="<?php echo $paci['peso']; ?>"/>

                                        <a href="#popupPerfil" data-rel="popup" data-position-to="window"
                                           data-transition="fade"><img src="<?php echo $foto_url; ?>" width="100px"
                                                                       height="100px" id="preview"/></a>
                                        <div data-role="popup" id="popupPerfil" data-overlay-theme="b" data-theme="b"
                                             data-corners="false">
                                                <a href="#" data-rel="back"
                                                   class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a><img
                                                    src="<?php echo $foto_url; ?>" style="max-height:512px;">
                                        </div>
                                        <input name="foto" type="file" onchange="previewImage(this)" accept="image/jpeg"
                                               id="foto"/>
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
                                <td><select name="tip" id="tip" data-mini="true">
                                        <option value="DNI" <?php if ($paci['tip'] == "DNI") echo "selected"; ?>>DNI
                                        </option>
                                        <option value="PAS" <?php if ($paci['tip'] == "PAS") echo "selected"; ?>>PAS
                                        </option>
                                        <option value="CEX" <?php if ($paci['tip'] == "CEX") echo "selected"; ?>>CEX
                                        </option>
                                    </select></td>
                                <td><?php echo $paci['dni']; ?></td>
                                <td>F. Nac</td>
                                <td><input name="fnac" type="date" id="fnac" data-mini="true"
                                           value="<?php echo $paci['fnac']; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Celular</td>
                                <td><input name="tcel" type="text" id="tcel" data-mini="true" class="numeros"
                                           value="<?php echo $paci['tcel']; ?>"/></td>
                                <td>E-Mail</td>
                                <td><input name="mai" type="text" id="mai" data-mini="true"
                                           value="<?php echo $paci['mai']; ?>"></td>
                            </tr>
                            <tr>
                                <td>T. Casa</td>
                                <td><input name="tcas" type="text" id="tcas" data-mini="true" class="numeros"
                                           value="<?php echo $paci['tcas']; ?>"/></td>
                                <td>Profesión</td>
                                <td><input name="prof" type="text" id="prof" data-mini="true"
                                           value="<?php echo $paci['prof']; ?>"/></td>
                            </tr>
                            <tr>
                                <td>T. Oficina</td>
                                <td><input name="tofi" type="text" id="tofi" data-mini="true"
                                           value="<?php echo $paci['tofi']; ?>"/></td>
                                <td>Referido por</td>
                                <td><input name="rem" type="text" id="rem" data-mini="true"
                                           value="<?php echo $paci['rem']; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Dep/Prov/Dis</td>
                                <td><select name="depa" id="depa" data-mini="true">
                                        <option value="">Departamento:</option>
                                        <?php $rDepa = $db->prepare("SELECT * FROM departamentos ORDER BY nomdepartamento ASC");
                                        $rDepa->execute();
                                        while ($depa = $rDepa->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $depa['Iddepartamento']; ?>" <?php if ($paci['depa'] == $depa['Iddepartamento']) echo " selected"; ?>><?php echo $depa['nomdepartamento']; ?></option>
                                        <?php } ?>
                                    </select></td>
                                <td><select name="prov" id="prov" data-mini="true">
                                        <?php $rProv = $db->prepare("SELECT * FROM provincias WHERE idprovincia=?");
                                        $rProv->execute(array($paci['prov']));
                                        $prov = $rProv->fetch(PDO::FETCH_ASSOC);
                                        if ($prov['idprovincia']) echo "<option value=" . $prov['idprovincia'] . " selected>" . $prov['nomprovincia'] . "</option>"; ?>
                                    </select></td>
                                <td><select name="dist" id="dist" data-mini="true">
                                        <?php $rDist = $db->prepare("SELECT * FROM distritos WHERE iddistrito=?");
                                        $rDist->execute(array($paci['dist']));
                                        $dist = $rDist->fetch(PDO::FETCH_ASSOC);
                                        if ($dist['iddistrito']) echo "<option value=" . $dist['iddistrito'] . " selected>" . $dist['nomdistrito'] . "</option>"; ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Dirección</td>
                                <td colspan="3"><input name="dir" type="text" id="dir" data-mini="true"
                                                       value="<?php echo $paci['dir']; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td colspan="3"><textarea name="sta" id="sta"
                                                          data-mini="true"><?php echo $paci['sta']; ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div data-role="collapsible"><h3>Familiares</h3>
                    <div class="scroll_h">
                        <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                            <tr>
                                <td width="7%"><input type="checkbox" name="f_dia" id="f_dia" data-mini="true"
                                                      value="Si" <?php if ($paci['f_dia'] == "Si") echo "checked"; ?>><label
                                            for="f_dia">Diabetes</label></td>
                                <td width="10%"><input type="checkbox" name="f_hip" id="f_hip" data-mini="true"
                                                       value="Si" <?php if ($paci['f_hip'] == "Si") echo "checked"; ?>><label
                                            for="f_hip">Hipertensión</label></td>
                                <td width="17%"><input type="checkbox" name="f_gem" id="f_gem" data-mini="true"
                                                       value="Si" <?php if ($paci['f_gem'] == "Si") echo "checked"; ?>><label
                                            for="f_gem">Gemelares</label></td>
                                <td width="5%"><input type="checkbox" name="f_hta" id="f_hta" data-mini="true"
                                                      value="Si" <?php if ($paci['f_hta'] == "Si") echo "checked"; ?>><label
                                            for="f_hta">HTA</label></td>
                                <td width="61%"><select name="f_tbc" id="f_tbc" data-mini="true">
                                        <option value="" selected="selected">TBC:</option>
                                        <option value="NO" <?php if ($paci['f_tbc'] == "NO") echo "selected"; ?>>TBC: NO
                                        </option>
                                        <optgroup label="TBC: SI">
                                            <option value="Pulmonar" <?php if ($paci['f_tbc'] == "Pulmonar") echo "selected"; ?>>
                                                TBC: Pulmonar
                                            </option>
                                            <option value="Extrapulmonar" <?php if ($paci['f_tbc'] == "Extrapulmonar") echo "selected"; ?>>
                                                TBC: Extrapulmonar
                                            </option>
                                        </optgroup>

                                    </select></td>
                            </tr>
                            <tr>
                                <td colspan="4">Cancer
                                    <textarea name="f_can" id="f_can"
                                              data-mini="true"><?php echo $paci['f_can']; ?></textarea></td>
                                <td>Otros
                                    <textarea name="f_otr" id="f_otr"
                                              data-mini="true"><?php echo $paci['f_otr']; ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div data-role="collapsible"><h3>Médicos</h3>
                    <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                        <tr>
                            <td width="24%"><input type="checkbox" name="m_dia" id="m_dia" data-mini="true"
                                                   value="Si" <?php if ($paci['m_dia'] == "Si") echo "checked"; ?>>
                                <label for="m_dia">Diabetes</label></td>
                            <td width="27%"><input type="checkbox" name="m_hip" id="m_hip" data-mini="true"
                                                   value="Si" <?php if ($paci['m_hip'] == "Si") echo "checked"; ?>>
                                <label for="m_hip">Hipertensión</label></td>
                            <td width="49%"><select name="m_tbc" id="m_tbc" data-mini="true">
                                    <option value="" selected="selected">TBC:</option>
                                    <option value="NO" <?php if ($paci['m_tbc'] == "NO") echo "selected"; ?>>TBC: NO
                                    </option>
                                    <optgroup label="TBC: SI">
                                        <option value="Pulmonar" <?php if ($paci['m_tbc'] == "Pulmonar") echo "selected"; ?>>
                                            TBC: Pulmonar
                                        </option>
                                        <option value="Extrapulmonar" <?php if ($paci['m_tbc'] == "Extrapulmonar") echo "selected"; ?>>
                                            TBC: Extrapulmonar
                                        </option>
                                    </optgroup>
                                </select></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="m_inf" id="m_inf" data-mini="true"
                                       class="chekes" <?php if ($paci['m_inf'] <> "") echo "checked"; ?>>
                                <label for="m_inf">Infecciones</label></td>
                            <td colspan="2"><input name="m_inf1" type="text" id="m_inf1" data-mini="true"
                                                   placeholder="Especifique.." readonly
                                                   value="<?php echo $paci['m_inf']; ?>"></td>
                        </tr>
                        <tr>
                            <td><select name="m_ale" id="m_ale" data-mini="true" class="chekes">
                                    <option value="" selected="selected">Alergias:</option>
                                    <option value="NO" <?php if ($paci['m_ale'] == "NO") echo "selected"; ?>>Alergia: NO
                                    </option>
                                    <option value="Medicamentada" <?php if ($paci['m_ale'] == "Medicamentada") echo "selected"; ?>>
                                        Alergia: Medicamentada
                                    </option>
                                    <option value="Otra" <?php if ($paci['m_ale'] == "Otra") echo "selected"; ?>>Alergia:
                                        Otra
                                    </option>
                                </select></td>
                            <td colspan="2"><input name="m_ale1" type="text" id="m_ale1" data-mini="true"
                                                   placeholder="Especifique.." readonly
                                                   value="<?php echo $paci['m_ale1']; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2">Cancer
                                <textarea name="m_can" id="m_can" data-mini="true"><?php echo $paci['m_can']; ?></textarea>
                            </td>
                            <td>Otros
                                <textarea name="m_otr" id="m_otr" data-mini="true"><?php echo $paci['m_otr']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><select name="select" class="med_insert" title="m_ets" data-mini="true">
                                    <option value="" selected="selected">ETS:</option>
                                    <option value="Borrar">--- Borrar Datos ---</option>
                                    <option value="Clamidiasis">ETS: Clamidiasis</option>
                                    <option value="Gonorrea">ETS: Gonorrea</option>
                                    <option value="Chancroide">ETS: Chancroide</option>
                                    <option value="Sífilis">ETS: Sífilis</option>
                                    <option value="Mycoplasma genitalium">ETS: Mycoplasma genitalium</option>
                                    <option value="VIH">ETS: VIH</option>
                                    <option value="Herpes virus">ETS: Herpes virus</option>
                                    <option value="Tricomoniasis">ETS: Tricomoniasis</option>
                                    <option value="Ladillas">ETS: Ladillas</option>
                                    <option value="VPH">ETS: VPH</option>
                                    <option value="Vaginosis bacteriana">ETS: Vaginosis bacteriana</option>
                                    <option value="Hepatitis C">ETS: Hepatitis C</option>
                                    <option value="Enfermedad pélvica inflamatoria">ETS: Enfermedad pélvica
                                        inflamatoria
                                    </option>
                                    <option value="Verrugas genitales por papiloma humano">ETS: Verrugas genitales por
                                        papiloma humano
                                    </option>
                                </select></td>
                            <td colspan="2"><textarea name="m_ets" readonly id="m_ets"
                                                      data-mini="true"><?php echo $paci['m_ets']; ?></textarea></td>
                        </tr>
                    </table>
                </div>

                <div data-role="collapsible"><h3>Hábitos</h3>
                    <div class="scroll_h">
                        <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                            <tr>
                                <td><select name="h_str" id="h_str" data-mini="true">
                                        <option value="">Stress</option>
                                        <option value="NO" <?php if ($paci['h_str'] == "NO") echo "selected"; ?>>Stress:
                                            NO
                                        </option>
                                        <optgroup label="Stress: SI">
                                            <option value="Bajo" <?php if ($paci['h_str'] == "Bajo") echo "selected"; ?>>
                                                Stress: Bajo
                                            </option>
                                            <option value="Medio" <?php if ($paci['h_str'] == "Medio") echo "selected"; ?>>
                                                Stress: Medio
                                            </option>
                                            <option value="Alto" <?php if ($paci['h_str'] == "Alto") echo "selected"; ?>>
                                                Stress: Alto
                                            </option>
                                        </optgroup>
                                    </select></td>
                                <td width="9%"><select name="h_dep" id="h_dep" data-mini="true">
                                        <option value="">Deportes</option>
                                        <option value="NO" <?php if ($paci['h_dep'] == "NO") echo "selected"; ?>>Deportes:
                                            NO
                                        </option>
                                        <optgroup label="Deportes: SI">
                                            <option value="Bajo" <?php if ($paci['h_dep'] == "Bajo") echo "selected"; ?>>
                                                Deportes: Bajo
                                            </option>
                                            <option value="Medio" <?php if ($paci['h_dep'] == "Medio") echo "selected"; ?>>
                                                Deportes: Medio
                                            </option>
                                            <option value="Alto" <?php if ($paci['h_dep'] == "Alto") echo "selected"; ?>>
                                                Deportes: Alto
                                            </option>
                                        </optgroup>
                                    </select></td>
                                <td width="8%"><select name="h_dro" id="h_dro" data-mini="true">
                                        <option value="">Drogas</option>
                                        <option value="NO" <?php if ($paci['h_dro'] == "NO") echo "selected"; ?>>Drogas:
                                            NO
                                        </option>
                                        <optgroup label="Drogas: SI">
                                            <option value="Bajo" <?php if ($paci['h_dro'] == "Bajo") echo "selected"; ?>>
                                                Drogas: Bajo
                                            </option>
                                            <option value="Medio" <?php if ($paci['h_dro'] == "Medio") echo "selected"; ?>>
                                                Drogas: Medio
                                            </option>
                                            <option value="Alto" <?php if ($paci['h_dro'] == "Alto") echo "selected"; ?>>
                                                Drogas: Alto
                                            </option>
                                        </optgroup>
                                    </select></td>
                                <td width="9%"><select name="h_tab" id="h_tab" data-mini="true">
                                        <option value="">Tabaco</option>
                                        <option value="NO" <?php if ($paci['h_tab'] == "NO") echo "selected"; ?>>Tabaco:
                                            NO
                                        </option>
                                        <optgroup label="Tabaco: SI">
                                            <option value="Bajo" <?php if ($paci['h_tab'] == "Bajo") echo "selected"; ?>>
                                                Tabaco: Bajo
                                            </option>
                                            <option value="Medio" <?php if ($paci['h_tab'] == "Medio") echo "selected"; ?>>
                                                Tabaco: Medio
                                            </option>
                                            <option value="Alto" <?php if ($paci['h_tab'] == "Alto") echo "selected"; ?>>
                                                Tabaco: Alto
                                            </option>
                                        </optgroup>
                                    </select></td>
                                <td><select name="h_alc" id="h_alc" data-mini="true">
                                        <option value="">Alcohol</option>
                                        <option value="NO" <?php if ($paci['h_alc'] == "NO") echo "selected"; ?>>Alcohol:
                                            NO
                                        </option>
                                        <optgroup label="Alcohol: SI">
                                            <option value="Bajo" <?php if ($paci['h_alc'] == "Bajo") echo "selected"; ?>>
                                                Alcohol: Bajo
                                            </option>
                                            <option value="Medio" <?php if ($paci['h_alc'] == "Medio") echo "selected"; ?>>
                                                Alcohol: Medio
                                            </option>
                                            <option value="Alto" <?php if ($paci['h_alc'] == "Alto") echo "selected"; ?>>
                                                Alcohol: Alto
                                            </option>
                                        </optgroup>
                                    </select></td>
                            </tr>
                            <tr>
                                <td width="9%">Otro</td>
                                <td colspan="4">
                                    <input name="h_otr" type="text" id="h_otr" data-mini="true"
                                           value="<?php echo $paci['h_otr']; ?>">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div data-role="collapsible" id="Quiru"><h3>Quirúrgicos</h3>

                    <a href="e_ante_quiru.php?dni=<?php echo $paci['dni'] . "&id="; ?>" rel="external"
                       class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>
                    <div class="scroll_h">


                        <table width="85%" style="margin:0 auto;font-size:small;" class="ui-responsive table-stroke">
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
                            <?php while ($quiru = $a_quiru->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><a href="e_ante_quiru.php?dni=<?php echo $paci['dni'] . "&id=" . $quiru['id']; ?>"
                                           rel="external"><?php echo date("d-m-Y", strtotime($quiru['fec'])); ?></a><?php if (file_exists("analisis/quiru_" . $quiru['id'] . ".pdf")) echo "<br><a href='analisis/quiru_" . $quiru['id'] . ".pdf' target='new'>Descargar</a>"; ?>
                                    </td>
                                    <td><?php echo $quiru['pro']; ?></td>
                                    <td><?php echo $quiru['med']; ?></td>
                                    <td><?php echo $quiru['dia']; ?></td>
                                    <td><?php echo $quiru['lug']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($a_quiru->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                    </div>
                </div>

                <div data-role="collapsible"><h3>Gineco - Obstétricos</h3>


                    <div class="scroll_h">
                        <table width="100%" style="margin: 0 auto;max-width:800px;">
                            <tr>
                                <td><select name="g_men" id="g_men" data-mini="true">
                                        <option value="" selected="selected">Menarquia:</option>

                                        <?php for ($i = 9; $i <= 16; $i++) { ?>
                                            <option value=<?php echo $i;
                                            if ($paci['g_men'] == $i) echo " selected"; ?>>
                                                Menarquia: <?php echo $i; ?></option>
                                        <?php } ?>

                                    </select></td>
                                <td><select name="g_per" id="g_per" data-mini="true">
                                        <option value="" selected="selected">Periocidad:</option>
                                        <option value="Regular" <?php if ($paci['g_per'] == "Regular") echo " selected"; ?>>
                                            Periocidad: Regular
                                        </option>
                                        <option value="Iregular" <?php if ($paci['g_per'] == "Iregular") echo " selected"; ?>>
                                            Periocidad: Iregular
                                        </option>
                                    </select></td>
                                <td width="16%"><select name="g_dur" id="g_dur" data-mini="true">
                                        <option value="" selected="selected">Duración:</option>
                                        <option value="3 a 5" <?php if ($paci['g_dur'] == "3 a 5") echo "selected"; ?>>
                                            Duración: 3 a 5
                                        </option>
                                        <option value="5 a 10" <?php if ($paci['g_dur'] == "5 a 10") echo "selected"; ?>>
                                            Duración: 5 a 10
                                        </option>
                                        <option value="Más de 10" <?php if ($paci['g_dur'] == "Aumentado") echo "selected"; ?>>
                                            Duración: Más de 10
                                        </option>
                                    </select></td>
                                <td width="14%"><select name="g_vol" id="g_vol" data-mini="true">
                                        <option value="" selected="selected">Volumen:</option>
                                        <option value="Normal" <?php if ($paci['g_vol'] == "Normal") echo "selected"; ?>>
                                            Volumen: Normal
                                        </option>
                                        <option value="Disminuido" <?php if ($paci['g_vol'] == "Disminuido") echo "selected"; ?>>
                                            Volumen: Disminuido
                                        </option>
                                        <option value="Aumentado" <?php if ($paci['g_vol'] == "Aumentado") echo "selected"; ?>>
                                            Volumen: Aumentado
                                        </option>
                                    </select></td>
                                <td width="3%"><label for="g_fur">FUR</label></td>
                                <td width="11%"><input type="date" data-clear-btn="false" name="g_fur" id="g_fur"
                                                       value="<?php echo $paci['g_fur']; ?>"></td>
                                <td><select name="g_ant" id="g_ant" data-mini="true">
                                        <option value="" selected="selected">Anticoncepción:</option>
                                        <option value="NO" <?php if ($paci['g_ant'] == "NO") echo "selected"; ?>>
                                            Anticoncepción: NO
                                        </option>
                                        <optgroup label="Anticoncepción: SI">
                                            <option value="Implante anticonceptivo" <?php if ($paci['g_ant'] == "Implante anticonceptivo") echo "selected"; ?>>
                                                Implante anticonceptivo
                                            </option>
                                            <option value="Parche anticonceptivo" <?php if ($paci['g_ant'] == "Parche anticonceptivo") echo "selected"; ?>>
                                                Parche anticonceptivo
                                            </option>
                                            <option value="Píldora anticonceptiva" <?php if ($paci['g_ant'] == "Píldora anticonceptiva") echo "selected"; ?>>
                                                Píldora anticonceptiva
                                            </option>
                                            <option value="Inyección anticonceptiva" <?php if ($paci['g_ant'] == "Inyección anticonceptiva") echo "selected"; ?>>
                                                Inyección anticonceptiva
                                            </option>
                                            <option value="Condon" <?php if ($paci['g_ant'] == "Condon") echo "selected"; ?>>
                                                Condon
                                            </option>
                                            <option value="Diafragma" <?php if ($paci['g_ant'] == "Diafragma") echo "selected"; ?>>
                                                Diafragma
                                            </option>
                                            <option value="Condon femenino" <?php if ($paci['g_ant'] == "Condon femenino") echo "selected"; ?>>
                                                Condon femenino
                                            </option>
                                            <option value="Dispositivo intrauterino (DiU)" <?php if ($paci['g_ant'] == "Dispositivo intrauterino (DiU)") echo "selected"; ?>>
                                                Dispositivo intrauterino (DiU)
                                            </option>
                                            <option value="Espermicidas" <?php if ($paci['g_ant'] == "Espermicidas") echo "selected"; ?>>
                                                Espermicidas
                                            </option>
                                            <option value="Vasectomía" <?php if ($paci['g_ant'] == "Vasectomía") echo "selected"; ?>>
                                                Vasectomía
                                            </option>
                                            <option value="Coitus interruptus" <?php if ($paci['g_ant'] == "Coitus interruptus") echo "selected"; ?>>
                                                Coitus interruptus
                                            </option>
                                            <option value="Esponja anticonceptiva" <?php if ($paci['g_ant'] == "Esponja anticonceptiva") echo "selected"; ?>>
                                                Esponja anticonceptiva
                                            </option>
                                            <option value="Esterilización femenina (tubárica)" <?php if ($paci['g_ant'] == "Esterilización femenina (tubárica)") echo "selected"; ?>>
                                                Esterilización femenina (tubárica)
                                            </option>
                                            <option value="Relaciones sexuales sin penetración" <?php if ($paci['g_ant'] == "Relaciones sexuales sin penetración") echo "selected"; ?>>
                                                Relaciones sexuales sin penetración
                                            </option>
                                        </optgroup>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>
                                    <fieldset data-role="controlgroup" data-type="horizontal">
                                        <select name="g_pap" id="g_pap" data-mini="true" class="chekes">
                                            <option value="" selected="selected">PAP:</option>
                                            <option value="Normal" <?php if ($paci['g_pap'] == "Normal") echo "selected"; ?>>
                                                PAP: Normal
                                            </option>
                                            <option value="Anormal" <?php if ($paci['g_pap'] == "Anormal") echo "selected"; ?>>
                                                PAP: Anormal
                                            </option>
                                        </select>
                                    </fieldset>
                                </td>
                                <td colspan="3"><input name="g_pap1" type="text" id="g_pap1" data-mini="true"
                                                       placeholder="Especifique.." readonly
                                                       value="<?php echo $paci['g_pap1']; ?>"></td>
                                <td colspan="2"><input type="month" data-clear-btn="false" name="g_pap2" id="g_pap2"
                                                       value="<?php echo $paci['g_pap2']; ?>"></td>
                                <td><select name="g_dis" id="g_dis" data-mini="true">
                                        <option value="" selected="selected">Dismenorrea:</option>
                                        <option value="Ausente" <?php if ($paci['g_dis'] == "Ausente") echo "selected"; ?>>
                                            Dismenorrea: Ausente
                                        </option>
                                        <option value="Leve" <?php if ($paci['g_dis'] == "Leve") echo "selected"; ?>>
                                            Dismenorrea: Leve
                                        </option>
                                        <option value="Moderada" <?php if ($paci['g_dis'] == "Moderada") echo "selected"; ?>>
                                            Dismenorrea: Moderada
                                        </option>
                                        <option value="Severa" <?php if ($paci['g_dis'] == "Severa") echo "selected"; ?>>
                                            Dismenorrea: Severa
                                        </option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td width="15%" class="peke2">
                                    Gestaciones
                                    <input type="text" name="g_ges" id="g_ges" value="<?php echo $paci['g_ges']; ?>"
                                           data-mini="true">
                                </td>
                                <td colspan="3" class="peke2">
              <span>P.T
                <input type="text" name="g_pt" id="g_pt" value="<?php echo $paci['g_pt']; ?>" data-mini="true"
                       class="numeros">
                </span><span>P.P
                <input type="text" name="g_pp" id="g_pp" value="<?php echo $paci['g_pp']; ?>" data-mini="true"
                       class="numeros">
                </span><span>A
                <input type="text" name="g_abo" id="g_abo" value="<?php echo $paci['g_abo']; ?>" data-mini="true"
                       class="numeros">
                </span><span>N.V
                <input type="text" name="g_nv" id="g_nv" value="<?php echo $paci['g_nv']; ?>" data-mini="true"
                       class="numeros">
               </span>
                                </td>
                                <td colspan="2" class="peke">
                                    <select name="g_neo" id="g_neo" data-mini="true">
                                        <option value="">Neonatal:</option>
                                        <option value="Precoz" <?php if ($paci['g_neo'] == "Precoz") echo "selected"; ?>>
                                            Neonatal: Precoz
                                        </option>
                                        <option value="Tardía" <?php if ($paci['g_neo'] == "Tardía") echo "selected"; ?>>
                                            Neonatal: Tardía
                                        </option>
                                    </select>
                                </td>
                                <td width="26%"><label for="g_fur">Último parto</label>
                                    <input type="month" data-clear-btn="false" name="g_fup" id="g_fup"
                                           value="<?php echo $paci['g_fup']; ?>"></td>
                            </tr>
                            <tr>
                                <td rowspan="3" class="peke2">
                                    <div data-role="controlgroup" data-mini="true">
                                        <select name="g_abo1" id="g_abo1" data-mini="true">
                                            <option value="">Aborto:</option>
                                            <option value="Espontaneo" <?php if ($paci['g_abo1'] == "Espontaneo") echo "selected"; ?>>
                                                Aborto: Espontaneo
                                            </option>
                                            <option value="Provocado" <?php if ($paci['g_abo1'] == "Provocado") echo "selected"; ?>>
                                                Aborto: Provocado
                                            </option>
                                        </select>

                                        <input type="checkbox" name="g_rn_men" id="g_rn_men" data-mini="true"
                                               value=1 <?php if ($paci['g_rn_men'] == 1) echo "checked"; ?>>
                                        <label for="g_rn_men">RN menor 2500gr</label>

                                        <select name="g_rn_mul" id="g_rn_mul" data-mini="true">
                                            <option value="" selected="selected">Múltiples:</option>
                                            <?php for ($i = 1; $i <= 4; $i++) { ?>
                                                <option value=<?php echo $i;
                                                if ($paci['g_rn_mul'] == $i) echo " selected"; ?>>
                                                    Múltiples: <?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>

                                        <div>Edad Gestacional</div>
                                        <input type="text" name="g_abo_ges" id="g_abo_ges"
                                               value="<?php echo $paci['g_abo_ges']; ?>" class="numeros">

                                    </div>
                                </td>
                                <td width="16%" class="peke2"><label for="g_vag">P.V</label>
                                    <input type="text" name="g_vag" id="g_vag" value="<?php echo $paci['g_vag']; ?>"
                                           data-mini="true" class="numeros"></td>
                                <td class="peke2"><label for="g_ces">P.C</label>
                                    <input type="text" name="g_ces" id="g_ces" value="<?php echo $paci['g_ces']; ?>"
                                           data-mini="true" class="numeros"></td>
                                <td class="peke2"><label for="g_nm">N. Muertos</label>
                                    <input type="text" name="g_nm" id="g_nm" value="<?php echo $paci['g_nm']; ?>"
                                           data-mini="true" class="numeros"></td>
                                <td colspan="2" class="peke2"><label for="g_viv">Hijos Vivos</label>
                                    <input type="text" name="g_viv" id="g_viv" value="<?php echo $paci['g_viv']; ?>"
                                           data-mini="true" class="numeros"></td>
                                <td class="peke">RN con mayor peso(gr)
                                    <input name="g_rn_may" id="g_rn_may" value="<?php echo $paci['g_rn_may']; ?>" size="6"
                                           maxlength="6" data-clear-btn="false" class="numeros"></td>
                            </tr>
                            <tr>
                                <td>Complicaciones</td>
                                <td colspan="4"><textarea name="g_abo_com"
                                                          id="g_abo_com"><?php echo $paci['g_abo_com']; ?></textarea></td>
                                <td><select name="g_agh" id="g_agh" data-mini="true">
                                        <option value="" selected="selected">AgHbs:</option>
                                        <option value="Positivo" <?php if ($paci['g_agh'] == "Positivo") echo "selected"; ?>>
                                            AgHbs: Positivo
                                        </option>
                                        <option value="Negativo" <?php if ($paci['g_agh'] == "Negativo") echo "selected"; ?>>
                                            AgHbs: Negativo
                                        </option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td colspan="4"><textarea name="g_obs" id="g_obs"><?php echo $paci['g_obs']; ?></textarea>
                                </td>
                                <td>Histero.<input type="text" name="g_his" id="g_his"
                                                   value="<?php echo $paci['g_his']; ?>" data-mini="true"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div data-role="collapsible" id="Pap"><h3>Historial PAP</h3>

                    <a href="e_ante_pap.php?dni=<?php echo $paci['dni'] . "&id="; ?>" rel="external"
                       class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>
                    <div class="scroll_h">


                        <table width="85%" style="margin:0 auto;font-size:small;" class="ui-responsive table-stroke">
                            <thead>
                            <tr>

                                <th width="11%" align="left">Año</th>
                                <th width="31%" align="left">Tipo</th>
                                <th width="31%" align="left">Observaciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($pap = $a_pap->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><a href="e_ante_pap.php?dni=<?php echo $paci['dni'] . "&id=" . $pap['id']; ?>"
                                           rel="external"><?php echo $pap['fec']; ?></a></td>
                                    <td><?php echo $pap['tip']; ?></td>
                                    <td><?php echo $pap['obs']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($a_pap->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                    </div>
                </div>

                <div data-role="collapsible" id="Perfi"><h3>Resultados de Análisis Clínicos</h3>


                    <p>
                        <a href="e_ante_hsghes.php?dni=<?php echo $paci['dni'] . "&id="; ?>" rel="external"
                           class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar<br>HSG - HES</a>
                    <div class="scroll_h">

                        <table width="85%" style="margin:0 auto;font-size:small;" class="ui-responsive table-stroke">
                            <thead>
                            <tr>

                                <th width="5%" align="left">Fecha</th>
                                <th width="5%" align="left">Tipo</th>
                                <th width="90%" align="left">Conclusión</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($hsghes = $a_hsghes->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php if ($hsghes['lab'] <> "") echo date("d-m-Y", strtotime($hsghes['fec'])) . ' (' . $hsghes['lab'] . ')'; else { ?>
                                            <a
                                            href="e_ante_hsghes.php?dni=<?php echo $paci['dni'] . "&id=" . $hsghes['fec']; ?>"
                                            rel="external"><?php echo date("d-m-Y", strtotime($hsghes['fec'])); ?></a><?php } ?>
                                        <?php if (file_exists("analisis/hsghes_" . $paci['dni'] . "_" . $hsghes['fec'] . ".pdf")) echo "<br><a href='analisis/hsghes_" . $paci['dni'] . "_" . $hsghes['fec'] . ".pdf' target='new'>Descargar</a>"; ?>
                                    </td>
                                    <td><?php echo $hsghes['tip']; ?></td>
                                    <td><?php if ($hsghes['con'] == 'P') echo 'En proceso..'; else echo $hsghes['con']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($a_hsghes->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                    </div>
                    </p>

                    <hr>
                    <p>
                        <a href="e_ante_perfi.php?dni=<?php echo $paci['dni'] . "&id="; ?>" rel="external"
                           class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar<br>Perfil<br>Hormonal</a>
                    <div class="scroll_h">

                        <table width="85%" style="margin:0 auto;font-size:small;text-align:center;"
                               class="ui-responsive table-stroke">
                            <thead>
                            <tr>

                                <th width="5%">Fecha</th>
                                <th width="10%">FSH</th>
                                <th width="10%">LH</th>
                                <th width="16%">Estradiol</th>
                                <th width="3%">Prolactina</th>
                                <th width="7%">Insulina</th>
                                <th width="8%">T3</th>
                                <th width="8%">T4</th>
                                <th width="11%">TSH</th>
                                <th width="14%">AMH</th>
                                <th width="8%">Inhibina</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($perfi = $a_perfi->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php if ($perfi['lab'] <> "") echo date("d-m-Y", strtotime($perfi['fec'])) . ' (' . $perfi['lab'] . ')'; else { ?>
                                            <a
                                            href="e_ante_perfi.php?dni=<?php echo $paci['dni'] . "&id=" . $perfi['fec']; ?>"
                                            rel="external"><?php echo date("d-m-Y", strtotime($perfi['fec'])); ?></a><?php } ?><?php if (file_exists("analisis/perfil_" . $paci['dni'] . "_" . $perfi['fec'] . ".pdf")) echo "<br><a href='analisis/perfil_" . $paci['dni'] . "_" . $perfi['fec'] . ".pdf' target='new'>Descargar</a>"; ?>
                                    </td>
                                    <td><?php if ($perfi['fsh'] == 'P') echo 'En proceso..'; else echo $perfi['fsh']; ?></td>
                                    <td><?php if ($perfi['lh'] == 'P') echo 'En proceso..'; else echo $perfi['lh']; ?></td>
                                    <td><?php if ($perfi['est'] == 'P') echo 'En proceso..'; else echo $perfi['est']; ?></td>
                                    <td><?php if ($perfi['prol'] == 'P') echo 'En proceso..'; else echo $perfi['prol']; ?></td>
                                    <td><?php if ($perfi['ins'] == 'P') echo 'En proceso..'; else echo $perfi['ins']; ?></td>
                                    <td><?php if ($perfi['t3'] == 'P') echo 'En proceso..'; else echo $perfi['t3']; ?></td>
                                    <td><?php if ($perfi['t4'] == 'P') echo 'En proceso..'; else echo $perfi['t4']; ?></td>
                                    <td><?php if ($perfi['tsh'] == 'P') echo 'En proceso..'; else echo $perfi['tsh']; ?></td>
                                    <td><?php if ($perfi['amh'] == 'P') echo 'En proceso..'; else echo $perfi['amh']; ?></td>
                                    <td><?php if ($perfi['inh'] == 'P') echo 'En proceso..'; else echo $perfi['inh']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($a_perfi->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                    </div>
                    </p>
                    <hr>
                    <p>
                        <a href="e_ante_p_sero.php?dni=mujer<?php echo "&ip=" . $paci['dni'] . "&id="; ?>" rel="external"
                           class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar<br>Serologías</a>
                    <div class="scroll_h">
                        <table width="85%" style="margin:0 auto;font-size:small;text-align:center;"
                               class="ui-responsive table-stroke">
                            <thead>
                            <tr>
                                <th width="5%">Fecha</th>
                                <th>Hepatitis B<br>HBs Ag</th>
                                <th>Hepatitis C <br>HCV Ac</th>
                                <th>HIV</th>
                                <th width="14%">RPR</th>
                                <th>Rubeola<br>IgG</th>
                                <th width="14%">Toxoplasma<br>IgG</th>
                                <th width="14%">Clamidia<br>IgG</th>
                                <th width="14%">clamidia<br>IgM</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($sero = $Sero->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td valign="top"><?php if ($sero['lab'] <> "") echo date("d-m-Y", strtotime($sero['fec'])) . ' (' . $sero['lab'] . ')'; else { ?>
                                            <a
                                            href="e_ante_p_sero.php?dni=mujer<?php echo "&ip=" . $paci['dni'] . "&id=" . $sero['fec']; ?>"
                                            rel="external"><?php echo date("d-m-Y", strtotime($sero['fec'])); ?></a><?php } ?><?php if (file_exists("analisis/sero_" . $paci['dni'] . "_" . $sero['fec'] . ".pdf")) echo "<br><a href='analisis/hsero_" . $paci['dni'] . "_" . $sero['fec'] . ".pdf' target='new'>Descargar</a>"; ?>
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
                                    <td valign="top" <?php if ($sero['rub'] == 1) echo 'class="color"'; ?>><?php if ($sero['rub'] == 1) echo "Positivo";
                                        if ($sero['rub'] == 2) echo "Negativo";
                                        if ($sero['rub'] == 3) echo "En proceso";
                                        if ($sero['rub'] == 4) echo "Indeterminado";
                                        if ($sero['rub'] == 0) echo "No Realizado"; ?></td>
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
                    </div>
                    </p>
                    <hr>
                    <?php if ($rAnal->rowCount() > 0 or $rAglo->rowCount() > 0) { ?>
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
                            <?php if ($rAnal->rowCount() > 0) {
                                while ($anal = $rAnal->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <th><?php echo $anal['a_exa']; ?></th>
                                        <td><?php echo $anal['a_sta']; ?></td>
                                        <td><?php echo $anal['a_obs']; ?></td>
                                        <th>
                                            <a href='<?php echo "analisis/" . $anal['id'] . "_" . $anal['a_dni'] . ".pdf"; ?>'
                                               target="new">Ver/Descargar</a></th>
                                        <td><?php echo date("d-m-Y", strtotime($anal['a_fec'])); ?></td>
                                    </tr>
                                <?php }
                            } ?>
                            <?php if ($rAglo->rowCount() > 0) {
                                while ($aglo = $rAglo->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <th><?php echo $aglo['VariableDescripcion']; ?></th>
                                        <td><?php echo $aglo['Resultado'] . ' ' . $aglo['Unidad']; ?></td>
                                        <td><?php echo $aglo['Observacion']; ?></td>
                                        <th>-</th>
                                        <td><?php echo date("d-m-Y", strtotime($aglo['FechaValidacion'])); ?></td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <label for="fe_exa">
                        Otros Exámenes:</label>
                    <textarea name="fe_exa" id="fe_exa" data-mini="true"><?php echo $paci['fe_exa']; ?></textarea>
                </div>

                <div data-role="collapsible" id="Cirug"><h3>Cirugías ginecológicas y/o Pélvicas</h3>

                    <a href="e_ante_cirug.php?dni=<?php echo $paci['dni'] . "&id="; ?>" rel="external"
                       class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>
                    <div class="scroll_h">

                        <table width="85%" style="margin:0 auto;font-size:small;" class="ui-responsive table-stroke">
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
                            <?php while ($cirug = $a_cirug->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><a href="e_ante_cirug.php?dni=<?php echo $paci['dni'] . "&id=" . $cirug['id']; ?>"
                                           rel="external"><?php echo date("d-m-Y", strtotime($cirug['fec'])); ?></a><?php if (file_exists("analisis/cirug_" . $cirug['id'] . ".pdf")) echo "<br><a href='analisis/cirug_" . $cirug['id'] . ".pdf' target='new'>Descargar</a>"; ?>
                                    </td>
                                    <td><?php echo $cirug['pro']; ?></td>
                                    <td><?php echo $cirug['med']; ?></td>
                                    <td><?php echo $cirug['dia']; ?></td>
                                    <td><?php echo $cirug['lug']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($a_cirug->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                    </div>
                </div>

                <div data-role="collapsible" id="Trata"><h3>Tratamientos de reproducción asistida anteriores (NO
                        realizados en INMATER)</h3>

                    <a href="e_ante_trata.php?dni=<?php echo $paci['dni'] . "&id="; ?>" rel="external"
                       class="ui-btn ui-btn-inline ui-mini" style="float:left">Agregar</a>
                    <div class="scroll_h">

                        <table width="85%" style="margin:0 auto;font-size:small;" class="ui-responsive table-stroke">
                            <thead>
                            <tr>

                                <th width="5%" align="left">Fecha</th>
                                <th width="18%" align="left">Procedimiento</th>
                                <th width="10%" align="left">Médico</th>
                                <th width="16%" align="left">Medicamentos</th>
                                <th width="3%" align="left">Nº Folículos</th>
                                <th width="7%" align="left">Nº Ovocitos<br>aspirados</th>
                                <th width="8%" align="left">Nº Embriones<br>transferidos</th>
                                <th width="8%" align="left">Día de<br>transferencia</th>
                                <th width="11%" align="left">Criopreservados</th>
                                <th width="14%" align="left">Resultado</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($trata = $a_trata->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><a href="e_ante_trata.php?dni=<?php echo $paci['dni'] . "&id=" . $trata['id']; ?>"
                                           rel="external"><?php echo date("d-m-Y", strtotime($trata['fec'])); ?></a></td>
                                    <td><?php echo $trata['pro'];
                                        if ($trata['tras'] == 1) echo ' <b>(TRASLADO EN PROCESO)</b>';
                                        if ($trata['tras'] == 2) echo ' <b>(TRASLADO FINALIZADO)</b>'; ?></td>
                                    <td><?php echo $trata['med']; ?></td>
                                    <td><?php echo $trata['medica']; ?></td>
                                    <td><?php echo $trata['fol']; ?></td>
                                    <td><?php echo $trata['ovo']; ?></td>
                                    <td><?php echo $trata['emb']; ?></td>
                                    <td><?php echo $trata['dia']; ?></td>
                                    <td><?php echo $trata['cri']; ?></td>
                                    <td><?php echo $trata['res']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($a_trata->rowCount() < 1) echo '<p><h3>¡ No hay datos aún !</h3></p>'; ?>

                    </div>
                </div>
                <div data-role="collapsible" id="Eco"><h3>Ecografía INMATER</h3>
                    <?php if ($rEco->rowCount() > 0) { ?>
                        <table style="font-size:small;" data-role="table" class="ui-responsive table-stroke">
                            <thead>
                            <tr>
                                <th>TIPO</th>
                                <th>OBSERVACION</th>
                                <th>INFORME</th>
                                <th>FECHA</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($eco = $rEco->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <th><?php echo $eco['a_exa']; ?></th>
                                    <td><?php echo $eco['a_obs']; ?></td>
                                    <th><a href='<?php echo "analisis/" . $eco['id'] . "_" . $eco['a_dni'] . ".pdf"; ?>'
                                           target="new">Ver/Descargar</a></th>
                                    <td><?php echo date("d-m-Y", strtotime($eco['a_fec'])); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } else echo "<h5>No hay Ecografías</h5>"; ?>
                </div>
                <div data-role="collapsible" id="Legal"><h3>Legal <span id="ultimo"></span></h3>
                    <?php if ($rLegal->rowCount() > 0) { ?>
                        <table style="font-size:small;" data-role="table" class="ui-responsive table-stroke">
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
                                    <td><?php $a_sta = '';
                                        if ($legal['a_sta'] == 1) $a_sta = ' (APTO)';
                                        if ($legal['a_sta'] == 2) $a_sta = ' (OBSERVADO)';
                                        if ($legal['a_sta'] == 3) $a_sta = ' (NO APTO)'; ?>
                                        <a href='<?php echo "legal/" . $legal['id'] . "_" . $legal['a_dni'] . ".pdf"; ?>'
                                           target="new">Ver/Descargar</a>
                                        <?php echo $a_sta; ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($legal['a_fec'])); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <script>
                            $(function () {
                                $("#ultimo").html("<?php echo $a_sta; ?>");
                            });</script>
                    <?php } else echo "<h5>No hay Documentos</h5>"; ?>
                </div>
            </div> <!-- close collapse 1 -->
            <?php if ($user['role'] == 1) { ?>
                <input type="Submit" value="GUARDAR DATOS" name="boton_datos" data-icon="check" data-iconpos="left"
                       data-mini="true" class="show-page-loading-msg" data-textonly="false" data-textvisible="true"
                       data-msgtext="Agregando datos.." data-theme="b" data-inline="true"/>
            <?php } ?>
        </div> <!-- /content -->

    </div><!-- /page -->
    <?php } ?>
</form>
<script>
    $(document).on("click", ".show-page-loading-msg", function () {
        if (document.getElementById("nom").value == "") {
            alert("Debe llenar el campo 'Nombre'");
            return false;
        }
        if (document.getElementById("ape").value == "") {
            alert("Debe llenar el campo 'Apellidos'");
            return false;
        }

        if ($('#m_inf').prop('checked')) {

            if (document.getElementById("m_inf1").value == "") {
                alert("Debe especificar la Infección");
                return false;
            }
        }

        if (document.getElementById("m_ale").value == "Medicamentada" || document.getElementById("m_ale").value == "Otra") {

            if (document.getElementById("m_ale1").value == "") {
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
        $("#alerta").prependTo(".ui-content");
        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>

</script>
</body>
</html>
