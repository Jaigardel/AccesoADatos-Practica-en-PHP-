<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();

	require_once("../utiles/variables.php");
    require_once("../utiles/funciones.php");

    //Primero se rellena un formulario que si se completa con éxito mandará un email al usuario con una URL para actualizar su contraseña

    $_SESSION["errorEmail"] = false; //La primera vez que carga, el valor de la variable es FALSE

    if ($_SERVER["REQUEST_METHOD"]=="POST"){

        //Obtenemos el valor de email del formulario
        $email = obtenerValorCampo("email");

        if(!validarEmail($email)){//Si no es válido se modifica la variable de error a TRUE
            $_SESSION["errorEmail"] = true;
        }else{
            //Comprobamos que el email sea de un usuario de nuestra aplicación
            $conexion = conectarPDO($host, $user, $password, $bbdd);
            $sql = "SELECT email FROM usuarios WHERE email=?";
            $resultado = $conexion->prepare($sql);
			$resultado->bindParam(1, $email);
            $resultado->execute();
            if($resultado->rowCount() != 1){ //Si no lo es, se mostrará un mensaje de error en el formulario
                $_SESSION["errorEmail"] = true;
            }else{
                cerrarPDO();
                //Creamos un token que mandaremos al usuario
                $token = bin2hex(openssl_random_pseudo_bytes(16));

                //Actualizamos la tabla del usuario, modificamos el token a uno nuevo (el que acabamos de crear) e inactivamos la cuenta
                $conexion = conectarPDO($host, $user, $password, $bbdd);
                $sql = "UPDATE usuarios SET activo=0, token=? WHERE email=?";
                $resultado = $conexion->prepare($sql);
                $resultado->bindParam(1, $token);
                $resultado->bindParam(2, $email);
                $resultado->execute();
                if($resultado->rowCount() > 0) 
                {//Si la actualización ha funcionado, mostramos un mensaje y mandamos un email al usuario con una URL que incluye su email y token (para validaciones)   
                    echo "<h1>Operación realizada con éxito, comprueba tu correo para cambiar la contraseña.</h1>";
                    $headers = [
                        "From" => "dwes@php.com",
                        "Content-type" => "text/plain; charset=utf-8"
                        ];
                        // Variables para el email
                        $emailEncode = urlencode($email);
                        $tokenEncode = urlencode($token);
                        // Texto del email
                        $textoEmail = "
                        Hola!\n
                      
                        Para actualizar la contraseña entra en el siguiente enlace:\n
                        
                        http://localhost:3000/Servidor/Aplicacion_Empresa/login/establecer.php?email=$emailEncode&token=$tokenEncode\n
                        ";
                        // Envio del email
                        mail($email, 'Activa tu cuenta', $textoEmail, $headers);
                } 
                //Si no ha ido bien, mostrar mensaje 
                else 
                {
                    echo "<h1>No se ha podido realizar la operación.</h1>";
                }
                cerrarPDO();
                
                /* Redirección a login.php con GET para informar del envío del email */
                header("Refresh: 3; url=login.php");
                exit();
            }
        }
    } 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordar contraseña</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <h1>Recordar Contraseña</h1>
    

    
        <!-- Formulario de identificación -->
        <form action="recordar.php" method="post">
            <p>
                <input type="text" name="email" placeholder="Email"> 
            </p>
            <?php if($_SESSION["errorEmail"]){?>
                <p class="error">El email no es válido o no existe</p>
            <?php }?>
            <p>
                <input type="submit" value="Recordar"> 
            </p>
        </form>
        <p><a href="login.php">Volver al Login</a></p>
</body>
</html>
