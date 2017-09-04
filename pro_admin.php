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
function borra(pro) {
    document.form2.accion.value=1;
	document.form2.pro.value=pro;
	if (confirm("Presione ACEPTAR para eliminar el protocolo "+ pro +" \n los cambios seran IRREVERSIBLES por Ud.")) 
	document.form2.submit();
}
function nombra(pro) {
    document.form2.accion.value=2;
	document.form2.pro.value=pro;
	document.form2.submit();
}
</script>
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="pro_admin" data-dialog="true">
<?php $rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($user['role']==2) {
$pro=$_POST['pro'];
$new_pro=trim(preg_replace('/\s+/',' ', $_POST['nom'.$pro]));
if ($_POST['accion']==1 and $pro<>"") {
	$stmt = $db->prepare("DELETE FROM lab_aspira WHERE pro=?");
	$stmt->execute(array($pro));
	
	$stmt = $db->prepare("DELETE FROM lab_aspira_T WHERE pro=?");
	$stmt->execute(array($pro));
	$stmt = $db->prepare("DELETE FROM lab_andro_cap WHERE pro=?");
	$stmt->execute(array($pro));
	
	$rPro = $db->prepare("SELECT pro_c,ovo_c FROM lab_aspira_dias WHERE pro=?");
	$rPro->execute(array($pro));
	if($rPro->rowCount()>0) { while($pro_c = $rPro->fetch(PDO::FETCH_ASSOC)) { 
		$stmt = $db->prepare("UPDATE lab_aspira_dias SET des=0 where pro=? and ovo=?"); // vuelve a congelar los ovo/emb q fueron descongelados
		$stmt->execute(array($pro_c['pro_c'],$pro_c['ovo_c']));
	}}
	
	$stmt = $db->prepare("DELETE FROM lab_aspira_dias WHERE pro=?"); // tiene q ir al final para que primero congele ovo/emb si es necesario
	$stmt->execute(array($pro));
}
if ($_POST['accion']==2 and $pro<>"" and $new_pro<>"") {
	$rPro = $db->prepare("SELECT pro FROM lab_aspira WHERE pro=?");
	$rPro->execute(array($new_pro));
	if($rPro->rowCount()==1) { ?>
	<script> var x = "<?php echo $new_pro; ?>"; alert('Este protocolo '+x+' ya existe! Debe renombrarlo por uno vacio'); </script>
	<?php } else {
	$stmt = $db->prepare("UPDATE lab_aspira SET pro=? where pro=?");
	$stmt->execute(array($new_pro,$pro));
	$stmt = $db->prepare("UPDATE lab_aspira_dias SET pro=? where pro=?");
	$stmt->execute(array($new_pro,$pro));
	$stmt = $db->prepare("UPDATE lab_aspira_dias SET pro_c=? where pro_c=?");
	$stmt->execute(array($new_pro,$pro));
	$stmt = $db->prepare("UPDATE lab_aspira_T SET pro=? where pro=?");
	$stmt->execute(array($new_pro,$pro));
	$stmt = $db->prepare("UPDATE lab_andro_cap SET pro=? where pro=?");
	$stmt->execute(array($new_pro,$pro));
	}
}		
$rPaci = $db->prepare("SELECT SUBSTRING_INDEX(lab_aspira.pro,'-',1) AS p1,SUBSTRING_INDEX(lab_aspira.pro,'-',-1) AS p2,hc_paciente.dni,ape,nom,lab_aspira.pro,lab_aspira.tip,lab_aspira.vec,lab_aspira.dias FROM hc_paciente,lab_aspira WHERE hc_paciente.dni=lab_aspira.dni and lab_aspira.tip<>'T'  ORDER by ABS(p2) DESC,ABS(p1) DESC");
$rPaci->execute();

if ($paci['dias']>0) $paci['dias']=$paci['dias']-1;  ?>

<style>
.ui-dialog-contain {
  	max-width: 1000px;
	margin: 1% auto 1%;
	padding: 0;
	position: relative;
	top: -35px;
}
.color { color:#F4062B !important; }
.mayuscula {
    text-transform: uppercase; font-size:small;
}
</style>

<div data-role="header" data-position="fixed">
<a href="r_pro.php" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
  <h2>Administración de Protocolos</h2>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="pro_admin.php" method="post" data-ajax="false" name="form2">
<input type="hidden" name="accion"> <input type="hidden" name="pro">

<input id="filtro" data-type="search" placeholder="Filtro..">
<table data-role="table" data-filter="true" data-input="#filtro" class="table-stripe ui-responsive mayuscula">
<thead>
<tr>
<th align="center">Protocolo</th>
<th align="center">Paciente</th>
<th align="center">Renombrar por</th>
<th align="center">Eliminar</th>
</tr>
</thead>
<tbody>
<?php while($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { ?>
<tr>
<th><a href='<?php echo "le_aspi".$paci['dias'].".php?id=".$paci['pro'];?>' rel="external" <?php if (strpos($paci['pro'],"-15") !== false or strpos($paci['pro'],"-16") !== false) echo 'class="color"'; ?>>
<?php echo $paci['tip'].'-'.$paci['pro'].'-'.$paci['vec'];?></a></th>
<td><?php echo $paci['ape'].' '.$paci['nom'];?></td>
<td><input width="100" type="text" data-role="none" name="nom<?php echo $paci['pro']; ?>" id="nom<?php echo $paci['pro']; ?>">
<a href="#" onClick="nombra('<?php echo $paci['pro']; ?>')">Renombrar</a></td>
<td><a href="#" onClick="borra('<?php echo $paci['pro']; ?>')">Eliminar</a></td>
</tr>
<?php } ?>
</tbody>
</table>
</form>
</div><!-- /content -->
<?php } ?>
</div><!-- /page -->
</body>
</html>
