<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$login = $_SESSION['login'];
$dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
if (!$login) { 
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://".$dir."'>";
}

require("_database/db_tools.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="_themes/tema_inmater.min.css" />
<link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="lista_pro_8" data-dialog="true">
<?php $rPaci = $db->prepare("SELECT hc_paciente.dni,ape,nom,hc_reprod.med,con_end,con_od,con1_med FROM hc_reprod,hc_paciente WHERE hc_paciente.dni = hc_reprod.dni and hc_reprod.f_asp = '' and hc_reprod.p_iiu IS NULL and hc_reprod.cancela <> 1 ORDER by ape ASC");
$rPaci->execute(); ?>

<style>
.ui-dialog-contain {
  	max-width: 1000px;
	margin: 1% auto 1%;
	padding: 0;
	position: relative;
	top: -35px;
}
.mayuscula {
    text-transform: uppercase;
}
</style>
<div data-role="header" data-position="fixed">
<h2>Pacientes desde el Ciclo 8</h2>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="lista_pro_8.php" method="post" data-ajax="false">

<ol data-role="listview" data-theme="a" data-inset="true">
<?php while($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { 

$con_end = explode("|", $paci['con_end']);
$con_od = explode("|", $paci['con_od']);
$con1_med = explode("|", $paci['con1_med']);
	
if ($con_end[7] <> ""  or $con_end[8] <> "" or $con_end[9] <> "" or $con_end[10] <> "" or $con_od[7] <> ""  or $con_od[8] <> "" or $con_od[9] <> "" or $con_od[10] <> "" or $con1_med[7] <> ""  or $con1_med[8] <> "" or $con1_med[9] <> "" or $con1_med[10] <> "") { ?>

<li class="mayuscula">
<a href="<?php echo "n_repro.php?id=".$paci['dni'];?>" rel="external"><?php echo $paci['ape'].' '.$paci['nom'].' ('.$paci['dni'].')';?><span class="ui-li-count"><?php echo $paci['med'];?></span></a>
</li>     
<?php } } ?>
</ol> 
</form>
</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
