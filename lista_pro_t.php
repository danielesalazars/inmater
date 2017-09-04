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

<div data-role="page" class="ui-responsive-panel" id="lista_pro_t" data-dialog="true">
<?php
$rUser = $db->prepare("SELECT role FROM usuario WHERE user=?");
$rUser->execute(array($login));
$user = $rUser->fetch(PDO::FETCH_ASSOC);

if ($user['role']==2)
$rPaci = $db->prepare("SELECT hc_paciente.dni,ape,nom,don,san,m_ets,hc_reprod.med,lab_aspira.pro,lab_aspira.sta,lab_aspira.dias,lab_aspira.f_fin,hc_reprod.p_dni FROM hc_antece,hc_paciente,lab_aspira,hc_reprod WHERE hc_reprod.id=lab_aspira.rep and hc_paciente.dni = hc_antece.dni and hc_paciente.dni=lab_aspira.dni and lab_aspira.tip='T' ORDER by lab_aspira.fec DESC");
$rPaci->execute(); ?>

<style>
.ui-dialog-contain {
  	max-width: 1200px;
	margin: 1% auto 1%;
	padding: 0;
	position: relative;
	top: -35px;
}
.color { color:#F4062B !important; }
</style>

<div data-role="header" data-position="fixed">
  <h2>Traslados</h2>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="lista_pro_t.php" method="post" data-ajax="false">

    <input id="filtro" data-type="search" placeholder="Filtro..">
    <table data-role="table" data-filter="true" data-input="#filtro"
           class="table-stripe ui-responsive mayuscula">
        <thead>
        <tr>
            <th align="center" width="110">Protocolo</th>
            <th align="center">Paciente</th>
            <th align="center">Medio</th>
            <th align="center">Informe</th>
            <th align="center">Informe Inmater</th>
            <th align="center">Fecha</th>
        </tr>
        </thead>
        <tbody>
<?php while($paci = $rPaci->fetch(PDO::FETCH_ASSOC)) { 
	$color=''; if ($paci['f_fin']=='0000-00-00') { $fecha=''; $color='class="color"'; } else { $fecha=date("d-m-Y", strtotime($paci['f_fin'])); $paci['dias']=$paci['dias']-1;} ?>

	<tr <?php echo $color; ?>>
        <td><a href='<?php echo "le_aspi".$paci['dias'].".php?id=".$paci['pro'];?>' rel="external"><?php echo '('.$paci['pro'].')';?></a></td>
    <td>
        <?php echo $paci['ape'].' '.$paci['nom'];?>
    <?php if ($paci['san']=="O-" || $paci['san']=="A-" || $paci['san']=="B-" || $paci['san']=="AB-") echo  " <b>(SANGRE NEGATIVA) </b>";
	   if (strpos($paci['m_ets'],"VIH") !== false) echo  " <b>(VIH) </b>"; 
	   if (strpos($paci['m_ets'],"Hepatitis C") !== false) echo  " <b>(Hepatitis C) </b>"; 
	   if ($paci['don']=='D') echo  " <b>(DONANTE)</b>"; ?>
    </td>
    <td><?php echo $paci['med']; ?></td>
        <td><small><?php echo '<a href="emb_pic/traslado_'.$paci['pro'].'.pdf" target="new">Ver</a>'; ?></small</td>
        <td><small><a href="info_r.php?a=<?php echo $paci['pro'] . "&b=" . $paci['dni'] . "&c=" . $paci['p_dni']; ?>" target="new">Ver</a></small</td>
        <td><?php echo $fecha; ?></td>
    </tr>
        
<?php } ?>
        </tbody>
    </table>

 </form>
 
</div><!-- /content -->

</div><!-- /page -->

</body>
</html>
