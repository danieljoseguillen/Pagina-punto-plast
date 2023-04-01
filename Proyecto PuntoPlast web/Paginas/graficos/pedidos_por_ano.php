<?php
require_once ('../../jpgraph/src/jpgraph.php');
require_once ('../../jpgraph/src/jpgraph_bar.php');
$con = mysqli_connect("localhost","root","","bd_puntoplast");
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
$year=$_GET['year'];
    
$result=mysqli_query($con,'SELECT (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="01") as enero, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="02") as febrero, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="03") as marzo, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="04") as abril, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="05") as mayo, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="06") as junio, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="07") as julio, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="08") as agosto, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="09") as septiembre, (SELECT  COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="10") as octubre, (SELECT COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="11") as noviembre, (SELECT  COUNT(Num_ped) FROM pedido WHERE Estado_ped="Procesado" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)="12") as diciembre');

// Creamos el grafico
$labels=array("Enero", "febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
while($row=$result->fetch_array()){
    $datos=array($row['enero'],$row['febrero'],$row['marzo'],$row['abril'],$row['mayo'],$row['junio'],$row['julio'],$row['agosto'],$row['septiembre'],$row['octubre'],$row['noviembre'],$row['diciembre']);
}
$grafico = new Graph(500, 500, 'auto');
$grafico->SetShadow();
$grafico->SetScale("textint");
$grafico->img->SetMargin(50,10,50,90);
$grafico->title->Set("Pedidos reservados para el año ".$year);
$grafico->title->SetFont(FF_ARIAL,FS_BOLD,12);
$grafico->xaxis->title->Set("");
$grafico->xaxis->SetLabelAngle(50);
//$grafico->subtitle->Set("ID: ".$id."\n Año: ".$year);
$grafico->xaxis->SetTickLabels($labels);
$grafico->xaxis->SetFont(FF_ARIAL,FS_NORMAL,11);
$grafico->yaxis->title->Set("Pedidos");
$grafico->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,11);
$grafico->yaxis->SetTitleMargin(35);
$barplot1 =new BarPlot($datos);
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("purple", "blue", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);
$barplot1->value->SetFont(FF_ARIAL,FS_BOLD,10);
$barplot1->value->SetAngle(90);
$barplot1->value->SetFormat('%0.0f');
$barplot1->SetValuePos('center');
$barplot1->value->HideZero();
$barplot1->value->SetColor("white","red"); 
$barplot1->value->Show();
$grafico->Stroke();
?>