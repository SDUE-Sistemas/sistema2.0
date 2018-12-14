<?php
include_once("librerias/info.php");
require_once("librerias/control_usuario.php");
require_once("librerias/elimina_acentos.php");
$detalles=elimina_acentos($_POST['detalles']);
$fecha_atiende=quita_diagonal($_POST['fecha']);
$personal = $_POST['personal_atiende'];
$causa=$_POST['causa'];
$folio=$_POST['folio'];
$query="UPDATE reportes 
        SET personal_atiende ='".$personal."' WHERE folio = $folio";
    $statement = $db->prepare($query); 
    $statement->execute();
    $statement->closeCursor();
    header("location:sinasignar.php");
?>