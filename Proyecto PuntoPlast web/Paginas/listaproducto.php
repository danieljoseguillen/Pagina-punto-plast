<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/Estilolistas2.css">
<link rel="stylesheet" type="text/css" href="../Css/fonts.css">
<link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.css">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
            
    <div class="contenedor">
           <header class="left">
            <img class="imagen" src="../Imagenes/puntop.jpg">
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
            if ($sesion =="false"){
            header("location:main.php");
            }$e=null;
    $result = $Procesos->list_products($prod,$e,$t);
    
    ?>
        
   <div background=white class="contenedormayor">
   <header class="titulo">Productos - Administrar</header>
       <br> <br>
           <form action="">
        <div>Buscar
        <input id="idauto"  type="text" name="prod"><input type="submit" name="buscar" value="Buscar"></div>
               <br>
        <div><input type="radio" name="tipo" value="plastico">Plasticos &nbsp; <input type="radio" name="tipo" value="limpieza">Limpieza &nbsp; <input type="radio" name="tipo" value=null>Todos</div>
           </form>
       <br>
       <table id="myTable">
           <tr>
           <th style="cursor: pointer;" onclick="sortTable(0)">Codigo</th>
           <th width="40%" style="cursor: pointer;" onclick="sortTable(1)">Nombre</th>
            <th width="20%" style="cursor: pointer;" onclick="sortTable(2)">Tipo</th>
            <th width="15%" style="cursor: pointer;" onclick="sortTable(3)">Precio Bsf</th>
            <th width="15%" style="cursor: pointer;" onclick="sortTable(4)">Stock</th>
            <th class="hid" width="15%" style="cursor: pointer;" onclick="sortTable(5)">Min</th>
            <th>Editar</th>
           </tr>
           <?php
         //for ($i = 0 ; $i < 5; $i++) {
            $aux=0;
        while($row = mysqli_fetch_assoc($result)){
			$aux++;
           ?>
        <tr>
        <td><?php echo $row['Cod_prod'];?></td>
        <td><a href="#" id="trigger<?php echo $aux?>" onmouseenter="showFoto(this);" onmouseleave="hideFoto(this);"><?php echo $row['Nomb_prod'];?></a></td>
        <td><?php echo $row['Tipo_prod'];?></td>
        <td><?php echo $row['Precio_prod'];?></td>
        <td><?php echo $row['Stock_prod'];?></td>
        <div id="pop-up"><?php echo '<img style="width:200px;height:250px" src="data:image/jpeg;base64,'.base64_encode( $row['Img_prod'] ).'"/>'; ?></div>
        <td class="hid"><?php echo $row['Cantidad_Min'];?></td>
        <td><?php echo '<a class="btn" href="productomodificar.php?idprod='.$row['Cod_prod'].'"><button class="tableheader"><i class="icono izquierda fa fa-exchange" aria-hidden="true"></i></button></a>'?></td>
        </tr>
          <?php } ?>
       </table>
       <br><br>
</div>
    </div>
  <style>
      div#pop-up {
  display: none;
  position: absolute;
  height: 250px;
  width: 200px;
  padding: 10px;
  background: #eeeeee;
  color: #000000;
  border: 1px solid #1a1a1a;
  font-size: 90%;
}</style>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
    <script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
    <script>
            $(function() {
                $( "#idauto" ).autocomplete({
                source: 'autocomplete_product.php'
            });});
    </script>
    <script type="text/javascript">
	
  var moveLeft = 20;
  var moveDown = 10;
  
    function showFoto($var){
		$('div#pop-up').show();
	}
	 
   function hideFoto($var) {
		$('div#pop-up').hide();
	}
        
  $('a #trigger').hover(function(e) {
	
    $('div#pop-up').show();
  }, function() {
    $('div#pop-up').hide();
  });

  $('td a').mousemove(function(e) {
  console.log(e);
    $("div#pop-up").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
  });
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