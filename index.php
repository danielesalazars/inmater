<?php
session_start(); 

$_SESSION['login']="";

require("_database/db_tools.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>INMATER</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="_themes/tema_inmater.min.css" />
<link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>


<script language="javascript" type="text/javascript"> 

function validForm(form)
{
	if (form.login.value == "") 
    {
	   alert("Debe llenar el campo 'Usuario'");
		return false;
	}
	else if (form.pass.value == "") 
    {
	   alert("Debe llenar el campo 'Contraseña'");
		return false;
	}
	else return true;
}
 
</script>

<?php 

if (($_POST['login']<>"") && authentification($_POST['login'],$_POST['pass'])){
/*
$rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($_POST['login']));
$user = $rUser->fetch(PDO::FETCH_ASSOC);
	
		if ($user["role"]==1)
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://".$dir."/lista.php'>";
*/		
		$_SESSION['login'] = strtolower(trim(preg_replace('/\s+/',' ', $_POST['login'])));
		$dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://".$dir."/lista.php'>";
}
?>
</head>

<body>
<div data-role="page" class="ui-responsive-panel">
<div data-role="header" data-position="fixed">

<h1>INMATER</h1>
 <!--<a href="n_perfi.php" data-rel="dialog" data-icon="search">Registrarse</a> -->
</div><!-- /header -->
     
<div class="ui-content" role="main">
<div class="ui-grid-b">
    <div class="ui-block-a"></div>
    <div class="ui-block-b">
    <form action="index.php" method="post" data-ajax="false">
       
    <img src="_images/logo_login.jpg" width="100%"/>
        <label for="login">Usuario:</label>
        <input name="login" type="text" id="login">
        <label for="pass">Contraseña:</label>
        <input name="pass" type="password" id="pass">
        <?php if (!authentification($_POST['login'], $_POST['pass']) and $_POST['login']<> "") echo "<font color='#FFD520'>Error de validación</font> &nbsp;&nbsp;"; ?>
        <input name="Entrar" type="Submit" onClick="return validForm(this.form)" value="Entrar" data-icon="check" data-iconpos="left" data-mini="true" data-inline="true"  data-theme="c"/>
		
    </form>
    </div>
    <div class="ui-block-c"></div>
</div><!-- /grid-b -->

		
</div><!-- /content -->

</div><!-- /page -->

</body>
</html>