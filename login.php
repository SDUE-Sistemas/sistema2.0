<?php
if (isset($_POST['usuario']) && isset($_POST['password'])){
$usuario = $_POST['usuario'];
$password = $_POST['password'];
setcookie('usuario', $usuario, time()+60*60);
setcookie('password', $password, time()+60*60);
header('Location: capturar.php');
}else {
    header('Location: index.php');
}