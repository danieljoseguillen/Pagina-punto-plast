<?php
header("content-type:image/jpeg");
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    $id=$_GET['id'];
    $result=$Procesos->load_product($id);
    print $result['Img_prod'];
}else{
header("location:javascript://history.go(-1)");}
?>