<?php
include_once("librerias/control_usuario.php");
include_once("librerias/info.php");
include_once("librerias/elimina_acentos.php");
$query = "SELECT folio, usuario, personal_levanta, area, fecha_levanta, asunto FROM reportes WHERE personal_atiende='".$user."' AND estado = 0";
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
        $("#fecha").datepicker();
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
        <p class="lead">AREA DE SISTEMAS / TERMINAR CAPTURAS </p>
    </div>
    <div class="container">

        <?php 
        if(empty($reportes)){
        echo "<div align='center'><h1>No tiene reportes sin atender</h1></div>";
        }
        foreach($reportes as $reporte):?>
            <div class="row">
                <div class="col">
                    <label for="">FOLIO</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['folio']; ?>" disabled> 
                    <label for="">USUARIO</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['usuario']; ?>" disabled>
                    <label for="">ASUNTO</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['asunto']; ?>" disabled>
                    
                    <label>DETALLES</label>
                    <textarea class="form-control" style="height:120px"></textarea>
                    <!-- height: width: -->
                </div>
                <div class="col">
                    <label for="">AREA</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['area']; ?>" disabled>
                    <label for="">FECHA EN QUE SE LEVANTO</label>
                    <input type="text" class="form-control" value="<?php echo pon_diagonal($reporte['fecha_levanta']) ?>" disabled>
                    <label for="">PERSONAL QUE LEVANTO</label>
                    <input type="text" class="form-control" value="<?php echo $reporte['personal_levanta']; ?>" disabled>
                    <label>CAUSA</label>
                    <select class="form-control">
                    <option>FALLA</option>
                    <option>CAPACITACION</option>
                    <option>NUEVO REQUERIMIENTO</option>
                    <option>SEDU</option>
                    </select>
                    <label for="">FECHA DE ATENCION</label>
                    <br>
                    <input type="text" name="fecha1" id="fecha1" class="datepicker"  readonly="readonly" size="60" style="
                    display: block;
                    width: 100%;
                    height: calc(2.25rem + 2px);
                    padding: 0.375rem 0.75rem;
                    font-size: 1rem;
                    line-height: 1.5;
                    color: #495057;
                    background-color: #fff;
                    background-clip: padding-box;
                    border: 1px solid #ced4da;
                    border-radius: 0.25rem;
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"/> 
                </div>
                
            </div>   
            <hr/>
        <?php endforeach; ?>
    </div>
</body>
</html>