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
        .color2 {
            color: #72a2aa;
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

        .peke .ui-input-text {
            width: 140px !important;

        }

        .peke2 .ui-input-text {
            width: 30px !important;
        }

        .peke2 span {
            float: left;
        }

        .ui-slider-track {
            margin-left: 15px;
        }

        .enlinea div {
            display: inline-block;
            /* width   : 12% !important;*/
            vertical-align: top;
        }
    </style>
</head>

<body>


<script>
    $(document).ready(function () {

        $("#p_iiu").change(function () {
            if ($(this).prop('checked')) {
                $('#p_fiv,#p_icsi,#p_cri,#p_don,#p_od,#p_des').val("");
                $('#p_fiv,#p_icsi,#p_cri,#p_don').checkboxradio("disable");
                $('#p_od,#p_des').selectmenu("disable");
            } else {
                $('#p_fiv,#p_icsi,#p_cri,#p_don').checkboxradio("enable");
                $('#p_od,#p_des').selectmenu("enable");
            }
        });

        $('#donante-button').hide();
        $("#p_des").change(function () {
            $('#donante-button').hide();
            $('#p_fiv,#p_icsi,#p_cri,#p_don,#p_iiu').checkboxradio("enable");
            $('#p_od').selectmenu("enable");
            $(".lista_des2").remove();

            if ($(this).val() == 1 || $(this).val() == 3) { //embriones
                $('#p_fiv,#p_icsi,#p_cri,#p_don,#p_iiu,#p_od').val("");
                $('#p_fiv,#p_icsi,#p_cri,#p_don,#p_iiu').checkboxradio("disable");
                $('#p_od').selectmenu("disable");
            }
            if ($(this).val() == 2 || $(this).val() == 4) { //ovulos
                $('#p_cri,#p_don,#p_iiu,#p_od').val("");
                $('#p_cri,#p_don,#p_iiu').checkboxradio("disable");
                $('#p_od').selectmenu("disable");
            }
            if ($(this).val() == 1 || $(this).val() == 2) { //ovulos/embriones donados
                $('#donante-button').show();
                $('#donante').val('');
                $('#donante').prop('selectedIndex', 0);
                $('#donante').selectmenu("refresh", true);
            }
            if ($(this).val() == 3 || $(this).val() == 4) { //ovulos/embriones propios
                var h = $(this).val();
                var dni = $("#dni").val();
                $('.lista_des').html('<h3>CARGANDO DATOS...</h3>');
                $.post("le_tanque.php", {h: h, dni: dni, paci: dni, btn_guarda: 1}, function (data) {
                    $('.lista_des').html('');
                    $(".lista_des").append('<div class="lista_des2">' + data + '</div>');
                    $('.ui-page').trigger('create'); // ------ recarga los css del jqm ----------------------------
                });
            }
        });
        $("#donante").change(function () {
            if ($(this).val() != '') {
                $(".lista_des2").remove();
                var h = $("#p_des").val();
                var dni = $(this).val();
                var paci = $("#dni").val();
                $('.lista_des').html('<h3>CARGANDO DATOS...</h3>');
                $.post("le_tanque.php", {h: h, dni: dni, paci: paci, btn_guarda: 1}, function (data) {
                    $('.lista_des').html('');
                    $(".lista_des").append('<div class="lista_des2">' + data + '</div>');
                    $('.ui-page').trigger('create'); // ------ recarga los css del jqm ----------------------------
                });
            }
        });

    });

    var descon = 0;
    var conta = 0;
    $(document).on('change', '.deschk', function (ev) {

        $("#des_dia").val($(this).attr("id")); // Esto define el dia de descongelacion segun el ultimo check q se presiono
        /* SE QUITA ESTE SCRIPT PARA QUE PERMITA SELECCIONAR CUALQUIER DIA DE DESCONGELACION
        if (descon == $(this).attr("id") || descon==0) {
            conta++;
            descon = $(this).attr("id");

            if (conta==1) {
               // var arr = descon.split('|');
               // $("#des_tip").val(arr[0]);
                $("#des_dia").val(descon);
            }

        } else {
            $('.deschk').attr('checked', false);
            descon = $(this).attr("id");
            conta = 0;
            $("#des_dia").val('');
        }
*/

    });

    function anular(x) {
        if (confirm("Esta apunto de eliminar esta Reproducción asistida, esta seguro?")) {
            document.form2.borrar.value = x;
            document.form2.submit();
        }
        else
            return false;
    }

    function Beta(beta, pro) {
        document.form2.val_beta.value = beta.value;
        document.form2.pro_beta.value = pro;
        document.form2.submit();
    }
</script>
<?php if ($_POST['borrar'] <> "") {
    $stmt = $db->prepare("DELETE FROM hc_reprod WHERE id=?");
    $stmt->execute(array($_POST['borrar']));
}

if ($_POST['val_beta'] <> "" and $_POST['pro_beta'] <> "") {
    $stmt = $db->prepare("UPDATE lab_aspira_T SET beta=? WHERE pro=?");
    $stmt->execute(array($_POST['val_beta'], $_POST['pro_beta']));
    echo "<div id='alerta'> BETA Guardado! </div>";
}

$fec = date("Y-m-d");
if (isSet($_POST['dni']) && $_POST['boton_datos'] == "GUARDAR DATOS") {

    if ($_POST['cont'] >= 1) {
        for ($p = 1; $p <= $_POST['cont']; $p++) {
            $tan = explode("|", $_POST['c' . $p]);
            $stmt2 = $db->prepare("UPDATE lab_aspira_dias SET adju=? WHERE pro=? AND ovo=?");
            $stmt2->execute(array($_POST['adju' . $p], $tan[0], $tan[1])); // Adjudica el dni de la paciente al ovo/embrion
        }
    }

    if ($_POST['p_dni'] == "1") $_POST['p_dni'] = ""; // soltera con p_dni vacio

    insertRepro($_POST['dni'], $_POST['p_dni'], $fec, $login, $_POST['fnac'], $_POST['p_cic'], $_POST['p_fiv'], $_POST['p_icsi'], $_POST['des_dia'], $_POST['des_don'], $_POST['p_od'], $_POST['p_don'], $_POST['p_cri'], $_POST['p_iiu'], $_POST['t_mue'], $_POST['obs']);

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

$rPaci = $db->prepare("SELECT hc_paciente.dni,nom,ape,fnac,g_fur,don,nota FROM hc_antece,hc_paciente WHERE hc_paciente.dni=? AND hc_antece.dni=?");
$rPaci->execute(array($id, $id));
$paci = $rPaci->fetch(PDO::FETCH_ASSOC);

$rRepro = $db->prepare("SELECT id,fec,p_dni,p_dni_het,des_dia,des_don,p_cic,p_fiv,p_icsi,p_od,p_don,p_cri,p_iiu,don_todo,f_iny,cancela,f_asp FROM hc_reprod WHERE dni=? ORDER BY fec DESC");
$rRepro->execute(array($id));

$rPP = $db->prepare("SELECT p_dni FROM hc_pare_paci WHERE dni=? ORDER BY p_fec DESC");
$rPP->execute(array($id));

if (!file_exists("paci/" . $paci['dni'] . "/foto.jpg")) $foto_url = "_images/foto.gif"; else $foto_url = "paci/" . $paci['dni'] . "/foto.jpg?v=" . mt_rand(); ?>
<form action="n_repro.php?id=<?php echo $paci['dni']; ?>" method="post" data-ajax="false" name="form2">
    <div data-role="page" class="ui-responsive-panel" id="n_repro">
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
                <li data-theme="b"><a href="<?php echo "n_gine.php?id=" . $paci['dni']; ?>" rel="external">Ginecología</a>
                </li>
                <li data-theme="b"><a href="<?php echo "n_obst.php?id=" . $paci['dni']; ?>" rel="external">Obstetricia</a>
                </li>
                <li data-theme="b" class="ui-disabled"><a href="<?php echo "n_repro.php?id=" . $paci['dni']; ?>"
                                                          rel="external">Repro. Asistida</a></li>
                <li data-icon="info"><a href="ayuda.php" rel="external">Ayuda</a></li>
            </ul>
        </div><!-- /panel -->

        <div data-role="header" data-position="fixed">
            <a href="#indice_paci" data-icon="bars" id="b_indice" class="ui-icon-alt" data-theme="a">MENU
                <small>> Repro. Asistida</small>
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


            <input type="hidden" name="dni" id="dni" value="<?php echo $paci['dni']; ?>">
            <input type="hidden" name="fnac" value="<?php echo $edad; ?>">
            <input type="hidden" name="borrar">
            <input type="hidden" name="val_beta"> <input type="hidden" name="pro_beta">
            <div data-role="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#one" data-ajax="false" class="ui-btn-active ui-btn-icon-left ui-icon-bullets">Repro.
                                Asistidas</a></li>
                        <li><a href="#two" data-ajax="false" class="ui-btn-icon-left ui-icon-edit">Nueva Repro.
                                Asistida</a></li>
                    </ul>
                </div>
                <div id="one">

                    <?php if ($rRepro->rowCount() > 0) { ?>
                        <table data-role="table" class="table-stroke ui-responsive">
                            <thead>
                            <tr>
                                <th>FECHA</th>
                                <?php if ($paci['don'] == 'D') echo '<th>RECEPTORA</th>'; else echo '<th>PAREJA</th>'; ?>
                                <th>PROCEDIMIENTO</th>
                                <th>TRANSFER BETA</th>
                                <th>CRIO</th>
                                <th>ESTADO</th>
                                <th>INFORME</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $crio = 0;
                            while ($repro = $rRepro->fetch(PDO::FETCH_ASSOC)) {
                                if ($paci['don'] == 'D') $pareja = ''; else {
                                    $rPare2 = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
                                    $rPare2->execute(array($repro['p_dni']));
                                    $pare2 = $rPare2->fetch(PDO::FETCH_ASSOC);
                                    if ($repro['p_dni'] == "") $pareja = "SOLTERA"; else $pareja = $pare2['p_ape'] . " " . $pare2['p_nom'];
                                }
                                if ($repro['cancela'] == 1) {
                                    $estado = 'Cancelado';
                                    $informe = '-';
                                } else if ($repro['cancela'] == 2) {
                                    $estado = 'Trasladado';
                                    $rAspi = $db->prepare("SELECT pro FROM lab_aspira WHERE lab_aspira.rep=?");
                                    $rAspi->execute(array($repro['id']));
                                    $aspi = $rAspi->fetch(PDO::FETCH_ASSOC);
                                    $informe = '<a href="emb_pic/traslado_' . $aspi['pro'] . '.pdf" target="new">Ver</a>';
                                } else {
                                    if ($repro['p_iiu'] >= 1) {
                                        $Rcap = $db->prepare("SELECT * FROM lab_andro_cap WHERE iiu=?");
                                        $Rcap->execute(array($repro['id']));
                                        $cap = $Rcap->fetch(PDO::FETCH_ASSOC);
                                        if ($cap['emb'] == 0) $estado = 'En Proceso <a href="javascript:anular(' . $repro["id"] . ');">(Eliminar)</a>'; else {
                                            $estado = 'Finalizado';
                                            $informe = '<a href="info.php?T=cap&a=' . $cap['p_dni'] . '&b=' . $cap['id'] . '&c=' . $paci['dni'] . '" target="new">Ver</a>';
                                        }

                                    } else {
                                        $rAspi = $db->prepare("SELECT pro,f_fin,dias,fec2,fec3,fec4,fec5,fec6 FROM lab_aspira WHERE lab_aspira.rep=?");
                                        $rAspi->execute(array($repro['id']));
                                        $aspi = $rAspi->fetch(PDO::FETCH_ASSOC);

                                        $rTran = $db->prepare("SELECT dia,beta FROM lab_aspira_T WHERE pro=?");
                                        $rTran->execute(array($aspi['pro']));

                                        if ($aspi['f_fin'] == "0000-00-00") $estado = 'En Laboratorio';
                                        if ($aspi['f_fin'] and $aspi['f_fin'] <> "0000-00-00") $estado = 'Finalizado <i class="color2">' . date("d-m-Y", strtotime($aspi['f_fin'])) . '</i>';
                                        if ($repro['don_todo'] == 1) $estado = 'Finalizado <i class="color2">' . date("d-m-Y", strtotime($repro['f_iny'])) . '</i>';
                                        if (!$aspi['f_fin'] and $repro['don_todo'] <> 1) $estado = 'En Proceso <a href="javascript:anular(' . $repro["id"] . ');">(Eliminar)</a>';

                                        if ($repro['don_todo'] == 1) $informe = 'Se donó Todo';
                                        else if ($aspi['pro'] > 0) {
                                            $informe = '<a href="e_repro_info.php?a=' . $aspi['pro'] . '&b=' . $id . '&c=' . $repro['id'] . '" rel="external">Editar</a> - <a href="info_rm.php?a=' . $aspi['pro'] . '&b=' . $id . '&c=' . $repro['p_dni'] . '" target="new">Ver</a>';
                                            if (file_exists("emb_pic/embryoscope_" . $aspi['pro'] . ".mp4"))
                                                $informe .= "<br><a href='emb_pic/embryoscope_" . $aspi['pro'] . ".mp4' target='new'>Embryoscope Video</a>";
                                            if (file_exists("emb_pic/embryoscope_" . $aspi['pro'] . ".pdf"))
                                                $informe .= "<br><a href='emb_pic/embryoscope_" . $aspi['pro'] . ".pdf' target='new'>Embryoscope Pdf</a>";
                                            if (file_exists("analisis/ngs_" . $aspi['pro'] . ".pdf"))
                                                $informe .= "<br><a href='analisis/ngs_" . $aspi['pro'] . ".pdf' target='new'>NGS</a>";

                                            if ($paci['don'] == 'D') {
                                                $rRecep = $db->prepare("SELECT DISTINCT hc_paciente.dni,hc_paciente.nom,hc_paciente.ape FROM hc_paciente,lab_aspira,lab_aspira_dias WHERE lab_aspira.pro=lab_aspira_dias.pro AND lab_aspira.dni=hc_paciente.dni AND pro_c=?");
                                                $rRecep->execute(array($aspi['pro']));
                                                if ($rRecep->rowCount() > 0) {
                                                    $pareja = '';
                                                    while ($recep = $rRecep->fetch(PDO::FETCH_ASSOC)) {
                                                        $pareja .= "<a href='n_repro.php?id=" . $recep['dni'] . "' target='new'>" . $recep['ape'] . " " . $recep['nom'] . "</a><br>";
                                                    }
                                                }
                                                if ($repro['p_don'] == 1) {
                                                    $rRecep = $db->prepare("SELECT hc_paciente.nom,hc_paciente.ape,hc_paciente.dni FROM hc_reprod,hc_paciente WHERE hc_reprod.p_od=? AND (hc_reprod.f_asp=? OR hc_reprod.f_asp='') AND hc_paciente.dni=hc_reprod.dni");
                                                    $rRecep->execute(array($paci['dni'], $repro['f_asp']));
                                                    if ($rRecep->rowCount() > 0) {
                                                        while ($recep = $rRecep->fetch(PDO::FETCH_ASSOC)) {
                                                            $pareja .= "<a href='n_repro.php?id=" . $recep['dni'] . "' target='new'>" . $recep['ape'] . " " . $recep['nom'] . "</a><br>";
                                                        }
                                                    }
                                                }
                                            }

                                        } else $informe = '-';
                                    }
                                }

                                $rCrio = $db->prepare("SELECT lab_aspira_dias.pro FROM hc_reprod,lab_aspira,lab_aspira_dias WHERE hc_reprod.id=lab_aspira.rep AND lab_aspira_dias.pro=lab_aspira.pro AND hc_reprod.id=? AND (lab_aspira_dias.d6f_cic='C' OR lab_aspira_dias.d5f_cic='C' OR lab_aspira_dias.d4f_cic='C' OR lab_aspira_dias.d3f_cic='C' OR lab_aspira_dias.d2f_cic='C' OR lab_aspira_dias.d0f_cic='C')");
                                $rCrio->execute(array($repro['id'])); ?>
                                <tr>
                                    <th><?php if ($repro['cancela'] == 2) echo date("d-m-Y", strtotime($repro['fec'])); else { ?>
                                            <a href='<?php echo "e_repro.php?id=" . $repro['id']; ?>'
                                               rel="external"><?php echo date("d-m-Y", strtotime($repro['fec'])); ?></a><?php } ?>
                                    </th>
                                    <td><?php echo '<small>' . $pareja . '</small>';
                                        if ($repro['p_dni_het'] <> "") echo " (HETEROLOGO)"; ?></td>
                                    <td><?php if ($repro['p_cic'] >= 1) echo "Ciclo Natural<br>";
                                        if ($repro['p_fiv'] >= 1) echo "FIV<br>";
                                        if ($repro['p_icsi'] >= 1) echo "ICSI<br>";
                                        if ($repro['p_od'] <> '') echo "OD Fresco<br>";
                                        if ($repro['p_cri'] >= 1) echo "Crio Ovulos<br>";
                                        if ($repro['p_iiu'] >= 1) echo "IIU<br>";
                                        if ($repro['p_don'] == 1) echo "Donación Fresco<br>";
                                        if ($repro['des_don'] == null and $repro['des_dia'] >= 1) echo "TED<br>";
                                        if ($repro['des_don'] == null and $repro['des_dia'] === 0) echo "<small>Descongelación Ovulos Propios</small><br>";
                                        if ($repro['des_don'] <> null and $repro['des_dia'] >= 1) echo "EMBRIOADOPCIÓN<br>";
                                        if ($repro['des_don'] <> null and $repro['des_dia'] === 0 and $repro['id']<>2192) echo "<small>Descongelación Ovulos Donados</small><br>"; ?></td>
                                    <td class="enlinea"><?php if ($rTran) {
                                            if ($rTran->rowCount() > 0) {
                                                $tra = $rTran->fetch(PDO::FETCH_ASSOC);
                                                $beta = $aspi['fec' . $tra['dia']]; //la fecha del dia de transferencia
                                                if ($tra['dia'] == 2) $dt = 15;
                                                if ($tra['dia'] == 3) $dt = 14;
                                                if ($tra['dia'] == 4) $dt = 13;
                                                if ($tra['dia'] == 5) $dt = 12;
                                                if ($tra['dia'] == 6) $dt = 11;
                                                $beta = date('d-m-Y', strtotime($beta . ' + ' . $dt . ' days')); ?>
                                                <select name="beta<?php echo $aspi['pro']; ?>" data-mini="true"
                                                        onChange="Beta(this,<?php echo $aspi['pro']; ?>)">
                                                    <option value=0 <?php if ($tra['beta'] == 0) echo 'selected'; ?>>
                                                        Pendiente
                                                    </option>
                                                    <option value=1 <?php if ($tra['beta'] == 1) echo 'selected'; ?>>
                                                        Positivo
                                                    </option>
                                                    <option value=2 <?php if ($tra['beta'] == 2) echo 'selected'; ?>>
                                                        Negativo
                                                    </option>
                                                    <option value=3 <?php if ($tra['beta'] == 3) echo 'selected'; ?>>
                                                        Bioquimico
                                                    </option>
                                                    <option value=4 <?php if ($tra['beta'] == 4) echo 'selected'; ?>>
                                                        Aborto
                                                    </option>
                                                </select>
                                                <?php echo '<i class="color2">' . $beta . '</i>';
                                            } else echo '-';
                                        } ?></td>
                                    <td><?php if ($rCrio->rowCount() > 0) {
                                            echo 'Si';
                                            $crio++;
                                        } else echo '-'; ?></td>
                                    <td><?php echo $estado; ?></td>
                                    <td><?php echo $informe; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo '<p><h3>¡ No tiene Reproducciones Asistidas !</h3></p>';
                    } ?>
                    <p>
                    <table width="100%" cellpadding="5"
                           style="text-align:center;font-size: small;border-collapse: collapse;border: 1px solid #72a2aa;">
                        <tr>
                            <th colspan="8"><a href="n_adju.php?id=<?php echo $id; ?>"
                                               class="ui-btn ui-mini ui-btn-inline" data-theme="a" rel="external">RESERVA
                                    DE OVULOS Y EMBRIONES</a></th>
                        </tr>

                        <?php $rAdju = $db->prepare("SELECT lab_aspira.dni,lab_aspira.fec,lab_aspira_dias.* FROM lab_aspira,lab_aspira_dias WHERE lab_aspira.pro=lab_aspira_dias.pro AND adju=? ORDER BY ABS(lab_aspira_dias.pro) ASC");
                        $rAdju->execute(array($id));
                        if ($rAdju->rowCount() > 0) {
                            $pro_adju = '';

                            while ($adj = $rAdju->fetch(PDO::FETCH_ASSOC)) {
                                if ($pro_adju <> $adj['pro']) {
                                    if ($adj['d0f_cic'] == 'C') $ovo_emb = 'Ovulos'; else $ovo_emb = 'Embriones';
                                    if ($adj['dni'] == $adj['adju']) $propios = ' (PROPIOS)'; else $propios = ' (DONADOS)';
                                    echo '<tr class="ui-bar-b"><th colspan="8">Protocolo: ' . $adj['pro'] . ' (' . date("d-m-Y", strtotime($adj['fec'])) . ') <a href="info_r.php?a=' . $adj['pro'] . '&b=' . $adj['dni'] . '&c=" target="new">Ver Informe</a>' . $propios . '</th></tr>';
                                    echo '<tr><th>ID ' . $ovo_emb . ' Reservados</th><th>DIA 2</th><th>DIA 3</th><th>DIA 4</th><th>DIA 5</th><th>DIA 6</th><th>NGS</th><th>Estado</th></tr>';
                                }
                                echo '<tr><td>' . $adj['ovo'] . '</td>';

                                if ($adj['d2f_cic'] <> '') {
                                    echo '<td>' . $adj['d2cel'] . '-' . $adj['d2fra'] . '%-' . $adj['d2sim'] . '</td>';
                                } else echo '<td>-</td>';
                                if ($adj['d3f_cic'] <> '') {
                                    echo '<td>' . $adj['d3cel'] . '-' . $adj['d3fra'] . '%-' . $adj['d3sim'] . '</td>';
                                } else echo '<td>-</td>';
                                if ($adj['d4f_cic'] <> '') {
                                    echo '<td>' . $adj['d4cel'] . '-' . $adj['d4fra'] . '%-' . $adj['d4sim'] . '</td>';
                                } else echo '<td>-</td>';
                                if ($adj['d5f_cic'] <> '') {
                                    echo '<td>' . $adj['d5cel'] . '</td>';
                                } else echo '<td>-</td>';
                                if ($adj['d6f_cic'] <> '') {
                                    echo '<td>' . $adj['d6cel'] . '</td>';
                                } else echo '<td>-</td>';
                                $ngs = '-';
                                if ($adj['ngs1'] == 1) $ngs = 'Normal';
                                if ($adj['ngs1'] == 2) $ngs = 'Anormal';
                                if ($adj['ngs1'] == 3) $ngs = 'NR';
                                echo '<td>' . $ngs . '</td>';

                                if ($adj['des'] == '') $esta = 'Criopreservado'; else $esta = 'Descongelado';
                                echo '<td>' . $esta . '</td>';
                                $pro_adju = $adj['pro'];
                            }

                        } ?>
                    </table>
                    </p>
                </div>
                <div id="two">
                    <div class="enlinea">
                        <p class="peke">
                        <h3>Pareja:</h3><select name="p_dni" id="p_dni" data-mini="true" data-inline="true">
                            <option value="">Seleccione Pareja</option>
                            <?php while ($pp = $rPP->fetch(PDO::FETCH_ASSOC)) {
                                $rPare = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
                                $rPare->execute(array($pp['p_dni']));
                                $pare = $rPare->fetch(PDO::FETCH_ASSOC);

                                echo "<option value=" . $pp['p_dni'] . ">" . $pare['p_ape'] . " " . $pare['p_nom'] . "</option>";
                            } ?>
                            <option value="1">---SOLTERA---</option>
                        </select>
                        <select name="t_mue" id="t_mue" data-mini="true" data-inline="true">
                            <option value="">Tipo de Muestra</option>
                            <option value=1>Muestra: Fresca</option>
                            <option value=2>Muestra: Congelada</option>
                            <option value=3>No Aplica</option>
                        </select></p>
                        <h3>Procedimientos:</h3>
                        <input type="checkbox" name="p_cic" id="p_cic" data-mini="true" value=1><label
                                for="p_cic">C. Natural</label>
                        <input type="checkbox" name="p_fiv" id="p_fiv" data-mini="true" value=1><label
                                for="p_fiv">FIV</label>
                        <input type="checkbox" name="p_icsi" id="p_icsi" data-mini="true" value=1><label
                                for="p_icsi">ICSI</label>
                        <input type="checkbox" name="p_cri" id="p_cri" data-mini="true" value=1><label
                                for="p_cri">Crio Ovos</label>
                        <input type="checkbox" name="p_iiu" id="p_iiu" data-mini="true" value=1><label
                                for="p_iiu">IIU</label>
                        <?php if ($paci['don'] == 'D') { ?>
                            <input type="checkbox" name="p_don" id="p_don" data-mini="true" value=1>
                            <label for="p_don">Donación Fresco</label>
                        <?php } else { // si es paciente puede ser receptora ---------
                        $rDon = $db->prepare("SELECT dni,nom,ape,don,med FROM hc_paciente WHERE don=? ORDER BY ape ASC");
                        $rDon->execute(array('D'));
                        $rDon->setFetchMode(PDO::FETCH_ASSOC);
                        $rows = $rDon->fetchAll(); ?>
                        <select name="p_od" id="p_od" data-mini="true">
                            <option value="">OD Fresco:</option>
                            <optgroup label="Seleccione la Donante:">
                                <?php foreach ($rows as $don) { ?>
                                    <option value="<?php echo $don['dni']; ?>"><?php echo 'OD Fresco: ' . $don['ape'] . ' ' . $don['nom'] . ' (' . $don['med'] . ')'; ?></option>
                                <?php } ?></optgroup>
                        </select>
                        <p>
                            <select name="p_des" id="p_des" data-mini="true">
                                <option value="" selected>Descongelación: NO</option>
                                <option value=1>Descongelación: EMBRIOADOPCIÓN</option>
                                <option value=2>Descongelación: ÓVULOS DONADOS</option>
                                <?php if ($crio > 0) { ?>
                                    <option value=3>Descongelación: TED</option>
                                    <option value=4>Descongelación: ÓVULOS PROPIOS</option>
                                <?php } ?></select>
                            <select name="donante" id="donante" data-mini="true">
                                <option value="">Seleccione Donante:</option>
                                <?php foreach ($rows as $don) { ?>
                                    <option value="<?php echo $don['dni']; ?>"><?php echo $don['ape'] . ' ' . $don['nom'] . ' (' . $don['med'] . ')'; ?></option>
                                <?php } ?></select>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="lista_des scroll_h">&nbsp;</div>

                    <?php if ($user['role'] == 1) { ?>
                        <input type="Submit" value="GUARDAR DATOS" name="boton_datos" data-icon="check"
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

        if (document.getElementById("p_dni").value == "") {
            alert("Debe ingresar la Pareja");
            return false;
        }
        if (document.getElementById("t_mue").value == "") {
            alert("Debe ingresar el tipo de Muestra");
            return false;
        }

        if (document.getElementById("p_des").value != "") {

            if (!document.getElementById("des_dia")) {
                alert("Debe marcar el Dia de Descongelación");
                return false;
            } else if (document.getElementById("des_dia").value == "") {
                alert("Debe marcar el Dia de Descongelación");
                return false;
            }

            /*if (confirm("Esta a punto de solicitar una Descongelación, esta seguro?"))
             return true;
             else
             return false;*/

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