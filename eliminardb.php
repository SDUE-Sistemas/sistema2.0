<?php
//Librerias para la base de datos y el Usuario
include_once("librerias/info.php");
require_once("librerias/control_usuario.php");
if($usuario['esadmin']==1){
//Verificando que el usuario verdaderamente sea administrador y no se quiera pasar de listo borrando todo

$query="TRUNCATE TABLE reportes";
    $statement = $db->prepare($query); 
    $statement->execute();
    $statement->closeCursor();
    //El usuario si es admin entonces si se vacia la base de datos
    header("Location: admin.php");
}else{
    
    ?>
    <script>
    //No es admin no puede eliminar la base de datos
    alert("No puede realizar esta accion");
    location.href="capturar.php";
    </script>
    <?php    
 
}
?>

<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 xd-->