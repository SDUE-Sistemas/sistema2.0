<?php 
include_once('librerias/elimina_acentos.php');
$usuario = $_POST['usuario'];

include_once('librerias/info.php');
$query = "DELETE FROM personal WHERE nombre='$usuario'";


$statement = $db->prepare($query);
$statement->execute();
$statement->closeCursor();
    
header('Location: admin.php');
?>