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
function Beta(beta,pro) {
    document.form2.val_beta.value=beta.value;
	document.form2.pro_beta.value=pro;
	document.form2.submit();
}
</script>
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="lista_pro_b" data-dialog="true">
<?php if ($_POST['val_beta']<>"" and $_POST['pro_beta']<>"") {
	$stmt = $db->prepare("UPDATE lab_aspira_T SET beta=? where pro=?");
	$stmt->execute(array($_POST['val_beta'],$_POST['pro_beta']));
	echo "<div id='alerta'> BETA Guardado! </div>";
	}
	
$rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($user['role']==1 or $user['role']==2)
	if ($_GET['med']==1) { $cerrar="lista.php"; $porMed=" and lab_aspira_T.med='".$login."'"; } else { $cerrar="lista_pro.php"; $porMed=""; }
$rPaci = $db->prepare("SELECT hc_paciente.dni,ape,nom,hc_paciente.med,lab_aspira.pro,lab_aspira.tip,lab_aspira.dias,lab_aspira.fec2,lab_aspira.fec3,lab_aspira.fec4,lab_aspira.fec5,lab_aspira.fec6,lab_aspira_T.beta,lab_aspira_T.dia FROM hc_paciente,lab_aspira,lab_aspira_T WHERE hc_paciente.dni=lab_aspira.dni and lab_aspira_T.pro=lab_aspira.pro".$porMed." ORDER by lab_aspira_T.beta ASC");
$rPaci->execute();
 ?>

<style>
.ui-dialog-contain {
  	max-width: 1000px;
	margin: 1% auto 1%;
	padding: 0;
	position: relative;
	top: -35px;
}

.col0 { background-color:#FFFF91 !important; }
.col1 { background-color:#FFEBCD !important; }
#alerta { background-color:#FF9;margin: 0 auto; text-align:center; padding:4px;}
</style>

<div data-role="header" data-position="fixed">
<a href="<?php echo $cerrar; ?>" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
  <h2>Transferencia - Betas</h2>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="lista_pro_b.php?med=<?php echo $_GET['med']; ?>" method="post" data-ajax="false" name="form2">
<input type="hidden" name="val_beta"> <input type="hidden" name="pro_beta">
<div style="width:800px;display:inline-block;">
<ul data-role="listview" data-theme="a" data-filter="true" data-filter-placeholder="Filtro..." data-inset="true">
<?php $t_0=0; $t_1=0; $t_2=0; $t_3=0; $t_4=0; $i = 0;
while($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) {
	
	$color=''; if ($paci['beta']==0) $color='class="col0"'; if ($paci['beta']==1) $color='class="col1"';

    $beta=$paci['fec'.$paci['dia']]; //la fecha del dia de transferencia
	if($paci['dia']==2) $dt=15; if($paci['dia']==3) $dt=14; if($paci['dia']==4) $dt=13; if($paci['dia']==5) $dt=12; if($paci['dia']==6) $dt=11;
	$beta=date('d-m-Y', strtotime($beta.' + '.$dt.' days')); ?>

    <?php if ($paci['beta']==0) { ?>
	<li <?php echo $color; ?>>
    <?php echo '('.$paci['tip'].'-'.$paci['pro'].')';?> <small><?php echo $paci['ape'].' '.$paci['nom'];?></small>
    
    <span class="ui-li-count">
    <?php echo $paci['med'];?>
    <select data-role="none" name="beta<?php echo $paci['pro']; ?>" data-mini="true" onChange="Beta(this,'<?php echo $paci['pro']; ?>')">
    <option value=0 <?php if($paci['beta']==0) { echo 'selected'; $t_0++; } ?>>Pendiente</option>
    <option value=1 <?php if($paci['beta']==1) { echo 'selected'; $t_1++; } ?>>Positivo</option>
    <option value=2 <?php if($paci['beta']==2) { echo 'selected'; $t_2++; } ?>>Negativo</option>
    <option value=3 <?php if($paci['beta']==3) { echo 'selected'; $t_3++; } ?>>Bioquimico</option>
    <option value=4 <?php if($paci['beta']==4) { echo 'selected'; $t_4++; } ?>>Aborto</option>
    </select>
    <?php echo $beta;?>
    </span>
    </li>
<?php } else {
        $datos[$i] = array($beta, $color, '('.$paci['tip'].'-'.$paci['pro'].')', $paci['ape'].' '.$paci['nom'], $paci['med'], $paci['pro'],$paci['beta']);
        $i++;
    }

}

usort($datos, function($a1, $a2) {
    $v1 = strtotime($a1[0]); // 0 = 1er valor del arrary osea: $beta
    $v2 = strtotime($a2[0]);
    return $v2 - $v1; // $v1 - $v2 to reverse direction
});

//print_r($datos);
foreach ($datos as $boy) { ?>
    <li <?php echo $boy[1]; ?>>
        <?php echo $boy[2];?> <small><?php echo $boy[3];?></small>

        <span class="ui-li-count">
    <?php echo $boy[4];?>
            <select data-role="none" name="beta<?php echo $boy[5]; ?>" data-mini="true" onChange="Beta(this,'<?php echo $boy[5]; ?>')">
    <option value=0 <?php if($boy[6]==0) { echo 'selected'; $t_0++; } ?>>Pendiente</option>
    <option value=1 <?php if($boy[6]==1) { echo 'selected'; $t_1++; } ?>>Positivo</option>
    <option value=2 <?php if($boy[6]==2) { echo 'selected'; $t_2++; } ?>>Negativo</option>
    <option value=3 <?php if($boy[6]==3) { echo 'selected'; $t_3++; } ?>>Bioquimico</option>
    <option value=4 <?php if($boy[6]==4) { echo 'selected'; $t_4++; } ?>>Aborto</option>
    </select>
            <?php echo $boy[0];?>
    </span>
    </li>
<?php }

if ($rPaci->rowCount()<1) 

echo '<p><h3>¡ No hay registros !</h3></p>';
?>
</ul> 
</div>
<div style="width:150px; float:right;">
<h3>RESUMEN</h3>
<?php echo "<span class='col0'>Pendientes: ".$t_0."</span><br><span class='col1'>Positivos: ".$t_1."</span><br>Negativos: ".$t_2."<br>Bioquimicos: ".$t_3."<br>Abortos: ".$t_4."<br><br>TOTAL: ".($t_0+$t_1+$t_2+$t_3+$t_4); ?>
</div>
 </form>
 
</div><!-- /content -->

</div><!-- /page -->
<script>
$(function(){
	$('#alerta').delay(3000).fadeOut('slow');

});//]]> 
</script>
</body>
</html>
