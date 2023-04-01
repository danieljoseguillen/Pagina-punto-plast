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
   <header class="titulo">Confirmacion de pedido</header>
       <br>
       <br>
       <style>
    input:invalid {
            border-color: #DD2C00;
    }
input,
input:valid {
    border-color: #ccc;
}
        </style>
        <?php

            //session_start();
            require_once "Procesos.php"; 
            $Procesos = new Procesos();  
            $sesion=$Procesos->session();
            if ($sesion =="true"){
            header("location:main.php");
            }
if(isset($_POST['checkcod']) && !empty($_POST['checkcod'])){
            $codigo=$_POST['checkcod'];
            ?>
    <form action="Procesopedido.php" method="post">
        <button type="submit" name="Procesar" onclick="return confirm('Esta seguro?')">Confirmar pedido</button>
        <br><br>
          <table>
            <tr>
                <td width="50%">Nombre</td>
                <td width="20%">Precio (Unidad)</td>
                <td width="5%">Cantidad</td>
                <td width="20%">Total</td>
            </tr>
            <?php 
            $precio=array();
            for($i=0; $i < count($codigo); $i++){
                $result=$Procesos->load_product($codigo[$i]);
                $id1[]=$result['Cod_prod'];
                $precio[]=$result['Precio_prod'];
                ?>
            <tr>
                <input type=hidden name="id1[]" value="<?php echo $id1[$i]; ?>">
            <td> <?php echo $result['Nomb_prod']; ?></td>
            <td><input style="width: 100%; height: 100%;" id="akitubojhon2<?php echo $i ?>"  type="text" readonly="true" value="<?php echo $precio[$i]; ?>" width="10px"></td>
                <td> <input style="width: 100%; height: 100%;" value="1" type="number"  min="1" id="akitubojhon<?php echo $i ?>" class="<?php echo $i ?>" onchange="funcion(this)" onkeypress="return event.charCode >= 48" name="number[]" title="El valor debe ser mayor de 0"></td>
                <td><input style="width: 100%; height: 100%;" id="akitubojhon34<?php echo $i ?>" type="text" disabled</td>
            </tr>
                <?php
                
            }

           ?></table></form>
        <br>
           <a href="listacatalogo.php"><button>Volver</button></a>
       <br><br>
        <?php }else{echo '<script language="javascript"> alert("Porfavor ingrese productos"); location.href = "listacatalogo.php";</script>';     } ?>
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
</body>
</html>