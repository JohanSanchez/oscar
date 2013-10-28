<?php
//session_start();
//if (!isset($_SESSION['usuario'])){
//    header('Location:index.php');
//    exit;
//}
require_once 'clases/Operacion.class.php';
require_once 'clases/Contenido.class.php';

$operacion = new Operacion();
$contenido = new Contenido();
$datos = $operacion->ObtenerRegistros();
?>
<!DOCTYPE html>
<html>

    <head>
        <title></title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type='text/javascript' src="js/funciones.js"></script>
        <link rel="stylesheet" type="text/css" href='estilos/estilos.css'>
        <link rel="stylesheet" type="text/css" href='estilos/menu.css'>
        <link rel="stylesheet" type="text/css" href='estilos/estilo_secciones.css'>
        <link rel="stylesheet" type="text/css" href='estilos/estilo_admin.css'>
        <script>
            $(function() {

                $("#Tentrada").click(function() {
                    var dato = $("#dato").val();
                    var valor = $("#valor").val();
                    var contenido = '', texto = '';
                    var patron = /[0-9]/;
                    if (dato != '' && valor != '') {
                        if (patron.test(valor)) {
                            if ($("#Tentrada").is(":checked")) {
                                if (confirm('Desea realizar una entrada con estos datos?')) {
//                       $("#formulario").submit();
                                    contenido = '';
                                    $.ajax({
                                        type: 'POST',
                                        url: 'ajax/ajaxOperaciones.php',
                                        data: {
                                            dato: dato,
                                            valor: valor
                                        },
                                        dataType: 'JSON',
                                        success: function(data) {
                                            $("#datosAjax").empty();
                                            texto = "<tr style='background: #ccc;'><td>Id</td><td>Tipo</td><td>Valor</td></tr>";
                                            $("#datosAjax").append(texto);
                                            $("#Tentrada").attr("checked", false);
                                            $.each(data, function(i, val) {
                                                contenido = '<tr><td>' + val.id + '</td><td>' + val.descripcion;
                                                contenido += '</td><td>' + val.valor + '</td><td><input type="button"';
                                                contenido += 'value="Borrar" onclick="operar(\'' + val.id + '\')"></td></tr>';
                                                $("#datosAjax").append(contenido);
                                            });
                                        }
                                    });
                                } else {
                                    $("#Tentrada").attr("checked", false);
                                }
                            }
                        } else {
                            alert("En valor Solo se permiten numeros");
                            return false;
                        }
                    } else {
                        alert("Error datos vacios");
                        return false;
                    }
                });

                $("#menu a").each(function() {
                    var href = $(this).attr("href");
                    $(this).attr({href: "#"});
                    $(this).click(function() {
                        $(".cuerpo").load(href);
                    });
                });

                $("#menu ul > a").each(function() {
                    var href = $(this).attr("href");
                    $(this).attr({href: "#"});
                    $(this).click(function() {
                        $(".cuerpo").load(href);
                    });
                });
            });
        </script>
        <script>
            function operar(id) {
                alert(id);
            }
        </script>
    </head>
    <body class="html" >
        <div id="contenido">

            <div id="encabezado">
                <div id="logo">
                    <div id="sesion">
                        <a href="CerrarSesion.php"><?php echo ucwords($_SESSION["usuario"]) ?>, Cerrar Session</a>
                    </div>
                </div>
                <div id="divMenu">
                    <?php
                    if (isset($_SESSION['permisos']) and !empty($_SESSION['permisos'])) {
                        $menu = $contenido->Menu($_SESSION['permisos']);
                        $submenu = $contenido->Submenu($_SESSION['permisos_sub']);
                        ?>
                        <ul id="menu">
                            <?php
                            foreach ($menu as $valor) {
                                ?>
                                <li><a href='<?php echo $valor['pagina'] ?>'><?php echo ucwords($valor['Nombre']); ?></a>
                                    <ul>
                                        <?php
                                        if (is_array($submenu)) {
                                            foreach ($submenu as $val) {
                                                if ($val['id_menu'] == $valor['id']) {
                                                    ?>
                                                    <li><a href='<?php echo $val['pagina'] ?>'><?php echo ucwords($val['descripcion']) ?></a></li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="cuerpo">
                <form action='' name='formulario' id='formulario' method='POST'>
                    <div id="entrada">
                        <table align='center'>
                            <tr>
                                <td>Dato</td>
                                <td><input type='text' name='dato' id='dato' placeholder='Descripcion'></td>
                                <td><input type='text' name='valor' id='valor' placeholder='Valor'></td>
                            </tr>    
                            <tr>
                                <td>Entrada</td>
                                <td><input type='checkbox' name='entrada' id='Tentrada'></td>
                            </tr>
                            <tr>
                                <td>Salida</td>
                                <td>
                                    <input type='checkbox' name='salida' id='Tsalida'>
                                    <input type='hidden' name='grabar' value='si'>
                                </td>
                            </tr>
                        </table>
                </form>
            </div>

            <div id="datos">
                <table id='datosAjax' align='center'>
                    <tr style='background: #ccc;'>
                        <td>Id</td>
                        <td>Tipo</td>
                        <td>Valor</td>
                    </tr>
                    <?php
                    foreach ($datos as $value) {
                        ?>
                        <tr>
                            <td><?php echo $value['id'] ?></td>
                            <td><?php echo $value['descripcion'] ?></td>
                            <td><?php echo $value['valor'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>
         
        </div>

    </div>


</body>
</html>
