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

        $creacion = $miDB->prepare(<<<SQL
            create table if not exists T01_Usuario(
                T01_CodUsuario varchar(8) primary key,
                T01_Password varchar(255)NOT NULL,
                T01_DescUsuario varchar(255),
                T01_FechaHoraUltimaConexion datetime,
                T01_NumConexiones int default 1,
                T01_Perfil enum('usuario','administrador') default 'usuario',
                T01_ImagenUsuario MEDIUMBLOB NULL
                )engine=innoDB;
            create table if not exists T02_Departamento(
                T02_codDepartamento varchar(3) primary key,
                T02_descDepartamento varchar(255) NULL,
                T02_fechaBaja int NULL,
                T02_volumenNegocio float NULL,
                T02_fechaAlta datetime NULL 
                )engine=Innodb;
    SQL);
        $creacion->execute(); //Ejecuto la consulta
        if ($creacion) {
            echo "<h3>Creacion ejecutada con exito</<h3>";
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
