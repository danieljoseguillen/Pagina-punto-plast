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
if(isset($_GET['year']) && !empty($_GET['year'])){
    $year=$_GET['year'];
$result=mysqli_query($con,"SELECT Cod_prod, Nomb_prod, SUM(Cant_prod_ped) as cantidad FROM pedido_producto INNER JOIN producto USING(Cod_prod) INNER JOIN pedido USING(Num_ped) WHERE year(Fecha_ped)='".$year."' AND Estado_ped='Procesado' GROUP BY Cod_prod ORDER BY cantidad asc LIMIT 10");
$datos=array();
$nombres=array();

while($row=$result->fetch_array()){
$datos[]=$row["cantidad"];
$nombres[]=$row["Nomb_prod"];
}
while($row=$result->fetch_array()){
    $datos=array($row['enero'],$row['febrero'],$row['marzo'],$row['abril'],$row['mayo'],$row['junio'],$row['julio'],$row['agosto'],$row['septiembre'],$row['octubre'],$row['noviembre'],$row['diciembre']);
}
$grafico = new Graph(600, 500, 'auto');
$grafico->SetScale("textint");
$grafico->Set90AndMargin(200,10,70,10);
$grafico->title->Set("Productos menos vendidos en el año ".$year);
$grafico->title->SetFont(FF_ARIAL,FS_BOLD,12);
//$grafico->subtitle->Set("ID: ".$id."\n Año: ".$year);
$grafico->xaxis->SetTickLabels($nombres);
$barplot1 =new BarPlot($datos);
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("purple", "blue", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);
$barplot1->value->SetFont(FF_ARIAL,FS_BOLD,10);
$barplot1->value->SetFormat('%0.0f');
$barplot1->SetValuePos('center');
$barplot1->value->HideZero();
$barplot1->value->SetColor("white","red"); 
$barplot1->value->Show();
$grafico->Stroke();
}
?>