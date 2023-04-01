<html>
<head>
<meta charset="UTF-8">
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
        <?php 
        //session_start();
            require "Procesos.php"; 
            $Procesos = new Procesos();  
            $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
        ?>
   <div background=white class="contenedormayor">
   <header class="titulo">Productos - Modificar</header>
       <br> <br>
           <form action="" method="get">
       <tr>
        <td>Buscar</td>
        <td><input id="idauto" type="text" name="idprod"><input type="submit" name="buscar" value="Buscar"></td>
        </tr>
           </form>
           <?php
            if(isset($_GET['idprod']) && !empty($_GET['idprod'])){
            $codigo=$_GET['idprod'];
            $result = $Procesos->load_product($codigo);
            if (empty($result)){
            echo '<script language="javascript"> alert("No se ha encontrado productos"); location.href = "productomodificar.php";</script>';
                die;}
           ?>
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
       <form action="" method="post" enctype="multipart/form-data">
       <table>
        <br>
        <tr>  
        <td>Codigo</td>
        <td colspan="2"><input type="text" name="id" value="<?php echo $result["Cod_prod"];?>" readonly=true></td>
        </tr>
        <tr>
        <td>Nombre</td>
        <td colspan="2"><input type="text" name="nombre" value="<?php echo $result["Nomb_prod"];?>" maxlength="40" required></td>
        </tr>
        <tr>
        <td>Tipo</td>
         <td><input type="radio" name="tipo" value="Limpieza" <?php if($result['Tipo_prod']=="Limpieza") echo "checked";  ?>>Limpieza</td>
        <td><input type="radio" name="tipo" value="Plastico" <?php if($result['Tipo_prod']=="Plastico") echo "checked";  ?>>Plastico</td>
        </tr>
        <tr>
        <td>Precio</td>
        <td colspan="2"><input type="number" onkeypress="return event.charCode >= 48" min="1" name="precio" step="0.01" value="<?php echo $result["Precio_prod"];?>" required></td>
        </tr>
        <tr>
        <td>Stock</td>
        <td colspan="2"><input type="number" onkeypress="return event.charCode >= 48" min="1" name="stock" value="<?php echo $result["Stock_prod"];?>" maxlength="11" required></td>
        </tr>
        <tr>
        <td>Minimo</td>
        <td colspan="2"><input type="number" onkeypress="return event.charCode >= 48" min="1" name="min" value="<?php echo $result["Cantidad_Min"];?>" maxlength="11" required></td>
        </tr>
        <tr>
        <td colspan="2">Imagen del producto</td>
        </tr>
        </table><br>
           <input type="file" name="image" accept="image/*" onchange="preview_image(event)">
           <br>
           <img id="output_image"/>
       <br>
       <br>
       <input type="submit" name="agregar" value="Guardar">
        
       <?php
               // echo '<img style="width:128px;height:128px" src="data:image/jpeg;base64,'.base64_encode( $result['Img_prod'] ).'"/>';
if(isset($_POST["volver"])){
header('Location: listaproducto.php');}
        if (isset($_POST["agregar"])){
        $id=$codigo;
        $nombre=$_POST["nombre"];
        $tipo=$_POST["tipo"]; 
        $precio=$_POST["precio"];
        $stock=$_POST["stock"];
        $min=$_POST["min"];
        if($_FILES['image']['size'] !== 0) {
        $img=addslashes (file_get_contents($_FILES['image']['tmp_name']));
        }else{$img=null;}
        $result = $Procesos->update_product($id, $nombre, $tipo, $precio, $stock, $min, $img);
        $desc="Modificar producto";
        $obj=$result["Cod_prod"];
        $Procesos->activity($desc, $obj);
        }
        ?>
       </form>
       <?php } ?>
       <a href="listaproducto.php"><button>Volver</button></a><br><br>
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
                source: 'autocomplete_product.php'
            });});
    </script> 
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