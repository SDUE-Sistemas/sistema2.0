<?php if(isset($_COOKIE['usuario']) && isset($_COOKIE['password'])){
  
  include_once('librerias/info.php');
  $query = "SELECT pass, nombre, esadmin FROM personal WHERE nombre='".$_COOKIE['usuario']."'";
  $statement = $db->prepare($query);
  $statement->execute();
  $usuario = $statement->fetch();
  $statement->closeCursor();
  }else{
  header('Location: index.php');
    }
if(!($usuario['pass']==$_COOKIE['password'])){
  header('Location: index.php');
}

//sacar el numero de folios asociados al usuario logeado
$user=$_COOKIE['usuario'];
include_once('librerias/info.php');

$query = "SELECT folio FROM reportes WHERE personal_atiende='".$user."' AND estado = 0";
$statement = $db->prepare($query);
$statement->execute();
$nr = $statement->fetchAll();
$statement->closeCursor();
$n = sizeof($nr);
?>