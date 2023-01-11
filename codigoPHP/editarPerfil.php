<?php
session_start();
require_once '../core/221024libreriaValidacionFormularios.php';
require_once '../conf/confDBPDODesarrollo.php';
    if (isset($_REQUEST['volver'])) {
        header('Location: programa.php');
        exit();
    }
//comprobamos que el usuario está logeado si no lo redirigimos al login
if(is_null($_SESSION['usuarioDAW201AppLoginLogoff'])){
    header('Location: login.php');
    exit;
}
    if(isset($_REQUEST['cambiarPassword'])){
        header('Location: cambiarPassword.php');
        exit();
    }
    if(isset($_REQUEST['borrarUsuario'])){
        try {
            $miDB = new PDO(DSN, USER, PASS);
            $borrarUsuario=<<< sql1
                    DELETE FROM T01_Usuario WHERE T01_CodUsuario=:usuario;
                    sql1;
            $queryBorrarUsuario=$miDB->prepare($borrarUsuario);
            $queryBorrarUsuario->bindParam(":usuario",$_SESSION['usuarioDAW201AppLoginLogoff']->T01_CodUsuario);
            $queryBorrarUsuario->execute();
            
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        } finally {
            unset($miDB);
        }
        session_destroy();
        header('Location: login.php');
        exit();
    }
$entradaOk = true;
//Array de errores para guardar los errores del formulario.
$aErrores = [
    'usuario' => null,
    'nombre'=>null
];
//Array de respuestas para guardar las respuestas del formulario
$aRespuestas = [
    'usuario' => null,
    'nombre'=>null
];
//Busqueda del usuario introducido
$buscaUsuarioPorCodigo = <<< sq2
    select * from T01_Usuario where T01_CodUsuario=:codUsuario;
sq2;
//actualizacion usuario introducido
$modificarUsuario = <<< sq3
    UPDATE T01_Usuario
	SET T01_Password=:password,T01_DescUsuario=:nombre
	WHERE T01_CodUsuario=:usuario;
sq3;
//Comprobamos si ha pulsado el botón de Iniciar Sesion
try {
    if (isset($_REQUEST['aceptar'])) {
        //Crear un objeto PDO pasándole las constantes definidas como parametros.
        $miDB = new PDO(DSN, USER, PASS);
        //Comprobamos que el usuario no haya introducido inyeccion de codigo y los datos están correctos
        $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 8, 4, obligatorio: 1);
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
            if (!$oUsuario) {
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
        $queryModificarUsuario = $miDB->prepare($modificarUsuario);
        $queryModificarUsuario->bindParam(":usuario", $aRespuestas['usuario']);
        $queryModificarUsuario->bindParam(":password", $aRespuestas['password']);
        $queryModificarUsuario->bindParam(":nombre",$aRespuestas['nombre']);
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
                    <h2>Modificar usuario</h2>
                </div>
            </header>
            <div id="ejercicios">
                <form name="ejercicio21" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <table class="formulario">
                        <tr>
                            <td><label for="usuario">Usuario:</label></td>
                            <td><input style="background-color: grey" type="text" name="usuario" class="usuario" value="<?php echo $_SESSION['usuarioDAW201AppLoginLogoff']->T01_CodUsuario; ?>" readonly="true" /></td>
                        </tr>
                        <tr>
                            <td><label for="nombre">Nombre:</label></td>
                            <td><input type="text" name="nombre" class="nombre" value="<?php echo $_SESSION['usuarioDAW201AppLoginLogoff']->T01_DescUsuario; ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" id="aceptar" value="Aceptar" name="aceptar"></td>
                        <tr>
                            <td><input type="submit" value="Volver" name="volver" id="volver"></td>
                            <td><input type="submit" value="Cambiar Contraseña" name="cambiarPassword" id="cambiarPassword"></td>
                            <td><input type="submit" value="Borrar Usuario" name="borrarUsuario" id="borrarUsuario"></td>
                        </tr>
                        </tr>
                        
                    </table>
                    <p>
                        <?php
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
