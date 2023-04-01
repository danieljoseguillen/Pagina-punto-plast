<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="Css/Estilo.css">
<link rel="stylesheet" type="text/css" href="Css/fonts.css">
<meta name="viewport" content="width=device-width, user scalable=no, initial-scale=1.0, minimun-scale=1.0">
<tittle></tittle>
</head>
<body>
    <div class="contenedor">
        <header class="left">
            <div><img class="imagen" src="Imagenes/puntop.jpg"></div>
        </header>
        <br> 
         <div class="marco3">
    <div id=block class="marco">
        <p class="titulo">Bienvenidos</p>
        
        <form action="" method="post">
        <p>Nombre:</p><input type="text" name="nomb"><br> 
        <p>Contrasena:</p><input type="password" name="passw"><br><br>
        <input type="submit" value="Ingresar" name="Ingresar">
            <br>
        </form>
        <a href="Paginas/registro.php"><button>Registro</button></a>
        <?php
            require_once "Paginas/Procesos.php"; 
            $Procesos = new Procesos(); 
            if($_SESSION["user"]!='root') {
            header('Location: Paginas/main.php');
}

            //session_start();
            if(isset($_POST["Ingresar"])){   
            $result = $Procesos->get_users($_POST["nomb"],$_POST["passw"]);   
            if($result==true){
                header('Location: Paginas/main.php');
            }else{
                echo "Usuario o contrasena incorrectos";
            }}
            ?>
    </div>
             <div id=block class="marco2"><marquee direction="left" >
<img style="height:300px;" src="Imagenes/marque1.jpg">
<img style="height:300px;" src="Imagenes/marque2.jpg">
<img style="height:300px;" src="Imagenes/marque3.jpg">
<img style="height:300px;" src="Imagenes/marque4.jpg">
<img style="height:300px;" src="Imagenes/marque5.jpg">
<img style="height:300px;" src="Imagenes/marque6.jpg">
<img style="height:300px;" src="Imagenes/marque7.jpg">
<img style="height:300px;" src="Imagenes/marque8.jpg">
<img style="height:300px;" src="Imagenes/marque9.jpg">
</marquee></div></div>
        <br>
        <div class="marco3">
        <div class="slides">
        <img src="Imagenes/slides24.jpg">
        <img src="Imagenes/slides1.jpg"> 
        <img src="Imagenes/slides2.jpg"> 
        <img src="Imagenes/slides4.jpg"> 
        </div>
        </div>
         
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.slides.js"></script>
    <script>
     $(function(){
  $(".slides").slidesjs({
    play: {
      active: true,
        // [boolean] Generate the play and stop buttons.
        // You cannot use your own buttons. Sorry.
      effect: "slide",
        // [string] Can be either "slide" or "fade".
      interval: 5000,
        // [number] Time spent on each slide in milliseconds.
      auto: false,
        // [boolean] Start playing the slideshow on load.
      swap: true,
        // [boolean] show/hide stop and play buttons
      pauseOnHover: false,
        // [boolean] pause a playing slideshow on hover
      restartDelay: 2500
        // [number] restart delay on inactive slideshow
    }
  });
});
    </script>
</body>
</html>