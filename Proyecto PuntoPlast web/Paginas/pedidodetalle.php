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
     if(isset($_POST['idped']) && !empty($_POST['idped'])){
         $idped=$_POST['idped'];
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="true"){
            header("location:main.php");
            }
    $result = $Procesos->det_ped($idped);
    $result2 = $Procesos->usu_ped($idped);

    ?>
        
   <div background=white class="contenedormayor">
   <header class="titulo">Detalles del pedido</header>
       
       <br><br>
       <div>ID: <?php echo $result2['Num_ped']; ?></div>
       <br>
       <div>Fecha: <?php echo $result2['Fecha_ped']; ?></div>
       <br>
       <?php if ($result2['Fecha_estado_ped'] !== null) { ?>
       <div> <?php if($result2['Estado_ped']=="En espera"){echo "Ultima modificacion: ";} if($result2['Estado_ped']=="Anulado"){echo "Anulado el: ";} if($result2['Estado_ped']=="Procesado"){echo "Procesado el: ";}  ?> <?php echo $result2['Fecha_estado_ped']; ?></div>
       <br>
       <?php }
       
         if($result2['Estado_ped']=="En espera" OR $result2['Estado_ped']=="Procesado" AND $result2['Num_fac'] == null){ ?><form action="" method="post"><input type="hidden" value="<?php echo $result2['Num_ped'];?>" name="idped"><div><input type="submit" name="anular" value="Anular pedido" onclick="return confirm('Esta seguro? (Esta operacion es irreversible)')"> &nbsp;(Esta operacion es irreversible)</div></form> <?php }else if ($result2['Num_fac'] !== null){echo "Facturado"; ?><br><br><?php } ?>
       <form action="pedido_modificar.php" method="post">
        <?php if($result2['Estado_ped']=="En espera" && $result2['Num_fac'] == null){ ?>
           <input type="submit" name="modificar" value="Modificar pedido">
           <input type="hidden" name="id" value="<?php echo $result2['Num_ped']; ?>"><br><br>
           <?php } ?>
       <table>
           <tr>
           <th width="60%">Nombre</th>
            <th>Cantidad</th>
            <th width="15%">Precio (Unidad)</th>
            <th width="15%">Precio (Total)</th>
           </tr>
           <?php
         $total=0;
             while($row = mysqli_fetch_array($result)){
           ?>
        <tr><input type="hidden" name="checkcod[]" value="<?php echo $row['Cod_prod'];?>">
        <td><?php echo $row['Nomb_prod'];?></td>
        <input type="hidden" name="checkcant[]" value="<?php echo $row['Cant_prod_ped'];?>">
        <td><?php echo $row['Cant_prod_ped'];?></td>
        <td><?php echo $row['Precio_prod'];?></td>
        <td><?php $total=$total+$row['Precio_cant_ped']; echo $row['Precio_cant_ped']; ?></td>
        </tr>
           <?php } ?>
            </form>
           <tr>
           <td colspan="3">Total a pagar</td>
            <td><?php echo $total; ?></td>
           </tr>
       </table>
       <br><br>
        <a href="listapedido.php" class="btn">Volver</a>
        <button class="used-for-btn-css-class" style="display: none"></button>
        <?php 
            if (isset($_POST['anular'])){
            $Procesos->anular($idped);
            $desc="Anular pedido";
            $obj=$idped;
            $Procesos->activity($desc, $obj);
            }
     }else{
header('Location: listapedido.php');}
?>
</div>
    </div> 
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
    <script>'use strict';
{ // Namespace starts (to avoid polluting root namespace).
  const btnCssText = window.getComputedStyle(
    document.querySelector('.used-for-btn-css-class')
  ).cssText;
  document.querySelectorAll('.btn').forEach(
    (btn) => {
      const _d = btn.style.display; // Hidden buttons should stay hidden.
      btn.style.cssText = btnCssText;
      btn.style.display = _d; 
    }
  );
} // Namespace ends.
</script>
</body>
</html>