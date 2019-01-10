<?php  
//Informacion necesaria para poder ingresar al localhost y hacer cambios en la base de datos
    $host = 'localhost';
    $database = 'sistemas';
    $username = 'root';
    $password = '';
    $dsn = "mysql:host=$host;dbname=$database";
    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "Algo anda mal..." . $error_message;
        exit();
    }
?>

<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 xd-->