<?php
//if (!isset($_SESSION['usuario'])){
//    header('Location:index.php');
//    exit;
//}
require_once 'clases/Operacion.class.php';
$operacion = new Operacion();
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href='estilos/estilo_secciones.css'>-->
<link rel="stylesheet" type="text/css" href='estilos/estilos_div.css'>
<script>
    $(function() {
            $("#asadero2").change(function() {
            var asadero = $(this).val();
            var contenido = '', acumEntrada = 0, acumSalida = 0, Entrada = '', Salida = '';
            var texto = $("#asadero2 option:selected").text();
            $("#titulo").html("<h3>" + "Asadero " + texto + "</h3>");
            $("#diventrada").fadeIn();
            $("#datos").fadeIn();
            $("#fechas").fadeIn();
            $("#tipoAsadero").val(asadero);

            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxOperaciones.php',
                data: {
                    asadero: asadero
                },
                dataType: 'JSON',
                success: function(data) {
                    $("#mostrar_negocio").fadeOut();
                    $("#fecha").fadeIn();
                    $("#muestra_pro, #seleccion_pro").fadeIn();
                    $("#datosAjax").empty();
                    texto = "<thead><tr><th>Fecha</th><th>Tipo</th><th>Entrada</th><th>Salida</th><th>Acciones</th></tr></thead>";
                    $("#datosAjax").append(texto);
                    $("#Tentrada").attr("checked", false);
                    $.each(data, function(i, val) {
                        if (val.movimiento == 'entrada') {
                            Entrada = val.valor;
                            acumEntrada += parseInt(Entrada);
                        } else {
                            Entrada = 0;
                        }
                        if (val.movimiento == 'salida') {
                            Salida = val.valor;
                            acumSalida += parseInt(Salida);
                        } else {
                            Salida = 0;
                        }
                        contenido = "<tbody><tr><td>" + val.fecha + "</td><td>" + val.descripcion + "</td><td>" + Entrada + "</td><td style='color: red;'>" + Salida + "</td><td><a href = '' onclick = 'borrar("+val.id+")' ><img src = 'images/borrar.png' style = 'border:none;'></a>&nbsp;&nbsp;&nbsp;<a href = '' onclick = 'borrar("+val.id+")' ><img src = 'images/actualizar.png' style = 'border:none;'></a></td></tr></tbody>"  
                        $("#datosAjax").append(contenido);
                    });
                    contenido = "<tfoot><tr><td></td></tr><tr><td>Neto</td><td></td><td>" + acumEntrada + "</td><td>" + acumSalida + "</td></tr><tr><td></td><tr></tfoot>";
                    contenido += "<tfoot><tr><td>Total</td><td></td><td></td><td>" + (acumEntrada - acumSalida) + "</td></tr><tfoot>";
                    $("#datosAjax").append(contenido);

                }

            });

        });    
    
        $("#asadero").change(function() {
            var asadero = $(this).val();
            var contenido = '', acumEntrada = 0, acumSalida = 0, Entrada = '', Salida = '';
            var texto = $("#asadero option:selected").text();
            $("#titulo").html("<h3>" + "Asadero " + texto + "</h3>");
            $("#diventrada").fadeIn();
            $("#datos").fadeIn();
            $("#fechas").fadeIn();
            $("#tipoAsadero").val(asadero);

            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxOperaciones.php',
                data: {
                    asadero: asadero
                },
                dataType: 'JSON',
                success: function(data) {
                    $("#mostrar_negocio").fadeOut();
                    $("#fecha").fadeIn();
                    $("#muestra_pro, #seleccion_pro").fadeIn();
                    $("#datosAjax").empty();
                    texto = "<thead><tr><th>Fecha</th><th>Tipo</th><th>Entrada</th><th>Salida</th><th>Acciones</th></tr></thead>";
                    $("#datosAjax").append(texto);
                    $("#Tentrada").attr("checked", false);
                    $.each(data, function(i, val) {
                        if (val.movimiento == 'entrada') {
                            Entrada = val.valor;
                            acumEntrada += parseInt(Entrada);
                        } else {
                            Entrada = 0;
                        }
                        if (val.movimiento == 'salida') {
                            Salida = val.valor;
                            acumSalida += parseInt(Salida);
                        } else {
                            Salida = 0;
                        }
                        contenido = "<tbody><tr><td>" + val.fecha + "</td><td>" + val.descripcion + "</td><td>" + Entrada + "</td><td style='color: red;'>" + Salida + "</td><td><a href = '' onclick = 'borrar("+val.id+")' ><img src = 'images/borrar.png' style = 'border:none;'></a>&nbsp;&nbsp;&nbsp;<a href = '' onclick = 'borrar("+val.id+")' ><img src = 'images/actualizar.png' style = 'border:none;'></a></td></tr></tbody>"
                        $("#datosAjax").append(contenido);
                    });
                    contenido = "<tfoot><tr><td></td></tr><tr><td>Neto</td><td></td><td>" + acumEntrada + "</td><td>" + acumSalida + "</td></tr><tr><td></td><tr></tfoot>";
                    contenido += "<tfoot><tr><td>Total</td><td></td><td></td><td>" + (acumEntrada - acumSalida) + "</td></tr><tfoot>";
                    $("#datosAjax").append(contenido);

                }

            });

        });

        $("#Tentrada").click(function() {
            var asadero = $("#asadero").val();
            var dato = $("#dato").val();
            var valor = $("#valor").val();
            var contenido = '', acumEntrada = 0, acumSalida = 0, Entrada = '', Salida = '';
            var patron = /[0-9]/;
            if (dato != '' && valor != '') {
                if (patron.test(valor)) {
                    if ($("#Tentrada").is(":checked")) {
                        if (confirm('Desea realizar una ENTRADA con estos datos?')) {
                            contenido = '';
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/ajaxOperaciones.php',
                                data: {
                                    dato: dato,
                                    valor: valor,
                                    tipo: asadero,
                                    mov: 'entrada'
                                },
                                dataType: 'JSON',
                                success: function(data) {
                                    $("#datosAjax").empty();
                                    texto = "<thead><tr><th>Fecha</th><th>Tipo</th><th>Entrada</th><th>Salida</th><th>Acciones</th></tr></thead>";
                                    $("#datosAjax").append(texto);
                                    $("#Tentrada").attr("checked", false);
                                    $.each(data, function(i, val) {
                                        if (val.movimiento == 'entrada') {
                                            Entrada = val.valor;
                                            acumEntrada += parseInt(Entrada);
                                        } else {
                                            Entrada = 0;
                                            acumSalida += parseInt(Salida);
                                        }

                                        if (val.movimiento == 'salida') {
                                            Salida = parseInt(val.valor);
                                        } else {
                                            Salida = 0;
                                        }
                                        contenido = "<tbody><tr><td>" + val.fecha + "</td><td>" + val.descripcion + "</td><td>" + parseInt(Entrada) + "</td><td style='color: red;'>" + parseInt(Salida) + "</td><td><a href = '#' onclick = 'borrar("+val.id+")' ><img src = 'images/borrar.png' style = 'border:none;'></a>&nbsp;&nbsp;&nbsp;<a href = '#' onclick = 'borrar("+val.id+")' ><img src = 'images/actualizar.png' style = 'border:none;'></a></td></tr></tbody>"
                                        $("#datosAjax").append(contenido);
                                    });
                                    contenido = "<tfoot><tr><td><hr></td></tr><tr><td>Neto</td><td></td><td>" + parseInt(acumEntrada) + "</td><td>" + parseInt(acumSalida) + "</td></tr><tr><td></td><tr></tfoot>";
                                    contenido += "<tfoot><tr><td>Total</td><td></td><td></td><td>" + parseInt((acumEntrada - acumSalida)) + "</td></tr></tfoot>";
                                    $("#datosAjax").append(contenido);

                                }
                            });
                            $("#Tentrada").prop("checked", false);
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


        $("#Tsalida").click(function() {
            var asadero = $("#asadero").val();
            var dato = $("#dato").val();
            var valor = $("#valor").val();
            var contenido = '', acumEntrada = 0, acumSalida = 0, Entrada = '', Salida = '';
            var patron = /[0-9]/;
            if (dato != '' && valor != '') {
                if (patron.test(valor)) {
                    if ($("#Tsalida").is(":checked")) {
                        if (confirm('Desea realizar una SALIDA con estos datos?')) {
                            contenido = '';
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/ajaxOperaciones.php',
                                data: {
                                    dato: dato,
                                    valor: valor,
                                    tipo: asadero,
                                    mov: 'salida'
                                },
                                dataType: 'JSON',
                                success: function(data) {
                                    $("#datosAjax").empty();
                                    texto = "<thead><tr><th>Fecha</th><th>Tipo</th><th>Entrada</th><th>Salida</th><th>Acciones</th></tr></thead>";
                                    $("#datosAjax").append(texto);
                                    $("#Tentrada").attr("checked", false);
                                    $.each(data, function(i, val) {
                                        if (val.movimiento == 'entrada') {
                                            Entrada = val.valor;
                                            acumEntrada += parseInt(Entrada);
                                        } else {
                                            Entrada = 0;
                                        }

                                        if (val.movimiento == 'salida') {
                                            Salida = val.valor;
                                            acumSalida += parseInt(Salida);
                                        } else {
                                            Salida = 0;
                                        }
                                        contenido = "<tbody><tr><td>" + val.fecha + "</td><td>" + val.descripcion + "</td><td>" + parseInt(Entrada) + "</td><td style='color: red;'>" + parseInt(Salida) + "</td><td><a href = '#' onclick = 'borrar("+val.id+")' ><img src = 'images/borrar.png' style = 'border:none;'></a>&nbsp;&nbsp;&nbsp;<a href = '#' onclick = 'borrar("+val.id+")' ><img src = 'images/actualizar.png' style = 'border:none;'></a></td></tr></tbody>"
                                        $("#datosAjax").append(contenido);
                                    });
                                    contenido = "<tfoot><tr><td></td></tr><tr><td>Neto</td><td></td><td>" + parseInt(acumEntrada) + "</td><td>" + parseInt(acumSalida) + "</td></tr><tr><td></td><tr></tfoot>";
                                    contenido += "<tfoot><tr><td>Total</td><td></td><td></td><td>" + parseInt((acumEntrada - acumSalida)) + "</td></tr></tfoot>";
                                    $("#datosAjax").append(contenido);
                                }
                            });

                            $("#Tsalida").prop("checked", false);
                        } else {
                            $("#Tsalida").attr("checked", false);
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
    });
    
</script>
<script type="text/javascript">
function borrar(id){
    alert('borrar');
//    $("#"+id).detach();
}
</script>

<!--Div que muestra el negocio a donde se va a entrar -->
<!--div-->
<div id="mostrar_negocio">
    <form action='' name='formulario' id='formulario' method='POST'>
        <table align="center" class="tabla_selecsion_pro">
            <tr>
                <td>Seleccione Asadero</td>
                <td>
                    <select name="asadero" id="asadero2">
                        <option value='0'>Seleccione Asadero</option>
                        <?php
                        $asaderos2 = $operacion->ObtenerAsaderos($_SESSION['opciones']);

                        foreach ($asaderos2 as $value) {
                            ?>
                            <option value='<?php echo $value['id'] ?>'><?php echo $value['descripcion'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            
        </table>
    </form>
</div>


<div id="po">

    <div class="div_arriba">

        <div id="seleccion_pro">
            <form action='' name='formulario' id='formulario' method='POST'>
                <table align="center" class="tabla_selecsion_pro">
                    <tr id="fechas" style="display: none;">
                        <td>Seleccione Asadero</td>
                        <td>
                            <select name="asadero" id="asadero">
                                <option value='0'>Seleccione Asadero</option>
                                <?php
                                $asaderos = $operacion->ObtenerAsaderos($_SESSION['opciones']);

                                foreach ($asaderos as $value) {
                                    ?>
                                    <option value='<?php echo $value['id'] ?>'><?php echo $value['descripcion'] ?></option>
                                    <?php
                                }
                                ?>

                            </select>
                        </td>
                    </tr>
                    <tr></tr>
                    <tr id="fecha" style="display: none;">
                        <td>Busqueda Por Fechas</td>
                        <td>
                            <select name="asadero" id="asadero">
                                <option value='0'>Seleccione Fecha</option>
                                <option>fecha</option>

                            </select>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <!--FIn-->

        <div id="muestra_pro">

            <div id="diventrada" style="display:none">
                <table align="center" class="tabla_muesta_pro">
                    <tr align='center'>
                        <td colspan='3'></td>
                    </tr>
                    <tr>
                        <td>Datos</td>
                        <td><input type='text' name='dato' id='dato' placeholder='  Descripcion' class="input_muestra_pro"></td>
                        <td><input type='text' name='valor' id='valor' placeholder='  Valor'class="input_muestra_pro"></td>
                    </tr>
                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
                    <tr>
                        <td class="check_"><input type='checkbox' name='entrada' id='Tentrada' class="check_muestra_pro"></td>
                        <td><label for="check_muestra_pro">Click Si es una ENTRADA</label></td>
                    </tr>
                    <tr>
                        <td class="check_"><input type='checkbox' name='salida' id='Tsalida'class="check_muestra_pro"></td>
                        <td><label for="check_muestra_pro">Click Si es una SALIDA</label></td>
                    <input type='hidden' name='tipoAsadero' value=''>
                    </tr>
                </table>
            </div>
        </div>


    </div>

</div>
<div class="abajo" style="display: block;">

    <div id="datos" style="display: none;">

        <div id='titulo' style="text-align: center;"></div>
        <table id='datosAjax' class="tabla_registros">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
