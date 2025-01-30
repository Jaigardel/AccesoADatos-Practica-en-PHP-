<?php
//Si no existe la variable se crea y se deja como FALSE
if(!isset($_SESSION["errorClave"])){
    $_SESSION["errorClave"] = false;
}
require_once("../utiles/variables.php");
require_once("../utiles/funciones.php");

//Obtenemos los valores de email y token de la URL del email que hemos enviado al usuario
$email = obtenerValorCampo("email");
$token = obtenerValorCampo("token");
$longitudMinima = 4;
$logintudMaxima = 20;

//Comprobamos el valor del token correspondiente a ese email en la base de datos
$conexion = conectarPDO($host, $user, $password, $bbdd);
            $sql = "SELECT token FROM usuarios WHERE email=?";
            $resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $email);
            $resultado->execute();
            if($resultado->rowCount()>0){
                $row = $resultado->fetch();
                $tokenBBDD = $row["token"];
                cerrarPDO();
            }
            
if($email == "" || $token == ""){ //Si alguno de los campos es una cadena vacía se muestra un mensaje y se redirige a login
    echo "<h1 style='color: red'>Acceso Denegado.</h1>";
    header("Refresh: 3; url=login.php");
    exit();
}elseif($token != $tokenBBDD){ //Si el valor de token difiere del de la base de datos se muestra un mensaje y se redirige a login
    echo "<h1 style='color: red'>Error de autenticación, el enlace no es válido despues de un uso.</h1>";
    header("Refresh: 3; url=login.php");
    exit();
}else{ //Si pasa todas pasa estas comprobaciones, se muestra un formulario para ingresar las nuevas contraseñas
    if($_SERVER["REQUEST_METHOD"] == "POST"){// Una vez completado el formulario, comprobamos los datos introducidos
        //Obtenemos los valores introducidos en el formulario 
        $clave1 = obtenerValorCampo("clave1");
        $clave2 = obtenerValorCampo("clave2");

        if($clave1 != $clave2){ //Si las claves son diferentes se recargará el formulario mostrando un mensaje de error
            $_SESSION["errorClave"] = true;
        }elseif(!validarLongitudCadena($clave1, $longitudMinima, $logintudMaxima)){ //Si la longitud de la contraseña no es válida, se recargará el formulario mostrando un mensaje de error
            $_SESSION["errorClave"] = true;
        }else{
            //Si la clave es válida, procedemos a activar la cuenta y a actualizar la constraseña
                $clave = password_hash($clave1, PASSWORD_BCRYPT);
                    $conexion = conectarPDO($host, $user, $password, $bbdd);
                    $sql = "UPDATE usuarios SET activo=1, password=? , token = null WHERE email=?";
                    $resultado = $conexion->prepare($sql);
                    $resultado->bindParam(1, $clave);
                    $resultado->bindParam(2, $email);
                    $resultado->execute();
                    if($resultado->rowCount() > 0) 
                    {               
                        echo "<h1>Operación realizada con éxito.</h1>";
                    } 
                    //Si no ha ido bien, mostrar mensaje 
                    else 
                    {
                        echo "<h1>No se ha podido realizar la operación.</h1>";
                    }
                    cerrarPDO();
                    header("Refresh: 3; url=login.php");
                    exit();                

        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer contraseña</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <h1>Nueva Contraseña</h1>     
    <!-- Formulario de identificación -->
    <form action="establecer.php" method="post">
        <p>
            Nueva Contraseña: <input type="text" name="clave1" placeholder="Contraseña"> 
        </p>
        <?php if($_SESSION["errorClave"]){ //Si hay algún error se muestra un mensaje?>
                <p class="error">La clave no tiene entre 4 y 8 caracteres o no coincide</p>
            <?php }?>
        <p>
            Repita Contraseña: <input type="text" name="clave2" placeholder="Contraseña"> 
        </p>
        <?php if($_SESSION["errorClave"]){?>
                <p class="error">La clave no tiene entre 4 y 8 caracteres o no coincide</p>
            <?php }?> 
        <p>
            <input type="submit" value="Establecer"> 
        </p>
        <p><input type="hidden" name="email" value="<?php echo $email?>"><input type="hidden" name="token" value="<?php echo $token?>"></p>
    </form>
    <p><a href="login.php">Volver al Login</a></p>
</body>
</html>
<?php }?>