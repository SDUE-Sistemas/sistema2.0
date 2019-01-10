<?php 
//Libreria para loguearse
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
    <link rel="stylesheet" href="jq/jquery-ui.css" />
    <script src="jq/jquery-1.9.1.js"></script>
    <script src="jq/jquery-ui.js"></script>
    <script src="librerias/calendario.js"></script>
    <script>
    //Funcion para las fechas
        $(function () {
        $("#fecha").datepicker();
        });
    </script>
    
</head>
<!-- empieza el body -->
<body >

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
                //Funcion para desloguearse
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
    <div class="container">
        <form action="consulta_mostrar.php" method="post" id="main">
            <div class="row">
                <div class="col" align="center">
                    <label for="">FOLIO</label>
                        <input type="checkbox" name="" id="chkfolio" onchange="checkFolio(this);">
                        <!-- Boton que nos habilita para buscar un reporte por su Folio, pero no deja habilitar mas campos -->
                    <input  style="text-align:center" class="form-control" name="folio" id=folio disabled>
                    <br>

                    <label for="">FECHA DE ATENCIÓN</label>
                    <!--Boton que habilita para buscar todos los reportes hechos de una fecha a otra -->
                    <input type="checkbox" name="chkfechas" id="chkfechas" >
                    
                    <div class="row">
                    <div class="col">
                    <label for="">FECHA 1</label>
                    <!-- Campo fecha 1 -->
                    <br>

                    <input  disabled name="fecha1" id="fecha1" class="datepicker"  readonly="readonly" size="9" style="
                    text-align:center;
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
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"/>
                    </div><div class="col">
                    <label for="">FECHA 2</label>
                    <!-- Campo fecha 2 -->
                    <input  name="fecha2" disabled id="fecha2" class="datepicker" readonly="readonly" size="9" style="text-align:center
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
                    
                    
                    </div>
                    </div>                    
                </div>
                <div class="col">
                    

                    <div align="left">
                        <label>ÁREA</label>
                            <input type="checkbox" name="" id="chkarea" >
                        <!-- Boton que nos habilita el campo de area -->
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
                    <select name="area" id="area" disabled class="form-control" style="text-align:center">
                    <?php  foreach($departamentos as $departamento): ?>
                        <option><?php echo $departamento['nombre'];?></option>
                    <?php endforeach; ?>
                    </select>       
                    
                    <label>PERSONAL</label>
                        <input type="checkbox" name="chkpersonal" id="chkpersonal" >
                    <!-- Boton que nos habilita el personal -->

<!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                    <?php
                        $query = "SELECT nombre FROM personal";
                        $statement = $db->prepare($query);
                        $statement->execute();
                        $personals = $statement->fetchALL();
                        $statement->closeCursor();
                    ?>
<!-- Desplegable  Ciclo For QUIEN ATIENDE-->
                    <select name="personal" id="personal" style="text-align:center" disabled class="form-control">
                    <option>DEJAR A CRITERIO DE UN ADMINISTRADOR</option>
                    <?php  foreach($personals as $personal): ?>
                    <option><?php echo $personal['nombre'];?></option>
                    <?php endforeach; ?>
                    </select>
                            
                    <label for="">USUARIO</label>
                        <input type="checkbox" name="chkusuario" id="chkusuario" >
                    <!-- boton que nos habilita los Usuarios -->
                    
                    <input name="usuario" id="usuario" disabled class="form-control" style="text-align:center">
                    <br>
                    <button class="btn btn-outline-primary" type="submit" name="buscar" id="buscar" onclick="validar();">BUSCAR</button>
                    <!-- Boton para verificar que los campos estan llenos -->
                    <button class="btn btn-outline-primary" onclick="fecha1.value=''; event.preventDefault();">LIMPIAR FECHA 1</button>
                    <button class="btn btn-outline-primary" onclick="fecha2.value=''; event.preventDefault();">LIMPIAR FECHA 2</button>
                    <!-- Botones para eliminar la fecha que se puso anteriormente -->
                </div>
            </div>
        </form>
    </div>
    
    <script type="text/javascript">

    chkfolio.onclick = function(){
    	if (folio.disabled){
            //Si Folio no esta habilitado que te permita marcar todos los campos
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
           //De lo contrario Folio esta habilitado
		}
    }
    chkarea.onclick = function(){
		if (area.disabled && folio.disabled){
            //Si el area esta habilitada y Folio no, que se el area se marque
			area.disabled = false;
		}else{
            //De lo contrario Folio si esta habilitado, entonces no se habilita el area
			area.disabled = true;
		}
    }
    chkfechas.onclick = function(){
		if (fecha1.disabled && fecha2.disabled && folio.disabled){
            //Si se habilita las Fechas y Folio no esta Activado si se pueden usar
            fecha1.disabled = false;
            fecha2.disabled = false;
		}else{
            //De lo contrario Folio esta habilitado entonces no se pueden usar los campos
            fecha1.disabled = true;
            fecha2.disabled = true;
		}
    }
    chkusuario.onclick = function(){
        if(usuario.disabled && folio.disabled){
            //usuario esta habilitado y Folio no esta, se puede usar el campo
            usuario.disabled = false;
        }else{
            //De lo contrario Folio esta habilitado y no se puede utilizar el campo
            usuario.disabled = true;
        }
    }
    chkpersonal.onclick = function(){
        if(personal.disabled && folio.disabled){
            //personal esta habilitado y Folio no esta, se puede usar el campo
            personal.disabled = false;
        }else{
            //De lo contrario folio esta habilitado y no se puede usar el campo
            personal.disabled = true;
        }
    }

    
    function validar(){
        if(!folio.disabled & folio.value==""){
        //El campo de se habilito y no se ingreso ningun folio
            alert("Folio esta vacio");
            event.preventDefault();
        }
        if(!fecha1.disabled & !fecha2.disabled){
             //El campo de fechas se habilito y no se llenaron las 2 Fechas
            if(fecha1.value=="" | fecha2.value==""){
            alert("alguna fecha esta vacia");
            event.preventDefault();
        }
    }
        if(!usuario.disabled & usuario.value==""){
            //El campo de usuario se habilito y no se escribio ningun nombre
            alert("Usuario esta vacio");
            event.preventDefault();
        }   
        
    }

</script>


</body>
</html>

<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->