<?php
require_once '../core/221024libreriaValidacionFormularios.php';
require_once '../conf/confDBPDODesarrollo.php';
    if (isset($_REQUEST['volver'])) {
        header('Location: login.php');
        exit();
    }
$entradaOk = true;
//Array de errores para guardar los errores del formulario.
$aErrores = [
    'usuario' => null,
    'password' => null,
    'nombre'=>null
];
//Array de respuestas para guardar las respuestas del formulario
$aRespuestas = [
    'usuario' => null,
    'password' => null,
    'nombre'=>null
];
//Busqueda del usuario introducido
$buscaUsuarioPorCodigo = <<< sq2
    select * from T01_Usuario where T01_CodUsuario=:codUsuario;
sq2;
//actualizacion usuario introducido
$crearUsuario = <<< sq3
    insert into T01_Usuario values(:usuario,:password,:nombre,now(),1,'usuario',null);
sq3;
//Comprobamos si ha pulsado el botón de Iniciar Sesion
try {
    if (isset($_REQUEST['iniciarSesion'])) {
        //Crear un objeto PDO pasándole las constantes definidas como parametros.
        $miDB = new PDO(DSN, USER, PASS);
        //Comprobamos que el usuario no haya introducido inyeccion de codigo y los datos están correctos
        $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 8, 4, obligatorio: 1);
        $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, obligatorio: 1);
        $aErrores['nombre']= validacionFormularios::comprobarAlfaNumerico($_REQUEST['nombre'], 255, 2, 1);
        foreach ($aErrores as $claveError => $mensajeError) {
            if ($mensajeError != null) {
                $entradaOk = false;
            }
        }
        if ($entradaOk) {
            $queryConsultaPorCodigo = $miDB->prepare($buscaUsuarioPorCodigo);
            $queryConsultaPorCodigo->bindParam(':codUsuario', $_REQUEST['usuario']);
            $queryConsultaPorCodigo->execute();
            $oUsuario = $queryConsultaPorCodigo->fetchObject();
            //Comprobación de contraseña correcta
            if (is_object($oUsuario)) {
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
    $aRespuestas['password']=hash('sha256',($_REQUEST['usuario'] . $_REQUEST['password']));
    $aRespuestas['nombre']=$_REQUEST['nombre'];
    //Iniciamos la sesión
    
    try {
        $miDB = new PDO(DSN, USER, PASS);
        //actualizamos el usuario
        $queryCrearUsuario = $miDB->prepare($crearUsuario);
        $queryCrearUsuario->bindParam(":usuario", $aRespuestas['usuario']);
        $queryCrearUsuario->bindParam(":password", $aRespuestas['password']);
        $queryCrearUsuario->bindParam(":nombre",$aRespuestas['nombre']);
        $queryCrearUsuario->execute();
        //Volvemos a buscar el usuario para actualizar el objeto usuario
        $queryConsultaPorCodigo = $miDB->prepare($buscaUsuarioPorCodigo);
        $queryConsultaPorCodigo->bindParam(':codUsuario', $_REQUEST['usuario']);
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
    session_start();
    $_SESSION['usuarioDAW201AppLoginLogoff'] = $oUsuario;
    $_SESSION['FechaHoraUltimaConexionAnterior'] = $oUsuario->T01_FechaHoraUltimaConexion;
    header('Location: programa.php');
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
                            <td><input type="text" name="usuario" class="usuario"/></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td><input type="password" name="password" class="password" /></td>
                        </tr>
                        <tr>
                            <td><label for="nombre">Nombre:</label></td>
                            <td><input type="text" name="nombre" class="nombre" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <select id="idioma" name="idioma">
                                    <option value="es"><img src="../doc/img/es.png" alt="Español"/>Español</option>
                                    <option value="pt"><img src="../doc/img/pt.png" alt="Portugués"/>Portugués</option>
                                    <option value="gb"><img src="../doc/img/gb.png" alt="Inglés"/>Inglés</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" id="iniciarSesion" value="Iniciar Sesion" name="iniciarSesion"></td>
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