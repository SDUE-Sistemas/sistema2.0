<?php 
//Libreria del Login
include_once("librerias/control_usuario.php");

//Verificando que sea Admnistrador para poder entrar
if($usuario['esadmin']!=1){?>
   <script>
   var mensaje = alert("No puede acceder, USTED NO ES ADMINISTRADOR.");
   location.href="capturar.php";
   </script><?php 
}
?>
<!--html-->
<!doctype html>
<html lang="en">
<head>
<!-- Icono -->
    <link rel="icon" type="image/png" href="img/icono.png" />
    <title>Capturar</title>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS y librerias personales -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="librerias/estilo.css">
    <link rel="stylesheet" href="librerias/fuente.css">
</head>
<!-- empieza el body -->
<body>

<!--encabezado-->
    <!-- Menu -->
    <div class="scrollmenu">
      <ul class="nav">
        <a href="capturar.php">CAPTURAR</a>
        <a href="modificar.php">MODIFICAR REPORTES</a>
        <a href="consulta.php"> CONSULTAS </a>
<!-- desplegable de buscar-->
        <!-- <li><a>BUSCAR</a>
          <ul>
				<li><a href="mfolio.php">POR FOLIO</a></li>
				<li><a href="musuario.php">POR NOMBRE USUARIO</a></li>
				<li><a href="mpersonal.php">POR PERSONAL</a></li>
                <li><a href="marea.php">POR AREA</a></li>          
          </ul>
        </li> -->
        <a href="terminar.php">TERMINAR CAPTURAS (<?php echo $n?>)</a>
        <?php if($usuario['esadmin']==1){ ?>
        <a href="admin.php">ADMIN</a><?php } ?>
        <!-- Funcion para salir del Sistema -->
        <a href="logout.php" id="salir">SALIR</a>
        <script>
            salir.onclick=function(){
                var mensaje = confirm("¿Seguro que desea salir?");
                if(!mensaje){
                    event.preventDefault();
                }
            }
        </script>
        </ul>
      </ul>
    </div>
<!-- jumbotron de la parte de arriba -->
    <div class="jumbotron" style="text-align:center">
<!-- imagen del lado derecho -->
        <img src="img/Logo Chihuahua.png" alt="" style="height:150px; width:150px" align="right">
<!-- Nombres -->
        <h1 class="display-6">SECRETARÍA DE DESARROLLO URBANO Y ECOLOGÍA</h1>
        <p class="lead">ÁREA DE SISTEMAS / ADMINISTRADOR</p>
    </div>
  <!-- Contenido -->
  <div class="container">
      <div class="row">
          <div class="col-md">
          <h1 style="font-size:20px; text-align:center">AGREGAR USUARIO</h1>
          <div align="center">
          <a style="width:250px;"class="btn btn-outline-primary" href="agregarusuario.php" role="button">IR</a>
          </div>
          <br>
          <h1 style="font-size:20px; text-align:center">MODIFICAR USUARIO</h1>
          <div align="center">
          <a style="width:250px;"class="btn btn-outline-primary" href="modificarusuario.php" role="button">IR</a>
          </div>
          <br>
          <h1 style="font-size:20px; text-align:center">ELIMINAR USUARIO</h1>
          <div align="center">
          <a style="width:250px;"class="btn btn-outline-primary" href="eliminar.php" role="button">IR</a>
          </div>
          </div>
      
          <div class="col-md">
          <h1 style="font-size:20px; text-align:center">REPORTES SIN ASIGNAR</h1>
          <div align="center">
          <a style="width:250px;"class="btn btn-outline-primary" href="sinasignar.php" role="button">IR</a>
          </div>
          <br><br><br><br><br>
          <h1 style="font-size:20px; text-align:center">VACIAR BASE DE DATOS</h1>
          <div align="center">
          <a style="width:250px;"class="btn btn-outline-primary" id="vaciars" href="eliminardb.php"; role="button">VACIAR</a>
          </div>
          </div>
          </div>
    </div>
  </div>
  <!-- Advertencia para verificar si realmente se quiere eliminar la Base de Datos -->
<script>
    vaciars.onclick=function(){
        var mensaje = confirm("La Base de Datos de Reportes se vaciara, y los datos ya no se podran recuperar");
        if(mensaje){
            var seguridad = confirm("¿Realmente esta seguro?");
            if(seguridad){
                alert("La base de datos de Reportes ha sido eliminada");
            }
            else{
            event.preventDefault();
            }
        }
        else{
            event.preventDefault();
        }
    }

</script>
<!-- Librerias No Mover >:V -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
         <script src="js/bootstrap.min.js"></script>

</body>
</html>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->