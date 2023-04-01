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
     if(isset($_POST['idped']) && !empty($_POST['idped'])){
         $idped=$_POST['idped'];
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="false"){
            header("location:main.php");
            }
    $result = $Procesos->det_ped($idped);
    $result2 = $Procesos->usu_ped($idped);

    ?>
        
   <div background=white class="contenedormayor">
   <header class="titulo">Detalles del pedido</header>
       <br><br>
       <div>ID del pedido: <?php echo $result2['Num_ped']; ?></div>
       <br>
       <div>Usuario: <?php echo $result2['Id_usu']; ?></div>
       <br>
       <div>Nombre: <?php echo $result2['Nomb_clie']; ?>&nbsp;<?php echo $result2['Ape_clie']; ?></div>
       <br>
       <div>Fecha: <?php echo $result2['Fecha_ped']; ?></div>
       <br>
       <?php if ($result2['Fecha_estado_ped'] !== null) { ?>
       <div> <?php if($result2['Estado_ped']=="En espera"){echo "Ultima modificacion: ";} if($result2['Estado_ped']=="Anulado"){echo "Anulado el: ";} if($result2['Estado_ped']=="Procesado"){echo "Procesado el: ";}  ?> <?php echo $result2['Fecha_estado_ped']; ?></div>
       <br>
       <?php }
         if($result2['Estado_ped']=="En espera"){ ?><form action="" method="post"><input type="hidden" value="<?php echo $result2['Num_ped'];?>" name="idped"><div><input type="submit" name="confirmar" value="Confirmar pedido" onclick="return confirm('Esta seguro?')"> &nbsp;</div></form> <?php }else if ($result2['Num_fac'] !== null){echo "Facturado"; ?><br><br><?php }
       
         if($result2['Estado_ped']=="En espera" OR $result2['Estado_ped']=="Procesado" AND $result2['Num_fac'] == null){ ?><form action="" method="post"><input type="hidden" value="<?php echo $result2['Num_ped'];?>" name="idped"><div><input type="submit" name="anular" value="Anular pedido" onclick="return confirm('Esta seguro? (Esta operacion es irreversible)')"> &nbsp;(Esta operacion es irreversible)</div></form> <?php } ?>
        
       <table>
           <tr>
           <th width="60%">Nombre</th>
            <th>Cantidad</th>
            <th width="15%">Precio (Unidad)</th>
            <th width="20%">Precio (Total)</th>
           </tr>
           <?php
         $total=0;
             while($row = mysqli_fetch_array($result)){
           ?>
        <tr>
        <td><?php echo $row['Nomb_prod'];?></td>
        <td><?php echo $row['Cant_prod_ped'];?></td>
        <td><?php echo $row['Precio_prod'];?></td>
        <td><?php $total=$total+$row['Precio_cant_ped']; echo $row['Precio_cant_ped']; ?></td>
        </tr>
           <?php } ?>
           <tr>
           <td colspan="3">Total a pagar</td>
            <td><?php echo $total; ?></td>
           </tr>
       </table>
       <br><br>
       <a href="listapedidos.php"><button>Volver</button></a>
       <br><br>
        <?php 
         $estado=$result2['Estado_ped'];
         
            if (isset($_POST['anular'])){
                $Procesos->anular($idped,$estado);
                $desc="Anular pedido";
                $obj=$idped;
                $Procesos->activity($desc, $obj);
            }
            if (isset($_POST['confirmar'])){
                $Procesos->confirmar($idped);
                $desc="Confirmar pedido";
                $obj=$idped;
                $Procesos->activity($desc, $obj);
            }
        }else{
header('Location: listapedidos.php');}
?>
</div>
    </div> 
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>