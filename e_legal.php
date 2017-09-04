<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <?php $login = $_SESSION['login'];
    $dir = $_SERVER['HTTP_HOST'] . substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
    if (!$login) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=http://" . $dir . "'>";
    }
    require("_database/db_tools.php"); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="_themes/tema_inmater.min.css"/>
    <link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css"/>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script>
        // popup PARA LA AGENDA ---------------------------------------------------
        $(document).on("pagecreate", function () {

            // The window width and height are decreased by 30 to take the tolerance of 15 pixels at each side into account
            function scale(width, height, padding, border) {
                var scrWidth = $(window).width() - 30,
                    scrHeight = $(window).height() - 30,
                    ifrPadding = 2 * padding,
                    ifrBorder = 2 * border,
                    ifrWidth = width + ifrPadding + ifrBorder,
                    ifrHeight = height + ifrPadding + ifrBorder,
                    h, w;

                if (ifrWidth < scrWidth && ifrHeight < scrHeight) {
                    w = ifrWidth;
                    h = ifrHeight;
                } else if (( ifrWidth / scrWidth ) > ( ifrHeight / scrHeight )) {
                    w = scrWidth;
                    h = ( scrWidth / ifrWidth ) * ifrHeight;
                } else {
                    h = scrHeight;
                    w = ( scrHeight / ifrHeight ) * ifrWidth;
                }

                return {
                    'width': w - ( ifrPadding + ifrBorder ),
                    'height': h - ( ifrPadding + ifrBorder )
                };
            };

            $(".ui-popup iframe")
                .attr("width", 0)
                .attr("height", "auto");

            $("#popupVideo").on({
                popupbeforeposition: function () {
                    // call our custom function scale() to get the width and height
                    var size = scale(1200, 600, 15, 1),
                        w = size.width,
                        h = size.height;

                    $("#popupVideo iframe")
                        .attr("width", w)
                        .attr("height", h);
                },
                popupafterclose: function () {
                    $("#popupVideo iframe")
                        .attr("width", 0)
                        .attr("height", 0);
                }
            });
        });
    </script>

    <style>
        .controlgroup-textinput {
            padding-top: .10em;
            padding-bottom: .10em;
        }
    </style>
</head>

<body>

<?php if ($_POST['dni'] <> '' and $_POST['guardar'] == 'GUARDAR DATOS') {
    updateLegal($_POST['idx'], $_POST['dni'], $_POST['a_mue'], $_POST['nom'], $_POST['med'], $_POST['a_exa'], $_POST['a_sta'], $_POST['a_obs'], $_POST['gin'], $login, $_FILES['informe']);
    if ($_POST['nota'] <> '') {

        $stmt = $db->prepare("UPDATE hc_paciente SET nota=? WHERE dni=?");
        $stmt->execute(array($_POST['nota'], $_POST['dni']));

    }
}

$gin = $_GET['gin'];
$and = $_GET['andro'];
$id = $_GET['id'];

$Rpop = $db->prepare("SELECT * FROM hc_legal WHERE id=?");
$Rpop->execute(array($id));
$pop = $Rpop->fetch(PDO::FETCH_ASSOC);

if ($and <> '') {
    $User = $db->prepare("SELECT p_dni,p_nom,p_ape,p_med FROM hc_pareja WHERE p_dni=?");
    $User->execute(array($and));
    $use = $User->fetch(PDO::FETCH_ASSOC);
    $nom = $use['p_ape'] . " " . $use['p_nom'];
    $dni = $use['p_dni'];
    $med = $use['p_med'];
}
if ($gin <> '') {
    $User = $db->prepare("SELECT DISTINCT hc_paciente.nom,hc_paciente.ape,hc_paciente.fnac,hc_paciente.nota,hc_gineco.dni,hc_gineco.med FROM hc_gineco,hc_paciente WHERE hc_paciente.dni=hc_gineco.dni AND hc_gineco.id=?");
    $User->execute(array($gin));
    $use = $User->fetch(PDO::FETCH_ASSOC);
    if ($use['fnac'] <> "0000-00-00") $edad = ' <a href="#popupBasic" data-rel="popup" data-transition="pop">(' . date_diff(date_create($use['fnac']), date_create('today'))->y . ')</a>';
    $nom = $use['ape'] . " " . $use['nom'];
    $dni = $use['dni'];
    $med = $use['med'];
}
if ($id <> '') {
    $nom = $pop['a_nom'];
    $dni = $pop['a_dni'];
    $med = $pop['a_med'];
}

$rMed = $db->prepare("SELECT id,nom FROM hc_analisis_tip WHERE lab=? ORDER BY nom ASC");
$rMed->execute(array($login)); ?>

<style>
    .ui-dialog-contain {
        max-width: 1000px;
        margin: 1% auto 1%;
        padding: 0;
        position: relative;
        top: -35px;
    }

    .scroll_h {
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
    }

    .truncate {
        width: 655px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #alerta {
        background-color: #FF9;
        margin: 0 auto;
        text-align: center;
        padding: 4px;
    }

    .enlinea div {
        display: inline-block;
        vertical-align: middle;
    }

    .peke2 .ui-input-text {
        width: 100px !important;
    }
</style>
<script>

    $(document).ready(function () {
        // No close unsaved windows --------------------
        var unsaved = false;
        $(":input").change(function () {

            unsaved = true;

        });

        $(window).on('beforeunload', function () {
            if (unsaved) {
                return 'UD. HA REALIZADO CAMBIOS';
            }
        });

        // Form Submit
        $(document).on("submit", "form", function (event) {
            // disable unload warning
            $(window).off('beforeunload');
        });

        $('#form1').submit(function () {

            $("#cargador").popup("open", {positionTo: "window"});
            return true;

        });


    });

</script>
<form action="e_legal.php" method="post" enctype="multipart/form-data" data-ajax="false" name="form1" id="form1">
    <div data-role="page" class="ui-responsive-panel" id="e_legal" data-dialog="true">
        <div data-role="header" data-position="fixed">
            <a href="lista.php" rel="external" class="ui-btn">Cerrar</a>
            <h2>Legal:
                <small><?php echo $nom.$edad; ?></small>
            </h2>
            <a href="#popupVideo" style="display: none;" data-rel="popup" data-position-to="window" class="ui-btn">Antecedentes</a>

        </div><!-- /header -->
        <div data-role="popup" id="popupBasic" data-arrow="true">
            <textarea name="nota" id="nota" data-mini="true"><?php echo $use['nota']; ?></textarea>
        </div>
        <div data-role="popup" id="popupVideo" data-overlay-theme="b" data-theme="a" data-tolerance="15,15"
             class="ui-content">
            <a href="#" data-rel="back"
               class="ui-btn ui-btn-b ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-left">Close</a>
                
            <iframe src="e_paci.php?id=<?php echo $dni; ?>&pop=1" seamless></iframe>
        </div>

        <div class="ui-content" role="main">


            <input type="hidden" name="idx" value="<?php echo $id; ?>">
            <input type="hidden" name="dni" value="<?php echo $dni; ?>">
            <input type="hidden" name="gin" value="<?php echo $gin; ?>">
            <input type="hidden" name="nom" value="<?php echo $nom; ?>">
            <input type="hidden" name="med" value="<?php echo $med; ?>">

            <table width="100%" align="center" style="margin: 0 auto;">
                <tr>
                    <td>Fecha</td>
                    <td><input name="a_mue" type="date" required id="a_mue"
                               value="<?php echo $pop['a_mue']; ?>" data-mini="true"></td>
                    <td width="4">&nbsp;</td>
                </tr>
                <tr>
                    <td>Tipo de Documento</td>
                    <td colspan="2"><select name="a_exa" id="a_exa" required data-mini="true">
                            <option value="">---</option>
                            <?php while ($med = $rMed->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $med['nom']; ?>" <?php if ($med['nom'] == $pop['a_exa']) echo 'selected'; ?>><?php echo $med['nom']; ?></option>
                            <?php } ?>
                        </select></td>

                </tr>
                <tr>
                    <td>Resultado</td>
                    <td colspan="2"><select name="a_sta" id="a_sta" required data-mini="true">
                            <option value=0 <?php if ($pop['a_sta'] == 0) echo 'selected'; ?>>ATENDIDO</option>
                            <option value=1 <?php if ($pop['a_sta'] == 1) echo 'selected'; ?>>APTO</option>
                            <option value=2 <?php if ($pop['a_sta'] == 2) echo 'selected'; ?>>OBSERVADO</option>
                            <option value=3 <?php if ($pop['a_sta'] == 3) echo 'selected'; ?>>NO APTO</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Informe</td>
                    <td colspan="2">
                        <input name="informe" type="file" id="informe" accept="application/pdf"
                               data-mini="true"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Observación
                    </td>
                    <td colspan="2"><textarea name="a_obs" id="a_obs"
                                              data-mini="true"><?php echo $pop['a_obs']; ?></textarea></td>
                </tr>
            </table>

            <input name="guardar" type="Submit" id="guardar" value="GUARDAR DATOS" data-icon="check"
                   data-iconpos="left" data-inline="true" data-theme="b" data-mini="true"/>

            <div data-role="popup" id="cargador" data-overlay-theme="b" data-dismissible="false"><p>GUARDANDO
                    DATOS..</p></div>

        </div><!-- /content -->


    </div><!-- /page -->
</form>
</body>
</html>
