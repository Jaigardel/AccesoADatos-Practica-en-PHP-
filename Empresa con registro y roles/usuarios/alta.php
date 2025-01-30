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



$email = "";
$rol = "";

$_SESSION["errorEmail"] = false;
$_SESSION["errorRol"] = false;

if($_SERVER["REQUEST_METHOD"]=="POST"){ //Si no llegamos por POST nos redirige al listado

    //Obtenemos los valores de email y rol del nuevo usuario y comprobamos que sean válidos
    $email = obtenerValorCampo("email");
    $rol = obtenerValorCampo("rol");
    
    //Comprobaciones
    if(!validarEmail($email)){
        $_SESSION["errorEmail"] = true;
    }
    if(!validarEnteroPositivo($rol)){
        $_SESSION["errorRol"] = true;
    }
    

    //Si el email ya está en uso lo damos por malo

    $conexion = conectarPDO($host, $user, $password, $bbdd);
  			
			// consulta a ejecutar
			$sql = "SELECT email FROM usuarios WHERE email = ?";

			// preparar la consulta (usar bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $email);
			// ejecutar la consulta y captura de la excepcion (try/catch)
			$resultado->execute();

            if ($resultado->rowCount() > 0){
                $_SESSION["errorEmail"] = true;
            }
			cerrarPDO();

    //Insert o redirreción si errores

    if($_SESSION["errorEmail"] || $_SESSION["errorRol"]){
        header("Location:nuevo.php");
    }else{
         
        //Si todos los valores son correctos vamos a mandar un enlace por email al nuevo usuario para que pueda activar su cuenta y poner una contraseña

        $token = bin2hex(openssl_random_pseudo_bytes(16));

        $conexion = conectarPDO($host, $user, $password, $bbdd);
  			
			// consulta a ejecutar (IMPORTANTE, hemos añadido un token a la base de datos asociado al email del usuario)
			$sql = "INSERT INTO usuarios (email, token, rol_id) VALUES (?,?,?)";

			// preparar la consulta (usar bindParam)
			$resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $email);
			$resultado->bindParam(2, $token);
			$resultado->bindParam(3, $rol);

			// ejecutar la consulta
			$resultado->execute();
			cerrarPDO();
        	
            $headers = [
                "From" => "dwes@php.com",
                "Content-type" => "text/plain; charset=utf-8"
                ];
                // Variables para el email
                $emailEncode = urlencode($email); //mandamos en la url su email y el token para poder permitir que active su cuenta (usaremos esos valores como validación)
                $tokenEncode = urlencode($token);
                // Texto del email
                $textoEmail = "
                Hola!\n
                Completa el registro para acceder a la mejor plataforma de internet.\
                n
                Para activar entra en el siguiente enlace:\n
                
                http://localhost:3000/Servidor/Aplicacion_Empresa/login/establecer.php?email=$emailEncode&token=$tokenEncode\n
                ";
                // Envio del email
                mail($email, 'Activa tu cuenta', $textoEmail, $headers);
                /* Redirección a listado.php */
                header('Location: listado.php');
                exit();
    }

}else{
    header("Location:listado.php");
}
}

?>