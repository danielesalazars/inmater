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
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="lista_cap" data-dialog="true">
<?php $Rcap = $db->prepare("SELECT * FROM lab_andro_cap ORDER by fec DESC"); 
$Rcap->execute(); ?>

<style>

.ui-dialog-contain {
  	max-width: 1500px;
	margin: 1% auto 1%;
	padding: 0;
	position: relative;
	top: -35px;
}
.color { color:#F4062B !important; }
.mayuscula {
    text-transform: uppercase;
}
</style>

<div data-role="header" data-position="fixed">
<a href="lista_and.php" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
<h2>LISTA DE CAPACITACIONES</h2>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="lista_cap.php" method="post" data-ajax="false">

<?php if ($Rcap->rowCount()>0) { ?>
<input id="filtro" data-type="search" placeholder="Filtro..">
<table data-role="table" data-filter="true" data-input="#filtro" class="table-stripe ui-responsive lista_orden" style="font-size: small;">
<thead>
<tr>
<th>APELLIDOS Y NOMBRES</th>
<th>PAREJA</th>
<th>MEDICO</th>
<th>FECHA</th>
<th>SOLTERA</th>
<th>ESTADO</th>
</tr>
</thead>
<tbody>
<?php $c=0; while($cap = $Rcap->fetch(PDO::FETCH_ASSOC)) { $c++;
	$het = '';
	if ($cap['p_dni']=="") { 
		if ($cap['iiu']>0) { // mujer soltera de iiu
		  $rIIU = $db->prepare("SELECT dni,p_dni_het FROM hc_reprod WHERE id=?");
	 	  $rIIU->execute(array($cap['iiu']));
	 	  $iiu = $rIIU->fetch(PDO::FETCH_ASSOC);
		  $dni = $iiu['dni'];
		  $het = $iiu['p_dni_het'];
		}
		if ($cap['pro']<>"") { // mujer soltera de pro
		  $rPRO = $db->prepare("SELECT dni FROM lab_aspira WHERE pro=?");
	 	  $rPRO->execute(array($cap['pro']));
	 	  $pro = $rPRO->fetch(PDO::FETCH_ASSOC);
		  $dni = $pro['dni'];
		}
	  $rPare = $db->prepare("SELECT nom AS p_nom,ape AS p_ape,med AS p_med FROM hc_paciente WHERE dni=?");
	  $rPare->execute(array($dni));
	  $pare = $rPare->fetch(PDO::FETCH_ASSOC);
	} else {
		if ($cap['iiu']>0) { // mujer soltera de iiu
		  $rIIU = $db->prepare("SELECT p_dni_het FROM hc_reprod WHERE id=?");
	 	  $rIIU->execute(array($cap['iiu']));
	 	  $iiu = $rIIU->fetch(PDO::FETCH_ASSOC);
		  $het = $iiu['p_dni_het'];
		}
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
<tr <?php if ($cap['emb']==0) echo "class='color' data-position=0"; else echo 'data-position='.$c; ?>>

<td class="mayuscula"><?php echo $pare['p_ape'].' <small>'.$pare['p_nom'].'</small>';?></td>
<td class="mayuscula"><?php if ($cap['p_dni']=="") echo '-'; else { if ($dni=="") echo '-'; else echo $mujer['ape'].' <small>'.$mujer['nom'].'</small>';} ?></td>
<td><?php if ($pare['p_med']<>"") echo $pare['p_med']; else echo 'Particular'; ?></td>
<td><?php echo date("d-m-Y", strtotime($cap['fec'])); ?></td>
<td><?php if ($cap['p_dni']=="") echo "Si"; ?></td>
<td>
<a href="le_andro_cap.php?dni=<?php echo "&ip=".$cap['p_dni']."&het=".$het."&id=".$cap['id']; ?>" rel="external" ><?php if ($cap['emb']==0) echo 'Nuevo'; else echo 'Editar'; ?></a>
<?php if ($cap['emb']>0) { ?>
/<a href="info.php?T=cap&a=<?php echo $cap['p_dni']."&b=".$cap['id']."&c=".$dni; ?>" target="new">Informe</a>/<a href="info_s.php?T=cap&a=<?php echo $cap['p_dni']."&b=".$cap['id']."&c=".$dni; ?>" target="new">Sobre</a><?php } ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else { echo '<p><h3>¡ No hay Pacientes !</h3></p>'; } ?>
</form>
</div><!-- /content -->
</div><!-- /page -->
</body>
</html>