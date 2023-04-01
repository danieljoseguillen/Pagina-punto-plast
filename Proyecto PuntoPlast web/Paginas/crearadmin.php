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
            <header>
        <table width="100%">
            <tr>
                <td><img class="imagen" src="../Imagenes/puntomini.jpg"></td>
            </tr>
            </table>
        </header>
    <br>

    
   <div background=white class="contenedormayor">
   <header class="titulo">Perfil - Administrador - crear</header>
            <br>
       <br>
       <form action="" method="post">
       <input type="submit" name="createdbusers" value="Crear usuario de login">
       </form>
        <form action="" method="post">
        <table>
        <tr>
        <td colspan="2">Datos de Administrador</td> 
        </tr>
        <tr>
        <td>Nombre: </td> 
        <td><input type=text name="nombreusu"></td>
        </tr>
        <tr>
        <td>Apellido: </td> 
        <td> <input type=text name="apellidousu"></td>
        </tr>
        <tr>
        <td colspan="2"><br>Datos de Cuenta: </td> 
        </tr>
        <tr>
        <td>Usuario: </td> 
        <td><input type=text name="userusu"><input type="submit" name="db" value="db"></td>
        </tr>
           <tr>
        <td>Contrasena: </td> 
        <td> <input type="password" name="passusu"></td>
        </tr>
            <tr>
        <td>Correo: </td> 
        <td> <input size= 30px type="email" name="correousu"></td>
        </tr>
       </table>
       <br><br>
<input type="submit" name="modificarperfilusu" value="Guardar">
       <input type="submit" name="spares" value="crear usuarios db">
       </form>
       <br><br>
       <?php 
if(isset($_POST["createdbusers"])){
require_once "Procesos.php"; 
$Procesos = new Procesos();
$result= $Procesos->crearusers();
}
if(isset($_POST["spares"])){
require_once "Procesos.php"; 
$Procesos = new Procesos();
$id=null;
$result= $Procesos->list_users($id);
             while($row = mysqli_fetch_assoc($result)){
                 $usuario=$row['Id_usu'];
                 $clave=$row['Password_usu'];
                 $Procesos->createsparedbusers($usuario, $clave);
             }
}
if(isset($_POST["modificarperfilusu"])){
$id=$_POST["userusu"];
$nombre=$_POST["nombreusu"];
$clave=md5($_POST["passusu"]);
$apellido=$_POST["apellidousu"];
$mail=$_POST["correousu"];
    require_once "Procesos.php"; 
$Procesos = new Procesos();
$result= $Procesos->crearadmin($id, $nombre, $clave, $apellido, $mail);
}
?>
</div>
        <td><?php //echo '<a class="btn" href="listausuario+.php?idusu='.$row['Id'].'"><button class="tableheader"><i class="fa fa-plus" aria-hidden="true"></i></button></a>'?></td>
        <td><?php //echo '<a class="btn" href="listausuario=.php?idusu='.$row['Id'].'"><button class="tableheader"><i class="fa fa-cog" aria-hidden="true"></i></button></a>'?></td>
    </div>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.slides.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>