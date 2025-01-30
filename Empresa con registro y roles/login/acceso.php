<?php 
// Incluye ficheros de variables y funciones
require_once("../utiles/variables.php");
require_once("../utiles/funciones.php");

// Comprobamos que nos llega los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $baseDeDatos = [];
// Base de datos ficticia que se usará en el ejemplo.
$email = obtenerValorCampo("email");
$contrasena = "";
$conexion = conectarPDO($host, $user, $password, $bbdd);
$sql = "SELECT password, rol_id, activo FROM usuarios WHERE email=?";
$resultado = $conexion->prepare($sql);
$resultado->bindParam(1, $email);
$resultado->execute();
if ($resultado->rowCount() > 0){
    $row = $resultado->fetch();
    $contrasena = $row["password"];
    $rol = $row["rol_id"];
    $activo = $row["activo"];
    cerrarPDO();
}
// Variables del formulario

$contrasenaFormulario = isset($_REQUEST['contrasena']) ? $_REQUEST['contrasena'] : null;


// Comprobamos si los datos son correctos
if (password_verify($contrasenaFormulario, $contrasena) && $activo == 1) {
    // Si son correctos, creamos la sesión
    session_name("sesion-privada");
    session_start();
    $_SESSION['rol'] = $rol;
    header('Location: ../index.php');
    exit();
    }
    else {
    // Si no son correctos, informamos al usuario
    print'<p style="color: red">El email o la contraseña es incorrecta.</p>';
    header("refresh:3;url=login.php");
	exit();
    }
}else{
    header("Location: login.php");
}
?>