<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../Css/Estilousuario2.css">
<link rel="stylesheet" type="text/css" href="../Css/fonts.css">
<link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.css">
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
   <header class="titulo">Panel de estadisticas</header>
       <br>
       <br>
        <?php
        require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
        ?>
       <div style=" min-width:300px; max-width:600px; display: inline-block;">
       <form action="" method="post">
        <table>
        <tr>
            <td><input type="radio" name="tipo" value="pedidos" onchange="show4()">Pedidos por año</td>
            <td><input type="radio" name="tipo" value="ganancia" onchange="show3()">Ganancias por año</td>
            <td><input type="radio" name="tipo" value="top10" onchange="show2()">Productos vendidos</td>
            <td><input type="radio" name="tipo" value="nombre" onchange="show()">Productos por nombre</td>
        </tr>
            
            <table>
            <tr id="pedidos" style="display:none;">
               <td>Año: </td>
               <td><input type="number" name="fecped"></td>
            </tr>
                
           <tr id="ganancia" style="display:none;">
               <td>Año: </td>
               <td><input type="number" name="fecgain"></td>
            </tr>
                
        <tr id="top10" style="display:none;">
            <td>Año: <br>Categoria</td>
            <td><input style="width: 150px;" type="number" name="fectop"><br><select style="width: 150px;" name="top">
  <option value="top10">10 mas vendidos</option>
  <option value="worst10">10 menos vendidos</option>
</select></td>
        </tr>
                
        <tr id="nombre" style="display:none;">
            <td>Nombre: <br>Año:</td>
            <td><input id="idauto" name="idprod"><br><input type="number" name="fecprod"></td>
        </tr>
                
            </table>
           </table>
       <br><br><input id="submit" type="submit" style="display: none" name="start" value="Generar estadistica">
           
       </form>
           </div><br>
        <?php if (isset($_POST["start"])){
            $tipo=$_POST['tipo'];
            
            if($tipo=='pedidos'){
            $year=$_POST['fecped'];
            if (!empty($year)){
                $result=$Procesos->verest($year);
                if($result !== 0){
                    echo "<img style='max-width:500px; width: 100%; height:auto; ' src='graficos/pedidos_por_ano.php?year=".$year."'>";
                }
                }else{
                echo "<script type='text/javascript'>alert('Error: Porfavor ingrese datos.')</script>";}
            }
            if($tipo=='ganancia'){
            $year=$_POST['fecgain'];
                if (!empty($year)){
                    $result=$Procesos->verest($year);
                    if($result !== 0){
                        echo "<img style='max-width:500px; width: 100%; height:auto;' src='graficos/ganancias_por_ano.php?year=".$year."'>";
                    }
                }else{
                echo "<script type='text/javascript'>alert('Error: Porfavor ingrese datos.')</script>";}
            }
            if($tipo=='top10'){
            $year=$_POST['fectop'];
            $type=$_POST['top'];
                if (!empty($year)){
                $result=$Procesos->verest($year);
                if($result !== 0){
            if($type=="top10"){
                echo "<img style='max-width:500px; width: 100%; height:auto; ' src='graficos/productos_mas_pedidos.php?year=".$year."'>";
            }else{
                 echo "<img style='max-width:600px; width: 100%; height:auto; ' src='graficos/productos_menos_pedidos.php?year=".$year."'>";}
                }
            }else{
                echo "<script type='text/javascript'>alert('Error: Porfavor ingrese datos.')</script>";}}
            
            if($tipo=='nombre'){
            $id=$_POST['idprod'];
            $year=$_POST['fecprod'];
                if (!empty($year) OR !empty($id)){
                $resultver=$Procesos->verest($year);
                    if($resultver !== 0){
            $result=$Procesos->load_product($id);
                if($result !== null){
            echo "<img style='max-width:500px; width: 100%; height:auto; ' src='graficos/productos_por_nombre.php?id=".$id."&year=".$year."'>";}else{
                echo "<script type='text/javascript'>alert('Error: El producto ingresado no existe en la base de datos.')</script>";}}
                }else{
                echo "<script type='text/javascript'>alert('Error: Porfavor ingrese datos.')</script>";}
            }
            ?>
            <?php } ?>
</div>
    </div>
     <script type="text/javascript">
            function show(str){
                document.getElementById('nombre').style.display = 'block';
                document.getElementById('top10').style.display = 'none';
                document.getElementById('ganancia').style.display = 'none';
                document.getElementById('pedidos').style.display = 'none';
                document.getElementById('submit').style.display = '';
            }
            function show2(sign){
                document.getElementById('nombre').style.display = 'none';
                document.getElementById('top10').style.display = 'block';
                document.getElementById('ganancia').style.display = 'none';
                document.getElementById('pedidos').style.display = 'none';
                document.getElementById('submit').style.display = '';
            }
            function show3(sign2){
                document.getElementById('nombre').style.display = 'none';
                document.getElementById('top10').style.display = 'none';
                document.getElementById('ganancia').style.display = 'block';
                document.getElementById('pedidos').style.display = 'none';
                document.getElementById('submit').style.display = '';
            }
            function show4(sign3){
                document.getElementById('nombre').style.display = 'none';
                document.getElementById('top10').style.display = 'none';
                document.getElementById('ganancia').style.display = 'none';
                document.getElementById('pedidos').style.display = 'block';
                document.getElementById('submit').style.display = '';
            }
        </script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
    <script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="../js/menu.js"></script>
    <script>
            $(function() {
                $( "#idauto" ).autocomplete({
                source: 'autocomplete_product.php'
            });});
    </script>  
    
</body>
</html>