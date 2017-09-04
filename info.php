<?php require("_database/db_tools.php");
$p_dni = $_GET['a'];
$id = $_GET['b'];
$dni = $_GET['c'];

$rPare = $db->prepare("SELECT p_nom,p_ape,p_fnac,p_med FROM hc_pareja WHERE p_dni=?");
$rPare->execute(array($p_dni));
$pare = $rPare->fetch(PDO::FETCH_ASSOC);

if ($dni <> "") {
    $rPaci = $db->prepare("SELECT nom,ape,med FROM hc_paciente WHERE dni=?");
    $rPaci->execute(array($dni));
    $paci = $rPaci->fetch(PDO::FETCH_ASSOC);

    $o_e = explode(",", $paci['med']);
    foreach ($o_e as $oe) {
        $rMed = $db->prepare("SELECT nom,cmp FROM usuario WHERE user=?");
        $rMed->execute(array($oe));
        $med = $rMed->fetch(PDO::FETCH_ASSOC);
        $pare_med = $med['nom'] . ' (CMP ' . $med['cmp'] . ') ' . $pare_med;
    }
    $pareja = '<h3>PAREJA: <smal><i>' . $paci['ape'] . ' ' . $paci['nom'] . '</i></small></h3><h3>MEDICO: <smal><i>' . $pare_med . '</i></small></h3>';
} else {
    if ($pare['p_med'] <> "") {
        $medico = '<h3>MEDICO: <smal><i>' . $pare['p_med'] . '</i></small></h3>';
    }
}
if ($_GET['T'] == "esp") { //###############################################################################################

    $Rpop = $db->prepare("SELECT * FROM lab_andro_esp WHERE p_dni=? AND fec=?");
    $Rpop->execute(array($p_dni, $id));
    $pop = $Rpop->fetch(PDO::FETCH_ASSOC);
    $edad = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EDAD: <smal>' . date_diff(date_create($pare['p_fnac']), date_create($pop['fec']))->y . '</small>';
    $html = '<h1>Espermatograma</h1>
<hr />
<h3>PACIENTE: <smal><i>' . $pare['p_ape'] . ' ' . $pare['p_nom'] . '</i></small></h3>';

    $html .= $pareja . $medico . '<p><b>Fecha de resultados:</b> ' . date("d-m-Y", strtotime($pop['fec'])) . '
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>' . $pop['vol_f'] . ' <small><i>Mililitros</i></small></td>
</tr>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_f'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round(($pop['vol_f'] * $pop['con_f']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th align="left">Viabilidad</th>
<td>' . $pop['via'] . ' %</td>
</tr>
<tr>
<th align="left">Aglutinación</th>
<td>' . $pop['agl'] . ' %</td>
</tr>
<tr>
<th align="left">Shaking</th>
<td>' . $pop['sha'] . ' %</td>
</tr>
<tr>
<th align="left">Células Redondas</th>
<td>' . $pop['c_red'] . ' <small><i>Millones por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Ph</th>
<td>' . $pop['ph'] . '</td>
</tr>
<tr>
<th width="200" align="left">Licuefacción</th>
<td>' . $pop['lic'] . ' <small><i>Minutos</i></small></td>
</tr>
<tr>
<th align="left">Debris</th>
<td>' . $pop['deb'] . '</td>
</tr>
<tr>
<th align="left">Consistencia</th>';
    if ($pop['con'] == 1) $esp_con = 'Aumentada'; else $esp_con = 'Normal';
    $html .= '<td>' . $esp_con . '</td>
</tr>
</table>
</blockquote>';
    /*<h4>MOTILIDAD</h4>
    <blockquote>
    <table border="0">
    <thead>
    <tr>
    <th width="200" align="left">Progresivo Lineal</th>
    <td>'.$pop['pl_f'].' %</td>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th align="left">Progresivo No Lineal</th>
    <td>'.$pop['pnl_f'].' %</td>
    </tr>
    <tr>
    <th align="left">Movilidad insitu</th>
    <td>'.$pop['ins_f'].' %</td>
    </tr>
    <tr>
    <th align="left">No Movil</th>
    <td>'.$pop['inm_f'].' %</td>
    </tr>
    </tbody>
    </table>
    </blockquote>'; */
    include "libchart-master/libchart/classes/libchart.php";

    $chart = new PieChart();
    $chart->getPlot()->getPalette()->setPieColor(array(
        new Color(125, 223, 228, 1.00),
        new Color(132, 231, 202, 1.00),
        new Color(84, 127, 227, 1.00),
        new Color(95, 170, 224, 1.00)
    ));
    $dataSet = new XYDataSet();
    $dataSet->addPoint(new Point("Progresivo Lineal: " . $pop['pl_f'] . "%", $pop['pl_f']));
    $dataSet->addPoint(new Point("Progresivo No Lineal: " . $pop['pnl_f'] . "%", $pop['pnl_f']));
    $dataSet->addPoint(new Point("Movilidad insitu: " . $pop['ins_f'] . "%", $pop['ins_f']));
    $dataSet->addPoint(new Point("No Movil: " . $pop['inm_f'] . "%", $pop['inm_f']));
    $chart->setDataSet($dataSet);

    $chart->setTitle("MOTILIDAD");
    $chart->render("generated/moti.png");
    $html .= '<img src="generated/moti.png"/>';

    if (($pop['m_a'] + $pop['m_n']) > 0) {
        $m_n = round(100 - (($pop['m_a'] * 100) / ($pop['m_a'] + $pop['m_n'])), 2);
        $m_a = 100 - $m_n;
        $chart = new HorizontalBarChart(600, 170);
        $dataSet = new XYDataSet();
        if ($pop['fec'] <= '2016-09-20') $defecto = 30; else $defecto = 4;
        $dataSet->addPoint(new Point("Limite inferior normales", $defecto . "%"));
        $dataSet->addPoint(new Point("NORMAL", $m_n . "%"));
        $dataSet->addPoint(new Point("ANORMAL", $m_a . "%"));
        $chart->setDataSet($dataSet);
        $chart->getPlot()->setGraphPadding(new Padding(5, 30, 20, 140));
        $chart->setTitle("MORFOLOGÍA");
        $chart->render("generated/morfo.png");
        $html .= '<img src="generated/morfo.png"/>';

        $m_mic = round(($pop['m_mic'] * 100) / $pop['m_a'], 0);
        $m_mac = round(($pop['m_mac'] * 100) / $pop['m_a'], 0);
        $m_cab = round(($pop['m_cab'] * 100) / $pop['m_a'], 0);
        $m_col = round(($pop['m_col'] * 100) / $pop['m_a'], 0);
        $m_inm = round(($pop['m_inm'] * 100) / $pop['m_a'], 0);
        $m_bic = round(($pop['m_bic'] * 100) / $pop['m_a'], 0);
        $m_bic2 = round(($pop['m_bic2'] * 100) / $pop['m_a'], 0);

        $chart = new PieChart();
        $chart->getPlot()->getPalette()->setPieColor(array(
            new Color(197, 218, 254, 1.00),
            new Color(168, 199, 254, 1.00),
            new Color(141, 182, 254, 1.00),
            new Color(105, 159, 254, 1.00),
            new Color(78, 142, 254, 1.00),
            new Color(42, 118, 253, 1.00),
            new Color(1, 91, 249, 1.00)
        ));
        $dataSet = new XYDataSet();
        $dataSet->addPoint(new Point("Microcefalo: " . $m_mic . "%", $m_mic));
        $dataSet->addPoint(new Point("Macrocefalo: " . $m_mac . "%", $m_mac));
        $dataSet->addPoint(new Point("Amorfo cabeza: " . $m_cab . "%", $m_cab));
        $dataSet->addPoint(new Point("Amorfo cola: " . $m_col . "%", $m_col));
        $dataSet->addPoint(new Point("Inmaduro: " . $m_inm . "%", $m_inm));
        $dataSet->addPoint(new Point("Bicaudo: " . $m_bic . "%", $m_bic));
        $dataSet->addPoint(new Point("Bicefalo: " . $m_bic2 . "%", $m_bic2));
        $chart->setDataSet($dataSet);
        $chart->setTitle("MORFOLOGÍA ANORMALES");
        $chart->render("generated/morfo2.png");
        $html .= '<img src="generated/morfo2.png"/>';
    }
    $html .= '<h4>RESULTADO</h4><blockquote>';

    if ($pop['con_f'] <= 0)
        $espermia = 'Azoospermia';
    else {
        if (($pop['m_a'] + $pop['m_n']) > 0) {
            $espermia = 'Normal';
            if ($pop['vol_f'] >= 6) {
                $html .= 'HIPER';
                $espermia = 'espermia';
            }
            if ($pop['vol_f'] <= 1.5) {
                $html .= 'HIPO';
                $espermia = 'espermia';
            }
            if ($pop['con_f'] <= 20) {
                $html .= 'OLIGO';
                $espermia = 'zoospermia';
            }
            if ($pop['con_f'] <= 0.1) {
                $html .= 'CRIPTO';
                $espermia = 'zoospermia';
            }
            if (($pop['pl_f'] + $pop['pnl_f']) <= 40) {
                $html .= 'ASTENO';
                $espermia = 'zoospermia';
            }
            if ($m_n <= 4) {
                $html .= 'TERATO';
                $espermia = 'zoospermia';
            }
            if ($pop['via'] < 58) {
                $html .= 'NECRO';
                $espermia = 'zoospermia';
            }
        } else $espermia = 'Morfologia en proceso..';
    }

    $html .= $espermia . '</blockquote>';
    if ($pop['nota'] <> "") $html .= '<h4>OBSERVACIONES</h4><blockquote>' . $pop['nota'] . '</blockquote>';

}
if ($_GET['T'] == "tes_cap") { //###############################################################################################

    $Rpop = $db->prepare("SELECT * FROM lab_andro_tes_cap WHERE p_dni=? AND fec=?");
    $Rpop->execute(array($p_dni, $id));
    $pop = $Rpop->fetch(PDO::FETCH_ASSOC);

    $html = '<h1>Test de Capacitación</h1>
<hr />
<h3>PACIENTE: <smal><i>' . $pare['p_ape'] . ' ' . $pare['p_nom'] . '</i></small></h3>';
    if ($pop['cap'] == 1) $cap = "Gradiente densidad";
    if ($pop['cap'] == 2) $cap = "Lavado";
    if ($pop['cap'] == 3) $cap = "Swim up";
    if ($pop['sel'] == 1) $sel = "Aleatoria";
    if ($pop['sel'] == 2) $sel = "Masculina";
    if ($pop['sel'] == 3) $sel = "Femenina";
    $html .= $pareja . $medico . '<p><b>Fecha de resultados:</b> ' . date("d-m-Y", strtotime($pop['fec'])) . '
<h4>FRESCO</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>' . $pop['vol_f'] . ' <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_f'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round(($pop['vol_f'] * $pop['con_f']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_f'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_f'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>
<h4>CAPACITADO</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>0.3 <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_c'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round((0.3 * $pop['con_c']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_c'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_c'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>
<h4>TIPO DE CAPACITACIÓN</h4>
<blockquote>' . $cap . '</blockquote>
<h4>SELECCIÓN ESPERMÁTICA</h4>
<blockquote>' . $sel . '</blockquote>';
}
if ($_GET['T'] == "tes_sob") { //###############################################################################################

    $Rpop = $db->prepare("SELECT * FROM lab_andro_tes_sob WHERE p_dni=? AND fec=?");
    $Rpop->execute(array($p_dni, $id));
    $pop = $Rpop->fetch(PDO::FETCH_ASSOC);

    $html = '<h1>Test de Sobrevivencia<br>Espermática</h1>
<hr />
<h3>PACIENTE: <smal><i>' . $pare['p_ape'] . ' ' . $pare['p_nom'] . '</i></small></h3>';
    if ($pop['cap'] == 1) $cap = "Gradiente densidad";
    if ($pop['cap'] == 2) $cap = "Lavado";
    if ($pop['cap'] == 3) $cap = "Swim up";
    if ($pop['sel'] == 1) $sel = "Aleatoria";
    if ($pop['sel'] == 2) $sel = "Masculina";
    if ($pop['sel'] == 3) $sel = "Femenina";
    $html .= $pareja . $medico . '<p><b>Fecha de resultados:</b> ' . date("d-m-Y", strtotime($pop['fec'])) . '
<h4>MUESTRA ACTUAL</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>' . $pop['vol_f'] . ' <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_f'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round(($pop['vol_f'] * $pop['con_f']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_f'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_f'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>
<h4>MUESTRA POST 24 HORAS</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>0.1 <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_c'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round((0.1 * $pop['con_c']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_c'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_c'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>
<h4>TIPO DE CAPACITACIÓN</h4>
<blockquote>' . $cap . '</blockquote>
<h4>SELECCIÓN ESPERMÁTICA</h4>
<blockquote>' . $sel . '</blockquote>';
}
if ($_GET['T'] == "crio_sem") { //###############################################################################################

    $Rpop = $db->prepare("SELECT * FROM lab_andro_crio_sem WHERE p_dni=? AND fec=?");
    $Rpop->execute(array($p_dni, $id));
    $pop = $Rpop->fetch(PDO::FETCH_ASSOC);

    $rRes = $db->prepare("SELECT T,C,V,P FROM lab_tanque_res WHERE sta=? AND tip=? AND tip_id=?");
    $rRes->execute(array($p_dni, 2, $id)); // 1=bio_tes 2=crio_sem

    $Rcap = $db->prepare("SELECT des FROM lab_andro_cap WHERE des_dni=? AND des_tip=? AND des_fec=?");
    $Rcap->execute(array($p_dni, 2, $id)); // 1=bio_tes 2=crio_sem

    $html = '<h1>Criopreservación de Semen</h1>
<hr />
<h3>PACIENTE: <smal><i>' . $pare['p_ape'] . ' ' . $pare['p_nom'] . '</i></small></h3>';
    if ($pop['cap'] == 1) $cap = "Gradiente densidad";
    if ($pop['cap'] == 2) $cap = "Lavado";
    if ($pop['cap'] == 3) $cap = "Swim up";
    $html .= $pareja . $medico . '<p><b>Fecha de resultados:</b> ' . date("d-m-Y", strtotime($pop['fec'])) . '
<h4>FRESCO</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>' . $pop['vol_f'] . ' <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_f'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round(($pop['vol_f'] * $pop['con_f']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_f'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_f'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>';
    if ($pop['cap'] <> "") {
        $html .= '<h4>CAPACITADO</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>' . $pop['vol_c'] . ' <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_c'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round(($pop['vol_c'] * $pop['con_c']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_c'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_c'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>
<h4>TIPO DE CAPACITACIÓN</h4>
<blockquote>' . $cap . '</blockquote>';
    }
    if ($Rcap->rowCount() > 0) {
        $html .= '<h4>VIALES DESCONGELADOS</h4>
<blockquote class="tabla"><table style="text-align:center;"><tr><th>Tanque</th><th>Canister</th><th>Varilla</th><th>Posición</th></tr>';
        while ($cap = $Rcap->fetch(PDO::FETCH_ASSOC)) {
            $des = explode('|', $cap['des']);
            foreach ($des as $vial) {
                if ($vial) {
                    $ds = explode('-', $vial);
                    $html .= '<tr><td>' . $ds[0] . '</td><td>' . $ds[1] . '</td><td>' . $ds[2] . '</td><td>' . $ds[3] . '</td></tr>';
                }
            }
        }
        $html .= '</table></blockquote>';
    }
    if ($rRes->rowCount() > 0) {
        $html .= '<h4>VIALES CRIOPRESERVADOS</h4>
<blockquote class="tabla"><table style="text-align:center;"><tr><th>Tanque</th><th>Canister</th><th>Varilla</th><th>Posición</th></tr>';
        while ($res = $rRes->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr> <td> ' . $res['T'] . '</td><td> ' . $res['C'] . '</td><td>' . $res['V'] . '</td><td>' . $res['P'] . '</td></tr>';
        }
        $html .= '</table></blockquote>';
        $html .= '<h4>TOTAL DE VIALES CONGELADOS: ' . $rRes->rowCount() . '</h4>';
    }
    if ($pop['obs'] <> "")
        $html .= '<h4>OBSERVACIONES</h4>' . $pop['obs'];

}
if ($_GET['T'] == "bio_tes") { //###############################################################################################

    $Rpop = $db->prepare("SELECT * FROM lab_andro_bio_tes WHERE p_dni=? AND fec=?");
    $Rpop->execute(array($p_dni, $id));
    $pop = $Rpop->fetch(PDO::FETCH_ASSOC);

    $rRes = $db->prepare("SELECT T,C,V,P FROM lab_tanque_res WHERE sta=? AND tip=? AND tip_id=?");
    $rRes->execute(array($p_dni, 1, $id)); // 1=bio_tes 2=crio_sem

    $Rcap = $db->prepare("SELECT des FROM lab_andro_cap WHERE des_dni=? AND des_tip=? AND des_fec=?");
    $Rcap->execute(array($p_dni, 1, $id)); // 1=bio_tes 2=crio_sem

    $html = '<h1>Biopsia Testicular</h1>
<hr />
<h3>PACIENTE: <smal><i>' . $pare['p_ape'] . ' ' . $pare['p_nom'] . '</i></small></h3>';
    if ($pop['tip'] == 1) $tip = "Biopsia testicular";
    if ($pop['tip'] == 2) $tip = "Aspiración de epididimo";
    if ($pop['esp'] == 0) $esp = "Millones de espermatozoides por mililitro";
    if ($pop['esp'] == 1) $esp = "Espermatosides  por campo";
    if ($pop['crio'] == 1) $crio = 'CRIOPRESERVADO'; else $crio = 'FRESCO';
    $html .= $pareja . $medico . '<p><b>Fecha de resultados:</b> ' . date("d-m-Y", strtotime($pop['fec'])) . '
<h4>' . $crio . '</h4>
<blockquote>
<table border="0" align="left">
<tr>
<th width="200" align="left">Tipo</th>
<td>' . $tip . '</td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_f'] . ' <small><i>' . $esp . '</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_f'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_f'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>';
    if ($Rcap->rowCount() > 0) {
        $html .= '<h4>VIALES DESCONGELADOS</h4>
<blockquote class="tabla"><table style="text-align:center;"><tr><th>Tanque</th><th>Canister</th><th>Varilla</th><th>Posición</th></tr>';
        while ($cap = $Rcap->fetch(PDO::FETCH_ASSOC)) {
            $des = explode('|', $cap['des']);
            foreach ($des as $vial) {
                if ($vial) {
                    $ds = explode('-', $vial);
                    $html .= '<tr><td>' . $ds[0] . '</td><td>' . $ds[1] . '</td><td>' . $ds[2] . '</td><td>' . $ds[3] . '</td></tr>';
                }
            }
        }
        $html .= '</table></blockquote>';
    }
    if ($rRes->rowCount() > 0) {
        $html .= '<h4>VIALES CRIOPRESERVADOS</h4>
<blockquote class="tabla"><table style="text-align:center;"><tr><th>Tanque</th><th>Canister</th><th>Varilla</th><th>Vial</th></tr>';
        while ($res = $rRes->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr> <td> ' . $res['T'] . '</td><td> ' . $res['C'] . '</td><td>' . $res['V'] . '</td><td>' . $res['P'] . '</td></tr>';
        }
        $html .= '</table></blockquote>';
        $html .= '<h4>TOTAL DE VIALES CONGELADOS: ' . $rRes->rowCount() . '</h4>';
    }
    if ($pop['nota'] <> "") $html .= '<h4>OBSERVACIONES</h4><blockquote>' . $pop['nota'] . '</blockquote>';
}
if ($_GET['T'] == "cap") { //###############################################################################################

    $Rpop = $db->prepare("SELECT * FROM lab_andro_cap WHERE id=?");
    $Rpop->execute(array($id));
    $pop = $Rpop->fetch(PDO::FETCH_ASSOC);

    $html = '<h1>Capacitación espermática</h1><hr />';
    if ($p_dni <> '') $html .= '<h3>PACIENTE: <smal><i>' . $pare['p_ape'] . ' ' . $pare['p_nom'] . '</i></small></h3>'; // cuando es SOLTERA
    if ($pop['cap'] == 1) $cap = "Gradiente densidad";
    if ($pop['cap'] == 2) $cap = "Lavado";
    if ($pop['cap'] == 3) $cap = "Swim up";
    if ($pop['sel'] == 1) $sel = "Aleatoria";
    if ($pop['sel'] == 2) $sel = "Masculina";
    if ($pop['sel'] == 3) $sel = "Femenina";
    if ($pop['mue'] == 1) $mue = "Fresca PAREJA (Homólogo)";
    if ($pop['mue'] == 2) $mue = "Fresca DONANTE (Heterólogo)";
    if ($pop['mue'] == 3) $mue = "Criopreservada PAREJA (Homólogo)";
    if ($pop['mue'] == 4) $mue = "Criopreservada DONANTE (Heterólogo)";
    $html .= $pareja . $medico . '<p><b>Fecha de resultados:</b> ' . date("d-m-Y", strtotime($pop['fec'])) . '
<h4>SELECCIÓN ESPERMÁTCA</h4>
<blockquote>' . $sel . '</blockquote>
<h4>MUESTRA</h4>
<blockquote>Tipo de Muestra: ' . $mue . '<br><br>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>' . $pop['vol_f'] . ' <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_f'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round(($pop['vol_f'] * $pop['con_f']), 2) . ' <small><i>Millones de espermatozoides por eyaculado</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_f'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_f'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_f'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>
<h4>CAPACITADO</h4>
<blockquote>Tipo de Capacitación: ' . $cap . '<br><br>
<table border="0" align="left">
<tr>
<th width="200" align="left">Volumen</th>
<td>0.3 <small><i>Mililitros</i></small></td>
</tr>
<tbody>
<tr>
<th align="left">Concentración</th>
<td>' . $pop['con_c'] . ' <small><i>Millones de espermatozoides por mililitro</i></small></td>
</tr>
<tr>
<th align="left">Total de espermatozoides</th>
<td>' . round((0.3 * $pop['con_c']), 2) . ' <small><i>Millones de espermatozoides a inseminar</i></small></td>
</tr>
<tr>
<th width="200" align="left">Progresivo Lineal</th>
<td>' . $pop['pl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Progresivo No Lineal</th>
<td>' . $pop['pnl_c'] . ' %</td>
</tr>
<tr>
<th align="left">Movilidad insitu</th>
<td>' . $pop['ins_c'] . ' %</td>
</tr>
<tr>
<th align="left">No Movil</th>
<td>' . $pop['inm_c'] . ' %</td>
</tr>
</tbody>
</table>
</blockquote>';
    if ($pop['mue'] >= 3) {

        if ($pop['des'] <> "") {

            if ($pop['mue'] == 4) {
                $rHete = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
                $rHete->execute(array($pop['des_dni']));
                $het = $rHete->fetch(PDO::FETCH_ASSOC);
                $dona = '(DONANTE)';
            }
            $html .= '<h4>VIALES DESCONGELADOS ' . $dona . '</h4>	
<blockquote class="tabla"><table style="text-align:center;"><tr><th>Tanque</th><th>Canister</th><th>Varilla</th><th>Posición</th><th>Tipo</th></tr>';
            $des = explode('|', $pop['des']);

            foreach ($des as $vial) {

                if ($vial) {
                    $ds = explode('-', $vial);
                    if ($pop['des_tip'] == 1) {
                        $tipo = 'Biopsia testicular';
                    } else {
                        $tipo = 'Criopreservación de Semen';
                    }

                    $html .= '<tr> <td> ' . $ds[0] . '</td><td> ' . $ds[1] . '</td><td ' . $bg . '> ' . $ds[2] . '</td><td ' . $bg . '> ' . $ds[3] . '</td><td> ' . $tipo . '</td></tr>';
                }
            }
            $html .= '</table></blockquote>';
        }
    }

}
//===============================================================================================================================
$estilo = '<style>@page {
	margin-header: 0mm;
	margin-footer: 0mm;
	margin-left: 0cm;
	margin-right: 0cm;
	header: html_myHTMLHeader;
	footer: html_myHTMLFooter;
} .xxx {margin-left: 2.3cm;margin-right: 1.7cm;} .tabla table {border-collapse: collapse;} .tabla table, .tabla th, .tabla td {border: 1px solid #72a2aa;}</style>';
$rEmb = $db->prepare("SELECT id,nom FROM lab_user WHERE id=?");
$rEmb->execute(array($pop['emb']));
$embrio = $rEmb->fetch(PDO::FETCH_ASSOC);
$html .= '</p><div width="200" style="float:right;"><img src="emb_pic/emb_' . $embrio['id'] . '.jpg?v=' . mt_rand() . '" width="200px" height="100px"><br><br><i>Blgo. ' . $embrio['nom'] . '</i></div>';
$head_foot = '<!--mpdf
<htmlpageheader name="myHTMLHeader"><img src="_images/info_head.jpg" width="100%"></htmlpageheader>
<htmlpagefooter name="myHTMLFooter"><img src="_images/info_foot.jpg" width="100%"></htmlpagefooter>
mpdf-->';
include("_mpdf60/mpdf.php");
$mpdf = new mPDF('s', 'A4', 9, 'dejavusans');
$mpdf->WriteHTML($estilo . '<body><div class="xxx">' . $head_foot . $html . '</div></body>');
$mpdf->Output();
exit; ?>