<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
<?php 
//session_start();
require_once "Procesos.php"; 
$Procesos = new Procesos();
session_destroy();
header('Location: ../Index.php');
  ?>
</body>
</html>