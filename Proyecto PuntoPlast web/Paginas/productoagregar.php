<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/Estilousuario2.css">
<link rel="stylesheet" type="text/css" href="../Css/fonts.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
            
    <div class="contenedor">
           <header class="left">
            <div><img class="imagen" src="../Imagenes/puntomini.jpg"></div>
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
<style>
#wrapper
{
 text-align:center;
 margin:0 auto;
 padding:0px;
 width:995px;
}
#output_image
{
 max-width:300px;
}
</style>
   <div background=white class="contenedormayor">
   <header class="titulo">Productos - Agregar</header>
       <br> <br>
       <?php  
            //session_start();
            require_once "Procesos.php"; 
            $Procesos = new Procesos();
            $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
       ?>
       <form action="" method="post">
       <table>
        <tr>
        <td align= justufy>Codigo</td>
        <td colspan="2" align= justufy><input type="number" name="idproducto" maxlength="20" required></td>
        </tr>
        <tr>
        <td>Nombre</td>
        <td colspan="2"><input type="text" name="nombproducto" maxlength="40" required></td>
        </tr>
        <tr>
        <td>Tipo</td>
         <td><input type="radio" name="tipo" value="Limpieza" >Limpieza</td>
        <td><input type="radio" name="tipo" value="Plastico" checked >Plastico</td>
        </tr>
        <tr>
        <td>Precio</td>
        <td colspan="2"><input type="number" name="precio" onkeypress="return event.charCode >= 48" min="1" step="0.01" required></td>
        </tr>
        <tr>
        <td>Stock</td>
        <td colspan="2"><input type="number" name="stock" maxlength="11" onkeypress="return event.charCode >= 48" min="0" required></td>
        </tr>
        <tr>
        <td>Minimo</td>
        <td colspan="2"><input type="number" name="min" maxlength="11" onkeypress="return event.charCode >= 48" min="1" required></td>
        </tr>
        <tr>
            <td colspan="2">Imagen del producto</td>
        </tr>
       </table><br>
           <input type="file" accept="image/*" onchange="preview_image(event)">
           <br>
           <img id="output_image"/>
       <br>
       <br>
       <input type="submit" name="agregar" value="Guardar">
       <br>
       <?php
        if (isset($_POST["agregar"])){
        $id=$_POST["idproducto"];
        $nombre=$_POST["nombproducto"];
        $tipo=$_POST["tipo"];
        $precio=$_POST["precio"];
        $stock=$_POST["stock"];
        $min=$_POST["min"];
        $result = $Procesos->reg_product($id, $nombre, $tipo, $precio, $stock, $min);
        $desc="Registrar producto";
        $obj=$_POST["idproducto"];
        $Procesos->activity($desc, $obj);
        }
        
        ?>
       </form>
</div>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
    <script type='text/javascript'>
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>