<html>
<?php
session_start();
if(!isset($_SESSION["user"]))  {
$_SESSION["user"]="root";
$_SESSION["pass"]="";
}
    define('DB_HOST','localhost'); 
    define('DB_NAME','bd_puntoplast'); 
    define('DB_CHARSET','utf-8'); 
  //echo $DB_USER;
    class Modelo 
{ 
    protected $_db; 

    public function __construct() 
    { 

        
        $this->_db = new mysqli(DB_HOST, $_SESSION["user"], $_SESSION["pass"], DB_NAME); 

        if ( $this->_db->connect_errno ) 
        { 
            echo "Fallo al conectar con la base de datos: ". $this->_db->connect_error; 
            return;     
        } 
        $this->_db->autocommit(FALSE);
        $this->_db->set_charset(DB_CHARSET); 
    } 
    } 

    class Procesos extends Modelo 
    {     
    public function __construct() 
    { 
        parent::__construct(); 
    } 
    public function get_users($nom, $pass) //---------------------------login----
    { 
        $_SESSION["user"]="log";
        $_SESSION["pass"]="2345logger";
        $pass2=md5($pass);
        $pass3=md5($nom);
        $query = "SELECT * FROM usuario WHERE Id_usu='".$nom."' && Password_usu='".$pass2."'"; 
        $result = $this->_db->query($query);
        $resultado = mysqli_fetch_array($result);
        $estado=$resultado['tipo_usu'];
        $count_row = $result->num_rows;
        
        if ($count_row == 1){
            $res = mysqli_fetch_array($result);
            if ($res["Estado_usu"]=="Suspendido" OR $res["tipo_usu"]=="Invitado"){
                return false;
            }
            $_SESSION["user_name"]=$nom;
            $sql="INSERT INTO actividad (Id_usu, Descripcion_actividad, Objetivo_actividad) values('".$nom."','Inicio de sesion',null)";
            $this->_db->query($sql);
            if($estado == "Cliente"){
            $_SESSION["user"]=$nom;
            $_SESSION["pass"]=$pass3;
            $_SESSION["admin_status"]="false";
            }
            if($estado == "Administrador"){
            $_SESSION["user"]=$nom;
            $_SESSION["pass"]=$pass3;
            
            //$_SESSION["user"]=$nom;
            //$_SESSION["pass"]=$pass2;
            $_SESSION["admin_status"]="true";
            }
            $log=true;
            //$this->_db->change_user($DB_USER,$DB_PASS, 'bd_puntoplast');
            //$this->_db->change_user($nom,$pass2, 'bd_puntoplast');
            //if ($result = $this->_db->query("SELECT CURRENT_USER()")) {
            //$row = $result->fetch_row();printf("Usuario: %s\n", $row[0]);$result->close();}
            if ( $this->_db->connect_errno ) 
            { 
            echo "Fallo al conectar con la base de datos: ". $this->_db->connect_error; 
            return;    
            $this->_db->rollback();
            } 
            $this->_db->commit();
            return $log;
        }else{
        return false;
        }
    }//-------------------------------------------------------------------------
        
    //--------------------------------------------registro---------------------- 
    public function reg_users($cedula, $usuario, $clave, $nombre, $apellido, $mail, $dir, $telf, $tipo, $origen, $doc, $emp){
        $_SESSION["user"]="log";
        $_SESSION["pass"]="2345logger";
//------------------------validacion--------------------------------------------
        if ($tipo=="Juridico"){
        if ($doc==null OR $emp== null){
        echo "<script type='text/javascript'>alert('Por favor, llene todos los campos solicitados')</script>";
        die();
        }}
        //valida si existe el usuario
        $veri="SELECT * from usuario WHERE Id_usu='".$usuario."'";
        $resul = $this->_db->query($veri);
        if( $resul !== false){
        $count_rowveri = $resul->num_rows;
        if ($count_rowveri >= 1) {
          echo "<script type='text/javascript'>alert('Ya existe un usuario con esta ID')</script>";  
            die();}}
        // valida si ya existe la cedula
        $veri1="SELECT * from cliente WHERE Ci_clie='".$cedula."'";
        $resul1 = $this->_db->query($veri1);
        if( $resul1 !== false){
        $count_rowveri1 = $resul1->num_rows;
        if ($count_rowveri1 >= 1) {
          echo "<script type='text/javascript'>alert('Ya existe un usuario con esta cedula')</script>"; 
         die();}}
        
        $veri2="SELECT * from usuario WHERE Email_usu='".$mail."'";
        $resul2 = $this->_db->query($veri2);
        if( $resul2 !== false){
        $count_rowveri2 = $resul2->num_rows;
        if ($count_rowveri2 >= 1) {
          echo "<script type='text/javascript'>alert('Ya existe un usuario con este correo')</script>"; 
         die();}}
//-------------------------validacion
        if ($tipo=="Juridico"){
            //juridico
        $sql2="INSERT into `juridico` (Ci_clie, Rif_juri, Empresa_juri) values ('".$cedula."','".$doc."','".$emp."')";
        }
            $clave2=md5($clave);
            $query1 = "INSERT into usuario(Id_usu, Password_usu, Email_usu, tipo_usu) values ('".$usuario."','".$clave2."','".$mail."','Cliente')";
            $result1 = mysqli_query($this->_db,$query1);
        
            $query = "INSERT into cliente (Tipo_ci_clie, Ci_clie, Nomb_clie, Ape_clie, Tipo_clie, Tlf_clie, Dir_clie, Id_usu) values ('".$origen."','".$cedula."','".$nombre."','".$apellido."','".$tipo."','".$telf."','".$dir."','".$usuario."')";
            $result = mysqli_query($this->_db,$query);
            if ($tipo=="Juridico"){
            $result2 = mysqli_query($this->_db,$sql2);
            }
            $user_db21="CREATE USER '$usuario'@'localhost' identified by '$clave2';";
            $user_db22="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.cliente TO '$usuario'@'localhost';"; 
            $user_db23="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.usuario TO '$usuario'@'localhost';";
            $user_db24="GRANT SELECT, INSERT, UPDATE, DELETE ON bd_puntoplast.pedido TO '$usuario'@'localhost';";
            $user_db25="GRANT SELECT, INSERT, UPDATE, DELETE ON bd_puntoplast.pedido_producto TO '$usuario'@'localhost';";
            $user_db26="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.producto TO '$usuario'@'localhost';";
            $user_db27="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.actividad TO '$usuario'@'localhost';";
            $user_db28="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.juridico TO '$usuario'@'localhost';";
            $result = mysqli_query($this->_db, $user_db21) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db22) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db23) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db24) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db25) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db26) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db27) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db28) or die(mysqli_connect_errno());
            
        if( $result !== false && $result1 !== false) { 
             echo '<script language="javascript"> alert("Su cuenta a sido creada con exito!"); location.href = "../Index.php";</script>';
			 
            $this->_db->commit();
            }else {
            if( $result == false) { 
        echo "<script type='text/javascript'>alert('Ha ocurrido un error al crear la cuenta, por favor verifique sus datos1.')</script>";
                $this->_db->rollback();
            }
            if($result1 == false) {
                echo "<script type='text/javascript'>alert('Ha ocurrido un error al crear la cuenta, por favor verifique sus datos2.')</script>";
            $this->_db->rollback();
            }
            }//}
    }//-----------------------------registro-------------------------------------
        
        //------------------------------------------cargar usuarios--------------
    public function load_users(){
    $usu=$_SESSION["user_name"];
    if($_SESSION["admin_status"] == "true"){
    $sql1 = "SELECT * FROM usuario WHERE Id_usu='".$usu."'"; 
    }
    if($_SESSION["admin_status"] == "false"){
    $sql="SELECT Tipo_clie FROM cliente inner join usuario using(`Id_usu`) WHERE Id_usu='".$usu."'";
    $resultado = $this->_db->query($sql);
        $users = mysqli_fetch_array($resultado);
        $tipo=$users['Tipo_clie'];
        if($tipo=="Natural"){
        $sql1="SELECT * FROM usuario inner join cliente using (`Id_usu`) WHERE usuario.Id_usu='".$usu."'"; 
        }
        if($tipo=="Juridico"){
         $sql1="SELECT * FROM usuario inner join cliente using (`Id_usu`) inner join `juridico` using (`Ci_clie`) WHERE usuario.Id_usu='".$usu."'";   
        }}
        $resultado1 = $this->_db->query($sql1);
        $users1 = mysqli_fetch_array($resultado1);
        return $users1;
    } //-------------------------------------------------------------------------
        
    //-------------------------------actualizar usuarios-------------------------  
    public function update_users($cedula ,$nombre, $clave, $apellido, $mail, $dir, $telf, $origen, $rif, $emp){
        if($_SESSION["admin_status"] == "true"){
        $query="UPDATE usuario set Password_usu='".$clave."', Email_usu='".$mail."' WHERE Id_usu='".$_SESSION["user_name"]."'";
        $resultado = $this->_db->query($query);
       if($resultado=="true"){
        echo '<script language="javascript"> alert("Actualizacion realizada con exito"); location.href = "perfiladmin.php";</script>';
        $this->_db->commit();
        }else{ 
        echo "<script type='text/javascript'>alert('Ha ocurrido un error al actualizar, por favor verifique sus datos.')</script>";
        $this->_db->rollback();
        die;
        }}else{
        $query="UPDATE usuario set Password_usu='".$clave."', Email_usu='".$mail."' WHERE Id_usu='".$_SESSION["user_name"]."'";
            
        $query1="UPDATE cliente set Tipo_ci_clie='".$origen."',Nomb_clie='".$nombre."', Ape_clie='".$apellido."', Tlf_clie='".$telf."', Dir_clie='".$dir."' WHERE Ci_clie='".$cedula."'";
        $resultado = $this->_db->query($query);   
        $resultado1 = $this->_db->query($query1);
            
        $sql="SELECT Tipo_clie FROM cliente WHERE Ci_clie='".$cedula."'";  
        $result = $this->_db->query($sql);
        $result1 = mysqli_fetch_array($result);
        $tipo=$result1['Tipo_clie']; 
        if ($tipo=="Juridico"){ 
        $query2="UPDATE `juridico` set Rif_juri='".$rif."', Empresa_juri='".$emp."' WHERE Ci_clie='".$cedula."'";  
        $resultado2 = $this->_db->query($query2) or die(mysqli_connect_errno());
        }
         //$_SESSION["user"]="root";$_SESSION["pass"]="";$dbup="SET PASSWORD FOR '".$_SESSION["user_name"]."'@'localhost' = '".$clave."';";$result = mysqli_query($this->_db, $dbup) or die(mysqli_connect_errno());
        if($resultado==true && $resultado1==true){
            echo '<script language="javascript"> alert("Actualizacion realizada con exito"); location.href = "perfilusuario.php";</script>';
            $this->_db->commit();
            }else{
        echo "<script type='text/javascript'>alert('Ha ocurrido un error al actualizar, por favor verifique sus datos.')</script>";
            $this->_db->rollback();
            }
        }
    }//-------------------------registro producto-------------------------------------------
    public function reg_product($id, $nombre, $tipo, $precio, $stock, $min){
    $veri="SELECT * from producto WHERE Cod_prod='".$id."'";
        $result = $this->_db->query($veri);
        if( $result !== false){
        $count_row = $result->num_rows;
        if ($count_row >= 1) {
          echo "<script type='text/javascript'>alert('Ya existe un producto con esta ID')</script>";  
            die();}}
        
        $sql="INSERT into producto (Cod_prod, Nomb_prod, Tipo_prod, Precio_prod, Stock_prod, Cantidad_Min) values('".$id."', '".$nombre."','".$tipo."', '".$precio."','".$stock."','".$min."')";
        $result = $this->_db->query($sql);
        if( $result !== false){
         echo '<script language="javascript"> alert("Registro exitoso"); location.href = "productoagregar.php";</script>';
            $this->_db->commit();
        }else{
        echo "<script type='text/javascript'>alert('Ha ocurrido un error al registrar el producto')</script>";  
            $this->_db->rollback();
        }
    }//--------------------------------------------------------------------------
        public function list_products($prod, $e, $t){//--cargar productos.... o quizas mas..--
        if ($prod==null){
            if($e!==null){
                if ($t =="limpieza"){
                $sql="SELECT * from producto WHERE Stock_prod >= Cantidad_Min AND Tipo_prod='Limpieza'";
                }else if ($t =="plastico"){
                $sql="SELECT * from producto WHERE Stock_prod >= Cantidad_Min AND Tipo_prod='Plastico'";
                }else{
            $sql="SELECT * from producto WHERE Stock_prod >= Cantidad_Min";
                }
            }else{
                if ($t =="limpieza"){
                $sql="SELECT * from producto WHERE Tipo_prod='Limpieza'";
                }else if ($t =="plastico"){
                $sql="SELECT * from producto WHERE Tipo_prod='Plastico'";
                }else{
                $sql="SELECT * from producto";
                }
            }
        }
        if ($prod!==null){
            if($e!==null){
             if ($t =="limpieza"){
               $sql="SELECT * from producto where Nomb_prod LIKE '%".$prod."%' AND Stock_prod >= Cantidad_Min AND Tipo_prod='Limpieza'";
                }else if ($t =="plastico"){
                $sql="SELECT * from producto where Nomb_prod LIKE '%".$prod."%' AND Stock_prod >= Cantidad_Min AND Tipo_prod='Plastico'";
                }else{   
            $sql="SELECT * from producto where Nomb_prod LIKE '%".$prod."%' AND Stock_prod >= Cantidad_Min";
             }
            }else{
            if ($t =="limpieza"){
            $sql="SELECT * from producto where Nomb_prod LIKE '%".$prod."%' AND Tipo_prod='Limpieza'";
            }else if ($t =="plastico"){
            $sql="SELECT * from producto where Nomb_prod LIKE '%".$prod."%' AND Tipo_prod='Plastico'";
            }else{   
            $sql="SELECT * from producto where Nomb_prod LIKE '%".$prod."%'";
            }
        }}
    $resultado = $this->_db->query($sql);
        return $resultado;
         
    }//--------cargar productos especificos---... quizas tambien lo use pronto---
        public function load_product($codigo){
        $sql="SELECT * from producto WHERE Nomb_prod='".$codigo."' OR Cod_prod='".$codigo."'";
        $resultado = $this->_db->query($sql);
        $product = mysqli_fetch_array($resultado);
        return $product;
        }
        
        public function list_users($id){//--cargar usuarios.... sin mas..--------
        if ($id==null){
            $sql="SELECT * from cliente inner join usuario using(Id_usu)";
        } if ($id!==null){
            $sql="SELECT * from cliente inner join usuario using(Id_usu) WHERE usuario.Id_usu LIKE '%".$id."%' OR cliente.Ci_clie LIKE '".$id."%'";
        }
    $resultado = $this->_db->query($sql);
        return $resultado;
        }
        public function update_product($id, $nombre, $tipo, $precio, $stock, $min, $img){
          //---------------actualiza productos----------------------
        if($img !== null){
        $sql="UPDATE producto SET Nomb_prod='".$nombre."',Tipo_prod='".$tipo."',Precio_prod='".$precio."',Stock_prod='".$stock."', Cantidad_Min='".$min."', Img_prod='".$img."' WHERE Cod_prod='".$id."'";
        }else{
        $sql="UPDATE producto SET Nomb_prod='".$nombre."',Tipo_prod='".$tipo."',Precio_prod='".$precio."',Stock_prod='".$stock."', Cantidad_Min='".$min."' WHERE Cod_prod='".$id."'";
        }
        $result = $this->_db->query($sql);
          if( $result !== false){
        echo '<script language="javascript"> alert("Actualizacion realizada con exito"); location.href = "listaproducto.php";</script>'; 
              $this->_db->commit();
        }else{
        echo "<script type='text/javascript'>alert('Ha ocurrido un error al actualizar el producto')</script>";
          $this->_db->rollback();
          }   
        }
        
        public function load_client($usu){//---------cargar clientes especificos
        $sql="SELECT Tipo_clie FROM cliente inner join usuario using(`Id_usu`) WHERE Id_usu='".$usu."'";
        $resultado = $this->_db->query($sql);
        $users = mysqli_fetch_array($resultado);
        $tipo=$users['Tipo_clie'];  
        if($tipo=="Juridico"){
         $sql1="SELECT * FROM cliente inner join usuario using (`Id_usu`) inner join `juridico` using (`Ci_clie`) WHERE usuario.Id_usu='".$usu."'";   
        }else{
        $sql1="SELECT * FROM cliente inner join usuario using (`Id_usu`) WHERE usuario.Id_usu='".$usu."'"; 
        }
        $resultado1 = $this->_db->query($sql1);
        $users1 = mysqli_fetch_array($resultado1);
        return $users1;
    }
        
        public function check_client($usu){//---------cargar clientes especificos
        $sql="SELECT * FROM usuario WHERE Id_usu='".$usu."'"; 
        $resultado = $this->_db->query($sql); 
        $result= mysqli_fetch_array($resultado);
        $tipo=$result['tipo_usu'];
        if($resultado !== false){
        if($tipo !=="Invitado"){
        return $tipo;
        }else{
        return 0;
        }    
        }
        if($resultado == false){return 0;}
    }
        
        public function suspender ($usu, $estado){
            if($estado=="Suspendido"){//------------suspende o activa usuarios---
            $sql="UPDATE usuario SET Estado_usu='Activo' WHERE Id_usu='".$usu."'";}else{
            $sql="UPDATE usuario SET Estado_usu='Suspendido' WHERE Id_usu='".$usu."'";
            }
            $resultado = $this->_db->query($sql);
            if( $resultado !== false){
         echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listausuarios.php";</script>';
                $this->_db->commit();
        }else{
        echo "<script type='text/javascript'>alert('Ha ocurrido un error')</script>";  
                $this->_db->rollback();
        }
        }
        
        public function session (){//------ checkeo de sesion-------
             //if ($result = $this->_db->query("SELECT CURRENT_USER()")) {
            //$row = $result->fetch_row();printf("Usuario: %s\n", $row[0]);$result->close();}
        if (isset($_SESSION["user_name"]) && !empty($_SESSION["user_name"])){
        if (isset($_SESSION["admin_status"]) && !empty($_SESSION["admin_status"])){
            return $_SESSION["admin_status"];   
        }else{
        header('Location: logout.php');}
        }else{
        header('Location: logout.php');}
        }
        
        public function anular ($idped){//--------anula pedidos-------
        //$timezone = new DateTimeZone('America/Caracas'); 
        //$date=new DateTime(null,$timezone);
        $query="UPDATE pedido SET Fecha_estado_ped=now(),Estado_ped='Anulado' WHERE Num_ped='".$idped."'";
        $resultado = $this->_db->query($query);
           if( $resultado == false){
        echo "<script type='text/javascript'>alert('Ha ocurrido un error')</script>";  
        }
        if ($resultado !== false){
        $query1="SELECT * from pedido_producto WHERE Num_ped='".$idped."'";
        $resultado1 = $this->_db->query($query1);
        while($row = mysqli_fetch_array($resultado1)){
            $resultado2="UPDATE producto SET Stock_prod=Stock_prod+'".$row['Cant_prod_ped']."' WHERE Cod_prod='".$row['Cod_prod']."'";
            $resultado2 = $this->_db->query($resultado2);
        }
             if($_SESSION["admin_status"] == "true"){
         echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listapedidos.php";</script>';
                 $this->_db->commit();
             }else{
             echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listapedido.php";</script>';
                 $this->_db->commit();
             }
        }
        }
        
        public function pedido($id, $cantidad){//-------procesa pedidos---------
        $pass="true";
        for($i=0; $i < count($id); $i++){
            $sqlpass="SELECT * from producto WHERE Cod_prod='".$id[$i]."'";
            $querypass=$this->_db->query($sqlpass);
            $prodpass = mysqli_fetch_array($querypass);
            if($prodpass["Stock_prod"]-$prodpass["Cantidad_Min"] < $cantidad[$i]){
            $pass="false";
                echo '<script language="javascript"> alert("La cantidad ingresada para el producto supera el Stock actual"); location.href = "listacatalogo.php";</script>';
            }
        }
        if ($pass=="true"){
        $sqlced="SELECT Ci_clie FROM cliente where Id_usu='".$_SESSION["user_name"]."'";
        $queryced=$this->_db->query($sqlced);
        $fetchced = mysqli_fetch_array($queryced);
        $cedula=$fetchced['Ci_clie'];
        $sql="INSERT into pedido (Ci_clie) values('".$cedula."')";
        $result = $this->_db->query($sql);
        $select= "SELECT MAX(Num_ped) from pedido WHERE Ci_clie='".$cedula."'";
        $select1=$this->_db->query($select);
        $product = mysqli_fetch_array($select1); 
            if( $select1 !== false){
            $productos = $product['MAX(Num_ped)'];
            for($i=0; $i < count($id); $i++){
             $ids=$id[$i];
             $cant=$cantidad[$i];
            $queryprod="SELECT Precio_prod from producto WHERE Cod_prod='".$ids."'";
            $selectprod=$this->_db->query($queryprod);
            $prodprec = mysqli_fetch_array($selectprod);
            $precio2=$prodprec["Precio_prod"];
            $precio=$precio2 * $cant;
            $sql1="INSERT into pedido_producto (Num_ped, Cod_prod, Cant_prod_ped, Precio_cant_ped) values('".$productos."','".$ids."','".$cant."','".$precio."')";
            $select3=$this->_db->query($sql1);
            //resta de stock
             $query="SELECT * from pedido_producto WHERE Num_ped='".$productos."' AND Cod_prod='".$ids."'";
        $resultado = $this->_db->query($query);
        while($row = mysqli_fetch_array($resultado)){
            $resultado1="UPDATE producto SET Stock_prod=Stock_prod-'".$row['Cant_prod_ped']."' WHERE Cod_prod='".$ids."'";
            $this->_db->query($resultado1);   
        }
        } echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listapedido.php";</script>';
            $this->_db->commit();
            }
            return $productos;
            }else{
        echo "<script type='text/javascript'>alert('Ha ocurrido un error')</script>";  $this->_db->commit();
        }
        }
        
        public function mod_ped($idped,$idprod,$cantidad){
            $pass="true";
        for($i=0; $i < count($idprod); $i++){
            $sqlpass="SELECT * from producto inner join pedido_producto using(Cod_prod) WHERE Cod_prod='".$idprod[$i]."' and Num_ped='".$idped."'";
            $querypass=$this->_db->query($sqlpass);
            $prodpass = mysqli_fetch_array($querypass);
            
            if($prodpass["Stock_prod"]+$prodpass["Cant_prod_ped"]-$prodpass["Cantidad_Min"] < $cantidad[$i]){
            $pass="false";
                echo '<script language="javascript"> alert("La cantidad ingresada para el producto supera el Stock actual"); location.href = "listapedido.php";</script>';
            }
        }
        
        if ($pass=="true"){ 
        $query1="SELECT * from pedido_producto WHERE Num_ped='".$idped."'";
        $resultado1 = $this->_db->query($query1);
        while($row = mysqli_fetch_array($resultado1)){
            $resultado2="UPDATE producto SET Stock_prod=Stock_prod+'".$row['Cant_prod_ped']."' WHERE Cod_prod='".$row['Cod_prod']."'";
            $resultado2 = $this->_db->query($resultado2);
            }
            $sqldel="DELETE FROM pedido_producto WHERE Num_ped='".$idped."'";
            $resultadodel=$this->_db->query($sqldel);
            
            for($i=0; $i < count($idprod); $i++){
             $ids=$idprod[$i];
             $cant=$cantidad[$i];
            $queryprod="SELECT Precio_prod from producto WHERE Cod_prod='".$ids."'";
            $selectprod=$this->_db->query($queryprod);
            $prodprec = mysqli_fetch_array($selectprod);
            $precio2=$prodprec["Precio_prod"];
            $precio=$precio2 * $cant;
            $sql1="INSERT into pedido_producto (Num_ped, Cod_prod, Cant_prod_ped, Precio_cant_ped) values('".$idped."','".$ids."','".$cant."','".$precio."')";
            $select3=$this->_db->query($sql1);
            //resta de stock
            $resultado1="UPDATE producto SET Stock_prod=Stock_prod-'".$cant."' WHERE Cod_prod='".$ids."'";
            $this->_db->query($resultado1); 
            //$timezone = new DateTimeZone('America/Caracas'); 
            //$date=new DateTime(null,$timezone);
        $query="UPDATE pedido SET Fecha_estado_ped=now() WHERE Num_ped='".$idped."'";
        $resultado3 = $this->_db->query($query);
        } echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listapedido.php";</script>';$this->_db->commit();}
        }
        
        public function list_ped($ped, $e, $c){//----- crea un listado de pedidos
            $sqlced="SELECT Ci_clie FROM cliente where Id_usu='".$_SESSION["user_name"]."'";
            $queryced=$this->_db->query($sqlced);
            $fetchced = mysqli_fetch_array($queryced);
            $cedula=$fetchced['Ci_clie'];
        if ($ped==null){//------cuando el campo de busqueda esta vacio
            if($e!==null){//----para usuarios
                if ($c !== 'all'){//---- en espera
                $sql="SELECT * from pedido WHERE Ci_clie='".$cedula."' AND Estado_ped='En espera'";
                }else{//-----todos los pedidos
            $sql="SELECT * from pedido WHERE Ci_clie='".$cedula."'";
                }
            }else{//----- para admins
              if ($c !== 'all'){//-----en espera 
                $sql="SELECT * from pedido WHERE Estado_ped='En espera'";
              }else{// todos
                $sql="SELECT * from pedido";
              }}}
            
        if ($ped!==null){//-----cuando hay algo en el campo de busqueda
            if($e!==null){//------para usuarios
                if ($c !== 'all'){// en espera
                $sql="SELECT * from pedido WHERE Ci_clie='".$cedula."' AND Num_ped LIKE '%".$ped."%' AND Estado_ped='En espera'";
            }else{// todos
        $sql="SELECT * from pedido WHERE Ci_clie='".$cedula."' AND Num_ped LIKE '%".$ped."%'";
        }}else{//-------para admins
               if ($c !== 'all'){//-----en espera 
                $sql="SELECT * from pedido WHERE Num_ped LIKE '%".$ped."%' OR Ci_clie LIKE '%".$ped."%' AND Estado_ped='En espera'";
               }else{// todos
            $sql="SELECT * from pedido WHERE Num_ped LIKE '%".$ped."%' OR Ci_clie LIKE '%".$ped."%'";
               }
            }}
    $resultado = $this->_db->query($sql);
    return $resultado;
        }
        
        public function usu_ped($idped){
        $sql="SELECT * from pedido inner join cliente using(`Ci_clie`) inner join usuario using(`Id_usu`) where Num_ped='".$idped."'";
        $resultado = $this->_db->query($sql);
        $pedido = mysqli_fetch_array($resultado);
        return $pedido;
        }
        
        public function det_ped($idped){//----- muestra detalles del pedido
        $sql="SELECT * from pedido_producto inner join pedido using(`Num_ped`) inner join producto using(`Cod_prod`) WHERE Num_ped='".$idped."'";
        $resultado = $this->_db->query($sql);
        return $resultado;
        }
        public function confirmar ($idped){//-------------confirma pedidos---------------
        //$timezone = new DateTimeZone('America/Caracas'); 
        //$date=new DateTime(null,$timezone);
        $query2="UPDATE pedido set Fecha_estado_ped=now(),Estado_ped='Procesado' WHERE Num_ped='".$idped."'";
            $resultado3 = $this->_db->query($query2);
             if( $resultado3 == false){
        echo "<script type='text/javascript'>alert('Ha ocurrido un error')</script>";  
        }
            if( $resultado3 !== false){
             if($_SESSION["admin_status"] == "true"){
         echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listapedidos.php";</script>';
             }else{
             echo '<script language="javascript"> alert("Operacion exitosa"); location.href = "listapedido.php";</script>';
             }
        }
        }

        public function activity($desc, $obj){//---------- registro de actividad -------
         $sql="INSERT into actividad (Id_usu,Descripcion_actividad, Objetivo_actividad) VALUES ('".$_SESSION["user_name"]."','".$desc."','".$obj."')";
        $this->_db->query($sql); 
        $this->_db->commit();
        }
        
        public function list_activity($id){//--carga registro de actividad-
            if ($id==null){
            $sql="SELECT * FROM actividad INNER JOIN usuario USING(Id_usu)";
        } if ($id!==null){
            $sql="SELECT * FROM actividad INNER JOIN usuario USING(Id_usu) WHERE Id_usu LIKE '%".$id."%'";
        }
    $resultado = $this->_db->query($sql);
        return $resultado;
        }
        
        
//------------------------- Zona de reportes ---------------------------==
       public function reporte_pedido_general(){
       $sql="SELECT Num_ped, Id_usu, Fecha_ped, Estado_ped, SUM(Cant_prod_ped) as cantidad, SUM(Precio_cant_ped) as total FROM `pedido` inner join pedido_producto using(Num_ped) group by Num_ped order by Num_ped";
        $resultado = $this->_db->query($sql);
        $result = mysqli_fetch_array($resultado);
        return $resultado;
       } 
        
        
//------------------------- fin de zona de reportes --------------------==
        //------------------parte de estadisticas----------------------
        public function verest($year){
        $sql="SELECT Num_ped FROM pedido WHERE year(Fecha_ped)='".$year."'";
        $resultado = $this->_db->query($sql);
        $result = mysqli_fetch_array($resultado);
        if (count($result) !== 0){
            return 1;
        }else{echo "<script type='text/javascript'>alert('No se encontraron datos.')</script>";
            return 0;}
        }
        
        public function createsparedbusers($usuario, $clave){
        $_SESSION["user"]="root";
        $_SESSION["pass"]="";
        $clave2=md5($usuario);
         $user_db21="CREATE USER '$usuario'@'localhost' identified by '$clave2';";
            $user_db22="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.cliente TO '$usuario'@'localhost';"; 
            $user_db23="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.usuario TO '$usuario'@'localhost';";
            $user_db24="GRANT SELECT, INSERT, UPDATE, DELETE ON bd_puntoplast.pedido TO '$usuario'@'localhost';";
            $user_db25="GRANT SELECT, INSERT, UPDATE, DELETE ON bd_puntoplast.pedido_producto TO '$usuario'@'localhost';";
            $user_db26="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.producto TO '$usuario'@'localhost';";
            $user_db27="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.actividad TO '$usuario'@'localhost';";
            $user_db28="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.juridico TO '$usuario'@'localhost';";
            $result = mysqli_query($this->_db, $user_db21) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db22) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db23) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db24) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db25) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db26) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db27) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db28) or die(mysqli_connect_errno());
        }
        
        public function crearusers(){
        $_SESSION["user"]="root";
        $_SESSION["pass"]="";
        $user_db1="CREATE USER 'log'@'localhost' identified by '2345logger';";
        $result = mysqli_query($this->_db, $user_db1) or die(mysqli_connect_errno());
        $user_db2="GRANT SELECT, INSERT ON bd_puntoplast.cliente TO 'log'@'localhost';"; 
        $user_db3="GRANT SELECT, INSERT ON bd_puntoplast.usuario TO 'log'@'localhost';";
        $user_db4="GRANT SELECT, INSERT ON bd_puntoplast.actividad TO 'log'@'localhost';";
        $user_db5="GRANT SELECT, INSERT ON bd_puntoplast.juridico TO 'log'@'localhost';";
            $result = mysqli_query($this->_db, $user_db2) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db3) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db4) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db5) or die(mysqli_connect_errno());
            
        //$user_db21="CREATE USER 'user'@'localhost' identified by '1234user';";$user_db22="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.cliente TO 'user'@'localhost';";$user_db23="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.usuario TO 'user'@'localhost';";$user_db24="GRANT SELECT, INSERT, UPDATE, DELETE ON bd_puntoplast.pedido TO 'user'@'localhost';";$user_db25="GRANT SELECT, INSERT, UPDATE, DELETE ON bd_puntoplast.pedido_producto TO 'user'@'localhost';";$user_db26="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.producto TO 'user'@'localhost';";$user_db27="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.actividad TO 'user'@'localhost';";$user_db28="GRANT SELECT, INSERT, UPDATE ON bd_puntoplast.juridico TO 'user'@'localhost';";
            
            //$result = mysqli_query($this->_db, $user_db21) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db22) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db23) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db24) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db25) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db26) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db27) or die(mysqli_connect_errno());$result = mysqli_query($this->_db, $user_db28) or die(mysqli_connect_errno());
            $this->_db->commit();
            
        }
        //==========crea admins, no es parte del programa==============
        public function crearadmin ($id, $nombre, $clave, $apellido, $mail){
            $query = "INSERT into usuario(Id_usu, Password_usu, Email_usu, Tipo_usu, Estado_usu) values ('".$id."','".$clave."','".$mail."','Administrador','Activo')";
            $result = mysqli_query($this->_db,$query) or die(mysqli_connect_errno());
            $clave2=md5($id);
            $user_db1="CREATE USER '$id'@'localhost' identified by '$clave2';";
            $user_db12="GRANT all privileges ON bd_puntoplast.* TO '$id'@'localhost';";
            $result = mysqli_query($this->_db, $user_db1) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db12) or die(mysqli_connect_errno());
        $this->_db->commit();
        }
        public function creardbadmin ($id){
            $clave2=md5($id);
            $user_db1="CREATE USER '$id'@'localhost' identified by '$clave2';";
            $user_db12="GRANT all privileges ON bd_puntoplast.* TO '$id'@'localhost';";
            $result = mysqli_query($this->_db, $user_db1) or die(mysqli_connect_errno());
            $result = mysqli_query($this->_db, $user_db12) or die(mysqli_connect_errno());
        $this->_db->commit();
        }
} 
?>
</html>