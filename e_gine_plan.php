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

<div data-role="page" class="ui-responsive-panel" id="e_gine_plan" data-dialog="true">

<?php if ($_POST['idp'] <> "" and $_POST['fec']) {

updateGine_plan($_POST['idx'],$_POST['idp'],$_POST['fec'],$_POST['plan'],$_FILES['foto'],$_POST['dni']);

}

if ($_GET['idp'] <> "" and $_GET['dni'] <> "") {

$dni = $_GET['dni'];
$idp = $_GET['idp'];	
$id = $_GET['id'];

$Rpop = $db->prepare("SELECT * FROM hc_gineco_plan WHERE id=?");
$Rpop->execute(array($id));
$pop = $Rpop->fetch(PDO::FETCH_ASSOC);

//if (!file_exists('paci/'.$dni.'/'.$idp.'/'.$id.'/foto.jpg')) $foto_url = '_images/fotoxxx.gif'; else
 $foto_url = 'paci/'.$dni.'/'.$idp.'/'.$id.'/foto.jpg?v='.mt_rand(); ?>


<style>
.ui-dialog-contain {
  	
  	max-width: 550px;
	margin: 2% auto 15px;
	padding: 0;
	position: relative;
	top: -15px;
	
}
.scroll_h { overflow-x: scroll; overflow-y: hidden; white-space:nowrap; } 
</style>

<div data-role="header" data-position="fixed">
    <h3>Ginecología - Plan de Trabajo</h3>
</div><!-- /header -->

<div class="ui-content" role="main">

<form action="e_gine_plan.php" method="post" enctype="multipart/form-data" data-ajax="false" name="form2">
<input type="hidden" name="idx" value="<?php echo $id;?>">
<input type="hidden" name="idp" value="<?php echo $idp;?>">
<input type="hidden" name="dni" value="<?php echo $dni;?>">

<table width="100%" align="center" style="margin: 0 auto;max-width:550px;">
		<tr>
		  <td width="106">Fecha</td>
		  <td width="144">
		    <input name="fec" type="date" id="fec" data-mini="true" value="<?php echo $pop['fec'];?>">
		    </td>
		  <td width="65">Imagen</td>
		  <td width="939">
          <img src="<?php echo $foto_url; ?>" alt="" width="100px" height="100px" id="preview" />
		    <input name="foto" type="file" onchange="previewImage(this)" accept="image/jpeg" id="foto"/>
            </fieldset>
		    <script type="text/javascript">      
              function previewImage(input) {
                var preview = document.getElementById('preview');
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                    preview.setAttribute('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
                } else {
                  preview.setAttribute('src', 'placeholder.png');
                }
              }
            </script>
          </td>
		  </tr>
		<tr>
		  <td>
         Plan
          </td>
		  <td colspan="3"><textarea name="plan" id="plan" data-mini="true"><?php echo $pop['plan'];?></textarea></td>
		  </tr>
		</table>
   
<input type="Submit" value="GUARDAR DATOS"  data-icon="check" data-iconpos="left" data-mini="true" class="show-page-loading-msg" data-textonly="false" data-textvisible="true" data-msgtext="Guardando datos.." data-theme="b" data-inline="true"/>
 
 </form>
 
</div><!-- /content -->


<?php } ?>
</div><!-- /page -->


<script>
$( document ).on( "click", ".show-page-loading-msg", function() {
	
	if (document.getElementById("fec").value == "") {
				alert ("Debe especificar la Fecha");
				return false;
			}
			
	if (document.getElementById("plan").value == "") {
				alert ("Debe especificar el Plan");
				return false;
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
