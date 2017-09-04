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

<div data-role="page" class="ui-responsive-panel" id="e_ante_sero" data-dialog="true">

<?php if ($_POST['fec']<>"") {
updateAnte_p_sero($_POST['idx'],$_POST['dni'],$_POST['p_dni'],$_POST['fec'],$_POST['hbs'],$_POST['hcv'],$_POST['hiv'],$_POST['rpr'],$_POST['rub'],$_POST['tox'],$_POST['cla_g'],$_POST['cla_m'],$_FILES['pdf']);
}

if ($_GET['ip'] <> "") {

$dni = $_GET['dni'];
$p_dni = $_GET['ip'];	
$id = $_GET['id'];

if ($dni=="mujer") {
$rPare = $db->prepare("SELECT nom,ape FROM hc_paciente WHERE dni=?");
$rPare->execute(array($p_dni));
} else {
$rPare = $db->prepare("SELECT p_nom,p_ape FROM hc_pareja WHERE p_dni=?");
$rPare->execute(array($p_dni));	
}
$pare = $rPare->fetch(PDO::FETCH_ASSOC);

$Rpop = $db->prepare("SELECT * FROM hc_antece_p_sero WHERE fec=? and p_dni=?");
$Rpop->execute(array($id,$p_dni));
$pop = $Rpop->fetch(PDO::FETCH_ASSOC); ?>

<style>
.ui-dialog-contain {
  	
  	max-width: 600px;
	margin: 2% auto 15px;
	padding: 0;
	position: relative;
	top: -15px;
	
}
.scroll_h { overflow-x: scroll; overflow-y: hidden; white-space:nowrap; } 
</style>

<div data-role="header" data-position="fixed">
    <h3>Serologías<small> (<?php if ($dni=="mujer") echo $pare['ape']." ".$pare['nom'];  else echo $pare['p_ape']." ".$pare['p_nom']; ?>)</small></h3>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="e_ante_p_sero.php" method="post" enctype="multipart/form-data" data-ajax="false" name="form2">
<input type="hidden" name="idx" value="<?php echo $id;?>">
<input type="hidden" name="dni" value="<?php echo $dni;?>">
<input type="hidden" name="p_dni" value="<?php echo $p_dni;?>">

<table width="100%" align="center" style="margin: 0 auto;text-align:center;">
		<tr>
		  <td>Fecha</td>
		  <td><input name="fec" type="date" required id="fec" value="<?php echo $pop['fec'];?>" data-mini="true"></td>
	    </tr>
		<tr>
		  <td width="532">EXAMEN</td>
		  <td width="721">RESULTADO</td>
	    </tr>
		<tr>
		  <td>Hepatitis B - HBs Ag</td>
		  <td><select name="hbs" id="hbs" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["hbs"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["hbs"]==2) echo "selected"; ?>>Negativo</option>
		    </select></td>
	    </tr>
		<tr>
		  <td>Hepatitis C - HCV Ac</td>
		  <td><select name="hcv" id="hcv" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["hcv"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["hcv"]==2) echo "selected"; ?>>Negativo</option>
	      </select></td>
	    </tr>
		<tr>
		  <td>HIV Ac/Ag</td>
		  <td><select name="hiv" id="hiv" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["hiv"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["hiv"]==2) echo "selected"; ?>>Negativo</option>
	      </select></td>
	    </tr>
		<tr>
		  <td>RPR</td>
		  <td><select name="rpr" id="rpr" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["rpr"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["rpr"]==2) echo "selected"; ?>>Negativo</option>
	      </select></td>
	    </tr>
		<?php if ($dni=="mujer") { ?>
        <tr>
		  <td>Rubeola IgG</td>
		  <td><select name="rub" id="rub" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["rub"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["rub"]==2) echo "selected"; ?>>Negativo</option>
	      </select></td>
	    </tr>
        <?php } ?>
		<tr>
		  <td>Toxoplasma IgG</td>
		  <td><select name="tox" id="tox" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["tox"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["tox"]==2) echo "selected"; ?>>Negativo</option>
		    </select></td>
	    </tr>
		<tr>
		  <td>Clamidia IgG</td>
		  <td><select name="cla_g" id="cla_g" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["cla_g"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["cla_g"]==2) echo "selected"; ?>>Negativo</option>
	      </select></td>
	    </tr>
		<tr>
		  <td>Clamidia IgM</td>
		  <td><select name="cla_m" id="cla_m" data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($pop["cla_m"]==1) echo "selected"; ?>>Positivo</option>
		    <option value=2 <?php if ($pop["cla_m"]==2) echo "selected"; ?>>Negativo</option>
		    </select></td>
	    </tr>
		<tr>
		  <td>ADJUNTAR RESULTADO (PDF)</td>
		  <td><input name="pdf" type="file" accept="application/pdf" id="pdf"/><?php if (file_exists("analisis/sero_".$p_dni."_".$pop['fec'].".pdf")) 
		   echo "<a href='analisis/sero_".$p_dni."_".$pop['fec'].".pdf' target='new'>Ver Resultado</a>"; ?></td>
	    </tr>
	  </table>
   
<input type="Submit" name="guardar" value="GUARDAR" data-icon="check" data-iconpos="left" data-mini="true" class="show-page-loading-msg" data-textonly="false" data-textvisible="true" data-msgtext="Guardando datos.." data-theme="b" data-inline="true"/>
 
 </form>
 
</div><!-- /content -->


<?php } ?>
</div><!-- /page -->


</body>
</html>
