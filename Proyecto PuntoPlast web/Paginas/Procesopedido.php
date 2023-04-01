<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
<?php 
require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
if(isset($_POST['id1']) && !empty($_POST['id1'])){
$id=$_POST['id1'];
$cantidad=$_POST['number'];
$var=0;

for($i=0; $i < count($cantidad); $i++){
    if($cantidad[$i]<=0 or empty($cantidad[$i])){
     echo '<script language="javascript"> alert("Porfavor, todos los productos deben tener una cantidad de almenos 1"); location.href="listacatalogo.php";</script>';
        //location.href="javascript:history.go(-1)\";
        $var=1;
    }
    
}
if($var == 0){
$sesion=$Procesos->pedido($id, $cantidad);
$desc="Pedido realizado";
$obj=$sesion;
if($obj !== false){
$Procesos->activity($desc, $obj);}
}
}else{
header("location:main.php");
}

  ?>
</body>
</html>