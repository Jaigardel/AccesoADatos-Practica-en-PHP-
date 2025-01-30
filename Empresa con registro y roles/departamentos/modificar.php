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
    <title>Modificar departamento</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
	<header>
        <h1>Modificar departamento</h1><button onclick="window.location.href='../login/cerrar-sesion.php'">Cerrar Sesión</button>
    </header>
    <?php
		// crea las variables para la comprobación de los datos y conectamos con la BBDD para obtener y pintar los datos de la id que acabamos de enviar a la página
		$errores = [];
    	$comprobarValidacion = false;
    	$id = "";
	    $nombre = "";
		$presupuesto = "";
		$sede = "";

    	if (count($_REQUEST) > 0) 
    	{
    		if (isset($_GET["idDepartamento"])) 
    		{
				$comprobarValidacion = true;
            	$id = $_GET["idDepartamento"];

            	//Conectamos a la BBDD
				$conexion = conectarPDO($host, $user, $password, $bbdd);
        		// Montamos la consulta a ejecutar
				$sql = "SELECT * FROM departamentos WHERE id=?";
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
					$presupuesto = $row["presupuesto"];
					$sede = $row["sede_id"];
					cerrarPDO();
				}
            } 
            else 
            {
		    	// Comenzamos la comprobación de los datos introducidos.
				// Creamos las variables con los requisitos de cada campo
				$departamentoMin = 3;
				$departamentoMax = 100;
			    
			    // Obtenemos el campo del departamento, presupuesto y sede
				$id = obtenerValorCampo("id");
			    $nombre = obtenerValorCampo("nombre");
				$presupuesto = obtenerValorCampo("presupuesto");
				$sede = obtenerValorCampo("sede");
			 
				 //-----------------------------------------------------
		        // Validaciones
		        //-----------------------------------------------------
				// Comprueba que el id del departamento se corresponde con uno que tengamos 
				//conectamos a la bbdd
				$conexion = conectarPDO($host, $user, $password, $bbdd);
	        	// preparamos la consulta SELECT a ejecutar
				$sql = "SELECT * FROM departamentos WHERE id=?";
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
				cerrarPDO();
		        // Nombre del departamento: validamos la longitud. Si no es correcta, generamos el error.
		        if (!validarLongitudCadena($nombre, $departamentoMin ,$departamentoMax)) 
		        {
					$errores["nombre"] = "La longitud del nombre tiene que ser entre 3 y 100 caracteres.";
		        } 
		        else 
		        {
		        	// Comprobar que no exita un departamento con ese nombre.
					//Para ello, te conectas a la bbdd, ejecutas un SELECT y comprueba si hay ya un departamento con ese nombre.
		        	$conexion = conectarPDO($host, $user, $password, $bbdd);
					$sql = "SELECT * FROM departamentos WHERE nombre=? AND id !=?";
					$resultado = $conexion->prepare($sql);
					$resultado->bindParam(1, $nombre);
					$resultado->bindParam(2, $id);
					$resultado->execute();
					// comprobamos si, al ejecutar la consulta, tenemos más de un registro. En tal caso, generar el mensaje de error.
					if ($resultado->rowCount() > 0)
					{
						$errores["repetido"] = "Ese departamento ya existe. Elija otro nombre.";
					}
					cerrarPDO();
		        }

		        // Presupuesto del departamento: Validamos que sea entero positivo.
		        if (!validarEnteroPositivo($presupuesto)) 
		        {
		            $errores["presupuesto"] = "El presupuesto tiene que ser un entero positivo.";
		        } 

		        // Nombre de la sede: : Validamos que sea entero positivo (el id)
		        if (!validarEnteroPositivo($sede))
		        {
					$errores["sede"] = "Tiene que elegir una sede válida.";
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
	            <!-- Campo nombre del departamento -->
	            <input type="text" name="nombre" placeholder="Departamento" value="<?php echo $nombre; ?>">
	            <?php
	            	if(isset($errores["nombre"])){
	            ?>
	            	<p class="error"><?php echo $errores["nombre"]; ?></p>
	            <?php
	            	}elseif(isset($errores["repetido"])){
	            ?>
					<p class="error"><?php echo $errores["repetido"]; ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo presupuesto del departamento -->
	            <input type="number" name="presupuesto" placeholder="Presupuesto" value="<?php echo $presupuesto; ?>">
	            <?php
	            	if(isset($errores["presupuesto"])){
	            ?>
	            	<p class="error"><?php echo $errores["presupuesto"]; ?></p>
	            <?php
	            	};
	            ?>
	        </p>
	        <p>
	            <!-- Campo nombre de la sede -->
	            <select id="sede" name="sede">
	            	<option value="">Seleccione Sede</option>
	            <?php
	            	//Conectamos a la bbdd y hacemos un SELECT de las sedes para que aparezca en el desplegable del formulario.
					$conexion = conectarPDO($host, $user, $password, $bbdd);
					$sql = "SELECT id, nombre FROM sedes";
					$resultado = resultadoConsulta($conexion, $sql);
  					// Terminamos usando:
					while ($row = $resultado->fetch(PDO::FETCH_ASSOC)):
  				?>
  					<option value="<?php echo $row["id"]; ?>"  <?php echo $row["id"] == $sede ? "selected" : "" ?>><?php echo $row["nombre"]; ?></option>
  				<?php
  					endwhile;
  				
  				?>
  				</select>
  				
	            <?php
	            	if(isset($errores["sede"])){
	            ?>
	            	<p class="error"><?php echo $errores["sede"]; ?></p>
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
		// Si no hay errores
  		else:
  			//Nos conectamos a la BBDD
			$conexion = conectarPDO($host, $user, $password, $bbdd);
			// Creamos una variable con la consulta "UPDATE" a ejecutar
			$sql = "UPDATE departamentos SET nombre=?, presupuesto=?, sede_id=? WHERE id=?";
			// preparamos la consulta (bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $nombre);
			$resultado->bindParam(2, $presupuesto);
			$resultado->bindParam(3, $sede);
			$resultado->bindParam(4, $id);
			// ejecutamos la consulta 
			try 
			{
				$resultado->execute();
			}
			catch (PDOException $exception)
			{
           		exit($exception->getMessage());
        	}

			$resultado = null;

			$conexion = null;

        	// redireccionamos al listado de departamentos
  			header("Location: listado.php");
  			
    	endif;
    ?>
    <div class="contenedor">
        <div class="enlaces">
            <a href="listado.php">Volver al listado de departamentos</a>
        </div>
   	</div>
    <?php }?>
</body>
</html>