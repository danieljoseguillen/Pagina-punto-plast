<?php // content="text/plain; charset=utf-8"
require_once ('../../jpgraph/src/jpgraph.php');
require_once ('../../jpgraph/src/jpgraph_pie.php');
require_once ('../../jpgraph/src/jpgraph_pie3d.php');
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
$result=mysqli_query($con,"SELECT Cod_prod, Nomb_prod, SUM(Cant_prod_ped) as cantidad FROM pedido_producto INNER JOIN producto USING(Cod_prod) INNER JOIN pedido USING(Num_ped) WHERE year(Fecha_ped)='".$year."' AND Estado_ped='Procesado' GROUP BY Cod_prod ORDER BY cantidad desc LIMIT 10");
$datos=array();
$nombres=array();
$numeros= array();
while($row=$result->fetch_array()){
$datos[]=$row["cantidad"];
$numeros[]=$row["cantidad"]." (%.1f%%)";
$nombres[]=$row["Nomb_prod"]." (".$row["cantidad"].")";
}


// A new pie graph
$grafico = new PieGraph(500,500,'auto');
$grafico->SetShadow();
// Title setup
$grafico->title->Set("Productos mas vendidos el ".$year);
$grafico->title->SetFont(FF_ARIAL,FS_BOLD,12);
$grafico->legend->Pos(0,0.79);
//$grafico->title->SetFont(FF_FONT1,FS_BOLD);
// Setup the pie plot
$p1 = new PiePlot3d($datos);
// Adjust projection angle
$p1->SetAngle(55);
// Adjust size and position of plot
$p1->SetSize(0.35);
$p1->SetCenter(0.5,0.4);
$p1->SetLabels($numeros);
// Setup slice labels and move them into the plot
$p1->SetLabelType(PIE_VALUE_PER);
// setup the names, position and color on the plot
$p1->value->Show();
$p1->value->SetFont(FF_FONT1,FS_BOLD);
$p1->value->SetColor("white");
$p1->SetLabelPos(0.5);
// Finally add the plot
$grafico->Add($p1);
$p1->SetSliceColors(array('darkred','green','blue','purple','red','orange','darkgreen','pink','darkgray','pink'));
$p1->SetLegends($nombres);
$grafico->legend->SetColumns(2);
$grafico->Stroke();
}
?>
