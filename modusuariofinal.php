<?php 
include_once('librerias/elimina_acentos.php');
include_once('librerias/info.php');
$usuario=$_POST['usuario'];
echo $usuario;
echo " ";
if(!empty($_POST['esadmiin'])){
    $es=1;
    }else
    {$es=0;}
if(isset($_POST['nombre']) && isset($_POST['password'])){
    $nombre=$_POST['nombre'];
    $nombre = elimina_acentos($nombre);
    $password=$_POST['password'];
    $query = " UPDATE personal SET nombre = :nombre, pass = :pass, esadmin = :esadmin WHERE nombre LIKE '".$usuario."'";

$statement = $db->prepare($query);
$statement->bindvalue(':nombre', strtoupper($nombre));
$statement->bindValue(':pass', $password);
$statement->bindValue(':esadmin', $es);
$statement->execute();
$statement->closeCursor();
    header("location:admin.php");
}
else if(isset($_POST['nombre']) && !isset($_POST['password'])){
    $nombre=$_POST['nombre'];
    $nombre = elimina_acentos($nombre);
    $query = " UPDATE personal SET nombre = :nombre, esadmin = :esadmin WHERE nombre LIKE '".$usuario."'";

$statement = $db->prepare($query);
$statement->bindvalue(':nombre', strtoupper($nombre));
$statement->bindValue(':esadmin', $es);
$statement->execute();
$statement->closeCursor();
    header("location:admin.php");
}
else if(!isset($_POST['nombre']) && isset($_POST['password'])){
    $password=$_POST['password'];
    $query = " UPDATE personal SET pass = :pass, esadmin = :esadmin WHERE nombre LIKE '".$usuario."'";

$statement = $db->prepare($query);
$statement->bindValue(':pass', $password);
$statement->bindValue(':esadmin', $es);
$statement->execute();
$statement->closeCursor();
    header("location:admin.php");
}else{
    $query = " UPDATE personal SET esadmin = :esadmin WHERE nombre LIKE '".$usuario."'";
$statement = $db->prepare($query);
$statement->bindValue(':esadmin', $es);
$statement->execute();
$statement->closeCursor();
    header("location:admin.php");

}
    
?>