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

</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="e_ngs" data-dialog="true">

<?php if ($_POST['pro']<>"" and $_POST['c']>0) {

$c=$_POST['c'];
	
	for($i=1; $i<=$c; $i++) {
	updateNGS($_POST['pro'],$_POST['ovo'.$i],$_POST['ngs1'.$i],$_POST['ngs2'.$i],$_POST['ngs3'.$i]);
	  }
	  
$foto=$_FILES['informe'];
if ($foto['name'] <> "") {
		if (is_uploaded_file($foto['tmp_name'])) {
			 $ruta = 'analisis/ngs_'.$_POST['pro'].'.pdf';
			 move_uploaded_file($foto['tmp_name'], $ruta);
			 }
	} ?>
	<script type="text/javascript">
	window.parent.location.href="lista.php";
    </script>
    <?php
}
	
$id = $_GET['id'];


$Rpop = $db->prepare("SELECT hc_paciente.nom,hc_paciente.ape,lab_aspira.f_fin FROM hc_paciente,lab_aspira WHERE hc_paciente.dni=lab_aspira.dni and lab_aspira.pro=?");
$Rpop->execute(array($id));
$pop = $Rpop->fetch(PDO::FETCH_ASSOC); 

$rNgs = $db->prepare("SELECT ovo,d5cel,d6cel,ngs1,ngs2,ngs3 FROM lab_aspira_dias WHERE pro=? and ((d5d_bio=1 and d5f_cic='C') or (d6d_bio=1 and d6f_cic='C'))");
$rNgs->execute(array($id));

if (file_exists('analisis/ngs_'.$id.'.pdf')) { $pdf=""; $descarga = '<a href="analisis/ngs_'.$id.'.pdf" target="new">Ver/Descargar</a>'; } else { $pdf="required"; $descarga=''; } ?>

<style>
.ui-dialog-contain {
  	
  	max-width: 800px;
	margin: 2% auto 15px;
	padding: 0;
	position: relative;
	top: -15px;
	
}
</style>
<script>
$(document).ready(function () {

$('#form1').submit(function() {
		
	  $("#cargador").popup("open",{positionTo:"window"}); return true;
		
});	
	
});
</script>

<div data-role="header" data-position="fixed">
<a href="lista.php" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
    <h3>NGS: <small><?php echo $pop['ape'].' '.$pop['nom']; ?></small></h3>
</div><!-- /header -->

<div class="ui-content" role="main">
<form action="e_ngs.php" method="post" enctype="multipart/form-data" data-ajax="false" id="form1">
<input type="hidden" name="pro" id="pro" value="<?php echo $id;?>">
<?php echo '<h4>Protocolo: '.$id.' Fecha: '.date("d-m-Y", strtotime($pop['f_fin'])).'</h4>'; ?>
<table width="100%" align="center" style="margin: 0 auto;">
		<tr bgcolor="#BEE5E3">
		  <td>ID Embion</td>
		  <td>Dia 5</td>
          <td>Dia 6</td>
		  <td>Resultado</td>
		  <td>Genero</td>
            <td>Detalles</td>
	    </tr>
         <?php $c=0; while($ngs = $rNgs->fetch(PDO::FETCH_ASSOC)) { $c++; ?>
		<tr>
		  <td><?php echo $ngs['ovo']; ?><input type="hidden" name="ovo<?php echo $c; ?>" value="<?php echo $ngs['ovo'];?>"></td>
		  <td><?php echo $ngs['d5cel']; ?></td>
          <td><?php echo $ngs['d6cel']; ?></td>
		  <td><select name="ngs1<?php echo $c; ?>" required data-mini="true">
		    <option value="">---</option>
		    <option value=1 <?php if ($ngs['ngs1']==1) echo 'selected';?>>Normal</option>
		    <option value=2 <?php if ($ngs['ngs1']==2) echo 'selected';?>>Anormal</option>
            <option value=3 <?php if ($ngs['ngs1']==3) echo 'selected';?>>NR</option>
		    </select></td>
            <td><select name="ngs3<?php echo $c; ?>" required data-mini="true">
                    <option value="">---</option>
                    <option value=1 <?php if ($ngs['ngs3']==1) echo 'selected';?>>Hombre</option>
                    <option value=2 <?php if ($ngs['ngs3']==2) echo 'selected';?>>Mujer</option>
                </select></td>
		  <td><input name="ngs2<?php echo $c; ?>" type="text" required value="<?php echo $ngs['ngs2'];?>" data-mini="true"></td>
	    </tr>
         <?php } ?>
        <tr>
		  <td><strong>Informe</strong></td>
		  <td colspan="2">
		  <input name="informe" type="file" <?php echo $pdf; ?> id="informe" accept="application/pdf" data-mini="true"/>
           </td>
            <td><?php echo $descarga; ?></td>
	    </tr>
		</table>
<input type="hidden" name="c" value="<?php echo $c;?>">  
<div class="enlinea">
<input name="guardar" type="Submit" id="guardar" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-inline="true" data-theme="b" data-mini="true"/>

</div>
<div data-role="popup" id="cargador" data-overlay-theme="b" data-dismissible="false"><p>GUARDANDO DATOS..</p></div> 
 
</form>
 
</div><!-- /content -->

</div><!-- /page -->

</body>
</html>
