<?php
/**
 *  @author David Aparicio Sir
 *  @version V1.0
 *  @since 05/12/2022
 */
require_once '../core/221024libreriaValidacionFormularios.php';
require_once '../conf/confDBPDODesarrollo.php';

$entradaOk = true;
//Array de respuestas para guardar las respuestas del formulario.
$aErrores = [
    'usuario' => null,
    'password' => null
];
$buscaUsuarioPorCodigo = <<< sq2
    select * from T01_Usuario where T01_CodUsuario=:codUsuario;
sq2;
$actualizacionConexiones = <<< sq3
    update T01_Usuario set T01_NumConexiones=T01_NumConexiones+1,T01_FechaHoraUltimaConexion=now() where T01_CodUsuario=:codUsuario;
sq3;
$ultimaConexion=null;
//Comprobamos si ha pulsado el botón de Iniciar Sesion
try {
    if (isset($_REQUEST['iniciarSesion'])) {
        //Crear un objeto PDO pasándole las constantes definidas como parametros.
        $miDB = new PDO(DSN, USER, PASS);
        $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 8,4, obligatorio: 1);
        $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8,4,1, obligatorio: 1);
        foreach ($aErrores as $claveError => $mensajeError) {
                if ($mensajeError != null) {
                    $entradaOk = false;
                }
            }
        $queryConsultaPorCodigo = $miDB->prepare($buscaUsuarioPorCodigo);
        $queryConsultaPorCodigo->bindParam(':codUsuario', $_REQUEST['usuario']);
        $queryConsultaPorCodigo->execute();
        $oUsuario = $queryConsultaPorCodigo->fetchObject();
        //Comprobación de contraseña correcta
        if (!$oUsuario || $oUsuario->T01_Password != hash('sha256', ($_REQUEST['usuario'] . $_REQUEST['password']))) {
            $entradaOk = false;
        } else {
           $ultimaConexion=$oUsuario->T01_FechaHoraUltimaConexion;
        }
//   
    } else {
        $entradaOk = false;
    }
} catch (PDOException $excepcion) {
    echo 'Error: ' . $excepcion->getMessage() . "<br>";
    echo 'Código de error: ' . $excepcion->getCode() . "<br>";
} finally {
    unset($miDB);
}
if ($entradaOk) {
    try {
       $miDB=new PDO(DSN,USER,PASS);
       $queryActualizacion=$miDB->prepare($actualizacionConexiones);
       $queryActualizacion->bindParam(":codUsuario",$oUsuario->T01_CodUsuario);
       $queryActualizacion->execute();
       $queryConsultaPorCodigo = $miDB->prepare($buscaUsuarioPorCodigo);
        $queryConsultaPorCodigo->bindParam(':codUsuario', $_REQUEST['usuario']);
        $queryConsultaPorCodigo->execute();
        $oUsuario = $queryConsultaPorCodigo->fetchObject();
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    } finally {
        unset($miDB);  
    }
session_start();
    $_SESSION['usuarioDAW201AppLoginLogoff'] = $oUsuario;
    $_SESSION['UltimaConexionDAW201AppLoginLogoff']=$ultimaConexion;
    header('Location: programa.php');
    die();
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