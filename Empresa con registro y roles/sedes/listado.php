<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"])) header("Refresh: 3; url=../index.php");

    require_once("../utiles/variables.php");
    require_once("../utiles/funciones.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de sedes</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Listado de sedes</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>

    <?php
        // Realiza la conexion a la base de datos a través de una función 
        $conexion = conectarPDO($host, $user, $password, $bbdd);
        // Realiza la consulta a ejecutar en la base de datos en una variable
        $sql = "select id, nombre, direccion FROM sedes";
        // Obten el resultado de ejecutar la consulta para poder recorrerlo. El resultado es de tipo PDOStatement
        $resultado = resultadoConsulta($conexion, $sql);   
    ?>

    <table border="1" cellpadding="10">
        <thead>
            <th>Nombre</th>
            <th>Dirección</th>
            <?php if($_SESSION["rol"] == 1): //Solo se muestra si es ADMIN?>            
            <th>Acción</th>
            <?php endif?>
        </thead>
        <tbody>

            <!-- Muestra los datos -->
            <?php
                while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr><td>$registro[nombre]</td><td>$registro[direccion]</td>";
                    //Si el usuario es un ADMIN, se mostrará unos botones que permiten modificar o borrar sedes
                    if($_SESSION["rol"] == 1)echo "
                    <td><a href=modificar.php?idSede=$registro[id] class=estilo_enlace>&#9998</a>
                    <a href=borrar.php?idSede=$registro[id] class=confirmacion_borrar>&#128465</a></td>";
                    echo "</tr>".PHP_EOL;
                }
            ?>


        </tbody>
    </table>
    <div class="contenedor">
        <div class="enlaces">
            <a href="../index.php">Volver a página de listados</a>
            <?php if($_SESSION["rol"] == 1): //Solo se muestra si es ADMIN?>   
            <a href="nuevo.php">Añadir</a>
            <?php endif?>   
        </div>
    </div>

    <?php

        // Libera el resultado y cierra la conexión
        cerrarPDO();
    ?>
    <script type="text/javascript">
        var elementos =
        document.getElementsByClassName("confirmacion_borrar");
        var confirmFunc = function (e)
        {
        if (!confirm('¿Está seguro de que desea borrar este registro?'))
        e.preventDefault();
        };
        for (var i = 0, l = elementos.length; i < l; i++) {
        elementos[i].addEventListener('click', confirmFunc, false);
        }
    </script>

</body>
</html>