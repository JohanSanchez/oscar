<?php

require_once 'Conexion.class.php';

class Operacion extends Conexion {

    private $registros;
    private $asaderos;
    private $hotel;

    public function __construct() {
        parent::__construct();
        parent::Conectar();
        $this->registros = array();
        $this->asaderos = array();
        $this->hotel = array();
    }

    public function ValidaUsuario($arreglo) {
        $sql = "
            SELECT * 
            FROM usuarios
            WHERE usuario='{$arreglo['usuario']}'
                AND clave='{$arreglo['clave']}'
            ";

        $res = mysql_query($sql);

        if (mysql_num_rows($res) > 0) {
            if ($fila = mysql_fetch_array($res)) {
                $_SESSION['usuario'] = $fila['usuario'];
                $_SESSION['permisos'] = $fila['permisos'];
                $_SESSION['permisos_sub'] = $fila['permisos_sub'];
                $_SESSION['opciones'] = $fila['opciones'];
            }
            header("Location:home.php");
        } else {
            header("Location:index.php?e=1");
        }
    }

    public function AgregarRegistro($descripcion, $valor, $user) {
        $sql = "
        INSERT INTO Operacion VALUES(null,'{$user}','{$descripcion}',$valor);     
        ";
        echo $sql;
    }

    public function ObtenerRegistros() {
        $this->Conectar();
        $sql = "
            SELECT * 
            FROM Operacion
            WHERE fecha >= CURDATE()
        ";

        $res = mysql_query($sql);

        while ($fila = mysql_fetch_assoc($res)) {
            $this->registros[] = $fila;
        }
        return $this->registros;
    }

    public function ObtenerAsaderos($permisos = null) {
        $this->asaderos = "";
        $in = $this->obtieneIdNegocio($permisos);
        $sql = "
            SELECT * 
            FROM negocios
            WHERE id IN($in);
        ";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $this->asaderos[] = $row;
        }
        return $this->asaderos;
    }

    public function obtieneIdNegocio($permisos) {
        $idnegocio = '';
        $negocios = array_filter(explode("/", $permisos));

        foreach ($negocios as $value) {
            $sql = "
                SELECT id 
                FROM negocios
                WHERE descripcion LIKE '%$value%'
                ";
            $res = mysql_query($sql);
            while ($filas = mysql_fetch_array($res)) {
                $idnegocio.= ($idnegocio == '') ? '' : ',';
                $idnegocio.= $filas['id'];
            }
        }
        return $idnegocio;
    }

}

?>
