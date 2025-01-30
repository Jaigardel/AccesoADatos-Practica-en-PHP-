<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"]) || ($_SESSION["rol"] != 1) && $_SESSION["rol"] != 2){//Si no somos ADMIN o GESTOR nos muestra un mensaje de acceso denegado y redirigimos a index
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
    <title>Modificar empleado</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
<body>
    <header>
        <h1>Modificar empleado</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php
		// crea las variables para la comprobación de los datos y conectamos con la BBDD para obtener y pintar los datos de la id que acabamos de enviar a la página
		$errores = [];
    	$comprobarValidacion = false;
    	$id = "";
		$nombre = "";
		$apellidos = "";
		$email = "";
		$salario = "";
		$hijos = "";
		$departamento = "";
		$nacionalidad = "";    	

    	if (count($_REQUEST) > 0) 
    	{

    		if (isset($_GET["idEmpleado"])) 
    		{
				$comprobarValidacion = true;
            	$id = $_GET["idEmpleado"];

            	//Obtenemos los datos del empleado. Para ello
            	//Conectamos a la BBDD
				$conexion = conectarPDO($host, $user, $password, $bbdd);
        		// Montamos la consulta a ejecutar
				$sql = "SELECT * FROM empleados WHERE id=?";
		        // prepararamos la consulta
				$resultado = $conexion->prepare($sql);
		        // parámetro (usamos bindParam)
				$resultado->bindParam(1, $id);
		        // ejecutamos la consulta 
				$resultado->execute();
		        // comprobamos si hay algún registro 
				if ($resultado->rowCount() == 0)
				{
					//Si no lo hay, desconectamos y volvemos al listado original
					cerrarPDO();
					header("Location: listado.php");
				}
				else 
				{
					// Si hay algún registro, Obtenemos el resultado (usamos fetch())
			        $row = $resultado->fetch();
					$nombre = $row["nombre"];
					$apellidos = $row["apellidos"];
					$email = $row["email"];
					$salario = $row["salario"];
					$hijos = $row["hijos"];
					$nacionalidad = $row["pais_id"];
					$departamento = $row["departamento_id"];
					cerrarPDO();
				}

            } 
            else 
            {
				// Comenzamos la comprobación de los datos introducidos.
				$id = obtenerValorCampo("id");
				$nombre = obtenerValorCampo("nombre");
				$apellidos = obtenerValorCampo("apellidos");
				$email = obtenerValorCampo("email");
				$salario = obtenerValorCampo("salario");
				$hijos = obtenerValorCampo("numeroHijos");
				$departamento = obtenerValorCampo("departamento");
				$nacionalidad = obtenerValorCampo("nacionalidad");
				// Creamos las variables con los requisitos de cada campo (función "obtenerValorCampo")
    			$limiteInferiorHijos = 0;
				$limiteSuperiorHijos = 10;
				$longitudMinimaNombre = 3;
				$longitudMaximaNombre = 50;
				$longitudMinimaApellidos = 3;
				$longitudMaximaApellidos = 150;
				$longitudMaximaEmail = 120;
			    
		    	//-----------------------------------------------------
		        // Validaciones
		        //-----------------------------------------------------
		        // Compruebo que el id del empleado se corresponde con uno que tengamos 
	        	//conectamos a la bbdd
				$conexion = conectarPDO($host, $user, $password, $bbdd);
	        	// preparamos la consulta SELECT a ejecutar
				$sql = "SELECT * FROM empleados WHERE id=?";
				// preparamos la consulta (bindParam)
				$resultado = $conexion->prepare($sql);
				$resultado->bindParam(1, $id);
				// ejecutamos la consulta 
				$resultado->execute();
				// comprobamos si algún registro 
				if ($resultado->rowCount() == 0)
				{
					//Si no lo hay, desconectamos y volvemos al listado original
					cerrarPDO();
					header("Location: listado.php");
				}
		        // Nombre del empleado: validamos la longitud. Si no es correcta, generamos el error.
		        if (!validarLongitudCadena($nombre, $longitudMinimaNombre ,$longitudMaximaNombre)) 
		        {
					$errores["nombre"] = "La longitud del nombre tiene que estar entre 3 y 50 caracteres.";
		        }

		        // Apellidos del empleado: validamos la longitud. Si no es correcta, generamos el error.
		        if (!validarLongitudCadena($apellidos, $longitudMinimaApellidos ,$longitudMaximaApellidos)) 
		        {
					$errores["apellidos"] = "La longitud del apellido tiene que estar entre 3 y 150 caracteres.";
		        }

		        // Correo electrónico del empleado: validamos que sea un email (validarEmail) y la longitud máxima.
		        if (!validarEmail($email))
		        {
		            $errores["noValido"] = "Introduzca un email válido.";
		        }
		        elseif (strlen($email)>$longitudMaximaEmail)
		        {
					$errores["email"] = "El email no puede contener más de 120 caracteres.";
		        }

		        // El número de hijos del empleado: validamos con validarEnteroLimites()
		        if (!validarEnteroLimites($hijos, $limiteInferiorHijos,$limiteSuperiorHijos))
		        {
		           $errores["hijos"]= "Elija una opción entre 0 y 10.";
		        }

		        // Salario del empleado: validamos que sea decimal positivo validarDecimalPositivo().
		        if (!validarDecimalPositivo($salario))
		        {
		            $errores["salario"] = "El salario tiene que ser un número postivo";
		        } 

		        // Nombre del departamento (el id): validamos con validarEnteroLimites()
		        if (!validarEnteroPositivo($departamento))
		        {
					$errores["departamento"] = "Elija un departamento.";
		        }
		        

		        // Nacionalidad del empleado (el id): validamos con validarEnteroLimites()
		        if (!validarEnteroPositivo($nacionalidad))
		        {
		            $errores["nacionalidad"] = "Elija una nacionalidad";
		        }
		    }
    	}
  	?>

  	<?php
  		//Si hay errores, pintarlos en el correspondiente campo:
		if($comprobarValidacion || count($errores) != 0):
  	?>
  		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  			<input type="hidden" name="id" value="<?php echo $id; ?>">
	    	<p>
	            <!-- Campo nombre del empleado -->
	            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
	            <?php
	            	if(isset($errores["nombre"])){
	            ?>
	            	<p class="error"><?php echo $errores["nombre"] ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo apellidos del empleado -->
	            <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $apellidos; ?>">
	            <?php
	            	if (isset($errores["apellidos"])){
	            ?>
	            	<p class="error"><?php echo $errores["apellidos"] ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo correo electrónico del empleado -->
	            <input type="text" name="email" placeholder="Correo electrónico" value="<?php echo $email; ?>">
	            <?php
	            	if (isset($errores["email"])){
	            ?>
	            	<p class="error"><?php echo $errores["email"] ?></p>
	            <?php
	            	}elseif(isset($errores["noValido"])){;
	            ?>
					<p class="error"><?php echo $errores["noValido"] ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo salario del empleado -->
	            <input type="number" step="0.01" name="salario" placeholder="Salario" value="<?php echo $salario; ?>">
	            <?php
	            	if (isset($errores["salario"])){
	            ?>
	            	<p class="error"><?php echo $errores["salario"] ?></p>
	            <?php
					};
	            ?>
	        </p>
	        <p>
	            <!-- Campo número de hijos del empleado -->
	            <input type="number" name="numeroHijos" placeholder="Número de hijos" value="<?php echo $hijos; ?>">
	            <?php
	            	if (isset($errores["hijos"])){
	            ?>
	            	<p class="error"><?php echo $errores["hijos"] ?></p>
	            <?php
					};
	            ?>
	        </p>
	        <p>
	            <!-- Campo nacionalidad del empleado -->
	            <select id="nacionalidad" name="nacionalidad">
	            	<option value="">Seleccione Nacionalidad</option>
	            <?php
				//nos conectamos a la bbdd y pintamos las diferentes nacionalidades en el desplegable, ordenado por nacionalidad.
	            	$conexion = conectarPDO($host, $user, $password, $bbdd);

	            	$consulta = "SELECT id, nacionalidad FROM paises ORDER BY nacionalidad";
	            	
	            	$resultado = resultadoConsulta($conexion, $consulta);

  					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)){
  				?>
  					<option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $nacionalidad ? "selected" : "" ?>><?php echo $row["nacionalidad"]; ?></option>
  				<?php
					};

  					cerrarPDO();
  				?>
  				</select>
  				
	            <?php
	            	if(isset($errores["nacionalidad"])){
	            ?>
	            	<p class="error"><?php echo $errores["nacionalidad"] ?></p>
	            <?php
					};
	            ?>
	        </p>
	        <p>
	            <!-- Campo departamento del empleado -->
	            <select id="departamento" name="departamento">
	            	<option value="">Seleccione Departamento</option>
	            <?php
				//nos conectamos a la bbdd y pintamos los diferentes departamentos en el desplegable, ordenado por el nombre del departamento.
	            	$conexion = conectarPDO($host, $user, $password, $bbdd);

	            	$consulta = "SELECT id, nombre FROM departamentos ORDER BY nombre";
	            	
	            	$resultado = resultadoConsulta($conexion, $consulta);

  					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)){
  				?>
  					<option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $departamento ? "selected" : ""?>><?php echo $row["nombre"]; ?></option>
  				<?php
					};
  					
  					cerrarPDO();
  				?>
  				</select>
  				
	            <?php
	            	if(isset($errores["departamento"])){
	            ?>
	            	<p class="error"><?php echo $errores["departamento"] ?></p>
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
			$sql = "UPDATE empleados SET nombre=?, email=?, apellidos=?, salario=?, hijos=?, departamento_id=?, pais_id=? WHERE id=?";
			// preparamos la consulta (bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $nombre);
			$resultado->bindParam(2, $email);
			$resultado->bindParam(3, $apellidos);
			$resultado->bindParam(4, $salario);
			$resultado->bindParam(5, $hijos);
			$resultado->bindParam(6, $departamento);
			$resultado->bindParam(7, $nacionalidad);
			$resultado->bindParam(8, $id);
			// ejecutamos la consulta 
			// ejecutar la consulta y mostramos el error
			try 
			{
				$resultado->execute();
			}
			catch (PDOException $exception)
			{
           		exit($exception->getMessage());
        	}

			cerrarPDO();

        	// redireccionamos al listado de empleados
  			header("Location: listado.php");
  			
    	endif;
    ?>
    <div class="contenedor">
        <div class="enlaces">
            <a href="listado.php">Volver al listado de empleados</a>
        </div>
   	</div>
    <?php }?>
</body>
</html>