<?php
require_once '../core/221024libreriaValidacionFormularios.php';
require_once '../conf/confDBPDODesarrollo.php';
$entradaOK = true;
define("MAX_TAMANYO", 8);//Tamaño maximo de las entradas alfabetica y password
define("MIN_TAMANYO", 4);//Tamaño minimo de las entradas alfabetica y password
define("OBLIGATORIO", 1);//Obligatoriedad

$aErrores = [
    'usuario' => "",
    'password' => ""
];
$sql1 = <<<SQL
              Select * from T01_Usuarios where T01_CodUsuario=':codUsuario1';
        SQL;
$sql2 = <<<SQL
               update T01_Usuario set T01_NumConexiones=T01_NumConexiones+1,T01_FechaHoraUltimaConexion=now() where T01_CodUsuario=':codUsuario2'; 
            SQL;
$ultimaCon = null;
$conexionesAnteriores = null;
$password=null;
if (isset($_REQUEST['iniciarSesion'])) {
    $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'],8,4, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'],8,4, 2, 1);
    if($aErrores['usuario']==null){
    try {
        $miDB = new PDO(DSN, USER, PASS);
        $resultadoSQL1 = $miDB->prepare($sql1);
        $resultadoSQL1->bindParam(':codUsuario1', $_REQUEST['usuario']);
        $resultadoSQL1->execute();
        $oUsuario = $statement1->fetchObject();
        if ($statement1->rowCount() == 0) {
            $entradaOK = false;
        } else {
            $ultimaCon = $oUsuario->T01_FechaHoraUltimaConexion;
            $conxionesAnteriores = $oUsuario->T01_NumConexiones;
            $password=hash('sha256', ($_REQUEST['usuario'] . $_REQUEST['password']));
            if ($_REQUEST['usuario']!=$oUsuario->T01_Cod_Usuario&&$password!=$oUsuario->T01_Password){
                $entradaOK = false;
                $_REQUEST['usuario']='';
                $_REQUEST['password']='';
            }
        }
    } catch (PDOException $PDOexc) {
        echo $PDOexc->getMessage();
    } finally {
        unset($miDB);
    }
    }
    foreach ($aErrores as $valor) {
        if($valor!=null){
            $entradaOK = false;
        }
    }
} else {
    $entradaOK = false;
}
if ($entradaOK) {
    session_start();
    $_SESSION['usuarioDAW201AppLoginLogoff']=$_REQUEST['usuario'];
    $_SESSION['passwordDAW201AppLoginLogoff']=$password;
    try {
        $miDB = new PDO(DSN, USER, PASS);
        $actualizar=$miDB->prepare($sql2);
        $actualizar->bindParam('codUsuario2',$_REQUEST['usuario']);
        $actualizar->execute();
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