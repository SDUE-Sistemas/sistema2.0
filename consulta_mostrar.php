<!--sacar los datos de los reportes que vamos a consultar -->
<?php
require_once('librerias/elimina_acentos.php');
include_once('librerias/info.php');
$query="SELECT folio, asunto, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area, detalles, causa, estado FROM reportes";
$ejem="SELECT folio, asunto, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area, detalles, causa, estado FROM reportes";
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
            
            $query .=" WHERE fecha_atiende BETWEEN '".$fecha1."' AND '".$fecha2."'";
        }else{
            $query .=" AND fecha_atiende BETWEEN '".$fecha1."' AND '".$fecha2."'";
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
<!-- desplegable de buscar-->
        <li><a>BUSCAR</a>
          <ul>
				<li><a href="mfolio.php">POR FOLIO</a></li>
				<li><a href="musuario.php">POR NOMBRE USUARIO</a></li>
				<li><a href="mpersonal.php">POR PERSONAL</a></li>
                <li><a href="marea.php">POR AREA</a></li>          
          </ul>
        </li>
        <a href="termrepor.php">TERMINAR MIS REPORTES (<?php echo "x"?>)</a>
        </ul>
      </ul>
    </div>
<!-- jumbotron de la parte de arriba -->
    <div class="jumbotron" style="text-align:center">
<!-- imagen del lado derecho -->
        <img src="img/Logo Chihuahua.png" alt="" style="height:150px; width:150px" align="right">
<!-- Nombres -->
        <h1 class="display-6">SECRETARÍA DE DESARROLLO URBANO Y ECOLOGÍA</h1>
        <p class="lead">AREA DE SISTEMAS / MODIFICAR </p>
    </div>
    <div class="container">
    <?php if($code==1){?>
<div class="row">
            <div class="col">
            <!-- si hay folio-->
                <input value="<?php echo $reporte['folio']; ?>" type="text">
                <input value="<?php echo $reporte['asunto']; ?>" type="text">
                <input value="<?php echo $reporte['usuario']; ?>" type="text">
                <input value="<?php echo pon_diagonal($reporte['fecha_levanta']); ?>" type="text">
                <input value="<?php echo pon_diagonal($reporte['fecha_atiende']); ?>" type="text">
                <input value="<?php echo $reporte['personal_levanta'];?>" type="text">
                <input value="<?php echo $reporte['personal_atiende']; ?>" type="text">
                <input value="<?php echo $reporte['area']; ?>" type="text">
                <input value="<?php echo $reporte['detalles']; ?>" type="text">
                <input value="<?php echo $reporte['causa']; ?>" type="text">
                <!-- folio, asunto, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area, detalles, causa, estado -->
            </div>
        </div>
    <?php }else{
    foreach ($reportes as $reporte){
       
        ?>
        <div class="row">
            <div class="col">
            <!-- no hay folio -->
                <input value="<?php echo $reporte['folio']; ?>" type="text">
                <input value="<?php echo $reporte['asunto']; ?>" type="text">
                <input value="<?php echo $reporte['usuario']; ?>" type="text">
                <input value="<?php echo pon_diagonal($reporte['fecha_levanta']); ?>" type="text">
                <input value="<?php echo pon_diagonal($reporte['fecha_atiende']); ?>" type="text">
                <input value="<?php echo $reporte['personal_levanta'];?>" type="text">
                <input value="<?php echo $reporte['personal_atiende']; ?>" type="text">
                <input value="<?php echo $reporte['area']; ?>" type="text">
                <input value="<?php echo $reporte['detalles']; ?>" type="text">
                <input value="<?php echo $reporte['causa']; ?>" type="text">
            </div>
        </div>
        <?php 
        }
    }

 ?>
    </div>
   
</body>
</html>