<?php

require_once '../clases/Conexion.class.php';

class AjaxUsuario extends Conexion {

    private $datos;

    public function __construct() {
        parent::__construct();
        parent::Conectar();
        $this->datos = array();
    }

    public function validarUsuario($user) {
        $sql = "
            SELECT * 
            FROM usuarios 
            WHERE usuario = '$user'";
        $res = mysql_query($sql);
        $dato = mysql_fetch_assoc($res);

        return ($dato > 0) ? $dato : false;
    }

    public function registrarUsuario($datos) {
        $sql = "INSERT INTO usuarios(usuario, clave) VALUES ('{$datos['usuario']}','{$datos['clave']}')";
        $res = mysql_query($sql);

        return ($res > 0) ? true : false;
    }

    public function AgregarPermisos($menu, $usuario) {
        $con = 0;
        $arreglo = array_filter(explode("/", $menu));
        $sql = "
            UPDATE
            usuarios SET permisos='',permisos_sub='',opciones=''
            WHERE usuario='$usuario';
        ";
        mysql_query($sql);

        foreach ($arreglo as $key => $value) {
            list($menu, $tipo) = explode(",", $value);

            if (preg_match("/(,menu)/", $value)) {
                $sql2 = "
                    UPDATE
                    usuarios SET permisos=CONCAT(permisos,'/$menu/')
                    WHERE usuario='$usuario';
                ";

                $res = mysql_query($sql2);
                if ($res > 0) {
                    ++$con;
                }
            } else if (preg_match("/(,submenu)/", $value)) {

                $sql3 = "
                    UPDATE
                    usuarios SET permisos_sub=CONCAT(permisos_sub,'/$menu/')
                    WHERE usuario='$usuario';
                ";

                $res2 = mysql_query($sql3);
                if ($res2 > 0) {
                    ++$con;
                }
            } else if (preg_match("/(,asaderoselect)/", $value)) {
                $sql4 = "
                    UPDATE
                    usuarios SET opciones=CONCAT(opciones,'/$menu/')
                    WHERE usuario='$usuario';
                ";
                $res3 = mysql_query($sql4);
                if ($res3 > 0) {
                    ++$con;
                }
            } else if (preg_match("/(,opciones)/", $value)) {
                $sql5 = "
                    UPDATE
                    usuarios SET opciones=CONCAT(opciones,'/$menu/')
                    WHERE usuario='$usuario';
                ";
                $res4 = mysql_query($sql5);
                if ($res4 > 0) {
                    ++$con;
                }
            }
        }

        return ($con > 0) ? true : false;
    }

}

$obj_ajax = new AjaxUsuario();
if (isset($_POST['usuario'])) {
    $ok = $obj_ajax->validarUsuario($_POST['usuario']);

    if ($ok == false) {
        $var = $obj_ajax->registrarUsuario($_POST);
        if ($var == true) {
            $arreglo = array("usuario" => "ok");
            echo json_encode($arreglo);
        } else {
            $arreglo = array("usuario" => "no");
            echo json_encode($arreglo);
        }
    } else {
        $arreglo = array("usuario" => "error");
        echo json_encode($arreglo);
    }
}

if (isset($_POST['user']) and !empty($_POST['user'])) {
    $datos = $obj_ajax->validarUsuario($_POST['user']);
    echo json_encode($datos);
}
if (isset($_POST['datos']) and isset($_POST['user2'])) {
    $ok2 = $obj_ajax->AgregarPermisos($_POST['datos'], $_POST["user2"]);
    if ($ok2 == true) {
        $arreglo = array("agregado" => 1);
        echo json_encode($arreglo);
    } else {
        $arreglo = array("agregado" => 0);
        echo json_encode($arreglo);
    }
}
?>
