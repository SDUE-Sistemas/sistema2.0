<?php 
include_once('librerias/elimina_acentos.php');
$usuario = elimina_acentos($_POST['usuario']);
$pass = $_POST['pass'];
$es=0;
if(!empty($_POST['esadmiin'])){
$es=1;
}

include_once('librerias/info.php');
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