<?php 
//Libreria para modificar cadena de caracteres
include_once('librerias/elimina_acentos.php');
$fecha = $_POST['fecha'];
//Manipulamos las cadenas de caracteres y les quitamos todos los acentos que tienen
$asunto = elimina_acentos($_POST['asunto']);
$quien_reporta = elimina_acentos($_POST['quien_reporta']);
$area = $_POST['area'];
$personal_atiende = $_POST['personal_atiende'];
$personal_levanta = $_POST['personal_levanto'];
$estado=0;
//Libreria para la base de datos
include_once('librerias/info.php');
//Se inserta en la base de datos un nuevo reporte
$query = "INSERT INTO reportes(asunto, usuario, personal_levanta, personal_atiende, area, estado, fecha_levanta)
                        VALUES(:asunto, :usuario, :personal_levanta, :personal_atiende, :area, :estado, :fecha)";

//Se mandan los datos
$statement = $db->prepare($query);
$statement->bindValue(':asunto', strtoupper($asunto));
$statement->bindValue(':usuario', strtoupper($quien_reporta));
$statement->bindValue(':personal_levanta', $personal_levanta);
$statement->bindValue(':personal_atiende', $personal_atiende);
$statement->bindValue(':area', $area);
$statement->bindValue(':estado', $estado);
$statement->bindValue(':fecha', $fecha);
$statement->execute();
$statement->closeCursor();


     
     $query = "SELECT folio FROM reportes WHERE folio = (SELECT max(folio) FROM reportes)";
     $statement = $db->prepare($query);
     $statement->execute();
     $x = $statement->fetch();
     $x=$x['folio'];
     $statement->closeCursor();
    
header('Location: foliomodificar.php?folio='.$x.'&code=levanta');
?>

<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->