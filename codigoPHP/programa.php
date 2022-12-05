<?php
session_start();
if(is_null($_SESSION['usuarioDAW201AppLoginLogoff'])){
    header('Location: login.php');
    exit;
}
if (isset($_REQUEST['salir'])) {
    $_SESSION['usuarioDAW201AppLoginLogoff']=null;
    session_destroy();
    header('Location: login.php');
    exit;
}

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
                    echo"Bienvenido ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_DescUsuario;
                    ?>
                    </p>
                    <p>
                    <?php
                    if($_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones>0){
                    echo"Ultimo inicio de sesión: ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_FechaHoraUltimaConexion;
                    ?>
                    </p>
                    <p>
                    <?php
                    echo"Te has conectado ".$_SESSION['usuarioDAW201AppLoginLogoff']->T01_NumConexiones." veces";
                    }else{
                    ?>
                    </p>
                    <p>
                        <?php 
                        echo 'Es la primera vez que te conectas';
                    }
                        ?>
                    </p>
                    <tr>
                        <td colspan="2"><input type="submit" id="salir" value="Salir" name="salir"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="detalle" value="Detalle" name="detalle"></td>
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