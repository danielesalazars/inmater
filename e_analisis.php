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

<div data-role="page" class="ui-responsive-panel" id="e_analisis" data-dialog="true">

<?php if ($_POST['dni']<>"") {
updateAnalisis($_POST['idx'],$_POST['dni'],$_POST['a_mue'],$_POST['nom'],$_POST['med'],$_POST['a_exa'],$_POST['a_sta'],$_POST['a_obs'],$_POST['cor'],$login,$_FILES['informe']);
}
	
$id = $_GET['id'];

if ($login=='eco')
	$rPaci = $db->prepare("SELECT dni,ape,nom,med FROM hc_paciente"); // solo para mujeres
else if ($login=='genomics')
	$rPaci = $db->prepare("SELECT p_dni AS dni,p_ape AS ape,p_nom AS nom,p_med AS med FROM hc_pareja"); // solo para hombres	
else
	$rPaci = $db->prepare("SELECT dni,ape,nom,med FROM hc_paciente UNION SELECT p_dni,p_ape,p_nom,p_med FROM hc_pareja");

$rPaci->execute();

$Rpop = $db->prepare("SELECT * FROM hc_analisis WHERE id=?");
$Rpop->execute(array($id));
$pop = $Rpop->fetch(PDO::FETCH_ASSOC); 

$rMed = $db->prepare("SELECT id,nom FROM hc_analisis_tip WHERE lab=? ORDER by nom ASC");
$rMed->execute(array($login));

$ruta = 'analisis/'.$pop['id'].'_'.$pop['a_dni'].'.pdf';
if (file_exists($ruta)) $pdf=""; else $pdf="required"; ?>

<style>
.ui-dialog-contain {
  	
  	max-width: 1000px;
	margin: 2% auto 15px;
	padding: 0;
	position: relative;
	top: -15px;
	
}
.scroll_h { overflow-x: scroll; overflow-y: hidden; white-space:nowrap; } 
.paci_insert {
    text-transform: uppercase; font-size:small;
}
.enlinea .ui-checkbox {
    display : inline-block;
	float:right;
}
</style>
<script>
$(document).ready(function () {

$('#form1').submit(function() {
		
	  $("#cargador").popup("open",{positionTo:"window"}); return true;
		
});	
    
$(".ui-input-search input").attr("id", "paci_nom");
$('#paci_nom').prop('required', 'true');

	$('.paci_insert').click(function(e){
		$('#paci_nom').val($(this).attr("nom"));
		$('#nom').val($(this).attr("nom"));
		$('#med').val($(this).attr("med"));
		$('#dni').val($(this).attr("dni"));
		$('#paci_nom').textinput('refresh');
		$('.fil_paci li').addClass('ui-screen-hidden');
		$('#paci_nom').focus();
});
	
});

</script>

<script>
$(document).ready(function () {
<?php if ($pop['id']<>'') { ?>	
	$('#paci_nom').val('<?php echo $pop['a_nom']; ?>');
	$('#dni').val('<?php echo $pop['a_dni']; ?>');
	$('#nom').val('<?php echo $pop['a_nom']; ?>');
	$('#med').val('<?php echo $pop['a_med']; ?>');
<?php } ?>
});
</script>
<div data-role="header" data-position="fixed">
<a href="lista.php" rel="external" class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Cerrar</a>
    <h3>Nuevo <?php if ($login=='eco') echo 'Ecografía'; else echo 'Exámen'; ?></h3>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="e_analisis.php" method="post" enctype="multipart/form-data" data-ajax="false" id="form1">
<input type="hidden" name="idx" id="idx" value="<?php echo $id;?>"> <!--idx="idx" se usa en el javascript-->
<input type="hidden" name="dni" id="dni">
<input type="hidden" name="nom" id="nom">
<input type="hidden" name="med" id="med">

<table width="100%" align="center" style="margin: 0 auto;">
		<tr>
		  <td>Fecha <?php if ($login<>'eco') echo 'de toma de muestra'; ?></td>
		  <td width="1053"><input name="a_mue" type="date" required id="a_mue" value="<?php echo $pop['a_mue'];?>" data-mini="true"></td>
		  <td width="4">&nbsp;</td>
	    </tr>
		<tr>
		  <td>Tipo de <?php if ($login=='eco') echo 'Ecografía'; else echo 'Exámen'; ?></td>
		  <td colspan="2"><select name="a_exa" id="a_exa" required data-mini="true">
		    <option value="">---</option>
		    <?php while($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
			<option value="<?php echo $med['nom']; ?>" <?php if ($med['nom']==$pop['a_exa']) echo 'selected';?>><?php echo $med['nom']; ?></option>
			<?php } ?>
	      </select></td>
          
	    </tr>
        <?php if ($login=='eco') echo '<input type="hidden" name="a_sta" id="a_sta">'; else { ?>
		<tr>
		  <td>Resultado</td>
		  <td colspan="2"><select name="a_sta" id="a_sta" required data-mini="true">
		    <option value="">---</option>
		    <option value="Positivo" <?php if ($pop['a_sta']=='Positivo') echo 'selected';?>>Positivo</option>
            <option value="Negativo" <?php if ($pop['a_sta']=='Negativo') echo 'selected';?>>Negativo</option>
	      </select></td>
	    </tr>
        <?php } ?>
		<tr>
		  <td>Informe</td>
		  <td colspan="2">
		  <input name="informe" type="file" <?php echo $pdf; ?> id="informe" accept="application/pdf" data-mini="true"/>
		   </td>
	    </tr>
		<tr>
		  <td width="201">Paciente</td>
		  <td colspan="2">
		    <ul data-role="listview" data-theme="c" data-inset="true" data-filter="true" data-filter-reveal="true" data-filter-placeholder="Buscar paciente por Nombre o DNI..." data-mini="true" class="fil_paci">
		      <?php while($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { ?>
		      <li data-icon="false" data-filtertext="<?php echo $paci['ape'].' '.$paci['nom'].' '.$paci['dni']; ?>">
            <a href="#" class="paci_insert" dni="<?php echo $paci['dni']; ?>" nom="<?php echo $paci['ape'].' '.$paci['nom']; ?>" med="<?php echo $paci['med']; ?>">
			  <?php echo $paci['ape'].' '.$paci['nom'].'<span class="ui-li-count">'.$paci['dni'].'/'.$paci['med'].'</span>'; ?></a>
              </li>
		      <?php } ?>
	        </ul></td>
		  </tr>
		<tr>
		  <td>
         Observación
          </td>
		  <td colspan="2"><textarea name="a_obs" id="a_obs" data-mini="true"><?php echo $pop['a_obs'];?></textarea></td>
		  </tr>
		</table>
   

<div class="enlinea">
<input name="guardar" type="Submit" id="guardar" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-inline="true" data-theme="b" data-mini="true"/>
<?php if ($login=='eco') echo '<input type="hidden" name="cor" id="cor">'; else { ?>
<input type="checkbox" name="cor" id="cor" data-mini="true" value=1 <?php if ($pop['cor']==1) echo "checked"; ?>><label for="cor">Exámen de Cortesía?</label>
<?php } ?>
</div>
<div data-role="popup" id="cargador" data-overlay-theme="b" data-dismissible="false"><p>GUARDANDO DATOS..</p></div> 
 
</form>
 
</div><!-- /content -->

</div><!-- /page -->

</body>
</html>
