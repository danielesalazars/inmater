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
<style>
.ui-dialog-contain {
  	width: 100%;
  	max-width: 800px;
	margin: 2% auto 15px;
	padding: 0;
	position: relative;
	top: -15px;
	
}
#alerta { background-color:#FF9;margin: 0 auto; text-align:center; padding:4px;}
</style>
<script language="JavaScript" type="text/javascript">

function anular(x) {
	document.form2.borrar.value=x;
	document.form2.nom.value=""; //para que no inserte registros
	document.form2.submit();
}
</script>
</head>

<body>
<div data-role="page" class="ui-responsive-panel" id="e_analisis_tip" data-dialog="true">

<div data-role="header" data-position="fixed">
<a href="lista.php" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
<h1>Tipos de <?php if ($login=='eco') echo 'Ecografía'; else if ($login=='legal') echo 'Documentos'; else echo 'Exámenes'; ?></h1>
</div><!-- /header -->
<div class="ui-content" role="main">
<?php if ($_POST['borrar']<>"") {
	$stmt = $db->prepare("DELETE FROM hc_analisis_tip WHERE id=?");
	$stmt->execute(array($_POST['borrar']));
	}
	
if ($_POST['nom']<>"")
	insertAnalisisTip($_POST['nom'],$login);

$rMed = $db->prepare("SELECT * FROM hc_analisis_tip WHERE lab=? ORDER by nom ASC");
$rMed->execute(array($login)); ?>

	<form action="e_analisis_tipo.php" method="post" name="form2">
    <input type="hidden" name="borrar">
    <div class="ui-bar ui-bar-a">
	<table style="margin: 0 auto;" width="100%">
		<tr>
		  <td width="16%">Nombre de <?php if ($login=='eco') echo 'Ecografía'; else if ($login=='legal') echo 'Documento'; else echo 'Exámen'; ?></td>
		  <td width="71%"><input name="nom" type="text" id="nom" data-mini="true" required/></td>
		  <td width="13%"><input name="guardar" type="Submit" id="guardar" value="AGREGAR"  data-icon="check" data-iconpos="left" data-inline="true" data-mini="true"/></td>
		  </tr>
		
	</table>
    </div>

<ul data-role="listview" data-inset="true" data-mini="true" >

<?php  while ($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
	<li style="margin: 0 auto;width:90%;">
    <h5><?php echo $med['nom'];?></h5>
    <span class="ui-li-count"><a href='javascript:anular(<?php echo $med['id'];?>);' data-theme="a">[Eliminar]</a></span>
    </li>

<?php } 

if ($rMed->rowCount()<1) 

echo '<p><h3 class="text_buscar">¡ No hay registros !</h3></p>';

?>
</ul> 
</form>

</div><!-- /content -->
<script>
$(function(){
	$('#alerta').delay(3000).fadeOut('slow');

});//]]> 
</script>
</div><!-- /page -->

</body>
</html>