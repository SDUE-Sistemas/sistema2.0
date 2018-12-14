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
        <p class="lead">ÁREA DE SISTEMAS / MODIFICAR USUARIO </p>
    </div>
<!-- contenido -->
<div class="container">
<form action="modusuariofinal.php" method="post" id="main">
    <div class="row">
    
        <div class="col" align="center">
            <label for="" >USUARIO</label>
            <?php
            $query = "SELECT nombre,esadmin FROM personal";
            $statement = $db->prepare($query);
            $statement->execute();
            $personal = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For DEPARTAMENTOS-->
                <select class="form-control" name="usuario" onchange="verificar();" id="usuario" style="width:350px;">
                <?php  foreach($personal as $personals): ?>
                <option><?php echo $personals['nombre'];?></option>
                <?php endforeach; ?>
                </select>
            <br>
            <div class="container" >
            <br>
            <div class="row">
            <div class="col" align="right">
            
            <label>NUEVO NOMBRE</label>
            <input type="checkbox" name="na" id="na" checked>
            <input type="text" id="nombre" name="nombre" class="form-control" style="width:30%">
            <br>
            </div>
            <div class="col" align="left">
            <label for="">NUEVA CONTRASEÑA</label>
            <input type="checkbox" name="pa" id="pa" checked>
            <input type="text" id="password" name="password" class="form-control" style="width:30%">
            <input type="text" id="abcd" name="abcd" value="<?php echo $_COOKIE['usuario']; ?>" class="form-control" style="width:30%" hidden>
            <br>
            </div>
            </div></div>
            <label>HACER ADMINISTRADOR</label>
            <input type="checkbox" name="esadmiin" id="esadmiin" checked>
            <br><br>
            </form>
            <button class="btn btn-outline-primary"  id="agregar">MODIFICAR</button>
            <button class="btn btn-outline-primary" id="cancelar">CANCELAR</button>
            <button  class="btn btn-outline-primary"  id="volver">VOLVER</button>
        </div>
    </div>
</div>

    <script Language="JavaScript">
        agregar.onclick=function(){
           if(pa.checked==true && password.value=="" || na.checked==true && nombre.value==""){
            alert("Hay campos vacios");
            event.preventDefault();
           }else{
            alert("Los cambios fueron realizados");
           }
           
        }
        cancelar.onclick=function(){
                var mensaje=confirm("¿Seguro que desea cancelar?");
                if(mensaje){
                    nombre.value=""
                    password.value="";
                    na.checked=true;
                    pa.checked=true;
                    nombre.disabled=false;
                    password.disabled=false;
                    event.preventDefault();
                }else{
                    event.preventDefault();
                }
            }
        volver.onclick=function(){
            var mensaje = confirm("¿Seguro que desea volver?");
            if(mensaje){
            event.preventDefault();
            location.href="admin.php";
            }else{
            event.preventDefault();
            }
        }
        na.onclick=function(){
        if(na.checked==true){
        nombre.disabled=false;
        }else{
        nombre.disabled=true;
        }
        }

        pa.onclick=function(){
        if(pa.checked==true){
        password.disabled=false;
        }else{
        password.disabled=true;
        }
        }
        
        function verificar(){
            var x = document.getElementById("usuario").value;
            var p = document.getElementById("abcd").value;
            p = p.toUpperCase();
            if(x==p){
            esadmiin.checked=true;
            }else{
            esadmiin.disabled=false;
            esadmiin.checked=false;
            }
            
        }
    </script>
</body>
</html>
<!-- END -->