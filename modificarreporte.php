<?php 
include_once('librerias/elimina_acentos.php');
include_once('librerias/info.php');

$folio = $_POST['folio'];
$asunto = $_POST['asunto'];
$usuario = $_POST['usuario'];
$area = $_POST['area'];
$personal_levanta = $_POST['personal_levanto'];
$personal_atiende = $_POST['personal_atiende'];

$asunto=elimina_acentos($asunto);
$usuario=elimina_acentos($usuario);

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

?>
<html>
<form name="main" method="post" action="foliomodificar.php">
<input type="text" name="folio" value="<?php echo $folio ?>" hidden>
</form>
<script>
window.onload=function(){
    document.forms["main"].submit();
}

</script>
</html>