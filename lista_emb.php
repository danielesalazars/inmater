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
<style>
.color { color:#F4062B !important; }
.color2 { color: #72a2aa; }
.pequeno2 .ui-input-text {
	width: 50px !important;
}	
</style>
</head>

<body>
<div data-role="page" class="ui-responsive-panel" id="lista">
<?php	
$rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($user["role"]==2) 
$rEmb = $db->prepare("SELECT id,nom,cbp,mai FROM lab_user");
$rEmb->execute();
?> 
<div data-role="header" data-position="fixed">

<h1>Embriologos</h1>

<?php if ($user["role"]==2) { ?>
<div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
<a href='lista.php' class="ui-btn ui-btn-c ui-icon-home ui-btn-icon-left" rel="external">Inicio</a>
<a href='e_emb.php?id=' class="ui-btn" rel="external">Agregar Embriologo</a>
</div>
<?php } ?>

<a href="index.php" class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power" rel="external">Salir</a>
</div><!-- /header -->

<div class="ui-content" role="main">

<FORM ACTION="lista_emb.php" method="post" data-ajax="false" id="form1">
<ol data-role="listview" data-theme="a" data-filter="true" data-filter-placeholder="Filtro..." data-inset="true">
<?php while($embrio = $rEmb->fetch(PDO::FETCH_ASSOC)) { ?>
<li>
    <a href='<?php echo "e_emb.php?id=".$embrio["id"];?>' rel="external"><?php echo $embrio["nom"];?></a>   
    <span class="ui-li-count"><?php echo $embrio["mai"];?></span>  
</li>
<?php } if ($rEmb->rowCount()<1) echo '<p><h3>¡ No hay Embriologos!</h3></p>'; ?>
</ol> 
</FORM>
</div><!-- /content -->
<div data-role="footer" data-position="fixed" id="footer"> 
<p><small> <?php echo $rEmb->rowCount();?> Embriologos</small></p>
</div><!-- /footer -->
</div><!-- /page -->
</body>
</html>