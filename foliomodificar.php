<?php
    //Librerias para base de datos y eliminar acentos
     include_once('librerias/info.php');
     include_once('librerias/elimina_acentos.php');
     if(!empty($_POST['folio'])){
     $folio = $_POST['folio'];
     }else{
      $folio = $_GET['folio'];
     }
     //Seleccionando los datos de un reporte que acaba de ser modificado para mostrarlo en la pantalla
     $query = "SELECT folio FROM reportes WHERE folio LIKE $folio";
     $statement = $db->prepare($query);
     $statement->execute();
     $x = $statement->fetch();
     $x=$x['folio'];
     $statement->closeCursor();

     $query = "SELECT folio, causa, asunto, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area, detalles, estado FROM reportes WHERE folio=$x";
     $statement = $db->prepare($query);
     $statement->execute();
     $reporte = $statement->fetch();
     $statement->closeCursor();
 ?>

<!-- Encontrado -->
<!doctype html>
 <html lang="en">
     <head>
<!-- Icono -->
         <link rel="icon" type="image/png" href="img/icono.png" />
         <title>Folio</title>
<!-- Required meta tags -->
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS && Lubrerias para toda la family -->
         <link rel="stylesheet" href="css/bootstrap.min.css">
         <link rel="stylesheet" href="librerias/estilo.css">
        <link rel="stylesheet" href="librerias/fuente.css">
         <link rel="stylesheet" href="menu.css">
     </head>
     <body>
<!--encabezado-->
         <div class="jumbotron" style="text-align:center">
<!-- imagen del lado derecho -->
             <img src="img/Logo Chihuahua.png" alt="" style="height:150px; width:150px" align="right">
<!-- Nombres -->
             <h1 class="display-6">SECRETARÍA DE DESARROLLO URBANO Y ECOLOGÍA</h1>
             <p class="lead">ÁREA DE SISTEMAS / REPORTE </p>
         </div>
<!-- Container -->
         <div class="container">
             <form>   
             <?php if($reporte['estado']==0){?>
                 <div class="row">
<!-- parte izquierda del contenedor -->
                     <div class="col">
                         <label>FOLIO</label>
                         <input form="main" name="folio" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['folio'];?>">
                         
                         <label>ASUNTO</label>
                         <input name="asunto" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['asunto'];?>">
                         
                         <label>QUIEN REPORTA</label>
                         <input name="usuario" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['usuario']?>">
                     </div>
<!-- parte derecha del contenedor -->
                     <div class="col">   
                         <label>DEPARTAMENTO</label>
                         <input name="area" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['area'];?>">
                         
                         <label>PERSONAL QUE LEVANTÓ</label>
                         <input style="text-align:center; " type="text" class="form-control" disabled
                         value="<?php echo $reporte['personal_levanta'];?>">
                         
                         <label>PERSONAL QUE ATENDERÁ</label>
                         <input  style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['personal_atiende']?>">
                     </div>
                 </div>
             <?php }else{?>
                <div class="row">
<!-- parte izquierda del contenedor -->
                     <div class="col">
                         <label>FOLIO</label>
                         <input form="main" name="folio" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['folio'];?>">
                         
                         <label>ASUNTO</label>
                         <input name="asunto" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['asunto'];?>">
                         
                         <label>QUIEN REPORTA</label>
                         <input name="usuario" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['usuario']?>">
                         <label>DETALLES</label>
                         <textarea style="text-align:center; height:110px; font-family:Gotham-Book;" type="text" class="form-control" 
                         disabled><?php echo $reporte['detalles']?></textarea>
                         
                     </div>
<!-- parte derecha del contenedor -->
                     <div class="col">   
                         <label>DEPARTAMENTO</label>
                         <input name="area" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['area'];?>">
                         
                         <label>PERSONAL QUE LEVANTÓ</label>
                         <input style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['personal_levanta'];?>">
                         
                         <label>PERSONAL QUE ATENDIÓ</label>
                         <input  style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['personal_atiende']?>">
                         <div class="row">
                         <div class="col">
                         <label>FECHA EN QUE SE ATENDIÓ</label>
                         <input  style="text-align:center;" type="text" class="form-control" disabled
                         value="<?php echo pon_diagonal($reporte['fecha_atiende'])?>">
                         </div>
                         <div class="col">
                         <label>FECHA EN QUE SE LEVANTÓ</label>
                         <input  style="text-align:center;" type="text" class="form-control" disabled
                         value="<?php echo pon_diagonal($reporte['fecha_levanta'])?>">
                         </div>
                         </div>
                         <label>CAUSA</label>
                         <input name="usuario" style="text-align:center" type="text" class="form-control" disabled
                         value="<?php echo $reporte['causa']?>">
                     </div>
                 </div>
             <?php }?>
             </form>
             <br>
             <div class="row" align="center">

                 <div class="col" align="right">
                     <a class="btn btn-outline-primary"<?php  
                     if(isset($_POST['code'])){
                     if($_POST['code']=="terminado"){ echo 'href="terminar.php"'; }
                     elseif($_POST['code']=="modificar"){ echo 'href="modificar.php"'; }
                     
                     }elseif($_GET['code']=="levanta"){ echo 'href="capturar.php"'; }
                     ?>role="button">ACEPTAR</a>
                 </div>
                 <div class="col" align="center">
                 <a class="btn btn-outline-primary" href="pdf.php?folio=<?php echo $reporte['folio'];?>" 
                 role="button">PDF</a>
                 </div>
                 <div class="col" align="left">
                    <form action="modificar.php" method="post">
                     <input name="folio" value="<?php echo $reporte['folio'];?>" hidden>
                     <button type="submit" class="btn btn-outline-primary">MODIFICAR</button>
                    </form>
                 </div>

             </div>
<!-- fin del contenedor -->
         </div>
<!-- Librerias No Mover >:V -->
         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
         <script src="js/bootstrap.min.js"></script>
        
     </body>
 </html>
 

<!-- Creado por Brayan Prieto && Angel Vega 2018-2019 -->