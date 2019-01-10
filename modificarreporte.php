<?php 
//Librerias
include_once('librerias/elimina_acentos.php');
include_once('librerias/info.php');
//Se verifica si el reporte ya estaba terminando
if($_POST['a']==1){
    //El reporte esta terminado, se le añade mas campos a la base de datos como Fecha en que se atendio, detalles y causa del reporte
    $folio = $_POST['folio'];
    $asunto = $_POST['asunto'];
    $usuario = $_POST['usuario'];
    $area = $_POST['area'];
    $personal_levanta = $_POST['personal_levanto'];
    $personal_atiende = $_POST['personal_atiende'];
    $detalles = $_POST['detalles'];
    $fecha = $_POST['fecha'];
    $fecha .=" ";
    //Modifica las cadenas de caracteres
    $fecha=quita_diagonal($fecha);
    $detalles = elimina_acentos($detalles);
    $asunto=elimina_acentos($asunto);
    $usuario=elimina_acentos($usuario);
    
    //Se actualizan los cambios a realizarse
    $query = " UPDATE reportes SET asunto = :asunto, usuario = :usuario, area = :area, 
    personal_levanta = :personal_levanta, fecha_atiende = :fecha_atiende, detalles = :detalles, personal_atiende = :personal_atiende WHERE folio like :folio";
    
    $statement = $db->prepare($query);
    $statement->bindvalue(':folio', $folio);
    $statement->bindValue(':asunto', strtoupper($asunto));
    $statement->bindValue(':usuario', strtoupper($usuario));
    $statement->bindValue(':detalles', strtoupper($detalles));
    $statement->bindValue(':fecha_atiende',$fecha);
    $statement->bindValue(':area', $area);
    $statement->bindValue(':personal_levanta', $personal_levanta);
    $statement->bindValue(':personal_atiende', $personal_atiende);
    $statement->execute();
    $statement->closeCursor();
}else{
    //no esta terminado el reporte
$folio = $_POST['folio'];
$asunto = $_POST['asunto'];
$usuario = $_POST['usuario'];
$area = $_POST['area'];
$personal_levanta = $_POST['personal_levanto'];
$personal_atiende = $_POST['personal_atiende'];
//modificando caddena de caracteres
$asunto=elimina_acentos($asunto);
$usuario=elimina_acentos($usuario);

//Se actualizan los cambios 
$query = " UPDATE reportes SET asunto = :asunto, usuario = :usuario, area = :area, 
personal_levanta = :personal_levanta, personal_atiende = :personal_atiende WHERE folio like :folio";

$statement = $db->prepare($query);
$statement->bindvalue(':folio', $folio);
$statement->bindValue(':asunto', strtoupper($asunto));
$statement->bindValue(':usuario', strtoupper($usuario));
$statement->bindValue(':area', $area);
$statement->bindValue(':personal_levanta', $personal_levanta);
$statement->bindValue(':personal_atiende', $personal_atiende);
$statement->execute();
$statement->closeCursor();
}
?>
<html>
<form name="main" method="post" action="foliomodificar.php">
<input type="text" name="folio" value="<?php echo $folio ?>" hidden>
<input type="text" name="code" value="modificar" hidden>
</form>
<script>
window.onload=function(){
    //Nos manda a otro dormulario en cuanto se da en aceptar
    document.forms["main"].submit();
}

</script>
</html>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->