<?php
session_start();
class Conexion {

    public function __construct() {
        
    }

    public function Conectar() {
        $arcConexion = "sistema.ini";
        $datos = parse_ini_file($arcConexion, true);

//        $con = mysql_connect($datos["host"], $datos['user'], $datos['pass']);
        $con = mysql_connect('localhost', 'root', '');
//        mysql_select_db($datos["db"]);
        mysql_select_db("oscar");
        if (mysql_errno() == 1049) {
            $this->creaBaseDatos();
        } else {
            return $con;
        }
    }

    public function ConexionSecundaria() {
        $arcConexion = "sistema.ini";
        $datos = parse_ini_file($arcConexion, true);
        $con = mysql_connect($datos["host"], $datos['user'], $datos['pass']);
        return $con;
    }

    public function creaBaseDatos() {
        $arcConexion = "sistema.ini";
        $datos = parse_ini_file($arcConexion, true);

        $sql = "CREATE DATABASE IF NOT EXISTS " . $datos['db'] . " DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
        $ok = mysql_query($sql, $this->ConexionSecundaria()) or die(mysql_error());
        $seleccion = "USE " . $datos['db'] . "";
        mysql_query($seleccion) or die(mysql_error());

        if ($ok > 0) {
            $menu = "CREATE TABLE IF NOT EXISTS menu (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        Nombre varchar(100) COLLATE utf8_spanish_ci NOT NULL,
                        pagina varchar(100) COLLATE utf8_spanish_ci NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ";
            mysql_query($menu);
            $insertMenu = "INSERT INTO menu (id, Nombre, pagina) VALUES
                        (1, 'inicio', 'inicio.php'),
                        (2, 'negocio', 'negocios.php'),
                        (3, 'Administrador', 'administrador.php');";
            mysql_query($insertMenu);

            $operacion = "CREATE TABLE IF NOT EXISTS operacion (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        usuarioreg varchar(100) NOT NULL,
                        descripcion varchar(100) NOT NULL,
                        valor int(11) NOT NULL,
                        fecha date NOT NULL,
                        idNegocio int(11) NOT NULL,
                        movimiento varchar(100) NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;";
            mysql_query($operacion);

            $permisos = "CREATE TABLE IF NOT EXISTS permisos (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        descripcion varchar(100) COLLATE utf8_spanish_ci NOT NULL,
                        trama varchar(100) COLLATE utf8_spanish_ci NOT NULL,
                        opcionvar text COLLATE utf8_spanish_ci NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;";
            mysql_query($permisos);

            $insertPermisos = "INSERT INTO permisos (id, descripcion, trama, opcionvar) VALUES
                            (1, 'Muestra la opcion Inicio', 'inicio', '/menu/'),
                            (3, 'Muestra la opcion de Negocio', 'negocio', '/menu/'),
                            (6, 'Muestra la opcion de administrador', 'administrador', '/menu/'),
                            (7, 'Muestra el submenu hotel', 'hotel', '/submenu/'),
                            (8, 'Muestra el submenu asadero', 'asadero', '/submenu/'),
                            (9, 'Muestra el submenu arriendo', 'arriendo', '/submenu/'),
                            (10, 'Muestra el submenu gastos', 'gastos', '/submenu/'),
                            (11, 'Muestra el submenu permisos', 'permisos', '/submenu/'),
                            (12, 'Muestra el submenu crear Usuario', 'crearUsuario', '/submenu/');";
            mysql_query($insertPermisos);

            $submenu = "CREATE TABLE IF NOT EXISTS submenu (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        descripcion varchar(100) NOT NULL,
                        pagina varchar(100) NOT NULL,
                        id_menu int(11) NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;";
            mysql_query($submenu);
            $insertSubmenu = "INSERT INTO `submenu` (`id`, `descripcion`, `pagina`, `id_menu`) VALUES
                            (1, 'asadero', 'asadero.php', 2),
                            (2, 'hotel', 'hotel.php', 2),
                            (3, 'arriendo', 'arriendos.php', 2),
                            (9, 'gastos', 'gastos.php', 2),
                            (10, 'permisos', 'permisos.php', 3),
                            (11, 'crearUsuario', 'usuario.php', 3);";
            mysql_query($insertSubmenu);

            $usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        usuario varchar(100) NOT NULL,
                        clave varchar(100) NOT NULL,
                        permisos varchar(100) NOT NULL,
                        permisos_sub text NOT NULL,
                        opciones text NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;";
            mysql_query($usuarios);

            $insertUsuarios = "INSERT INTO usuarios (id, usuario, clave, permisos, permisos_sub, opciones) VALUES
                            (1, 'admin', 'admin', '/administrador/', '', '/registrar/');";
            mysql_query($insertUsuarios);

            $negocios = "CREATE TABLE IF NOT EXISTS negocios (
                        id int(11) NOT NULL AUTO_INCREMENT,
                        id_negocio int(11) NOT NULL,
                        descripcion varchar(100) NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;";
            mysql_query($negocios);

            $insertNegocios = "INSERT INTO negocios (id, id_negocio, descripcion) VALUES
                            (1, 1, 'Av 19'),
                            (2, 1, 'Pinares'),
                            (3, 1, 'Tebaida'),
                            (4, 1, 'Suba'),
                            (5, 1, 'Funza');";
            mysql_query($insertNegocios);
        }
    }

}

?>
