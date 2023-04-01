<?php
require('../../fpdf/fpdf.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
session_start();
    if (isset($_SESSION["user_name"]) && !empty($_SESSION["user_name"])){
    if (isset($_SESSION["admin_status"]) && !empty($_SESSION["admin_status"])){
    $sesion=$_SESSION["admin_status"];   
        }else{
        header('Location: ../logout.php');}
        }else{
        header('Location: ../logout.php');
        }
        if ($sesion =="false"){
        header("location:javascript://history.go(-1)");
        }
    $id=$_GET['id'];
    $type=$_GET['type'];
    $timezone = new DateTimeZone('America/Caracas'); 
$date=new DateTime(null,$timezone);
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../Imagenes/puntomini.jpg',10,6,40);
    global $title;
    global $subtitle;
    global $header;
    global $subtitle2;
    global $subtitle3;
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Calculamos ancho y posición del título.
    $w = $this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    // Colores de los bordes, fondo y texto
    // Ancho del borde (1 mm)
    // Título
    $this->Cell($w,20,$title,'C',true);
    $this->SetFont('Arial','B',12);
    // Calculamos ancho y posición del título.
    $w = $this->GetStringWidth($subtitle)+6;
    $this->SetX((210-$w)/2);
    $this->Cell($w,6,$subtitle,'C',true);
    $w = $this->GetStringWidth($subtitle2)+6;
    $this->SetX((210-$w)/2);
    $this->Cell($w,6,$subtitle2,'C',true);
    $w = $this->GetStringWidth($subtitle3)+6;
    $this->SetX((210-$w)/2);
    $this->Cell($w,6,$subtitle3,'C',true);
    // Salto de línea
    $this->Ln(6);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','IB',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
function FancyTable($header, $data)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(155,240,255);
    $this->SetTextColor(30);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',10);
    // Cabecera
    $w = array(45, 50, 50, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row['Id_actividad'],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row['Descripcion_actividad'],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row['Objetivo_actividad'],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row['Fecha_actividad'],'LR',0,'L',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}
}
$nombre=null;
$apellido=null;
// Creación del objeto de la clase heredada
$pdf = new PDF();
$con = mysqli_connect("localhost","root","","bd_puntoplast");
if($type==1){
$clie=mysqli_query($con,'SELECT * FROM cliente inner join usuario using(Id_usu) WHERE Id_usu="'.$id.'"');
$cliente=mysqli_fetch_array($clie,MYSQLI_ASSOC);
$nombre=$cliente['Nomb_clie'];
$apellido=$cliente['Ape_clie'];
$cedula=$cliente['Ci_clie'];
$subtitle ='Usuario: '.$cliente['Id_usu'];
$subtitle2 ='Ci: '.$cedula;
}else{
$clie=mysqli_query($con,'SELECT * FROM usuario WHERE Id_usu="'.$id.'"');
$cliente=mysqli_fetch_array($clie,MYSQLI_ASSOC);
$nombre=$cliente['Id_usu'];
$apellido=null;
$subtitle = 'Usuario: '.$cliente['Id_usu'];  
$subtitle2 = 'Administrador';
}
$title = 'Reporte de actividad de '.$nombre.' '.$apellido;
$subtitle3 = 'Emitido el: '.$date->format('Y-m-d H:i:s');
// Títulos de las columnas
$header = array('ID', 'Actividad', 'Objetivo', 'Fecha');
// Carga de datos
$pdf->AddPage();
$result=mysqli_query($con,"SELECT * FROM actividad INNER JOIN usuario USING(Id_usu) WHERE Id_usu='".$id."' ORDER BY Id_actividad");      
$pdf->SetTitle($title);
$data=$result;
$pdf->SetFont('Arial','',12);
$pdf->AliasNbPages();
$pdf->FancyTable($header,$data);
//print_r($);
$pdf->Output();
}else{
header('location:javascript://history.go(-1)');}
?>