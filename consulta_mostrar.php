
<!--sacar los datos de los reportes que vamos a consultar -->
<?php
require_once("librerias/control_usuario.php");
require_once('librerias/elimina_acentos.php');
require_once('librerias/info.php');
$query="SELECT folio, asunto, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area, detalles, causa, estado FROM reportes";
$ejem=$query;
if(isset($_POST['folio'])){

    $query .=" WHERE folio LIKE '".$_POST['folio']."'";

    $statement = $db->prepare($query);
    $statement->execute();
    $reporte = $statement->fetch();
    $statement->closeCursor();
    $code=1;

}else{
    
    if(isset($_POST['area'])){
        $query .=" WHERE area LIKE '".$_POST['area']."'";

    }
    if(isset($_POST['personal'])){
        if($query==$ejem){
            $query .=" WHERE personal_atiende LIKE '".$_POST['personal']."'";
        }else{
            
            $query .=" AND personal_atiende LIKE '".$_POST['personal']."'";
        }

    }
    if(isset($_POST['fecha1'])&&!empty($_POST['fecha2'])){
        $x=$_POST['fecha1'];
            $x=quita_diagonal($x); 
            $fecha1=0 + $x;
            $x=$_POST['fecha2'];
            $x=quita_diagonal($x); 
            $fecha2=0 + $x;

            
        if($query==$ejem){
            if($fecha2<$fecha1){
                $query .=" WHERE fecha_atiende BETWEEN '".$fecha2."' AND '".$fecha1."'";
            }else{
            $query .=" WHERE fecha_atiende BETWEEN '".$fecha1."' AND '".$fecha2."'";
            }
        }else{
            if($fecha2<$fecha1){
                $query .=" AND fecha_atiende BETWEEN '".$fecha2."' AND '".$fecha1."'";   
            }else{
                $query .=" AND fecha_atiende BETWEEN '".$fecha1."' AND '".$fecha2."'";
            }
        }

    }
    if(isset($_POST['usuario'])){
        if($query==$ejem){
            $query .=" WHERE usuario LIKE '".$_POST['usuario']."'";
        }else{
            $query .=" AND usuario LIKE '".$_POST['usuario']."'";
        }

    }
    if(isset($_POST['causa'])){
        if($query==$ejem){
            $query .=" WHERE causa LIKE '".$_POST['causa']."'";
        }else{
            $query .=" AND causa LIKE '".$_POST['causa']."'";
        }
    }
    $statement = $db->prepare($query);
    $statement->execute();
    $reportes = $statement->fetchAll();
    $statement->closeCursor();
    $code=0; 
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
        <p class="lead">ÁREA DE SISTEMAS / CONSULTAS </p>
    </div>
    </div>
    <div class="container">
    <?php
    
    if($code==1){
        
        if(!empty($reporte)){
            if($reporte['estado']==0){ ?>
<button class="btn btn-outline-primary" id="volver">VOLVER</button>
<form action="excel.php" method="post">
        <input type="text" name="query" value="<?php echo $query ?>" hidden>
        <input type="text" name="code" value="<?php echo $code ?>" hidden>
    <button class="btn btn-outline-primary" type="submit"> GENERAR EN EXCEL </button>
    </form>

                <a href="pdf.php?folio=<?php echo $reporte['folio'];?>" role="button" class="btn btn-outline-primary">PDF </a>
        <div class="row">
            <div class="col">
            
            <!-- si hay folio-->
                <label for="">FOLIO</label>
                <input class="form-control" value="<?php echo $reporte['folio']; ?>" type="text" disabled>
                <label for="">ASUNTO</label>
                <input class="form-control" value="<?php echo $reporte['asunto']; ?>" type="text" disabled>
                <label for="">USUARIO</label>
                <input class="form-control" value="<?php echo $reporte['usuario']; ?>" type="text" disabled>
                <label for="">FECHA EN QUE SE LEVANTO</label>
                <input class="form-control" value="<?php echo pon_diagonal($reporte['fecha_levanta']); ?>" type="text" disabled>

            </div>
            <div class="col">
                <label for="">PERSONAL QUE LEVANTO</label>
                <input class="form-control" value="<?php echo $reporte['personal_levanta'];?>" type="text" disabled>
                <label for="">PERSONAL QUE ATENDIO</label>
                <input class="form-control" value="<?php echo $reporte['personal_atiende']; ?>" type="text" disabled>
                <label for="">ÁREA</label>
                <input class="form-control" value="<?php echo $reporte['area']; ?>" type="text" disabled>
                <h1>Aún sin atender</h1>
                
            </div>
        </div>
        <br>
            <?php }else{
        ?>
        <button class="btn btn-outline-primary" id="volver">VOLVER</button>
        <form action="excel.php" method="post">
        <input type="text" name="query" value="<?php echo $query ?>" hidden>
        <input type="text" name="code" value="<?php echo $code ?>" hidden>
    <button class="btn btn-outline-primary" type="submit"> GENERAR EN EXCEL </button>
    </form>
        <div class="row">
            <div class="col">
            
            <!-- si hay folio-->
                <label for="">FOLIO</label>
                <input class="form-control" value="<?php echo $reporte['folio']; ?>" type="text" disabled>
                <label for="">ASUNTO</label>
                <input class="form-control" value="<?php echo $reporte['asunto']; ?>" type="text" disabled>
                <label for="">USUARIO</label>
                <input class="form-control" value="<?php echo $reporte['usuario']; ?>" type="text" disabled>
                <label for="">FECHA EN QUE SE LEVANTO</label>
                <input class="form-control" value="<?php echo pon_diagonal($reporte['fecha_levanta']); ?>" type="text" disabled>
                <label for="">FECHA EN QUE SE ATENDIO</label>
                <input class="form-control" value="<?php echo pon_diagonal($reporte['fecha_atiende']); ?>" type="text" disabled>
            </div>
            <div class="col">
                <label for="">PERSONAL QUE LEVANTO</label>
                <input class="form-control" value="<?php echo $reporte['personal_levanta'];?>" type="text" disabled>
                <label for="">PERSONAL QUE ATENDIO</label>
                <input class="form-control" value="<?php echo $reporte['personal_atiende']; ?>" type="text" disabled>
                <label for="">ÁREA</label>
                <input class="form-control" value="<?php echo $reporte['area']; ?>" type="text" disabled>
                <label for="">DETALLES</label>
                <textarea style="font-family: Gotham-Book;"class="form-control" type="text" disabled><?php echo $reporte['detalles']; ?></textarea>
                <label for="">CAUSA</label>
                <input class="form-control" value="<?php echo $reporte['causa']; ?>" type="text" disabled>
            </div>
        </div>
        <br>
    
    <?php 
            }    
}else{
        
    ?>  <div align="center">  <h1>no se encontro nada</h1>  </div><?php
    }
    
}else{
        if(!empty($reportes)){
            ?>
            <button class="btn btn-outline-primary" id="volver">VOLVER</button>
            <form action="excel.php" method="post">
        <input type="text" name="query" value="<?php echo $query ?>" hidden>
        <input type="text" name="code" value="<?php echo $code ?>" hidden>
    <button class="btn btn-outline-primary" type="submit"> GENERAR EN EXCEL </button>
    </form>
        <?php
    foreach ($reportes as $reporte){
       if($reporte['estado']==1){
        ?>
        <div class="row">
            <div class="col">
            <!-- si hay folio-->
                <label for="">FOLIO</label>
                <input class="form-control" value="<?php echo $reporte['folio']; ?>" type="text" disabled>
                <label for="">ASUNTO</label>
                <input class="form-control" value="<?php echo $reporte['asunto']; ?>" type="text" disabled>
                <label for="">USUARIO</label>
                <input class="form-control" value="<?php echo $reporte['usuario']; ?>" type="text" disabled>
                <label for="">FECHA EN QUE SE LEVANTO</label>
                <input class="form-control" value="<?php echo pon_diagonal($reporte['fecha_levanta']); ?>" type="text" disabled>
                <label for="">FECHA EN QUE SE ATENDIO</label>
                <input class="form-control" value="<?php echo pon_diagonal($reporte['fecha_atiende']); ?>" type="text" disabled>
            </div>
            <div class="col">
                <label for="">PERSONAL QUE LEVANTO</label>
                <input class="form-control" value="<?php echo $reporte['personal_levanta'];?>" type="text" disabled>
                <label for="">PERSONAL QUE ATENDIO</label>
                <input class="form-control" value="<?php echo $reporte['personal_atiende']; ?>" type="text" disabled>
                <label for="">ÁREA</label>
                <input class="form-control" value="<?php echo $reporte['area']; ?>" type="text" disabled>
                <label for="">DETALLES</label>
                <input class="form-control" value="<?php echo $reporte['detalles']; ?>" type="text" disabled>
                <label for="">CAUSA</label>
                <input class="form-control" value="<?php echo $reporte['causa']; ?>" type="text" disabled>
                <br>
                <a href="pdf.php?folio=<?php echo $reporte['folio'];?>" role="button" class="btn btn-outline-primary">PDF </a>
            </div>
        </div>
        <hr/>
        <br>

        <?php 
       }else{ ?>
        <div class="row">
            <div class="col">
            <!-- si hay folio-->
                <label for="">FOLIO</label>
                <input class="form-control" value="<?php echo $reporte['folio']; ?>" type="text" disabled>
                <label for="">ASUNTO</label>
                <input class="form-control" value="<?php echo $reporte['asunto']; ?>" type="text" disabled>
                <label for="">USUARIO</label>
                <input class="form-control" value="<?php echo $reporte['usuario']; ?>" type="text" disabled>
                <label for="">FECHA EN QUE SE LEVANTO</label>
                <input class="form-control" value="<?php echo pon_diagonal($reporte['fecha_levanta']); ?>" type="text" disabled>
               
            </div>
            <div class="col">
                <label for="">PERSONAL QUE LEVANTO</label>
                <input class="form-control" value="<?php echo $reporte['personal_levanta'];?>" type="text" disabled>
                <label for="">PERSONAL QUE ATENDIO</label>
                <input class="form-control" value="<?php echo $reporte['personal_atiende']; ?>" type="text" disabled>
                <label for="">ÁREA</label>
                <input class="form-control" value="<?php echo $reporte['area']; ?>" type="text" disabled>
                <br>
                <h1>Aún sin atender</h1>
                
                <a href="pdf.php?folio=<?php echo $reporte['folio'];?>" role="button" class="btn btn-outline-primary">PDF </a>
            </div>
        </div>
        <hr/>
        <br>
       <?php }
        }
        
    }else{
    ?>    
    <div align="center">  
    <h1>NO SE ENCONTRÓ NADA</h1>  
    <br>
    <button class="btn btn-outline-primary" id="volver">VOLVER</button>
    
    </div> <?php
    }
    }
 ?>
    </div>
   <script>
   volver.onclick= function(){
        location.href="consulta.php";
   }
   </script>
</body>
</html>