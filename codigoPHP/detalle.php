<?php
/**
 *  @author David Aparicio Sir
 *  @version V1.0
 *  @since 05/12/2022
 */
//Inicioamos la sesón
session_start();
//comprobamos que el usuario está logeado si no lo redirigimos al login
if(is_null($_SESSION['usuarioDAW201AppLoginLogoff'])){
    header('Location: login.php');
    exit;
}
//Comprobamos que se ha pulsado a volver si es correcto redirigimos la pagina al programa
if (isset($_REQUEST['volver'])) {
    header("Location: programa.php");
    exit();
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
            form table, form th, form td{
                border: none;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Tema 5 Proyecto LoginLogoff</h1>
            <div id="nav">
                <h2>Detalle</h2>
            </div>

        </header>
        <div id="ejercicios">
            <form name="ejercicio21" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="formulario">
                    <tr>
                        <td colspan="2"><input type="submit" id="volver" value="Volver" name="volver"></td>
                    </tr>
                </table>
            </form>

            <?php
            
            //Muestra del contenido de la variable $_SESSION con foreach()
            echo '<h2>Mostrar $_SESSION con foreach()</h2>';
            
                echo "<table><tr><th class='cajaizquierda'>Clave</th><th class='cajaderecha'>Valor</th></tr>";
                foreach ($_SESSION as $clave => $valor) {
                    echo "<tr>";
                    echo "<td><strong>$clave</strong></td>";
                    if (is_object($valor)) {
                        echo '<td><table><th>Clave</th><th>valor</th>';
                        foreach ($valor as $c => $v) {
                            echo "<tr><th>$c</th>";
                            echo "<td>$v</td></tr>";
                        }
                        echo"</table></td>";
                    } else {
                        echo "<td>" . $valor . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            
            echo "</br>";

            //Muestra del contenido de la variable $_COOKIE con foreach()
            echo '<h2>Mostrar $_COOKIE con foreach()</h2>';
            echo '<table><tr><th>Clave</th><th>Valor</th></tr>';
            foreach ($_COOKIE as $key => $value) {
                echo "<tr><td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td></tr>";
            }
            echo '</table>';
            echo "</br>";

            //Muestra del contenido de la variable $_SERVER con foreach()
            echo '<h2>Mostrar $_SERVER con foreach()</h2>';
            echo "<table><tr><th class='cajaizquierda'>Clave</th><th class='cajaderecha'>Valor</th></tr>";
            foreach ($_SERVER as $key => $value) {
                echo "<tr>";
                echo "<td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</br>";

            //Muestra del contenido de la variable $_REQUEST con foreach()
            echo '<h2>Mostrar $_REQUEST con foreach()</h2>';
            echo '<table><tr><th>Clave</th><th>Valor</th></th>';
            foreach ($_REQUEST as $key => $value) {
                echo "<td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td>";
            }
            echo '</table>';

            //Muestra del contenido de la variable $_GET con foreach()
            echo '<h2>Mostrar $_GET con foreach()</h2>';
            echo '<table><tr><th>Clave</th><th>Valor</th></th>';
            foreach ($_GET as $key => $value) {
                echo "<td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td>";
            }
            echo '</table>';
            echo "</br>";

            //Muestra del contenido de la variable $_FILES con foreach()
            echo '<h2>Mostrar $_FILES con foreach()</h2>';
            echo '<table><tr><th>Clave</th><th>Valor</th></th>';
            foreach ($_FILES as $key => $value) {
                echo "<td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td>";
            }
            echo '</table>';
            echo "</br>";

            //Muestra del contenido de la variable $_ENV con foreach()
            echo '<h2>Mostrar $_ENV con foreach()</h2>';
            echo '<table><tr><th>Clave</th><th>Valor</th></th>';
            foreach ($_ENV as $key => $value) {
                echo "<td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td>";
            }
            echo '</table>';
            echo "</br>";

            //Muestra del contenido de la variable $_POST con foreach()
            echo '<h2>Mostrar $_POST con foreach()</h2>';
            echo '<table><tr><th>Clave</th><th>Valor</th></th>';
            foreach ($_POST as $key => $value) {
                echo "<td><strong>" . $key . "</strong></td>";
                echo "<td>" . $value . "</td>";
            }
            echo '</table>';
            echo "</br>";

            //Muestra del contenido de la variable $GLOBALS con foreach(), uso de dos foreach para mostrar el contenido de algunos arrays dentro del array de la variable
            echo '<h2>Mostrar $GLOBALS con foreach()</h2>';
            echo "<table><tr><th class='cajaizquierda'>Clave</th><th class='cajaderecha'>Valor</th></tr>";
            foreach ($GLOBALS as $clave => $valor) {
                echo "<tr>";
                echo "<td><strong>$clave</strong></td>";
                if (is_array($valor)) {
                    echo '<td><table><th>Clave</th><th>valor</th>';
                    foreach ($valor as $c => $v) {
                        echo "<tr><th>$c</th>";
                        echo "<td>$v</td></tr>";
                    }
                    echo"</table></td>";
                } else {
                    echo "<td>" . $valor . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "</br>";
            ?>
        </div>
        <footer> 
            <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
            <a href="../indexProyectoTema5.php"><img src="../doc/img/home.png" alt="HOME" hidden="true"/></a>
            <a href="https://www.github.com/davidas02/201DWESProyectoLoginLogoffTema5" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
            <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
        </footer>
    </body>
</html>
