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
.scroll_h { overflow-x: scroll; overflow-y: hidden; white-space:nowrap; } 
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
	
    $('.numeros').keyup(function() {
		
        var $th = $(this);
        $th.val( $th.val().replace(/[^0-9]/g, function(str) { 
            //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');
            
            return ''; } ) );
			
			//$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
    });
	
	$('.alfanumerico').keyup(function() {
		
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { 
            //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');
            
            return ''; } ) );
			
			//$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
    });
});
</script>
<div data-role="header" data-position="fixed">
<h1>Nuevo Paciente (Hombre Particular)</h1>
</div><!-- /header -->
<div class="ui-content" role="main">
<?php

if (isSet($_POST['p_dni'])) {

insertPareja('',$_POST['p_dni'],$_POST['p_tip'],$_POST['p_nom'],$_POST['p_ape'],$_POST['p_fnac'],$_POST['p_tcel'],$_POST['p_tcas'],$_POST['p_tofi'],$_POST['p_mai'],$_POST['p_dir'],$_POST['p_prof'],$_POST['p_san'],$_POST['p_raz'],$_POST['p_med'],$_POST['p_med_mai'],$_POST['p_med_cel']);

} 

?>

<form action="n_pare_and.php" method="post" enctype="multipart/form-data" data-ajax="false">
<div class="scroll_h">  <table width="100%" align="center" style="margin: 0 auto;">
      <tr>
        <td width="8%">Nombre(s) </td>
        <td width="36%"><input name="p_nom" type="text" required id="p_nom" data-mini="true"/></td>
        <td width="6%">Apellidos </td>
        <td width="31%"><input name="p_ape" type="text" required id="p_ape" data-mini="true"/></td>
        <td><select name="p_raz" id="p_raz" data-mini="true">
          <option value="">Raza:</option>
          <option value="Blanca">Blanca</option>
          <option value="Morena">Morena</option>
          <option value="Mestiza">Mestiza</option>
          <option value="Asiatica">Asiatica</option>
        </select></td>
        <td width="12%"><select name="p_san" id="p_san" data-mini="true">
          <option value="">G. Sangre:</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
        </select></td>
        </tr>
      <tr>
        <td><select name="p_tip" id="p_tip" data-mini="true">
          <option value="DNI" selected>DNI</option>
          <option value="PAS">PAS</option>
          <option value="CEX">CEX</option>
		  </select></td>
        <td><input name="p_dni" type="text" required id="p_dni" data-mini="true" class="alfanumerico"/></td>
        <td>F. Nac</td>
        <td><input name="p_fnac" type="date" id="p_fnac" data-mini="true"/></td>
        <td>Ocupación</td>
        <td><input name="p_prof" type="text" id="p_prof" data-mini="true"/></td>
        </tr>
      <tr>
        <td>Celular</td>
        <td><input name="p_tcel" type="number" step="any" class="numeros" id="p_tcel" data-mini="true"/></td>
        <td>T. Casa</td>
        <td><input name="p_tcas" type="number" step="any" id="p_tcas" data-mini="true" class="numeros"/></td>
        <td width="7%">E-mail</td>
        <td><input name="p_mai" type="email" id="p_mai" data-mini="true"></td>
      </tr>
      <tr>
        <td>T. Oficina</td>
        <td><input name="p_tofi" type="number" step="any" id="p_tofi" data-mini="true"/></td>
        <td>Dirección</td>
        <td colspan="3"><input name="p_dir" type="text" id="p_dir" data-mini="true"/></td>
      </tr>
      <tr>
        <td colspan="6" align="center" class="ui-bar-a">Médico de procedencia</td>
        </tr>
      <tr>
        <td>Nombre y Apellidos</td>
        <td><input name="p_med" type="text" required id="p_med" data-mini="true"/></td>
        <td>E-mail</td>
        <td><input name="p_med_mai" type="email" id="p_med_mai" data-mini="true"></td>
        <td>Teléfono</td>
        <td><input name="p_med_cel" type="number" step="any" id="p_med_cel" data-mini="true"/></td>
      </tr>
    </table></div>
     
<input type="Submit" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-mini="true" data-theme="b" data-inline="true"/>
 
</form>

</div><!-- /content -->

</div><!-- /page -->

</body>
</html>