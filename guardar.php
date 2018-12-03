<?php 
$fecha = $_POST['fecha'];
$asunto = strtoupper($_POST['asunto']);
$quien_reporta = strtoupper($_POST['quien_reporta']);
$area = $_POST['area'];
$personal_atiende = $_POST['personal_atiende'];
$personal_levanta = $_POST['personal_levanto'];
$estado=0;
include_once('librerias/info.php');
$query = "INSERT INTO reportes(asunto, usuario, personal_levanta, personal_atiende, area, estado, fecha_levanta)
                        VALUES(:asunto, :usuario, :personal_levanta, :personal_atiende, :area, :estado, :fecha)";

            include_once('librerias/elimina_acentos.php');
$statement = $db->prepare($query);
$statement->bindValue(':asunto', elimina_acentos($asunto));
$statement->bindValue(':usuario', elimina_acentos($quien_reporta));
$statement->bindValue(':personal_levanta', $personal_levanta);
$statement->bindValue(':personal_atiende', $personal_atiende);
$statement->bindValue(':area', $area);
$statement->bindValue(':estado', $estado);
$statement->bindValue(':fecha', $fecha);
$statement->execute();
$statement->closeCursor();
    
header('Location: capturar.php');
?>