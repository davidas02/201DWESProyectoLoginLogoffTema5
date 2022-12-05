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
        $insercion->execute(); //Ejecuto la consulta
        
        if ($insercion) {
            echo "<h3>Insercion ejecutada con exito</<h3>";
            $resultadoDepartamentos = $miDB->prepare("select * from T02_Departamento");
           print '<table>';
            print '<tr><th>codDepartamento</th><th>descDepartamento</th><th>fechaBaja</th><th>volumenNegocio</th><th>fechaAlta</th></tr>';
            $resultadoDepartamentos->execute();
            $oDepartamento=$resultadoDepartamentos->fetchObject();
            while ($oDepartamento!=null) {
                print"<tr>";
                echo "<td>$oDepartamento->T02_codDepartamento</td>";
                echo "<td>$oDepartamento->T02_descDepartamento</td>";
                echo "<td>$oDepartamento->T02_fechaBaja</td>";
                echo "<td>$oDepartamento->T02_volumenNegocio</td>";
                echo "<td>$oDepartamento->T02_fechaAlta</td>";
                print"</tr>";
                $oDepartamento=$resultadoDepartamentos->fetch_object();
            }
            print '</table>';
        }
        $insercion2=$miDB->prepare(<<<SQL
        insert into T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_FechaHoraUltimaConexion,T01_NumConexiones,T01_Perfil) values
        ("admin",sha2(concat("admin","paso"),256),"Administrador",now(),1,"administrador"),
        ("amor",sha2(concat("amor","paso"),256),"Amor",now(),1,"usuario"),
        ("alberto",sha2(concat("alberto","paso"),256),"Alberto",now(),1,"usuario"),
        ("antonio",sha2(concat("antonio","paso"),256),"Antonio",now(),1,"usuario"),
        ("heraclio",sha2(concat("heraclio","paso"),256),"Heraclio",now(),1,"usuario"),
        ("david",sha2(concat("david","paso"),256),"David",now(),1,"usuario"),
        ("manuel",sha2(concat("manuel","paso"),256),"Manuel",now(),1,"usuario"),
        ("ricardo",sha2(concat("ricardo","paso"),256),"Ricardo",now(),1,"usuario"),
        ("luis",sha2(concat("luis","paso"),256),"Luis",now(),1,"usuario"),
        ("otalvaro",sha2(concat("otalvaro","paso"),256),"Alejandro",now(),1,"usuario"),
        ("josue",sha2(concat("josue","paso"),256),"Josué",now(),1,"usuario");
        SQL);
        $insercion2->execute();
        if($insercion2){
            echo"<h3>Insercion 2 ejecutada con exito</h3>";
            $resultadoUsuarios = $miDB->prepare("select * from T02_Departamento");
           print '<table>';
            print '<tr><th>codDepartamento</th><th>descDepartamento</th><th>fechaBaja</th><th>volumenNegocio</th><th>fechaAlta</th></tr>';
            $resultadoUsuarios->execute();
            $oUsuario=$resultadoUsuarios->fetchObject();
            while ($oUsuario!=null) {
                print"<tr>";
                echo "<td>$oUsuario->T01_CodUsuario</td>";
                echo "<td>$oDepartamento->T01_Password</td>";
                echo "<td>$oDepartamento->T01_DescUsuario</td>";
                echo "<td>$oDepartamento->T01_FechaHoraUltimaConexion</td>";
                echo "<td>$oDepartamento->T01_NumConexiones</td>";
                echo "<td>$oDepartamento->T01_Perfil</td>";
                print"</tr>";
                $oDepartamento=$resultadoDepartamentos->fetch_object();
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
    <footer> 
        <a href="../../doc/CVDavidAparicioSir.pdf" target="blank"><img src="../doc/img/cv.png" alt="CV David Aparicio"/></a>
        <a href="../indexProyectoTema4.php"><img src="../doc/img/home.png" alt="HOME"/></a>
        <a href="https://www.github.com/davidas02" target="_blank"><img src="../doc/img/git.png" alt="github David Aparicio"/></a>
        <p>2022-2023 David Aparicio Sir &COPY; Todos los derechos reservados</p>
    </footer>
</body>
</html>
