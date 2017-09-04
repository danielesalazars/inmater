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
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nuevo Paciente</title>
<link rel="stylesheet" href="_themes/tema_inmater.min.css" />
<link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

</head>

<body>
<div data-role="page" class="ui-responsive-panel" id="n_paci" data-dialog="true">
<style>
.ui-dialog-contain {
  	
  	max-width: 1200px;
	margin: 2% auto 15px;
	padding: 0;
	position: relative;
	top: -15px;
	
}
.enlinea div { display : inline-block; vertical-align : middle; }
</style>

<script>
$(document).ready(function () {
   // No close unsaved windows --------------------
     var unsaved = false;
    $(":input").change(function () {
		
		unsaved = true;
		
    });
	
	$(window).on('beforeunload', function(){
		if (unsaved) { 
		return 'UD. HA REALIZADO CAMBIOS';
		}
	});
	
	// Form Submit
	$(document).on("submit", "form", function(event){
		// disable unload warning
		$(window).off('beforeunload');
	});
	
	$('.alfanumerico').keyup(function() {
		
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { 
            //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');
            
            return ''; } ) );
			
			//$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
    });
	
	$(".mujer,.hombre").hide();
	
	$("#paciente").change(function () {	
		if ($(this).val()==1) {
			$(".mujer").show();$(".hombre").hide();
			$("#nom,#ape,#dni,#don,input[name='pareja']").prop('required',true); 
			$("#p_nom,#p_ape,#p_dni").prop('required',false); 
			$("#T_med option[value='Otro']").remove();
		} 
		if ($(this).val()==2) {
			$(".hombre").show();$(".mujer").hide();
			$("#p_nom,#p_ape,#p_dni").prop('required',true); 
			$("#nom,#ape,#dni,#don,input[name='pareja']").prop('required',false);
			$("#T_med").append($('<option> </option>').val('Otro').html('OTRO'));
		}
		$("#T_med").prop('selectedIndex', 0);
		$("#T_med").selectmenu("refresh",true);
	});
	
	$("input[name='pareja']").change(function () {	
		if ($(this).val()==1) {
			$(".hombre").show();
			$("#p_nom,#p_ape,#p_dni").prop('required',true); 
			
		} 
		if ($(this).val()==2) {
			$(".hombre").hide();
			$("#p_nom,#p_ape,#p_dni").prop('required',false); 
		}
	});
});
</script>
<div data-role="header" data-position="fixed">
<h1>Nuevo Paciente</h1>
</div><!-- /header -->
<div class="ui-content" role="main">
<?php
$rMed = $db->prepare("SELECT user FROM usuario WHERE role=1");
$rMed->execute();

if ($_POST['paciente']==2) {

insertPareja('',$_POST['p_dni'],$_POST['p_tip'],$_POST['p_nom'],$_POST['p_ape'],$_POST['p_fnac'],'','','','','','','','',$_POST['T_med'],'','');

} 

if ($_POST['paciente']==1) {

insertPaci($_POST['dni'],$_POST['T_med'],$_POST['tip'],$_POST['nom'],$_POST['ape'],$_POST['fnac'],'','','','','','','','','','','',$_POST['don'],'',$_FILES['foto'],'','');

if ($_POST['pareja']==1 and $_POST['dni']<>"")
insertPareja($_POST['dni'],$_POST['p_dni'],$_POST['p_tip'],$_POST['p_nom'],$_POST['p_ape'],$_POST['p_fnac'],'','','','','','','','',$_POST['T_med'],'',''); else { ?>
			<script type="text/javascript">
			window.parent.location.href="lista.php";
			</script>
			<?php }
} ?>

<form action="n_pacipare.php" method="post" data-ajax="false">
<div class="enlinea ui-bar-a">Paciente:
<select name="paciente" id="paciente" required data-mini="true">
  <option value="" selected>Seleccione..</option>
  <option value=1>Mujer</option>
  <option value=2>Hombre</option>
</select>Médico:
<select name="T_med" id="T_med" required data-mini="true">
  <option value="" selected>Seleccione..</option>
  <?php while ($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
  <option value="<?php echo $med['user']; ?>"><?php echo $med['user']; ?></option>
  <?php } ?>
</select>  
</div>

  <table width="100%" align="center" style="margin: 0 auto;" class="mujer">
		<tr>
		  <td width="9%">Nombre(s) </td>
		  <td width="36%"><input name="nom" type="text" id="nom" data-mini="true"/></td>
		  <td width="6%">Apellidos	      </td>
		  <td width="32%"><input name="ape" type="text" id="ape" data-mini="true"/></td>
		  <td width="17%"><select name="don" id="don" data-mini="true">
		    <option value="">Tipo Paciente:</option>
		    <option value="P">Paciente</option>
		    <option value="D">Donante</option>
	      </select></td>
		  </tr>
		<tr>
		  <td><select name="tip" id="tip" data-mini="true">
		    <option value="DNI" selected>DNI</option>
		    <option value="PAS">PAS</option>
            <option value="CEX">CEX</option>
		    </select></td>
		  <td><input name="dni" type="text" id="dni" data-mini="true" class="alfanumerico"/></td>
		  <td>F. Nac</td>
		  <td><input name="fnac" type="date" id="fnac" data-mini="true"/></td>
		  <td><fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
        <legend>Pareja:</legend>
        <input type="radio" name="pareja" id="parejaa" value=1> <label for="parejaa">Si</label>
        <input type="radio" name="pareja" id="parejab" value=2> <label for="parejab">No</label>
    	</fieldset></td>
		  </tr>
</table>
<table width="100%" align="center" style="margin: 0 auto;" class="hombre">
      <tr>
        <td width="9%">Nombre(s) </td>
        <td width="36%"><input name="p_nom" type="text" id="p_nom" data-mini="true"/></td>
        <td width="7%">Apellidos </td>
        <td width="31%"><input name="p_ape" type="text" id="p_ape" data-mini="true"/></td>
        <td width="17%">&nbsp;</td>
        </tr>
      <tr>
        <td><select name="p_tip" id="p_tip" data-mini="true">
          <option value="DNI" selected>DNI</option>
          <option value="PAS">PAS</option>
          <option value="CE">C. Extranjeria</option>
		  </select></td>
        <td><input name="p_dni" type="text" id="p_dni" data-mini="true" class="alfanumerico"/></td>
        <td>F. Nac</td>
        <td><input name="p_fnac" type="date" id="p_fnac" data-mini="true"/></td>
        <td>&nbsp;</td>
        </tr>
    </table>
     
<input type="Submit" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-mini="true" data-theme="b" data-inline="true"/>
 
</form>

</div><!-- /content -->

</div><!-- /page -->

</body>
</html>