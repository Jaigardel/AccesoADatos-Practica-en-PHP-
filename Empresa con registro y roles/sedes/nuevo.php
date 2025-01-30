<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 1){ ///Si no somos ADMIN nos muestra un mensaje de acceso denegado y redirigimos a index
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
    <title>Alta nueva sede</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
	<header>
        <h1>Alta de una nueva sede</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php

		// Crea las variables necesarias para introducir los campos y comprobar errores.
		$error = true;
		$errorSede = false;
		$errorDireccion = false;

    	if ($_SERVER["REQUEST_METHOD"]=="POST")
    	{
			//Crea las variables con los requisitos de los campos (longitud del nombre de la sede y la dirección)
		    $minNombre = 3;
			$maxNombre = 50;
			$minDireccion = 10;
			$maxDireccion = 255;  
		    
		    // Obtenemos el campo del nombre de la sede y dirección a partir de la función "obtenerValorCampo"
		    $nombre = obtenerValorCampo("nombre");
			$direccion = obtenerValorCampo("direccion");
		    
	    	//-----------------------------------------------------
	        // Validaciones
	        //-----------------------------------------------------
	        // Nombre de la sede: Debe tener la longitud exigida. Si no, preparad las variables para mostrar el error.
	        if(empty($nombre) || !validarLongitudCadena($nombre, $minNombre, $maxNombre)) 
	        {
	            $errorSede = true;
	        }else{
				$error = false;
			}
	        // Dirección de la sede
	        if (empty($direccion) || !validarLongitudCadena($direccion, $minDireccion, $maxDireccion)) 
	        {
	            $errorDireccion = true;
	        }else{
				$error = false;
			}
    	}
  	?>

  	<?php
  		//Si hay algún error, tenemos que mostrar los errores en la misma página, manteniendo los valores bien introducidos.
		 if ($error || $errorDireccion || $errorSede):
?>
    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <p>
            <!-- Campo nombre de la sede -->
            <input type="text" name="nombre" placeholder="Sede" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
            <?php
                if ($errorSede): // Si hay un error en el nombre
            ?>
                <p class="error"><?php echo "El nombre tiene que tener entre 3 y 50 caracteres"; ?></p>
            <?php
                endif;
            ?>
        </p>
        <p>
            <!-- Campo dirección de la sede -->
            <input type="text" name="direccion" placeholder="Dirección" value="<?php echo isset($_POST['direccion']) ? $_POST['direccion'] : ''; ?>">
            <?php
                if ($errorDireccion): // Si hay un error en la dirección
            ?>
                <p class="error"><?php echo "La dirección tiene que tener entre 10 y 255 caracteres"; ?></p>
            <?php
                endif;
            ?>
	        </p>
	        <p>
	            <!-- Botón submit -->
	            <input type="submit" value="Guardar">
	        </p>
	    </form>
  	<?php

			// Si no hay errores, conectar a la BBDD:
  		else:
  			$conexion = conectarPDO($host, $user, $password, $bbdd);

			// consulta a ejecutar
			$sql = "INSERT INTO sedes (nombre, direccion) VALUES (?,?)";

			// preparar la consulta (usar bindParam)
			$consulta = $conexion->prepare($sql);
			$consulta->bindParam(1, $nombre);
			$consulta->bindParam(2, $direccion);	

			// ejecutar la consulta 
			$consulta->execute();

        	// redireccionamos al listado de sedes
			cerrarPDO();
  			header("Location: listado.php");
  			
    	endif;
    ?>
   <div class="contenedor">
        <div class="enlaces">
            <a href="listado.php">Volver al listado de sedes</a>
        </div>
   </div>
   <?php }?>
</body>
</html>