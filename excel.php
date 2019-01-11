<?php

//Libreiras para Base de Datos y Modificar cadena de caracteres
require_once("librerias/info.php");

require_once('librerias/elimina_acentos.php');

$query=$_POST['query'];

$code=$_POST['code'];



if($code==1){
    //Si solo hay un reporte
    $statement = $db->prepare($query);
    $statement->execute();
    $reporte = $statement->fetch();
    $statement->closeCursor();
    $filas=1;
}
elseif($code==0){
    //existe mas de un reporte
    $statement = $db->prepare($query);
    $statement->execute();
    $reportes = $statement->fetchAll();
    $statement->closeCursor();
    $filas=contarFilas($reportes);
}
//libreria para generar el Excel

require_once('Classes/PHPExcel.php');

$hoja = new PHPExcel();
//Dar formato al Excel
$hoja->getProperties()
->setCreator("Oficina de sistemas")
->setTitle("")
->setDescription("INFORME MENSUAL");

$hoja->setActiveSheetIndex(0);
$hoja->getActiveSheet()->setTitle('INFORME MENSUAL');
$hoja->getActiveSheet()->getRowDimension('F')->setRowHeight(40);;
$hoja->getActiveSheet()->getColumnDimension('F')->setWidth(23);
$hoja->getActiveSheet()->getColumnDimension('E')->setWidth(23);
$hoja->getActiveSheet()->getColumnDimension('H')->setWidth(16);
$hoja->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$hoja->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$hoja->getActiveSheet()->setCellValue('A1', 'FOLIO');
$hoja->getActiveSheet()->setCellValue('B1', 'ASUNTO');
$hoja->getActiveSheet()->setCellValue('C1', 'FECHA EN QUE SE LEVANTÓ');
$hoja->getActiveSheet()->setCellValue('D1', 'FECHA EN QUE SE ATENDIÓ');
$hoja->getActiveSheet()->setCellValue('E1', 'PERSONAL QUE LEVANTÓ');
$hoja->getActiveSheet()->setCellValue('F1', 'PERSONAL QUE ATENDIÓ');
$hoja->getActiveSheet()->setCellValue('G1', 'AREA');
$hoja->getActiveSheet()->setCellValue('H1', 'OBSERVACIONES');
$hoja->getActiveSheet()->setCellValue('I1', 'CAUSA');
$c=2;
if(isset($reportes)){
    //Si hay varios reportes se hace un ciclo para imprimirlos todos
    foreach($reportes as $reporte){
        $hoja->getActiveSheet()->setCellValue('A'.$c, $reporte['folio']);
        $hoja->getActiveSheet()->setCellValue('B'.$c, $reporte['asunto']);
        $hoja->getActiveSheet()->setCellValue('C'.$c, pon_diagonal($reporte['fecha_levanta']));
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('D'.$c, pon_diagonal($reporte['fecha_atiende']));
        }else{
            $hoja->getActiveSheet()->setCellValue('D'.$c,'N/T');
        }
        $hoja->getActiveSheet()->setCellValue('E'.$c, $reporte['personal_levanta']);
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('F'.$c, $reporte['personal_atiende']);
        }else{
            $hoja->getActiveSheet()->setCellValue('F'.$c, 'N/T');
        }
        $hoja->getActiveSheet()->setCellValue('G'.$c, $reporte['area']);
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('H'.$c, $reporte['detalles']);
        }else{
            $hoja->getActiveSheet()->setCellValue('H'.$c,'N/T');
        }
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('I'.$c, $reporte['causa']);
        }else{
            $hoja->getActiveSheet()->setCellValue('I'.$c,'N/T');
        }
        
        $c++;
    }

}else{
    //En caso de que solo sea uno el que se desea generar excel
    $hoja->getActiveSheet()->setCellValue('A'.$c, $reporte['folio']);
        $hoja->getActiveSheet()->setCellValue('B'.$c, $reporte['asunto']);
        $hoja->getActiveSheet()->setCellValue('C'.$c, pon_diagonal($reporte['fecha_levanta']));
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('D'.$c, pon_diagonal($reporte['fecha_atiende']));
        }else{
            $hoja->getActiveSheet()->setCellValue('D'.$c,'N/T');
        }
        $hoja->getActiveSheet()->setCellValue('E'.$c, $reporte['personal_levanta']);
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('F'.$c, $reporte['personal_atiende']);
        }else{
            $hoja->getActiveSheet()->setCellValue('F'.$c, 'N/T');
        }
        $hoja->getActiveSheet()->setCellValue('G'.$c, $reporte['area']);
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('H'.$c, $reporte['detalles']);
        }else{
            $hoja->getActiveSheet()->setCellValue('H'.$c,'N/T');
        }
        if($reporte['estado']==1){
            $hoja->getActiveSheet()->setCellValue('I'.$c, $reporte['causa']);
        }else{
            $hoja->getActiveSheet()->setCellValue('I'.$c,'N/T');
        }
        
}

ob_end_clean(); 

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename='INFORME.xlsx'");
header('Cache-Control: max-age=0');

$hoja = PHPExcel_IOFactory::createWriter($hoja, 'Excel2007');
$hoja ->save('php://output');
exit;
?>
<!-- Creado por Brayan Prieto && Angel Vega -->