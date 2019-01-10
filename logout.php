<?php 
//Nos pone la sesion para que le quede un segundo de vida y nos mande al index
setcookie('usuario', ""+1);
setcookie('password', ""+1);
header('Location: index.php?code=1');
?>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->