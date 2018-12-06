<?php require_once('librerias/control_usuario.php'); ?>
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
    	
    <link rel="stylesheet" type="text/css" href="jquery-ui-1.7.2/jquery-1.3.2" />
    <link rel="stylesheet" type="text/css" href="jquery-ui-themes-1.7.2" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>

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
        <a href="termrepor.php">TERMINAR MIS REPORTES (<?php echo $n?>)</a>
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
<!-- MOSTRANDO LOS DATOS -->

    <div class="container">
    <form action="consulta_mostrar.php" method="post" id="main">
        <div class="row">
        <div class="btn-group" data-toggle="buttons">
                <label for="">folio <input type="checkbox" name="" id="chkfolio" onchange="checkFolio(this);" ></label>
                <input type="text" name="folio" id=folio disabled>
           
                <label>area
                <input type="checkbox" name="" id="chkarea" >
                </label>
                
            <!-- Desplegable  Ciclo For DEPARTAMENTOS-->            
            <?php
            $query = "SELECT nombre FROM departamentos";
            $statement = $db->prepare($query);
            $statement->execute();
            $departamentos = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For DEPARTAMENTOS-->
                <select name="area" id="area">
                <?php  foreach($departamentos as $departamento): ?>
                  <option><?php echo $departamento['nombre'];?></option>
                <?php endforeach; ?>
                </select>
            
                
          
                <label for="">fecha1
                <input type="checkbox" name="" id="chkfecha" autocomplete="off">
                </label>
                <input type="text" name="fecha1" id="fecha1" class="datepicker" readonly="readonly" size="12" />
                </div>
            <div class="row">
                
            
                <label for="">usuario <input type="checkbox" name="" id="chkusuario" autocomplete="off"></label>
                <input type="text" name="usuario" id="usuario">

                <label>personal <input type="checkbox" name="" ></label>
                <!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                <?php
            $query = "SELECT nombre FROM personal";
            $statement = $db->prepare($query);
            $statement->execute();
            $personals = $statement->fetchALL();
            $statement->closeCursor();
            ?>
                <!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                <select name="personal" id="personal">
                    <option>DEJAR A CRITERIO DE UN ADMINISTRADOR</option>
                <?php  foreach($personals as $personal): ?>
                  <option><?php echo $personal['nombre'];?></option>
                <?php endforeach; ?>
                </select>
       
                <button type="submit">buscar</button>
                <label for="">fecha2  <input type="checkbox" name="" id="" autocomplete="off">  </label>
                <input type="text" name="fecha2" id="fecha2" class="datepicker" readonly="readonly" size="12" />
                </div>
            </div>
        
        </div>
    </form>
    </div>
    <script src="librerias/calendario.js"></script>
    <script type="text/javascript">

    chkfolio.onclick = function(){
    			if (folio.disabled){
                    folio.disabled = false
                    area.disabled = true;
                    fecha1.disabled = true;
                    fecha2.disabled = true;
                    usuario.disabled = true;
                    personal.disabled = true;
    			}else{
                    folio.disabled = true
                    area.disabled = false;
                    fecha1.disabled = false;
                    fecha2.disabled = false;
                    usuario.disabled = false;
                    personal.disabled = false;
    			}
            }
    chkarea.onclick = function(){
    			if (area.disabled && folio.disabled){
    				area.disabled = false;
    			}else{
    				area.disabled = true;
    			}
            }
            chkfecha.onclick = function(){
    			if (area.disabled && folio.disabled){
                    fecha1.disabled = false;
                    fecha2.disabled = false;
    			}else{
                    fecha1.disabled = true;
                    fecha2.disabled = true;
    			}
    		}       

</script>
</body>
</html>