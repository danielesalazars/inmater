<?php try {
    //$db = new PDO('mysql:host=localhost;dbname=vigose5_inmater;charset=utf8', 'root', '');
    $db = new PDO('mysql:host=localhost;dbname=inmater;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}
function authentification($user, $pass)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM usuario WHERE user=? AND pass=?");
    $stmt->execute(array($user, $pass));
    if ($stmt->rowCount() > 0) return TRUE; else return FALSE;
}

function updatePerfil($login, $pass, $nom, $mail, $cmp)
{

    global $db;

    if ($pass == "") {
        $stmt = $db->prepare("UPDATE usuario SET nom=?,mail=?,cmp=? WHERE user=?");
        $stmt->execute(array($nom, $mail, $cmp, $login));
    } else {
        $stmt = $db->prepare("UPDATE usuario SET pass=?,nom=?,mail=?,cmp=? WHERE user=?");
        $stmt->execute(array($pass, $nom, $mail, $cmp, $login));
    }

    ?>
    <script type="text/javascript">
        window.parent.location.href = "lista.php";
    </script>
    <?php
}

// --------------------------------------- CLINICA -------------------------------------------------------------------------------

function insertPaci($dni, $med, $tip, $nom, $ape, $fnac, $tcel, $tcas, $tofi, $mai, $dir, $nac, $depa, $prov, $dist, $prof, $san, $don, $raz, $foto, $rem, $sta)
{
    global $db;

    $rPaci = $db->prepare("SELECT dni,nom,ape,med FROM hc_paciente WHERE dni=?");
    $rPaci->execute(array($dni));

    if ($rPaci->rowCount() < 1) { // Nuevo paciente
        $stmt = $db->prepare("INSERT INTO hc_paciente (dni,pass,med,tip,nom,ape,fnac,tcel,tcas,tofi,mai,dir,nac,depa,prov,dist,prof,san,don,raz,rem,sta) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($dni, $dni, $med, $tip, $nom, $ape, $fnac, $tcel, $tcas, $tofi, $mai, $dir, $nac, $depa, $prov, $dist, $prof, $san, $don, $raz, $rem, $sta));

        $stmt = $db->prepare("INSERT INTO hc_antece (dni) VALUES (?)");
        $stmt->execute(array($dni));
        mkdir('paci/' . $dni, 0755);
    } else { //Paciente ya existe
        $paci = $rPaci->fetch(PDO::FETCH_ASSOC);
        if (strpos($paci['med'], $med) !== false) { // si el medico YA esta en la lista de medicos ?>
            <script type="text/javascript">
                alert("<?php echo $paci['nom'] . " " . $paci['ape']; ?> \n YA EXISTE EN SU LISTA DE PACIENTES!");
            </script>
        <?php } else { // agrega al nuevo medico al pacientes ya existente
            $stmt = $db->prepare("UPDATE hc_paciente SET med=? WHERE dni=?");
            $stmt->execute(array($med . ',' . $paci['med'], $dni)); ?>
            <script type="text/javascript">
                alert("<?php echo $paci['nom'] . " " . $paci['ape']; ?> es paciente de otro médico en el sistema. \n Será agregada con su misma información, antecedentes y consultas a su lista de pacientes.");
            </script>
        <?php }
    }

    if ($foto['name'] <> "") {

        $nom_destination = 'paci/' . $dni . '/foto.jpg';

        if (is_uploaded_file($foto['tmp_name'])) move_uploaded_file($foto['tmp_name'], $nom_destination);

    }

}

function updatePaci($dni, $tip, $nom, $ape, $fnac, $tcel, $tcas, $tofi, $mai, $dir, $nac, $depa, $prov, $dist, $prof, $san, $don, $raz, $peso, $talla, $foto, $rem, $sta)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_paciente SET tip=?,nom=?,ape=?,fnac=?,tcel=?,tcas=?,tofi=?,mai=?,dir=?,nac=?,depa=?,prov=?,dist=?,prof=?,san=?,don=?,raz=?,peso=?,talla=?,rem=?,sta=? WHERE dni=?");
    $stmt->execute(array($tip, $nom, $ape, $fnac, $tcel, $tcas, $tofi, $mai, $dir, $nac, $depa, $prov, $dist, $prof, $san, $don, $raz, $peso, $talla, $rem, $sta, $dni));

    if ($foto['name'] <> "") {

        $nom_destination = 'paci/' . $dni . '/foto.jpg';

        if (is_uploaded_file($foto['tmp_name'])) move_uploaded_file($foto['tmp_name'], $nom_destination);

    }

}

function updatePaciAnte($dni, $f_dia, $f_hip, $f_gem, $f_hta, $f_tbc, $f_can, $f_otr, $m_dia, $m_hip, $m_inf, $m_ale, $m_ale1, $m_tbc, $m_ets, $m_can, $m_otr, $h_str, $h_dep, $h_dro, $h_tab, $h_alc, $h_otr, $g_men, $g_per, $g_dur, $g_vol, $g_fur, $g_ant, $g_pap, $g_pap1, $g_pap2, $g_dis, $g_ges, $g_abo, $g_abo1, $g_abo_ges, $g_abo_com, $g_pt, $g_pp, $g_vag, $g_ces, $g_nv, $g_nm, $g_neo, $g_viv, $g_fup, $g_rn_men, $g_rn_mul, $g_rn_may, $g_agh, $g_his, $g_obs, $fe_exa)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_antece SET f_dia=?,f_hip=?,f_gem=?,f_hta=?,f_tbc=?,f_can=?,f_otr=?,m_dia=?,m_hip=?,m_inf=?,m_ale=?,m_ale1=?,m_tbc=?,m_ets=?,m_can=?,m_otr=?,h_str=?,h_dep=?,h_dro=?,h_tab=?,h_alc=?,h_otr=?,g_men=?,g_per=?,g_dur=?,g_vol=?,g_fur=?,g_ant=?,g_pap=?,g_pap1=?,g_pap2=?,g_dis=?,g_ges=?,g_abo=?,g_abo1=?,g_abo_ges=?,g_abo_com=?,g_pt=?,g_pp=?,g_vag=?,g_ces=?,g_nv=?,g_nm=?,g_neo=?,g_viv=?,g_fup=?,g_rn_men=?,g_rn_mul=?,g_rn_may=?,g_agh=?,g_his=?,g_obs=?,fe_exa=? WHERE dni=?");
    $stmt->execute(array($f_dia, $f_hip, $f_gem, $f_hta, $f_tbc, $f_can, $f_otr, $m_dia, $m_hip, $m_inf, $m_ale, $m_ale1, $m_tbc, $m_ets, $m_can, $m_otr, $h_str, $h_dep, $h_dro, $h_tab, $h_alc, $h_otr, $g_men, $g_per, $g_dur, $g_vol, $g_fur, $g_ant, $g_pap, $g_pap1, $g_pap2, $g_dis, $g_ges, $g_abo, $g_abo1, $g_abo_ges, $g_abo_com, $g_pt, $g_pp, $g_vag, $g_ces, $g_nv, $g_nm, $g_neo, $g_viv, $g_fup, $g_rn_men, $g_rn_mul, $g_rn_may, $g_agh, $g_his, $g_obs, $fe_exa, $dni));

    echo "<div id='alerta'> Datos actualizados! </div>";

}

function updateAnte_quiru($id, $dni, $fec, $pro, $med, $dia, $lug, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_quiru (dni,fec,pro,med,dia,lug) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($dni, $fec, $pro, $med, $dia, $lug));
        $id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_quiru SET fec=?,pro=?,med=?,dia=?,lug=? WHERE id=?");
        $stmt->execute(array($fec, $pro, $med, $dia, $lug, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/quiru_' . $id . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "e_paci.php?id=" + x + "&pop=Quiru";
    </script>
    <?php
}

function updateAnte_pap($id, $dni, $fec, $tip, $obs)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_pap (dni,fec,tip,obs) VALUES (?,?,?,?)");
        $stmt->execute(array($dni, $fec, $tip, $obs));
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_pap SET fec=?,tip=?,obs=? WHERE id=?");
        $stmt->execute(array($fec, $tip, $obs, $id));
    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "e_paci.php?id=" + x + "&pop=Pap";
    </script>
    <?php
}

function updateAnte_hsghes($id, $dni, $fec, $tip, $con, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_hsghes (dni,fec,tip,con) VALUES (?,?,?,?)");
        $stmt->execute(array($dni, $fec, $tip, $con));
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_hsghes SET fec=?,tip=?,con=? WHERE dni=? AND fec=?");
        $stmt->execute(array($fec, $tip, $con, $dni, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/hsghes_' . $dni . '_' . $fec . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "e_paci.php?id=" + x + "&pop=Perfi";
    </script>
    <?php
}

function updateAnte_perfi($id, $dni, $fec, $fsh, $lh, $est, $prol, $ins, $t3, $t4, $tsh, $amh, $inh, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_perfi (dni,fec,fsh,lh,est,prol,ins,t3,t4,tsh,amh,inh) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($dni, $fec, $fsh, $lh, $est, $prol, $ins, $t3, $t4, $tsh, $amh, $inh));
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_perfi SET fec=?,fsh=?,lh=?,est=?,prol=?,ins=?,t3=?,t4=?,tsh=?,amh=?,inh=? WHERE dni=? AND fec=?");
        $stmt->execute(array($fec, $fsh, $lh, $est, $prol, $ins, $t3, $t4, $tsh, $amh, $inh, $dni, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/perfil_' . $dni . '_' . $fec . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "e_paci.php?id=" + x + "&pop=Perfi";
    </script>
    <?php
}

function updateAnte_cirug($id, $dni, $fec, $pro, $med, $dia, $lug, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_cirug (dni,fec,pro,med,dia,lug) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($dni, $fec, $pro, $med, $dia, $lug));
        $id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_cirug SET fec=?,pro=?,med=?,dia=?,lug=? WHERE id=?");
        $stmt->execute(array($fec, $pro, $med, $dia, $lug, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/cirug_' . $id . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "e_paci.php?id=" + x + "&pop=Cirug";
    </script>
    <?php
}

function updateAnte_trata($id, $dni, $fec, $pro, $med, $medica, $fol, $ovo, $emb, $dia, $cri, $res, $tras)
{
    global $db;
    if ($id == "") {
        if ($tras = 'x') {
            $tras = 1;
            $tras_sms = 1;
        }
        $stmt = $db->prepare("INSERT INTO hc_antece_trata (dni,fec,pro,med,medica,fol,ovo,emb,dia,cri,res,tras) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($dni, $fec, $pro, $med, $medica, $fol, $ovo, $emb, $dia, $cri, $res, $tras));
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_trata SET fec=?,pro=?,med=?,medica=?,fol=?,ovo=?,emb=?,dia=?,cri=?,res=?,tras=? WHERE id=?");
        $stmt->execute(array($fec, $pro, $med, $medica, $fol, $ovo, $emb, $dia, $cri, $res, $tras, $id));
    }
    if ($tras_sms == 1) echo "<div id='alerta'> Traslado Agregado! </div>";
    else { ?>
        <script type="text/javascript">
            var x = "<?php echo $dni; ?>";
            window.parent.location.href = "e_paci.php?id=" + x + "&pop=Trata";
        </script>
    <?php }
}

function insertPareja($dni, $p_dni, $p_tip, $p_nom, $p_ape, $p_fnac, $p_tcel, $p_tcas, $p_tofi, $p_mai, $p_dir, $p_prof, $p_san, $p_raz, $p_med, $p_med_mai, $p_med_cel)
{
    global $db;

    $rPare = $db->prepare("SELECT p_dni,p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
    $rPare->execute(array($p_dni));

    if ($rPare->rowCount() < 1) {

        $stmt = $db->prepare("INSERT INTO hc_pareja (p_dni,p_tip,p_nom,p_ape,p_fnac,p_tcel,p_tcas,p_tofi,p_mai,p_dir,p_prof,p_san,p_raz,p_med,p_med_mai,p_med_cel) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($p_dni, $p_tip, $p_nom, $p_ape, $p_fnac, $p_tcel, $p_tcas, $p_tofi, $p_mai, $p_dir, $p_prof, $p_san, $p_raz, $p_med, $p_med_mai, $p_med_cel));
        $stmt2 = $db->prepare("INSERT INTO hc_pare_paci (dni,p_dni) VALUES (?,?)");
        $stmt2->execute(array($dni, $p_dni));

    } else {
        $pare = $rPare->fetch(PDO::FETCH_ASSOC);
        ?>
        <script type="text/javascript">
            //if (confirm("Presione ACEPTAR para efectuar la donación, los cambios seran IRREVERSIBLES por Ud.")) {
            alert("<?php echo $pare['p_nom'] . " " . $pare['p_ape']; ?> \n YA EXISTE EN EL SISTEMA!");
        </script>
        <?php if ($dni <> "") {
            $stmt2 = $db->prepare("INSERT INTO hc_pare_paci (dni,p_dni) VALUES (?,?)");
            $stmt2->execute(array($dni, $p_dni));
            echo "<div id='alerta'> Datos guardados en el historial de parejas! </div>";
        }
    }

    if ($_SESSION['login'] == "lab") { ?>
        <script type="text/javascript">
            window.parent.location.href = "lista_and.php";
        </script>
        <?php
    }
    if ($_SESSION['login'] == "pagos") { ?>
        <script type="text/javascript">
            window.parent.location.href = "lista.php";
        </script>
        <?php
    }
}

function updatePareja($dni, $p_dni, $p_tip, $p_nom, $p_ape, $p_fnac, $p_tcel, $p_tcas, $p_tofi, $p_mai, $p_dir, $p_prof, $p_san, $p_raz, $p_f_dia, $p_f_hip, $p_f_gem, $p_f_hta, $p_f_tbc, $p_f_can, $p_f_otr, $p_m_dia, $p_m_hip, $p_m_inf1, $p_m_ale1, $p_m_tbc, $p_m_can, $p_m_otr, $p_m_ets, $p_h_str, $p_h_dep, $p_h_dro, $p_h_tab, $p_h_alc, $p_h_otr, $p_obs, $p_pes, $p_tal, $p_ojo, $p_cab, $p_ins, $p_icq, $foto, $foto1, $foto2, $doc1, $doc2, $doc3, $doc4, $p_het, $p_med, $p_med_mai, $p_med_cel, $role)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_pareja SET p_tip=?,p_nom=?,p_ape=?,p_fnac=?,p_tcel=?,p_tcas=?,p_tofi=?,p_mai=?,p_dir=?,p_prof=?,p_san=?,p_raz=?,p_f_dia=?,p_f_hip=?,p_f_gem=?,p_f_hta=?,p_f_tbc=?,p_f_can=?,p_f_otr=?,p_m_dia=?,p_m_hip=?,p_m_inf=?,p_m_ale=?,p_m_tbc=?,p_m_can=?,p_m_otr=?,p_m_ets=?,p_h_str=?,p_h_dep=?,p_h_dro=?,p_h_tab=?,p_h_alc=?,p_h_otr=?,p_obs=?,p_pes=?,p_tal=?,p_ojo=?,p_cab=?,p_ins=?,p_icq=?,p_med=?,p_med_mai=?,p_med_cel=? WHERE p_dni=?");
    $stmt->execute(array($p_tip, $p_nom, $p_ape, $p_fnac, $p_tcel, $p_tcas, $p_tofi, $p_mai, $p_dir, $p_prof, $p_san, $p_raz, $p_f_dia, $p_f_hip, $p_f_gem, $p_f_hta, $p_f_tbc, $p_f_can, $p_f_otr, $p_m_dia, $p_m_hip, $p_m_inf1, $p_m_ale1, $p_m_tbc, $p_m_can, $p_m_otr, $p_m_ets, $p_h_str, $p_h_dep, $p_h_dro, $p_h_tab, $p_h_alc, $p_h_otr, $p_obs, $p_pes, $p_tal, $p_ojo, $p_cab, $p_ins, $p_icq, $p_med, $p_med_mai, $p_med_cel, $p_dni));

    if ($dni == "") {
        $stmt2 = $db->prepare("UPDATE hc_pare_paci SET p_het=? WHERE dni=? AND p_dni=?");
        $stmt2->execute(array($p_het, '', $p_dni));
    }

    $dir = 'pare/' . $p_dni;
    if (!file_exists($dir)) mkdir($dir, 0755, true);

    if (is_uploaded_file($foto['tmp_name'])) {
        $ruta = $dir . '/foto.jpg';
        move_uploaded_file($foto['tmp_name'], $ruta);
    }
    if (is_uploaded_file($foto1['tmp_name'])) {
        $ruta = $dir . '/foto1.jpg';
        move_uploaded_file($foto1['tmp_name'], $ruta);
    }
    if (is_uploaded_file($foto2['tmp_name'])) {
        $ruta = $dir . '/foto2.jpg';
        move_uploaded_file($foto2['tmp_name'], $ruta);
    }
    if (is_uploaded_file($doc1['tmp_name'])) {
        $ruta = $dir . '/eval_sico.pdf';
        move_uploaded_file($doc1['tmp_name'], $ruta);
    }
    if (is_uploaded_file($doc2['tmp_name'])) {
        $ruta = $dir . '/careotipo.pdf';
        move_uploaded_file($doc2['tmp_name'], $ruta);
    }
    if (is_uploaded_file($doc3['tmp_name'])) {
        $ruta = $dir . '/frag_adn.pdf';
        move_uploaded_file($doc3['tmp_name'], $ruta);
    }
    if (is_uploaded_file($doc4['tmp_name'])) {
        $ruta = $dir . '/fish_spz.pdf';
        move_uploaded_file($doc4['tmp_name'], $ruta);
    }

    if ($role == 7) echo "<div id='alerta'> Datos guardados! </div>"; // cuando es urologo
    else {
        ?>
        <script type="text/javascript">
            var x = "<?php if ($_SESSION['login'] == "lab") echo "lista_and.php"; else if ($_SESSION['login'] == "pagos") echo "lista.php"; else echo "n_pare.php?id=" . $dni; ?>";
            window.parent.location.href = x;
        </script>
    <?php }

}

function updateAnte_p_examp($id, $dni, $p_dni, $fec, $tip, $con, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_p_examp (p_dni,fec,tip,con) VALUES (?,?,?,?)");
        $stmt->execute(array($p_dni, $fec, $tip, $con));
        $id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_p_examp SET fec=?,tip=?,con=? WHERE id=?");
        $stmt->execute(array($fec, $tip, $con, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/p_examp_' . $id . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Examp";
    </script>
    <?php
}


function updateAnte_p_quiru($id, $dni, $p_dni, $fec, $pro, $med, $dia, $lug, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_p_quiru (p_dni,fec,pro,med,dia,lug) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($p_dni, $fec, $pro, $med, $dia, $lug));
        $id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_p_quiru SET fec=?,pro=?,med=?,dia=?,lug=? WHERE id=?");
        $stmt->execute(array($fec, $pro, $med, $dia, $lug, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/p_quiru_' . $id . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Quiru";
    </script>
    <?php
}

function updateAnte_p_sero($id, $dni, $p_dni, $fec, $hbs, $hcv, $hiv, $rpr, $rub, $tox, $cla_g, $cla_m, $pdf)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_antece_p_sero (p_dni,fec,hbs,hcv,hiv,rpr,rub,tox,cla_g,cla_m) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($p_dni, $fec, $hbs, $hcv, $hiv, $rpr, $rub, $tox, $cla_g, $cla_m));
    } else {
        $stmt = $db->prepare("UPDATE hc_antece_p_sero SET fec=?,hbs=?,hcv=?,hiv=?,rpr=?,rub=?,tox=?,cla_g=?,cla_m=? WHERE p_dni=? AND fec=?");
        $stmt->execute(array($fec, $hbs, $hcv, $hiv, $rpr, $rub, $tox, $cla_g, $cla_m, $p_dni, $id));
    }
    if (is_uploaded_file($pdf['tmp_name'])) {
        $ruta = 'analisis/sero_' . $p_dni . '_' . $fec . '.pdf';
        move_uploaded_file($pdf['tmp_name'], $ruta);
    } ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";

        <?php if ($dni == "mujer") { ?>
        window.parent.location.href = "e_paci.php?id=" + y + "&pop=Perfi";
        <?php } else { ?>
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Sero";
        <?php } ?>
    </script>
    <?php
}

function updateAndro_esp($id, $dni, $p_dni, $fec, $vol_f, $con_f, $via, $agl, $sha, $c_red, $ph, $lic, $deb, $con, $pl_f, $pnl_f, $ins_f, $inm_f, $m_n, $m_a, $m_mic, $m_mac, $m_cab, $m_col, $m_inm, $m_bic, $m_bic2, $nota, $emb)
{
    global $db;

    try {

        if ($id == "") {
            $stmt = $db->prepare("INSERT INTO lab_andro_esp (p_dni,fec) VALUES (?,?)");
            $stmt->execute(array($p_dni, $fec));
        } else {
            $stmt = $db->prepare("UPDATE lab_andro_esp SET fec=?,vol_f=?,con_f=?,via=?,agl=?,sha=?,c_red=?,ph=?,lic=?,deb=?,con=?,pl_f=?,pnl_f=?,ins_f=?,inm_f=?,m_n=?,m_a=?,m_mic=?,m_mac=?,m_cab=?,m_col=?,m_inm=?,m_bic=?,m_bic2=?,nota=?,emb=? WHERE p_dni=? AND fec=?");
            $stmt->execute(array($fec, $vol_f, $con_f, $via, $agl, $sha, $c_red, $ph, $lic, $deb, $con, $pl_f, $pnl_f, $ins_f, $inm_f, $m_n, $m_a, $m_mic, $m_mac, $m_cab, $m_col, $m_inm, $m_bic, $m_bic2, $nota, $emb, $p_dni, $id));
        }

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) { ?>
            <script type="text/javascript"> alert("No puede ingresar datos en la misma Fecha!"); </script>
        <?php } else {
            echo $e->getMessage();
        }
    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Esp";
    </script>
    <?php
}

function updateAndro_cap($id, $dni, $p_dni, $fec, $vol_f, $con_f, $esp, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $mue, $des_tip, $des_fec, $cont, $des, $pro, $p_dni_het, $emb)
{
    global $db;

    if ($cont > 0 and $mue >= 3 and $des == "") {

        for ($p = 1; $p <= $cont; $p++) {
            if (isset($_POST['c' . $p])) {
                $tan = explode("-", $_POST['c' . $p]);
                $stmt2 = $db->prepare("UPDATE lab_tanque_res SET sta=?,tip=?,tip_id=? WHERE T=? AND C=? AND V=? AND P=?");
                $stmt2->execute(array("", 0, "", $tan[0], $tan[1], $tan[2], $tan[3]));
                $des .= $tan[0] . '-' . $tan[1] . '-' . $tan[2] . '-' . $tan[3] . '|';
            }
        }

    }

    if ($mue == 4) $des_dni = $p_dni_het; else $des_dni = $p_dni;

    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO lab_andro_cap (p_dni,fec,vol_f,con_f,esp,con_c,pl_f,pl_c,pnl_f,pnl_c,ins_f,ins_c,inm_f,inm_c,cap,sel,mue,des,des_tip,des_fec,des_dni,pro,emb) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($p_dni, $fec, $vol_f, $con_f, $esp, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $mue, $des, $des_tip, $des_fec, $des_dni, $pro, $emb));
    } else {
        $stmt = $db->prepare("UPDATE lab_andro_cap SET fec=?,vol_f=?,con_f=?,esp=?,con_c=?,pl_f=?,pl_c=?,pnl_f=?,pnl_c=?,ins_f=?,ins_c=?,inm_f=?,inm_c=?,cap=?,sel=?,mue=?,des=?,des_tip=?,des_fec=?,des_dni=?,emb=? WHERE id=?");
        $stmt->execute(array($fec, $vol_f, $con_f, $esp, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $mue, $des, $des_tip, $des_fec, $des_dni, $emb, $id));
    }

    if ($pro == "") { ?>
        <script type="text/javascript">
            var x = "<?php echo $dni; ?>";
            var y = "<?php echo $p_dni; ?>";
            //window.parent.location.href="e_pare.php?id="+x+"&ip="+y+"&pop=p_Cap"; // para borrar sino dicen nada
            window.parent.location.href = "lista_cap.php";
        </script>
    <?php } else { ?>
        <script type="text/javascript">
            var x = "<?php echo $pro; ?>";
            window.parent.location.href = "le_aspi0.php?id=" + x;
        </script>
    <?php }
}

function updateAndro_tes_cap($id, $dni, $p_dni, $fec, $vol_f, $con_f, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $emb)
{
    global $db;

    try {

        if ($id == "") {
            $stmt = $db->prepare("INSERT INTO lab_andro_tes_cap (p_dni,fec) VALUES (?,?)");
            $stmt->execute(array($p_dni, $fec));
        } else {
            $stmt = $db->prepare("UPDATE lab_andro_tes_cap SET fec=?,vol_f=?,con_f=?,con_c=?,pl_f=?,pl_c=?,pnl_f=?,pnl_c=?,ins_f=?,ins_c=?,inm_f=?,inm_c=?,cap=?,sel=?,emb=? WHERE p_dni=? AND fec=?");
            $stmt->execute(array($fec, $vol_f, $con_f, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $emb, $p_dni, $id));
        }

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            ?>
            <script type="text/javascript"> alert("No puede ingresar datos en la misma Fecha!"); </script>  <?php
        } else {
            echo $e->getMessage();
        }
    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Tes_cap";
    </script>
    <?php
}

function updateAndro_tes_sob($id, $dni, $p_dni, $fec, $vol_f, $con_f, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $emb)
{
    global $db;

    try {

        if ($id == "") {
            $stmt = $db->prepare("INSERT INTO lab_andro_tes_sob (p_dni,fec) VALUES (?,?)");
            $stmt->execute(array($p_dni, $fec));
        } else {
            $stmt = $db->prepare("UPDATE lab_andro_tes_sob SET fec=?,vol_f=?,con_f=?,con_c=?,pl_f=?,pl_c=?,pnl_f=?,pnl_c=?,ins_f=?,ins_c=?,inm_f=?,inm_c=?,cap=?,sel=?,emb=? WHERE p_dni=? AND fec=?");
            $stmt->execute(array($fec, $vol_f, $con_f, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $cap, $sel, $emb, $p_dni, $id));
        }

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            ?>
            <script type="text/javascript"> alert("No puede ingresar datos en la misma Fecha!"); </script>  <?php
        } else {
            echo $e->getMessage();
        }
    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Tes_sob";
    </script>
    <?php
}

function updateAndro_bio_tes($id, $dni, $p_dni, $fec, $tip, $con_f, $esp, $nota, $pl_f, $pnl_f, $ins_f, $inm_f, $crio, $tra, $doc, $vol, $via, $met, $emb, $c_tan, $c_can, $v_p)
{
    global $db;

    try {

        if ($id == "") {
            $stmt = $db->prepare("INSERT INTO lab_andro_bio_tes (p_dni,fec) VALUES (?,?)");
            $stmt->execute(array($p_dni, $fec));

        } else {

            $stmt = $db->prepare("UPDATE lab_andro_bio_tes SET fec=?,tip=?,con_f=?,esp=?,nota=?,pl_f=?,pnl_f=?,ins_f=?,inm_f=?,crio=?,tra=?,vol=?,via=?,met=?,emb=? WHERE p_dni=? AND fec=?");
            $stmt->execute(array($fec, $tip, $con_f, $esp, $nota, $pl_f, $pnl_f, $ins_f, $inm_f, $crio, $tra, $vol, $via, $met, $emb, $p_dni, $id));
        }

        if ($c_tan > 0 and $c_can > 0 and $crio == 1) {

            if ($doc['name'] <> "") {
                $dir = 'pare/' . $p_dni;
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                if (is_uploaded_file($doc['tmp_name'])) {
                    $ruta = $dir . '/biopsia_traslado_' . $fec . '.pdf';
                    move_uploaded_file($doc['tmp_name'], $ruta);
                }
            }
            $vp = explode("|", $v_p);

            for ($v = 1; $v <= $vp[0]; $v++) {
                for ($p = 1; $p <= $vp[1]; $p++) {

                    //echo "vial: ".$_POST[$v.'_'.$p]."---".$c_tan."_".$c_can."_".$v."_".$p."<br>";
                    if (isset($_POST[$v . '_' . $p])) {
                        $stmt2 = $db->prepare("UPDATE lab_tanque_res SET sta=?,tip=?,tip_id=? WHERE T=? AND C=? AND V=? AND P=?");
                        if ($_POST[$v . '_' . $p] == 1) // chekeado
                            $stmt2->execute(array($p_dni, 1, $fec, $c_tan, $c_can, $v, $p)); // 1=bio_tes 2=crio_sem 3=embrio 4=ovo
                        else
                            $stmt2->execute(array("", 0, "", $c_tan, $c_can, $v, $p));
                    }
                }
            }

        }

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            ?>
            <script type="text/javascript"> alert("No puede ingresar datos en la misma Fecha!"); </script>  <?php
        } else {
            echo $e->getMessage();
        }
    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Bio_tes";
    </script>
    <?php


}

function updateAndro_crio_sem($id, $dni, $p_dni, $fec, $vol_f, $vol_c, $con_f, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $obs, $cap, $tra, $doc, $vol, $via, $met, $emb, $c_tan, $c_can, $v_p)
{
    global $db;

    try {

        if ($id == "") {
            $stmt = $db->prepare("INSERT INTO lab_andro_crio_sem (p_dni,fec) VALUES (?,?)");
            $stmt->execute(array($p_dni, $fec));
        } else {
            $stmt = $db->prepare("UPDATE lab_andro_crio_sem SET fec=?,vol_f=?,vol_c=?,con_f=?,con_c=?,pl_f=?,pl_c=?,pnl_f=?,pnl_c=?,ins_f=?,ins_c=?,inm_f=?,inm_c=?,obs=?,cap=?,tra=?,vol=?,via=?,met=?,emb=? WHERE p_dni=? AND fec=?");
            $stmt->execute(array($fec, $vol_f, $vol_c, $con_f, $con_c, $pl_f, $pl_c, $pnl_f, $pnl_c, $ins_f, $ins_c, $inm_f, $inm_c, $obs, $cap, $tra, $vol, $via, $met, $emb, $p_dni, $id));
        }

        if ($c_tan > 0 and $c_can > 0) {
            if ($doc['name'] <> "") {
                $dir = 'pare/' . $p_dni;
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                if (is_uploaded_file($doc['tmp_name'])) {
                    $ruta = $dir . '/crio_traslado_' . $fec . '.pdf';
                    move_uploaded_file($doc['tmp_name'], $ruta);
                }
            }
            $vp = explode("|", $v_p);

            for ($v = 1; $v <= $vp[0]; $v++) {
                for ($p = 1; $p <= $vp[1]; $p++) {

                    //echo "vial: ".$_POST[$v.'_'.$p]."---".$c_tan."_".$c_can."_".$v."_".$p."<br>";
                    if (isset($_POST[$v . '_' . $p])) {
                        $stmt2 = $db->prepare("UPDATE lab_tanque_res SET sta=?,tip=?,tip_id=? WHERE T=? AND C=? AND V=? AND P=?");
                        if ($_POST[$v . '_' . $p] == 1) // chekeado
                            $stmt2->execute(array($p_dni, 2, $fec, $c_tan, $c_can, $v, $p)); // 1=bio_tes 2=crio_sem 3=embrio 4=ovo
                        else
                            $stmt2->execute(array("", 0, "", $c_tan, $c_can, $v, $p));
                    }
                }
            }

        }

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            ?>
            <script type="text/javascript"> alert("No puede ingresar datos en la misma Fecha!"); </script>  <?php
        } else {
            echo $e->getMessage();
        }
    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        var y = "<?php echo $p_dni; ?>";
        window.parent.location.href = "e_pare.php?id=" + x + "&ip=" + y + "&pop=p_Crio_sem";
    </script>
    <?php
}

function updateUrolo($id, $fec, $fec_h, $fec_m, $mot, $dig, $medi, $aux, $e_sol, $in_t, $in_f2, $in_h2, $in_m2)
{
    global $db;
    $stmt = $db->prepare("UPDATE hc_urolo SET fec=?,fec_h=?,fec_m=?,mot=?,dig=?,medi=?,aux=?,e_sol=?,in_t=?,in_f2=?,in_h2=?,in_m2=? WHERE id=?");
    $stmt->execute(array($fec, $fec_h, $fec_m, $mot, $dig, $medi, $aux, $e_sol, $in_t, $in_f2, $in_h2, $in_m2, $id));
    echo "<div id='alerta'> Datos guardados! </div>";
}

function insertGine($dni, $fec, $med, $fec_h, $fec_m, $mot, $cupon)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO hc_gineco (dni,fec,med,fec_h,fec_m,mot,cupon) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute(array($dni, $fec, $med, $fec_h, $fec_m, $mot, $cupon));
    $idp = $db->lastInsertId();
    mkdir('paci/' . $dni . '/' . $idp, 0755); // crea carpeta para subir imagenes de los planes de trabajo -------
    echo "<div id='alerta'> Datos guardados en el historial de consultas! </div>";
}


function updateGine($id, $fec, $fec_h, $fec_m, $mot, $dig, $aux, $efec, $cic, $vag, $vul, $cer, $cer1, $mam, $mam1, $t_vag, $eco, $e_sol, $i_med, $i_fec, $i_obs, $in_t, $in_f1, $in_h1, $in_m1, $in_f2, $in_h2, $in_m2, $in_c, $repro)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_gineco SET fec=?,fec_h=?,fec_m=?,mot=?,dig=?,aux=?,efec=?,cic=?,vag=?,vul=?,cer=?,cer1=?,mam=?,mam1=?,t_vag=?,eco=?,e_sol=?,i_med=?,i_fec=?,i_obs=?,in_t=?,in_f1=?,in_h1=?,in_m1=?,in_f2=?,in_h2=?,in_m2=?,in_c=?,repro=? WHERE id=?");
    $stmt->execute(array($fec, $fec_h, $fec_m, $mot, $dig, $aux, $efec, $cic, $vag, $vul, $cer, $cer1, $mam, $mam1, $t_vag, $eco, $e_sol, $i_med, $i_fec, $i_obs, $in_t, $in_f1, $in_h1, $in_m1, $in_f2, $in_h2, $in_m2, $in_c, $repro, $id));
    echo "<div id='alerta'> Datos guardados! </div>";
}

function updateMedi($idx, $dni, $medi_name, $medi_dosis, $medi_frecuencia, $medi_cant_dias, $medi_init_fec, $medi_init_h, $medi_init_m, $medi_obs, $id)
{

    global $db;
    $medi=explode('|',$medi_name);
    if ($id == 0) {
        $stmt = $db->prepare("INSERT INTO hc_agenda (id,dni,medi_id,medi_name,medi_dosis,medi_frecuencia,medi_cant_dias,medi_init_fec,medi_init_h,medi_init_m,medi_obs) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($idx, $dni, $medi[0], $medi[1], $medi_dosis, $medi_frecuencia, $medi_cant_dias, $medi_init_fec, $medi_init_h, $medi_init_m, $medi_obs));
    } else {
        $stmt = $db->prepare("UPDATE hc_agenda SET medi_id=?,medi_name=?,medi_dosis=?,medi_frecuencia=?,medi_cant_dias=?,medi_init_fec=?,medi_init_h=?,medi_init_m=?,medi_obs=? WHERE id_agenda=?");
        $stmt->execute(array($medi[0], $medi[1], $medi_dosis, $medi_frecuencia, $medi_cant_dias, $medi_init_fec, $medi_init_h, $medi_init_m, $medi_obs, $id)); ?>
        <script type="text/javascript">
            var x = "<?php echo $idx; ?>";
            window.parent.location.href = "e_gine.php?id=" + x;
        </script>
    <?php }
}


function updateGine_plan($id, $idp, $fec, $plan, $foto, $dni)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_gineco_plan (idp,fec,plan) VALUES (?,?,?)");
        $stmt->execute(array($idp, $fec, $plan));
        $id = $db->lastInsertId();
        mkdir('paci/' . $dni . '/' . $idp . '/' . $id, 0755);
    } else {
        $stmt = $db->prepare("UPDATE hc_gineco_plan SET fec=?,plan=? WHERE id=?");
        $stmt->execute(array($fec, $plan, $id));
    }

    if ($foto['name'] <> "") {

        $nom_fichier = $foto['tmp_name'];
        $nom_destination = 'paci/' . $dni . '/' . $idp . '/' . $id . '/foto.jpg';

        $destino_temporal = tempnam("tmp/", "tmp");

        redimensionar_jpeg($nom_fichier, $destino_temporal, 800, 600, 100);

        $fp = fopen($nom_destination, "w");

        fputs($fp, fread(fopen($destino_temporal, "r"), filesize($destino_temporal)));

        fclose($fp);

    }
    ?>
    <script type="text/javascript">
        var x = "<?php echo $idp; ?>";
        window.parent.location.href = "e_gine.php?id=" + x + "&pop=Plan";
    </script>
    <?php
}

function insertObst($dni, $fec, $med, $g_3par, $g_rn_men, $g_gem, $g_ges, $g_abo, $g_pt, $g_pp, $g_vag, $g_ces, $g_nv, $g_nm, $g_viv, $g_m1, $g_m2, $g_fup, $g_rn_may, $pes, $tal, $fur, $fpp, $dud, $fuma, $vdrl, $vdrl_f, $hb, $hb_f)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO hc_obste (dni,fec,med,g_3par,g_rn_men,g_gem,g_ges,g_abo,g_pt,g_pp,g_vag,g_ces,g_nv,g_nm,g_viv,g_m1,g_m2,g_fup,g_rn_may,pes,tal,fur,fpp,dud,fuma,vdrl,vdrl_f,hb,hb_f) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($dni, $fec, $med, $g_3par, $g_rn_men, $g_gem, $g_ges, $g_abo, $g_pt, $g_pp, $g_vag, $g_ces, $g_nv, $g_nm, $g_viv, $g_m1, $g_m2, $g_fup, $g_rn_may, $pes, $tal, $fur, $fpp, $dud, $fuma, $vdrl, $vdrl_f, $hb, $hb_f));
    echo "<div id='alerta'> Datos guardados en el historial de Embarazos! </div>";
}

function updateObst($id, $dni, $g_3par, $g_rn_men, $g_gem, $g_ges, $g_abo, $g_pt, $g_pp, $g_vag, $g_ces, $g_nv, $g_nm, $g_viv, $g_m1, $g_m2, $g_fup, $g_rn_may, $pes, $tal, $fur, $fpp, $dud, $fuma, $vdrl, $vdrl_f, $hb, $hb_f, $con_fec, $con_fec_h, $con_fec_m, $con_sem, $con_eg, $con_pes, $con_pa, $con_mov, $con_ede, $con_la, $con_pla, $con_pre, $con_fcf, $con_pc, $con_lcn, $con_vv, $con_eco, $con_hb, $con_gi, $con_ori, $con_obs, $parto_sex, $parto_pes, $parto_tal, $parto_nom, $parto_nac, $parto_obs, $in_t, $in_f1, $in_h1, $in_m1, $in_f2, $in_h2, $in_m2, $in_c)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_obste SET g_3par=?,g_rn_men=?,g_gem=?,g_ges=?,g_abo=?,g_pt=?,g_pp=?,g_vag=?,g_ces=?,g_nv=?,g_nm=?,g_viv=?,g_m1=?,g_m2=?,g_fup=?,g_rn_may=?,pes=?,tal=?,fur=?,fpp=?,dud=?,fuma=?,vdrl=?,vdrl_f=?,hb=?,hb_f=?,con_fec=?,con_fec_h=?,con_fec_m=?,con_sem=?,con_eg=?,con_pes=?,con_pa=?,con_mov=?,con_ede=?,con_la=?,con_pla=?,con_pre=?,con_fcf=?,con_pc=?,con_lcn=?,con_vv=?,con_eco=?,con_hb=?,con_gi=?,con_ori=?,con_obs=?,parto_sex=?,parto_pes=?,parto_tal=?,parto_nom=?,parto_nac=?,parto_obs=?,in_t=?,in_f1=?,in_h1=?,in_m1=?,in_f2=?,in_h2=?,in_m2=?,in_c=? WHERE id=?");
    $stmt->execute(array($g_3par, $g_rn_men, $g_gem, $g_ges, $g_abo, $g_pt, $g_pp, $g_vag, $g_ces, $g_nv, $g_nm, $g_viv, $g_m1, $g_m2, $g_fup, $g_rn_may, $pes, $tal, $fur, $fpp, $dud, $fuma, $vdrl, $vdrl_f, $hb, $hb_f, $con_fec, $con_fec_h, $con_fec_m, $con_sem, $con_eg, $con_pes, $con_pa, $con_mov, $con_ede, $con_la, $con_pla, $con_pre, $con_fcf, $con_pc, $con_lcn, $con_vv, $con_eco, $con_hb, $con_gi, $con_ori, $con_obs, $parto_sex, $parto_pes, $parto_tal, $parto_nom, $parto_nac, $parto_obs, $in_t, $in_f1, $in_h1, $in_m1, $in_f2, $in_h2, $in_m2, $in_c, $id));

    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "n_obst.php?id=" + x;
    </script>
    <?php

}

function insertRepro($dni, $p_dni, $fec, $med, $eda, $p_cic, $p_fiv, $p_icsi, $des_dia, $des_don, $p_od, $p_don, $p_cri, $p_iiu, $t_mue, $obs)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO hc_reprod (dni,p_dni,fec,med,eda,p_cic,p_fiv,p_icsi,des_dia,des_don,p_od,p_don,p_cri,p_iiu,t_mue,obs) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($dni, $p_dni, $fec, $med, $eda, $p_cic, $p_fiv, $p_icsi, $des_dia, $des_don, $p_od, $p_don, $p_cri, $p_iiu, $t_mue, $obs));

    echo "<div id='alerta'> Datos guardados en el historial de Reproduccion Asistida! </div>";
}

function updateRepro($id, $eda, $p_dni_het, $p_cic, $p_fiv, $p_icsi, $p_od, $p_don, $p_cri, $p_iiu, $p_extras, $n_fol, $fur, $f_aco, $fsh, $lh, $est, $prol, $ins, $amh, $inh, $t3, $t4, $tsh, $m_agh, $m_vdrl, $m_clam, $m_his, $m_hsg, $f_fem, $f_mas, $con_fec, $con_od, $con_oi, $con_end, $con1_med, $con2_med, $con3_med, $con4_med, $con5_med, $con_iny, $con_obs, $obs, $f_iny, $h_iny, $f_asp, $cancela)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_reprod SET eda=?,p_dni_het=?,p_cic=?,p_fiv=?,p_icsi=?,p_od=?,p_don=?,p_cri=?,p_iiu=?,p_extras=?,n_fol=?,fur=?,f_aco=?,fsh=?,lh=?,est=?,prol=?,ins=?,amh=?,inh=?,t3=?,t4=?,tsh=?,m_agh=?,m_vdrl=?,m_clam=?,m_his=?,m_hsg=?,f_fem=?,f_mas=?,con_fec=?,con_od=?,con_oi=?,con_end=?,con1_med=?,con2_med=?,con3_med=?,con4_med=?,con5_med=?,con_iny=?,con_obs=?,obs=?,f_iny=?,h_iny=?,f_asp=?,cancela=? WHERE id=?");
    $stmt->execute(array($eda, $p_dni_het, $p_cic, $p_fiv, $p_icsi, $p_od, $p_don, $p_cri, $p_iiu, $p_extras, $n_fol, $fur, $f_aco, $fsh, $lh, $est, $prol, $ins, $amh, $inh, $t3, $t4, $tsh, $m_agh, $m_vdrl, $m_clam, $m_his, $m_hsg, $f_fem, $f_mas, $con_fec, $con_od, $con_oi, $con_end, $con1_med, $con2_med, $con3_med, $con4_med, $con5_med, $con_iny, $con_obs, $obs, $f_iny, $h_iny, $f_asp, $cancela, $id));

}

function updateRepro_info($pro_info, $dni, $pro, $rep, $nom_pro, $n_ovo, $nof, $ins, $pn2, $pn3, $inm, $atr, $ct, $ids, $d2, $d3, $d4, $d5, $d6, $d7, $c_T, $c_C, $bio, $fin, $obs, $f_tra, $h_tra)
{
    global $db;
    if ($pro_info == "") {
        $stmt = $db->prepare("INSERT INTO hc_reprod_info (pro,nom_pro,n_ovo,nof,ins,pn2,pn3,inm,atr,ct,ids,d2,d3,d4,d5,d6,d7,c_T,c_C,bio,fin,obs) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($pro, $nom_pro, $n_ovo, $nof, $ins, $pn2, $pn3, $inm, $atr, $ct, $ids, $d2, $d3, $d4, $d5, $d6, $d7, $c_T, $c_C, $bio, $fin, $obs));
    } else {
        $stmt = $db->prepare("UPDATE hc_reprod_info SET nom_pro=?,n_ovo=?,nof=?,ins=?,pn2=?,pn3=?,inm=?,atr=?,ct=?,ids=?,d2=?,d3=?,d4=?,d5=?,d6=?,d7=?,c_T=?,c_C=?,bio=?,fin=?,obs=? WHERE pro=?");
        $stmt->execute(array($nom_pro, $n_ovo, $nof, $ins, $pn2, $pn3, $inm, $atr, $ct, $ids, $d2, $d3, $d4, $d5, $d6, $d7, $c_T, $c_C, $bio, $fin, $obs, $pro));
    }

    $stmt2 = $db->prepare("UPDATE hc_reprod SET f_tra=?,h_tra=? WHERE id=?");
    $stmt2->execute(array($f_tra, $h_tra, $rep));

    ?>
    <script type="text/javascript">
        var x = "<?php echo $dni; ?>";
        window.parent.location.href = "n_repro.php?id=" + x;
    </script>
    <?php
}

function updateLegal($id, $a_dni, $a_mue, $a_nom, $a_med, $a_exa, $a_sta, $a_obs, $gin, $lab, $foto)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_legal (a_dni,a_mue,a_nom,a_med,a_exa,a_sta,a_obs,gin,lab) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($a_dni, $a_mue, $a_nom, $a_med, $a_exa, $a_sta, $a_obs, $gin, $lab));
        $id = $db->lastInsertId();
        if ($gin <> '') { // para q no inserte cuando es Andrologia
            $stmt = $db->prepare("UPDATE hc_gineco SET legal=? WHERE id=?");
            $stmt->execute(array($id, $gin));
        }

    } else {
        $stmt = $db->prepare("UPDATE hc_legal SET a_dni=?,a_mue=?,a_nom=?,a_med=?,a_exa=?,a_sta=?,a_obs=?,gin=?,lab=? WHERE id=?");
        $stmt->execute(array($a_dni, $a_mue, $a_nom, $a_med, $a_exa, $a_sta, $a_obs, $gin, $lab, $id));
    }
    if ($foto['name'] <> "") {
        if (is_uploaded_file($foto['tmp_name'])) {
            $ruta = 'legal/' . $id . '_' . $a_dni . '.pdf';
            move_uploaded_file($foto['tmp_name'], $ruta);
            $stmt = $db->prepare("UPDATE hc_legal SET fec_doc=CURDATE() WHERE id=?");
            $stmt->execute(array($id));
        }
    } ?>
    <script type="text/javascript">
        window.parent.location.href = "lista.php";
    </script>
    <?php
}

function updateAnalisis($id, $a_dni, $a_mue, $a_nom, $a_med, $a_exa, $a_sta, $a_obs, $cor, $lab, $foto)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO hc_analisis (a_dni,a_mue,a_nom,a_med,a_exa,a_sta,a_obs,cor,lab) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($a_dni, $a_mue, $a_nom, $a_med, $a_exa, $a_sta, $a_obs, $cor, $lab));
        $id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("UPDATE hc_analisis SET a_dni=?,a_mue=?,a_nom=?,a_med=?,a_exa=?,a_sta=?,a_obs=?,cor=?,lab=? WHERE id=?");
        $stmt->execute(array($a_dni, $a_mue, $a_nom, $a_med, $a_exa, $a_sta, $a_obs, $cor, $lab, $id));
    }
    if ($foto['name'] <> "") {
        if (is_uploaded_file($foto['tmp_name'])) {
            $ruta = 'analisis/' . $id . '_' . $a_dni . '.pdf';
            move_uploaded_file($foto['tmp_name'], $ruta);
        }
    } ?>
    <script type="text/javascript">
        window.parent.location.href = "lista.php";
    </script>
    <?php
}

function insertAnalisisTip($nom, $lab)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO hc_analisis_tip (nom,lab) VALUES (?,?)");
    $stmt->execute(array($nom, $lab));

    echo "<div id='alerta'> Examen Agregado! </div>";
}

function insertDisponi($med, $fec, $ini, $fin, $obs)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO hc_disponible (med, fec, ini, fin, obs) VALUES (?,?,?,?,?)");
    $stmt->execute(array($med, $fec, $ini, $fin, $obs));

    echo "<div id='alerta'>Evento Agendado! </div>";
}

// --------------------------------------- LABORATORIO -------------------------------------------------------------------------------------

function Descongela_Ovo_Emb($des_dia, $pro, $dni, $tip, $rep, $cont, $obs_med)
{
    global $db;

    if ($cont > 0 and isset($des_dia) and $des_dia >= 0) {
        $VeriPro = $db->prepare("SELECT pro FROM lab_aspira WHERE pro=?");
        $VeriPro->execute(array($pro));
        if ($VeriPro->rowCount() > 0) { ?>
            <script type="text/javascript">
                alert("Este protocolo YA EXISTE! Ingrese uno diferente");
                var x = "<?php echo $rep; ?>";
                window.parent.location.href = "le_aspi9.php?rep=" + x;
            </script>
        <?php } else {
            $c = 0;
            for ($p = 1; $p <= $cont; $p++) {
                if (isset($_POST['c' . $p])) {
                    $tan = explode("|", $_POST['c' . $p]);
                    $stmt2 = $db->prepare("UPDATE lab_aspira_dias SET des=? WHERE pro=? AND ovo=?");
                    $stmt2->execute(array(1, $tan[0], $tan[1])); // Descongela ovo/emb

                    $c++;

                    $rOvo = $db->prepare("SELECT * FROM lab_aspira_dias WHERE pro=? AND ovo=?");
                    $rOvo->execute(array($tan[0], $tan[1]));
                    $ovo = $rOvo->fetch(PDO::FETCH_ASSOC);

                    // todos los cogelados antiguos van como vacios , el d6f_cic no se inserta porque es el ultimo y debe ser vacio tb
                    if ($ovo['d0f_cic'] == 'C') $ovo['d0f_cic'] = '';
                    if ($ovo['d1f_cic'] == 'C') $ovo['d1f_cic'] = '';
                    if ($ovo['d2f_cic'] == 'C') $ovo['d2f_cic'] = '';
                    if ($ovo['d3f_cic'] == 'C') $ovo['d3f_cic'] = '';
                    if ($ovo['d4f_cic'] == 'C') $ovo['d4f_cic'] = '';
                    if ($ovo['d5f_cic'] == 'C') $ovo['d5f_cic'] = '';

                    $stmt = $db->prepare("INSERT INTO lab_aspira_dias (pro,ovo,anu,obs,pro_c,ovo_c,d0est,d0mor,d0z_pel,d0rot,d0inte,d1c_pol,d1pron,d1t_pro,d1d_nuc,d1hal,d0f_cic,d2cel,d2fra,d2sim,d1f_cic,d3cel,d3fra,d3sim,d3c_bio,d2f_cic,d4cel,d4fra,d4sim,d4mci,d4tro,d3f_cic,d5cel,d5mci,d5tro,d5fra,d5vac,d5col,d5d_bio,d4f_cic,d6cel,d6mci,d6tro,d6fra,d6vac,d6col,d6d_bio,d5f_cic,ngs1,ngs2,ngs3) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($pro, $c, $ovo['anu'], $ovo['obs'], $ovo['pro'], $ovo['ovo'], $ovo['d0est'], $ovo['d0mor'], $ovo['d0z_pel'], $ovo['d0rot'], $ovo['d0inte'], $ovo['d1c_pol'], $ovo['d1pron'], $ovo['d1t_pro'], $ovo['d1d_nuc'], $ovo['d1hal'], $ovo['d0f_cic'], $ovo['d2cel'], $ovo['d2fra'], $ovo['d2sim'], $ovo['d1f_cic'], $ovo['d3cel'], $ovo['d3fra'], $ovo['d3sim'], $ovo['d3c_bio'], $ovo['d2f_cic'], $ovo['d4cel'], $ovo['d4fra'], $ovo['d4sim'], $ovo['d4mci'], $ovo['d4tro'], $ovo['d3f_cic'], $ovo['d5cel'], $ovo['d5mci'], $ovo['d5tro'], $ovo['d5fra'], $ovo['d5vac'], $ovo['d5col'], $ovo['d5d_bio'], $ovo['d4f_cic'], $ovo['d6cel'], $ovo['d6mci'], $ovo['d6tro'], $ovo['d6fra'], $ovo['d6vac'], $ovo['d6col'], $ovo['d6d_bio'], $ovo['d5f_cic'], $ovo['ngs1'], $ovo['ngs2'], $ovo['ngs3']));

                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d0_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d0_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d0_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d1_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d1_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d1_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d2_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d2_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d2_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d3_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d3_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d3_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d4_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d4_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d4_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d5_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d5_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d5_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                    if (file_exists("emb_pic/p" . $ovo['pro'] . "d6_" . $ovo['ovo'] . ".jpg")) {
                        $img = "emb_pic/p" . $ovo['pro'] . "d6_" . $ovo['ovo'] . ".jpg";
                        $newimg = "emb_pic/p" . $pro . "d6_" . $c . ".jpg";
                        if (!copy($img, $newimg)) echo "fallo al copiar imagen";
                    }
                }
            }
            $sta = "Dia " . $des_dia;
            if ($des_dia == 0) {
                $fec0 = date("Y-m-d");
                $fec1 = endCycle($fec0, 1);
                $fec2 = endCycle($fec0, 2);
                $fec3 = endCycle($fec0, 3);
                $fec4 = endCycle($fec0, 4);
                $fec5 = endCycle($fec0, 5);
                $fec6 = endCycle($fec0, 6);
            }
            if ($des_dia == 1) {
                $fec0 = "";
                $fec1 = date("Y-m-d");
                $fec2 = endCycle($fec0, 1);
                $fec3 = endCycle($fec0, 2);
                $fec4 = endCycle($fec0, 3);
                $fec5 = endCycle($fec0, 4);
                $fec6 = endCycle($fec0, 5);
            }
            if ($des_dia == 2) {
                $fec0 = $fec1 = "";
                $fec2 = date("Y-m-d");
                $fec3 = endCycle($fec0, 1);
                $fec4 = endCycle($fec0, 2);
                $fec5 = endCycle($fec0, 3);
                $fec6 = endCycle($fec0, 4);
            }
            if ($des_dia == 3) {
                $fec0 = $fec1 = $fec2 = "";
                $fec3 = date("Y-m-d");
                $fec4 = endCycle($fec0, 1);
                $fec5 = endCycle($fec0, 2);
                $fec6 = endCycle($fec0, 3);
            }
            if ($des_dia == 4) {
                $fec0 = $fec1 = $fec2 = $fec3 = "";
                $fec4 = date("Y-m-d");
                $fec5 = endCycle($fec0, 1);
                $fec6 = endCycle($fec0, 2);
            }
            if ($des_dia == 5) {
                $fec0 = $fec1 = $fec2 = $fec3 = $fec4 = "";
                $fec5 = date("Y-m-d");
                $fec6 = endCycle($fec0, 1);
            }
            if ($des_dia == 6) {
                $fec0 = $fec1 = $fec2 = $fec3 = $fec4 = $fec5 = "";
                $fec6 = date("Y-m-d");
            }

            $stmt = $db->prepare("INSERT INTO lab_aspira (pro,rep,tip,dni,n_ovo,sta,dias,fec0,fec1,fec2,fec3,fec4,fec5,fec6,obs_med) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($pro, $rep, $tip, $dni, $c, $sta, $des_dia, $fec0, $fec1, $fec2, $fec3, $fec4, $fec5, $fec6, $obs_med));
            $rVeces = $db->prepare("SELECT pro FROM lab_aspira WHERE dni=?");
            $rVeces->execute(array($dni));

            $vec = $rVeces->rowCount();
            $stmt2 = $db->prepare("UPDATE lab_aspira SET vec=? WHERE pro=?");
            $stmt2->execute(array($vec, $pro));
            ?>
            <script type="text/javascript">
                window.parent.location.href = "lista_pro.php";
            </script>
        <?php }
    }
}

function lab_insertAspi($pro, $rep, $tip, $dni, $f_pun, $o_ovo, $pen, $end, $n_ovo, $obs, $obs_med, $s_pun, $s_cum, $sta, $dias, $n_ins, $hra, $emb, $hra_a, $emb_a, $f_fin, $p_cic, $p_fiv, $p_icsi, $p_cri, $pago_extras, $inc)
{
    global $db;
    try {
        $stmt = $db->prepare("INSERT INTO lab_aspira (pro,rep,tip,dni,f_pun,o_ovo,pen,end,n_ovo,obs,obs_med,s_pun,s_cum,sta,dias,n_ins,hra0,emb0,hra_a,emb_a,f_fin,inc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($pro, $rep, $tip, $dni, $f_pun, $o_ovo, $pen, $end, $n_ovo, $obs, $obs_med, $s_pun, $s_cum, $sta, $dias, $n_ins, $hra, $emb, $hra_a, $emb_a, $f_fin, $inc));

        $rVeces = $db->prepare("SELECT pro FROM lab_aspira WHERE dni=?");
        $rVeces->execute(array($dni));

        $vec = $rVeces->rowCount();
        $stmt2 = $db->prepare("UPDATE lab_aspira SET vec=? WHERE pro=?");
        $stmt2->execute(array($vec, $pro));

        $stmt3 = $db->prepare("UPDATE hc_reprod SET p_cic=?,p_fiv=?,p_icsi=?,p_cri=?,pago_extras=? WHERE id=?");
        $stmt3->execute(array($p_cic, $p_fiv, $p_icsi, $p_cri, $pago_extras, $rep)); ?>
        <script type="text/javascript">
            var x = "<?php echo $pro; ?>";
            window.parent.location.href = "le_aspi0.php?id=" + x;
        </script>
        <?php
    } catch (PDOException $e) {

        if ($e->getCode() == 23000) { ?>
            <script type="text/javascript"> alert("Este protocolo YA EXISTE! Ingrese uno diferente");
                window.parent.location.href = "lista_pro.php"; </script>  <?php } else {
            echo $e->getMessage();
        }
    }

}

function lab_inserAspiTraslado($id_tra, $dni, $ovos, $des_dia, $pro, $fec_tra, $med, $img)
{
    global $db;
    $rTras = $db->prepare("SELECT pro FROM lab_aspira WHERE pro=?");
    $rTras->execute(array($pro));

    if ($rTras->rowCount() == 0) {
        $sta = "Dia " . $des_dia;
        if ($des_dia == 0) {
            $fec0 = $fec_tra;
            $fec1 = endCycle($fec0, 1);
            $fec2 = endCycle($fec0, 2);
            $fec3 = endCycle($fec0, 3);
            $fec4 = endCycle($fec0, 4);
            $fec5 = endCycle($fec0, 5);
            $fec6 = endCycle($fec0, 6);
        }
        if ($des_dia == 1) {
            $fec0 = "";
            $fec1 = $fec_tra;
            $fec2 = endCycle($fec0, 1);
            $fec3 = endCycle($fec0, 2);
            $fec4 = endCycle($fec0, 3);
            $fec5 = endCycle($fec0, 4);
            $fec6 = endCycle($fec0, 5);
        }
        if ($des_dia == 2) {
            $fec0 = $fec1 = "";
            $fec2 = $fec_tra;
            $fec3 = endCycle($fec0, 1);
            $fec4 = endCycle($fec0, 2);
            $fec5 = endCycle($fec0, 3);
            $fec6 = endCycle($fec0, 4);
        }
        if ($des_dia == 3) {
            $fec0 = $fec1 = $fec2 = "";
            $fec3 = $fec_tra;
            $fec4 = endCycle($fec0, 1);
            $fec5 = endCycle($fec0, 2);
            $fec6 = endCycle($fec0, 3);
        }
        if ($des_dia == 4) {
            $fec0 = $fec1 = $fec2 = $fec3 = "";
            $fec4 = $fec_tra;
            $fec5 = endCycle($fec0, 1);
            $fec6 = endCycle($fec0, 2);
        }
        if ($des_dia == 5) {
            $fec0 = $fec1 = $fec2 = $fec3 = $fec4 = "";
            $fec5 = $fec_tra;
            $fec6 = endCycle($fec0, 1);
        }
        if ($des_dia == 6) {
            $fec0 = $fec1 = $fec2 = $fec3 = $fec4 = $fec5 = "";
            $fec6 = $fec_tra;
        }

        $stmt = $db->prepare("INSERT INTO hc_reprod (dni,fec,med,cancela) VALUES (?,?,?,?)");
        $stmt->execute(array($dni, $fec_tra, $med, 2)); // cancela = 2 significa q es una reproduccion traslado
        $rep = $db->lastInsertId();
        $stmt1 = $db->prepare("INSERT INTO lab_aspira (pro,rep,tip,dni,n_ovo,dias,sta,fec0,fec1,fec2,fec3,fec4,fec5,fec6) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt1->execute(array($pro, $rep, 'T', $dni, $ovos, $des_dia, $sta, $fec0, $fec1, $fec2, $fec3, $fec4, $fec5, $fec6));

        for ($i = 1; $i <= $ovos; $i++) {
            lab_insertAspi_ovos($pro, $i);
        }

        $stmt2 = $db->prepare("UPDATE hc_antece_trata SET tras=? WHERE id=?");
        $stmt2->execute(array(2, $id_tra));

        if ($img['name'] <> "") {
            if (is_uploaded_file($img['tmp_name'])) {
                $ruta = 'emb_pic/traslado_' . $pro . '.pdf';
                move_uploaded_file($img['tmp_name'], $ruta);
            }
        } ?>
        <script type="text/javascript">
            window.parent.location.href = "lista_pro_t.php";
        </script>
    <?php } else { ?>
        <script type="text/javascript"> alert("Este protocolo YA EXISTE! Ingrese uno diferente");
            window.parent.location.href = "lista_pro.php"; </script>
    <?php }

}

function lab_updateAspi($pro, $sta, $dias, $f_fin)
{

    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira SET sta=?,dias=?,f_fin=? WHERE pro=?");
    $stmt->execute(array($sta, $dias, $f_fin, $pro));

    echo "<div id='alerta'> Datos Guardados!</div>";

}

function lab_updateAspi_sta($pro, $sta, $dias, $hra, $emb, $hra_c, $emb_c)
{

    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira SET sta=?,dias=?,hra" . ($dias - 1) . "=?,emb" . ($dias - 1) . "=?,hra" . ($dias - 1) . "c=?,emb" . ($dias - 1) . "c=? WHERE pro=?");
    $stmt->execute(array($sta, $dias, $hra, $emb, $hra_c, $emb_c, $pro));

}

function lab_updateAspi_sta_T($id, $pro, $dia, $t_cat, $s_gui, $s_cat, $endo, $inte, $eco, $med, $emb, $obs)
{
    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO lab_aspira_T (pro,dia,t_cat,s_gui,s_cat,endo,inte,eco,med,emb,obs) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($pro, $dia, $t_cat, $s_gui, $s_cat, $endo, $inte, $eco, $med, $emb, $obs));
    } else {
        $stmt = $db->prepare("UPDATE lab_aspira_T SET t_cat=?,s_gui=?,s_cat=?,endo=?,inte=?,eco=?,med=?,emb=?,obs=? WHERE pro=?");
        $stmt->execute(array($t_cat, $s_gui, $s_cat, $endo, $inte, $eco, $med, $emb, $obs, $pro));
    }
}

function lab_updateAspi_fin($pro)
{

    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira SET f_fin=? WHERE pro=?");
    $stmt->execute(array(date("Y-m-d"), $pro));

}

function lab_updateAspi_fec_dia($pro, $fec0, $fec1, $fec2, $fec3, $fec4, $fec5, $fec6)
{

    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira SET fec0=?,fec1=?,fec2=?,fec3=?,fec4=?,fec5=?,fec6=? WHERE pro=?");
    $stmt->execute(array($fec0, $fec1, $fec2, $fec3, $fec4, $fec5, $fec6, $pro));

}

function lab_don_todo($id)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_reprod SET don_todo=? WHERE id=?");
    $stmt->execute(array(1, $id)); ?>
    <script type="text/javascript">
        window.parent.location.href = "lista_pro.php";
    </script><?php
}

function lab_updateRepro($id, $p_cic, $p_fiv, $p_icsi, $p_cri, $pago_extras, $dia, $o_ovo, $pen, $end, $s_pun, $s_cum, $n_ins, $hra, $emb, $hra_c, $emb_c, $hra_a, $emb_a, $obs, $obs_med, $book, $hoja, $inc)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_reprod SET p_cic=?,p_fiv=?,p_icsi=?,p_cri=?,pago_extras=? WHERE id=?");
    $stmt->execute(array($p_cic, $p_fiv, $p_icsi, $p_cri, $pago_extras, $id));

    $stmt2 = $db->prepare("UPDATE lab_aspira SET o_ovo=?,pen=?,end=?,s_pun=?,s_cum=?,n_ins=?,hra0=?,emb0=?,hra0c=?,emb0c=?,hra_a=?,emb_a=?,obs=?,obs_med=?,book=?,hoja=?,inc=? WHERE rep=?");
    $stmt2->execute(array($o_ovo, $pen, $end, $s_pun, $s_cum, $n_ins, $hra, $emb, $hra_c, $emb_c, $hra_a, $emb_a, $obs, $obs_med, $book, $hoja, $inc, $id));

    if ($dia == 1) { ?>
        <script type="text/javascript">
            window.parent.location.href = "lista_pro.php";
        </script><?php }
}

function lab_updateRepro2($id, $pago_extras, $obs, $obs_med, $book, $hoja)
{

    global $db;
    $stmt = $db->prepare("UPDATE hc_reprod SET pago_extras=? WHERE id=?");
    $stmt->execute(array($pago_extras, $id));

    $stmt2 = $db->prepare("UPDATE lab_aspira SET obs=?,obs_med=?,book=?,hoja=? WHERE rep=?");
    $stmt2->execute(array($obs, $obs_med, $book, $hoja, $id));
    ?>
    <script type="text/javascript">
        window.parent.location.href = "lista_pro.php";
    </script>
    <?php
}

function lab_insertAspi_ovos($pro, $ovo)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO lab_aspira_dias (pro,ovo) VALUES (?,?)");
    $stmt->execute(array($pro, $ovo));
}

function lab_updateAspi_d0($pro, $ovo, $anu, $est, $mor, $z_pel, $rot, $inte, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $img)
{
    ////if ($T=='') $T = null; if ($C=='') $C = null; if ($G=='') $G = null; if ($P=='') $P = null;
    if ($f_cic <> 'O') $otros_f_cic = ",d1f_cic='',d2f_cic='',d3f_cic='',d4f_cic='',d5f_cic='',d6f_cic=''"; else $otros_f_cic = "";
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d0est=?,d0mor=?,d0z_pel=?,d0rot=?,d0inte=?,d0f_cic=?,obs=?,T=?,C=?,G=?,P=?,col=?,don=?" . $otros_f_cic . " WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $est, $mor, $z_pel, $rot, $inte, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd0_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function lab_updateAspi_d1($pro, $ovo, $anu, $est1, $c_pol, $pron, $t_pro, $d_nuc, $hal, $f_cic, $obs, $don, $img)
{
    if ($f_cic <> 'O') $otros_f_cic = ",d2f_cic='',d3f_cic='',d4f_cic='',d5f_cic='',d6f_cic=''"; else $otros_f_cic = "";
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d1est=?,d1c_pol=?,d1pron=?,d1t_pro=?,d1d_nuc=?,d1hal=?,d1f_cic=?,obs=?,don=?" . $otros_f_cic . " WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $est1, $c_pol, $pron, $t_pro, $d_nuc, $hal, $f_cic, $obs, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd1_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function lab_updateAspi_d2($pro, $ovo, $anu, $cel, $fra, $sim, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $img)
{
    //if ($T=='') $T = null; if ($C=='') $C = null; if ($G=='') $G = null; if ($P=='') $P = null;
    if ($f_cic <> 'O') $otros_f_cic = ",d3f_cic='',d4f_cic='',d5f_cic='',d6f_cic=''"; else $otros_f_cic = "";
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d2cel=?,d2fra=?,d2sim=?,d2f_cic=?,obs=?,T=?,C=?,G=?,P=?,col=?,don=?" . $otros_f_cic . " WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $cel, $fra, $sim, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd2_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function lab_updateAspi_d3($pro, $ovo, $anu, $cel, $fra, $sim, $c_bio, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $img)
{
    //if ($T=='') $T = null; if ($C=='') $C = null; if ($G=='') $G = null; if ($P=='') $P = null;
    if ($f_cic <> 'O') $otros_f_cic = ",d4f_cic='',d5f_cic='',d6f_cic=''"; else $otros_f_cic = "";
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d3cel=?,d3fra=?,d3sim=?,d3c_bio=?,d3f_cic=?,obs=?,T=?,C=?,G=?,P=?,col=?,don=?" . $otros_f_cic . " WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $cel, $fra, $sim, $c_bio, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd3_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function lab_updateAspi_d4($pro, $ovo, $anu, $cel, $fra, $sim, $mci, $tro, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $img)
{
    //if ($T=='') $T = null; if ($C=='') $C = null; if ($G=='') $G = null; if ($P=='') $P = null;
    if ($f_cic <> 'O') $otros_f_cic = ",d5f_cic='',d6f_cic=''"; else $otros_f_cic = "";
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d4cel=?,d4fra=?,d4sim=?,d4mci=?,d4tro=?,d4f_cic=?,obs=?,T=?,C=?,G=?,P=?,col=?,don=?" . $otros_f_cic . " WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $cel, $fra, $sim, $mci, $tro, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd4_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function lab_updateAspi_d5($pro, $ovo, $anu, $cel, $mci, $tro, $fra, $vac, $colap, $d_bio, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $img)
{
    //if ($T=='') $T = null; if ($C=='') $C = null; if ($G=='') $G = null; if ($P=='') $P = null;
    if ($f_cic <> 'O') $otros_f_cic = ",d6f_cic=''"; else $otros_f_cic = "";
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d5cel=?,d5mci=?,d5tro=?,d5fra=?,d5vac=?,d5col=?,d5d_bio=?,d5f_cic=?,obs=?,T=?,C=?,G=?,P=?,col=?,don=?" . $otros_f_cic . " WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $cel, $mci, $tro, $fra, $vac, $colap, $d_bio, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd5_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function lab_updateAspi_d6($pro, $ovo, $anu, $cel, $mci, $tro, $fra, $vac, $colap, $d_bio, $kid, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $img)
{
    //if ($T=='') $T = null; if ($C=='') $C = null; if ($G=='') $G = null; if ($P=='') $P = null;
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET anu=?,d6cel=?,d6mci=?,d6tro=?,d6fra=?,d6vac=?,d6col=?,d6d_bio=?,d6kid=?,d6f_cic=?,obs=?,T=?,C=?,G=?,P=?,col=?,don=? WHERE pro=? AND ovo=?");
    $stmt->execute(array($anu, $cel, $mci, $tro, $fra, $vac, $colap, $d_bio, $kid, $f_cic, $obs, $T, $C, $G, $P, $col, $don, $pro, $ovo));
    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/p' . $pro . 'd6_' . $ovo . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
}

function updateNGS($pro, $ovo, $ngs1, $ngs2, $ngs3)
{
    global $db;
    $stmt = $db->prepare("UPDATE lab_aspira_dias SET ngs1=?,ngs2=?,ngs3=? WHERE pro=? AND ovo=?");
    $stmt->execute(array($ngs1, $ngs2, $ngs3, $pro, $ovo));
}

function lab_insertTanque($n_c, $n_v, $n_p, $tip, $sta)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO lab_tanque (n_c,n_v,n_p,tip,sta) VALUES (?,?,?,?,?)");
    $stmt->execute(array($n_c, $n_v, $n_p, $tip, $sta));
    $t = $db->lastInsertId();

    for ($c = 1; $c <= $n_c; $c++) {
        for ($v = 1; $v <= $n_v; $v++) {
            for ($p = 1; $p <= $n_p; $p++) {
                $stmt2 = $db->prepare("INSERT INTO lab_tanque_res (T,C,V,P) VALUES (?,?,?,?)");
                $stmt2->execute(array($t, $c, $v, $p));
            }
        }
    }
}

function updateEmbrio($id, $nom, $mai, $cbp, $cel, $img)
{

    global $db;
    if ($id == "") {
        $stmt = $db->prepare("INSERT INTO lab_user (nom,mai,cbp,cel) VALUES (?,?,?,?)");
        $stmt->execute(array($nom, $mai, $cbp, $cel));
        $id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("UPDATE lab_user SET nom=?,mai=?,cbp=?,cel=? WHERE id=?");
        $stmt->execute(array($nom, $mai, $cbp, $cel, $id));
    }

    if ($img['name'] <> "") {
        if (is_uploaded_file($img['tmp_name'])) {
            $ruta = 'emb_pic/emb_' . $id . '.jpg';
            move_uploaded_file($img['tmp_name'], $ruta);
        }
    }
    ?>
    <script type="text/javascript">
        window.parent.location.href = "lista_emb.php";
    </script>
    <?php

}

function lab_insertEmbry($pro,$vid,$pdf)
{
    if ($vid['name'] <> "") {
        if (is_uploaded_file($vid['tmp_name'])) {
            $ruta = 'emb_pic/embryoscope_' . $pro . '.mp4';
            move_uploaded_file($vid['tmp_name'], $ruta);
        }
    }
    if ($pdf['name'] <> "") {
        if (is_uploaded_file($pdf['tmp_name'])) {
            $ruta = 'emb_pic/embryoscope_' . $pro . '.pdf';
            move_uploaded_file($pdf['tmp_name'], $ruta);
        }
    }
}

// -------------------------------------- PAGOS ------------------------------------------------------------------------------
function Recibo($id, $fec, $dni, $nom, $med, $sede, $tip, $ruc, $raz, $t_ser, $pak, $ser, $mon, $tot, $t1, $m1, $p1, $t2, $m2, $p2, $t3, $m3, $p3, $man_ini, $man_fin, $cadena)
{
    global $db;
    $anglo = '';

    if ($id == "") {
        $Rpop = $db->prepare("SELECT id FROM recibos WHERE tip=? ORDER BY id DESC LIMIT 1");
        $Rpop->execute(array($tip));
        if ($Rpop->rowCount() == 1) {
            $pop = $Rpop->fetch(PDO::FETCH_ASSOC);
            $id = $pop['id'] + 1;
        } else $id = 1;

        if ($cadena<>'' and ($t_ser == 4 or $t_ser == 5)) {
            $client = new nusoap_client('http://www.anglolab.com:287/Service.svc?wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';
            $err = $client->getError();
            if ($err) {
                //echo '<h2>Constructor error:</h2><pre>' . $err . '</pre>';
                $anglo = 4;
            }
            $Rpaci = $db->prepare("SELECT tip,nom,ape,fnac FROM hc_paciente WHERE dni=?");
            $Rpaci->execute(array($dni));

            if ($Rpaci->rowCount() == 1) {
                $sex = 'F';
            } else {
                $sex = 'M';
                $Rpaci = $db->prepare("SELECT p_tip AS tip,p_nom AS nom,p_ape AS ape,p_fnac AS fnac FROM hc_pareja WHERE p_dni=?");
                $Rpaci->execute(array($dni));
            }

            $paci = $Rpaci->fetch(PDO::FETCH_ASSOC);
            $ape = explode(' ', $paci['ape'], 2);

            $medico = explode(' ', $med, 2);

            $param = array(
                'Dato' => "|" . $id . "-" . $tip . "|" . $id . "-" . $tip . "|" . date("d/m/Y", strtotime($fec)) . "|S00036|CC0151|PT2290||||AMBULATORIO|NORMAL||R|" . $dni . "|".$paci['tip']."|" . $dni . "|" . $paci['nom'] . "|" . $ape[0] . "|" . $ape[1] . "|" . $sex . "|" . date("d/m/Y", strtotime($paci['fnac'])) . "|20544478096|INMATER||" . $medico[0] . "|" . $medico[1] . "||" . $cadena . "|");

            $result = $client->call('Registrar_Orden_HIS_Inmater', $param);
// Check for a fault
            if ($client->fault) {
                //echo '<h2>FALLO:</h2><pre>';
                $anglo = 3;
                //print_r($result);
                $err = $result['Registrar_Orden_HIS_Inmater'];
                //echo '</pre>';
            } else {
                // Check for errors
                $err = $client->getError();
                if ($err) {
                    // Display the error
                    //echo '<h2>ERROR:</h2><pre>' . $err . '</pre>';
                    $anglo = 2;
                } else {
                    // Display the result
                    //echo '<h2>RESULTADO:</h2><pre>' . $result['Registrar_Orden_HIS_ProvidenciaResult'] . '</pre>';
                    $anglo = $result['Registrar_Orden_HIS_InmaterResult'];
                    //echo "|".$id."-".$tip."|".$id."-".$tip."|".date("d/m/Y", strtotime($fec))."|S00036|CC0151|PT2290||||AMBULATORIO|NORMAL||R|".$dni."|PAS|".$dni."|".$paci['nom']."|".$ape[0]."|".$ape[1]."|".$sex."|".date("d/m/Y", strtotime($paci['fnac']))."|20544478096|INMATER|||||".$cadena."|";
                }
            }


            echo '<h2>'.$param['Dato'].'</h2>';
            print_r($result);
            if (strpos($anglo, "Correcto") === false) {
                $anglo = $anglo . '=' . $err; ?>
                <script type="text/javascript">
                    alert("ERROR al enviar solicitud a Anglolab!");
                </script>
            <?php }
        }

        $stmt = $db->prepare("INSERT INTO recibos (id,tip,fec,dni,nom,med,sede,ruc,raz,t_ser,pak,ser,mon,tot,t1,m1,p1,t2,m2,p2,t3,m3,p3,man_ini,man_fin,anglo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($id, $tip, $fec, $dni, $nom, $med, $sede, $ruc, $raz, $t_ser, $pak, $ser, $mon, $tot, $t1, $m1, $p1, $t2, $m2, $p2, $t3, $m3, $p3, $man_ini, $man_fin, $anglo));
    } else {
        $stmt = $db->prepare("UPDATE recibos SET fec=?,med=?,sede=?,ruc=?,raz=?,t1=?,m1=?,p1=?,t2=?,m2=?,p2=?,t3=?,m3=?,p3=?,man_ini=?,man_fin=? WHERE id=? AND tip=?");
        $stmt->execute(array($fec, $med, $sede, $ruc, $raz, $t1, $m1, $p1, $t2, $m2, $p2, $t3, $m3, $p3, $man_ini, $man_fin, $id, $tip));
    }

    ?>
    <script type="text/javascript">
        var x = "<?php echo $id; ?>";
        var y = "<?php echo $tip; ?>";
        window.parent.location.href = "pago_imp.php?id=" + x + "&t=" + y;
    </script>
    <?php
}

function Recibo_serv($nom, $pak, $costo, $cc, $tip, $cod)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO recibo_serv (nom,pak,costo,cc,tip,cod) VALUES (?,?,?,?,?,?)");
    $stmt->execute(array($nom, $pak, $costo, $cc, $tip, $cod));
    echo "<div id='alerta'> Servicio guardado! </div>";
}

function Control($nom, $cat, $pres, $lote, $f_ven, $f_ing, $f_uso, $sob1, $sob2, $sob3, $color)
{
    global $db;
    $stmt = $db->prepare("INSERT INTO lab_control (nom,cat,pres,lote,f_ven,f_ing,f_uso,sob1,sob2,sob3,color) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($nom, $cat, $pres, $lote, $f_ven, $f_ing, $f_uso, $sob1, $sob2, $sob3, $color));
    echo "<div id='alerta'> Insumo Guardado! </div>";
}

//--------------------------------------- EXTRAS ------------------------------------------------------------------------------
function google_cal($title, $desc, $ev_date, $cal_id)
{

    session_start();

    /************************************************
     * Make an API request authenticated with a service
     * account.
     ************************************************/
    require_once "google-api-php-client/src/Google/autoload.php";
    require_once "google-api-php-client/src/Google/Client.php";
    require_once "google-api-php-client/src/Google/Service/Calendar.php";

    //obviously, insert your own credentials from the service account in the Google Developer's console
    $client_id = '715845141171-r90vcpf5k0mknt6qh0o5pcpa0ja5dsbg.apps.googleusercontent.com"';
    $service_account_name = 'inmater@api-project-715845141171.iam.gserviceaccount.com';
    $key_file_location = 'API Project-3c4c0633fed4.p12';

    if (!strlen($service_account_name) || !strlen($key_file_location))
        echo missingServiceAccountDetailsWarning();

    $client = new Google_Client();
    //$client->setCache(new Google_Cache_File('google_cache'));
    $client->setApplicationName("inmater");

    if (isset($_SESSION['service_token'])) {
        $client->setAccessToken($_SESSION['service_token']);
    }

    $key = file_get_contents($key_file_location);
    $cred = new Google_Auth_AssertionCredentials(
        $service_account_name,
        array('https://www.googleapis.com/auth/calendar'),
        $key
    );

    /*   $cred = new Google_Auth_AssertionCredentials(
        $service_account_name,
        array('https://www.googleapis.com/auth/calendar'),
        $key,
		  'notasecret',
		  'http://oauth.net/grant_type/jwt/1.0/bearer',
		  'betollaque@gmail.com'
    ); */
    $client->setAssertionCredentials($cred);
    if ($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
    }
    $_SESSION['service_token'] = $client->getAccessToken();

    $calendarService = new Google_Service_Calendar($client);
    $calendarList = $calendarService->calendarList;

    //Set the Event data
    $event = new Google_Service_Calendar_Event();
    $event->setSummary($title);
    $event->setDescription($desc);

    $start = new Google_Service_Calendar_EventDateTime();
    $start->setDateTime($ev_date);
    $event->setStart($start);

    $end = new Google_Service_Calendar_EventDateTime();
    $end->setDateTime($ev_date);
    $event->setEnd($end);

    $createdEvent = $calendarService->events->insert($cal_id, $event);

    //echo $createdEvent->getId();
}

function endCycle($d1, $days)
{

    return date('Y-m-d', strtotime($d1 . ' + ' . $days . ' days'));

}

function rm_folder_recursively($dir)
{
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rm_folder_recursively("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
    return true;
}

function delete_hc_paciente($tel, $confe)
{
    if ($confe <> "") {
        $dir = $tel . '/' . $confe;
        rm_folder_recursively($dir);

        mysql_query("DELETE FROM hc_paciente WHERE user='$tel' and Confer= '$confe'");

    }
}

function getExtension($chaine)
{
    $taille = strlen($chaine) - 1;
    for ($i = $taille; $i >= 0; $i--)
        if ($chaine['$i'] == '.') break;

    return substr($chaine, $i + 1, strlen($chaine) - ($i + 1));
}

function redimensionar_jpeg($nom_fichier, $destino_temporal, $destino_temporal_anchura, $destino_temporal_altura, $destino_temporal_calidad)
{
#
// crear una imagen desde el original
#
    $img = imagecreatefromjpeg($nom_fichier);

    if (imagesx($img) > 100 or imagesy($img) > 100) {

#
// crear una imagen nueva
#
        $thumb = imagecreatetruecolor($destino_temporal_anchura, $destino_temporal_altura);
#
// redimensiona la imagen original copiandola en la imagen
#
        imagecopyresized($thumb, $img, 0, 0, 0, 0, $destino_temporal_anchura, $destino_temporal_altura, imagesx($img), imagesy($img));
#
// guardar la nueva imagen redimensionada donde indicia $destino_temporal
#
        imagejpeg($thumb, $destino_temporal, $destino_temporal_calidad);
    } else {
        imagejpeg($img, $destino_temporal, $destino_temporal_calidad);
    }
    imagedestroy($img);

}

?>
