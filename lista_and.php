<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php $login = $_SESSION['login'];
$dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
if (!$login) { 
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://".$dir."'>";
}
require("_database/db_tools.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="_themes/tema_inmater.min.css" />
<link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script>
$(document).ready(function () {
$(".lista_orden tr").sort(sort_li).appendTo('.lista_orden');
function sort_li(a, b){
    return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;    
}	
});	
</script>
<style>
.color { color:#F4062B !important; }
</style>
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="lista">
<?php $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($user['role']==2) {

$rPaci = $db->prepare("SELECT hc_pare_paci.p_dni,hc_pare_paci.dni,p_nom,p_ape,p_san,p_m_ets,p_m_ale,hc_pare_paci.p_het FROM hc_pareja,hc_pare_paci WHERE hc_pareja.p_dni=hc_pare_paci.p_dni ORDER by p_ape,p_nom ASC");

$rPaci->execute();

$Cap = $db->prepare("SELECT id FROM lab_andro_cap WHERE emb=0"); 
$Cap->execute();
if ($Cap->rowCount()>0) $new_cap="<i class='color'>(".$Cap->rowCount()." Pendientes)</i>"; else $new_cap="";
} ?> 
<div data-role="header" data-position="fixed">

<h1>Andrología</h1>

<?php if ($user['role']==2) { ?>
<div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
<a href='lista.php' class="ui-btn ui-btn-c ui-icon-home ui-btn-icon-left" rel="external">Inicio</a>
<a href='n_pare_and.php' class="ui-btn ui-mini ui-btn-inline" rel="external">AGREGAR NUEVO PACIENTE</a>
<a href='lista_cap.php' class="ui-btn ui-mini ui-btn-inline" rel="external">CAPACITACIONES <?php echo $new_cap; ?></a>
</div>
<?php } ?>

<a href="index.php" class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power" rel="external">Salir</a>
</div><!-- /header -->

<div class="ui-content" role="main">

<FORM ACTION="lista_and.php" method="post" name="form1">

<?php if ($rPaci->rowCount()>0) { ?>
<input id="filtro" data-type="search" placeholder="Filtro..">
<table data-role="table" data-filter="true" data-input="#filtro" class="table-stripe ui-responsive lista_orden"><br>
<thead>
<tr>
<th>APELLIDOS Y NOMBRES</th>
<th>DNI/PASAPORTE</th>
<th>MEDICO</th>
<th>EXAMENES PENDIENTE</th>
</tr>
</thead>
<tbody>
<?php $c=0; while($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { $c++;
	
$Esp = $db->prepare("SELECT fec FROM lab_andro_esp WHERE p_dni=? and emb=0 ORDER by fec DESC"); $Esp->execute(array($paci['p_dni']));
//$Cap = $db->prepare("SELECT fec FROM lab_andro_cap WHERE p_dni=? and emb=0 ORDER by fec DESC"); $Cap->execute(array($paci['p_dni']));
$Tes_cap = $db->prepare("SELECT fec FROM lab_andro_tes_cap WHERE p_dni=? and emb=0 ORDER by fec DESC"); $Tes_cap->execute(array($paci['p_dni']));
$Tes_sob = $db->prepare("SELECT fec FROM lab_andro_tes_sob WHERE p_dni=? and emb=0 ORDER by fec DESC"); $Tes_sob->execute(array($paci['p_dni']));
$Bio_tes = $db->prepare("SELECT fec FROM lab_andro_bio_tes WHERE p_dni=? and emb=0 ORDER by fec DESC"); $Bio_tes->execute(array($paci['p_dni']));
$Cri_sem = $db->prepare("SELECT fec FROM lab_andro_crio_sem WHERE p_dni=? and emb=0 ORDER by fec DESC"); $Cri_sem->execute(array($paci['p_dni']));

		if ($paci['dni']<>"") {
				$rPare = $db->prepare("SELECT nom,ape,med FROM hc_paciente WHERE dni=?");
				$rPare->execute(array($paci['dni']));
				$pare = $rPare->fetch(PDO::FETCH_ASSOC);
		} ?>
<tr <?php if ($Esp->rowCount()>0 or $Tes_cap->rowCount()>0 or $Tes_sob->rowCount()>0 or $Bio_tes->rowCount()>0 or $Cri_sem->rowCount()>0) echo "data-position=0"; else echo "data-position=".$c; ?>>

<th> <a href='<?php echo "e_pare.php?id=".$paci['dni']."&ip=".$paci['p_dni'];?>' rel="external"><?php echo $paci['p_ape'].' <small>'.$paci['p_nom'].'</small>';?></a><br><small style="opacity:.5;"><?php if ($paci['p_m_ale']=="Medicamentada") echo  " (ALERGIA MEDICAMENTADA)"; 
if (strpos($paci['p_san'],"-") !== false) echo  " (SANGRE NEGATIVA)";
if (strpos($paci['p_m_ets'],"VIH") !== false) echo  " (VIH)"; 
if (strpos($paci['p_m_ets'],"Hepatitis C") !== false) echo  " (Hepatitis C)";
if ($paci['dni']=="" and $paci['p_het']==1) echo  " (Donante APTO)";
if ($paci['dni']=="" and $paci['p_het']==2) echo  " (Donante)"; ?></small></th>
<td><?php echo $paci['p_dni']; ?></td>
<td><?php if ($paci['dni']<>"") echo $pare['med'].'<br><small style="opacity:.5;">'.$pare['ape'].' '.$pare['nom'].'</small>'; else echo 'Particular'; ?></td>
<td><?php if ($Esp->rowCount()>0) echo "<i class='color'> -ESPERMATOGRAMA</i>";
		//if ($Cap->rowCount()>0) echo "<i class='color'> -CAPACITACIÓN</i>";
		if ($Tes_cap->rowCount()>0) echo "<i class='color'> -TEST CAPACITACIÓN</i>";
		if ($Tes_sob->rowCount()>0) echo "<i class='color'> -TEST SOBREVIVENCIA</i>";
		if ($Bio_tes->rowCount()>0) echo "<i class='color'> -BIOPSIA TESTICULAR</i>";
		if ($Cri_sem->rowCount()>0) echo "<i class='color'> -CRIOPRESERVACIÓN SEMEN</i>"; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else { echo '<p><h3>¡ No hay Pacientes !</h3></p>'; } ?>
</FORM>
</div><!-- /content -->
<div data-role="footer" data-position="fixed" id="footer"> 
<p><small> <?php echo $rPaci->rowCount();?> Pacientes</small></p>
 </div><!-- /footer -->

</div><!-- /page -->

</body>

</html>