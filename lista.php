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
        function PrintElem(elem) {
            var data = $(elem).html();
            var mywindow = window.open('', 'Imprimir', 'height=600,width=800');
            mywindow.document.write('<html><head><title>Imprimir</title>');
            mywindow.document.write('<style> @page {margin: 0px 0px 0px 5px;} table {border-collapse: collapse;font-size:10px;} .table-stripe td {border: 1px solid black;} .tablamas2 td {border: 1px solid white;} .mas2 {display: block !important;} .noVer, .ui-table-cell-label {display: none;} a:link {pointer-events: none; cursor: default;}</style>');
            mywindow.document.write('</head><body>');
            mywindow.document.write(data);
            mywindow.document.write('<script type="text/javascript">window.print();<' + '/script>');
            mywindow.document.write('</body></html>');
            return true;
        }
        $(document).ready(function () {
            $(".mas2").hide();
            $(".mas").click(function () {
                var mas = $(this).attr("data");
                $("#" + mas).toggle();
            });

            $('.ui-input-search').appendTo($('.enlinea'));

            $('#agenda_med').on('change', function () {
                if (this.value)
                    window.location.href = "agenda_frame.php?med=" + this.value;
                $(this).val('');
            });

            $('#med_agenda').on('change', function () {
                $(".marco_agenda").remove();
                if (this.value)
                    $(".td_agenda").append('<div class="marco_agenda"><h2>REVISE LA DISPONIBILDAD DEL MEDICO</h2><iframe src="agenda.php?med=' + this.value + '" width="100%" height="800" seamless></iframe></div>');
            });

            $(".ui-input-search input").attr("id", "paci_nom");
            $('.paci_insert').click(function (e) {
                $('#paci_nom').val($(this).text());
                $('#dni').val($(this).attr("dni"));
                $('#paci_nom').textinput('refresh');
                $('.fil_paci li').addClass('ui-screen-hidden');
                $('#paci_nom').focus();
                $('#med').val('');
                med = $(this).attr("med"); //nose se esta usando
            });

            $('#orden').click(function () {
                var table = $(this).parents('table').eq(0);
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
                this.asc = !this.asc;
                if (!this.asc) {
                    rows = rows.reverse()
                }
                for (var i = 0; i < rows.length; i++) {
                    table.append(rows[i])
                }
            })
            function comparer(index) {
                return function (a, b) {
                    var valA = getCellValue(a, index), valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                }
            }

            function getCellValue(row, index) {
                return $(row).children('td').eq(index).html()
            }

        });
        function anular(x, y) {
            if (confirm("CONFIRMA LA ANULACION DEL RECIBO: " + x + " ?")) {
                document.form1.anu_x.value = x;
                document.form1.anu_y.value = y;
                document.form1.submit();
                return true;
            } else return false;
        }
        function borrarNGS(x, y) {
            if (confirm("CONFIRMA ELIMINAR?")) {
                document.form1.anu_ngs.value = x;
                document.form1.dni_ngs.value = y;
                document.form1.submit();
                return true;
            } else return false;

        }
        var tableToExcel = (function () {
            var uri = 'data:application/vnd.ms-excel;base64,'
                ,
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                }
                , format = function (s, c) {
                    return s.replace(/{(\w+)}/g, function (m, p) {
                        return c[p];
                    })
                }
            return function (table, visita) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {worksheet: 'reporte_' + visita || 'reporte', table: table.innerHTML}
                window.location.href = uri + base64(format(template, ctx))
            }
        })()
    </script>
    <style>
        #alerta {
            background-color: #FF9;
            margin: 0 auto;
            text-align: center;
            padding: 4px;
        }

        .color {
            color: #F4062B !important;
        }

        .analisis .ui-btn {
            border-color: #E9A4A4 !important;
        }

        .enlinea div {
            display: inline-block;
            vertical-align: middle;
        }

        .controlgroup-textinput {
            padding-top: 0.5px;
            padding-bottom: 0.5px;
        }

        .scroll_h {
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
        }
    </style>
</head>

<body>
<div data-role="page" class="ui-responsive-panel" id="lista">
    <?php $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
    $rUser->execute(array($login));
    $user = $rUser->fetch(PDO::FETCH_ASSOC);

    if ($_POST['btn_consulta'] == "AGENDAR CONSULTA" and isSet($_POST['dni']) and isSet($_POST['fec']) and isSet($_POST['fec_h'])) {

        $rPaci = $db->prepare("SELECT med FROM hc_paciente WHERE dni=?");
        $rPaci->execute(array($_POST['dni']));
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);
        if (strpos($paci['med'], $_POST['med_agenda']) == false) { // si el medico NO esta en la lista de medicos, entonces lo agrega
            $stmt = $db->prepare("UPDATE hc_paciente SET med=? WHERE dni=?");
            $stmt->execute(array($_POST['med_agenda'] . ',' . $paci['med'], $_POST['dni']));
        }

        insertGine($_POST['dni'], $_POST['fec'], $_POST['med_agenda'], $_POST['fec_h'], $_POST['fec_m'], $_POST['mot'], $_POST['cupon']);

    } ?>

    <?php if ($user['role'] == 1) { ?>
        <div data-role="panel" id="indice_paci">
            <img src="_images/logo.jpg"/>
            <ul data-role="listview" data-inset="true" data-theme="a">
                <li data-icon="user"><a href="perfil.php" rel="external">Perfil</a></li>
                <li class="ui-disabled" data-icon="bars"><a href="lista.php" rel="external">Lista de Pacientes</a></li>
                <li data-icon="plus"><a href="n_paci.php" rel="external">Nuevo Paciente</a></li>
                <li data-icon="calendar"><a href="agenda_frame.php" rel="external">Agenda</a></li>
                <li data-icon="bullets"><a href="r_pap.php" rel="external">Reporte PAP</a></li>
                <li data-icon="bullets"><a href="r_parto.php" rel="external">Reporte Partos</a></li>
                <li data-icon="bullets"><a href="lista_pro_b.php?med=1" rel="external">Lista Betas</a></li>
                <li data-icon="info"><a href="ayuda.php" rel="external">Ayuda</a></li>

            </ul>
        </div><!-- /panel -->
    <?php } ?>

    <div data-role="header" data-position="fixed">
        <?php if ($user['role'] == 1) { ?>
            <a href="#indice_paci" data-icon="bars" id="b_indice" class="ui-icon-alt" data-theme="a">MENU</a>
        <?php } ?>
        <?php if ($user['role'] == 2) { ?>
            <div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
                <a href='lista_pro.php' class="ui-btn ui-mini ui-btn-inline" rel="external">PROCEDIMIENTOS</a>
                <a href='lista_and.php' class="ui-btn ui-mini ui-btn-inline" rel="external">ANDROLOGIA</a>
                <a href='agenda_frame.php' class="ui-btn ui-mini ui-btn-inline" rel="external">AGENDA</a>
                <a href="#popupBasic" data-rel="popup" class="ui-btn" data-transition="pop">ADMINISTRACION</a>
            </div>
            <div data-role="popup" id="popupBasic" data-arrow="true">
                <ul data-role="listview" data-inset="true">
                    <li><a href='lista_con.php' rel="external">Control de Calidad de Insumos</a></li>
                    <!--<li><a href='lista_tan.php' rel="external">Tanques</a></li>-->
                    <li><a href='pago_veri.php?x=x' rel="external">Ultimos 100 Procedimientos</a></li>
                    <li><a href='r_data.php' rel="external">DATA</a></li>
                    <li><a href='r_pro.php' rel="external">Reporte Procedimientos</a></li>
                    <li><a href='r_tanque.php' rel="external">Reporte tanque semen</a></li>
                    <li><a href='r_inv_ngs.php' rel="external">Investigacion NGS</a></li>
                    <li><a href='#' rel="external">Investigacion Plasma</a></li>
                    <li><a href='lista_emb.php' rel="external">Embriologos</a></li>
                    <li><a href='ayuda.php' rel="external">Ayuda</a></li>
                    <li><a href='r_gine.php' rel="external">Reporte Ginecología</a></li>
                    <li><a href='r_obste.php' rel="external">Reporte Obstetricia</a></li>
                    <li><a href='perfil.php' rel="external">Cambiar Contraseña</a></li>
                </ul>
            </div>
        <?php } ?>
        <?php if ($user['role'] == 3) { ?>
            <div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
                <a href="#popupBasic" data-rel="popup" class="ui-btn" data-transition="pop">NUEVO RECIBO</a>
                <a href="#popupBasic2" data-rel="popup" class="ui-btn" data-transition="pop">ADMINISTRACION</a>
            </div>
            <div data-role="popup" id="popupBasic" data-arrow="true">
                <ul data-role="listview" data-split-icon="gear" data-split-theme="a" data-inset="true">
                    <li><a href="pago.php?id=&t=&s=1" rel="external">Reproducción Asistida</a><a href="pago_ser.php?s=1"
                                                                                                 rel="external">admin</a>
                    </li>
                    <li><a href="pago.php?id=&t=&s=2" rel="external">Andrología</a><a href="pago_ser.php?s=2"
                                                                                      rel="external">admin</a></li>
                    <li><a href="pago.php?id=&t=&s=3" rel="external">Procedimientos Sala</a><a href="pago_ser.php?s=3"
                                                                                               rel="external">admin</a>
                    </li>
                    <li><a href="pago.php?id=&t=&s=4" rel="external">Analisis Sangre</a><a href="pago_ser.php?s=4"
                                                                                           rel="external">admin</a></li>
                    <li><a href="pago.php?id=&t=&s=5" rel="external">Perfiles</a><a href="pago_ser.php?s=5"
                                                                                    rel="external">admin</a></li>
                    <li><a href="pago.php?id=&t=&s=6" rel="external">Ecografía</a><a href="pago_ser.php?s=6"
                                                                                     rel="external">admin</a></li>
                    <li><a href="pago.php?id=&t=&s=7" rel="external">Adicionales</a><a href="pago_ser.php?s=7"
                                                                                       rel="external">admin</a></li>
                </ul>
            </div>
            <div data-role="popup" id="popupBasic2" data-arrow="true">
                <ul data-role="listview" data-inset="true">
                    <li><a href='n_pacipare.php' rel="external">Nuevo Paciente</a></li>
                    <li><a href='pago_veri.php?x=x' rel="external">Ultimos 100 Procedimientos</a></li>
                    <li><a href='r_tanque.php' rel="external">Reporte tanque semen</a></li>
                    <li><a href='traslado.php' rel="external">Traslados</a></li>
                    <li><a href='perfil.php' rel="external">Cambiar Contraseña</a></li>
                </ul>
            </div>
        <?php } ?>
        <?php if ($user['role'] == 6) { ?>
            <div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
                <a href='n_paci.php' class="ui-btn ui-mini ui-btn-inline" rel="external">Nuevo Paciente</a>
            </div>
        <?php }
        if ($user['role'] == 7) { ?>
            <a href="perfil.php" class="ui-btn ui-mini ui-btn-inline" rel="external">Perfil</a>
        <?php }
        if ($user['role'] == 8) { ?>
            <a href="e_analisis_tipo.php" class="ui-btn ui-mini ui-btn-inline" rel="external">Tipo de Documento</a>
        <?php } ?>
        <h1>
            <?php if ($user['role'] == 1) echo "Historia Clínica - Lista de Pacientes (" . $login . ")";
            if ($user['role'] == 2) echo "Laboratorio";
            if ($user['role'] == 3) echo "Facturación y Boletas";
            if ($user['role'] == 4 and $login <> 'eco') echo "Análisis Clínico (" . $login . ")";
            if ($user['role'] == 4 and $login == 'eco') echo "Ecografía";
            if ($user['role'] == 5) echo "Recepción";
            if ($user['role'] == 6) echo "Consultas Ginecológicas";
            if ($user['role'] == 7) echo "Consultas Urológicas (" . $login . ")";
            if ($user['role'] == 8) echo "Legal"; ?>
        </h1>

        <a href="index.php"
           class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power"
           rel="external">Salir</a>
    </div><!-- /header -->

    <div class="ui-content" role="main">
        <FORM ACTION="lista.php" method="post" data-ajax="false" name="form1" id="form1">

            <?php if ($user['role'] == 1) { // **************** MEDICOS ************************************************************************************
                $rPaci = $db->prepare("SELECT hc_paciente.dni,ape,nom,sta,don,san,m_ale,m_ets FROM hc_antece,hc_paciente WHERE hc_paciente.dni = hc_antece.dni AND hc_paciente.med LIKE ? ORDER BY ape,nom ASC");
                $rPaci->execute(array("%$login%"));

                $rAnal = $db->prepare("SELECT DISTINCT hc_analisis.a_dni,hc_analisis.a_nom FROM hc_analisis,hc_paciente WHERE hc_analisis.a_dni=hc_paciente.dni AND CAST(a_fec AS DATE) = CAST(CURRENT_TIMESTAMP AS DATE) AND  hc_analisis.a_med=?");
                $rAnal->execute(array($login));

                $rAnal_H = $db->prepare("SELECT DISTINCT hc_analisis.a_dni,hc_analisis.a_nom,hc_pare_paci.dni FROM hc_analisis,hc_pareja,hc_pare_paci WHERE hc_analisis.a_dni=hc_pareja.p_dni AND hc_pare_paci.p_dni=hc_pareja.p_dni AND CAST(a_fec AS DATE) = CAST(CURRENT_TIMESTAMP AS DATE) AND hc_analisis.a_med=?");
                $rAnal_H->execute(array($login));

                $rBeta = $db->prepare("SELECT beta FROM lab_aspira_T WHERE med=? AND beta=0");
                $rBeta->execute(array($login));

                if ($rAnal->rowCount() > 0 or $rAnal_H->rowCount() > 0 or $rBeta->rowCount() > 0) {
                    echo '<ul data-role="listview" data-theme="a" data-inset="true" class="analisis">';
                    if ($rAnal->rowCount() > 0 or $rAnal_H->rowCount() > 0)
                        echo '<li data-role="list-divider" style="background-color: #E9A4A4;">Resultados recientes de Análisis Clínicos y/o Ecografía</li>';
                    while ($anal = $rAnal->fetch(PDO::FETCH_ASSOC)) {

                        echo '<li><a href="e_paci.php?id=' . $anal['a_dni'] . '" rel="external"><small>' . $anal['a_nom'] . ' (' . $anal['a_dni'] . ')</small></a></li>';

                    }
                    while ($anal = $rAnal_H->fetch(PDO::FETCH_ASSOC)) {

                        echo '<li><a href="n_pare.php?id=' . $anal['dni'] . '" rel="external"><h4><small>' . $anal['a_nom'] . ' (' . $anal['a_dni'] . ')</small></h4> </a></li>';

                    }
                    if ($rBeta->rowCount() > 0) echo '<li data-role="list-divider" style="background-color: #FFFF91;"><a href="lista_pro_b.php?med=1" rel="external"><h4>BETAS PENDIENTES: ' . $rBeta->rowCount() . '</h4></a></li>';
                    echo '</ul>';
                } ?>
                <ol data-role="listview" data-theme="a" data-filter="true" data-filter-placeholder="Filtro..."
                    data-inset="true">
                    <?php while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { ?>
                        <li>
                            <a href='<?php echo "e_paci.php?id=" . $paci['dni']; ?>' rel="external">
                                <h4><?php echo $paci['ape']; ?>
                                    <small><?php echo $paci['nom'] . ' (' . $paci['dni'] . ')'; ?></small>
                                </h4>
                                <p>
                                    <?php
                                    if ($paci['sta'] <> "") echo '(' . $paci['sta'] . ')';
                                    if ($paci['m_ale'] == "Medicamentada") echo " <b>(ALERGIA MEDICAMENTADA) </b>";
                                    if (strpos($paci['san'], "-") !== false) echo " <b>(SANGRE NEGATIVA) </b>";
                                    if (strpos($paci['m_ets'], "VIH") !== false) echo " <b>(VIH) </b>";
                                    if (strpos($paci['m_ets'], "Hepatitis C") !== false) echo " <b>(Hepatitis C) </b>"; ?>
                                </p>
                            </a>
                            <?php if ($paci['don'] == "D") echo '<span class="ui-li-count">Donante</span>'; ?>
                        </li>

                    <?php }
                    if ($rPaci->rowCount() < 1) echo '<p><h3>¡ No hay Pacientes !</h3></p>'; ?>
                </ol>
            <?php }
            if ($user['role'] == 2 or $user['role'] == 5) { // ************ LAB Y AGENDA **********************************************************************
                if ($_POST['ini'] == "") $_POST['ini'] = date("Y-m-d");

                $rRepro = $db->prepare("SELECT SUBSTRING_INDEX(hc_reprod.f_asp,'T',-1) AS h_asp,h_tra,ape,nom,hc_reprod.id,hc_reprod.dni,hc_reprod.med,don,hc_reprod.p_dni,hc_reprod.t_mue,hc_reprod.n_fol,hc_reprod.p_dni_het,hc_reprod.p_od,hc_reprod.p_cic,hc_reprod.p_fiv,hc_reprod.p_icsi,hc_reprod.p_cri,hc_reprod.p_iiu,hc_reprod.p_don,hc_reprod.des_don,hc_reprod.des_dia,hc_reprod.obs,hc_reprod.p_extras FROM hc_paciente,hc_reprod WHERE hc_paciente.dni=hc_reprod.dni AND (SUBSTRING_INDEX(hc_reprod.f_asp,'T',1) = ? OR hc_reprod.f_tra=?) AND hc_reprod.cancela <> 1 UNION SELECT CONCAT(hc_gineco.in_h2,':',hc_gineco.in_m2) AS h_asp,NULL AS h_tra,ape,nom,hc_gineco.id,hc_gineco.dni,hc_gineco.med,hc_gineco.in_t AS don,NULL AS p_dni,'x' AS t_mue,'-' AS n_fol,NULL AS p_dni_het,NULL AS p_od,NULL AS p_cic,NULL AS p_fiv,NULL AS p_icsi,NULL AS p_cri,NULL AS p_iiu,NULL AS p_don,NULL AS des_don,NULL AS des_dia,NULL AS obs,NULL AS p_extras FROM hc_paciente,hc_gineco WHERE hc_paciente.dni=hc_gineco.dni AND hc_gineco.in_f2 = ? AND hc_gineco.in_c=1 UNION SELECT CONCAT(hc_urolo.in_h2,':',hc_urolo.in_m2) AS h_asp,NULL AS h_tra,hc_pareja.p_ape AS ape,hc_pareja.p_nom AS nom,hc_urolo.id,hc_urolo.p_dni AS dni,hc_urolo.med,hc_urolo.in_t AS don,NULL AS p_dni,'x' AS t_mue,'-' AS n_fol,NULL AS p_dni_het,NULL AS p_od,NULL AS p_cic,NULL AS p_fiv,NULL AS p_icsi,NULL AS p_cri,NULL AS p_iiu,NULL AS p_don,NULL AS des_don,NULL AS des_dia,NULL AS obs,NULL AS p_extras FROM hc_pareja,hc_urolo WHERE hc_pareja.p_dni=hc_urolo.p_dni AND hc_urolo.in_f2 = ?");
                $rRepro->execute(array($_POST['ini'], $_POST['ini'], $_POST['ini'], $_POST['ini']));
                $Rcap = $db->prepare("SELECT p_dni,iiu,pro,h_cap FROM lab_andro_cap WHERE fec=? AND iiu>0 ORDER BY fec DESC");// capacitacion con IIU
                $Rcap->execute(array($_POST['ini']));
                if ($user['role'] == 5) {
                    $rMed = $db->prepare("SELECT user FROM usuario WHERE role=1");
                    $rMed->execute();
                }
                ?>
                <div id="imprime">
                    <div class="enlinea">
                        <b>Fecha </b>
                        <input name="ini" type="date" id="ini" value="<?php echo $_POST['ini']; ?>" data-mini="true">
                        <input name="VER" type="Submit" id="VER" value="VER" data-inline="true" data-mini="true"
                               data-theme="b" class="noVer"/>
                        <a href="javascript:PrintElem('#imprime')" data-role="button" data-mini="true"
                           data-inline="true" rel="external" class="noVer">Imprimir</a>
                        <?php if ($user['role'] == 5) { ?>
                            <select name="agenda_med" id="agenda_med" data-mini="true"">
                            <option value="" selected>Agenda de Médico</option>
                            <?php while ($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $med['user']; ?>"><?php echo $med['user']; ?></option>
                            <?php } ?>
                            </select>
                        <?php } ?>
                        </div>
                    <?php if ($rRepro->rowCount() > 0) { ?>
                        <h3>Programación de Sala</h3>
                        <div class="scroll_h">
                            <table style="font-size:14px;width:100%;" class="table-stripe ui-responsive">
                                <thead>
                                <tr>
                                    <th align="center" id="orden">Hora</th>
                                    <th align="center">Paciente</th>
                                    <th align="center">Procedimientos</th>
                                    <th align="center">Muestra</th>
                                    <th align="center">Foliculos</th>
                                    <th align="center">Médico</th>
                                    <?php if ($user['role'] == 2) { ?>
                                        <th align="center">Extras Médico</th>
                                        <th align="center" class="noVer"></th><?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $id_pros=''; while ($rep = $rRepro->fetch(PDO::FETCH_ASSOC)) {
                                    if ($user['role'] == 2 or ($user['role'] == 5 and ($rep['p_od'] == '' or $rep['h_tra'] <> ''))) { ?>
                                        <tr <?php if ($rep['t_mue'] == 'x') echo 'bgcolor="#C2F7B8"'; // t_mue es X cuando la fila pertenece a hc_gineco o hc_urolo del union ?>>
                                            <td><?php if ($rep['h_asp'] <> '' and $rep['h_tra'] == '') echo $rep['h_asp'];
                                                if ($rep['h_tra'] <> '') echo $rep['h_tra']; ?></td>
                                            <td>
                                                <?php if ($user['role'] == 2) {
                                                    if ($rep['n_fol']=='-') $url="e_pare.php?id=&ip=".$rep['dni']; else $url="e_paci.php?id=".$rep['dni'];
                                                    ?>
                                                   <a href='<?php echo $url; ?>' target="_blank" rel="external">
                                                    <?php echo $rep['ape'] . ' ' . $rep['nom']; ?>
                                                   </a>
                                                    <?php if ($rep['don'] == 'D') echo ' (DONANTE)';
                                                    if ($rep['p_od'] <> '') echo ' (RECEPTORA)';
                                                } else {
                                                    echo $rep['ape'] . ' ' . $rep['nom'];
                                                } ?>
                                            </td>
                                            <td><?php  if ($rep['n_fol']<>'-') {
                                                    if ($rep['des_dia'] === 0 or $rep['des_dia'] >= 1) $dias = 9; else $dias = 0; // si es una descogelacion enlaza a le_aspi9.php -------
                                                    $url = "le_aspi" . $dias . ".php?rep=" . $rep['id'];
                                                    echo '<a href=' . $url . ' rel="external">';
                                                    if ($rep['p_cic'] >= 1) echo "Ciclo Natural<br>";
                                                    if ($rep['p_fiv'] >= 1) echo "FIV<br>";
                                                    if ($rep['p_icsi'] >= 1) echo "ICSI<br>";
                                                    if ($rep['p_od'] <> '') echo "OD Fresco<br>";
                                                    if ($rep['p_cri'] >= 1) echo "Crio Ovulos<br>";
                                                    if ($rep['p_iiu'] >= 1) echo "IIU<br>";
                                                    if ($rep['p_don'] == 1) echo "Donación Fresco<br>";
                                                    if ($rep['des_don'] == null and $rep['des_dia'] >= 1) echo "TED<br>";
                                                    if ($rep['des_don'] == null and $rep['des_dia'] === 0) echo "<small>Descongelación Ovulos Propios</small><br>";
                                                    if ($rep['des_don'] <> null and $rep['des_dia'] >= 1) echo "EMBRIOADOPCIÓN<br>";
                                                    if ($rep['des_don'] <> null and $rep['des_dia'] === 0) echo "<small>Descongelación Ovulos Donados</small><br>";
                                                    echo '</a>';
                                            }
                                                if ($rep['h_tra'] <> '') echo 'TRANSFERENCIA';
                                                if ($rep['don'] == "AMEU") echo "AMEU"; // En realidad es in_t pero usa el alias de don en el union
                                                if ($rep['don'] == "Legrado") echo "Legrado";
                                                if ($rep['don'] == "Ecografia y/o tacto vaginal") echo "Ecografia y/o tacto vaginal";
                                                if ($rep['don'] == "Biopsia endometrial") echo "Biopsia endometrial";
                                                if ($rep['don'] == "Histeroscopia diagnostica") echo "Histeroscopia diagnostica";
                                                if ($rep['don'] == "Resectoscopia (Histeroscopia Quirurgica)") echo "Resectoscopia (Histeroscopia Quirurgica)";
                                                if ($rep['don'] == "Cono Leep") echo "Cono Leep";
                                                if ($rep['don'] == "Labioplastia ambulatoria") echo "Labioplastia ambulatoria";
                                                if ($rep['don'] == "Electrofulguración de condilomas") echo "Electrofulguración de condilomas";
                                                if ($rep['don'] == "Biopsia testicular") echo "Biopsia testicular";
                                                if ($rep['don'] == "Aspiración de epidídimo") echo "Aspiración de epidídimo";
                                                ?></td>
                                            <td><?php $t_mue = 'No Aplica';
                                                if ($rep['t_mue'] == 1) $t_mue = 'Fresca';
                                                if ($rep['t_mue'] == 2) $t_mue = 'Congelada';
                                                echo $t_mue; ?></td>
                                            <td align="center"><?php echo $rep['n_fol']; ?></td>
                                            <td><?php echo $rep['med']; ?></td>
                                            <?php if ($user['role'] == 2) { ?>
                                                <td><?php echo $rep['p_extras']; ?></td>
                                                <td class="noVer"><small>
                                                    <?php if ($rep['obs'] <> '') { ?>
                                                        <a href="#obs<?php echo $rep['id']; ?>" data-rel="popup"
                                                           data-transition="pop">Obs</a>
                                                        <div data-role="popup" id="obs<?php echo $rep['id']; ?>"
                                                             class="ui-content" style="font-size:14px;">
                                                            <?php echo $rep['obs']; ?>
                                                        </div>
                                                    <?php } if ($rep['n_fol']<>'-') { $id_pros.=$rep['id'].'|'; ?>
                                                    <a href="info_ficha.php?id=<?php echo $rep['id']; ?>|&fec=<?php echo $_POST['ini']; ?>" target="new">Ficha</a>
                                                    <?php } ?>
                                                    </small></td>
                                            <?php } ?>
                                        </tr>

                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                            <a href="info_ficha.php?id=<?php echo $id_pros; ?>&fec=<?php echo $_POST['ini']; ?>" target="new" class="noVer ui-btn ui-mini ui-btn-inline">Imprimir Fichas de Laboratorio</a>
                        </div>
                    <?php } ?>
                    <?php if ($Rcap->rowCount() > 0) { ?>
                        <h3>Programación de Capacitaciones (IIU)</h3>
                        <div class="scroll_h">
                            <table style="font-size:14px;width:100%;" class="table-stripe ui-responsive">
                                <thead>
                                <tr>
                                    <th align="center" id="orden">Hora</th>
                                    <th align="center">Paciente</th>
                                    <th align="center">Pareja</th>
                                    <th align="center">Soltera</th>
                                    <th align="center">Médico</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $c = 0;
                                while ($cap = $Rcap->fetch(PDO::FETCH_ASSOC)) {
                                    $c++;
                                    $het = '';
                                    if ($cap['p_dni'] == "") {
                                        // if ($cap['iiu'] > 0) { // mujer soltera de iiu
                                        $rIIU = $db->prepare("SELECT dni,p_dni_het FROM hc_reprod WHERE id=?");
                                        $rIIU->execute(array($cap['iiu']));
                                        $iiu = $rIIU->fetch(PDO::FETCH_ASSOC);
                                        $dni = $iiu['dni'];
                                        $het = $iiu['p_dni_het'];
                                        // }
                                        if ($cap['pro'] <> "") { // mujer soltera de pro
                                            $rPRO = $db->prepare("SELECT dni FROM lab_aspira WHERE pro=?");
                                            $rPRO->execute(array($cap['pro']));
                                            $pro = $rPRO->fetch(PDO::FETCH_ASSOC);
                                            $dni = $pro['dni'];
                                        }
                                        $rPare = $db->prepare("SELECT nom AS p_nom,ape AS p_ape,med AS p_med FROM hc_paciente WHERE dni=?");
                                        $rPare->execute(array($dni));
                                        $pare = $rPare->fetch(PDO::FETCH_ASSOC);
                                    } else {
                                        // if ($cap['iiu'] > 0) { // mujer soltera de iiu
                                        $rIIU = $db->prepare("SELECT p_dni_het FROM hc_reprod WHERE id=?");
                                        $rIIU->execute(array($cap['iiu']));
                                        $iiu = $rIIU->fetch(PDO::FETCH_ASSOC);
                                        $het = $iiu['p_dni_het'];
                                        // }
                                        $rPare = $db->prepare("SELECT p_nom,p_ape,p_med FROM hc_pareja WHERE p_dni=?");
                                        $rPare->execute(array($cap['p_dni']));
                                        $pare = $rPare->fetch(PDO::FETCH_ASSOC);

                                        $rPaci = $db->prepare("SELECT dni FROM hc_pare_paci WHERE p_dni=?");
                                        $rPaci->execute(array($cap['p_dni']));
                                        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);
                                        $dni = $paci['dni'];

                                        $rMujer = $db->prepare("SELECT nom,ape FROM hc_paciente WHERE dni=?");
                                        $rMujer->execute(array($dni));
                                        $mujer = $rMujer->fetch(PDO::FETCH_ASSOC);
                                    } ?>
                                    <tr>
                                        <td><?php echo $cap['h_cap']; ?></td>
                                        <td class="mayuscula"><?php echo $pare['p_ape'] . ' <small>' . $pare['p_nom'] . '</small>'; ?></td>
                                        <td class="mayuscula"><?php if ($cap['p_dni'] == "") echo '-'; else {
                                                if ($dni == "") echo '-'; else echo $mujer['ape'] . ' <small>' . $mujer['nom'] . '</small>';
                                            } ?></td>
                                        <td><?php if ($cap['p_dni'] == "") echo "Si"; ?></td>
                                        <td><?php if ($pare['p_med'] <> "") echo $pare['p_med']; else echo 'Particular'; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            <?php }
            if ($user['role'] == 3) { // *********** PAGOS ****************************************************************************
                if ($_POST['anu_x'] <> "" and $_POST['anu_y'] <> "") {
                    $stmt = $db->prepare("UPDATE recibos SET anu=1 WHERE id=? AND tip=?");
                    $stmt->execute(array($_POST['anu_x'], $_POST['anu_y']));
                }
                if ($_POST['ini'] <> "" and $_POST['fin'] <> "" and $_POST['VER'] == "VER") {
                    $rRec = $db->prepare("SELECT * FROM recibos WHERE " . $_POST['t_pag'] . $_POST['t_ser'] . $_POST['med'] . " fec BETWEEN ? AND ? ORDER BY fec DESC,id DESC");
                    $rRec->execute(array($_POST['ini'], $_POST['fin']));
                } else if ($_GET['todo'] == 1) {
                    $rRec = $db->prepare("SELECT * FROM recibos ORDER BY fec DESC,id DESC");
                    $rRec->execute();
                } else {
                    $rRec = $db->prepare("SELECT * FROM recibos ORDER BY fec DESC,id DESC LIMIT 50");
                    $rRec->execute();
                }

                if ($rRec->rowCount() > 0) {
                    $rMed = $db->prepare("SELECT DISTINCT med FROM recibos");
                    $rMed->execute(); ?>
                    <input name="anu_x" type="hidden"> <input name="anu_y" type="hidden">
                    <input id="filtro" data-type="search" placeholder="Filtro..">
                    <div class="enlinea">
                        Ver Desde<input name="ini" type="date" required id="ini" value="<?php echo $_POST['ini']; ?>"
                                        data-mini="true">
                        Hasta<input name="fin" type="date" id="fin" value="<?php echo $_POST['fin']; ?>" data-mini="true">
                        <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                            <select name="t_pag" id="t_pag" data-mini="true">
                                <option value="" selected>Medio Pago(Todos)</option>
                                <option value="(t1=1 or t2=1 or t3=1) and" <?php if ($_POST['t_pag'] == "(t1=1 or t2=1 or t3=1) and") echo "selected"; ?>>
                                    EFECTIVO
                                </option>
                                <option value="(t1=2 or t2=2 or t3=2) and" <?php if ($_POST['t_pag'] == "(t1=2 or t2=2 or t3=2) and") echo "selected"; ?>>
                                    TARJETA
                                </option>
                                <option value="(t1=3 or t2=3 or t3=3) and" <?php if ($_POST['t_pag'] == "(t1=3 or t2=3 or t3=3) and") echo "selected"; ?>>
                                    DEPOSITO
                                </option>
                            </select>
                            <select name="t_ser" id="t_ser" data-mini="true">
                                <option value="" selected>Servicio(Todos)</option>
                                <option value=" t_ser=1 and" <?php if ($_POST['t_ser'] == " t_ser=1 and") echo "selected"; ?>>
                                    REPRODUCCION
                                </option>
                                <option value=" t_ser=2 and" <?php if ($_POST['t_ser'] == " t_ser=2 and") echo "selected"; ?>>
                                    ANDROLOGIA
                                </option>
                                <option value=" t_ser=3 and" <?php if ($_POST['t_ser'] == " t_ser=3 and") echo "selected"; ?>>
                                    PROCEDIMIENTOS
                                </option>
                                <option value=" t_ser=4 and" <?php if ($_POST['t_ser'] == " t_ser=4 and") echo "selected"; ?>>
                                    ANALISIS
                                </option>
                                <option value=" t_ser=5 and" <?php if ($_POST['t_ser'] == " t_ser=5 and") echo "selected"; ?>>
                                    PERFILES
                                </option>
                                <option value=" t_ser=6 and" <?php if ($_POST['t_ser'] == " t_ser=6 and") echo "selected"; ?>>
                                    ECOGRAFIA
                                </option>
                                <option value=" t_ser=7 and" <?php if ($_POST['t_ser'] == " t_ser=7 and") echo "selected"; ?>>
                                    ADICIONALES
                                </option>
                            </select>
                            <select name="med" id="med" data-mini="true">
                                <option value="" selected>Medico(Todos)</option>
                                <?php while ($med = $rMed->fetch(PDO::FETCH_ASSOC)) {
                                    $valmed = " med='" . $med['med'] . "' and"; ?>
                                    <option value="<?php echo $valmed; ?>" <?php if ($_POST['med'] == $valmed) echo "selected"; ?>><?php echo $med['med']; ?></option>
                                <?php } ?>
                            </select>
                            <input name="VER" type="Submit" id="VER" value="VER" data-inline="true" data-mini="true"
                                   data-theme="b"/>
                        </div>
                        <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                            <a href="lista.php?todo=1" rel="external"
                               class="ui-btn ui-corner-all ui-btn-inline ui-mini">Ver Todo</a>
                            <a href="javascript:PrintElem('#imprime')" data-role="button" data-mini="true"
                               data-inline="true" rel="external">Imprimir</a>
                            <a href="#" onclick="tableToExcel('dvData', 'pagos')" class="ui-btn ui-mini ui-btn-inline">Exportar</a>
                        </div>
                    </div>
                    <div id="imprime" class="scroll_h">
                        <table width="100%" data-filter="true" data-input="#filtro" class="table-stripe ui-responsive"
                               id="dvData" style="font-size: small;">
                            <thead>
                            <tr>
                                <th width="7%">Fecha</th>
                                <th width="5%">N° Recibo</th>
                                <th width="1%">Tipo</th>
                                <th width="25%">Nombre de Paciente</th>
                                <th width="10%">Medico</th>
                                <th width="20%">Tipo de Servicio</th>
                                <th width="7%">Total</th>
                                <th width="5%">T. Cambio</th>
                                <th width="5%">Medio Pago 1</th>
                                <th width="5%">Medio Pago 2</th>
                                <th width="5%">Medio Pago 3</th>
                                <th width="5%">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $tot_sol = 0;
                            $tot_dolar = 0;
                            while ($rec = $rRec->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr <?php if ($rec['anu'] == 1) echo 'bgcolor="#F9CCCD"'; ?>>
                                    <td><?php echo date("d-m-Y", strtotime($rec['fec'])); ?></td>
                                    <td>
                                        <?php if ($rec['tip'] == 1 or $rec['tip'] == 2) { ?>
                                            <a href='<?php echo "pago.php?id=" . $rec['id'] . "&t=" . $rec['tip'] . "&s=" . $rec['t_ser']; ?>'
                                               rel="external"><?php echo sprintf('%05d', $rec['id']); ?></a>
                                        <?php } else {
                                            echo sprintf('%05d', $rec['id']);
                                        } ?>
                                    </td>
                                    <td><?php if ($rec['tip'] == 1) echo "B";
                                        if ($rec['tip'] == 2) echo "F";
                                        if ($rec['tip'] == 3) echo "B Fisica";
                                        if ($rec['tip'] == 4) echo "F Fisica"; ?></td>
                                    <td><?php echo $rec['nom']; ?></td>
                                    <td><?php echo $rec['med']; ?></td>
                                    <td><a href="#" data="<?php echo $rec['id'] . "_" . $rec['tip']; ?>" class="mas">
                                            <?php if ($rec['t_ser'] == 1) echo 'Reproducción Asistida';
                                            if ($rec['t_ser'] == 2) echo 'Andrología';
                                            if ($rec['t_ser'] == 3) echo 'Procedimientos Sala';
                                            if ($rec['t_ser'] == 4) echo 'Analisis Sangre';
                                            if ($rec['t_ser'] == 5) echo 'Perfiles';
                                            if ($rec['t_ser'] == 6) echo 'Ecografía';
                                            if ($rec['t_ser'] == 7) echo 'Adicionales'; ?></a>
                                        <?php $anglo = '';
                                        if ($rec['anglo'] <> '') {
                                            if (strpos($rec['anglo'], "Correcto") === false)
                                                $anglo = '<font color="red">Error</font>';
                                            else $anglo = '<font color="green">Enviado</font>';
                                        }
                                        echo '<small>' . $anglo . '</small>'; ?>
                                        <div id="<?php echo $rec['id'] . "_" . $rec['tip']; ?>" class="mas2">
                                            <table style="font-size:10px; background-color:#FFFFFF;width:100%;"
                                                   class="tablamas2"><?php echo $rec['ser']; ?></table>
                                            <?php if ($rec['man_ini'] <> '0000-00-00') echo 'Inicio:' . date("d-m-Y", strtotime($rec['man_ini'])) . ' Fin:' . date("d-m-Y", strtotime($rec['man_fin'])); ?>
                                        </div>
                                    </td>
                                    <td><?php if ($rec['t_ser'] == 1 or $rec['t_ser'] == 2 or $rec['t_ser'] == 3) {
                                            if ($rec['mon'] == 1) echo "$ &nbsp&nbsp" . $rec['tot']; else echo "S/. " . $rec['tot'];
                                        } else {
                                            if ($rec['mon'] == 1) echo "S/. " . $rec['tot']; else echo "$ &nbsp&nbsp" . $rec['tot'];
                                        }
                                        ?></td>
                                    <td><?php if ($rec['mon'] > 1) echo $rec['mon']; else "-"; ?></td>
                                    <td><?php
                                        if ($rec['t1'] == 1) {
                                            echo 'Efectivo ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m1'] == 1) $dol1 = $dol1 + $rec['p1']; else $sol1 = $sol1 + $rec['p1'];
                                            }
                                        }
                                        if ($rec['t1'] == 2) {
                                            echo 'Tarjeta ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m1'] == 1) $dol2 = $dol2 + $rec['p1']; else $sol2 = $sol2 + $rec['p1'];
                                            }
                                        }
                                        if ($rec['t1'] == 3) {
                                            echo 'Deposito ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m1'] == 1) $dol3 = $dol3 + $rec['p1']; else $sol3 = $sol3 + $rec['p1'];
                                            }
                                        }
                                        if ($rec['m1'] == 1) echo '$'; else echo 'S/.';
                                        echo $rec['p1']; ?></td>
                                    <td><?php
                                        if ($rec['t2'] == 1) {
                                            echo 'Efectivo ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m2'] == 1) $dol1 = $dol1 + $rec['p2']; else $sol1 = $sol1 + $rec['p2'];
                                            }
                                        }
                                        if ($rec['t2'] == 2) {
                                            echo 'Tarjeta ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m2'] == 1) $dol2 = $dol2 + $rec['p2']; else $sol2 = $sol2 + $rec['p2'];
                                            }
                                        }
                                        if ($rec['t2'] == 3) {
                                            echo 'Deposito ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m2'] == 1) $dol3 = $dol3 + $rec['p2']; else $sol3 = $sol3 + $rec['p2'];
                                            }
                                        }
                                        if ($rec['m2'] == 1) echo '$'; else echo 'S/.';
                                        echo $rec['p2']; ?></td>
                                    <td><?php
                                        if ($rec['t3'] == 1) {
                                            echo 'Efectivo ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m3'] == 1) $dol1 = $dol1 + $rec['p3']; else $sol1 = $sol1 + $rec['p3'];
                                            }
                                        }
                                        if ($rec['t3'] == 2) {
                                            echo 'Tarjeta ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m3'] == 1) $dol2 = $dol2 + $rec['p3']; else $sol2 = $sol2 + $rec['p3'];
                                            }
                                        }
                                        if ($rec['t3'] == 3) {
                                            echo 'Deposito ';
                                            if ($rec['anu'] <> 1) {
                                                if ($rec['m3'] == 1) $dol3 = $dol3 + $rec['p3']; else $sol3 = $sol3 + $rec['p3'];
                                            }
                                        }
                                        if ($rec['m3'] == 1) echo '$'; else echo 'S/.';
                                        echo $rec['p3']; ?></td>
                                    <td style="font-size:10px">
                                        <a href='<?php echo "pago_imp.php?id=" . $rec['id'] . "&t=" . $rec['tip']; ?>'
                                           rel="external" class="noVer">Imprimir</a>
                                        <?php if ($rec['t_ser'] == 1) { ?><a
                                            href='<?php echo "pago_veri.php?id=" . $rec['id'] . "&t=" . $rec['tip']; ?>'
                                            rel="external" class="noVer">Verificar</a><?php } ?><br>
                                        <?php if ($rec['anu'] == 1) echo 'Anulado'; else { ?><a
                                            href="javascript:anular(<?php echo $rec['id'] . ',' . $rec['tip']; ?>);"
                                            class="noVer">Anular</a><?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr style="font-weight: bold;vertical-align:middle;">
                                <th></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2">TOTAL SOLES<br>Efectivo:&nbsp;<?php echo $sol1; ?><br>Tarjeta:&nbsp;&nbsp;&nbsp;<?php echo $sol2; ?>
                                    <br>Deposito:<?php echo $sol3; ?><br><?php echo $sol1 + $sol2 + $sol3; ?></td>
                                <td></td>
                                <td colspan="4">TOTAL DOLARES<br>Efectivo:&nbsp;<?php echo $dol1; ?><br>Tarjeta:&nbsp;&nbsp;&nbsp;<?php echo $dol2; ?>
                                    <br>Deposito:<?php echo $dol3; ?><br><?php echo $dol1 + $dol2 + $dol3; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } else {
                    echo '<p><h3>¡ No hay recibos !</h3></p>';
                } ?>

            <?php }
            if ($user['role'] == 4) { // ******* RESULTADOS LABORATORIOS ************************************************************
                if ($_POST['anu_ngs'] <> "" and $_POST['dni_ngs'] <> "") {
                    $stmt = $db->prepare("DELETE FROM hc_analisis WHERE id=?");
                    $stmt->execute(array($_POST['anu_ngs']));
                    unlink("analisis/" . $_POST['anu_ngs'] . "_" . $_POST['dni_ngs'] . ".pdf");
                }
                if ($_POST['ini'] <> "" and $_POST['fin'] <> "" and $_POST['Buscar'] == "Buscar") {
                    $rAnal = $db->prepare("SELECT * FROM hc_analisis WHERE lab=? AND a_mue BETWEEN ? AND ? ORDER BY a_mue DESC");
                    $rAnal->execute(array($login, $_POST['ini'], $_POST['fin']));
                } else {
                    $rAnal = $db->prepare("SELECT * FROM hc_analisis WHERE lab=? ORDER BY a_mue DESC");
                    $rAnal->execute(array($login));
                } ?>
                <input name="anu_ngs" type="hidden">
                <input name="dni_ngs" type="hidden">
                <?php if ($login <> 'genomics') { ?>
                    <div class="ui-bar ui-bar-a">
                        <table style="margin: 0 auto;" width="100%">
                            <tr>
                                <td width="57%">
                                    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                        <a href="e_analisis.php?id=" class="ui-btn ui-btn-inline" data-theme="a"
                                           rel="external">NUEVO <?php if ($login == 'eco') echo 'ECOGRAFIA'; else echo 'EXAMEN'; ?></a>
                                        <a href="e_analisis_tipo.php" class="ui-btn ui-btn-inline" data-theme="a"
                                           rel="external">AGREGAR
                                            TIPO <?php if ($login == 'eco') echo 'ECOGRAFIA'; else echo 'EXAMEN'; ?></a>
                                    </div>
                                </td>
                                <td width="10%">Mostrar Desde</td>
                                <td width="12%"><input name="ini" type="date" required id="ini"
                                                       value="<?php echo $_POST['ini']; ?>" data-mini="true"></td>
                                <td width="4%">Hasta</td>
                                <td width="12%"><input name="fin" type="date" required id="fin"
                                                       value="<?php echo $_POST['fin']; ?>" data-mini="true"></td>
                                <td width="5%"><input name="Buscar" type="Submit" id="Buscar" value="Buscar"
                                                      data-icon="search" data-iconpos="left" data-inline="true"
                                                      data-mini="true"/></td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
                <?php if ($login == 'genomics') { ?>
                    <div data-role="tabs" id="tabs">
                    <div data-role="navbar">
                        <ul>
                            <li><a href="#one" data-ajax="false" class="ui-btn-active">Otros</a></li>
                            <li><a href="#two" data-ajax="false">NGS</a></li>
                        </ul>
                    </div>
                <?php } ?>
                <div id="one">
                    <?php if ($rAnal->rowCount() > 0) { ?>

                        <?php if ($login == 'genomics') { ?>
                            <a href="e_analisis.php?id=" class="ui-btn ui-mini ui-btn-inline" data-theme="a"
                               rel="external">NUEVO EXAMEN</a>
                        <?php } ?>
                        <input id="filtro" data-type="search" placeholder="Filtro..">
                        <table data-role="table" data-filter="true" data-input="#filtro"
                               class="table-stripe ui-responsive">
                            <thead>
                            <tr>
                                <th><?php if ($login == 'eco') echo 'Ecografía'; else echo 'Exámen'; ?></th>
                                <th>Apellidos y Nombres</th>
                                <th>Médico</th>
                                <?php if ($login <> 'eco') echo '<th>Resultado</th>'; ?>
                                <th>Informe</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($anal = $rAnal->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <th><a href='<?php echo "e_analisis.php?id=" . $anal['id']; ?>'
                                           rel="external"><?php echo $anal['a_exa']; ?></a></th>
                                    <td><?php echo $anal['a_nom']; ?></td>
                                    <td><?php echo $anal['a_med']; ?></td>
                                    <?php if ($login <> 'eco') echo '<td>' . $anal['a_sta'] . '</td>'; ?>
                                    <th><a href='<?php echo "analisis/" . $anal['id'] . "_" . $anal['a_dni'] . ".pdf"; ?>'
                                           target="new">Ver/Descargar</a> <?php if ($anal['a_exa'] == 'NGS') { ?>- <a
                                                href="javascript:borrarNGS(<?php echo $anal['id'] . ',' . $anal['a_dni']; ?>);">
                                                Eliminar</a><?php } ?></th>
                                    <td><?php echo date("d-m-Y", strtotime($anal['a_mue'])); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo '<p><h3>¡ No hay Registros !</h3></p>';
                    } ?>
                </div>
                <?php if ($login == 'genomics') { ?>
                    <div id="two">
                        <?php $rNgs = $db->prepare("SELECT hc_paciente.dni,ape,nom,hc_reprod.med,lab_aspira.pro,lab_aspira.f_fin FROM hc_paciente,lab_aspira,hc_reprod WHERE hc_paciente.dni=lab_aspira.dni AND hc_reprod.id=lab_aspira.rep AND lab_aspira.f_fin<>'0000-00-00' AND lab_aspira.tip<>'T' AND hc_reprod.pago_extras LIKE '%NGS%' AND lab_aspira.dias>=5 ORDER BY ABS(pro) DESC");
                        $rNgs->execute();
                        if ($rNgs->rowCount() > 0) { ?>
                            <input id="filtrongs" data-type="search" placeholder="Filtro..">
                            <table data-role="table" data-filter="true" data-input="#filtrongs"
                                   class="table-stripe ui-responsive">
                                <thead>
                                <tr>
                                    <th>ID Protocolo</th>
                                    <th>Fecha Protocolo</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Médico</th>
                                    <th>Informe</th>
                                    <th>Resultado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($ngs = $rNgs->fetch(PDO::FETCH_ASSOC)) {
                                    $rOvo = $db->prepare("SELECT ngs1 FROM lab_aspira_dias WHERE pro=? AND ((d5d_bio=1 AND d5f_cic='C') OR (d6d_bio=1 AND d6f_cic='C'))");
                                    $rOvo->execute(array($ngs['pro']));
                                    if ($rOvo->rowCount() > 0) {
                                        if (file_exists("analisis/ngs_" . $ngs['pro'] . ".pdf")) {
                                            $res = 'Negativo';
                                            while ($ovo = $rOvo->fetch(PDO::FETCH_ASSOC)) {
                                                if ($ovo['ngs1'] == 1) {
                                                    $res = 'Positivo';
                                                    break;
                                                }
                                            }
                                            $pdf = '<a href="analisis/ngs_' . $ngs['pro'] . '.pdf" target="new">Ver/Descargar</a>';
                                        } else {
                                            $res = '-';
                                            $pdf = 'PENDIENTE';
                                        } ?>
                                        <tr>
                                            <td><?php echo $ngs['pro']; ?></td>
                                            <td><a href='<?php echo "e_ngs.php?id=" . $ngs['pro']; ?>'
                                                   rel="external"><?php echo date("d-m-Y", strtotime($ngs['f_fin'])); ?></a>
                                            </td>
                                            <td><?php echo $ngs['ape'] . ' ' . $ngs['nom']; ?></td>
                                            <td><?php echo $ngs['med']; ?></td>
                                            <th><?php echo $pdf; ?></th>
                                            <th><?php echo $res; ?></th>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo '<p><h3>¡ No hay Registros !</h3></p>';
                        } ?>
                    </div>
                    </div>
                <?php } ?>

            <?php } // *************************************************************************************************************************************
            if ($user['role'] == 8) { // ******* LEGAL ***********************************************************
                $rGine = $db->prepare("SELECT hc_paciente.dni,ape,nom,hc_gineco.id,hc_gineco.med,hc_gineco.repro,hc_gineco.fec FROM hc_paciente,hc_gineco WHERE hc_paciente.dni=hc_gineco.dni AND hc_gineco.repro<>'' AND hc_gineco.repro<>'NINGUNA' AND hc_gineco.legal=0 ORDER BY hc_gineco.fec DESC");
                $rGine->execute();

                $rAndro = $db->prepare("SELECT hc_pare_paci.p_dni,hc_pare_paci.dni,p_nom,p_ape,hc_pare_paci.p_het FROM hc_pareja,hc_pare_paci WHERE hc_pareja.p_dni=hc_pare_paci.p_dni ORDER BY p_ape,p_nom ASC");
                $rAndro->execute();

                $rLegal = $db->prepare("SELECT * FROM hc_legal ORDER BY a_mue DESC");
                $rLegal->execute(); ?>

                <div data-role="tabs" id="tabs">

                    <div data-role="navbar">
                        <ul>
                            <li><a href="#one" data-ajax="false" class="ui-btn-active">Ginecologia (Reprod.
                                    Asistida)</a></li>
                            <li><a href="#tre" data-ajax="false">Andrologia</a></li>
                            <li><a href="#two" data-ajax="false" class="color">PACIENTES ATENDIDOS</a></li>
                        </ul>
                    </div>
                    <div id="one">
                        <?php if ($rGine->rowCount() > 0) { ?>
                            <table data-role="table" class="table-stripe ui-responsive">
                                <thead>
                                <tr>
                                    <th>Apellidos y Nombres</th>
                                    <th>Médico</th>
                                    <th>Reprod. Asistida</th>
                                    <th>Consulta ginecologica</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($gine = $rGine->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><a href='<?php echo "e_legal.php?id=&gin=" . $gine['id']; ?>'
                                               rel="external"><?php echo $gine['ape'] . ' ' . $gine['nom']; ?></a>
                                        </td>
                                        <td><?php echo $gine['med']; ?></td>
                                        <th><?php echo $gine['repro']; ?></th>
                                        <th><?php echo date("d-m-Y", strtotime($gine['fec'])); ?></th>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo '<p><h3>¡ No hay Registros !</h3></p>';
                        } ?>
                    </div>
                    <div id="tre">
                        <ol data-role="listview" data-theme="a" data-filter="true" data-filter-placeholder="Filtro..."
                            data-inset="true">
                            <?php while ($andro = $rAndro->fetch(PDO::FETCH_ASSOC)) { ?>
                                <li>
                                    <a href='<?php echo "e_legal.php?id=&andro=" . $andro['p_dni']; ?>' rel="external">
                                        <h4><?php echo $andro['p_ape']; ?>
                                            <small><?php echo $andro['p_nom'] . ' (' . $andro['p_dni'] . ')'; ?></small>
                                        </h4>
                                    </a>
                                    <?php if ($andro['p_het'] > 0) echo '<span class="ui-li-count">Donante</span>'; ?>
                                </li>

                            <?php } ?>
                        </ol>
                    </div>
                    <div id="two">
                        <?php if ($rLegal->rowCount() > 0) { ?>
                            <input id="filtro" data-type="search" placeholder="Filtro..">
                            <table data-role="table" data-filter="true" data-input="#filtro"
                                   class="table-stripe ui-responsive">
                                <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Médico</th>
                                    <th>Resultado</th>
                                    <th>Informe</th>
                                    <th>Fecha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($lega = $rLegal->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr style="font-size: small;">
                                        <td><a href='<?php echo "e_legal.php?id=" . $lega['id']; ?>'
                                               rel="external"><?php echo $lega['a_exa']; ?></a></td>
                                        <td><?php echo $lega['a_nom']; ?></td>
                                        <td><?php echo $lega['a_med']; ?></td>
                                        <td><?php if ($lega['a_sta'] == 0) echo '<b>ATENDIDO</b>';
                                            if ($lega['a_sta'] == 1) echo 'APTO';
                                            if ($lega['a_sta'] == 2) echo 'OBSERVADO';
                                            if ($lega['a_sta'] == 3) echo 'NO APTO'; ?></td>
                                        <td><?php $ruta = 'legal/' . $lega['id'] . '_' . $lega['a_dni'] . '.pdf';
                                            if (file_exists($ruta)) { ?>
                                                <a href='<?php echo "legal/" . $lega['id'] . "_" . $lega['a_dni'] . ".pdf"; ?>'
                                                   target="new">Ver/Descargar</a>
                                                <?php if ($lega['fec_doc'] <> '0000-00-00') echo '<br>' . date("d-m-Y", strtotime($lega['fec_doc']));
                                            } else echo '-'; ?>
                                        </td>
                                        <td><?php echo date("d-m-Y", strtotime($lega['a_mue'])); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo '<p><h3>¡ No hay Registros !</h3></p>';
                        } ?>
                    </div>

                </div>

            <?php } // ************************************************************************************************************************************* ?>

            <?php if ($user['role'] == 6) { // ************ CONSULTA **************************************************************************************
                $rPaci = $db->prepare("SELECT dni,ape,nom,med FROM hc_paciente");
                $rPaci->execute();
                $rMed = $db->prepare("SELECT user,nom FROM usuario WHERE role=1");
                $rMed->execute(); ?>
                <input type="hidden" name="dni" id="dni">
                <table width="100%" align="center" style="margin: 0 auto;">
                    <tr>
                        <td width="30%" valign="top">
                            <ul data-role="listview" data-theme="c" data-inset="true" data-filter="true"
                                data-filter-reveal="true" data-filter-placeholder="Buscar paciente por Nombre o DNI.."
                                data-mini="true"
                                class="fil_paci">
                                <?php while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <li><a href="#" class="paci_insert" dni="<?php echo $paci['dni']; ?>"
                                           med="<?php echo $paci['med']; ?>"><?php echo '<small>' . $paci['ape'] . ' ' . $paci['nom'] . '</small>'; ?></a><span
                                                class="ui-li-count"><?php echo $paci['dni']; ?></span></li>
                                <?php } ?>
                            </ul>
                            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                <select name="med_agenda" id="med_agenda" data-mini="true" required>
                                    <option value="" selected>Seleccione Medico</option>
                                    <?php while ($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $med['user']; ?>"><?php echo $med['nom']; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="cupon" id="cupon">
                                    <option value=0 selected>Clinica</option>
                                    <option value=1>Cono NORTE</option>
                                    <option value=2>Cono SUR</option>
                                    <option value=3>Tacna</option>
                                    <option value=4>Arequipa</option>
                                </select>
                            </div>
                            Fecha y Hora de la consulta:
                            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                                <input name="fec" type="date" id="fec" value="<?php echo date("Y-m-d"); ?>"
                                       data-wrapper-class="controlgroup-textinput ui-btn">
                                <select name="fec_h" id="fec_h" required>
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
                                <select name="fec_m" id="fec_m" required>
                                    <option value="">Min</option>
                                    <option value="00">00 min</option>
                                    <option value="15">15 min</option>
                                    <option value="30">30 min</option>
                                    <option value="45">45 min</option>
                                </select>
                            </div>
                            Motivo de la Consulta:<textarea name="mot" id="mot" data-mini="true" required></textarea>
                            <input type="Submit" value="AGENDAR CONSULTA" name="btn_consulta" data-icon="check"
                                   data-mini="true" data-theme="b" data-inline="true"/>
                        </td>
                        <td width="70%" align="center" valign="top" class="td_agenda"></td>
                    </tr>
                </table>
            <?php } ?>
            <?php if ($user['role'] == 7) { // ************** UROLOGO ************************************************************************
                $rMiPaci = $db->prepare("SELECT DISTINCT hc_urolo.p_dni,hc_pare_paci.dni,p_nom,p_ape,p_san,p_m_ets,p_m_ale FROM hc_pareja,hc_pare_paci,hc_urolo WHERE hc_pareja.p_dni=hc_urolo.p_dni AND hc_pareja.p_dni=hc_pare_paci.p_dni AND hc_urolo.med=? ORDER BY p_ape,p_nom ASC");
                $rMiPaci->execute(array($login));
                $rPaci = $db->prepare("SELECT hc_pare_paci.p_dni,hc_pare_paci.dni,p_nom,p_ape,p_san,p_m_ets,p_m_ale FROM hc_pareja,hc_pare_paci WHERE hc_pareja.p_dni=hc_pare_paci.p_dni AND hc_pare_paci.p_het=0 ORDER BY p_ape,p_nom ASC");
                $rPaci->execute(); ?>
                <div data-role="tabs" id="tabs">

                    <div data-role="navbar">
                        <ul>
                            <li><a href="#one" data-ajax="false" class="ui-btn-active">Pacientes atendidos</a></li>
                            <li><a href="#two" data-ajax="false">Todos los pacientes</a></li>
                        </ul>
                    </div>
                    <div id="one">
                        <input id="filtro" data-type="search" placeholder="Filtro..">
                        <table data-role="table" data-filter="true" data-input="#filtro"
                               class="table-stripe ui-responsive lista_orden"><br>
                            <thead>
                            <tr>
                                <th>APELLIDOS Y NOMBRES</th>
                                <th>DNI/PASAPORTE</th>
                                <th>PAREJA</th>
                                <th>MEDICO PAREJA</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($paci = $rMiPaci->fetch(PDO::FETCH_ASSOC)) {
                                if ($paci['dni'] <> "") {
                                    $rPare = $db->prepare("SELECT nom,ape,med FROM hc_paciente WHERE dni=?");
                                    $rPare->execute(array($paci['dni']));
                                    $pare = $rPare->fetch(PDO::FETCH_ASSOC);
                                } ?>
                                <tr>
                                    <th><a href='<?php echo "e_pare.php?id=" . $paci['dni'] . "&ip=" . $paci['p_dni']; ?>'
                                           rel="external"><?php echo $paci['p_ape'] . ' <small>' . $paci['p_nom'] . '</small>'; ?></a><br>
                                        <small style="opacity:.5;"><?php if ($paci['p_m_ale'] == "Medicamentada") echo " (ALERGIA MEDICAMENTADA)";
                                            if (strpos($paci['p_san'], "-") !== false) echo " (SANGRE NEGATIVA)";
                                            if (strpos($paci['p_m_ets'], "VIH") !== false) echo " (VIH)";
                                            if (strpos($paci['p_m_ets'], "Hepatitis C") !== false) echo " (Hepatitis C)"; ?></small>
                                    </th>
                                    <td><?php echo $paci['p_dni']; ?></td>
                                    <td><?php if ($paci['dni'] <> "") echo $pare['ape'] . ' ' . $pare['nom']; else echo 'Soltero'; ?></td>
                                    <td><?php if ($paci['dni'] <> "") echo $pare['med']; else echo 'Particular'; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="two">
                        <input id="filtro2" data-type="search" placeholder="Filtro..">
                        <table data-role="table" data-filter="true" data-input="#filtro2"
                               class="table-stripe ui-responsive lista_orden"><br>
                            <thead>
                            <tr>
                                <th>APELLIDOS Y NOMBRES</th>
                                <th>DNI/PASAPORTE</th>
                                <th>PAREJA</th>
                                <th>MEDICO PAREJA</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {
                                if ($paci['dni'] <> "") {
                                    $rPare = $db->prepare("SELECT nom,ape,med FROM hc_paciente WHERE dni=?");
                                    $rPare->execute(array($paci['dni']));
                                    $pare = $rPare->fetch(PDO::FETCH_ASSOC);
                                } ?>
                                <tr>
                                    <th><a href='<?php echo "e_pare.php?id=" . $paci['dni'] . "&ip=" . $paci['p_dni']; ?>'
                                           rel="external"><?php echo $paci['p_ape'] . ' <small>' . $paci['p_nom'] . '</small>'; ?></a><br>
                                        <small style="opacity:.5;"><?php if ($paci['p_m_ale'] == "Medicamentada") echo " (ALERGIA MEDICAMENTADA)";
                                            if (strpos($paci['p_san'], "-") !== false) echo " (SANGRE NEGATIVA)";
                                            if (strpos($paci['p_m_ets'], "VIH") !== false) echo " (VIH)";
                                            if (strpos($paci['p_m_ets'], "Hepatitis C") !== false) echo " (Hepatitis C)"; ?></small>
                                    </th>
                                    <td><?php echo $paci['p_dni']; ?></td>
                                    <td><?php if ($paci['dni'] <> "") echo $pare['ape'] . ' ' . $pare['nom']; else echo 'Soltero'; ?></td>
                                    <td><?php if ($paci['dni'] <> "") echo $pare['med']; else echo 'Particular'; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </FORM>
    </div><!-- /content -->

    <?php if ($user['role'] == 1) { ?>
        <div data-role="footer" data-position="fixed" id="footer">
            <p>
                <small> <?php echo $rPaci->rowCount(); ?> Pacientes</small>
            </p>
        </div><!-- /footer -->
    <?php } ?>

</div><!-- /page -->
<script>
    $(function () {

        $("#orden").click();

        $('#alerta').delay(3000).fadeOut('slow');

    });//]]>

</script>
</body>
</html>