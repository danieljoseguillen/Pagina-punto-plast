<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/Estilolistas2.css">
<link rel="stylesheet" type="text/css" href="../Css/fonts.css">
<link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.css">
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
            <li><a href=""><i class="fa fa-user-circle" aria-hidden="true"></i> Usuarios <i style="float: right;" class="icono derecha fa fa-chevron-down" aria-hidden="true"></i></a>
            <ul>
            <li><a href=perfiladmin.php><i class="fa fa-user" aria-hidden="true"></i> Mi Perfil</a></li>
                <li><a href=listausuarios.php><i class="fa fa-users" aria-hidden="true"></i> Lista de Usuarios</a></li>
                <li><a href=listaactividad.php><i class="fa fa-list" aria-hidden="true"></i> Registro de actividad</a></li>
            </ul>
            </li>
            <li class="activado"><a href=""><i class="icono izquierda fa fa-cubes" aria-hidden="true"></i> Productos <i style="float: right;" class="icono derecha fa fa-chevron-down" aria-hidden="true"></i></a>
            <ul>
            <li><a href="listaproducto.php"><i class="icono izquierda fa fa-book" aria-hidden="true"></i> Lista de Productos</a></li>    
            <li><a href="productoagregar.php"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a></li> 
            <li><a href="productomodificar.php"><i class="icono izquierda fa fa-exchange" aria-hidden="true"></i> Modificar Productos</a></li> 
            </ul>
            </li>
            <li><a href="listapedidos.php"><i class="icono izquierda fa fa-cart-arrow-down" aria-hidden="true"></i> Pedidos</a></li>
            <li class="activado"><a href="estadistica_panel.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> Estadisticas</a></li>
            <li class="activado"><a href=""><i class="fa fa-list-alt" aria-hidden="true"></i> Reportes <i style="float: right;" class="icono derecha fa fa-chevron-down" aria-hidden="true"></i></a>
            <ul>
            <li><a href="panel_reporte_actividad.php">Actividad <i style="float: right;" class="icono derecha fa fa-chevron-right" aria-hidden="true"></i></a></li>
            <li><a href="panel_reporte_pedidos.php">Pedidos <i style="float: right;" class="icono derecha fa fa-chevron-right" aria-hidden="true"></i></a></li>
            <li><a onclick="window.open ('reportes/reporte_productos.php', ''); return false" href="javascript:void(0);">Productos</a></li>
            <li><a onclick="window.open ('reportes/reporte_usuarios.php?est=1', ''); return false" href="javascript:void(0);">Usuarios Activos</a></li>
            <li><a onclick="window.open ('reportes/reporte_usuarios.php?est=2', ''); return false" href="javascript:void(0);">Usuarios Suspendidos</a></li>
            </ul>
            </li>
            <li><a href="logout.php"><i class="fa fa-window-close" aria-hidden="true"></i> Cerrar Session</a></li>
        </ul>
    </div>
    
   <div background=white class="contenedormayor">
   <header class="titulo">Usuarios - Administrar</header>
       <br> <br>
       <form action="">
        <div>Buscar
        <input id="idauto" type="text" name="id"><input type="submit" name="buscar" value="Buscar"></div>
           </form>
       <br>
       <?php
    if(isset($_GET['id']) && !empty($_GET['id'])){
    $id=$_GET['id'];
    }else{
    $id=null;
    }
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
    $result = $Procesos->list_users($id);

    ?>
          <table id="myTable">
       <tr>
        <th width="30%" style="cursor: pointer;" onclick="sortTable(0)">Usuario</th> 
        <th width="30%" style="cursor: pointer;" onclick="sortTable(1)">Nombre</th> 
        <th width="30%" style="cursor: pointer;" onclick="sortTable(2)">Apellido</th> 
        <th width="15%" style="cursor: pointer;" onclick="sortTable(3)">Estado</th> 
        <th width="10%" colspan="2">Opciones</th> 
        </tr>
        <?php
             while($row = mysqli_fetch_assoc($result)){
           ?>
        <tr>
        <td><?php echo $row['Id_usu'];?></td>
        <td><?php echo $row['Nomb_clie'];?></td>
        <td><?php echo $row['Ape_clie'];?></td>
        <td><?php echo $row['Estado_usu'];?></td>
        <td><?php echo '<a class="btn" href="listausuario+.php?idusu='.$row['Id_usu'].'"><button class="tableheader"><i class="fa fa-plus" aria-hidden="true"></i></button></a>'?></td>
        <td><?php echo '<a class="btn" href="listausuario=.php?idusu='.$row['Id_usu'].'"><button class="tableheader"><i class="fa fa-cog" aria-hidden="true"></i></button></a>'?></td>
        </tr>
           <?php } ?>
       </table>
       
       <br><br>
</div>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
    <script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
    <script>
            $(function() {
                $( "#idauto" ).autocomplete({
                source: 'autocomplete_user.php'
            });});
    </script>
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