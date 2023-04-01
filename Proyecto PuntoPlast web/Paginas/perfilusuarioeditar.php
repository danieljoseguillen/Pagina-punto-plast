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
    
   <div background=white class="contenedormayor">
  <header class="titulo">Mi Perfil - Editar</header>
        <?php
    require_once "Procesos.php"; 
    $Procesos = new Procesos();
    //session_start();
    $sesion=$Procesos->session();
            if ($sesion =="true"){
            header("location:main.php");
            }
        $result = $Procesos->load_users();
        if(isset($_POST["volver"])){
        header('Location: perfilusuario.php');}
        ?>
       <br>
       <br>
        <form action="" method="post">
        <table>
        <tr>
        <td colspan="2">Datos de Usuario</td> 
        </tr>
        <tr>
        <td class="t1">Cedula: </td> 
        <td><input size= 30px type=text name="cedusu" readonly=true value="<?php echo $result['Ci_clie']; ?>"></td>
        </tr>
        <tr>
        <td class="t1">Origen: </td> 
        <td><input type=radio name="origenusu" value="V" <?php if($result['Tipo_ci_clie']=="V") echo "checked" ?>>Residente <input type=radio name="origenusu" value="Extranjero" <?php if($result['Tipo_ci_clie']=="E") echo "checked" ?>>Extranjero</td>
        </tr>
        <tr>
        <td class="t1">Nombre: </td> 
        <td><input size= 30px type=text name="nombreusu" pattern="[a-zA-Z ]{3,30}" maxlength="30" title="Solo letras de 3 a 30 caracteres" value="<?php echo $result['Nomb_clie']; ?>"></td>
        </tr>
        <tr>
        <td class="t1">Apellido: </td> 
        <td> <input size= 30px type=text name="apellidousu" pattern="[a-zA-Z ]{3,30}" maxlength="30" title="Solo letras de 3 a 30 caracteres" value="<?php echo $result['Ape_clie']; ?>"></td>
        </tr>
        <tr>
        <td class="t1">Telefono: </td> 
        <td> <input size= 30px type="tel" name="telfusu" pattern= "[0-9]{9,12}" title="Solo numeros" value="<?php echo $result['Tlf_clie']; ?>"></td>
        </tr>
        <tr>
        <td>Direccion: </td> 
        <td class="t1"><textarea rows="4"  title="Maximo 200 caracteres" name="dirusu"><?php echo $result['Dir_clie']; ?></textarea></td>
        </tr>
         <?php if ($result['Tipo_clie']=="Juridico"){?>
        <tr>
        <td class="t1">Rif: </td> 
        <td> <input size= 30px type=text name="rifusu" value=<?php  echo $result['Rif_juri']; ?>></td>
        </tr>
        <tr>
        <td class="t1">Empresa: </td> 
        <td> <input size= 30px type=text name="empusu" value=<?php  echo $result['Empresa_juri']; ?>></td>
        </tr>
          <?php }; ?>  
        <tr>
        <td colspan="2"><br>Datos de Cuenta: </td> 
        </tr>
        <tr>
        <td class="t1">Usuario: </td> 
        <td><input size= 30px type=text name="userusu" readonly=true value="<?php echo $result['Id_usu']; ?>"></td>
        </tr>
        <tr>
        <td class="t1">Correo: </td> 
        <td> <input size= 30px type="email" name="correousu" value="<?php echo $result['Email_usu']; ?>"></td>
        </tr>
        <td colspan="2"><br>Contraseña: </td> 
        </tr>
        <td class="t1">Original: </td> 
        <td><input size= 30px type="password" name="passusuorig" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="La contraseña debe tener mas de 6 digitos, menos de 20 y debe contener almenos una mayuscula, una minuscula y un numero." maxlength="20" required></td>
        </tr>
        <tr>
        <td class="t1">Nueva: </td> 
        <td> <input size= 30px type="password" name="passusu" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="La contraseña debe tener mas de 6 digitos, menos de 20 y debe contener almenos una mayuscula, una minuscula y un numero." maxlength="20"></td>
        </tr>
        <tr>
        <td class="t1">Repetir: </td> 
        <td> <input size= 30px type="password" name="passusu2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="Las contraseñas deben coincidir" maxlength="20"></td>
        </tr>
       </table>
       <br>  
        <br>
        <input class="used-for-btn-css-class" type="submit" name="modificarperfilusu" value="Guardar">
        <a href="perfilusuario.php" class="btn">Volver</a>
       </form>
       <?php 
$origen=null;
$rif=null;
$emp=null;
if(isset($_POST["modificarperfilusu"])){
$cedula=$_POST["cedusu"];
$nombre=ucwords(strtolower($_POST["nombreusu"]));
$clave=$_POST["passusu"];
$clave2=$_POST["passusu2"];
$claveorig=$_POST["passusuorig"];
$clavefinal=null;
$apellido=ucwords(strtolower($_POST["apellidousu"]));
$mail=$_POST["correousu"];
$dir=$_POST["dirusu"];
$telf=$_POST["telfusu"];  
$origen= $_POST["origenusu"];
if ($result['Tipo_clie']=="Natural"){
$rif=null;
$emp=null; 
}
if ($result['Tipo_clie']=="Juridico"){
$rif=$_POST["rifusu"];
$emp=strtoupper($_POST["empusu"]);
}
    
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
$Procesos = new Procesos();
$result1= $Procesos->update_users($cedula ,$nombre, $clavefinal, $apellido, $mail, $dir, $telf, $origen, $rif, $emp);
$desc="Modificar perfil";
$obj=$_SESSION["user_name"];
$Procesos->activity($desc, $obj);
    }
}
       ?>
</div>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
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