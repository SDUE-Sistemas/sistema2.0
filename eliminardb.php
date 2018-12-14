<?php
include_once("librerias/info.php");
require_once("librerias/control_usuario.php");
if($usuario['esadmin']==1){
$query="TRUNCATE TABLE reportes";
    $statement = $db->prepare($query); 
    $statement->execute();
    $statement->closeCursor();
    header("Location: admin.php");
}else{
    
    ?>
    <script>
    alert("No puede realizar esta accion");
    location.href="capturar.php";
    </script>
    <?php    
 
}
?>