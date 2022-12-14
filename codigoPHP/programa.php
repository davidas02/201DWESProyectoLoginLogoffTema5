<?php
/**
 *  @author David Aparicio Sir
 *  @version V1.0
 *  @since 07/12/2022
 */
//iniciamos la sesión
session_start();
//Comprobamos que el usuario se ha logeado si no lo redirijo a la ventana de login
if(is_null($_SESSION['usuarioDAW201AppLoginLogoff'])){
    header('Location: login.php');
    exit;
}
if(isset($_REQUEST['modificar'])){
    header('Location: editarPerfil.php');
}
//Comprobamos que hemos pulsado en salir borramos todo lo que hay en la sesion y la destruimos
if (isset($_REQUEST['salir'])) {
    $_SESSION['usuarioDAW201AppLoginLogoff']=null;
    $_SESSION['FechaHoraUltimaConexionAnterior']=null;
    session_destroy();
    header('Location: login.php');
    exit;
}
//Comprobamos que hemos pulsado en detalle y dirigimos a detalle.php
if(isset($_REQUEST['detalle'])){
    header('Location: detalle.php');
    exit;
}

?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Tema 5 ejercicio 1 David Aparicio</title>
            <link rel="stylesheet" href="../webroot/css/estilos.css"/>
            <link rel="icon" type="image/x-icon" href="../doc/img/favicon.ico"/>
            <style>
            table,th,td{
                border: none;
            }
        </style>
        </head>
    <body>
        <header>
            <h1>Tema 5 Proyecto LoginLogoff</h1>
            <div id="nav">
                <h2>Programa</h2>
            </div>
        </header>
        <div id="ejercicios">
        <form name="ejercicio21" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="formulario">
                    <p>
                    <?php
                    //Damos la bienvenida al usuario en diferentes idiomas dependiendo de la cookie idioma
                    switch ($_COOKIE['idioma']) {
                        case "es":
                            echo"Bienvenido ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_DescUsuario;
                            break;
                        case "pt":
                            echo"Bem-vindo ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_DescUsuario;
                            break;
                        case "gb":
                            echo"Welcome ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_DescUsuario;
                            break;
                        default:
                            echo"Bienvenido ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_DescUsuario;
                            break;
                    }
                        
                    ?>
                    </p>
                    <p>
                    <?php
                    //comprobamos el numero de conexiones si es mayor a 1 tambien mostramos la fecha y hora de la ultima conexion
                    if($_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones>1){
                    switch ($_COOKIE['idioma']) {
                        case "es":
                            echo"Ultimo inicio de sesión: ".$_SESSION['FechaHoraUltimaConexionAnterior'];
                            break;
                        case "pt":
                            echo"Último Login: ".$_SESSION['FechaHoraUltimaConexionAnterior'];
                            break;
                        case "gb":
                            echo"Last Login: ".$_SESSION['FechaHoraUltimaConexionAnterior'];
                            break;
                        default:
                            echo"Ultimo inicio de sesión: ".$_SESSION['FechaHoraUltimaConexionAnterior'];
                            break;
                    }
                    ?>
                    </p>
                    <p>
                    <?php
                    //Mostramos el numero de conexiones
                    switch ($_COOKIE['idioma']) {
                        case "es":
                            echo"Te has conectado ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones." veces";
                            break;
                        case "pt":
                            echo"Você se conectou ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones." vezes";
                            break;
                        case "gb":
                            echo"You have been connected ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones." times before";
                            break;
                        default:
                            echo"Te has conectado ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones." veces";
                            break;
                    }
                    }else{
                    ?>
                    </p>
                    <p>
                        <?php 
                        
                        switch ($_COOKIE['idioma']) {
                        case "es":
                            echo 'Es la primera vez que te conectas';
                            break;
                        case "pt":
                            echo"É a primeira vez que você se conecta";
                            break;
                        case "gb":
                            echo"It's the first time you connect";
                            break;
                        default:
                            echo 'Es la primera vez que te conectas';
                            break;
                    }
                    }
                        ?>
                        
                    </p>
                    <tr>
                        <td colspan="2"><input type="submit" id="salir" value="Salir" name="salir"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="detalle" value="Detalle" name="detalle"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="modificar" value="Modificar Perfil" name="modificar"></td>
                    </tr>
                </table>
            </form>
        </div>
    <footer> 
        <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
        <a href="../indexProyectoTema5.php"><img src="../doc/img/home.png" alt="HOME" hidden/></a>
        <a href="https://www.github.com/davidas02/201DWESProyectoLoginLogoffTema5" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
        <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
    </footer>
</body>
</html>