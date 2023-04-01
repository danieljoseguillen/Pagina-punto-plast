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

if(isset($_GET['year']) && !empty($_GET['year']) && isset($_GET['id']) && !empty($_GET['id'])){
$nomb=$_GET['id'];
$year=$_GET['year'];
    $query=mysqli_query($con,'SELECT Cod_prod from producto where Nomb_prod="'.$nomb.'"');
    while($row=$query->fetch_array()){
    $id=$row['Cod_prod'];
    }
$vistaenero=mysqli_query($con,'CREATE OR REPLACE VIEW enero AS (SELECT Cod_prod, SUM(Cant_prod_ped) as enero FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=1)');
$vistafebrero=mysqli_query($con,'CREATE OR REPLACE VIEW febrero AS (SELECT Cod_prod, SUM(Cant_prod_ped) as febrero FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=2)');
$vistamarzo=mysqli_query($con,'CREATE OR REPLACE VIEW marzo AS (SELECT Cod_prod, SUM(Cant_prod_ped) as marzo FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=3)');
$vistaabril=mysqli_query($con,'CREATE OR REPLACE VIEW abril AS (SELECT Cod_prod, SUM(Cant_prod_ped) as abril FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=4)');
$vistamayo=mysqli_query($con,'CREATE OR REPLACE VIEW mayo AS (SELECT Cod_prod, SUM(Cant_prod_ped) as mayo FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=5)');
$vistajunio=mysqli_query($con,'CREATE OR REPLACE VIEW junio AS (SELECT Cod_prod, SUM(Cant_prod_ped) as junio FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=6)');
$vistajulio=mysqli_query($con,'CREATE OR REPLACE VIEW julio AS (SELECT Cod_prod, SUM(Cant_prod_ped) as julio FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=7)');
$vistaagosto=mysqli_query($con,'CREATE OR REPLACE VIEW agosto AS (SELECT Cod_prod, SUM(Cant_prod_ped) as agosto FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=8)');
$vistaseptiembre=mysqli_query($con,'CREATE OR REPLACE VIEW septiembre AS (SELECT Cod_prod, SUM(Cant_prod_ped) as septiembre FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=9)');
$vistaoctubre=mysqli_query($con,'CREATE OR REPLACE VIEW octubre AS (SELECT Cod_prod, SUM(Cant_prod_ped) as octubre FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=10)');
$vistanoviembre=mysqli_query($con,'CREATE OR REPLACE VIEW noviembre AS (SELECT Cod_prod, SUM(Cant_prod_ped) as noviembre FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=11)');
$vistadiciembre=mysqli_query($con,'CREATE OR REPLACE VIEW diciembre AS (SELECT Cod_prod, SUM(Cant_prod_ped) as diciembre FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=12)');
//$vista=mysqli_query($con,'CREATE OR REPLACE VIEW  AS (SELECT Cod_prod, SUM(Cant_prod_ped) as  FROM pedido_producto inner join pedido USING(Num_ped) WHERE Estado_ped="Procesado" AND Cod_prod="'.$id.'" AND YEAR(Fecha_ped)="'.$year.'" AND MONTH(Fecha_ped)=)');

$result=mysqli_query($con,'SELECT Nomb_prod, Cod_prod,enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre FROM producto left join enero USING(Cod_prod) left join febrero USING(Cod_prod) left join marzo USING(Cod_prod) left join abril USING(Cod_prod) left join mayo USING(Cod_prod) left join junio USING(Cod_prod) left join julio USING(Cod_prod) left join agosto USING(Cod_prod) left join septiembre USING(Cod_prod) left join octubre USING(Cod_prod) left join noviembre USING(Cod_prod) left join diciembre USING(Cod_prod) where Cod_prod="'.$id.'"');
// Creamos el grafico
$datos2=array();
$datos3=null;
$labels=array("Enero", "febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$nombre=null;
$id=null;
while($row=$result->fetch_array()){
    $datos=array($row['enero'],$row['febrero'],$row['marzo'],$row['abril'],$row['mayo'],$row['junio'],$row['julio'],$row['agosto'],$row['septiembre'],$row['octubre'],$row['noviembre'],$row['diciembre']);
    //$datos2[]=$row['cant_esp'];
    
$nombre=$row['Nomb_prod'];
$id=$row['Cod_prod'];
}
$grafico = new Graph(500, 500, 'auto');
$grafico->SetScale("textint");
$grafico->img->SetMargin(50,10,50,90);
$grafico->title->Set("Productos reservados para ".$nombre);
$grafico->title->SetFont(FF_ARIAL,FS_BOLD,12);
$grafico->xaxis->title->Set("");
$grafico->xaxis->SetLabelAngle(50);
$grafico->subtitle->Set("ID: ".$id."\n Año: ".$year);
$grafico->subtitle->SetFont(FF_ARIAL,FS_BOLD,10);
$grafico->xaxis->SetTickLabels($labels);
$grafico->xaxis->SetFont(FF_ARIAL,FS_NORMAL,11);
$grafico->yaxis->title->Set("Cantidad");
$grafico->yaxis->title->SetFont(FF_ARIAL,FS_NORMAL,11);
$grafico->yaxis->SetTitleMargin(35);
$barplot1 =new BarPlot($datos);
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("purple", "blue", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);
$barplot1->value->SetFont(FF_ARIAL,FS_BOLD,10);
$barplot1->value->SetAngle(0);
$barplot1->value->SetFormat('%0.0f');
$barplot1->SetValuePos('center');
$barplot1->value->HideZero();
$barplot1->value->SetColor("white","red"); 
$barplot1->value->Show();
$grafico->Stroke();
}
?>