<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
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
    <title>Modificar una sede</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
	<header>
        <h1>Modificar una sede</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php
		// crea las variables para la comprobación de los datos y conectamos con la BBDD para obtener y pintar los datos de la id que acabamos de enviar a la página
    	$errores = [];
    	$comprobarValidacion = false;
		$nombre = "";
		$direccion = "";

    	if (count($_REQUEST) > 0)
    	{
		    if (isset($_GET["idSede"]))
		    {
				$comprobarValidacion = true;
            	$idSede = $_GET["idSede"];
          
            	//Conectamos a la BBDD
				$conexion = conectarPDO($host, $user, $password, $bbdd);
        		// Montamos la consulta a ejecutar
				$sql = "SELECT nombre, direccion FROM sedes WHERE id=?";
		        // prepararamos la consulta
				$resultado = $conexion->prepare($sql);
		        // parámetro (usamos bindParam)
				$resultado->bindParam(1, $idSede);
		        // ejecutamos la consulta 
				$resultado->execute();
		        // comprobamos si hay algún registro
				if($resultado->rowCount() == 0)
				{
					//Si no lo hay, desconectamos y volvemos al listado original
					cerrarPDO();
					header("Location:listado.php");
				}
				else 
				{
					// Si hay algún registro, Obtenemos el resultado (usamos fetch())
					$row = $resultado->fetch();
					$nombre = $row["nombre"];
					$direccion = $row["direccion"];
					cerrarPDO();			        
				}
        	} 
        	else 
        	{
				// Comenzamos la comprobación de los datos introducidos.
				
				// Creamos las variables con los requisitos de cada campo
				$minNombre = 3;
				$maxNombre = 50;
				$minDireccion = 10;
				$maxDireccion = 255;  
        		// Obtenemos el campo del nombre de la sede y dirección
				$idSede = obtenerValorCampo("id");
				$nombre = obtenerValorCampo("nombre");
				$direccion = obtenerValorCampo("direccion");
			    
			    //-----------------------------------------------------
		        // Validaciones
		        //-----------------------------------------------------
				// Comprueba que el id de la sede se corresponde con una que tengamos 
				//conectamos a la bbdd
				$conexion = conectarPDO($host, $user, $password, $bbdd);
	        	// preparamos la consulta SELECT a ejecutar
				$sql = "SELECT nombre FROM sedes WHERE id=?";
				// preparamos la consulta (bindParam)
				$resultado = $conexion->prepare($sql);
				$resultado->bindParam(1, $sedeId);
				// ejecutamos la consulta 
				$resultado->execute();
				// comprobamos si algún registro 
				if ($resultado->rowCount() == 0)
				{
					//Si no lo hay, desconectamos y volvemos al listado original
					cerrarPDO();
					header("Location:listado.php");
				}
				cerrarPDO();
		        // Nombre de la sede: validamos la longitud. Si no es correcta, generamos el error.
		        if(!validarLongitudCadena($nombre, $minNombre ,$maxNombre)) 
		        {
					//Generar msj de error
					$errores["nombre"] = "Error, el nombre tiene que tener entre 3 y 50 caracteres.";
		        }
		        // Dirección de la sede: validamos la longitud. Si no es correcta, generamos el error.
		        if(!validarLongitudCadena($direccion, $minDireccion, $maxDireccion)) 
		        {
					//Generar msj de error
					$errores["direccion"] = "Error, la dirección tiene que tener entre 10 y 255 caracteres.";
		        }

        	}
		    
    	}else{
			header("Location:listado.php");
		} 
    	
  	?>

  	<?php
  		//Si hay errores, pintarlos en el correspondiente campo:
		  if($comprobarValidacion || count($errores) != 0):
  	?>
  		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  			<input type="hidden" name="id" value="<?php echo $idSede; ?>">
	    	<p>
	            <!-- Campo nombre de la sede -->
	            <input type="text" name="nombre" placeholder="Sede" value="<?php echo $nombre; ?>">
	            <?php
	            	if(isset($errores["nombre"])){
				
	            ?>
	            	<p class="error"><?php echo $errores["nombre"]; ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo dirección de la sede -->
	            <input type="text" name="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
	            <?php
	            	if(isset($errores["direccion"])){
	            ?>
	            	<p class="error"><?php echo $errores["direccion"] ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Botón submit -->
	            <input type="submit" value="Guardar">
	        </p>
	    </form>
  	<?php
  		//Si no hay errores:
		else:
  			
			//Nos conectamos a la BBDD
			$conexion = conectarPDO($host, $user, $password, $bbdd);
			// Creamos una variable con la consulta "UPDATE" a ejecutar
			$sql = "UPDATE sedes SET nombre=?, direccion=? WHERE id=?";
			// preparamos la consulta (bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $nombre);
			$resultado->bindParam(2, $direccion);
			$resultado->bindParam(3, $idSede);
			$resultado->execute();
			// ejecutamos la consulta 
			cerrarPDO();
        	// redireccionamos al listado de sedes
  			header("Location: listado.php");
  			
    	endif;
    ?>
    <div class="contenedor">
        <div class="enlaces">
            <a href="listado.php">Volver al listado de sedes</a>
        </div>
   	</div>
    <?php } ?>
</body>
</html>