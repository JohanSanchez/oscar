<?php
require_once 'clases/Operacion.class.php';

$operacion = new Operacion();

if (isset($_POST['grabar']) and $_POST["grabar"] == "si") {
    $operacion->ValidaUsuario($_POST);
}
?>

<!DOCTYPE html>
<html class="html">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="estilos/style_login.css" type="text/css">
        <title></title>
    </head>
    <body>
        <form action="" method='POST' name='form'>
            <h2>Ingresar al Portal</h2>
            <input type='text' name='usuario' id='user'placeholder="Usuario" class="text-usuario"><br>

            <input type='password' name='clave' id='pass' placeholder="Password" class="text-password"><br>
            <input type='submit' name='enviar' id='enviar' value='enviar' class="button"><br>
            <input type='hidden' name='grabar' id='grabar' value='si'>

            <div class="informacion_login">
                <?php
                if (isset($_GET["e"])) {
                    switch ($_GET["e"]) {
                        case '1': {
                                ?>
                                <h3 style="color:white">Usuario no existe en la base de datos</h3>
                                <?php
                                break;
                            }
                        case '2': {
                                ?>
                                <h3 style="color:green">Session Cerrada Correctamente</h3>
                                <?php
                                break;
                            }
                        case '3': {
                                ?>
                                <h3 style="color:red">La session no existe</h3>
                                <?php
                                break;
                            }
                    }
                }
                ?>
            </div>
        </form>
    </body>
</html>

