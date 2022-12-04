<?php

/*
 * Fichero de configuracion que contiene la conexion a la base de datos PDO
 * @author David Aparicio Sir
 * Fecha Creacion:  14/11/2021
 * Última modificación: 14/11/2021
 */

//ENTORNO DESARROLLO CASA
// IP del servidor y Nombre de la base de datos
define("DSN", "mysql:dbname=DAW201DBProyectoLoginLogoffTema5;host=192.168.3.208");
// Usuario con el que se conecta 
define("USER", "userDAW201AppLoginLogoff");
// Contraseña con la que conectarse a la base de datos 
define("PASS", "paso");

//ENTORNO DESARROLLO CLASE LOCAL
/*
// IP del servidor y Nombre de la base de datos
define("DSN", "mysql:dbname=DAW201DBProyectoLoginLogoffTema5;host=192.168.20.19");
// Usuario con el que se conecta 
define("USER", "userDAW201AppLoginLogoff");
// Contraseña con la que conectarse a la base de datos 
define("PASS", "paso");
*/
//ENTORNO DESARROLLO 1&1
/*
// IP del servidor y Nombre de la base de datos
define("DSN", "mysql:host=db5010845754.hosting-data.io; dbname=dbs9173955;");
// Usuario con el que se conecta 
define("USER", "dbu2895102");
// Contraseña con la que conectarse a la base de datos 
define("PASS", "daw2_Sauces");
*/
?>