<?php 
$usuario = $_POST['usuario'];
//Libreria de la base de datos
include_once('librerias/info.php');
//Se elimina el usuario de la base de datos
$query = "DELETE FROM personal WHERE nombre='$usuario'";


$statement = $db->prepare($query);
$statement->execute();
$statement->closeCursor();
    
header('Location: admin.php');
?>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->