<!-- comprueba si ya estan definidas las cookies de la sesion -->
<?php if(isset($_COOKIE['usuario']) && isset($_COOKIE['password'])){

  include_once('librerias/info.php');
  //seleccionamos la contraseña según el usuario que ingresó
  $query = "SELECT pass FROM personal WHERE nombre='".$_COOKIE['usuario']."'";
  $statement = $db->prepare($query);
  $statement->execute();
  $usuario = $statement->fetch();
  $statement->closeCursor();
  //comparamos la contraseña que ingreso el usuario con la que tenemos en la base de datos
  if($usuario['pass']==$_COOKIE['password']){
    //Si es que es correcta la contraseña lo mandamos a la pagina principal para que empiece a trabajar
    header('Location:capturar.php');
  }else{
    //si es que la contraseña no coincide le decimos que el usuario o la contraseña estaba mal
      ?>
      <script>alert("Contraseña y/o usuario incorrecta(s)");</script>
      <?php
  }
  }else{
    //si no estan definidas las cookies de sesion le decimos que inice sesion con un alert
    ?>
    <script>alert("inicie sesion");</script>
    
    <?php
}
?>

<!-- Diseño del login -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Librerias para toda la family -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="librerias/estilo.css">
    <link rel="stylesheet" href="librerias/fuente.css">
</head>
<body>
<div class="jumbotron" style="text-align:center">
  <!-- imagen del lado derecho -->
    <img src="img/Logo Chihuahua.png" alt="" style="height:150px; width:150px" align="right">
    <!-- Nombres -->
        <h1 class="display-6">SECRETARÍA DE DESARROLLO URBANO Y ECOLOGÍA</h1>
        <p class="lead">INGRESAR AL SISTEMA</p>
      </div>
<div class="container">
  
  <div class="row">
    <div class="col-md">
      
    </div>
      <div class="col-md">
<!-- form del login -->
    <form action="login.php" method="post" style="text-align:center">
    <label>USUARIO</label>
    <input name="usuario" id="usuario "type="text" class="form-control" style="text-align:center; width:350px;">
    <br><br>
    <label>CONTRASEÑA</label>
    <input name="password" id="password" type="password" class="form-control" style="text-align:center; width:350px;">
    <br><br>
    <button type="submit" class="btn btn-secondary">INGRESAR</button>
</form>
</div>
<div class="col-md"></div>
</div>
</div>

   <!-- Librerias -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    
</body>
</html>
