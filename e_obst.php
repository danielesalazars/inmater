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
<script src="jquery.maskedinput.js" type="text/javascript"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<style>
	.controlgroup-textinput{
		padding-top:.10em;
		padding-bottom:.10em;
	}
</style>
</head>

<body>

<div data-role="page" class="ui-responsive-panel" id="e_obst" data-dialog="true">
<?php
if (isSet($_POST['idx'])) {
	
$con_fec = $_POST['con_fec0']."|".$_POST['con_fec1']."|".$_POST['con_fec2']."|".$_POST['con_fec3']."|".$_POST['con_fec4']."|".$_POST['con_fec5']."|".$_POST['con_fec6']."|".$_POST['con_fec7']."|".$_POST['con_fec8']."|".$_POST['con_fec9']."|".$_POST['con_fec10']."|".$_POST['con_fec11']."|".$_POST['con_fec12']."|".$_POST['con_fec13']."|".$_POST['con_fec14']."|".$_POST['con_fec15'];

$con_fec_h = $_POST['con_fec_h0']."|".$_POST['con_fec_h1']."|".$_POST['con_fec_h2']."|".$_POST['con_fec_h3']."|".$_POST['con_fec_h4']."|".$_POST['con_fec_h5']."|".$_POST['con_fec_h6']."|".$_POST['con_fec_h7']."|".$_POST['con_fec_h8']."|".$_POST['con_fec_h9']."|".$_POST['con_fec_h10']."|".$_POST['con_fec_h11']."|".$_POST['con_fec_h12']."|".$_POST['con_fec_h13']."|".$_POST['con_fec_h14']."|".$_POST['con_fec_h15'];

$con_fec_m = $_POST['con_fec_m0']."|".$_POST['con_fec_m1']."|".$_POST['con_fec_m2']."|".$_POST['con_fec_m3']."|".$_POST['con_fec_m4']."|".$_POST['con_fec_m5']."|".$_POST['con_fec_m6']."|".$_POST['con_fec_m7']."|".$_POST['con_fec_m8']."|".$_POST['con_fec_m9']."|".$_POST['con_fec_m10']."|".$_POST['con_fec_m11']."|".$_POST['con_fec_m12']."|".$_POST['con_fec_m13']."|".$_POST['con_fec_m14']."|".$_POST['con_fec_m15'];

$con_sem = $_POST['con_sem0']."|".$_POST['con_sem1']."|".$_POST['con_sem2']."|".$_POST['con_sem3']."|".$_POST['con_sem4']."|".$_POST['con_sem5']."|".$_POST['con_sem6']."|".$_POST['con_sem7']."|".$_POST['con_sem8']."|".$_POST['con_sem9']."|".$_POST['con_sem10']."|".$_POST['con_sem11']."|".$_POST['con_sem12']."|".$_POST['con_sem13']."|".$_POST['con_sem14']."|".$_POST['con_sem15'];

$con_eg = $_POST['con_eg0']."|".$_POST['con_eg1']."|".$_POST['con_eg2']."|".$_POST['con_eg3']."|".$_POST['con_eg4']."|".$_POST['con_eg5']."|".$_POST['con_eg6']."|".$_POST['con_eg7']."|".$_POST['con_eg8']."|".$_POST['con_eg9']."|".$_POST['con_eg10']."|".$_POST['con_eg11']."|".$_POST['con_eg12']."|".$_POST['con_eg13']."|".$_POST['con_eg14']."|".$_POST['con_eg15'];

$con_pes = $_POST['con_pes0']."|".$_POST['con_pes1']."|".$_POST['con_pes2']."|".$_POST['con_pes3']."|".$_POST['con_pes4']."|".$_POST['con_pes5']."|".$_POST['con_pes6']."|".$_POST['con_pes7']."|".$_POST['con_pes8']."|".$_POST['con_pes9']."|".$_POST['con_pes10']."|".$_POST['con_pes11']."|".$_POST['con_pes12']."|".$_POST['con_pes13']."|".$_POST['con_pes14']."|".$_POST['con_pes15'];

$con_pa = $_POST['con_pa0']."|".$_POST['con_pa1']."|".$_POST['con_pa2']."|".$_POST['con_pa3']."|".$_POST['con_pa4']."|".$_POST['con_pa5']."|".$_POST['con_pa6']."|".$_POST['con_pa7']."|".$_POST['con_pa8']."|".$_POST['con_pa9']."|".$_POST['con_pa10']."|".$_POST['con_pa11']."|".$_POST['con_pa12']."|".$_POST['con_pa13']."|".$_POST['con_pa14']."|".$_POST['con_pa15'];

$con_mov = $_POST['con_mov0']."|".$_POST['con_mov1']."|".$_POST['con_mov2']."|".$_POST['con_mov3']."|".$_POST['con_mov4']."|".$_POST['con_mov5']."|".$_POST['con_mov6']."|".$_POST['con_mov7']."|".$_POST['con_mov8']."|".$_POST['con_mov9']."|".$_POST['con_mov10']."|".$_POST['con_mov11']."|".$_POST['con_mov12']."|".$_POST['con_mov13']."|".$_POST['con_mov14']."|".$_POST['con_mov15'];

$con_ede = $_POST['con_ede0']."|".$_POST['con_ede1']."|".$_POST['con_ede2']."|".$_POST['con_ede3']."|".$_POST['con_ede4']."|".$_POST['con_ede5']."|".$_POST['con_ede6']."|".$_POST['con_ede7']."|".$_POST['con_ede8']."|".$_POST['con_ede9']."|".$_POST['con_ede10']."|".$_POST['con_ede11']."|".$_POST['con_ede12']."|".$_POST['con_ede13']."|".$_POST['con_ede14']."|".$_POST['con_ede15'];


$con_la = $_POST['con_la0']."|".$_POST['con_la1']."|".$_POST['con_la2']."|".$_POST['con_la3']."|".$_POST['con_la4']."|".$_POST['con_la5']."|".$_POST['con_la6']."|".$_POST['con_la7']."|".$_POST['con_la8']."|".$_POST['con_la9']."|".$_POST['con_la10']."|".$_POST['con_la11']."|".$_POST['con_la12']."|".$_POST['con_la13']."|".$_POST['con_la14']."|".$_POST['con_la15'];

$con_pla = $_POST['con_pla0']."|".$_POST['con_pla1']."|".$_POST['con_pla2']."|".$_POST['con_pla3']."|".$_POST['con_pla4']."|".$_POST['con_pla5']."|".$_POST['con_pla6']."|".$_POST['con_pla7']."|".$_POST['con_pla8']."|".$_POST['con_pla9']."|".$_POST['con_pla10']."|".$_POST['con_pla11']."|".$_POST['con_pla12']."|".$_POST['con_pla13']."|".$_POST['con_pla14']."|".$_POST['con_pla15'];

$con_pre = $_POST['con_pre0']."|".$_POST['con_pre1']."|".$_POST['con_pre2']."|".$_POST['con_pre3']."|".$_POST['con_pre4']."|".$_POST['con_pre5']."|".$_POST['con_pre6']."|".$_POST['con_pre7']."|".$_POST['con_pre8']."|".$_POST['con_pre9']."|".$_POST['con_pre10']."|".$_POST['con_pre11']."|".$_POST['con_pre12']."|".$_POST['con_pre13']."|".$_POST['con_pre14']."|".$_POST['con_pre15'];

$con_fcf = $_POST['con_fcf0']."|".$_POST['con_fcf1']."|".$_POST['con_fcf2']."|".$_POST['con_fcf3']."|".$_POST['con_fcf4']."|".$_POST['con_fcf5']."|".$_POST['con_fcf6']."|".$_POST['con_fcf7']."|".$_POST['con_fcf8']."|".$_POST['con_fcf9']."|".$_POST['con_fcf10']."|".$_POST['con_fcf11']."|".$_POST['con_fcf12']."|".$_POST['con_fcf13']."|".$_POST['con_fcf14']."|".$_POST['con_fcf15'];

$con_pc = $_POST['con_pc0']."|".$_POST['con_pc1']."|".$_POST['con_pc2']."|".$_POST['con_pc3']."|".$_POST['con_pc4']."|".$_POST['con_pc5']."|".$_POST['con_pc6']."|".$_POST['con_pc7']."|".$_POST['con_pc8']."|".$_POST['con_pc9']."|".$_POST['con_pc10']."|".$_POST['con_pc11']."|".$_POST['con_pc12']."|".$_POST['con_pc13']."|".$_POST['con_pc14']."|".$_POST['con_pc15'];

$con_lcn = $_POST['con_lcn0']."|".$_POST['con_lcn1']."|".$_POST['con_lcn2']."|".$_POST['con_lcn3']."|".$_POST['con_lcn4']."|".$_POST['con_lcn5']."|".$_POST['con_lcn6']."|".$_POST['con_lcn7']."|".$_POST['con_lcn8']."|".$_POST['con_lcn9']."|".$_POST['con_lcn10']."|".$_POST['con_lcn11']."|".$_POST['con_lcn12']."|".$_POST['con_lcn13']."|".$_POST['con_lcn14']."|".$_POST['con_lcn15'];

$con_vv = $_POST['con_vv0']."|".$_POST['con_vv1']."|".$_POST['con_vv2']."|".$_POST['con_vv3']."|".$_POST['con_vv4']."|".$_POST['con_vv5']."|".$_POST['con_vv6']."|".$_POST['con_vv7']."|".$_POST['con_vv8']."|".$_POST['con_vv9']."|".$_POST['con_vv10']."|".$_POST['con_vv11']."|".$_POST['con_vv12']."|".$_POST['con_vv13']."|".$_POST['con_vv14']."|".$_POST['con_vv15'];

$con_eco = $_POST['con_eco0']."|".$_POST['con_eco1']."|".$_POST['con_eco2']."|".$_POST['con_eco3']."|".$_POST['con_eco4']."|".$_POST['con_eco5']."|".$_POST['con_eco6']."|".$_POST['con_eco7']."|".$_POST['con_eco8']."|".$_POST['con_eco9']."|".$_POST['con_eco10']."|".$_POST['con_eco11']."|".$_POST['con_eco12']."|".$_POST['con_eco13']."|".$_POST['con_eco14']."|".$_POST['con_eco15'];

$con_hb = $_POST['con_hb0']."|".$_POST['con_hb1']."|".$_POST['con_hb2']."|".$_POST['con_hb3']."|".$_POST['con_hb4']."|".$_POST['con_hb5']."|".$_POST['con_hb6']."|".$_POST['con_hb7']."|".$_POST['con_hb8']."|".$_POST['con_hb9']."|".$_POST['con_hb10']."|".$_POST['con_hb11']."|".$_POST['con_hb12']."|".$_POST['con_hb13']."|".$_POST['con_hb14']."|".$_POST['con_hb15'];

$con_gi = $_POST['con_gi0']."|".$_POST['con_gi1']."|".$_POST['con_gi2']."|".$_POST['con_gi3']."|".$_POST['con_gi4']."|".$_POST['con_gi5']."|".$_POST['con_gi6']."|".$_POST['con_gi7']."|".$_POST['con_gi8']."|".$_POST['con_gi9']."|".$_POST['con_gi10']."|".$_POST['con_gi11']."|".$_POST['con_gi12']."|".$_POST['con_gi13']."|".$_POST['con_gi14']."|".$_POST['con_gi15'];

$con_ori = $_POST['con_ori0']."|".$_POST['con_ori1']."|".$_POST['con_ori2']."|".$_POST['con_ori3']."|".$_POST['con_ori4']."|".$_POST['con_ori5']."|".$_POST['con_ori6']."|".$_POST['con_ori7']."|".$_POST['con_ori8']."|".$_POST['con_ori9']."|".$_POST['con_ori10']."|".$_POST['con_ori11']."|".$_POST['con_ori12']."|".$_POST['con_ori13']."|".$_POST['con_ori14']."|".$_POST['con_ori15'];

$con_obs = $_POST['con_obs0']."|".$_POST['con_obs1']."|".$_POST['con_obs2']."|".$_POST['con_obs3']."|".$_POST['con_obs4']."|".$_POST['con_obs5']."|".$_POST['con_obs6']."|".$_POST['con_obs7']."|".$_POST['con_obs8']."|".$_POST['con_obs9']."|".$_POST['con_obs10']."|".$_POST['con_obs11']."|".$_POST['con_obs12']."|".$_POST['con_obs13']."|".$_POST['con_obs14']."|".$_POST['con_obs15'];

updateObst($_POST['idx'],$_POST['dni'],$_POST['g_3par'],$_POST['g_rn_men'],$_POST['g_gem'],$_POST['g_ges'],$_POST['g_abo'],$_POST['g_pt'],$_POST['g_pp'],$_POST['g_vag'],$_POST['g_ces'],$_POST['g_nv'],$_POST['g_nm'],$_POST['g_viv'],$_POST['g_m1'],$_POST['g_m2'],$_POST['g_fup'],$_POST['g_rn_may'],$_POST['pes'],$_POST['tal'],$_POST['fur'],$_POST['fpp'],$_POST['dud'],$_POST['fuma'],$_POST['vdrl'],$_POST['vdrl_f'],$_POST['hb'],$_POST['hb_f'],$con_fec,$con_fec_h,$con_fec_m,$con_sem,$con_eg,$con_pes,$con_pa,$con_mov,$con_ede,$con_la,$con_pla,$con_pre,$con_fcf,$con_pc,$con_lcn,$con_vv,$con_eco,$con_hb,$con_gi,$con_ori,$con_obs,$_POST['parto_sex'],$_POST['parto_pes'],$_POST['parto_tal'],$_POST['parto_nom'],$_POST['parto_nac'],$_POST['parto_obs'],$_POST['in_t'],$_POST['in_f1'],$_POST['in_h1'],$_POST['in_m1'],$_POST['in_f2'],$_POST['in_h2'],$_POST['in_m2'],$_POST['in_c']);

}

if ($_GET['id'] <> "") {
	
$id = $_GET['id'];
$rObst = $db->prepare("SELECT * FROM hc_obste WHERE id=?");
$rObst->execute(array($id));
$obst = $rObst->fetch(PDO::FETCH_ASSOC);

$rPaci = $db->prepare("SELECT nom,ape,fnac FROM hc_paciente WHERE dni=?");
$rPaci->execute(array($obst['dni']));
$paci = $rPaci->fetch(PDO::FETCH_ASSOC);

 ?>

<style>
.ui-dialog-contain {
  	max-width: 1400px;
	margin: 1% auto 1%;
	padding: 0;
	position: relative;
	top: -35px;
}
#wrap{
  max-width:1200px;
  overflow:auto;
  overflow-y:hidden;
  white-space:nowrap; 
}
#wrap::-webkit-scrollbar {
    width: 12px;
}
#wrap::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(63,95,95,0.3);
    border-radius: 10px;
}
#wrap::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(63,95,95,0.5);
}
.ui-tabs-panel{
        background-color: #FFF;
		padding:5px;
}	
/* Hide the number input */
.ui-slider input[type=number] {
    display: none;
}
.pequeno .ui-input-text {
	width: 140px !important;
	
}
.pequeno2 .ui-input-text {
	width: 30px !important;
}
.pequeno2 span {
	float:left;	
}
.ui-slider-track {
    margin-left: 15px; 
}
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
	
	$(".mask_pa").mask("?999/999",{placeholder:"___/___"});
	
	$(".sem").change(function () {	
		var num = $(this).attr("title");
		var fec = new Date($(this).val());
		var fur = new Date($("#fur").val());
		
		var resta  = new Date(fec - fur)
		
		resta = Math.ceil(resta / 1000 / 60 / 60 / 24); // convert milliseconds to days. ceil to round up.

		$('#con_sem'+num).val(Math.floor(resta/7)+"sem "+resta%7+"dias");
		
	});

	$("#fur").on("change", function(){
       var date = new Date($(this).val());
      date.setDate(date.getDate() + 280); // + 280 dias 
      $("#fpp").val(date.toInputFormat());
       
    });
    
    //From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
    Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };
	
	$(".partox").hide();
	
	$("#in_t").change(function () {	
		if ($(this).val()=="Parto cesarea" || $(this).val()=="Parto vaginal")
		$(".partox").show();
		else
		$(".partox").hide();
		
	});
	
	$("#g_abo").keyup(function () {
		a = parseInt($("#g_abo").val()) + parseInt($('#g_pt').val()) + parseInt($('#g_pp').val()) + parseInt($('#g_nv').val()); 
		$("#g_ges").val(a); 
	});
	$("#g_pt").keyup(function () {
		a = parseInt($("#g_abo").val()) + parseInt($('#g_pt').val()) + parseInt($('#g_pp').val()) + parseInt($('#g_nv').val()); 
		$("#g_ges").val(a); 
	});
	$("#g_p").keyup(function () {
		a = parseInt($("#g_abo").val()) + parseInt($('#g_pt').val()) + parseInt($('#g_pp').val()) + parseInt($('#g_nv').val()); 
		$("#g_ges").val(a); 
	});
	$("#g_nv").keyup(function () {
		a = parseInt($("#g_abo").val()) + parseInt($('#g_pt').val()) + parseInt($('#g_pp').val()) + parseInt($('#g_nv').val()); 
		$("#g_ges").val(a); 
	});
});

</script>

<?php if ($obst['in_t']=="Parto cesarea" or $obst['in_t']=="Parto vaginal") { ?>
<script>
$(document).ready(function () {
	$(".partox").show();
});
</script>
<?php } ?>

<div data-role="header" data-position="fixed">
    <h2>Gestación #<small><?php echo $obst['g_ges']." ".$paci['ape']." ".$paci['nom']; if ($paci['fnac']<>"0000-00-00") echo '('.date_diff(date_create($paci['fnac']), date_create('today'))->y.')'; ?></small></h2>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="e_obst.php" method="post" data-ajax="false">
<input type="hidden" name="idx" value="<?php echo $obst['id'];?>">
<input type="hidden" name="dni" value="<?php echo $obst['dni'];?>">

<div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true">

<div data-role="collapsible"> <h3>Historia</h3>
<table width="100%" align="center" style="margin: 0 auto;">
		<tr>
		  <td width="12%" class="pequeno2"># Gestación
		    <input type="text" name="g_ges" id="g_ges" value="<?php echo $obst['g_ges']; ?>" data-mini="true" class="numeros"></td>
		  <td width="29%" class="pequeno2"><span>P.T
		      <input type="text" name="g_pt" id="g_pt" value="<?php echo $obst['g_pt']; ?>" data-mini="true" class="numeros">
		    </span><span>P.P
		    <input type="text" name="g_pp" id="g_pp" value="<?php echo $obst['g_pp']; ?>" data-mini="true" class="numeros">
		      </span><span>A
		        <input type="text" name="g_abo" id="g_abo" value="<?php echo $obst['g_abo']; ?>" data-mini="true" class="numeros">
		        </span><span>N.V
		          <input type="text" name="g_nv" id="g_nv" value="<?php echo $obst['g_nv']; ?>" data-mini="true" class="numeros">
		          </span></td>
		  <td width="19%" align="center" class="pequeno2"><span>P.V
		    <input type="text" name="g_vag" id="g_vag" value="<?php echo $obst['g_vag']; ?>" data-mini="true" class="numeros"></span><span>P.C		    
		    <input type="text" name="g_ces" id="g_ces" value="<?php echo $obst['g_ces']; ?>" data-mini="true" class="numeros"></span></td>
		  <td align="center" class="pequeno2"><span>Hijos Vivos
		    <input type="text" name="g_viv" id="g_viv" value="<?php echo $obst['g_viv']; ?>" data-mini="true" class="numeros"></span><span>N. Muertos<input type="text" name="g_nm" id="g_nm" value="<?php echo $obst['g_nm']; ?>" data-mini="true" class="numeros"></span></td>
		  <td width="12%"><label for="g_fup">Último parto</label>
		    <input type="month" name="g_fup" id="g_fup" value="<?php echo $obst['g_fup']; ?>" data-mini="true" ></td>
		  </tr>
		<tr>
		  <td class="pequeno"><label for="pes">Peso anterior</label>
		    <input name="pes" type="number" step="any" id="pes" value="<?php echo $obst['pes']; ?>" data-mini="true"></td>
		  <td><input type="checkbox" value=1 name="dud" id="dud" data-mini="true" <?php if ($obst['dud']==1) echo "checked"; ?>>
		    <label for="dud">Dudas</label></td>
		  <td width="19%" align="center" class="pequeno2">Muertos 1º sem
            <input name="g_m1" type="text" id="g_m1" value="<?php echo $obst['g_m1']; ?>" data-mini="true" class="numeros"></td>
		  <td width="28%" align="center" class="pequeno2">Despues 1º sem
            <input name="g_m2" type="text" id="g_m2" value="<?php echo $obst['g_m2']; ?>" data-mini="true" class="numeros"></td>
		  <td rowspan="2"><fieldset data-role="controlgroup" data-mini="true">
		    <input type="checkbox" value=1 name="g_3par" id="g_3par" data-mini="true" <?php if ($obst['g_3par']==1) echo "checked"; ?>>
		    <label for="g_3par">Ninguno o mas de 3 partos</label>
		    <input type="checkbox" value=1 name="g_rn_men" id="g_rn_men" data-mini="true" <?php if ($obst['g_rn_men']==1) echo "checked"; ?>>
		    <label for="g_rn_men">RN menor a 2500g</label>
		    <input type="checkbox" value=1 name="g_gem" id="g_gem" data-mini="true" <?php if ($obst['g_gem']==1) echo "checked"; ?>>
		    <label for="g_gem">Gemelares</label>
		    </fieldset></td>
		  </tr>
		<tr>
		  <td class="pequeno"><label for="tal">Talla (cms)</label>
		    <input name="tal" type="number" step="any" id="tal" value="<?php echo $obst['tal']; ?>" data-mini="true"></td>
		  <td><label for="fuma">Cigarros al día</label>
		    <input name="fuma" type="range" id="fuma" max="40" min="0" value="<?php echo $obst['fuma']; ?>" data-show-value="true" data-popup-enabled="true" data-highlight="true"></td>
		  <td colspan="2"><div data-role="controlgroup" data-type="horizontal" data-mini="true">
		    <select name="vdrl" id="vdrl">
		      <option value="">VDRL:</option>
		      <option value=1 <?php if ($obst['vdrl']==1) echo "selected"; ?>>VDRL: Positivo</option>
		      <option value=2 <?php if ($obst['vdrl']==2) echo "selected"; ?>>VDRL: Negativo</option>
		      </select>
		    <input name="vdrl_f" type="date" id="vdrl_f" value="<?php echo $obst['vdrl_f']; ?>" data-wrapper-class="controlgroup-textinput ui-btn" />
		    </div></td>
		  </tr>
		<tr>
		  <td>FUR 
			<input name="fur" type="date" id="fur" value="<?php echo $obst['fur']; ?>"></td>
		  <td>FPP <input name="fpp" type="date" id="fpp" readonly value="<?php echo $obst['fpp']; ?>"></td>
		  <td colspan="2"><div data-role="controlgroup" data-type="horizontal" data-mini="true">
		    <select name="hb" id="hb">
		      <option value="">Hb:</option>
		      <option value=7 <?php if ($obst['hb']==7) echo "selected"; ?>>Hb: 7</option>
		      <option value=8 <?php if ($obst['hb']==8) echo "selected"; ?>>Hb: 8</option>
		      <option value=9 <?php if ($obst['hb']==9) echo "selected"; ?>>Hb: 9</option>
		      <option value=10 <?php if ($obst['hb']==10) echo "selected"; ?>>Hb: 10</option>
		      <option value=11 <?php if ($obst['hb']==11) echo "selected"; ?>>Hb: 11</option>
		      <option value=12 <?php if ($obst['hb']==12) echo "selected"; ?>>Hb: 12</option>
		      <option value=13 <?php if ($obst['hb']==13) echo "selected"; ?>>Hb: 13</option>
		      <option value=14 <?php if ($obst['hb']==14) echo "selected"; ?>>Hb: 14</option>
		      </select>
		    <input name="hb_f" type="date" id="hb_f" value="<?php echo $obst['hb_f']; ?>" data-wrapper-class="controlgroup-textinput ui-btn" />
		    </div></td>
		  <td class="pequeno">RN con mayor peso(gr)
		    <input name="g_rn_may" id="g_rn_may" value="<?php echo $obst['g_rn_may']; ?>" size="6" maxlength="6" data-mini="true" class="numeros"></td>
		  </tr>
       
		</table>      
</div>  
 
<div data-role="collapsible" data-collapsed="false"> <h3>Consultas</h3>

   <?php   $con_fec = explode("|", $obst['con_fec']);
	    $con_fec_h = explode("|", $obst['con_fec_h']);
	    $con_fec_m = explode("|", $obst['con_fec_m']);
		$con_sem = explode("|", $obst['con_sem']);
		$con_eg  = explode("|", $obst['con_eg']);
		$con_pes = explode("|", $obst['con_pes']);
		$con_pa  = explode("|", $obst['con_pa']);
		$con_mov = explode("|", $obst['con_mov']);
		$con_ede = explode("|", $obst['con_ede']);
		$con_la  = explode("|", $obst['con_la']);
		$con_pla = explode("|", $obst['con_pla']);
		$con_pre = explode("|", $obst['con_pre']);
		$con_fcf = explode("|", $obst['con_fcf']);
		$con_pc  = explode("|", $obst['con_pc']);
		$con_lcn = explode("|", $obst['con_lcn']);
		$con_vv  = explode("|", $obst['con_vv']);
		$con_eco = explode("|", $obst['con_eco']);
		$con_hb  = explode("|", $obst['con_hb']);
		$con_gi  = explode("|", $obst['con_gi']);
		$con_ori = explode("|", $obst['con_ori']);
		$con_obs = explode("|", $obst['con_obs']);
		?>
<table cellspacing="0" cellpadding="0" style="width:120px;float:left;font-size: small;">
    <tr><td height="20"></td></tr>
    <tr><td height="40">FECHA</td></tr>
    <tr><td height="40">HORA</td></tr>
	<tr><td height="45">SEM. AME.</td></tr>
    <tr><td height="45">EG x ECO</td></tr>
	<tr><td height="45">PESO (Kg.)</td></tr>
    <tr><td height="45">P.A (max/min)</td></tr>
    <tr><td height="45">MOV. FETAL</td></tr>
    <tr><td height="45">EDEMA</td></tr>
    <tr><td height="45">L.A</td></tr>
	<tr><td height="45">PLACENTA</td></tr>
	<tr><td height="45">PRESENTACION</td></tr>
	<tr><td height="45">F.C.F (lat/min)</td></tr>
	<tr><td height="45">P.C</td></tr>
    <tr><td height="45">L.C.N</td></tr>
    <tr><td height="45">V.V</td></tr>
    <tr><td height="45">ECOGRAFIA</td></tr>
    <tr><td height="45">HB</td></tr>
    <tr><td height="45">GI</td></tr>
    <tr><td height="45">ORINA</td></tr>
    <tr><td height="45">OBSERVACION</td></tr>
  </table>
  <div id="wrap"> 
    <table id="data" cellspacing="0" cellpadding="0" align="center" style="margin: 0 auto;font-size: small;" class="pequeno">  
    	<colgroup>
        <col <?php if ($con_fec[0] <> "") echo 'style="background-color:#d7e5e5"'; ?>>    
        <col <?php if ($con_fec[1] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[2] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[3] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[4] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[5] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[6] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[7] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[8] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[9] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[10] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[11] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[12] <> "") echo 'style="background-color:#d7e5e5"'; ?>>
        <col <?php if ($con_fec[13] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[14] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        <col <?php if ($con_fec[15] <> "") echo 'style="background-color:#d7e5e5"'; ?>>  
        </colgroup>
    
        <tr>
          <td>1º Consulta</td>
          <td>2º Consulta</td>
          <td>3º Consulta</td>
          <td>4º Consulta</td>
          <td>5º Consulta</td>
          <td>6º Consulta</td>
          <td>7º Consulta</td>
          <td>8º Consulta</td>
          <td>9º Consulta</td>
          <td>10º Consulta</td>
          <td>11º Consulta</td>
          <td>12º Consulta</td>
          <td>13º Consulta</td>
          <td>14º Consulta</td>
          <td>15º Consulta</td>
          <td>16º Consulta</td>
          </tr>
        <tr>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec0" id="con_fec0" value="<?php echo $con_fec[0]; ?>" class="sem" title="0">
      <div data-role="controlgroup" data-type="horizontal" data-mini="true">
      <select name="con_fec_h0" id="con_fec_h0">
      <option value="">Hra</option>
      <option value="07" <?php if ($con_fec_h[0]=="07") echo "selected"; ?>>07h</option>
      <option value="08" <?php if ($con_fec_h[0]=="08") echo "selected"; ?>>08h</option>
      <option value="09" <?php if ($con_fec_h[0]=="09") echo "selected"; ?>>09h</option>
      <option value="10" <?php if ($con_fec_h[0]=="10") echo "selected"; ?>>10h</option>
      <option value="11" <?php if ($con_fec_h[0]=="11") echo "selected"; ?>>11h</option>
      <option value="12" <?php if ($con_fec_h[0]=="12") echo "selected"; ?>>12h</option>
      <option value="13" <?php if ($con_fec_h[0]=="13") echo "selected"; ?>>13h</option>
      <option value="14" <?php if ($con_fec_h[0]=="14") echo "selected"; ?>>14h</option>
      <option value="15" <?php if ($con_fec_h[0]=="15") echo "selected"; ?>>15h</option>
      <option value="16" <?php if ($con_fec_h[0]=="16") echo "selected"; ?>>16h</option>
      <option value="17" <?php if ($con_fec_h[0]=="17") echo "selected"; ?>>17h</option>
      <option value="18" <?php if ($con_fec_h[0]=="18") echo "selected"; ?>>18h</option>
      <option value="19" <?php if ($con_fec_h[0]=="19") echo "selected"; ?>>19h</option>
      <option value="20" <?php if ($con_fec_h[0]=="20") echo "selected"; ?>>20h</option>
      </select>
      <select name="con_fec_m0" id="con_fec_m0">
      <option value="">Min</option>
      <option value="00" <?php if ($con_fec_m[0]=="00") echo "selected"; ?>>00m</option>
      <option value="15" <?php if ($con_fec_m[0]=="15") echo "selected"; ?>>15m</option>
      <option value="30" <?php if ($con_fec_m[0]=="30") echo "selected"; ?>>30m</option>
      <option value="45" <?php if ($con_fec_m[0]=="45") echo "selected"; ?>>45m</option>
      </select>
    </div>
          </td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec1" id="con_fec1" value="<?php echo $con_fec[1]; ?>" class="sem" title="1">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h1" id="con_fec_h1">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[1]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[1]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[1]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[1]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[1]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[1]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[1]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[1]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[1]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[1]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[1]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[1]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[1]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[1]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m1" id="con_fec_m1">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[1]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[1]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[1]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[1]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec2" id="con_fec2" value="<?php echo $con_fec[2]; ?>" class="sem" title="2">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h2" id="con_fec_h2">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[2]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[2]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[2]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[2]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[2]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[2]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[2]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[2]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[2]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[2]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[2]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[2]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[2]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[2]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m2" id="con_fec_m2">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[2]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[2]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[2]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[2]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec3" id="con_fec3" value="<?php echo $con_fec[3]; ?>" class="sem" title="3">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h3" id="con_fec_h3">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[3]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[3]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[3]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[3]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[3]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[3]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[3]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[3]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[3]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[3]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[3]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[3]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[3]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[3]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m3" id="con_fec_m3">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[3]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[3]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[3]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[3]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec4" id="con_fec4" value="<?php echo $con_fec[4]; ?>" class="sem" title="4">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h4" id="con_fec_h4">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[4]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[4]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[4]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[4]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[4]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[4]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[4]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[4]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[4]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[4]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[4]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[4]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[4]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[4]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m4" id="con_fec_m4">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[4]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[4]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[4]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[4]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec5" id="con_fec5" value="<?php echo $con_fec[5]; ?>" class="sem" title="5">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h5" id="con_fec_h5">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[5]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[5]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[5]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[5]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[5]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[5]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[5]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[5]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[5]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[5]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[5]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[5]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[5]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[5]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m5" id="con_fec_m5">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[5]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[5]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[5]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[5]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec6" id="con_fec6" value="<?php echo $con_fec[6]; ?>" class="sem" title="6">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h6" id="con_fec_h6">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[6]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[6]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[6]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[6]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[6]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[6]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[6]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[6]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[6]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[6]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[6]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[6]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[6]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[6]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m6" id="con_fec_m6">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[6]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[6]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[6]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[6]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec7" id="con_fec7" value="<?php echo $con_fec[7]; ?>" class="sem" title="7">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h7" id="con_fec_h7">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[7]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[7]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[7]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[7]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[7]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[7]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[7]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[7]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[7]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[7]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[7]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[7]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[7]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[7]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m7" id="con_fec_m7">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[7]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[7]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[7]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[7]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec8" id="con_fec8" value="<?php echo $con_fec[8]; ?>" class="sem" title="8">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h8" id="con_fec_h8">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[8]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[8]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[8]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[8]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[8]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[8]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[8]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[8]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[8]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[8]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[8]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[8]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[8]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[8]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m8" id="con_fec_m8">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[8]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[8]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[8]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[8]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec9" id="con_fec9" value="<?php echo $con_fec[9]; ?>" class="sem" title="9">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h9" id="con_fec_h9">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[9]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[9]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[9]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[9]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[9]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[9]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[9]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[9]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[9]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[9]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[9]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[9]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[9]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[9]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m9" id="con_fec_m9">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[9]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[9]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[9]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[9]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec10" id="con_fec10" value="<?php echo $con_fec[10]; ?>" class="sem" title="10">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h10" id="con_fec_h10">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[10]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[10]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[10]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[10]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[10]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[10]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[10]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[10]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[10]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[10]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[10]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[10]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[10]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[10]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m10" id="con_fec_m10">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[10]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[10]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[10]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[10]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec11" id="con_fec11" value="<?php echo $con_fec[11]; ?>" class="sem" title="11">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h11" id="con_fec_h11">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[11]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[11]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[11]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[11]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[11]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[11]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[11]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[11]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[11]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[11]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[11]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[11]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[11]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[11]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m11" id="con_fec_m11">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[11]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[11]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[11]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[11]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec12" id="con_fec12" value="<?php echo $con_fec[12]; ?>" class="sem" title="12">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h12" id="con_fec_h12">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[12]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[12]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[12]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[12]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[12]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[12]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[12]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[12]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[12]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[12]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[12]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[12]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[12]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[12]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m12" id="con_fec_m12">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[12]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[12]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[12]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[12]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec13" id="con_fec13" value="<?php echo $con_fec[13]; ?>" class="sem" title="13">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h13" id="con_fec_h13">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[13]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[13]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[13]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[13]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[13]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[13]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[13]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[13]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[13]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[13]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[13]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[13]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[13]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[13]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m13" id="con_fec_m13">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[13]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[13]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[13]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[13]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec14" id="con_fec14" value="<?php echo $con_fec[14]; ?>" class="sem" title="14">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h14" id="con_fec_h14">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[14]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[14]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[14]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[14]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[14]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[14]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[14]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[14]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[14]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[14]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[14]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[14]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[14]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[14]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m14" id="con_fec_m14">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[14]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[14]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[14]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[14]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  <td width="7%"><input type="date" data-mini="true" name="con_fec15" id="con_fec15" value="<?php echo $con_fec[15]; ?>" class="sem" title="15">
		    <div data-role="controlgroup" data-type="horizontal" data-mini="true">
		      <select name="con_fec_h15" id="con_fec_h15">
		        <option value="">Hra</option>
		        <option value="07" <?php if ($con_fec_h[15]=="07") echo "selected"; ?>>07h</option>
		        <option value="08" <?php if ($con_fec_h[15]=="08") echo "selected"; ?>>08h</option>
		        <option value="09" <?php if ($con_fec_h[15]=="09") echo "selected"; ?>>09h</option>
		        <option value="10" <?php if ($con_fec_h[15]=="10") echo "selected"; ?>>10h</option>
		        <option value="11" <?php if ($con_fec_h[15]=="11") echo "selected"; ?>>11h</option>
		        <option value="12" <?php if ($con_fec_h[15]=="12") echo "selected"; ?>>12h</option>
		        <option value="13" <?php if ($con_fec_h[15]=="13") echo "selected"; ?>>13h</option>
		        <option value="14" <?php if ($con_fec_h[15]=="14") echo "selected"; ?>>14h</option>
		        <option value="15" <?php if ($con_fec_h[15]=="15") echo "selected"; ?>>15h</option>
		        <option value="16" <?php if ($con_fec_h[15]=="16") echo "selected"; ?>>16h</option>
		        <option value="17" <?php if ($con_fec_h[15]=="17") echo "selected"; ?>>17h</option>
		        <option value="18" <?php if ($con_fec_h[15]=="18") echo "selected"; ?>>18h</option>
		        <option value="19" <?php if ($con_fec_h[15]=="19") echo "selected"; ?>>19h</option>
		        <option value="20" <?php if ($con_fec_h[15]=="20") echo "selected"; ?>>20h</option>
		        </select>
		      <select name="con_fec_m15" id="con_fec_m15">
		        <option value="">Min</option>
		        <option value="00" <?php if ($con_fec_m[15]=="00") echo "selected"; ?>>00m</option>
		        <option value="15" <?php if ($con_fec_m[15]=="15") echo "selected"; ?>>15m</option>
		        <option value="30" <?php if ($con_fec_m[15]=="30") echo "selected"; ?>>30m</option>
		        <option value="45" <?php if ($con_fec_m[15]=="45") echo "selected"; ?>>45m</option>
		        </select>
		      </div></td>
		  </tr>
		<tr>
		  <td><input type="text" name="con_sem0" id="con_sem0" value="<?php echo $con_sem[0]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem1" id="con_sem1" value="<?php echo $con_sem[1]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem2" id="con_sem2" value="<?php echo $con_sem[2]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem3" id="con_sem3" value="<?php echo $con_sem[3]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem4" id="con_sem4" value="<?php echo $con_sem[4]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem5" id="con_sem5" value="<?php echo $con_sem[5]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem6" id="con_sem6" value="<?php echo $con_sem[6]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem7" id="con_sem7" value="<?php echo $con_sem[7]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem8" id="con_sem8" value="<?php echo $con_sem[8]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem9" id="con_sem9" value="<?php echo $con_sem[9]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem10" id="con_sem10" value="<?php echo $con_sem[10]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem11" id="con_sem11" value="<?php echo $con_sem[11]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem12" id="con_sem12" value="<?php echo $con_sem[12]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem13" id="con_sem13" value="<?php echo $con_sem[13]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem14" id="con_sem14" value="<?php echo $con_sem[14]; ?>" readonly data-mini="true"></td>
		  <td><input type="text" name="con_sem15" id="con_sem15" value="<?php echo $con_sem[15]; ?>" readonly data-mini="true"></td>
		  </tr>
          <tr>
            <td><input type="text" name="con_eg0" id="con_eg0" value="<?php echo $con_eg[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg1" id="con_eg1" value="<?php echo $con_eg[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg2" id="con_eg2" value="<?php echo $con_eg[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg3" id="con_eg3" value="<?php echo $con_eg[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg4" id="con_eg4" value="<?php echo $con_eg[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg5" id="con_eg5" value="<?php echo $con_eg[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg6" id="con_eg6" value="<?php echo $con_eg[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg7" id="con_eg7" value="<?php echo $con_eg[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg8" id="con_eg8" value="<?php echo $con_eg[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg9" id="con_eg9" value="<?php echo $con_eg[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg10" id="con_eg10" value="<?php echo $con_eg[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg11" id="con_eg11" value="<?php echo $con_eg[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg12" id="con_eg12" value="<?php echo $con_eg[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg13" id="con_eg13" value="<?php echo $con_eg[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg14" id="con_eg14" value="<?php echo $con_eg[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eg15" id="con_eg15" value="<?php echo $con_eg[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="number" step="any" name="con_pes0" id="con_pes0" value="<?php echo $con_pes[0]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes1" id="con_pes1" value="<?php echo $con_pes[1]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes2" id="con_pes2" value="<?php echo $con_pes[2]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes3" id="con_pes3" value="<?php echo $con_pes[3]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes4" id="con_pes4" value="<?php echo $con_pes[4]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes5" id="con_pes5" value="<?php echo $con_pes[5]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes6" id="con_pes6" value="<?php echo $con_pes[6]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes7" id="con_pes7" value="<?php echo $con_pes[7]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes8" id="con_pes8" value="<?php echo $con_pes[8]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes9" id="con_pes9" value="<?php echo $con_pes[9]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes10" id="con_pes10" value="<?php echo $con_pes[10]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes11" id="con_pes11" value="<?php echo $con_pes[11]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes12" id="con_pes12" value="<?php echo $con_pes[12]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes13" id="con_pes13" value="<?php echo $con_pes[13]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes14" id="con_pes14" value="<?php echo $con_pes[14]; ?>" data-mini="true"></td>
            <td><input type="number" step="any" name="con_pes15" id="con_pes15" value="<?php echo $con_pes[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_pa0" id="con_pa0" value="<?php echo $con_pa[0]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa1" id="con_pa1" value="<?php echo $con_pa[1]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa2" id="con_pa2" value="<?php echo $con_pa[2]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa3" id="con_pa3" value="<?php echo $con_pa[3]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa4" id="con_pa4" value="<?php echo $con_pa[4]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa5" id="con_pa5" value="<?php echo $con_pa[5]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa6" id="con_pa6" value="<?php echo $con_pa[6]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa7" id="con_pa7" value="<?php echo $con_pa[7]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa8" id="con_pa8" value="<?php echo $con_pa[8]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa9" id="con_pa9" value="<?php echo $con_pa[9]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa10" id="con_pa10" value="<?php echo $con_pa[10]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa11" id="con_pa11" value="<?php echo $con_pa[11]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa12" id="con_pa12" value="<?php echo $con_pa[12]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa13" id="con_pa13" value="<?php echo $con_pa[13]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa14" id="con_pa14" value="<?php echo $con_pa[14]; ?>" data-mini="true" class="mask_pa"></td>
            <td><input type="text" name="con_pa15" id="con_pa15" value="<?php echo $con_pa[15]; ?>" data-mini="true" class="mask_pa"></td>
            </tr>
          <tr>
            <td><select name="con_mov0" id="con_mov0" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[0]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[0]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[0]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov1" id="con_mov1" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[1]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[1]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[1]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov2" id="con_mov2" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[2]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[2]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[2]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov3" id="con_mov3" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[3]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[3]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[3]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov4" id="con_mov4" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[4]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[4]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[4]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov5" id="con_mov5" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[5]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[5]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[5]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov6" id="con_mov6" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[6]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[6]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[6]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov7" id="con_mov7" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[7]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[7]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[7]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov8" id="con_mov8" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[8]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[8]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[8]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov9" id="con_mov9" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[9]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[9]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[9]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov10" id="con_mov10" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[10]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[10]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[10]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov11" id="con_mov11" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[11]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[11]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[11]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov12" id="con_mov12" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[12]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[12]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[12]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov13" id="con_mov13" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[13]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[13]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[13]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov14" id="con_mov14" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[14]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[14]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[14]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            <td><select name="con_mov15" id="con_mov15" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_mov[15]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_mov[15]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_mov[15]=="+++") echo "selected"; ?>>+++</option>
            </select></td>
            </tr>
          <tr>
            <td><select name="con_ede0" id="con_ede0" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[0]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[0]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[0]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[0]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede1" id="con_ede1" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[1]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[1]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[1]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[1]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede2" id="con_ede2" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[2]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[2]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[2]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[2]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede3" id="con_ede3" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[3]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[3]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[3]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[3]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede4" id="con_ede4" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[4]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[4]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[4]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[4]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede5" id="con_ede5" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[5]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[5]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[5]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[5]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede6" id="con_ede6" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[6]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[6]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[6]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[6]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede7" id="con_ede7" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[7]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[7]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[7]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[7]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede8" id="con_ede8" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[8]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[8]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[8]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[8]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede9" id="con_ede9" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[9]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[9]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[9]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[9]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede10" id="con_ede10" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[10]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[10]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[10]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[10]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede11" id="con_ede11" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[11]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[11]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[11]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[11]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede12" id="con_ede12" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[12]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[12]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[12]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[12]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede13" id="con_ede13" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[13]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[13]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[13]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[13]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede14" id="con_ede14" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[14]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[14]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[14]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[14]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            <td><select name="con_ede15" id="con_ede15" data-mini="true">
              <option value=""></option>
              <option value="+" <?php if ($con_ede[15]=="+") echo "selected"; ?>>+</option>
              <option value="++" <?php if ($con_ede[15]=="++") echo "selected"; ?>>++</option>
              <option value="+++" <?php if ($con_ede[15]=="+++") echo "selected"; ?>>+++</option>
              <option value="SE" <?php if ($con_ede[15]=="SE") echo "selected"; ?>>SE</option>
            </select></td>
            </tr>
          <tr>
            <td><input type="text" name="con_la0" id="con_la0" value="<?php echo $con_la[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la1" id="con_la1" value="<?php echo $con_la[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la2" id="con_la2" value="<?php echo $con_la[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la3" id="con_la3" value="<?php echo $con_la[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la4" id="con_la4" value="<?php echo $con_la[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la5" id="con_la5" value="<?php echo $con_la[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la6" id="con_la6" value="<?php echo $con_la[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la7" id="con_la7" value="<?php echo $con_la[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la8" id="con_la8" value="<?php echo $con_la[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la9" id="con_la9" value="<?php echo $con_la[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la10" id="con_la10" value="<?php echo $con_la[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la11" id="con_la11" value="<?php echo $con_la[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la12" id="con_la12" value="<?php echo $con_la[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la13" id="con_la13" value="<?php echo $con_la[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la14" id="con_la14" value="<?php echo $con_la[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_la15" id="con_la15" value="<?php echo $con_la[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><select name="con_pla0" id="con_pla0" data-mini="true">
		      <option value=""></option>
		      <option value="I/III" <?php if ($con_pla[0]=="I/III") echo "selected"; ?>>I/III</option>
		      <option value="II/III" <?php if ($con_pla[0]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[0]=="III/III") echo "selected"; ?>>III/III</option>
		      </select>
            </td>
            <td><select name="con_pla1" id="con_pla1" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[1]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[1]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[1]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla2" id="con_pla2" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[2]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[2]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[2]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla3" id="con_pla3" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[3]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[3]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[3]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla4" id="con_pla4" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[4]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[4]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[4]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla5" id="con_pla5" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[5]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[5]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[5]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla6" id="con_pla6" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[6]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[6]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[6]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla7" id="con_pla7" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[7]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[7]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[7]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla8" id="con_pla8" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[8]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[8]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[8]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla9" id="con_pla9" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[9]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[9]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[9]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla10" id="con_pla10" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[10]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[10]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[10]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla11" id="con_pla11" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[11]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[11]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[11]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla12" id="con_pla12" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[12]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[12]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[12]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla13" id="con_pla13" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[13]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[13]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[13]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla14" id="con_pla14" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[14]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[14]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[14]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            <td><select name="con_pla15" id="con_pla15" data-mini="true">
              <option value=""></option>
              <option value="I/III" <?php if ($con_pla[15]=="I/III") echo "selected"; ?>>I/III</option>
              <option value="II/III" <?php if ($con_pla[15]=="II/III") echo "selected"; ?>>II/III</option>
              <option value="III/III" <?php if ($con_pla[15]=="III/III") echo "selected"; ?>>III/III</option>
            </select></td>
            </tr>
          <tr>
            <td><select name="con_pre0" id="con_pre0" data-mini="true">
		      <option value=""></option>
		      <option value="C" <?php if ($con_pre[0]=="C") echo "selected"; ?>>C</option>
		      <option value="O" <?php if ($con_pre[0]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[0]=="P") echo "selected"; ?>>P</option>
		      <option value="T" <?php if ($con_pre[0]=="T") echo "selected"; ?>>T</option>
		      </select>
            </td>
            <td><select name="con_pre1" id="con_pre1" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[1]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[1]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[1]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[1]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre2" id="con_pre2" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[2]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[2]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[2]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[2]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre3" id="con_pre3" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[3]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[3]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[3]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[3]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre4" id="con_pre4" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[4]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[4]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[4]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[4]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre5" id="con_pre5" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[5]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[5]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[5]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[5]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre6" id="con_pre6" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[6]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[6]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[6]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[6]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre7" id="con_pre7" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[7]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[7]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[7]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[7]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre8" id="con_pre8" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[8]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[8]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[8]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[8]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre9" id="con_pre9" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[9]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[9]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[9]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[9]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre10" id="con_pre10" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[10]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[10]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[10]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[10]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre11" id="con_pre11" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[11]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[11]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[11]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[11]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre12" id="con_pre12" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[12]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[12]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[12]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[12]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre13" id="con_pre13" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[13]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[13]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[13]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[13]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre14" id="con_pre14" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[14]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[14]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[14]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[14]=="T") echo "selected"; ?>>T</option>
            </select></td>
            <td><select name="con_pre15" id="con_pre15" data-mini="true">
              <option value=""></option>
              <option value="C" <?php if ($con_pre[15]=="C") echo "selected"; ?>>C</option>
              <option value="O" <?php if ($con_pre[15]=="O") echo "selected"; ?>>O</option>
              <option value="P" <?php if ($con_pre[15]=="P") echo "selected"; ?>>P</option>
              <option value="T" <?php if ($con_pre[15]=="T") echo "selected"; ?>>T</option>
            </select></td>
            </tr>
          <tr>
            <td><input type="text" name="con_fcf0" id="con_fcf0" value="<?php echo $con_fcf[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf1" id="con_fcf1" value="<?php echo $con_fcf[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf2" id="con_fcf2" value="<?php echo $con_fcf[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf3" id="con_fcf3" value="<?php echo $con_fcf[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf4" id="con_fcf4" value="<?php echo $con_fcf[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf5" id="con_fcf5" value="<?php echo $con_fcf[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf6" id="con_fcf6" value="<?php echo $con_fcf[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf7" id="con_fcf7" value="<?php echo $con_fcf[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf8" id="con_fcf8" value="<?php echo $con_fcf[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf9" id="con_fcf9" value="<?php echo $con_fcf[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf10" id="con_fcf10" value="<?php echo $con_fcf[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf11" id="con_fcf11" value="<?php echo $con_fcf[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf12" id="con_fcf12" value="<?php echo $con_fcf[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf13" id="con_fcf13" value="<?php echo $con_fcf[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf14" id="con_fcf14" value="<?php echo $con_fcf[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_fcf15" id="con_fcf15" value="<?php echo $con_fcf[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_pc0" id="con_pc0" value="<?php echo $con_pc[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc1" id="con_pc1" value="<?php echo $con_pc[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc2" id="con_pc2" value="<?php echo $con_pc[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc3" id="con_pc3" value="<?php echo $con_pc[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc4" id="con_pc4" value="<?php echo $con_pc[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc5" id="con_pc5" value="<?php echo $con_pc[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc6" id="con_pc6" value="<?php echo $con_pc[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc7" id="con_pc7" value="<?php echo $con_pc[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc8" id="con_pc8" value="<?php echo $con_pc[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc9" id="con_pc9" value="<?php echo $con_pc[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc10" id="con_pc10" value="<?php echo $con_pc[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc11" id="con_pc11" value="<?php echo $con_pc[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc12" id="con_pc12" value="<?php echo $con_pc[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc13" id="con_pc13" value="<?php echo $con_pc[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc14" id="con_pc14" value="<?php echo $con_pc[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_pc15" id="con_pc15" value="<?php echo $con_pc[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_lcn0" id="con_lcn0" value="<?php echo $con_lcn[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn1" id="con_lcn1" value="<?php echo $con_lcn[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn2" id="con_lcn2" value="<?php echo $con_lcn[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn3" id="con_lcn3" value="<?php echo $con_lcn[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn4" id="con_lcn4" value="<?php echo $con_lcn[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn5" id="con_lcn5" value="<?php echo $con_lcn[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn6" id="con_lcn6" value="<?php echo $con_lcn[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn7" id="con_lcn7" value="<?php echo $con_lcn[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn8" id="con_lcn8" value="<?php echo $con_lcn[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn9" id="con_lcn9" value="<?php echo $con_lcn[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn10" id="con_lcn10" value="<?php echo $con_lcn[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn11" id="con_lcn11" value="<?php echo $con_lcn[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn12" id="con_lcn12" value="<?php echo $con_lcn[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn13" id="con_lcn13" value="<?php echo $con_lcn[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn14" id="con_lcn14" value="<?php echo $con_lcn[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_lcn15" id="con_lcn15" value="<?php echo $con_lcn[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_vv0" id="con_vv0" value="<?php echo $con_vv[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv1" id="con_vv1" value="<?php echo $con_vv[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv2" id="con_vv2" value="<?php echo $con_vv[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv3" id="con_vv3" value="<?php echo $con_vv[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv4" id="con_vv4" value="<?php echo $con_vv[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv5" id="con_vv5" value="<?php echo $con_vv[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv6" id="con_vv6" value="<?php echo $con_vv[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv7" id="con_vv7" value="<?php echo $con_vv[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv8" id="con_vv8" value="<?php echo $con_vv[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv9" id="con_vv9" value="<?php echo $con_vv[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv10" id="con_vv10" value="<?php echo $con_vv[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv11" id="con_vv11" value="<?php echo $con_vv[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv12" id="con_vv12" value="<?php echo $con_vv[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv13" id="con_vv13" value="<?php echo $con_vv[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv14" id="con_vv14" value="<?php echo $con_vv[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_vv15" id="con_vv15" value="<?php echo $con_vv[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_eco0" id="con_eco0" value="<?php echo $con_eco[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco1" id="con_eco1" value="<?php echo $con_eco[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco2" id="con_eco2" value="<?php echo $con_eco[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco3" id="con_eco3" value="<?php echo $con_eco[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco4" id="con_eco4" value="<?php echo $con_eco[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco5" id="con_eco5" value="<?php echo $con_eco[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco6" id="con_eco6" value="<?php echo $con_eco[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco7" id="con_eco7" value="<?php echo $con_eco[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco8" id="con_eco8" value="<?php echo $con_eco[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco9" id="con_eco9" value="<?php echo $con_eco[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco10" id="con_eco10" value="<?php echo $con_eco[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco11" id="con_eco11" value="<?php echo $con_eco[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco12" id="con_eco12" value="<?php echo $con_eco[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco13" id="con_eco13" value="<?php echo $con_eco[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco14" id="con_eco14" value="<?php echo $con_eco[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_eco15" id="con_eco15" value="<?php echo $con_eco[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_hb0" id="con_hb0" value="<?php echo $con_hb[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb1" id="con_hb1" value="<?php echo $con_hb[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb2" id="con_hb2" value="<?php echo $con_hb[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb3" id="con_hb3" value="<?php echo $con_hb[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb4" id="con_hb4" value="<?php echo $con_hb[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb5" id="con_hb5" value="<?php echo $con_hb[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb6" id="con_hb6" value="<?php echo $con_hb[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb7" id="con_hb7" value="<?php echo $con_hb[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb8" id="con_hb8" value="<?php echo $con_hb[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb9" id="con_hb9" value="<?php echo $con_hb[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb10" id="con_hb10" value="<?php echo $con_hb[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb11" id="con_hb11" value="<?php echo $con_hb[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb12" id="con_hb12" value="<?php echo $con_hb[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb13" id="con_hb13" value="<?php echo $con_hb[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb14" id="con_hb14" value="<?php echo $con_hb[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_hb15" id="con_hb15" value="<?php echo $con_hb[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><input type="text" name="con_gi0" id="con_gi0" value="<?php echo $con_gi[0]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi1" id="con_gi1" value="<?php echo $con_gi[1]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi2" id="con_gi2" value="<?php echo $con_gi[2]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi3" id="con_gi3" value="<?php echo $con_gi[3]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi4" id="con_gi4" value="<?php echo $con_gi[4]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi5" id="con_gi5" value="<?php echo $con_gi[5]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi6" id="con_gi6" value="<?php echo $con_gi[6]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi7" id="con_gi7" value="<?php echo $con_gi[7]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi8" id="con_gi8" value="<?php echo $con_gi[8]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi9" id="con_gi9" value="<?php echo $con_gi[9]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi10" id="con_gi10" value="<?php echo $con_gi[10]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi11" id="con_gi11" value="<?php echo $con_gi[11]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi12" id="con_gi12" value="<?php echo $con_gi[12]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi13" id="con_gi13" value="<?php echo $con_gi[13]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi14" id="con_gi14" value="<?php echo $con_gi[14]; ?>" data-mini="true"></td>
            <td><input type="text" name="con_gi15" id="con_gi15" value="<?php echo $con_gi[15]; ?>" data-mini="true"></td>
            </tr>
          <tr>
            <td><select name="con_ori0" id="con_ori0" data-mini="true">
		      <option value=""></option>
		      <option value="P" <?php if ($con_ori[0]=="P") echo "selected"; ?>>P</option>
		      <option value="N" <?php if ($con_ori[0]=="N") echo "selected"; ?>>N</option>
		      </select>
            </td>
            <td><select name="con_ori1" id="con_ori1" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[1]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[1]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori2" id="con_ori2" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[2]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[2]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori3" id="con_ori3" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[3]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[3]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori4" id="con_ori4" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[4]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[4]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori5" id="con_ori5" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[5]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[5]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori6" id="con_ori6" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[6]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[6]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori7" id="con_ori7" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[7]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[7]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori8" id="con_ori8" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[8]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[8]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori9" id="con_ori9" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[9]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[9]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori10" id="con_ori10" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[10]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[10]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori11" id="con_ori11" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[11]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[11]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori12" id="con_ori12" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[12]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[12]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori13" id="con_ori13" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[13]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[13]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori14" id="con_ori14" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[14]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[14]=="N") echo "selected"; ?>>N</option>
            </select></td>
            <td><select name="con_ori15" id="con_ori15" data-mini="true">
              <option value=""></option>
              <option value="P" <?php if ($con_ori[15]=="P") echo "selected"; ?>>P</option>
              <option value="N" <?php if ($con_ori[15]=="N") echo "selected"; ?>>N</option>
            </select></td>
            </tr>
          <tr>
            <td><textarea name="con_obs0" id="con_obs0" data-mini="true"><?php echo $con_obs[0];?></textarea></td>
            <td><textarea name="con_obs1" id="con_obs1" data-mini="true"><?php echo $con_obs[1];?></textarea></td>
            <td><textarea name="con_obs2" id="con_obs2" data-mini="true"><?php echo $con_obs[2];?></textarea></td>
            <td><textarea name="con_obs3" id="con_obs3" data-mini="true"><?php echo $con_obs[3];?></textarea></td>
            <td><textarea name="con_obs4" id="con_obs4" data-mini="true"><?php echo $con_obs[4];?></textarea></td>
            <td><textarea name="con_obs5" id="con_obs5" data-mini="true"><?php echo $con_obs[5];?></textarea></td>
            <td><textarea name="con_obs6" id="con_obs6" data-mini="true"><?php echo $con_obs[6];?></textarea></td>
            <td><textarea name="con_obs7" id="con_obs7" data-mini="true"><?php echo $con_obs[7];?></textarea></td>
            <td><textarea name="con_obs8" id="con_obs8" data-mini="true"><?php echo $con_obs[8];?></textarea></td>
            <td><textarea name="con_obs9" id="con_obs9" data-mini="true"><?php echo $con_obs[9];?></textarea></td>
            <td><textarea name="con_obs10" id="con_obs10" data-mini="true"><?php echo $con_obs[10];?></textarea></td>
            <td><textarea name="con_obs11" id="con_obs11" data-mini="true"><?php echo $con_obs[11];?></textarea></td>
            <td><textarea name="con_obs12" id="con_obs12" data-mini="true"><?php echo $con_obs[12];?></textarea></td>
            <td><textarea name="con_obs13" id="con_obs13" data-mini="true"><?php echo $con_obs[13];?></textarea></td>
            <td><textarea name="con_obs14" id="con_obs14" data-mini="true"><?php echo $con_obs[14];?></textarea></td>
            <td><textarea name="con_obs15" id="con_obs15" data-mini="true"><?php echo $con_obs[15];?></textarea></td>
            </tr>
    </table>
  </div>
 
 </div>
 <div data-role="collapsible"> <h3>Orden de Internamiento</h3>

  <table width="100%" align="center" style="margin: 0 auto;">
		<tr>
		  <td width="4%">Tipo:</td>
		  <td width="19%"><select name="in_t" id="in_t" data-mini="true">
		    <option value="">---</option>
		    <option value="Parto cesarea" <?php if ($obst['in_t']=="Parto cesarea") echo "selected"; ?>>Parto cesarea</option>
		    <option value="Parto vaginal" <?php if ($obst['in_t']=="Parto vaginal") echo "selected"; ?>>Parto vaginal</option>
		    <option value="Legrado uterino" <?php if ($obst['in_t']=="Legrado uterino") echo "selected"; ?>>Legrado uterino</option>
            <option value="Cerclaje cervical" <?php if ($obst['in_t']=="Cerclaje cervical") echo "selected"; ?>>Cerclaje cervical</option>
		    </select></td>
		  <td width="17%">Fecha/Hora de Internamiento</td>
		  <td width="60%"><div data-role="controlgroup" data-type="horizontal" data-mini="true">
		    <input type="date" name="in_f1" id="in_f1" value="<?php echo $obst['in_f1'];?>" data-mini="true" data-wrapper-class="controlgroup-textinput ui-btn">
		    <select name="in_h1" id="in_h1">
		      <option value="">Hra</option>
		      <option value="07" <?php if ($obst['in_h1']=="07") echo "selected"; ?>>07 hrs</option>
		      <option value="08" <?php if ($obst['in_h1']=="08") echo "selected"; ?>>08 hrs</option>
		      <option value="09" <?php if ($obst['in_h1']=="09") echo "selected"; ?>>09 hrs</option>
		      <option value="10" <?php if ($obst['in_h1']=="10") echo "selected"; ?>>10 hrs</option>
		      <option value="11" <?php if ($obst['in_h1']=="11") echo "selected"; ?>>11 hrs</option>
		      <option value="12" <?php if ($obst['in_h1']=="12") echo "selected"; ?>>12 hrs</option>
		      <option value="13" <?php if ($obst['in_h1']=="13") echo "selected"; ?>>13 hrs</option>
		      <option value="14" <?php if ($obst['in_h1']=="14") echo "selected"; ?>>14 hrs</option>
		      <option value="15" <?php if ($obst['in_h1']=="15") echo "selected"; ?>>15 hrs</option>
		      <option value="16" <?php if ($obst['in_h1']=="16") echo "selected"; ?>>16 hrs</option>
		      <option value="17" <?php if ($obst['in_h1']=="17") echo "selected"; ?>>17 hrs</option>
		      <option value="18" <?php if ($obst['in_h1']=="18") echo "selected"; ?>>18 hrs</option>
		      <option value="19" <?php if ($obst['in_h1']=="19") echo "selected"; ?>>19 hrs</option>
		      <option value="20" <?php if ($obst['in_h1']=="20") echo "selected"; ?>>20 hrs</option>
		      </select>
		    <select name="in_m1" id="in_m1">
		      <option value="">Min</option>
		      <option value="00" <?php if ($obst['in_m1']=="00") echo "selected"; ?>>00 min</option>
		      <option value="15" <?php if ($obst['in_m1']=="15") echo "selected"; ?>>15 min</option>
		      <option value="30" <?php if ($obst['in_m1']=="30") echo "selected"; ?>>30 min</option>
		      <option value="45" <?php if ($obst['in_m1']=="45") echo "selected"; ?>>45 min</option>
		      </select>
		    </div></td>
		  </tr>
		<tr>
		  <td>Clinica:</td>
		  <td><input name="in_c" type="text" id="in_c" data-mini="true" value="<?php echo $obst['in_c']; ?>"/></td>
		  <td>Fecha/Hora de Intervención</td>
		  <td><div data-role="controlgroup" data-type="horizontal" data-mini="true">
		    <input type="date" name="in_f2" id="in_f2" value="<?php echo $obst['in_f2'];?>" data-mini="true" data-wrapper-class="controlgroup-textinput ui-btn">
		    <select name="in_h2" id="in_h2">
		      <option value="">Hra</option>
		      <option value="07" <?php if ($obst['in_h2']=="07") echo "selected"; ?>>07 hrs</option>
		      <option value="08" <?php if ($obst['in_h2']=="08") echo "selected"; ?>>08 hrs</option>
		      <option value="09" <?php if ($obst['in_h2']=="09") echo "selected"; ?>>09 hrs</option>
		      <option value="10" <?php if ($obst['in_h2']=="10") echo "selected"; ?>>10 hrs</option>
		      <option value="11" <?php if ($obst['in_h2']=="11") echo "selected"; ?>>11 hrs</option>
		      <option value="12" <?php if ($obst['in_h2']=="12") echo "selected"; ?>>12 hrs</option>
		      <option value="13" <?php if ($obst['in_h2']=="13") echo "selected"; ?>>13 hrs</option>
		      <option value="14" <?php if ($obst['in_h2']=="14") echo "selected"; ?>>14 hrs</option>
		      <option value="15" <?php if ($obst['in_h2']=="15") echo "selected"; ?>>15 hrs</option>
		      <option value="16" <?php if ($obst['in_h2']=="16") echo "selected"; ?>>16 hrs</option>
		      <option value="17" <?php if ($obst['in_h2']=="17") echo "selected"; ?>>17 hrs</option>
		      <option value="18" <?php if ($obst['in_h2']=="18") echo "selected"; ?>>18 hrs</option>
		      <option value="19" <?php if ($obst['in_h2']=="19") echo "selected"; ?>>19 hrs</option>
		      <option value="20" <?php if ($obst['in_h2']=="20") echo "selected"; ?>>20 hrs</option>
		      </select>
		    <select name="in_m2" id="in_m2">
		      <option value="">Min</option>
		      <option value="00" <?php if ($obst['in_m2']=="00") echo "selected"; ?>>00 min</option>
		      <option value="15" <?php if ($obst['in_m2']=="15") echo "selected"; ?>>15 min</option>
		      <option value="30" <?php if ($obst['in_m2']=="30") echo "selected"; ?>>30 min</option>
		      <option value="45" <?php if ($obst['in_m2']=="45") echo "selected"; ?>>45 min</option>
		      </select>
		    </div></td>
		  </tr>
       
		</table>  
     <iframe src="agenda.php" width="100%" height="800" seamless></iframe>    
 </div>

<div data-role="collapsible" class="partox"> <h3>Datos del recien nacido</h3>
  <table width="100%" align="center" style="margin: 0 auto;">
    <tr>
      <td width="31%" class="pequeno2">Nombre</td>
      <td width="7%" class="pequeno2">Sexo</td>
      <td width="12%" class="pequeno2">Peso(kg)</td>
      <td width="12%" class="pequeno2">Talla(cm)</td>
      <td width="38%" class="pequeno2">F. Nacimiento</td>
    </tr>
    <tr>
      <td><input type="text" name="parto_nom" id="parto_nom" value="<?php echo $obst['parto_nom']; ?>" data-mini="true"></td>
      <td><select name="parto_sex" id="parto_sex" data-mini="true">
        <option value="">---</option>
        <option value=1 <?php if ($obst['parto_sex']==1) echo "selected"; ?>>Hombre</option>
        <option value=2 <?php if ($obst['parto_sex']==2) echo "selected"; ?>>Mujer</option>
      </select></td>
      <td><input type="number" step="any" name="parto_pes" id="parto_pes" value="<?php echo $obst['parto_pes']; ?>" data-mini="true"></td>
      <td><input type="number" step="any" name="parto_tal" id="parto_tal" value="<?php echo $obst['parto_tal']; ?>" data-mini="true"></td>
      <td><input type="date" name="parto_nac" id="parto_nac" value="<?php echo $obst['parto_nac']; ?>" data-mini="true"></td>
    </tr>
    <tr>
      <td>Observaciones:</td>
      <td colspan="4"><textarea name="parto_obs" id="parto_obs" data-mini="true"><?php echo $obst['parto_obs']; ?></textarea></td>
    </tr>
    </table>
  
 </div>
 </div>
<!-- close collapse 1 ---------------------------------------> 
<?php if ($obst['med']==$login) { ?>
 <input type="Submit" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-mini="true" class="show-page-loading-msg" data-textonly="false" data-textvisible="true" data-msgtext="Actualizando datos.." data-theme="b" data-inline="true"/>
<?php } else { echo '<font color="#E34446"><b>PERMISO DE EDICION SOLO PARA: </b> '.$obst['med'].'</font>'; } ?> 
 </form>
 
</div><!-- /content -->


<?php } ?>
</div><!-- /page -->


<script>
$( document ).on( "click", ".show-page-loading-msg", function() {
	
	
	if (document.getElementById("g_ges").value == "") 
	{
		alert ("Debe llenar el campo 'Gestaciones'");
		return false;
	}
	
	if (document.getElementById("in_t").value != "") {
	
			if (document.getElementById("in_f1").value == "" || document.getElementById("in_h1").value == "" || document.getElementById("in_m1").value == "" || document.getElementById("in_f2").value == "" || document.getElementById("in_h2").value == "" || document.getElementById("in_m2").value == "") {
				alert ("Debe llenar las fechas de Internamiento e Intervención");
				return false;
			}
	}
	
	// --------------------------- valida las fechas y horas de las consultas -----------------------------------------------------
	
	if (document.getElementById("con_fec0").value != "") {
	
			if (document.getElementById("con_fec_h0").value == "" || document.getElementById("con_fec_m0").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 1");
				return false;
			}
	}
	if (document.getElementById("con_fec1").value != "") {
	
			if (document.getElementById("con_fec_h1").value == "" || document.getElementById("con_fec_m1").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 2");
				return false;
			}
	}
	if (document.getElementById("con_fec2").value != "") {
	
			if (document.getElementById("con_fec_h2").value == "" || document.getElementById("con_fec_m2").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 3");
				return false;
			}
	}
	if (document.getElementById("con_fec3").value != "") {
	
			if (document.getElementById("con_fec_h3").value == "" || document.getElementById("con_fec_m3").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 4");
				return false;
			}
	}
	if (document.getElementById("con_fec4").value != "") {
	
			if (document.getElementById("con_fec_h4").value == "" || document.getElementById("con_fec_m4").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 5");
				return false;
			}
	}
	if (document.getElementById("con_fec5").value != "") {
	
			if (document.getElementById("con_fec_h5").value == "" || document.getElementById("con_fec_m5").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 6");
				return false;
			}
	}
	if (document.getElementById("con_fec6").value != "") {
	
			if (document.getElementById("con_fec_h6").value == "" || document.getElementById("con_fec_m6").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 7");
				return false;
			}
	}
	if (document.getElementById("con_fec7").value != "") {
	
			if (document.getElementById("con_fec_h7").value == "" || document.getElementById("con_fec_m7").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 8");
				return false;
			}
	}
	if (document.getElementById("con_fec8").value != "") {
	
			if (document.getElementById("con_fec_h8").value == "" || document.getElementById("con_fec_m8").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 9");
				return false;
			}
	}
	if (document.getElementById("con_fec9").value != "") {
	
			if (document.getElementById("con_fec_h9").value == "" || document.getElementById("con_fec_m9").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 10");
				return false;
			}
	}
	if (document.getElementById("con_fec10").value != "") {
	
			if (document.getElementById("con_fec_h10").value == "" || document.getElementById("con_fec_m10").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 11");
				return false;
			}
	}
	if (document.getElementById("con_fec11").value != "") {
	
			if (document.getElementById("con_fec_h11").value == "" || document.getElementById("con_fec_m11").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 12");
				return false;
			}
	}
	if (document.getElementById("con_fec12").value != "") {
	
			if (document.getElementById("con_fec_h12").value == "" || document.getElementById("con_fec_m12").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 13");
				return false;
			}
	}
	if (document.getElementById("con_fec13").value != "") {
	
			if (document.getElementById("con_fec_h13").value == "" || document.getElementById("con_fec_m13").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 14");
				return false;
			}
	}
	if (document.getElementById("con_fec14").value != "") {
	
			if (document.getElementById("con_fec_h14").value == "" || document.getElementById("con_fec_m14").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 15");
				return false;
			}
	}
	if (document.getElementById("con_fec15").value != "") {
	
			if (document.getElementById("con_fec_h15").value == "" || document.getElementById("con_fec_m15").value == "") {
				alert ("Debe llenar la fecha y hora de la Consulta 16");
				return false;
			}
	}
	
    var $this = $( this ),
        theme = $this.jqmData( "theme" ) || $.mobile.loader.prototype.options.theme,
        msgText = $this.jqmData( "msgtext" ) || $.mobile.loader.prototype.options.text,
        textVisible = $this.jqmData( "textvisible" ) || $.mobile.loader.prototype.options.textVisible,
        textonly = !!$this.jqmData( "textonly" );
        html = $this.jqmData( "html" ) || "";
    $.mobile.loading( "show", {
            text: msgText,
            textVisible: textVisible,
            theme: theme,
            textonly: textonly,
            html: html
    });
})
.on( "click", ".hide-page-loading-msg", function() {
    $.mobile.loading( "hide" );
});



</script>
</body>
</html>
