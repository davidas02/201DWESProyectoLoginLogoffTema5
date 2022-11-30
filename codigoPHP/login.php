<?php
if(isset($_REQUEST['iniciarSesion'])&&$entradaOK){
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
            <h1>Tema 5 Proyecto LoginLogoff</h1>
            <div id="nav">
                <h2>Login</h2>
            </div>
        </header>
        <div id="ejercicios"><?php
        $entradaOK=true;
        $aRespuestas=[
            'usuario'=>"",
            'password'=>""
        ];
        $aErrores=[
            'usuario'=>"",
            'password'=>""
        ];
        $sql1 = <<< sql
             select T01_CodUsuario,T01_Password from T01_Usuario where T01_CodUsuario='$_SERVER[PHP_AUTH_USER]';
            sql;
        if(isset($_REQUEST['iniciarSesion'])){
            
        }else{
            $entradaOK=false;
        }
        ?>
        <form name="ejercicio21" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="formulario">
                    <tr>
                        <td><label for="usuario">Usuario:</label></td>
                        <td><input type="text" name="usuario" class="usuario"/></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td><input type="password" name="password" class="password" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="iniciarSesion" value="Iniciar Sesion" name="iniciarSesion"></td>
                    </tr>
                </table>
            </form>
        </div>
    <footer> 
        <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
        <a href="../../201DWESProyectoDWES/indexProyectoDWES.php"><img src="../doc/img/home.png" alt="HOME"/></a>
        <a href="https://www.github.com/davidas02/201DWESProyectoLoginLogoffTema5" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
        <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
    </footer>
</body>
</html>