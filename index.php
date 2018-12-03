<?php if(isset($_COOKIE['usuario']) && isset($_COOKIE['password'])){

  include_once('librerias/info.php');
  $query = "SELECT pass FROM personal WHERE nombre='".$_COOKIE['usuario']."'";
  $statement = $db->prepare($query);
  $statement->execute();
  $usuario = $statement->fetch();
  $statement->closeCursor();
  if($usuario['pass']==$_COOKIE['password']){
    header('Location:capturar.php');
  }else{
      ?>
      <script>alert("Contraseña y/o usuario incorrecta(s)");</script>
      <?php
  }
  }else{
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    
    <form action="login.php" method="post" style="text-align:center">
    <input name="usuario" type="text" class="form-control" style="text-align:center; width:350px;" placeholder="USUARIO">
    <br><br>
    <input name="password" type="password" class="form-control" style="text-align:center; width:350px;" placeholder="CONTRASEÑA">
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
