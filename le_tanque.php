<?php require("_database/db_tools.php");
$salida = "";

if ($_POST['t']) {
    $rTan = $db->prepare("SELECT * FROM lab_tanque WHERE tan=?");
    $rTan->execute(array($_POST['t']));
    $tan = $rTan->fetch(PDO::FETCH_ASSOC);

    echo "<option value='' selected>---</option>";
    for ($c = 1; $c <= $tan['n_c']; $c++) {
        $rRes = $db->prepare("SELECT * FROM lab_tanque_res WHERE T=? AND C=? AND sta=?");
        $rRes->execute(array($_POST['t'], $c, ""));

        // imprime canister con espacio disponible ----------------
        if ($rRes->rowCount() > 0) echo "<option value=" . $c . " id='" . $tan['tan'] . "|" . $c . "|" . $tan['n_v'] . "|" . $tan['n_p'] . "' >" . $c . "</option>";
        else echo "<option value=" . $c . " id='" . $tan['tan'] . "|" . $c . "|" . $tan['n_v'] . "|" . $tan['n_p'] . "' >" . $c . " (Lleno)</option>";

    }
    echo $salida;
}

if ($_POST['c'] and $_POST['p_dni']) {

    $tan = explode("|", $_POST['c']);

    $t = $tan[0];
    $c = $tan[1];
    $v = $tan[2];
    $p = $tan[3];
    $count = 1;

    $rRes = $db->prepare("SELECT * FROM lab_tanque_res WHERE T=? AND C=?");
    $rRes->execute(array($t, $c));

    if ($_POST['tip'] == 3 or $_POST['tip'] == 4 or ($_POST['tip'] == 0 and $_POST['tip_id'] == "x")) {
        echo '<p class="ui-bar-b">MARQUE aquí las pajuelas para criopreservar:</p>';
        $pos = "pajuela";
        $col = "Gobelet";
    } else {
        echo '<p class="ui-bar-b">MARQUE aquí los viales para criopreservar:</p>';
        $pos = "vial";
        $col = "Varilla";
    }

    if ($p == 5) $n_pos = '<td>' . $pos . ' 5</td>';
    if ($p == 6) $n_pos = '<td>' . $pos . ' 5</td><td>' . $pos . ' 6</td>';

    echo '<table bordercolor="#72a2aa" style="text-align:center" class="tablex"><tr><td>' . $col . '</td><td>' . $pos . ' 1</td><td>' . $pos . ' 2</td><td>' . $pos . ' 3</td><td>' . $pos . ' 4</td>' . $n_pos . '</tr> <tr><td>' . $count . '</td>';


    if ($_POST['tip_id'] == "") $disabled = "disabled"; else $disabled = ""; // tip_id=="" cuando es un nuevo ingreso, desabilita las posiciones

    $ovo_emb = "";

    while ($res = $rRes->fetch(PDO::FETCH_ASSOC)) {

        if ($res['sta'] <> "" and $res['sta'] <> $_POST['p_dni'])    // de otro paciente
            echo '<td class="chk_otro"><input type="checkbox" name="xxx" checked disabled><small style="color:white;">' . $res['sta'] . '</small></td>';


        if ($_POST['tip'] <> 0) { // 1=bio_tes 2=crio_sem 3=embrio 4=ovo 0=descongelados

            if ($res['sta'] <> "" and $res['sta'] == $_POST['p_dni'] and $res['tip'] == 1) {    // bio_tes
                if ($_POST['tip_id'] == "" or $_POST['tip_id'] <> $res['tip_id'] or $_POST['tip'] <> 1) { // mismo paciente pero diferente tipo o id
                    echo '<td class="chk_bio"><input type="checkbox" name="xxx" value=1 checked disabled></td>';
                } else {
                    echo '<input type="hidden" name="' . $res['V'] . '_' . $res['P'] . '" value=0>';
                    echo '<td class="chk_bio"><input type="checkbox" name="' . $res['V'] . '_' . $res['P'] . '" value=1 checked ' . $disabled . '></td>';
                }
            }
            if ($res['sta'] <> "" and $res['sta'] == $_POST['p_dni'] and $res['tip'] == 2) {    // crio_sem
                if ($_POST['tip_id'] == "" or $_POST['tip_id'] <> $res['tip_id'] or $_POST['tip'] <> 2) { // mismo paciente pero diferente tipo o id
                    echo '<td class="chk_crio"><input type="checkbox" name="xxx" value=1 checked disabled></td>';
                } else {
                    echo '<input type="hidden" name="' . $res['V'] . '_' . $res['P'] . '" value=0>';
                    echo '<td class="chk_crio"><input type="checkbox" name="' . $res['V'] . '_' . $res['P'] . '" value=1 checked ' . $disabled . '></td>';
                }
            }
            if ($res['sta'] == "") {

                echo '<input type="hidden" name="' . $res['V'] . '_' . $res['P'] . '" value=0>';
                echo '<td class="chk_free"><input type="checkbox" name="' . $res['V'] . '_' . $res['P'] . '" value=1>' . $ovo_emb . '</td>';
            }

        } else { // Si es un proceso de descongelacion ---------------------------------------------------------------------

            if ($res['sta'] <> "" and $res['sta'] == $_POST['p_dni'] and $res['tip'] == 1) {    // bio_tes
                //echo '<input type="hidden" name="'.$res['V'].'_'.$res['P'].'" value=1>';
                echo '<td class="chk_bio"><input type="checkbox" name="' . $res['V'] . '_' . $res['P'] . '" value="1|' . $res['tip_id'] . '" checked></td>';
            }
            if ($res['sta'] <> "" and $res['sta'] == $_POST['p_dni'] and $res['tip'] == 2) {    // crio_sem
                // echo '<input type="hidden" name="'.$res['V'].'_'.$res['P'].'" value=2>';
                echo '<td class="chk_crio"><input type="checkbox" name="' . $res['V'] . '_' . $res['P'] . '" value="2|' . $res['tip_id'] . '" checked></td>';
            }
            if ($res['sta'] == "") {
                echo '<td class="chk_free"><input type="checkbox" name="xxx" value=1 checked disabled></td>';
            }
        }

        if ($res['P'] == $p) {
            $count++;
            echo '</tr><tr><td>' . $count . '</td>';
        } // Salto de varilla
    }


    echo '</tr></table><input type="hidden" name="v_p" value="' . $v . '|' . $p . '">';
}

if ($_POST['d']) { // descongelacion (capacitacion) --------------------------------------------

    if ($_POST['het'] == 1) {
        $rHete = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
        $rHete->execute(array($_POST['d']));
        $het = $rHete->fetch(PDO::FETCH_ASSOC);
        echo 'DONANTE:<b> ' . $het['p_ape'] . ' ' . $het['p_nom'] . '</b>';
    }

    echo '<p class="ui-bar-b">MARQUE aquí los viales para descongelar:</p>';
    echo '<table bordercolor="#72a2aa" style="text-align:center">';
    echo '<tr class="ui-bar-b"> <td colspan="6">Viales Criopreservados:</td></tr>';
    echo '<tr class="ui-bar-c"><td>T</td><td>C</td><td>Vial</td><td>Pajuela</td><td>Tipo</td><td>Fecha</td></tr>';


    $rRes = $db->prepare("SELECT T,C,V,P,tip,tip_id FROM lab_tanque_res WHERE sta=?");
    $rRes->execute(array($_POST['d']));

    $c = 0;
    while ($res = $rRes->fetch(PDO::FETCH_ASSOC)) {
        $c++;
        echo '<tr>';
        echo '<td>' . $res['T'] . '</td>';
        echo '<td>' . $res['C'] . '</td>';

        if ($res['tip'] == 1) $bg = "#E99885"; else $bg = "#9AC2F1";

        echo '<td bgcolor="' . $bg . '">' . $res['V'] . '</td>';
        echo '<td bgcolor="' . $bg . '">' . $res['P'] . '</td>';
        echo '<td><input type="checkbox" name="c' . $c . '" value="' . $res['T'] . '-' . $res['C'] . '-' . $res['V'] . '-' . $res['P'] . '" id="' . $res['tip'] . '|' . $res['tip_id'] . '" class="deschk">';

        if ($res['tip'] == 1) echo "Biop."; else echo "Crio.";

        echo '</td>';
        echo '<td>' . date("d-m-Y", strtotime($res['tip_id'])) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<input type="hidden" name="cont" value=' . $c . ' >';

}

if ($_POST['e'] and $_POST['f'] and $_POST['p_dni']) { // --- muestra los valores de crio o bio en capacitacion ---------

    if ($_POST['e'] == 1) {
        $Rpop = $db->prepare("SELECT vol,con_f,esp,pl_f,pnl_f,ins_f,inm_f FROM lab_andro_bio_tes WHERE p_dni=? AND fec=?");
        $Rpop->execute(array($_POST['p_dni'], $_POST['f']));
        $pop = $Rpop->fetch(PDO::FETCH_ASSOC);
        echo $pop['vol'] . "|" . $pop['con_f'] . "|" . $pop['esp'] . "|" . $pop['pl_f'] . "|" . $pop['pnl_f'] . "|" . $pop['ins_f'] . "|" . $pop['inm_f'];
    }

    if ($_POST['e'] == 2) {
        $Rpop = $db->prepare("SELECT vol_f,con_f,pl_f,pnl_f,ins_f,inm_f FROM lab_andro_crio_sem WHERE p_dni=? AND fec=?");
        $Rpop->execute(array($_POST['p_dni'], $_POST['f']));
        $pop = $Rpop->fetch(PDO::FETCH_ASSOC);
        echo $pop['vol_f'] . "|" . $pop['con_f'] . "|0|" . $pop['pl_f'] . "|" . $pop['pnl_f'] . "|" . $pop['ins_f'] . "|" . $pop['inm_f'];
    }

}

if ($_POST['h'] and $_POST['dni'] and $_POST['paci'] and $_POST['btn_guarda']) { // muestra ovos o embrio para Reserva ------------------------

    $rAsp = $db->prepare("SELECT lab_aspira.pro,lab_aspira.fec,lab_aspira.tip,hc_reprod.p_dni FROM hc_reprod,lab_aspira WHERE hc_reprod.id=lab_aspira.rep AND lab_aspira.dni=?");
    $rAsp->execute(array($_POST['dni']));

    if ($rAsp->rowCount() > 0) {
        $c = 0;
        $vacio = 0;

        if ($_POST['h'] == 2 or $_POST['h'] == 4) $ovo_emb = 'Ovulos';
        if ($_POST['h'] == 1 or $_POST['h'] == 3) $ovo_emb = 'Embriones';
        echo '<p class="ui-bar-b" align="center">Seleccione los ' . $ovo_emb . ' para reservarlos:</p>';
        while ($asp = $rAsp->fetch(PDO::FETCH_ASSOC)) {

            if ($_POST['h'] == 1 or $_POST['h'] == 3) $rRes = $db->prepare("SELECT * FROM lab_aspira_dias WHERE pro=? AND des<>1 AND (adju='' OR adju=?) AND (d6f_cic='C' OR d5f_cic='C' OR d4f_cic='C' OR d3f_cic='C' OR d2f_cic='C')");
            if ($_POST['h'] == 2 or $_POST['h'] == 4) $rRes = $db->prepare("SELECT * FROM lab_aspira_dias WHERE pro=? AND des<>1 AND (adju='' OR adju=?) AND d0f_cic='C'");
            $rRes->execute(array($asp['pro'], $_POST['paci']));

            if ($rRes->rowCount() > 0) {
                $ubica = '';
                echo '<span class="ui-bar-b">Protocolo: ' . $asp['pro'] . ' (' . date("d-m-Y", strtotime($asp['fec'])) . ')</span> <a href="info_rm.php?a=' . $asp['pro'] . '&b=' . $_POST['dni'] . '&c=' . $asp['p_dni'] . '" target="new">Ver Informe</a>';
                echo '<table cellpadding="5" style="text-align:center;font-size: small;border-collapse: collapse;border: 2px solid #72a2aa;">';
                echo '<tr style="border: 1px solid #72a2aa;"><th>ID ' . $ovo_emb . '</th>';
                if ($_POST['h'] == 1 or $_POST['h'] == 3) echo '<th>DIA 2</th><th>DIA 3</th><th>DIA 4</th><th>DIA 5</th><th>DIA 6</th><th>NGS</th>';
                echo '<th>PAJUELA</th><th>RESERVAR</th></tr>';
                while ($res = $rRes->fetch(PDO::FETCH_ASSOC)) {
                    $c++;
                    if ($ubica == $res['T'] . '-' . $res['C'] . '-' . $res['G'] . '-' . $res['P']) $borde = ''; else $borde = 'style="border-top: 1px solid #72a2aa;"';
                    echo '<tr ' . $borde . '><td>' . $res['ovo'] . '</td>';
                    if ($_POST['h'] == 1 or $_POST['h'] == 3) {
                        if ($res['d2f_cic'] <> '') {
                            echo '<td>' . $res['d2cel'] . '-' . $res['d2fra'] . '%-' . $res['d2sim'] . '</td>';
                            if ($res['d2f_cic'] == 'C') $des_dia = 2;
                        } else echo '<td>-</td>';
                        if ($res['d3f_cic'] <> '') {
                            echo '<td>' . $res['d3cel'] . '-' . $res['d3fra'] . '%-' . $res['d3sim'] . '</td>';
                            if ($res['d3f_cic'] == 'C') $des_dia = 3;
                        } else echo '<td>-</td>';
                        if ($res['d4f_cic'] <> '') {
                            echo '<td>' . $res['d4cel'] . '-' . $res['d4fra'] . '%-' . $res['d4sim'] . '</td>';
                            if ($res['d4f_cic'] == 'C') $des_dia = 4;
                        } else echo '<td>-</td>';
                        if ($res['d5f_cic'] <> '') {
                            echo '<td>' . $res['d5cel'] . '</td>';
                            if ($res['d5f_cic'] == 'C') $des_dia = 5;
                        } else echo '<td>-</td>';
                        if ($res['d6f_cic'] <> '') {
                            echo '<td>' . $res['d6cel'] . '</td>';
                            if ($res['d6f_cic'] == 'C') $des_dia = 6;
                        } else echo '<td>-</td>';
                        $ngs = '-';
                        $ngs3 = '';
                        if ($res['ngs1'] == 1) $ngs = 'Normal';
                        if ($res['ngs1'] == 2) $ngs = '<font color="red">Anormal</font>';
                        if ($res['ngs1'] == 3) $ngs = 'NR';
                        if ($res['ngs3'] == 1) $ngs3 = ' (H)';
                        if ($res['ngs3'] == 2) $ngs3 = ' (M)';
                        echo '<td><a href="analisis/ngs_' . $asp['pro'] . '.pdf" target="new">' . $ngs . $ngs3 . '</a></td>';
                    }
                    if ($res['d0f_cic'] == 'C') $des_dia = 0;
                    $ubica = $res['T'] . '-' . $res['C'] . '-' . $res['G'] . '-' . $res['P'];
                    echo '<td>' . $ubica . '</td>';
                    if ($res['adju'] == '') $check = ''; else $check = 'checked';
                    echo '<input type="hidden" name="c' . $c . '" value="' . $asp['pro'] . '|' . $res['ovo'] . '">';
                    echo '<td><input type="checkbox" name="adju' . $c . '" id="' . $des_dia . '" class="deschk" value="' . $_POST['paci'] . '" data-mini="true" ' . $check . '></td></tr>';

                }
                echo '</table>';

            } else $vacio++;

        }
        if ($vacio == $rAsp->rowCount()) {
            echo '<p>Sin ' . $ovo_emb . '</p>';
        } else {
            echo '<input type="hidden" name="cont" value="' . $c . '">';
            if ($_POST['btn_guarda'] == 1) { // 1=interface del medico 2=reserva de embiones ovulos
                echo '<input type="hidden" name="des_dia" id="des_dia">';
                if ($_POST['h'] == 1 or $_POST['h'] == 2) echo '<input type="hidden" name="des_don" id="des_don" value="' . $_POST['dni'] . '">'; // ovo/embrio donados
                echo '<textarea name="obs" id="obs" placeholder="Observaciones"></textarea>';
            } else {
                echo '<input type="submit" name="guardar" value="GUARDAR" data-icon="check" data-iconpos="left" data-mini="true" data-theme="b" data-inline="true"/><b class="color">Debe reservar los ' . $ovo_emb . ' agrupados por PAJUELA</b>';
            }
        }

    } else echo '<p>Sin Procedimientos</p>';

}

if ($_POST['depa']) {

    $rProv = $db->prepare("SELECT * FROM provincias WHERE Iddepartamento=? ORDER BY nomprovincia ASC");
    $rProv->execute(array($_POST['depa']));

    echo '<option value="">Provincia:</option>';
    while ($prov = $rProv->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value=" . $prov['idprovincia'] . ">" . $prov['nomprovincia'] . "</option>";
    }

}

if ($_POST['prov']) {

    $rDist = $db->prepare("SELECT * FROM distritos WHERE idprovincia=? ORDER BY nomdistrito ASC");
    $rDist->execute(array($_POST['prov']));

    echo '<option value="">Distrito:</option>';
    while ($dist = $rDist->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value=" . $dist['iddistrito'] . ">" . $dist['nomdistrito'] . "</option>";
    }

}

if ($_POST['pak'] and $_POST['t_ser'] and $_POST['mon'] and $_POST['tip']) {

    $rPak = $db->prepare("SELECT nom,costo,cod,cc FROM recibo_serv WHERE tip=? AND pak=?");
    $rPak->execute(array($_POST['t_ser'], $_POST['pak']));
    $cadena = '';
    while ($pak = $rPak->fetch(PDO::FETCH_ASSOC)) {
        if ($_POST['t_ser'] == 3) {
            $costo = $pak['costo'] * $_POST['mon']; //cambia en dolares -------------------
            $cc = "CC" . $pak['cc'] . ":";
        } else {
            $costo = round($pak['costo'] / $_POST['mon']); //cambia en soles -------------------
            $cc = "";
        }

        if ($_POST['tip'] == 2) $costo = round($costo / 1.18, 2); //muestra costo unitario con igv

        echo "<tr><td>" . $cc . $pak['nom'] . "</td><td>" . $costo . "</td></tr>";

        if ($cadena == '')
            $cadena = $pak['cod'];
        else
            $cadena = $cadena . "," . $pak['cod'];

        if ($_POST['t_ser'] == 1 or $_POST['t_ser'] == 2 or $_POST['t_ser'] == 3)
            $total = $total + ($pak['costo'] * $_POST['mon']);
        else
            $total = $total + ($pak['costo'] / $_POST['mon']);
    }
    echo '|' . round($total, 2) . '|' . round($total - ($total / 1.18), 2) . '|' . $cadena;
}

if ($_POST['med']) {
    $rMed = $db->prepare("SELECT nom FROM usuario WHERE user=?");
    $rMed->execute(array($_POST['med']));
    $med = $rMed->fetch(PDO::FETCH_ASSOC);
    echo $med['nom'];
}

if ($_POST['carga_paci'] == 1) {
    $rPaci = $db->prepare("SELECT dni,ape,nom,med FROM hc_paciente UNION SELECT p_dni,p_ape,p_nom,p_med FROM hc_pareja");
    $rPaci->execute();
    echo '<ul data-role="listview" data-theme="c" data-inset="true" data-filter="true"
    data-filter-reveal="true" data-filter-placeholder="Buscar paciente por Nombre o DNI.."
    data-mini="true"
    class="fil_paci">';
    while ($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {
        echo '<li><a href="#" class="paci_insert" dni="' . $paci['dni'] . '" med="' . $paci['med'] . '"><small>' . $paci['ape'] . ' ' . $paci['nom'] . '</small></a><span class="ui-li-count">' . $paci['dni'] . '</span></li>';
    }
    echo '</ul>';
}
?>