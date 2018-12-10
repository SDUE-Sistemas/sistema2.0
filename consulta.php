<?php 
include_once("librerias/control_usuario.php");
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
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script>
        $(function () {
        $("#fecha").datepicker();
        });
    </script>
    <style>
        .datepicker:disabled {
        background-color: #e9ecef;
        opacity: 1;
}
    </style>
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
        <p class="lead">AREA DE SISTEMAS / CONSULTAS </p>
    </div>
    <div class="container">
        <form action="consulta_mostrar.php" method="post" id="main">
            <div class="row">
                <div class="col" align="center">
                    <label for="">FOLIO</label>
                        <input type="checkbox" name="" id="chkfolio" onchange="checkFolio(this);">
                    
                    <input type="text"  class="form-control" name="folio" id=folio disabled>
                    <br>

                    <label for="">FECHAS</label>
                    <input type="checkbox" name="chkfechas" id="chkfechas" checked>
                    
                    <div class="row">
                    <div class="col">
                    <label for="">FECHA 1</label>
                    <label for="">FECHA 2</label>
                    <br>

                    <input type="text" name="fecha1" id="fecha1" class="datepicker"  readonly="readonly" size="9" style="
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
                    
                    <input type="text" name="fecha2" id="fecha2" class="datepicker" readonly="readonly" size="9" style="
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
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
                    
                    ;"/>
                    
                    
                    </div>
                    </div>                    
                </div>
                <div class="col">
                    

                    <div align="left">
                        <label>AREA</label>
                            <input type="checkbox" name="" id="chkarea" checked>
                        
                    </div>
<!-- Desplegable  Ciclo For DEPARTAMENTOS-->            
                    <?php
                        $query = "SELECT nombre FROM departamentos";
                        $statement = $db->prepare($query);
                        $statement->execute();
                        $departamentos = $statement->fetchALL();
                        $statement->closeCursor();
                    ?>
<!-- Desplegable  Ciclo For DEPARTAMENTOS-->
                    <select name="area" id="area" class="form-control">
                    <?php  foreach($departamentos as $departamento): ?>
                        <option><?php echo $departamento['nombre'];?></option>
                    <?php endforeach; ?>
                    </select>       
                    
                    <label>PERSONAL</label>
                        <input type="checkbox" name="chkpersonal" id="chkpersonal" checked>
                    

<!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                    <?php
                        $query = "SELECT nombre FROM personal";
                        $statement = $db->prepare($query);
                        $statement->execute();
                        $personals = $statement->fetchALL();
                        $statement->closeCursor();
                    ?>
<!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                    <select name="personal" id="personal" class="form-control">
                    <option>DEJAR A CRITERIO DE UN ADMINISTRADOR</option>
                    <?php  foreach($personals as $personal): ?>
                    <option><?php echo $personal['nombre'];?></option>
                    <?php endforeach; ?>
                    </select>
                            
                    <label for="">USUARIO</label>
                        <input type="checkbox" name="chkusuario" id="chkusuario" checked>
                    
                    
                    <input type="text" name="usuario" id="usuario" class="form-control">
                    <br>
                    <button class="btn btn-outline-primary" type="submit" name="buscar" id="buscar" onclick="validar();">BUSCAR</button>

                    <button class="btn btn-outline-primary" onclick="fecha1.value=''; event.preventDefault();">LIMPIAR FECHA 1</button>
                    <button class="btn btn-outline-primary" onclick="fecha2.value=''; event.preventDefault();">LIMPIAR FECHA 2</button>
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
            chkarea.checked = false;
            fecha1.disabled = true;
            fecha2.disabled = true;
            chkfechas.checked = false;
            usuario.disabled = true;
            chkusuario.checked = false;
            personal.disabled = true;
            chkpersonal.checked = false;
		}else{
            folio.disabled = true
            area.disabled = false;
            chkarea.checked = true;
            fecha1.disabled = false;
            fecha2.disabled = false;
            chkfechas.checked = true;
            usuario.disabled = false;
            chkusuario.checked = true;
            personal.disabled = false;
            chkpersonal.checked = true;
		}
    }
    chkarea.onclick = function(){
		if (area.disabled && folio.disabled){
			area.disabled = false;
		}else{
			area.disabled = true;
		}
    }
    chkfechas.onclick = function(){
		if (fecha1.disabled && fecha2.disabled && folio.disabled){
            fecha1.disabled = false;
            fecha2.disabled = false;
		}else{
            fecha1.disabled = true;
            fecha2.disabled = true;
		}
    }
    chkusuario.onclick = function(){
        if(usuario.disabled && folio.disabled){
            usuario.disabled = false;
        }else{
            usuario.disabled = true;
        }
    }
    chkpersonal.onclick = function(){
        if(personal.disabled && folio.disabled){
            personal.disabled = false;
        }else{
            personal.disabled = true;
        }
    }

    
    function validar(){
        if(!folio.disabled & folio.value==""){
            alert("Folio esta vacio");
            event.preventDefault();
        }
        if(!fecha1.disabled & !fecha2.disabled){
            if(fecha1.value=="" & fecha2.value==""){
            alert("alguna fecha esta vacia");
            event.preventDefault();
        }
    }
        if(!usuario.disabled & usuario.value==""){
            alert("Usuario esta vacio");
            event.preventDefault();
        }   
        
    }

</script>

</body>
</html>