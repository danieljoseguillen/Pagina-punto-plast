<?php
require('../../fpdf/fpdf.php');
session_start();
    if (isset($_SESSION["user_name"]) && !empty($_SESSION["user_name"])){
    if (isset($_SESSION["admin_status"]) && !empty($_SESSION["admin_status"])){
    $sesion=$_SESSION["admin_status"];   
        }else{
        header('Location: ../logout.php');}
        }else{
        header('Location: ../logout.php');
        }
        if ($sesion =="true"){
        header("location:javascript://history.go(-1)");
        }
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
    global $subtitle2;
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
    $this->Cell($w,2,$subtitle,'C',true);
    $w = $this->GetStringWidth($subtitle2)+6;
    $this->SetX((210-$w)/2);
    $this->Cell($w,12,$subtitle2,'C',true);
    // Salto de línea
    $this->Ln(8);
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
    $this->SetFont('','B',9);
    // Cabecera
    $w = array(30, 40, 45, 35, 40);
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
        $this->Cell($w[0],6,$row['Num_ped'],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row['Fecha_ped'],'LR',0,'R',$fill);
        $this->Cell($w[2],6,$row['Estado_ped'],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row['cantidad'],'LR',0,'R',$fill);
        $this->Cell($w[4],6,$row['total'],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$con = mysqli_connect("localhost","root","","bd_puntoplast");
$clie=mysqli_query($con,'SELECT * FROM cliente inner join usuario using(Id_usu) WHERE Id_usu="'.$_SESSION["user_name"].'"');
$cliente=mysqli_fetch_array($clie,MYSQLI_ASSOC);
$title = 'Reporte de pedidos de '. $cliente['Nomb_clie'].' '.$cliente['Ape_clie'];
$subtitle = 'Ci: '.$cliente['Ci_clie'];
$subtitle2 = 'Emitido el: '.$date->format('Y-m-d H:i:s');
// Títulos de las columnas
$header = array('Nro Pedido', 'Fecha', 'Estado', 'Productos', 'Total');
// Carga de datos
$pdf->AddPage();
$result=mysqli_query($con,'SELECT Num_ped, Fecha_ped, Estado_ped, SUM(Cant_prod_ped) as cantidad, SUM(Precio_cant_ped) as total FROM `pedido` inner join pedido_producto using(Num_ped) WHERE Ci_clie="'.$cliente['Ci_clie'].'" group by Num_ped order by Num_ped');
$pdf->SetTitle($title);
$data=$result;
$pdf->SetFont('Arial','',12);
$pdf->AliasNbPages();
$pdf->FancyTable($header,$data);
//print_r($);
$pdf->Output();
?>