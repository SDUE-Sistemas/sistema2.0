<?php
$folio=$_GET['folio'];
include_once('librerias/info.php');
$query = "SELECT folio, asunto, usuario, fecha_levanta, fecha_atiende, personal_levanta, personal_atiende, area, detalles, causa FROM reportes WHERE folio LIKE $folio";
$statement = $db->prepare($query);
$statement->execute();
$reporte = $statement->fetch();
$statement->closeCursor();

$folio="FOLIO: ";
$folio .=$reporte['folio'];

$asunto="ASUNTO: ";
$asunto .=$reporte['asunto'];

$fecha_l="FECHA QUE SE LEVANTO: ";
$fecha_l .=$reporte['fecha_levanta'];

$fecha_a="FECHA DE ATENCION: ";
if(!empty($reporte['fecha_atiende'])){
$fecha_a .=$reporte['fecha_atiende'];
}else{
$fecha_a .="";
}
$usuario="USUARIO: ";
$usuario .=$reporte['usuario'];

$departamento="DEPARTAMENTO: ";
$departamento .=$reporte['area'];

$tecnico="PERSONAL: ";
if(!$reporte['personal_atiende']=="DEJAR A CRITERIO DE UN ADMINISTRADOR"){
$tecnico .=$reporte['personal_atiende'];
}
$detalles="";

$detalles .=$reporte['detalles'];

if(empty($detalles)){
$obser="____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
}else{
  $obser=$detalles;
}

require('fpdf/fpdf.php');
$texto = "Normally, both your asses would be dead as fucking fried chicken, but you happen to pull this shit while I'm in a transitional period so I don't wanna kill you, I wanna help you. But I can't give you this case, it don't belong to me. Besides, I've already been through too much shit this morning over this case to hand it over to your dumb ass.";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','I',10);
$pdf->Image('img/LogoHorizontal.png',160,6,46,15);
$pdf->Image('img/SDUE.png',10,6,46,15);
$pdf->Cell(180,33,'SECRETARIA DE DESARROLLO URBANO Y ECOLOGIA',0, 1 ,'C');
$pdf->Ln(-8);
$pdf->Cell(0, 0,'OFICINA DE INFORMATICA',0,0, 'C');
$pdf->Ln(8);
$pdf->Ln(5);
$pdf->Cell(100, 0,$folio);
$pdf->Cell(0, 0,$fecha_l);
$pdf->Ln(8);
$pdf->MultiCell(180,5,$asunto);
$pdf->Ln(8);
$pdf->Cell(0,0,$usuario);
$pdf->Ln(8);
$pdf->Cell(0,0,$departamento);
$pdf->Ln(8);
$pdf->Cell(0,0,$tecnico);
$pdf->Ln(8);

$pdf->Ln(8);
$pdf->Cell(0,0,"OBSERVACIONES",0 , 0, "C");
$pdf->Ln(8);
$pdf->MultiCell(180,10,$obser,0 , 1);
$pdf->Ln(8);
$pdf->Cell(20,5,"CAUSA: ",0 , 0);
$pdf->Cell(14,5,"FALLA",0 , 0);
if($reporte['causa']=="FALLA"){
$pdf->Cell(10,5,"",1 , 0, "L" , true);
}else{
  $pdf->Cell(10,5,"",1 , 0);
}
$pdf->Cell(30,5,"CAPACITACION",0 , 0);
if($reporte['causa']=="CAPACITACION"){
  $pdf->Cell(10,5,"",1 , 0, "L" , true);
  }else{
    $pdf->Cell(10,5,"",1 , 0);
  }
$pdf->Cell(45,5,"NUEVO REQUERIMIENTO",0 , 0);
if($reporte['causa']=="NUEVO REQUERIMIENTO"){
  $pdf->Cell(10,5,"",1 , 0, "L" , true);
  }else{
    $pdf->Cell(10,5,"",1 , 0);
  }
$pdf->Cell(12,5,"SEDU",0 , 0);
if($reporte['causa']=="SEDU"){
  $pdf->Cell(10,5,"",1 , 0, "L" , true);
  }else{
    $pdf->Cell(10,5,"",1 , 0);
  }
$pdf->Ln(10);
$pdf->Cell(100,5,$fecha_a);
$pdf->Ln(12);
$pdf->Cell(100,0,"FIRMA DEL USUARIO:");
$pdf->Cell(100,0,"FIRMA DEL PERSONAL:");
$pdf->Ln(8);
$pdf->Cell(100,0,"________________________");
$pdf->Cell(100,0,"________________________");
$pdf->Output();
?>