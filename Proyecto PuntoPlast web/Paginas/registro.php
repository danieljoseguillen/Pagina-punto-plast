<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/Estiloregistro.css">
<link rel="stylesheet" type="text/css" href="../Css/fonts.css">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
    <br>
    <div class="marco3">
<header>
        <div><a href="../Index.php"><img class="imagen"   src="../Imagenes/puntomini.jpg"></a></div>
</header>
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
        require_once "Procesos.php";
        $Procesos = new Procesos();
            if($_SESSION["user"]!='root') {
            session_destroy();}
        ?>
     <form action="" method="post">
         <br>
         <div><b>Datos de Cuenta</b></div>
        <table>
        <tr>
        <td align=right><br>Usuario:</td>  
        <td><br><input type="text" name="usuario" class="input" maxlength="20" required> </td>
        </tr>
         <tr>
        <td align=right>Contraseña:</td>  
        <td><input type="password" name="cont" class="input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="La contraseña debe tener mas de 6 digitos, menos de 20 y debe contener almenos una mayuscula, una minuscula y un numero." maxlength="20" required></td>
        </tr>
        <tr>
        <td align=right>Confirmar<br>Contraseña:</td>  
        <td><input type="password" name="cont2" class="input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" title="Las contraseñas deben coincidir" maxlength="20" autocomplete="off" required></td>
        </tr>
         <th colspan="2"><br>Datos de Usuario</th>
        <TR>
        <td align=right><br>Cedula:</td>  
        <td><br><input type="text" name="cedula" class="input" pattern="[0-9]{6,11}" title="La cedula solo puede contener numeros" maxlength="11" required></td>
        </TR>
        <tr>
                  <td align=right>Origen:</td>
                  <td><input type=radio name="origen" value="V" checked>Residente <br class="space" style="display:none;"><br class="space" style="display:none;"><input type=radio name="origen" value="E">Extranjero</td>
        </tr>
        <tr>
        <td align=right>Nombre:</td>  
        <td><input type="text" name="nombre"  pattern="[a-zA-Z ]{3,30}" class="input" required  title="Solo letras de 3 a 30 caracteres" maxlength="30"></td>
        </tr>
         <tr>
        <td align=right>Apellido:</td>  
        <td><input type="text" name="apellido"  pattern="[a-zA-Z ]{3,30}" class="input" required  title="solo letras de 3 a 30 caracteres" maxlength="30"></td>
        </tr>
        <tr>
        <td align=right>Correo:</td>  
        <td><input type="email" name="correo" class="input" maxlength="30" required></td>
        </tr>
        <tr>
        <td align=right>Direccion:</td>  
            <td><textarea rows="4" name="direccion" required title="maximo de 200 caracteres" maxlength="200"></textarea></td>
        </tr>
        <tr>
        <td align=right>Telefono:</td>  
        <td><input type="tel" name="telefono" class="input" pattern= "[0-9]{9,12}" required title="Solo numeros" maxlength="12"></td>
        </tr>
            <tr>
                <td><input type=radio name="tipousu" value="Natural" onchange="show2()">Natural</td>
                <td><input type=radio name="tipousu" value="Juridico" onchange="show()">Juridico</td>
            </tr>
        <table>
            <br>
        <tr id="Juridico" style="display:none;">
            <td align=right>Rif Juridico:<br>Empresa: </td> 
            <td><input type="text" name="documento" maxlength="20"><br><input type="text" name="empresa" maxlength="30"></td>
        </tr> 
            </table>
        </table>
         <br><br>
         <button id="submit" type="submit" name="registrar" disabled>Registrar</button>
         <br><br>
         <a href="../Index.php" class="btn">Volver</a>
        </form>
        <button class="used-for-btn-css-class" style="display: none"></button>
    </div>
    
    <script type="text/javascript">
            function show(str){
                document.getElementById('Juridico').style.display = 'block';
                document.getElementById('submit').disabled = false;
            }
            function show2(sign){
                document.getElementById('Juridico').style.display = 'none';
                document.getElementById('submit').disabled = false;
            }
        </script>
        <?php
if (isset($_POST["registrar"])){
    $cedula=$_POST["cedula"];
    $usuario=$_POST["usuario"];
    $clave=$_POST["cont"];
    $clave2=$_POST["cont2"];
    $nombre=ucwords(strtolower($_POST["nombre"]));
    $apellido=ucwords(strtolower($_POST["apellido"]));
    $mail=$_POST["correo"];
    $dir=$_POST["direccion"];
    $telf=$_POST["telefono"];
    $tipo=$_POST["tipousu"];
    $doc= $_POST["documento"];
    $emp= strtoupper($_POST["empresa"]);
    $origen= $_POST["origen"];
    if($clave == $clave2){
        $Procesos->reg_users($cedula, $usuario, $clave, $nombre, $apellido, $mail, $dir, $telf, $tipo, $origen, $doc, $emp);
    }else{ echo "<script type='text/javascript'>alert('Las claves no coinciden')</script>";}
   }
    ?>
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