<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 1){ ///Si no somos ADMIN nos muestra un mensaje de acceso denegado y redirigimos a index
    echo "<h1 style='color: red'>Acceso Denegado.</h1>";
    header("Refresh: 3; url=../index.php");
}else{
require_once("../utiles/variables.php");
require_once("../utiles/funciones.php");

//Si no existen se les da valor negativo a las variables que controlan los errores
if(!isset($_SESSION["errorEmail"]) || !isset($_SESSION["errorRol"])){
    $_SESSION["errorEmail"] = false;
    $_SESSION["errorRol"] = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Añadir Usuarios</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <form action="alta.php" method="post">
        <p>Email: <input type="text" name="email" id="email"></p>
        <?php if($_SESSION["errorEmail"]) echo "<p class=error>Email incorrecto o ya existe</p>" // Si el email no es válido se muestra un mensaje de error?>
        <p>Rol: 
            <select name="rol" id="rol">
                <option value="">Seleccione un rol</option>
                <?php
					//Conectar a la base de datos para tomar los posibles valores de los usuarios.
					
	            	$conexion = conectarPDO($host, $user, $password, $bbdd);
					
	            	$consulta = "SELECT DISTINCT u.rol_id, r.nombre FROM usuarios u LEFT JOIN roles r ON u.rol_id = r.id";
	            	
	            	$resultado = resultadoConsulta($conexion, $consulta);

  					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)):
                ?>
  					<option value="<?php echo $row["rol_id"]; ?>"><?php echo $row["nombre"]; ?></option>
  				<?php
  					endwhile;
  					
  					$resultado = null;
        			$conexion = null;
  				?>
            </select>
            <?php if($_SESSION["errorRol"]) echo "<p class=error>Elija un rol</p>" //Si hay algún error se muestra un mensaje?>
        </p>
        <p><input type="submit" value="Enviar"></p>
    </form>
</body>
</html>
<?php }?>