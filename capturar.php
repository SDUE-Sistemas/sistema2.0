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
        <a href="logout.php">SALIR</a>
        </ul>
      </ul>
    </div>
<!-- jumbotron de la parte de arriba -->
    <div class="jumbotron" style="text-align:center">
<!-- imagen del lado derecho -->
        <img src="img/Logo Chihuahua.png" alt="" style="height:150px; width:150px" align="right">
<!-- Nombres -->
        <h1 class="display-6">SECRETARÍA DE DESARROLLO URBANO Y ECOLOGÍA</h1>
        <p class="lead">AREA DE SISTEMAS / CAPTURAR </p>
    </div>
<!-- contenido -->
    <div class="container">
        <!--empieza el form -->
    <form action="guardar.php" method="post" id="main">
        <!-- parte izquierda -->
        <div class="row">
            
            <div class="col-md">
                <label>FOLIO</label>
                <input style="text-align:center" type="text" class="form-control" value="<?php echo $folio_max['folio']+1;?>" name="folio" disabled>
                <label>ASUNTO</label>
                <input type="text" class="form-control" name="asunto" id="asunto" >
                <label>QUIEN REPORTA</label>
                <input type="text" class="form-control" name="quien_reporta" id="quien_reporta">
                <!-- input invisible del la fecha acutual que se va a rellenar con javascript -->
                <input type="text" id="fecha" name="fecha"hidden>
            </div>
            <!-- parte derecha -->
            <div class="col-md">

                <label>DEPARTAMENTO</label>
            <!-- Desplegable  Ciclo For DEPARTAMENTOS-->            
            <?php
            $query = "SELECT nombre FROM departamentos";
            $statement = $db->prepare($query);
            $statement->execute();
            $departamentos = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For DEPARTAMENTOS-->
                <select class="form-control" name="area" >
                <?php  foreach($departamentos as $departamento): ?>
                  <option><?php echo $departamento['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                
                <label>PERSONAL QUE LEVANTO EL REPORTE</label>
                <!-- Desplegable  Ciclo For QUIEN LEVANTA-->
                <?php
            $query = "SELECT nombre FROM personal";
            $statement = $db->prepare($query);
            $statement->execute();
            $personals = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For QUIEN LEVANTA-->
                <select class="form-control" name="personal_levanto" >
                <?php  foreach($personals as $personal): ?>
                  <option <?php if($usuario['nombre']==$personal['nombre']){echo "selected";} ?>><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>

                <label>PERSONAL QUE ATENDERÁ</label>
                <!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                <?php
            $query = "SELECT nombre FROM personal";
            $statement = $db->prepare($query);
            $statement->execute();
            $personals = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                <select class="form-control" name="personal_atiende" >
                    <option>DEJAR A CRITERIO DE UN ADMINISTRADOR</option>
                <?php  foreach($personals as $personal): ?>
                  <option><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <br>
                <!-- botones -->
                
            </div>
            <!-- termina el form -->
            </form>
        </div>
        <div class="row" align="center">
                    
                    <!-- agregar -->
                    <div class="col-md" align="right"> 
                    <button form="main" type="submit" class="btn btn-outline-primary" onclick="validar();">AGREGAR</button>
                    </div>
                    <!-- cancelar -->
                    <div class="col-md" align="left">
                <input type="button" value="LIMPIAR" onclick="cancelar();" class="btn btn-outline-primary">
                    </div>
                </div>
        <!--termina el container -->
    </div>

    <script Language="JavaScript">
    function chec(){
       //Evento al querer subir un reporte que cheque si esta lleno
        if(asunto.value=="" &&  quien_reporta.value==""){
           
            alert("Esta vacio");
            //funcion para cancelar el envio del form
        }
    }
    function validar(){
       //Evento al querer subir un reporte que cheque si esta lleno
        if(asunto.value=="" ||  quien_reporta.value==""){
           
            alert("Faltan campos de llenar");
            //funcion para cancelar el envio del form
            event.preventDefault();
        }
        else{
            alert("Guardado");
            var d = new Date();
            fecha.value=d.getFullYear() + "" + (d.getMonth() +1) + "" + d.getDate();
            
        }
        }
        //funcion para el boton cancel
        function cancelar(){
        var mensaje = confirm("¿Seguro que deseas borrar?");
        //si le da que si le vacia los campos
        if(mensaje){
            chec();
            asunto.value = "";
            quien_reporta.value = "";
        }
        }
    </script>
</body>
</html>
<!-- END -->