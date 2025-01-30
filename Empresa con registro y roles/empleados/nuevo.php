<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "rol", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"]) || ($_SESSION["rol"] != 1) && $_SESSION["rol"] != 2){ //Si no somos ADMIN o GESTOR nos muestra un mensaje de acceso denegado y redirigimos a index
    echo "<h1 style='color: red'>Acceso Denegado.</h1>";
    header("Refresh: 3; url=../index.php");
}else{

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
    <title>Alta nuevo empleado</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Alta nuevo empleado</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php
	// Crea las variables necesarias para introducir los campos y comprobar errores.

    	$error = true;
		$errorNombre = false;
		$errorApellidos = false;
		$errorEmail = false;
		$errorHijos = false;
		$errorSalario = false;
		$errorDepartamento = false;
		$errorNacionalidad = false;
    	$limiteInferiorHijos = 0;
    	$limiteSuperiorHijos = 10;
    	$nombre = "";
    	$longitudMinimaNombre = 3;
		$longitudMaximaNombre = 50;
    	$apellidos = "";
    	$longitudMinimaApellidos = 3;
		$longitudMaximaApellidos = 150;
    	$email = "";
    	$longitudMaximaEmail = 120;
    	$salario = "";
    	$hijos = "";
    	$nacionalidad = "";
    	$departamento = "";

    	if ($_SERVER["REQUEST_METHOD"]=="POST")
    	{
		    
		 // Obtenemos los diferentes campos del formulario a partir de la función "obtenerValorCampo"
		  $nombre = obtenerValorCampo("nombre");
		  $apellidos = obtenerValorCampo("apellidos");
		  $email = obtenerValorCampo("email");
		  $salario = obtenerValorCampo("salario");
		  $hijos = obtenerValorCampo("numeroHijos");
    	  $nacionalidad = obtenerValorCampo("nacionalidad");
    	  $departamento = obtenerValorCampo("departamento");
		    
	    	//-----------------------------------------------------
	        // Validaciones
	        //-----------------------------------------------------
	        // Nombre del empleado: Debe tener la longitud exigida. Si no, preparad las variables para mostrar el error.
	        if (!validarLongitudCadena($nombre, $longitudMinimaNombre ,$longitudMaximaNombre)) 
	        {
	            $errorNombre = true;
	        }else{
				$error = false;
			}

	        // Apellidos del empleado: Debe tener la longitud exigida. Si no, preparad las variables para mostrar el error.
	        if (!validarLongitudCadena($apellidos, $longitudMinimaApellidos, $longitudMaximaApellidos))
	        {
	            $errorApellidos = true;
	        }else{
				$error = false;
			}
	        

	        // Correo electrónico del empleado: Debe ser un email válido y con la longitud correcta. Si no, preparad las variables para mostrar el error.
	        if (!validarEmail($email))
	        {
	            $errorEmail = true;
	        }
	        elseif (strlen($email)>$longitudMaximaEmail)
	        {
				$errorEmail = true;
	        }else{
				$error = false;
			}

	        // El número de hijos del empleado a partir de la función "validarEnteroLimites"
	        if (!validarEnteroLimites($hijos, $limiteInferiorHijos,$limiteSuperiorHijos))
	        {
	            $errorHijos = true;
	        }else{
				$error = false;
			}

	        // Salario del empleado a partir de la función "validarDecimalPositivo"
	        if (!validarDecimalPositivo($salario))
	        {
	            $errorSalario = true;
	        }else{
				$error = false;
			} 


	        // Nombre del departamento a partir de la función "validarEnteroPositivo", ya que usaremos el id
	        if (!validarEnteroPositivo($departamento))
	        {
	            $errorDepartamento = true;
	        }else{
				$error = false;
			} 
	        
	        // Nacionalidad del empleado a partir de la función "validarEnteroPositivo", ya que usaremos el id
	        if (!validarEnteroPositivo($nacionalidad))
	        {
				$errorNacionalidad = true;
	        }else{
				$error = false;
			} 
	        
    	}
  	?>

  	<?php
  		//Si hay algún error, tenemos que mostrar los errores en la misma página, manteniendo los valores bien introducidos.
		if ($error || $errorNombre ||$errorApellidos || $errorEmail || $errorSalario || $errorHijos || $errorDepartamento || $errorNacionalidad):
  
  	?>
  		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	    	<p>
	            <!-- Campo nombre del empleado -->
	            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
	            <?php
	            	if ($errorNombre){
	            ?>
	            	<p class="error"><?php echo "Longitud del nombre incorrecta (3-50)."; ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo apellidos del empleado -->
	            <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : ''; ?>">
	            <?php
	            	if ($errorApellidos){
	            ?>
	            	<p class="error"><?php echo "Longitud de apellidos incorrecta (3-150)." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo correo electrónico del empleado -->
	            <input type="text" name="email" placeholder="Correo electrónico" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
	            <?php
	            	if ($errorEmail){
	            ?>
	            	<p class="error"><?php echo "Introduzca un email de menos de 150 caracteres." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo salario del empleado -->
	            <input type="number" step="0.01" name="salario" placeholder="Salario" value="<?php echo isset($_POST['salario']) ? $_POST['salario'] : ''; ?>">
	            <?php
	            	if ($errorSalario){
	            ?>
	            	<p class="error"><?php echo "Intruduzca un salario positivo." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo número de hijos del empleado -->
	            <input type="number" name="numeroHijos" placeholder="Número de hijos" value="<?php echo isset($_POST['numeroHijos']) ? $_POST['numeroHijos'] : ''; ?>">
	            <?php
	            	if ($errorHijos){
	            ?>
	            	<p class="error"><?php echo "Introduzca un número de hijos entre 0 y 10." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo nacionalidad del empleado -->
	            <select id="nacionalidad" name="nacionalidad">
	            	<option value="">Seleccione Nacionalidad</option>
	            <?php
				//Conectar a la base de datos para tomar los posibles valores de las nacionalidades.
	            	$conexion = conectarPDO($host, $user, $password, $bbdd);

				//Usamos un SELECT para traer los valores del id y la nacionalidad (ordenar por nacionalidad).
					$sql = "SELECT id, nacionalidad FROM paises";
					
				//Obtenemos el resultado de la consulta con la función "resultadoConsulta($conexion, $consulta)"
					$resultado = resultadoConsulta($conexion, $sql);
					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)){
  				?>
  					<option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $nacionalidad ? "selected" : ""?>><?php echo $row["nacionalidad"]; ?></option>
  				<?php
  					};

  					$resultado = null;
        			$conexion = null;
  				?>
  				</select>
  				
	            <?php
	            	if ($errorNacionalidad){
	            ?>
	            	<p class="error"><?php echo "Seleccione una nacionalidad." ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo departamento del empleado -->
	            <select id="departamento" name="departamento">
	            	<option value="">Seleccione Departamento</option>
	            <?php
	            	//Conectar a la base de datos para tomar los posibles valores de las nacionalidades.
	            	$conexion = conectarPDO($host, $user, $password, $bbdd);

				//Usamos un SELECT para traer los valores del id y la nacionalidad (ordenar por nacionalidad).
					$sql = "SELECT id, nombre FROM departamentos";
				//Obtenemos el resultado de la consulta con la función "resultadoConsulta($conexion, $consulta)"
					$resultado = resultadoConsulta($conexion, $sql);
					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)){
  				?>
  					<option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $departamento ? "selected" : ""?>><?php echo $row["nombre"]; ?></option>
  				<?php
  					};
  					
  					$resultado = null;
        			$conexion = null;
  				?>
  				</select>
  				
	            <?php
	            	if ($errorDepartamento){
	            ?>
	            	<p class="error"><?php echo "Seleccione un departamento." ?></p>
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
  			
			// consulta a ejecutar (insert)
			$sql = "INSERT INTO empleados (nombre, email, apellidos, salario, hijos, departamento_id, pais_id) VALUES (?,?,?,?,?,?,?)";

			// preparar la consulta (usar bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $nombre);
			$resultado->bindParam(2, $email);
			$resultado->bindParam(3, $apellidos);
			$resultado->bindParam(4, $salario);
			$resultado->bindParam(5, $hijos);
			$resultado->bindParam(6, $departamento);
			$resultado->bindParam(7, $nacionalidad);
			
			// ejecutar la consulta y captura de la excepcion
			$resultado->execute();
			cerrarPDO();

        	// redireccionamos al listado de departamentos
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