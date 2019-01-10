<?php 
//librerias
include_once('librerias/elimina_acentos.php');
include_once('librerias/info.php');
$usuario=$_POST['usuario'];
$abcd=strtoupper($_POST['abcd']);
//Verificando si se marco el cuadro de hacer administrador
if(!empty($_POST['esadmiin'])){
    $es=1;
    }else
    {$es=0;}
    //Esto quiere decir si el usuario logueado es el que esta modificando usuarios, para que no se pueda 
    //quitar el admin el mismo usuario y asi se garantiza que nunca se quedaran sin administradores
    if($usuario==$abcd){
        $es=1;
    }

if(isset($_POST['nombre']) && isset($_POST['password'])){
    //Si se habilito el campo de cambiar nombre y contraseña
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
    //si se habilito el campo de cambiar nombre pero el de contraseña no
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
    //si el nombre no se quiere cambiar, solo la contraseña
    $password=$_POST['password'];
    $query = " UPDATE personal SET pass = :pass, esadmin = :esadmin WHERE nombre LIKE '".$usuario."'";

$statement = $db->prepare($query);
$statement->bindValue(':pass', $password);
$statement->bindValue(':esadmin', $es);
$statement->execute();
$statement->closeCursor();
    header("location:admin.php");
}else{
    //En caso de que solo se quiera hacer administrador
    $query = " UPDATE personal SET esadmin = :esadmin WHERE nombre LIKE '".$usuario."'";
$statement = $db->prepare($query);
$statement->bindValue(':esadmin', $es);
$statement->execute();
$statement->closeCursor();
    header("location:admin.php");
}
    
?>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->