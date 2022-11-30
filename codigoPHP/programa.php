<?php
if (isset($_REQUEST['salir'])) {
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
        <a href="../indexProyectoTema5.php"><img src="../doc/img/home.png" alt="HOME"/></a>
        <a href="https://www.github.com/davidas02/201DWESProyectoLoginLogoffTema5" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
        <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
    </footer>
</body>
</html>