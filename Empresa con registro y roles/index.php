<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"])) header("Location: login/login.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
    <header>
        <h1>Listados</h1><button onclick="window.location.href='login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <div class="contenedor">
        <div class="enlaces">
            <!-- Poner enlace a listado de sedes -->
             <a href="sedes/listado.php">
            Listado de sedes</a>
        </div>
        <div class="enlaces">
            <!-- Poner enlace a listado de departamentos -->
             <a href="departamentos/listado.php">
            Listado de departamento</a>
        </div>
        <div class="enlaces">
            <!-- Poner enlace a Listado de empleados -->
             <a href="empleados/listado.php">
            Listado de empleados</a>
        </div>
        <?php if($_SESSION["rol"] == 1): //Si se cumple que rol es 1 (admin) se muestra el enlace a usuarios?>
        <div class="enlaces">
            <!-- Poner enlace a Listado de usuarios -->
             <?php echo "<a href=usuarios/listado.php>Usuarios</a>" ?>
        </div>
        <?php endif?>
    </div>
</body>
</html>

</html>