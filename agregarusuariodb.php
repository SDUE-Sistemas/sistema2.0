<?php 
//Libreria que quita acentos y modifica cadenas de caracteres
include_once('librerias/elimina_acentos.php');
$usuario = elimina_acentos($_POST['usuario']);
$pass = $_POST['pass'];
$es=0;
if(!empty($_POST['esadmiin'])){
$es=1;
}
//Libreria para acceder a la base de datos
include_once('librerias/info.php');
//Agregando un nuevo usuario con los valores del formulario que se envio
$query = "INSERT INTO personal(esadmin,nombre,pass)
                        VALUES(:esadmin,:nombre,:pass)";


$statement = $db->prepare($query);
$statement->bindValue(':esadmin', $es);
$statement->bindValue(':nombre', strtoupper($usuario));
$statement->bindValue(':pass', $pass);

$statement->execute();
$statement->closeCursor();
    
header('Location: admin.php');
?>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->