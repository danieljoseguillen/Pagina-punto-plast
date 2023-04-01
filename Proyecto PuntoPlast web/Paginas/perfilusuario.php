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
    <style>
        .t1{
        text-align: right;
        }
    </style>
   <div background=white class="contenedormayor">
   <header class="titulo"> Mi Perfil</header>
       <br>
       <br>
       <?php
        //session_start();
        require_once "Procesos.php"; 
        $Procesos = new Procesos();
        $sesion=$Procesos->session();if ($sesion =="true"){header("location:main.php");}
        $result = $Procesos->load_users();
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
        <td>Rif: </td> 
        <td> <?php echo $result["Rif_juri"]; ?></td>
        </tr>
        <tr>
        <td>Empresa: </td> 
        <td> <?php echo $result["Empresa_juri"]; ?></td>
        </tr>
           <?php } ?>
        <tr>
        <td colspan="2"><br>Datos de Cuenta: </td> 
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
       <form action="perfilusuarioeditar.php">
       <input type="submit" name="modificarperfil" value="Modificar Datos">
       </form>
</div>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>