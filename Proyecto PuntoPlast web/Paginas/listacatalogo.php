<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/Estilolistas2.css">
<link rel="stylesheet" type="text/css" href="../Css/fonts.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
            
    <div class="contenedor">
            <header class="left">
            <div><img class="imagen" src="../Imagenes/puntop.jpg"></div>
        </header>
    <br>
    <div class="contenedoracord">
        <ul class="menu">
            <li><a href=main.php><i class="icono izquierda fa fa-home" aria-hidden="true"></i> Inicio</a></li>
            <li><a href="perfilusuario.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi Perfil</a></li>
            <li class="activado"><a href=""><i class="icono izquierda fa fa-cubes" aria-hidden="true"></i> Productos <i style="float: right;" class="icono derecha fa fa-chevron-down" aria-hidden="true"></i></a>
            <ul>
            <li><a href="listacatalogo.php"><i class="icono izquierda fa fa-book" aria-hidden="true"></i> Catalogo</a></li>    
            <li><a href="listacatalogo.php?tipo=limpieza"><i class="fa fa-bath" aria-hidden="true"></i> Limpieza</a></li>
            <li><a href="listacatalogo.php?tipo=plastico"><i class="fa fa-spoon" aria-hidden="true"></i>&nbsp; Plasticos</a></li>
            </ul>
            </li>
            <li><a href="listapedido.php"><i class="icono izquierda fa fa-cart-arrow-down" aria-hidden="true"></i> Pedidos</a></li>
            <li><a href="logout.php"><i class="fa fa-window-close" aria-hidden="true"></i> Cerrar Session</a></li>
        </ul>
    </div>
    
    <?php
    if(isset($_GET['prod']) && !empty($_GET['prod'])){
    $prod=$_GET['prod'];
    }else{
    $prod=null;
    }
    if(isset($_GET['tipo']) && !empty($_GET['tipo'])){
    $t= $_GET['tipo'];
    }else{
    $t=null;
    }
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="true"){
            header("location:main.php");
            }$e=1;
    $result = $Procesos->list_products($prod,$e, $t);
    ?>
        
   <div background=white class="contenedormayor">
   <header class="titulo">Catalogo de Productos <?php if($t=="plastico"){ echo "Plasticos"; } if($t=="limpieza"){echo "de Limpieza";} ?></header>
       <br> <br>
        <form action="">
        </form>
         <form method="post" action="pedido.php">
       <input type="submit" name="registrar" value="Registrar pedido">
       <br><br>
       <table id="myTable">
           <tr>
           <th style="cursor: pointer;" width="60%" onclick="sortTable(0)">Nombre</th>
            <th style="cursor: pointer;" width="20%" onclick="sortTable(1)">Tipo</th>
            <th style="cursor: pointer;" width="20%" onclick="sortTable(2)">Precio</th>
            <th><i class="icono izquierda fa fa-cart-arrow-down" aria-hidden="true"></i></th>
           </tr>
           <?php
             while($row = mysqli_fetch_array($result)){
           ?>
        <tr>
        <td><?php echo $row['Nomb_prod'];?></td>
        <td><?php echo $row['Tipo_prod'];?></td>
        <td><?php echo $row['Precio_prod'];?></td>
        <td><input type="checkbox" class="check" name="checkcod[]" value="<?php echo $row['Cod_prod'];?>"></td>
        </tr>
           <?php } ?>
       </table>
       </form>
       <br>
</div>
    </div> 
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
    <script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  dir = "asc"; 
  while (switching) {
    switching = false;
    rows = table.getElementsByTagName("TR");
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }} else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }}}
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++; 
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }}}}
</script>
</body>
</html>