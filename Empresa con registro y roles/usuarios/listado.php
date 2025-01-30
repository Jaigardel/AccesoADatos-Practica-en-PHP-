<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 1){ //Si no somos ADMIN nos muestra un mensaje de acceso denegado y redirigimos a index
    echo "<h1 style='color: red'>Acceso Denegado.</h1>";
    header("Refresh: 3; url=../index.php");
}else{
require_once("../utiles/variables.php");
require_once("../utiles/funciones.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Listado Usuarios</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>

    <?php
        // Realiza la conexion a la base de datos a través de una función 
        $conexion = conectarPDO($host, $user, $password, $bbdd);
       
        $sql = "SELECT u.email, if(u.activo = 1, 'Activo', 'Inactivo') as activo, u.fecha, r.nombre 
        FROM usuarios u INNER JOIN roles r ON u.rol_id=r.id
        ORDER BY u.fecha DESC";


        // Obten el resultado de ejecutar la consulta para poder recorrerlo. El resultado es de tipo PDOStatement
        $resultado = resultadoConsulta($conexion, $sql);   
    ?>

    <table border="1" cellpadding="10">
        <thead>
            <th>Email</th>
            <th>Activo</th>            
            <th>Rol</th>
            <th>Fecha de alta</th>
        </thead>
        <tbody>

            <!-- Muestra los datos -->
            <?php
                while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr><td>$registro[email]</td><td>$registro[activo]</td>
                    <td>$registro[nombre]</td><td>$registro[fecha]</td></tr>".PHP_EOL;
                }
            ?>


        </tbody>
    </table>
    <div class="contenedor">
        <div class="enlaces">
            <a href="../index.php">Volver a página de listados</a>
            <a href="nuevo.php">Añadir</a>
        </div>
    </div>
    <?php

        // Libera el resultado y cierra la conexión
        cerrarPDO();
    ?>
</body>
</html>
<?php }?>