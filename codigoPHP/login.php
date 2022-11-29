<?php
if (isset($_REQUEST['volver'])) {
    header('Location: ../../201DWESProyectoDWES/indexProyectoDWES.php');
    exit;
}
if(isset($_REQUEST['iniciarSesion'])){
    header('Location: programa.php');
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
            <h1>Tema 5 DESARROLLO DE APLICACIONES WEB UTILIZANDO CÓDIGO EMBEBIDO</h1>
            <div id="nav">
                <h2>1. Desarrollo de un control de acceso con identificación del usuario basado en la función header().</h2>
            </div>
        </header>
        <div id="ejercicios">
        <form name="ejercicio21" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="formulario">
                    <tr>
                        <td><label for="usuario">Usuario:</label></td>
                        <td><input type="text" name="usuario" class="entradadatos"/></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td><input type="password" name="password" class="entradadatos" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="iniciarSesion" value="Iniciar Sesion" name="iniciarSesion"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="volver" value="Volver" name="volver"></td>
                    </tr>
                </table>
            </form>
        </div>
    <footer> 
        <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
        <a href="../indexProyectoTema5.php"><img src="../doc/img/home.png" alt="HOME"/></a>
        <a href="https://www.github.com/davidas02" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
        <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
    </footer>
</body>
</html>