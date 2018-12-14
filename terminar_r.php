<?php
include_once("librerias/info.php");
require_once("librerias/control_usuario.php");
require_once("librerias/elimina_acentos.php");
$detalles=elimina_acentos($_POST['detalles']);
$fecha_atiende=quita_diagonal($_POST['fecha']);
$causa=$_POST['causa'];
$folio=$_POST['folio'];
$query="UPDATE reportes 
        SET detalles = '".strtoupper($detalles)."', fecha_atiende ='".$fecha_atiende."', causa = '".$causa."', estado = 1 WHERE folio = $folio";
    $statement = $db->prepare($query); 
    $statement->execute();
    $statement->closeCursor();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="foliomodificar.php" id="main" method="post">
    <input type="text" name="folio" value="<?php echo $folio; ?>"hidden>
    <input type="text" name="code" value="terminado" hidden>
    </form>
</body>
</html>
<script>

window.onload= function(){
    document.forms["main"].submit();

} 

</script>