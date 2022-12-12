<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tema  ejercicio  David Aparicio</title>
        <link rel="stylesheet" href="../webroot/css/estilos.css"/>
        <link rel="icon" type="image/x-icon" href="../doc/img/favicon.ico"/>
    </head>
</head>
<body>
    <header>
        <h1>Tema </h1>
        <div id="nav">
            <h2>Enunciado</h2>
        </div>
    </header>
    <div id="ejercicios">
    <?php
    include_once '../conf/confDBPDOExplotacion.php';
    try {
        //Establecimiento de la conexión 
        $miDB = new PDO(DSN, USER, PASS);

        $insercion = $miDB->prepare(<<<SQL
                    insert into T02_Departamento values
                    ("INF","Departamento de Informatica",null,3500,FROM_UNIXTIME('1668167592')),
                    ("VEN","Departamento de Ventas",null,25000,FROM_UNIXTIME('1668167592')),
                    ("MAR","Departamento de Marketing",null,13657,FROM_UNIXTIME('1668167592')),
                    ("IDE","Departamento de Innovacion y Desarrollo",null,-2350,FROM_UNIXTIME('1668167592')),
                    ("CON","Departamento de Contabilidad",null,44962,FROM_UNIXTIME('1668167592'));
                SQL);
        $insercion->execute();
        if ($insercion) {
            $resultadoDepartamentos = $miDB->prepare("Select * from T02_Departamento");
            $resultadoDepartamentos->execute();
            $oDepartamento = $resultadoDepartamentos->fetchObject();
            if (is_object($oDepartamento)) {
                print '<table>';
                print '<tr><th>codDepartamento</th><th>descDepartamento</th><th>fechaBaja</th><th>volumenNegocio</th><th>fechaAlta</th></tr>';
                while ($oDepartamento != null) {
                    print"<tr>";
                    echo "<td>$oDepartamento->T02_codDepartamento</td>";
                    echo "<td>$oDepartamento->T02_descDepartamento</td>";
                    echo "<td>$oDepartamento->T02_fechaBaja</td>";
                    echo "<td>$oDepartamento->T02_volumenNegocio</td>";
                    echo "<td>$oDepartamento->T02_fechaAlta</td>";
                    $oDepartamento = $resultadoDepartamentos->fetchObject();
                }
                print '</table>';
            } 
        }
        $insercion2 = $miDB->prepare(<<<SQL
                insert into T01_Usuario(T01_CodUsuario,T01_Password,T01_DescUsuario,T01_FechaHoraUltimaConexion,T01_NumConexiones,T01_Perfil) values
                ('admin',sha2(concat('admin','paso'),256),'Administrador',null,0,'administrador'),
                ('heraclio',sha2(concat('heraclio','paso'),256),'Heraclio Profesor',null,0,'usuario'),
                ('amor',sha2(concat('amor','paso'),256),'Amor Profesora',null,0,'usuario'),
                ('antonio',sha2(concat('antonio','paso'),256),'Antonio Profesor',null,0,'usuario'),
                ('alberto',sha2(concat('alberto','paso'),256),'Alberto Profesor',null,0,'usuario'),
                ('ricardo',sha2(concat('ricardo','paso'),256),'Ricardo Santiago',null,0,'usuario'),
                ('otalvaro',sha2(concat('otalvaro','paso'),256),'Alejandro Otalvaro',null,0,'usuario'),
                ('josue',sha2(concat('josue','paso'),256),'Josué Martínez',null,0,'usuario'),
                ('luis',sha2(concat('luis','paso'),256),'Luis Perez',null,0,'usuario'),
                ('manuel',sha2(concat('manuel','paso'),256),'Manuel Martín',null,0,'usuario'),
                ('david',sha2(concat('david','paso'),256),'David Aparicio',null,0,'usuario'); 
                SQL);

        $insercion2->execute();
        if ($insercion2) {
            echo"<h3>Insercion ejecutada con exito</h3>";
            $resultadoUsuarios = $miDB->prepare("select * from T01_Usuario");
            $resultadoUsuarios->execute();
            print '<table>';
            print '<tr><th>codUsuario</th><th>Password</th><th>DescUsuario</th><th>FechaHoraUltimaConexion</th><th>T01_NumConexiones</th><th>Perfil</th></tr>';
            $oUsuario = $resultadoUsuarios->fetchObject();
            while ($oUsuario != null) {
                print"<tr>";
                echo "<td>$oUsuario->T01_CodUsuario</td>";
                echo "<td>$oUsuario->T01_Password</td>";
                echo "<td>$oUsuario->T01_DescUsuario</td>";
                echo "<td>$oUsuario->T01_FechaHoraUltimaConexion</td>";
                echo "<td>$oUsuario->T01_NumConexiones</td>";
                echo "<td>$oUsuario->T01_Perfil</td>";
                print"</tr>";
                $oUsuario = $resultadoUsuarios->fetchObject();
            }
            print '</table>';
        }
    } catch (PDOException $excepcion) {//Código que se ejecutará si se produce alguna excepción
        //Almacenamos el código del error de la excepción en la variable $errorExcepcion
        $errorExcep = $excepcion->getCode();
        //Almacenamos el mensaje de la excepción en la variable $mensajeExcep
        $mensajeExcep = $excepcion->getMessage();

        echo "<span style='color: red;'>Error: </span>" . $mensajeExcep . "<br>"; //Mostramos el mensaje de la excepción
        echo "<span style='color: red;'>Código del error: </span>" . $errorExcep; //Mostramos el código de la excepción
    } finally {
        // Cierre de la conexión.
        unset($mydb);
    }
    ?>
    </div>
    <footer> 
        <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
        <a href="../indexProyectoTema4.php"><img src="../doc/img/home.png" alt="HOME"/></a>
        <a href="https://www.github.com/davidas02" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
        <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
    </footer>
</body>
</html>
