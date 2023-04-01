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
    if(isset($_GET['ped']) && !empty($_GET['ped'])){
    $ped=$_GET['ped'];
    }else{
    $ped=null;
    }
    if(isset($_GET['c'])){
    $c=$_GET['c'];
    }else{
    $c='all';
    }
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="true"){
            header("location:main.php");
            }$e=1;
    $result = $Procesos->list_ped($ped, $e, $c);
    
    ?>
        
   <div background=white class="contenedormayor">
   <header class="titulo">Mis pedidos</header>
       <br> <br>
        <form action="">
        <div>Buscar
        <input type="text" name="ped" value="<?php echo $ped; ?>"><input type="submit" name="buscar" value="Buscar"></div>
            <div><input type="radio" name="c" value="espera">Pedidos en espera</div><div><input type="radio" name="c" value="all">Todos los pedidos</div>
            </form>
           <div>Generar reporte de pedidos <a href="reportes/reporte_cliente_general.php" target="_blank"><button>Generar</button></a></div>
     <br>
       <table id="myTable">
           <tr>
           <th width="40%" style="cursor: pointer;" onclick="sortTable(0)">Numero de pedido</th>
            <th width="30%" style="cursor: pointer;" onclick="sortTable(1)">Fecha</th>
            <th width="30%" style="cursor: pointer;" onclick="sortTable(2)">Estado</th>
            <th>Info</th>
           </tr>
           <?php
             while($row = mysqli_fetch_array($result)){
           ?>
        <tr>
        <td><?php echo $row['Num_ped'];?></td>
        <td><?php $date=$row['Fecha_ped']; $dt = strtotime($date); echo date("d/m/Y", $dt); ?></td>
        <td><?php echo $row['Estado_ped'];?></td>
        <td><form action="pedidodetalle.php" method="post"><input type="hidden" value="<?php echo $row['Num_ped'];?>" name="idped"><button class="tableheader2" type="submit"><i class="icono izquierda fa fa-exchange" aria-hidden="true"></i></button></form>
            </td>
        </tr>
           <?php } ?>
       </table>
       <br><br>
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