<!--sacar el ultimo folio con php-->
<?php
    include_once('info.php');
    $query = "SELECT folio FROM reportes WHERE folio = (SELECT max(folio) FROM reportes)";
    $statement = $db->prepare($query);
    $statement->execute();
    $folio_max = $statement->fetch();
    $statement->closeCursor();
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
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/estilos.css">
    <!-- script -->
    <script Language="JavaScript">
    function validar(){
       
        if(document.getElementById("asunto").value=="" ||  document.getElementById("quien_reporta").value==""){
            $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: success,
            dataType: dataType
            });
        }else{
            alert('Reporte guardado con exito');
        }
        }
    </script>
</head>
<!-- empieza el body -->
<body>

<!--encabezado-->
    
    <div class="scrollmenu">
      <ul class="nav">
        <a href="reportes.php">CAPTURAR</a>
        <a href="modificar.php">MODIFICAR REPORTES</a>
<!-- desplegable de buscar-->
        <li><a>BUSCAR</a>
          <ul>
				<li><a href="mostrando.php">POR FOLIO</a></li>
				<li><a href="mostrande.php">POR NOMBRE USUARIO</a></li>
				<li><a href="mostrandi.php">POR TECNICO</a></li>
                <li><a href="mostranda.php">POR AREA</a></li>          
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
        <p class="lead">AREA DE SISTEMAS / CAPTURAR </p>
    </div>
<!-- contenido -->
<!-- formulario -->
    <div class="container">
        <div class="row">
            <div class="col-md">
                <label>FOLIO</label>
                <input style="text-align:center" type="text" class="form-control" value="<?php echo $folio_max['folio']+1;?>" name="folio" disabled>
                <label>ASUNTO</label>
                <input type="text" class="form-control" id="asunto" >
                <label>QUIEN REPORTA</label>
                <input type="text" class="form-control" id="quien_reporta">
                
            </div>
            <div class="col-md">

                <label>DEPARTAMENTO</label>
            <!-- Desplegable  Ciclo For-->            
            <?php
            include_once('info.php');
            $query = "SELECT nombre FROM departamentos";
            $statement = $db->prepare($query);
            $statement->execute();
            $departamentos = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For-->
                <select class="form-control" name="tecnico" form="main">
                <?php  foreach($departamentos as $departamento): ?>
                  <option><?php echo $departamento['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                
                <label>PERSONAL QUE LEVANTO</label>
                <!-- Desplegable  Ciclo For-->
                <?php
            include_once('info.php');
            $query = "SELECT nombre FROM personal";
            $statement = $db->prepare($query);
            $statement->execute();
            $personals = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For-->
                <select class="form-control" name="tecnico" form="main">
                <?php  foreach($personals as $personal): ?>
                  <option><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
                <br>
                <!-- botones -->
                <div class="row">
                    <div class="col-md"></div>
                    <div class="col-md">
                    <button type="button" class="btn btn-outline-primary" onclick="validar();">AGREGAR</button>
                    </div>
                    <div class="col-md">
                <button onclick="location.href='capturar.php'" class="btn btn-outline-primary">CANCELAR</button>
                    </div>
                    <div class="col-md"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
