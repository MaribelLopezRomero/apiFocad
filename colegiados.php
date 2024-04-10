<?php

// Permitir el acceso desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('./config.php');
include('./main.php');

// Parámetros permitidos
$parametrosPermitidos = array(
    'IDColegiado',
    'numColegiado',
    'nombre',
    'apellidos',
    'email',
    'dni',
    'contains',
    'order',
    'sort',
);

// Parámetros permitidos orden
$parametrosPermitidosOrder = array(
    'IDColegiado',
    'numColegiado',
    'nombre',
    'apellidos',
    'email',
    'dni',
);

// Parámetros permitidos sort
$parametrosPermitidosSort = array(
    'asc',
    'desc'
);
// Parámetros permitidos contains
$parametrosPermitidosContains = array(
    'IDColegiado',
    'numColegiado',
    'nombre',
    'apellidos',
    'email',
    'dni'
);


//MANEJAR SOLICTUDES GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $num_params = count($_GET);

    //si no hay parametros o solo hay order y sort
    if ($num_params === 0 || (($num_params == 1 && isset($_GET['order'])) || ($num_params == 2 && (isset($_GET['order']) && isset($_GET['sort']))))) {

        require_once('get/colegiados.php');
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        $order = isset($_GET['order']) ? $_GET['order'] : null;


        $parametros_no_permitidos_order = parametroPermitidosX($order, $parametrosPermitidosOrder, 'order');
        $parametros_no_permitidos_sort = parametroPermitidosX($sort, $parametrosPermitidosSort, 'sort');

        // Fusionar los arrays de parámetros no permitidos
        $parametrosTotalesNoPermitidos = array_merge(
            $parametros_no_permitidos_order,
            $parametros_no_permitidos_sort
        );

        if (!empty($parametrosTotalesNoPermitidos)) {

            //retronamos una badrespuesta
            header("HTTP/1.1 400 Bad Request");
            echo json_encode($parametrosTotalesNoPermitidos);
        } else {
            //Buscamos en la bbdd y retornamos un json

            //paginacion

            // $limit = 100; // Este valor puede ajustarse según tus necesidades
            // $offset = 0;

            // do {
            //     $colegiados = getColegiados($con, $order, $sort, $offset, $limit);

            //     foreach ($colegiados as $colegiado) {
            //         $usuarios[] = $colegiado;
            //     }

            //     // Procesar los colegiados obtenidos

            //     $numRows = count($colegiados);
            //     $offset += $limit;
            // } while ($numRows == $limit);

          
            // echo json_encode(($usuarios));

            $colegiados = getColegiados($con, $order, $sort);
            echo json_encode(($colegiados));
           
        }
    } elseif ($num_params >= 1) {

        require_once('get/colegiados.php');
        //MANERA GENERICA: obtener los parámetros y procesamos la respuesta.  Tmabien acepta orden y sort y contains
        $parametros = $_GET;

        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        $order = isset($_GET['order']) ? $_GET['order'] : null;
        $contains = isset($_GET['contains']) ? $_GET['contains'] : null;


        $parametros_no_permitidos = parametroPermitidos($parametros, $parametrosPermitidos);
        $parametros_no_permitidos_order = parametroPermitidosX($order, $parametrosPermitidosOrder, 'order');
        $parametros_no_permitidos_sort = parametroPermitidosX($sort, $parametrosPermitidosSort, 'sort');
        $parametros_no_permitidos_contains = parametroPermitidosContains($contains, $parametrosPermitidosContains, $parametros, 'contains');

        // Fusionar los arrays de parámetros no permitidos
        $parametrosTotalesNoPermitidos = array_merge(
            $parametros_no_permitidos,
            $parametros_no_permitidos_order,
            $parametros_no_permitidos_sort,
            $parametros_no_permitidos_contains
        );

        if (!empty($parametrosTotalesNoPermitidos)) {
            // Retornamos una badrespuesta
            header("HTTP/1.1 400 Bad Request");
            echo json_encode($parametrosTotalesNoPermitidos);
        } else {
            //Buscamos en la bbdd y retornamos un json

            $usuarios = getColegiadosbyParams($parametros, $con);
            echo json_encode(($usuarios));
        }
    } else {
        // Si hay más de dos parámetros, devolver un mensaje de error
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["error" => "La solicitud contiene demasiados parámetros"]);
        exit();
    }
}






// Manejar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados en la solicitud POST
    $datos = json_decode(file_get_contents('php://input'), true);

    // Validar y procesar los datos (en este ejemplo, simplemente los agregamos a la lista)
    $nuevoUsuario = [
        'id' => count($usuarios) + 1,
        'nombre' => $datos['nombre'],
        'edad' => $datos['edad']
    ];
    $usuarios[] = $nuevoUsuario;

    // Devolver el nuevo usuario creado en formato JSON
    echo json_encode($nuevoUsuario);
}
