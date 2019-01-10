<?php
//Librerias para accesar a Base de Datos, al Login del Sistema, y para modificar el texto
include_once("librerias/info.php");
require_once("librerias/control_usuario.php");
require_once("librerias/elimina_acentos.php");
$detalles=elimina_acentos($_POST['detalles']);
$fecha_atiende=quita_diagonal($_POST['fecha']);
$personal = $_POST['personal_atiende'];
$causa=$_POST['causa'];
$folio=$_POST['folio'];
//Actualiza un registro asignando el reporte a algun usuario
$query="UPDATE reportes 
        SET personal_atiende ='".$personal."' WHERE folio = $folio";
    $statement = $db->prepare($query); 
    $statement->execute();
    $statement->closeCursor();
    header("location:sinasignar.php");
?>

<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->