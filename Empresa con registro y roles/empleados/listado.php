<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"])) header("Location: ../login/login.php");

    // Incluye ficheros de variables y funciones
    require_once("../utiles/variables.php");
    require_once("../utiles/funciones.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de empleados</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    
</head>
<body>
<header>
        <h1>Listado empleados</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php
        // Realiza la conexion a la base de datos a través de una función 
        $conexion = conectarPDO($host, $user, $password, $bbdd);
        // Realiza la consulta a ejecutar en la base de datos en una variable
        $sql = "SELECT e.id, e.nombre, e.email, e.apellidos, e.salario, e.hijos, d.nombre as departamento, p.pais as nacionalidad, s.nombre as sede 
         FROM empleados e 
         LEFT JOIN paises p ON e.pais_id=p.id 
         LEFT JOIN departamentos d ON e.departamento_id=d.id 
         LEFT JOIN sedes s ON d.sede_id=s.id";
        // Obten el resultado de ejecutar la consulta para poder recorrerlo. El resultado es de tipo PDOStatement
        $resultado = resultadoConsulta($conexion, $sql);
    ?>
        
    <table border="1" cellpadding="10" style="margin-bottom: 10px;">
        <thead>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo electrónico</th>
            <th>Nº hijos</th>
            <th>Salario</th>
            <th>Nacionalidad</th>
            <th>Departamento</th>
            <th>Sede</th>
            <?php if($_SESSION["rol"] == 1 || $_SESSION["rol"] == 2): //Solo se muestra si es ADMIN o GESTOR?>
            <th>Acción</th>
            <?php endif?>
        </thead>
        <tbody>
            
            <!-- Mostrar todos los datos de los empleados -->
            <?php
                while($registro = $resultado->fetch(PDO::FETCH_OBJ)){
                    echo "<tr><td>$registro->nombre</td><td>$registro->apellidos</td><td>$registro->email</td>
                    <td>$registro->hijos</td><td>$registro->salario</td><td>$registro->nacionalidad</td>
                    <td>$registro->departamento</td><td>$registro->sede</td>";
                    //Si el usuario es un ADMIN o GESTOR, se mostrará unos botones que permiten modificar o borrar empleados
                    if($_SESSION["rol"] == 1 || $_SESSION["rol"] == 2) echo "
                    <td><a href=modificar.php?idEmpleado=$registro->id class=estilo_enlace>&#9998</a>
                    <a href=borrar.php?idEmpleado=$registro->id class=confirmacion_borrar>&#128465</a></td>";
                    echo "</tr>".PHP_EOL;
                }
            ?>
        </tbody>
    </table>
        
    <div class="contenedor">
        <div class="enlaces">
            <a href="../index.php">Volver a página de listados</a>
            <?php if($_SESSION["rol"] == 1 || $_SESSION["rol"] == 2): //Solo se muestra si es ADMIN o GESTOR?>
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