<?php

// include('configBD.php');

// define('db_charset','utf8');

// // Crear conexión con la base de datos
// $con = mysqli_connect(db_host, db_user, db_pass, db_name);
// if (mysqli_connect_errno()) {
//     exit('Failed to connect to MySQL: ' . mysqli_connect_error());
// }
// // Actualizar el conjunto de caracteres
// mysqli_set_charset($con, db_charset);

include('configBD.php');

define('db_charset', 'utf8');

try {
    // Crear una instancia de la clase PDO para conectarse a la base de datos
    $dsn = "mysql:host=" . db_host . ";dbname=" . db_name . ";charset=" . db_charset;
    $con = new PDO($dsn, db_user, db_pass);

    // Configurar PDO para que lance excepciones en caso de errores
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error al conectarse a la base de datos, mostrar el mensaje de error
    exit("Failed to connect to database: " . $e->getMessage());
}


?>