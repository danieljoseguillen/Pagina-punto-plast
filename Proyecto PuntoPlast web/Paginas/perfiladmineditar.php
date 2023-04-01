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
   <header class="titulo">Mi Perfil - Administrador - Editar</header>
            <br>
       <?php
        //session_start();
        require_once "Procesos.php"; 
        $Procesos = new Procesos();
        $sesion=$Procesos->session();
        if ($sesion =="false"){
        header("location:main.php");
        }
        if(isset($_POST["volver"])){
header('Location: perfiladmin.php');}
        $result = $Procesos->load_users();
        ?>
       <form action="" method="post">
        <table>
        <th colspan="2"><br>Datos de Cuenta: </th> 
        </tr>
        <tr>
        <td class="t1">Usuario: </td> 
        <td><input type=text name="userusu" readonly=true value="<?php echo $result['Id_usu']; ?>"></td>
        </tr>
        <tr>
        <td class="t1">Correo: </td> 
        <td> <input type="email" name="correousu" value="<?php echo $result['Email_usu']; ?>" required></td>
        </tr>
           </tr>
        <th colspan="2"><br>Contraseña: </th> 
        </tr>
        <td class="t1">Original: </td> 
        <td> <input type="password" name="passusuorig" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="La contraseña debe tener mas de 6 digitos, menos de 20 y debe contener almenos una mayuscula, una minuscula y un numero." maxlength="20" required></td>
        </tr>
        <tr>
        <td class="t1">Nueva: </td> 
        <td> <input type="password" name="passusu" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="La contraseña debe tener mas de 6 digitos, menos de 20 y debe contener almenos una mayuscula, una minuscula y un numero." maxlength="20"></td>
        </tr>
        <tr>
        <td class="t1">Repetir: </td> 
        <td> <input type="password" name="passusu2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="Las contraseñas deben coincidir" maxlength="20"></td>
        </tr>
       </table>
       <br><br>
<input class="used-for-btn-css-class" type="submit" name="modificarperfilusu" value="Guardar">
    <a href="perfiladmin.php" class="btn">Volver</a>
        </form>
       <?php 
if(isset($_POST["modificarperfilusu"])){
$nombre=null;
$clave=$_POST["passusu"];
$clave2=$_POST["passusu2"];
$claveorig=$_POST["passusuorig"];
$clavefinal=null;
$apellido=null;
$mail=$_POST["correousu"];
$cedula=null;
$dir=null;
$telf=null;
$origen=null;
$rif=null;
$emp=null;
$pass=null;
    if (md5($claveorig) == $result['Password_usu']){
    if (!empty($clave2) OR !empty($clave)){
    if($clave == $clave2){
    $clavefinal = md5($clave);
    $pass=1;
    }else{ echo "<script type='text/javascript'>alert('Las nuevas claves no coinciden')</script>"; $pass=0;}
    }else{
    $clavefinal = md5($claveorig);
    $pass=1;}
    }else{
    echo "<script type='text/javascript'>alert('Clave original erronea')</script>"; $pass=0;
    }
    
if($pass == 1){
require_once "Procesos.php";
$Procesos = new Procesos();
$result= $Procesos->update_users($cedula ,$nombre, $clavefinal, $apellido, $mail, $dir, $telf, $origen, $rif, $emp);
$desc="Modificar perfil";
$obj=$_SESSION["user_name"];
$Procesos->activity($desc, $obj);
}
}
        ?>
</div>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
</body>
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
</html>