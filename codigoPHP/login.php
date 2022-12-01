<?php
require_once '../core/221024libreriaValidacionFormularios.php';
require_once '../conf/confDBPDODesarrollo.php';
$entradaOK = true;
define("MAX_TAMANYO", 8);
define("MIN_TAMANYO", 4);
define("OBLIGATORIO", 1);
$aRespuestas = [
    'usuario' => "",
    'password' => ""
];
$aErrores = [
    'usuario' => "",
    'password' => ""
];
if (isset($_REQUEST['iniciarSesion'])) {
    $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], MAX_TAMANYO, MIN_TAMANYO, OBLIGATORIO);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], MAX_TAMANYO, MIN_TAMANYO, 2, OBLIGATORIO);
    $sql1 = <<<SQL
                        Select * from T01_Usuarios where T01_CodUsuario='$_REQUEST[usuario]';
                        SQL;
    $sql2= <<<SQL
               update T01_Usuario set T01_NumConexiones=T01_NumConexiones+1,T01_FechaHoraUltimaConexion=now() where T01_CodUsuario='$_REQUEST[usuario]'; 
            SQL;
    $ultimaCon=null;
    $conexionesAnteriores=null;
    try {
        $miDB = new PDO(DSN, USER, PASS);
        $statement1 = $miDB->prepare($sql1);
        $statement1->execute();
        $oUsuario = $statement1->fetchObject();
        if ($statement1->rowCount() == 0) {
            $aErrores['password'] = "Error en el login";
        }else{
            $ultimaCon=$oUsuario->T01_FechaHoraUltimaConexion;
            $conxionesAnteriores=$oUsuario->T01_NumConexiones;
        }
    } catch (PDOException $PDOexc) {
        echo $PDOexc->getMessage();
    } finally {
        unset($miDB);
    }
    foreach ($aErrores as $campo => $valor) {
        if ($error != null) {
            $_REQUEST[$campo] = "";
            $entradaOK = false;
        }
    }
} else {
    $entradaOK = false;
}
if ($entradaOK) {
    $aRespuestas['usuario'] = $_REQUEST['usuario'];
    $aRespuestas['password'] = $_REQUEST['password'];
    try {
        $miDB = new PDO(DSN, USER, PASS);
        
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    } finally {
        unset($miDB);
    }
    if (isset($_REQUEST['iniciarSesion'])) {
        header('Location: programa.php');
        exit;
    }
} else {
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
            <div id="ejercicios">
                <form name="ejercicio21" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <table class="formulario">
                        <tr>
                            <td><label for="usuario">Usuario:</label></td>
                            <td><input type="text" name="usuario" class="usuario"/>  <span style="color: red"><?php echo $aErrores['usuario']; ?></span></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td><input type="password" name="password" class="password" /><span style="color: red"><?php echo $aErrores['password']; ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" id="iniciarSesion" value="Iniciar Sesion" name="iniciarSesion"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
        }
        ?>
        <footer> 
            <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
            <a href="../../201DWESProyectoDWES/indexProyectoDWES.php"><img src="../doc/img/home.png" alt="HOME"/></a>
            <a href="https://www.github.com/davidas02/201DWESProyectoLoginLogoffTema5" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
            <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
        </footer>
    </body>
</html>