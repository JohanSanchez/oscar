<?php
require_once 'clases/Operacion.class.php';
require_once 'clases/Contenido.class.php';
$operacion = new Operacion();
$contenido = new Contenido();
$menuPermisos = $contenido->Permisos();
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type='text/javascript' src="js/funciones.js"></script>
<script>
    $(function() {
        var control = 0;
        $("#registrar").click(function() {
            var usuario = $('#usuario').val();
            var clave = $('#clave').val();
            var texto = '';
            var confirmacion = $('#confirmacion').val();
            if (clave === confirmacion && clave > 0 && confirmacion > 0) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ajaxUsuario.php',
                    data: {
                        usuario: usuario,
                        clave: clave
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data['usuario'] == 'ok') {
                            texto = 'Usuario Registrado correctamente';
                            $("#respuesta").removeClass("error").addClass("ok");
                        } else if (data['usuario'] == 'error') {
                            texto = "Usuario ya existe";
                            $("#respuesta").removeClass("ok").addClass("error");
                        } else {
                            texto = 'Error al registrar el usuario';
                            $("#respuesta").removeClass("ok").addClass("error");
                        }
                        $("#respuesta").text(texto);
                        $("#usuario,#clave,#confirmacion").val("");
                    }
                });
            } else {
                alert('Por favor verifique los datos de registro');
            }
        });
        $("#permisos").click(function() {
            $("#formualario").slideUp();
            $("#frmpermisos").fadeIn(1000);
        });

        $("#user").blur(function() {
            var user = $(this).val();
            var permisos = new Array();
            var permisos_sub = new Array();
            var opciones = new Array();
            var divide = new Array();
            var menu = '';
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxUsuario.php',
                data: {
                    user: user
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data != false) {

                        $("#valido").css("background-color", "green");
                        $("#valido").val(data['usuario']);
                        $("#agregar").removeAttr("disabled");
                        $(".permisoscheck").removeAttr("disabled");

                        permisos = array_filter((data['permisos'].split("/")));
                        permisos_sub = array_filter((data['permisos_sub'].split("/")));
                        opciones = array_filter((data['opciones'].split("/")));

                        $(".permisoscheck").each(function() {
                            divide = $(this).val().split(",");
                            for (var i = 0; i < permisos.length; i++) {
                                if (permisos[i] === divide[0]) {
                                    $(this).prop("checked", true);
                                }
                            }
                            for (var j = 0; j < permisos_sub.length; j++) {
                                if (permisos_sub[j] === divide[0]) {
                                    $(this).prop("checked", true);
                                }
                            }

                            for (var j = 0; j < opciones.length; j++) {
                                if (opciones[j] === divide[0]) {
                                    $(this).prop("checked", true);
                                }
                            }

                        });

                    } else {
                        $("#valido").css("background", "red");
                        $("#valido").val("Usuario no encontrado");
                    }

                }
            });//fin ajax
        });

        $("#agregar").click(function() {
            var usuario = $("#user").val();
            var datos = "";
            $('input[name="permisos[]"]:checked').each(function() {
                datos += (datos == '') ? '' : '/';
                datos += $(this).val();
            });


            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxUsuario.php',
                data: {
                    datos: datos,
                    user2: usuario
                },
                dataType: 'JSON',
                success: function(data) {


                }
            });//fin ajax
        });
    });
</script>










<div class='cuerpo1'>
    <div id='formualario'>
        <table align='center'>
            <tr>
                <td>Usuario</td>
                <td><input type="text" name='usuario' id="usuario"></td>
            </tr>
            <tr>
                <td>clave</td>
                <td><input type="text" name='clave' id='clave'></td>
            </tr>
            <tr>
                <td>confirmacion</td>
                <td><input type="text" name='confirmacion' id='confirmacion'></td>
            </tr>
            <tr align='center'>
                <td colspan='3'><div id='respuesta' ></div></td>
            </tr>
            <tr>
                <td><input type="button" name='registrar' value='registrar' style='visibility:<?php echo (stripos($_SESSION['opciones'], '/registrar/') !== false) ? 'visible' : 'hidden' ?>' id='registrar'></td>
            </tr>
            <tr>
                <td><input type='button' name='permisos' value='Permisos' id='permisos'></td>
            </tr>
        </table>
    </div>
    <div id='frmpermisos' style='display: none'>
        <table align='center'>
            <tr>
                <td>Usuario</td>
                <td><input type='text' name='user' id='user'></td>
                <td><input type='text' name='valido' id='valido' readonly></td>
            </tr>
            <tr style='background: #ccc;'>
                <td>Id</td>
                <td>Descripcion</td>
                <td>Trama</td>
                <td>Tipo</td>
            </tr>
            <?php
            foreach ($menuPermisos as $key => $value) {
                ?>
                <tr>
                    <td><input type='checkbox' name='permisos[]' class='permisoscheck' id='id_<?php echo $key; ?>' value='<?php echo $value['trama'] . ',' . str_replace("/", "", $value['opcionvar']); ?>' disabled></td>
                    <td><?php echo $value['descripcion'] ?></td>
                    <td><?php echo ucwords($value['trama']) ?></td>
                    <td><?php echo ucwords(str_replace("/", "", $value['opcionvar'])); ?></td>
                </tr>    
                <?php
            }
            ?>
            <tr>
                <td colspan='4'><div id='respuesta2'></div></td>
            </tr>
            <tr>
                <td><input type='button' name='agregar' id='agregar' value='Agregar' disabled></td>
            </tr>
        </table>
    </div>


</div>
