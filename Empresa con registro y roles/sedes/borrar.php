<?php
// Activa las sesiones
session_name("sesion-privada");
session_start();
// Comprueba si existe la sesión "email", en caso contrario vuelve a la página de login
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != 1){ //Si no somos ADMIN nos muestra un mensaje de acceso denegado y redirigimos a index
    echo "<h1 style='color: red'>Acceso Denegado.</h1>";
    header("Refresh: 3; url=../index.php");
}else{ 

    require_once("../utiles/variables.php");
    require_once("../utiles/funciones.php");

    //Si se ha seleccionado un registro para borrar
    if (count($_REQUEST) > 0)
    {

        if (isset($_GET["idSede"]))
        {
            //Declarar la variable para la sedeque tomará el valor del $_GET, conectar a la BBDD, definir la consulta a ejecutar (DELETE), 
            $id = obtenerValorCampo("idSede");
            $conexion = conectarPDO($host, $user, $password, $bbdd);
            $sql = "DELETE FROM sedes WHERE id=?";
            $resultado = $conexion->prepare($sql);
            $resultado->bindParam(1, $id);
            //preparar la consulta (bindParam) y ejecutarla
            $resultado->execute();
            //Si todo ha ido bien, mostrar mensaje
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
            //En ambos casos, redireccionar al listado original tras 3 segundos.
            header("Refresh: 3; url=listado.php");
        } 
        
    } 
    //Evitar que se pueda entrar directamente a la página .../borrar.php, redireccionando en tal caso a la página del listado
    else 
    {
        header("Location: listado.php");
    }
}
?>