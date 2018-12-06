<?php
//verificamos si nos mandaron los datos de usuario y contraseña con el post
if (isset($_POST['usuario']) && isset($_POST['password'])){
//si mandaron los datos los guardamos en variables para manipularlos más facil
$usuario = $_POST['usuario'];
$password = $_POST['password'];
//definimos los cookies con los datos que nos mandaron con anterioridad
setcookie('usuario', $usuario, time()+60*60);
setcookie('password', $password, time()+60*60);
/*lo mandamos a la pagina principal, en la cual 
lo va a regresar al index en caso de tener los datos mal*/
header('Location: capturar.php');
}else {
    //si no nos mandaron los datos lo devolvemos al index
    header('Location: index.php');
}