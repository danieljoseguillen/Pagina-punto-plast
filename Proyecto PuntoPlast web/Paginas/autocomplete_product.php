<?php

if(!empty($_GET['term']))
{
$con = mysqli_connect("localhost","root","","bd_puntoplast");


//get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $result=mysqli_query($con,"SELECT * FROM producto WHERE Nomb_prod LIKE '%".$searchTerm."%' ORDER BY Nomb_prod ASC");
    $data=array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['Nomb_prod'];
    }
    
    //return json data
    echo json_encode($data);
}
?>