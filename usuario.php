<?php
require_once 'clases/Operacion.class.php';
require_once 'clases/Contenido.class.php';
$operacion = new Operacion();
$contenido = new Contenido();
$menuPermisos = $contenido->Permisos();
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type='text/javascript' src="js/funciones.js"></script>
<script type="text/javascript">
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
    });
</script>
<div id="campo_principal_usuario_admin">    
    <div id="sub_campo_principal_usuario_left">
        <div id="sub_campo_principal_usuario_interno">
            <h3>Modulo Creacion Usuarios</h3>
            <input type="text" name='usuario' id="usuario" class="sub_campo_principal_usuario_interno_input" placeholder="Ingrese Nuevo Usuario"><br/>
            <input type="text" name='clave' id='clave' class="sub_campo_principal_usuario_interno_input" placeholder="Ingrese Password"><br/>
            <input type="text" name='confirmacion' id='confirmacion' class="sub_campo_principal_usuario_interno_input" placeholder="ReIngrese Password"><br/>
            <input type="button" name='registrar' value='registrar' style='visibility:<?php echo (stripos($_SESSION['opciones'], '/registrar/') !== false) ? 'visible' : 'hidden' ?>' id='registrar' class="sub_campo_principal_usuario_interno_boton">
            <div id='respuesta' class="sub_campo_principal_usuario_interno_respuesta"></div>
        </div> 
    </div>
    <div id="sub_campo_principal_usuario_rigth">
        Campo sin definir<br/>
        Campo sin definir<br/>
        Campo sin definir<br/>
        Campo sin definir<br/>
    </div>
</div>
