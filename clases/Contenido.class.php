<?php

require_once 'Conexion.class.php';

class Contenido extends Conexion {

    private $menu;
    private $submenu;
    private $permisos;

    public function __construct() {
        parent::__construct();
        parent::Conectar();
        $this->menu = array();
        $this->submenu = array();
        $this->permisos = array();
    }

    public function Menu($permisos) {
        $this->menu = '';
        $arreglo = array_filter(explode("/", $permisos));

        foreach ($arreglo as $value) {
            $query = "
                SELECT * 
                FROM menu
                where Nombre = '$value'
            ";
            $resQuery = mysql_query($query);

            while ($fila = mysql_fetch_assoc($resQuery)) {
                $this->menu[] = $fila;
            }
        }
        return $this->menu;
    }

    public function Submenu($permisos_sub) {
        $this->submenu = '';
        $arreglo = array_filter(explode("/", $permisos_sub));

        foreach ($arreglo as $value) {
            $query = "
                SELECT * 
                FROM submenu
                where descripcion = '$value'
            ";
            $resQuery = mysql_query($query);

            while ($fila = mysql_fetch_assoc($resQuery)) {
                $this->submenu[] = $fila;
            }
        }
        return $this->submenu;
    }

    public function Permisos() {
        $sql = '
            SELECT * 
            FROM permisos';
        $res = mysql_query($sql);
        while ($fila = mysql_fetch_assoc($res)) {
            $this->permisos[] = $fila;
        }
        return $this->permisos;
    }

}

?>
