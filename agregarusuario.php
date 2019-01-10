<!--sacar el ultimo folio con php-->
<?php
    include_once('librerias/info.php');
    $query = "SELECT folio FROM reportes WHERE folio = (SELECT max(folio) FROM reportes)";
    $statement = $db->prepare($query);
    $statement->execute();
    $folio_max = $statement->fetch();
    $statement->closeCursor();
?>
<!-- control de usuarios -->
<?php if(isset($_COOKIE['usuario']) && isset($_COOKIE['password'])){
  
  include_once('librerias/info.php');
  $query = "SELECT pass, nombre, esadmin FROM personal WHERE nombre='".$_COOKIE['usuario']."'";
  $statement = $db->prepare($query);
  $statement->execute();
  $usuario = $statement->fetch();
  $statement->closeCursor();
  }else{
  header('Location: index.php');
    }
if(!($usuario['pass']==$_COOKIE['password'])){
  header('Location: index.php');
}

//sacar el numero de folios asociados al usuario logeado
$user=$_COOKIE['usuario'];
include_once('librerias/info.php');

$query = "SELECT folio FROM reportes WHERE personal_atiende='".$user."' AND estado = 0";
$statement = $db->prepare($query);
$statement->execute();
$nr = $statement->fetchAll();
$statement->closeCursor();
$n = sizeof($nr);
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
        <a href="consulta.php">CONSULTAS</a>
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
        <!-- funcion para desloguearte del Sistema -->
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
        <p class="lead">ÁREA DE SISTEMAS / AGREGAR USUARIO </p>
    </div>
<!-- contenido -->
<div class="container">
<form action="agregarusuariodb.php" method="post" id="main">
    <div class="row">
    
        <div class="col" align="center">
            <label for="" >USUARIO</label>
            <input type="text" id="usuario" name="usuario" class="form-control" style="width:30%">
            <label for="">CONTRASEÑA</label>
            <input type="text" id="pass" name="pass" class="form-control" style="width:30%">
            <label>HACER ADMINISTRADOR</label>
            <input type="checkbox" name="esadmiin" id="esadmiin">
            <br><br>
            </form>
            <button class="btn btn-outline-primary"  id="agregar">AGREGAR</button>
            <button class="btn btn-outline-primary" id="cancelar">CANCELAR</button>
            <button  class="btn btn-outline-primary"  id="volver">VOLVER</button>
        </div>
    </div>
</div>

    
    <script Language="JavaScript">
        agregar.onclick=function(){
        //Funcion para verificar que los campos no estan vacios al dar clic en Aceptar
            if(usuario.value=="" | pass.value==""){
                //Si hay campos vacios no manda el formulario
                alert("No puede dejar campos vacios");
                event.preventDefault();
            }else{
                //No hay campos vacios, manda el formulario
            alert("Usuario Agregado ");
            }
        }
        
        cancelar.onclick=function(){
            //Funcion para cancelar y vaciar los campos que se llenaron al dar clic en Cancelar
                var mensaje=confirm("¿Seguro que desea cancelar?");
                if(mensaje){
                    //Si se acepta la advertencia vacia los campos
                    usuario.value=""
                    pass.value="";
                    esadmiin.checked=false;
                    event.preventDefault();
                }else{
                    //No se acepta se queda igual
                    event.preventDefault();
                }
            }
        volver.onclick=function(){
        //Funcion para volver a la pagina de Administrador al dar clic en Volver
            var mensaje = confirm("¿Seguro que desea volver?");
            if(mensaje){
                //Si se acepta nos devuelve a la pagina de admin
            event.preventDefault();
            location.href="admin.php";
            }else{
                //Se cancela nos deja en la misma pagina
            event.preventDefault();
            }

        }
    </script>
</body>
</html>


<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->
<!-- END -->