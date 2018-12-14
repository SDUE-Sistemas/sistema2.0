<?php
include_once("librerias/control_usuario.php");
include_once("librerias/info.php");
include_once("librerias/elimina_acentos.php");
$a = "DEJAR A CRITERIO DE UN ADMINISTRADOR";
$query = "SELECT folio, usuario, personal_levanta, area, fecha_levanta, asunto FROM reportes WHERE personal_atiende='".$a."' AND estado = 0";
$statement = $db->prepare($query);
$statement->execute();
$reportes = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="librerias/estilo.css">
    <link rel="stylesheet" href="librerias/fuente.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="librerias/calendario.js"></script>
    <script>
        $(function () {
        $(".fecha").datepicker();
        });
    </script>
    <title>Document</title>
</head>
<body>

<!--encabezado-->
    
    <div class="scrollmenu">
      <ul class="nav">
        <a href="capturar.php">CAPTURAR</a>
        <a href="modificar.php">MODIFICAR REPORTES</a>
        <a href="consulta.php">CONSULTAS</a>
        <a href="terminar.php">ASIGNAR REPORTES (<?php echo $n?>)</a>
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
        <p class="lead">ÁREA DE SISTEMAS / TERMINAR CAPTURAS </p>
    </div>
    
    <div class="container">

        <?php 
        if(empty($reportes)){
        echo "<div align='center'><h1>No hay reportes sin asignar</h1></div>";
        }
        foreach($reportes as $reporte):?>
        <form action="acabarasignar.php" method="post" id="form<?php echo $reporte['folio'];?>">
            <div class="row">
                <div class="col">
                
                    <label for="">FOLIO</label>
                    <input type="text" class="form-control"  value="<?php echo $reporte['folio']; ?>" disabled>
                    <input type="text" class="form-control" name="folio" value="<?php echo $reporte['folio']; ?>" hidden> 
                    <label for="">USUARIO</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['usuario']; ?>" disabled>
                    <label for="">ASUNTO</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['asunto']; ?>" disabled>
                    
                    
                    <!-- height: width: -->
                </div>
                <div class="col">
                
                    <label for="">AREA</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['area']; ?>" disabled>
                    <label for="">FECHA EN QUE SE LEVANTÓ</label>
                    <input type="text" class="form-control" value="<?php echo pon_diagonal($reporte['fecha_levanta']) ?>" disabled>
                    <label for="">PERSONAL QUE LEVANTÓ</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['personal_levanta']; ?>" disabled>
                    <label>PERSONAL QUE ATENDERA</label>
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
                </div> 
            </div>  
            <br>
        <div class="row" align="center">


        <div class="col"> <button type="submit" class="btn btn-outline-primary" form="form<?php echo $reporte['folio'];?>">GUARDAR</button> </div>

        </form>
        
        <div class="col">  <form action="modificar.php" method="post">
                     <input name="folio" value="<?php echo $reporte['folio'];?>" hidden>
                     <button type="submit" class="btn btn-outline-primary">MODIFICAR</button>
                    </form> </div>
        </div>            
        <hr/>    
        <?php endforeach; ?>
    </div>
    
</body>
</html>