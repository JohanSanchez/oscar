<?php

class ajax {

    private $registros;

    public function __construct() {
        $this->Conectar();
    }

    public function Conectar() {
        $con = mysql_connect("localhost", "root", "");
        mysql_select_db("oscar");
        return $con;
    }

    public function AgregarRegistro($descripcion, $valor, $negocio, $mov) {
        $mov = ($mov == "entrada") ? "entrada" : "salida";

        $sql = "
        INSERT INTO Operacion VALUES(null,'','{$descripcion}',$valor,now(),$negocio,'{$mov}');     
        ";

        $res = mysql_query($sql);

        return ($res > 0) ? true : false;
    }

    public function ObtenerRegistros($asadero) {

        $sql = "
            SELECT * 
            FROM Operacion
            WHERE fecha >= CURDATE()
            AND idNegocio=$asadero
        ";
        $res = mysql_query($sql);

        while ($fila = mysql_fetch_assoc($res)) {
            $this->registros[] = $fila;
        }
        return $this->registros;
    }

}

$ajax = new ajax();

if (isset($_POST["valor"]) and isset($_POST['dato']) and isset($_POST['mov']) and isset($_POST['tipo'])) {
    $insert = $ajax->AgregarRegistro($_POST['dato'], $_POST["valor"], $_POST["tipo"], $_POST["mov"]);

    if ($insert === true) {
        $reponse = $ajax->ObtenerRegistros($_POST["tipo"]);
        echo json_encode($reponse);
    }
} else if (isset($_POST["asadero"])) {
    $datos = $ajax->ObtenerRegistros($_POST["asadero"]);
    echo json_encode($datos);
}
?>
