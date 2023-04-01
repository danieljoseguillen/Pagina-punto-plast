<?php

if(!empty($_GET['term']))
{
$con = mysqli_connect("localhost","root","","bd_puntoplast");


//get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $result=mysqli_query($con,"SELECT * FROM usuario WHERE Id_usu LIKE '%".$searchTerm."%' AND tipo_usu='Cliente' ORDER BY Id_usu ASC");
    $data=array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['Id_usu'];
    }
    
    //return json data
    echo json_encode($data);
}
?>