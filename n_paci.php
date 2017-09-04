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
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nuevo Paciente</title>
        <link rel="stylesheet" href="_themes/tema_inmater.min.css"/>
        <link rel="stylesheet" href="_themes/jquery.mobile.icons.min.css"/>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css"/>
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

    </head>

<body>
<div data-role="page" class="ui-responsive-panel" id="n_paci" data-dialog="true">
    <style>
        .ui-dialog-contain {

            max-width: 900px;
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

            $('.numeros').keyup(function () {

                var $th = $(this);
                $th.val($th.val().replace(/[^0-9]/g, function (str) {
                    //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');

                    return '';
                }));

                //$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
            });

            $('.alfanumerico').keyup(function () {

                var $th = $(this);
                $th.val($th.val().replace(/[^a-zA-Z0-9]/g, function (str) {
                    //$('#cod small').replaceWith('<small>Error: Porfavor ingrese solo letras y números</small>');

                    return '';
                }));

                //$('#cod small').replaceWith('<small>Aqui ingrese siglas o un nombre corto de letras y números</small>');
            });

            $("#depa").change(function () {

                $("#depa option:selected").each(function () {
                    var depa = $(this).val();
                    //$(".varillas").remove();
                    $.post("le_tanque.php", {depa: depa}, function (data) {
                        $("#prov").html(data);
                        $("#prov").selectmenu("refresh");
                    });
                });
            });

            $("#prov").change(function () {

                $("#prov option:selected").each(function () {
                    var prov = $(this).val();
                    //$(".varillas").remove();
                    $.post("le_tanque.php", {prov: prov}, function (data) {
                        $("#dist").html(data);
                        $("#dist").selectmenu("refresh");
                    });
                });
            });
        });
    </script>
    <div data-role="header" data-position="fixed">
        <h1>Nuevo Paciente</h1>
    </div><!-- /header -->
    <div class="ui-content" role="main">
        <?php

        if (isSet($_POST['dni'])) {

            insertPaci($_POST['dni'], $login, $_POST['tip'], $_POST['nom'], $_POST['ape'], $_POST['fnac'], $_POST['tcel'], $_POST['tcas'], $_POST['tofi'], $_POST['mai'], $_POST['dir'], $_POST['nac'], $_POST['depa'], $_POST['prov'], $_POST['dist'], $_POST['prof'], $_POST['san'], $_POST['don'], $_POST['raz'], $_FILES['foto'], $_POST['rem'], $_POST['sta']); ?>
            <script type="text/javascript">
                window.parent.location.href = "lista.php";
            </script>
            <?php
        }

        ?>
        <form action="n_paci.php" method="post" enctype="multipart/form-data" data-ajax="false">
            <div class="scroll_h">
                <table width="100%" align="center" style="margin: 0 auto;max-width:800px;">
                    <tr>
                        <td width="9%">Nombre(s)</td>
                        <td width="19%"><input name="nom" type="text" id="nom" data-mini="true"/></td>
                        <td width="13%">Apellidos</td>
                        <td width="29%"><input name="ape" type="text" id="ape" data-mini="true"/></td>
                        <td rowspan="8">
                            <fieldset data-role="controlgroup">
                                <select name="nac" id="nac" data-mini="true">
                                    <option value="">Nacionalidad</option>
                                    <option value="PE">Peru</option>
                                    <?php $rPais = $db->prepare("SELECT * FROM countries ORDER by countryName ASC");
                                    $rPais->execute();
                                    while ($pais = $rPais->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value=" . $pais['countryCode'] . ">" . $pais['countryName'] . "</option>";
                                    } ?>
                                </select>
                                <select name="raz" id="raz" data-mini="true">
                                    <option value="">Raza:</option>
                                    <option value="Blanca">Blanca</option>
                                    <option value="Morena">Morena</option>
                                    <option value="Mestiza">Mestiza</option>
                                    <option value="Asiatica">Asiatica</option>
                                </select>
                                <select name="san" id="san" data-mini="true">
                                    <option value="">Grupo Sanguineo:</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                                <select name="don" id="don" data-mini="true">
                                    <option value="">Tipo Paciente:</option>
                                    <option value="P">Paciente</option>
                                    <option value="D">Donante</option>
                                </select>

                                <img src="_images/foto.gif" alt="" width="100px" height="100px" id="preview"/>
                                <input name="foto" type="file" onchange="previewImage(this)" accept="image/jpeg"
                                       id="foto"/>

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
                        <td><select name="tip" id="tip" data-mini="true">
                                <option value="DNI" selected>DNI</option>
                                <option value="PAS">PAS</option>
                                <option value="CEX">CEX</option>
                            </select></td>
                        <td><input name="dni" type="text" id="dni" data-mini="true" class="alfanumerico"/></td>
                        <td>F. Nac</td>
                        <td><input name="fnac" type="date" id="fnac" data-mini="true"/></td>
                    </tr>
                    <tr>
                        <td>Celular</td>
                        <td><input name="tcel" type="number" step="any" id="tcel" data-mini="true" class="numeros"/>
                        </td>
                        <td>E-Mail</td>
                        <td><input name="mai" type="text" id="mai" data-mini="true"></td>
                    </tr>
                    <tr>
                        <td>T. Casa</td>
                        <td><input name="tcas" type="number" step="any" id="tcas" data-mini="true" class="numeros"/>
                        </td>
                        <td>Profesión</td>
                        <td><input name="prof" type="text" id="prof" data-mini="true"/></td>
                    </tr>
                    <tr>
                        <td>T. Oficina</td>
                        <td><input name="tofi" type="text" id="tofi" data-mini="true"/></td>
                        <td>Referido por</td>
                        <td><input name="rem" type="text" id="rem" data-mini="true"/></td>
                    </tr>
                    <tr>
                        <td>Dep/Prov/Dis</td>
                        <td><select name="depa" id="depa" data-mini="true">
                                <option value="">Departamento:</option>
                                <option value="150000">LIMA</option>
                                <?php $rDepa = $db->prepare("SELECT * FROM departamentos ORDER by nomdepartamento ASC");
                                $rDepa->execute();
                                while ($depa = $rDepa->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $depa['Iddepartamento']; ?>"><?php echo $depa['nomdepartamento']; ?></option>
                                <?php } ?>
                            </select></td>
                        <td><select name="prov" id="prov" data-mini="true"> </select></td>
                        <td><select name="dist" id="dist" data-mini="true"> </select></td>
                    </tr>
                    <tr>
                        <td>Dirección</td>
                        <td colspan="3"><input name="dir" type="text" id="dir" data-mini="true"/></td>
                    </tr>
                    <tr>
                        <td>Observaciones</td>
                        <td colspan="3"><textarea name="sta" id="sta" data-mini="true"></textarea></td>
                    </tr>
                </table>
            </div>
            <input type="Submit" value="AGREGAR DATOS" data-icon="check" data-iconpos="left" data-mini="true"
                   class="show-page-loading-msg" data-textonly="false" data-textvisible="true"
                   data-msgtext="Agregando paciente.." data-theme="b" data-inline="true"/>

        </form>

    </div><!-- /content -->
    <script>
        $(document).on("click", ".show-page-loading-msg", function () {

            if (document.getElementById("nom").value == "") {
                alert("Debe llenar el campo 'Nombre'");
                return false;
            }
            if (document.getElementById("ape").value == "") {
                alert("Debe llenar el campo 'Apellidos'");
                return false;
            }
            if (document.getElementById("tip").value == "") {
                alert("Debe llenar el campo 'Tipo de Documento'");
                return false;
            }
            if (document.getElementById("dni").value == "") {
                alert("Debe llenar el campo 'DNI'");
                return false;
            }

            if (document.getElementById("don").value == "") {
                alert("Debe llenar el campo 'Tipo de Paciente'");
                return false;
            }

            var $this = $(this),
                theme = $this.jqmData("theme") || $.mobile.loader.prototype.options.theme,
                msgText = $this.jqmData("msgtext") || $.mobile.loader.prototype.options.text,
                textVisible = $this.jqmData("textvisible") || $.mobile.loader.prototype.options.textVisible,
                textonly = !!$this.jqmData("textonly");
            html = $this.jqmData("html") || "";

            $.mobile.loading("show", {
                text: msgText,
                textVisible: textVisible,
                theme: theme,
                textonly: textonly,
                html: html
            });
            $(".show-page-loading-msg").hide();
        })
            .on("click", ".hide-page-loading-msg", function () {
                $.mobile.loading("hide");
            });
    </script>
</div><!-- /page -->

</body>
</html>