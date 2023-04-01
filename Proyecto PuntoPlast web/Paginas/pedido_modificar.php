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
    
   <div background=white class="contenedormayor">
   <header class="titulo">Modificar pedido</header>
       <br>
       <br>
        <?php

            //session_start();
            require_once "Procesos.php"; 
            $Procesos = new Procesos();  
            $sesion=$Procesos->session();
            if ($sesion =="true"){
            header("location:main.php");
            }
if(isset($_POST['checkcod']) && !empty($_POST['checkcod']) && isset($_POST['checkcant']) && !empty($_POST['checkcant'])){
            $id=$_POST['id'];
            $codigo=$_POST['checkcod'];
            $cant=$_POST['checkcant'];
            $del=array();
    
    if(isset($_POST['Procesar'])){
        $var=0;
    for($i=0; $i < count($cant); $i++){
    if($cant[$i]<=0 & $var==0){
         echo '<script language="javascript"> alert("Porfavor, todos los productos deben tener una cantidad de almenos 1");</script>';
        $var=1;
    }}
    if ($var==0){
    $Procesos->mod_ped($id,$codigo,$cant);
    
    }
    }
    if(isset($_POST['Eliminar'])){
    if(isset($_POST['checkdel']) && !empty($_POST['checkdel'])){
    $del=$_POST['checkdel'];
    for($i=0; $i < count($del); $i++){
    for($j=0; $j < count($codigo); $j++){
    if($codigo[$j] == $del[$i]){
    array_splice($codigo, $j, 1);
    array_splice($cant, $j, 1);
            }
        }
    }
    if ($codigo == null){
    echo '<script language="javascript"> alert("No puede eliminar todos los productos de un pedido."); location.href = "listapedido.php";</script>';
    
    }
    }else{echo "<script type='text/javascript'>alert('Error, no se ha marcado ningun producto para remover del pedido.')</script>";
    }}
            ?>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input style="float: left; margin-left: 10px;" type="submit" name="Procesar" value="Confirmar pedido" onclick="return confirm('Esta seguro?')"><input style='float: right; margin-right: 10px;' id="elim" type="submit" name="Eliminar" value="Eliminar productos" onclick="return confirm('Esta seguro?')" disabled>
        <br><br>
          <table>
            <tr>
                <td width="50%">Nombre</td>
                <td width="20%">Precio (Unidad)</td>
                <td width="5%">Cantidad</td>
                <td width="25%">Total</td>
                <td>X</td>
            </tr>
            <?php 
            $precio=array();
            for($i=0; $i < count($codigo); $i++){
                $result=$Procesos->load_product($codigo[$i]);
                $precio[]=$result['Precio_prod'];
                ?>
            <tr>
                <input type=hidden name="checkcod[]" value="<?php echo $codigo[$i]; ?>">
            <td> <?php echo $result['Nomb_prod']; ?></td>
            <td><input style="width: 100%; height: 100%;" id="akitubojhon2<?php echo $i ?>"  type="text" readonly="true" value="<?php echo $precio[$i]; ?>" width="10px"></td>
                <td> <input style="width: 100%; height: 100%;" value="<?php echo $cant[$i] ?>" type="number"  min="0" id="akitubojhon<?php echo $i ?>" class="<?php echo $i ?>" onchange="funcion(this)" onkeypress="return event.charCode >= 48" name="checkcant[]"></td>
                <td><input style="width: 100%; height: 100%;" id="akitubojhon34<?php echo $i ?>" type="text" disabled</td>
                    <td><input type="checkbox" onclick="myFunction()" class="check" name="checkdel[]" value="<?php echo $codigo[$i];?>"></td>
            </tr>
                <?php
                
            }

           ?></table></form>
        <br>
       <form action="pedidodetalle.php" method="post"><input type="hidden" value="<?php echo $id; ?>" name="idped"><button type="submit">Volver</button></form>
        <?php }else{echo '<script language="javascript"> alert("Porfavor ingrese productos"); location.href = "listapedido.php";</script>';     } ?>
</div>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
      <script>
        //("#akitubojhon").on("change", function(){
        function funcion(evt){
            var $clase=$(evt).attr("class");
            var $multiplicador;
            var $valor;
            var $result;
            $multiplicador=$("#akitubojhon"+$clase).val();
            $valor=$("#akitubojhon2"+$clase).val();
            $result=$multiplicador*$valor;
            $("#akitubojhon34"+$clase).val($result.toString());
        }
    
    </script>
    <script>
function myFunction() {
    document.getElementById("elim").disabled = false;
}
</script>
</body>
</html>