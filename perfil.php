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
<title>Perfil</title>
<link rel="stylesheet" href="_themes/tema_inmater.min.css" />
<link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

</head>

<body>
<div data-role="page" class="ui-responsive-panel" id="perfil" data-dialog="true">
<style>
.ui-dialog-contain {
  	
  	max-width: 700px;
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
});
</script>
<div data-role="header" data-position="fixed">
<h1>Mi Perfil</h1>
</div><!-- /header -->
<div class="ui-content" role="main">
<?php
$rPerfi = $db->prepare("SELECT * FROM usuario WHERE user=?");
$rPerfi->execute(array($login));
$perfi = $rPerfi->fetch(PDO::FETCH_ASSOC);

if (isSet($_POST['nom'])) {

updatePerfil($login,$_POST['pass'],$_POST['nom'],$_POST['mail'],$_POST['cmp']);

} 

?>

<form action="perfil.php" method="post" data-ajax="false">
  
    <table width="100%" align="center" style="margin: 0 auto;">
      <tr>
        <td width="12%">Nombre y Apellido</td>
        <td width="51%"><input name="nom" type="text" required id="nom" value="<?php echo $perfi['nom']; ?>" data-mini="true"/></td>
        <td width="18%">Cambiar Contraseña<br>
          <small><b>(Dejar en blanco para NO cambiar)</b></small></td>
        <td width="19%"><input name="pass" type="password" id="pass" data-mini="true" value="<?php echo $perfi['pass']; ?>"/></td>
        </tr>
      <tr>
        <td>E-Mail</td>
        <td><input name="mail" type="email" required id="mail" value="<?php echo $perfi['mail']; ?>" data-mini="true"></td>
        <td>CMP</td>
        <td><input name="cmp" type="text" id="cmp" class="numeros" data-mini="true" value="<?php echo $perfi['cmp']; ?>"/></td>
        </tr>
    </table>
     
<input type="Submit" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-mini="true" data-theme="b" data-inline="true"/>
 
</form>

</div><!-- /content -->

</div><!-- /page -->

</body>
</html>