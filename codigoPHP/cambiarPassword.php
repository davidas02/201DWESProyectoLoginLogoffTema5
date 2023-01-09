<?php
session_start();
require_once '../core/221024libreriaValidacionFormularios.php';
require_once '../conf/confDBPDODesarrollo.php';
//comprobamos que el usuario está logeado si no lo redirigimos al login
if(is_null($_SESSION['usuarioDAW201AppLoginLogoff'])){
    header('Location: login.php');
    exit;
}
    if (isset($_REQUEST['volver'])) {
        header('Location: editarPerfil.php');
        exit();
    }
$entradaOk = true;
//Array de errores para guardar los errores del formulario.
$aErrores = [
    'usuario' => null,
    'Apassword' => null,
    'Npassword' => null,
    'RNpassword' => null
];
//Array de respuestas para guardar las respuestas del formulario
$aRespuestas = [
    'usuario' => null,
    'password' => null
    
];
//Busqueda del usuario introducido
$buscaUsuarioPorCodigo = <<< sq2
    select * from T01_Usuario where T01_CodUsuario=:codUsuario;
sq2;
//actualizacion usuario introducido
$modificarUsuario = <<< sq3
    UPDATE T01_Usuario
	SET T01_Password=:password
	WHERE T01_CodUsuario=:usuario;
sq3;
//Comprobamos si ha pulsado el botón de Iniciar Sesion
try {
    if (isset($_REQUEST['aceptar'])) {
        //Crear un objeto PDO pasándole las constantes definidas como parametros.
        $miDB = new PDO(DSN, USER, PASS);
        //Comprobamos que el usuario no haya introducido inyeccion de codigo y los datos están correctos
        $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 8, 4, obligatorio: 1);
        $aErrores['Apassword'] = validacionFormularios::validarPassword($_REQUEST['Apassword'], 8, 4, 1, obligatorio: 1);
        $aErrores['Npassword'] = validacionFormularios::validarPassword($_REQUEST['Npassword'], 8, 4, 1, obligatorio: 1);
        $aErrores['RNpassword'] = validacionFormularios::validarPassword($_REQUEST['RNpassword'], 8, 4, 1, obligatorio: 1);
        foreach ($aErrores as $claveError => $mensajeError) {
            if ($mensajeError != null) {
                $entradaOk = false;
            }
        }
        if($_REQUEST['Npassword']!=$_REQUEST['RNpassword']){
            $entradaOk=false;
        }
        if ($entradaOk) {
            $queryConsultaPorCodigo = $miDB->prepare($buscaUsuarioPorCodigo);
            $queryConsultaPorCodigo->bindParam(':codUsuario', $_REQUEST['usuario']);
            $queryConsultaPorCodigo->execute();
            $oUsuario = $queryConsultaPorCodigo->fetchObject();
            //Comprobación de contraseña correcta
            if ($oUsuario->T01_Password!= hash("sha256",($_REQUEST['usuario'].$_REQUEST['Apassword']))||$_REQUEST['Npassword']!=$_REQUEST['RNpassword']) {
                $entradaOk = false;
            }
        }
//   si se ha pulsado iniciar sesion le pedimos que muestre el formulario de inicio
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
    $aRespuestas['usuario']=$_REQUEST['usuario'];
    $aRespuestas['password']=hash('sha256',($_REQUEST['usuario'].$_REQUEST['Npassword']));
    //Iniciamos la sesión
    
    try {
        $miDB = new PDO(DSN, USER, PASS);
        //actualizamos el usuario
        $queryModificarUsuario = $miDB->prepare($modificarUsuario);
        $queryModificarUsuario->bindParam(":usuario", $aRespuestas['usuario']);
        $queryModificarUsuario->bindParam(":password", $aRespuestas['password']);
        $queryModificarUsuario->execute();
        //Volvemos a buscar el usuario para actualizar el objeto usuario
        $queryConsultaPorCodigo = $miDB->prepare($buscaUsuarioPorCodigo);
        $queryConsultaPorCodigo->bindParam(':codUsuario', $aRespuestas['usuario']);
        $queryConsultaPorCodigo->execute();
        $oUsuario = $queryConsultaPorCodigo->fetchObject();
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    } finally {
        unset($miDB);
    }
    //Establecemos una nueva cookie para el idioma y utlizaremos el metodo time al cual le sumaremos 1800 segundos(media hora)
    if (!isset($_COOKIE['idioma'])) {
        setcookie('idioma', $_REQUEST['idioma'], time() + 1800);
    }
    //Introducimos el usuario en la sesion
    
    $_SESSION['usuarioDAW201AppLoginLogoff'] = $oUsuario;
    $_SESSION['FechaHoraUltimaConexionAnterior'] = $oUsuario->T01_FechaHoraUltimaConexion;
    header('Location: editarPerfil.php');
    exit();
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
                            <td><input style="background-color: grey" type="text" name="usuario" class="usuario" value="<?php echo $_SESSION['usuarioDAW201AppLoginLogoff']->T01_CodUsuario; ?>" readonly="true"/></td>
                        </tr>
                        <tr>
                            <td><label for="Apassword">Password Antigua:</label></td>
                            <td><input type="password" name="Apassword" class="Apassword" /></td>
                        </tr>
                        <tr>
                            <td><label for="Npassword">Password Nuevo:</label></td>
                            <td><input type="password" name="Npassword" class="Npassword" /></td>
                        </tr>
                        <tr>
                            <td><label for="RNpassword">Repite Password Nuevo:</label></td>
                            <td><input type="password" name="RNpassword" class="RNpassword" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" id="aceptar" value="Aceptar" name="aceptar"></td>
                            <td><input type="submit" value="Volver" name="volver" id="volver"></td>
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
<?php
    }
?>

