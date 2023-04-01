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
   <header class="titulo">Perfil - Detalles</header>
       <br>
       <br>
        <?php
            if(isset($_GET['idusu']) && !empty($_GET['idusu'])){
            //session_start();
            $usu=$_GET['idusu'];
            require_once "Procesos.php"; 
            $Procesos = new Procesos();  
            $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
            $result = $Procesos->load_client($usu);
            if (empty($result)){
            echo '<script language="javascript"> alert("No se ha encontrado clientes"); location.href = "listausuario+.php";</script>';
                die;}
           ?>
       <table align="center">
        <tr>
        <th colspan="2">Datos de Usuario</th> 
        </tr>
        <tr>
        <td class="t1">Cedula: </td> 
        <td><?php echo $result["Ci_clie"]; ?></td>
        </tr>
         <tr>
        <td class="t1">Origen: </td> 
        <td> <?php if($result['Tipo_ci_clie']=="V"){
       echo "Residente";
       }else if($result['Tipo_ci_clie']=="E"){
echo "Extranjero";}?></td>
        </tr>
        <tr>
        <td class="t1">Nombre: </td> 
        <td><?php echo $result['Nomb_clie']; ?></td>
        </tr>
        <tr>
        <td class="t1">Apellido: </td> 
        <td> <?php echo $result['Ape_clie']; ?></td>
        </tr>
        <tr>
        <td class="t1">Telefono: </td> 
        <td> <?php echo  $result['Tlf_clie']; ?></td>
        </tr>
        <tr>
        <td class="t1">Direccion: </td> 
        <td> <?php echo $result['Dir_clie']; ?></td>
        </tr>
               <?php if ($result['Tipo_clie']=="Juridico"){?>
        <tr>
        <td class="t1">Rif: </td> 
        <td> <?php echo $result["Rif_juri"]; ?></td>
        </tr>
        <tr>
        <td class="t1">Empresa: </td> 
        <td> <?php echo $result["Empresa_juri"]; ?></td>
        </tr>
           <?php } ?>
        <tr>
        <th colspan="2"><br>Datos de Cuenta: </th> 
        </tr>
        <tr>
        <td class="t1">Usuario: </td> 
        <td> <?php echo  $result['Id_usu']; ?></td>
        </tr>
           <tr>
        <td class="t1">Correo: </td> 
        <td> <?php echo  $result['Email_usu']; ?></td>    
        </tr>
       </table>
        <br><br>
           <button onclick="goBack()">Volver</button>
       <br><br>
        <?php }else{
header("location:listausuarios.php");}
?>
</div>
    </div>
    <script>
function goBack() {
    window.history.back();
}
</script>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>