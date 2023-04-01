<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../Css/Estilousuario2.css">
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
   <header class="titulo">Reporte de Pedidos</header>
       <br>
       <br>
        <?php
         require "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
    if (isset($_POST["start"])){
            $tipo=$_POST['tipo'];
        
            if($tipo=='fechaesp'){
            $ini=$_POST['fechaini'];
            $fin=$_POST['fechafin'];
                if (!empty(strtotime($ini)) OR !empty(strtotime($fin))){
            if($ini > $fin){
                echo "<script type='text/javascript'>alert('Error: La fecha de inicio es mayor que la final.')</script>";
                echo "<script>window.close();</script>";
            }else if($ini == $fin){
            header('Location: reportes/reporte_fecha_dia.php?dia='.$ini.'');
            }else{
            header('Location: reportes/reporte_fecha_especifica.php?ini='.$ini.'&fin='.$fin.'');} 
                }else{
                echo "<script type='text/javascript'>alert('Error: Porfavor ingrese datos.')</script>";
                echo "<script>window.close();</script>";
                }
            }
        
            if($tipo=='fechagen'){
            header('Location: reportes/reporte_fecha_general.php');
            }
            if($tipo=='dia'){
            $dia=$_POST['fechadia'];
                if (!empty(strtotime($dia))){
            header('Location: reportes/reporte_fecha_dia.php?dia='.$dia.'');
            }else{
                echo "<script type='text/javascript'>alert('Error: Porfavor ingrese datos.')</script>";
                echo "<script>window.close();</script>";
                }
            } }
        ?>
       <div style=" min-width:300px; max-width:600px; display: inline-block;">
       <form action="" method="post" target="_blank">
        <table>
        <tr>
            <td><input type="radio" name="tipo" value="fechaesp" onchange="show3()">Por fecha especifica</td>
            <td>&nbsp;<input type="radio" name="tipo" value="dia" onchange="show()">Por dia &nbsp;</td>
            <td><input type="radio" name="tipo" value="fechagen" onchange="show2()">Por fecha general</td>
        </tr>
            </table><br>
            <table>
           <tr id="fechaesp" style="display:none;">
               <td>Fecha &nbsp;&nbsp;&nbsp;</td>
               <td>inicio <input type="date" name="fechaini"><br> Final <input type="date" name="fechafin"></td>
            </tr>
            <tr id="fechagen" style="display:none;">
            </tr>
               <tr id="dia" style="display:none;">
                   <td>
                   Fecha:
                   </td>
                   <td>
                   <input type="date" name="fechadia">
                   </td>
               </tr>
            </table>
       <br><br><input id="submit" type="submit" style="display: none" name="start" value="Generar reporte">
          <?php  ?> 
           </form>
           </div>
        
</div>
    </div>
     <script type="text/javascript">
            function show(str){
                document.getElementById('fechaesp').style.display = 'none';
                document.getElementById('dia').style.display = 'block';
                document.getElementById('fechagen').style.display = 'none';
                document.getElementById('submit').style.display = '';
            }
            function show2(sign){
                document.getElementById('fechaesp').style.display = 'none';
                document.getElementById('dia').style.display = 'none';
                document.getElementById('fechagen').style.display = 'block';
                document.getElementById('submit').style.display = '';
            }
            function show3(sign2){
                document.getElementById('fechaesp').style.display = 'block';
                document.getElementById('dia').style.display = 'none';
                document.getElementById('fechagen').style.display = 'none';
                document.getElementById('submit').style.display = '';
            }
        </script>
     <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
 <script src="../Highcharts-4.1.5/js/highcharts.js"></script>
<script src="../Highcharts-4.1.5/js/modules/exporting.js"></script>
    
</body>
</html>