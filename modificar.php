<!-- control de usuarios -->
<?php 

    include_once('librerias/control_usuario.php');
    include_once('librerias/info.php');
    include_once('librerias/elimina_acentos.php');
    $query = "SELECT folio FROM reportes WHERE folio = (SELECT max(folio) FROM reportes)";
    $statement = $db->prepare($query);
    $statement->execute();
    $folio_max = $statement->fetch();
    $statement->closeCursor();

//sacar el numero de folios asociados al usuario logeado
$user=$_COOKIE['usuario'];

$query = "SELECT folio FROM reportes WHERE personal_atiende='".$user."' AND estado = 0";
$statement = $db->prepare($query);
$statement->execute();
$n = $statement->fetchAll();
$statement->closeCursor();
$n = sizeof($n);
// sacar los datos del reporte que vamos a modificar
if(isset($_POST['folio'])){
$x=$_POST['folio'];
$query = "SELECT folio, asunto, estado, detalles, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area FROM reportes WHERE folio=$x";
$statement = $db->prepare($query);
$statement->execute();
$reporte = $statement->fetch();
$statement->closeCursor();
}
?>
<!--html-->
<!doctype html>
<html lang="en">
<head>
<!-- Icono -->
    <link rel="icon" type="image/png" href="img/icono.png" />
    <title>Modificar</title>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS y librerias personales -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="librerias/estilo.css">
    <link rel="stylesheet" href="librerias/fuente.css">
    <link rel="stylesheet" href="jq/jquery-ui.css" />
    <script src="jq/jquery-1.9.1.js"></script>
    <script src="jq/jquery-ui.js"></script>
    <script src="librerias/calendario.js"></script>
    <script>
        $(function () {
        $("#fecha").datepicker();
        });
    </script>
</head>
<!-- empieza el body -->
<body>

<!--encabezado-->
    
    <div class="scrollmenu">
      <ul class="nav">
        <a href="capturar.php">CAPTURAR</a>
        <a href="modificar.php">MODIFICAR REPORTES</a>
<!-- desplegable de buscar-->
        <a href="consulta.php">CONSULTAS</a>
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
    </div>
<!-- jumbotron de la parte de arriba -->
    <div class="jumbotron" style="text-align:center">
<!-- imagen del lado derecho -->
        <img src="img/Logo Chihuahua.png" alt="" style="height:150px; width:150px" align="right">
<!-- Nombres -->
        <h1 class="display-6">SECRETARÍA DE DESARROLLO URBANO Y ECOLOGÍA</h1>
        <p class="lead">ÁREA DE SISTEMAS / MODIFICAR </p>
    </div>
    <!-- un if que revisa si nos han enviado el folio que nesecitamos para la busqueda -->
    <?php if(!isset($_POST['folio'])){?>
    <div class="container">
        <div class="row">
            <div align="center" class="col">
                <form action="modificar.php" method="post">
                <label>FOLIO</label>
                    <input class="form-control" id="folio" style="width: 400px"  name="folio" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                    <br><br>
                    <button type="submit" class="btn btn-outline-primary" onclick="verificar();">Buscar</button>
                </form>
            </div>
        </div>
    </div>
    <!-- en caso que lo encuentre le soltamos los datos que puede modificar para que cambie lo que nesecite,
    además, checamos con un elseif si el folio que nos pasaron está dentro del rango que tenemos. Para esto,
    vamos a sacar el ultimo folio que tenemos en nuestra base de datos y vamos a hacer la comparacion este
    cero y el ultimo folio-->
    
    <?php }elseif(($folio_max['folio']+1)>$_POST['folio'] && $_POST['folio']>0) { 
        
        
        if($reporte['estado']==1){
            if($usuario['esadmin']==1){ ?>
                
                <div class="container">
    <form action="modificarreporte.php" method="POST" id="main">
        <div class="row">
            <div class="col">
                <input id="a" name="a" value="1" hidden>
                <input id="b" name="b" value="1" hidden>
                <label for="">FOLIO</label>
                <input type="text"style="text-align:center" class="form-control" name="folio" value="<?php echo $reporte['folio']; ?>" disabled>
                <input type="text" class="form-control" name="folio" value="<?php echo $reporte['folio']; ?>" hidden>
                <label for="">ASUNTO</label>
                <input type="text" class="form-control" id="asunto" name="asunto" value="<?php echo $reporte['asunto']; ?>">
                <label for="">QUIEN REPORTA</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $reporte['usuario']; ?>">
                <label for="">DETALLES</label>
                <textarea style="font-family:Gotham-Book" type="text" class="form-control" id="detalles" name="detalles" value=""><?php echo $reporte['detalles']; ?></textarea>
                
                
            </div>
            <div class="col">
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
                  <option <?php if($departamento['nombre']==$reporte['area']){echo "selected";} ?>><?php echo $departamento['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <label>PERSONAL QUE LEVANTÓ</label>
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
                  <option <?php if($reporte['personal_levanta']==$personal['nombre']){echo "selected";} ?>><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <label>PERSONAL QUE ATENDERÁ</label>
                <!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                <select class="form-control" name="personal_atiende" >
                    <option>DEJAR A CRITERIO DE UN ADMINISTRADOR</option>
                <?php  foreach($personals as $personal): ?>
                  <option <?php if($personal['nombre']==$reporte['personal_atiende']){echo "selected";} ?>><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <br>
                <label for="">FECHA EN QUE SE LEVANTÓ</label>
                    <input  name="fecha" class="datepicker" readonly="readonly" size="9" value="<?php echo pon_diagonal_xd($reporte['fecha_atiende']) ?>" style="text-align:center
                    display: block;
                    width: 100%;
                    height: calc(2.25rem + 2px);
                    padding: 0.375rem 0.75rem;
                    font-size: 1rem;
                    line-height: 1.5;
                    color: #495057;
                    text-align:center;
                    background-clip: padding-box;
                    border: 1px solid #ced4da;
                    border-radius: 0.25rem;
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
                    ;"/>
                <br>
            </div>
            </form>
        </div>
        <div class="row">
        <div class="col" align="center">
            <br>
        <button  class="btn btn-outline-primary" onclick="cambios();" form="main">GUARDAR</button>
                <a name="" id="" class="btn btn-outline-primary" href="modificar.php" role="button" onclick="cancelar();">CANCELAR</a> 
    </div>
    </div>
    </div>

            <?php }else{?>
                <div class="row">
                <div class="col" align="center">
                    <br>
                    <h1>Usted no puede modificar ese reporte </h1>
                        <a name="" id="" class="btn btn-outline-primary" href="modificar.php" role="button">VOLVER</a> 
            </div>
            </div>
            <?php 
            }
        }
        else
        {
        
        
        ?>
    <div class="container">
    <form action="modificarreporte.php" method="POST" id="main">
        <div class="row">
            <div class="col">
                <label for="">FOLIO</label>
                <input type="text"style="text-align:center" class="form-control" name="folio" value="<?php echo $reporte['folio']; ?>" disabled>
                <input type="text" class="form-control" name="folio" value="<?php echo $reporte['folio']; ?>" hidden>
                <label for="">ASUNTO</label>
                <input type="text" class="form-control" id="asunto" name="asunto" value="<?php echo $reporte['asunto']; ?>">
                <label for="">QUIEN REPORTA</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $reporte['usuario']; ?>">
                
            </div>
            <div class="col">
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
                  <option <?php if($departamento['nombre']==$reporte['area']){echo "selected";} ?>><?php echo $departamento['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <label>PERSONAL QUE LEVANTÓ</label>
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
                  <option <?php if($reporte['personal_levanta']==$personal['nombre']){echo "selected";} ?>><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <label>PERSONAL QUE ATENDERÁ</label>
                <!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                <select class="form-control" name="personal_atiende" >
                    <option>DEJAR A CRITERIO DE UN ADMINISTRADOR</option>
                <?php  foreach($personals as $personal): ?>
                  <option <?php if($personal['nombre']==$reporte['personal_atiende']){echo "selected";} ?>><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <br>
            </div>
            </form>
        </div>
        <div class="row">
        <div class="col" align="center">
        <button  class="btn btn-outline-primary" onclick="cambios();" form="main">GUARDAR</button>
                <a name="" id="" class="btn btn-outline-primary" href="modificar.php" role="button" onclick="cancelar();">CANCELAR</a> 
    </div>
    </div>
    </div>
    <!-- si el folio no esta en el rango permitido madamos un alert y lo redireccionamos -->
    <?php }}else{ ?>
        <script>
            alert("folio inexistente");
            location.href ="modificar.php";
        </script>
    <?php } ?>
    <script Language="JavaScript">
    function verificar(){
       //Evento al querer subir un reporte que cheque si esta lleno
        if(folio.value == ""){
            alert("Llene los campos");
            //funcion para cancelar el envio del form
            event.preventDefault();
        }
    }
    function cancelar(){
        var mensaje = confirm("¿Seguro que deseas cancelar?");
        //si le da que si le vacia los campos
        if(mensaje){
            
        }else{
            event.preventDefault();
        }
    }
    function cambios(){
    var x = document.getElementById("a").value;
    var y = document.getElementById("b").value;
    if(x==y){
        if(detalles.value == "" || asunto.value=="" || usuario.value==""){
            alert("No puede dejar campos vacios");
            event.preventDefault();
        }
    }
    else if(x!=y && asunto.value=="" || usuario.value==""){
    alert("Llene todos los campos");
    event.preventDefault();
    }
    

    }
        </script>
</body>
</html>