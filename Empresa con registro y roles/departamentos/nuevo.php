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
    <title>Alta nuevo departamento</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
	<header>
        <h1>Alta nuevo departamento</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php
		// Crea las variables necesarias para introducir los campos y comprobar errores.
			$error = true;
			$errorDepartamento = false;
			$errorPresupuesto = false;
			$errorSede = false;
			$nombre = "";
			$presupuesto = 0;
			$sede = 0;

    	if ($_SERVER["REQUEST_METHOD"]=="POST")
    	{
		    //Crea las variables con los requisitos de longitud en el campo nombre del departamento 
			$departamentoMin = 3;
			$departamentoMax = 100;
						    
		    // Obtenemos el campo del nombre del departamento, presupuesto y sede a partir de la función "obtenerValorCampo"
		    $nombre = obtenerValorCampo("nombre");
			$presupuesto = obtenerValorCampo("presupuesto");
			$sede = obtenerValorCampo("sede");
	    	//-----------------------------------------------------
	        // Validaciones
	        //-----------------------------------------------------
	        // Nombre del departamento: Debe tener la longitud exigida. Si no, preparad las variables para mostrar el error.
	        if (!validarLongitudCadena($nombre, $departamentoMin ,$departamentoMax)) 
	        {
				$errorDepartamento = true;
	        } 
	        else 
	        {
	        	// En caso de que los datos sean correctos, comprobar que no exita un departamento con ese nombre.
				// Para ello, conectaros a la bbdd, usar el comando SELECT en departamento y buscar el nombre de departamento que se ha introducido.
				// Si el resultado es distinto de nulo, informar de que el departamento ya existe.
	        	
				$conexion = conectarPDO($host, $user, $password, $bbdd);
				$sql = "SELECT * FROM departamentos WHERE nombre LIKE '%$nombre%'";
				$resultado = resultadoConsulta($conexion, $sql);

				if($resultado->rowCount() == 0){
					$error = false;
				}else{
					$errorDepartamento = true;
				}

				$resultado = null;
        		$conexion = null;

	        }

	        // Presupuesto del departamento: entero positivo
	        if (!validarEnteroPositivo($presupuesto)) 
	        {
				$errorPresupuesto = true;
	        }else{
				$error = false;
			} 

	        // Nombre de la sede. Usamos la función validarEnteroPositivo() porque el valor del campo sede será el id.
	        if (!validarEnteroPositivo($sede))
	        {
				$errorSede = true;
	        }else{
				$error = false;
			}
	        
    	}
  	?>

  	<?php
  		//Si hay algún error, tenemos que mostrar los errores en la misma página, manteniendo los valores bien introducidos.
		if ($error || $errorDepartamento || $errorPresupuesto || $errorSede):
  
  	?>
  		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	    	<p>
	            <!-- Campo nombre del departamento -->
	            <input type="text" name="nombre" placeholder="Departamento" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
	            <?php
	            	if ($errorDepartamento){
	            ?>
	            	<p class="error"><?php echo "El nombre no tiene la longitud requerida (3-100) o ya existe un departamento con ese nombre." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo presupuesto del departamento -->
	            <input type="number" name="presupuesto" placeholder="Presupuesto" value="<?php isset($_POST['presupuesto']) ? $_POST['presupuesto'] : ''; ?>">
	            <?php
	            	if ($errorPresupuesto){
	            ?>
	            	<p class="error"><?php echo "El presupuesto tiene que ser un valor positivo." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo nombre de la sede -->
	            <select id="sede" name="sede">
	            	<option value="">Seleccione Sede</option>
	            <?php
					//Conectar a la base de datos para tomar los posibles valores de las sedes.
					
	            	$conexion = conectarPDO($host, $user, $password, $bbdd);
					//Usamos un SELECT para traer los valores del id y en nombre de la sede.
	            	$consulta = "SELECT id, nombre FROM sedes";
	            	
	            	$resultado = resultadoConsulta($conexion, $consulta);

  					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)):
//Usamos el $row para darle los valores al desplegable de las sedes, siendo el id el valor que toma la variable $sede (o como lo hayáis llamado) y el nombre lo que aparece en el desplegable.
  				?>
  					<option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $sede ? "selected" : "" ?>><?php echo $row["nombre"]; ?></option>
  				<?php
  					endwhile;
  					
  					$resultado = null;
        			$conexion = null;
  				?>
  				</select>
  				
	            <?php
	            	if ($errorSede){
	            ?>
	            	<p class="error"><?php echo "Tiene que seleccionar una sede." ?></p>
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

		// Si no hay errores, conectar a la BBDD:
  		else:
  			$conexion = conectarPDO($host, $user, $password, $bbdd);
  			
			// consulta a ejecutar
			$sql = "INSERT INTO departamentos (nombre, presupuesto, sede_id) VALUES (?,?,?)";

			// preparar la consulta (usar bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $nombre);
			$resultado->bindParam(2, $presupuesto);
			$resultado->bindParam(3, $sede);

			// ejecutar la consulta y captura de la excepcion (try/catch)
			$resultado->execute();
			cerrarPDO();
        	// redireccionamos al listado de departamentos
  			header("Location: listado.php");
  			
    	endif;
    ?>
   <div class="contenedor">
        <div class="enlaces">
            <a href="listado.php">Volver al listado de departamentos</a>
        </div>
   </div>
   <?php } ?>
</body>
</html>