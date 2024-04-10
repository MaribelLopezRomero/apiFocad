<?php

/**
 * @brief Obtiene colegiados filtrados por un parámetro.
 *
 * Esta función busca colegiados en la base de datos basados en el parámetro proporcionado.
 *
 * @param PDO $con Una instancia de la clase PDO para la conexión a la base de datos.
 * @return array Un array de colegiados que cumplen con los criterios de búsqueda.
 */

function getColegiados($con, $order, $sort)
{



    $sqlQuery = "SELECT * FROM colegiados";

    if ($order!=null) {
        $sqlQuery .= " ORDER BY $order";
    }
    if ($sort!=null) {
        $sqlQuery .= " $sort";
    }

    $stmt = $con->prepare($sqlQuery);

    $stmt->execute();

    $colegiados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    return $colegiados;
}

//PAGINACION

// function getColegiados($con, $order, $sort, $offset, $limit = 50000)
// {
//     // Construye la consulta SQL con paginación
//     $sqlQuery = "SELECT * FROM colegiados";

//     if ($order != null) {
//         $sqlQuery .= " ORDER BY $order";
//     }

//     if ($sort != null) {
//         $sqlQuery .= " $sort";
//     }

//     // Agrega la cláusula LIMIT y OFFSET para la paginación
//     $sqlQuery .= " LIMIT $limit OFFSET $offset";

//     $stmt = $con->prepare($sqlQuery);

//     $stmt->execute();

//     $colegiados = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     $stmt->closeCursor();

//     return $colegiados;
// }


/**
 * @brief Obtiene colegiadosss filtrados por un parámetro.
 *
 * Esta función busca colegiadosss en la base de datos basados en el parámetro proporcionado.
 *
 * @param string $param El nombre del parámetro.
 * @param mixed $value El valor del parámetro.
 * @param PDO $con Una instancia de la clase PDO para la conexión a la base de datos.
 * @return array Un array de colegiadosss que cumplen con los criterios de búsqueda.
 */

function getColegiadosbyParam($param, $value, $con)
{

    $sqlQuery = "SELECT * FROM colegiados WHERE " . $param . " = ?";

    $stmt = $con->prepare($sqlQuery);
    $stmt->execute([$value]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt->closeCursor();
    return $result;
}

/**
 * @brief Obtiene colegiados filtrados por parámetros.
 *
 * Esta función busca colegiados en la base de datos basados en los parámetros proporcionados.
 *
 * @param array $parametros Un array asociativo de parámetros de búsqueda.
 * @param PDO $con Una instancia de la clase PDO para la conexión a la base de datos.
 * @return array Un array de colegiados que cumplen con los criterios de búsqueda.
 */

function getColegiadosbyParams($parametros, $con)
{


     // Verificar si tiene el parámetro order, sort o contains
     $order = isset($parametros['order']) ? $parametros['order'] : null;
     $sort = isset($parametros['sort']) ? $parametros['sort'] : null;
     $contains = isset($parametros['contains']) ? $parametros['contains'] : null;
     unset($parametros['order']);
     unset($parametros['sort']);
     unset($parametros['contains']); 

     $conditions = [];
     $paramValues = [];
 
     foreach ($parametros as $param => $value) {
         // Verificar si el parámetro coincide con el valor de 'contains'
         if ($param === $contains) {
             // Usar LIKE '%?%' en lugar de '= ?'
             $conditions[] = "$param LIKE ?";
             $paramValues[] = "%$value%"; // Agregar los signos de porcentaje para LIKE
         } else {
             // Usar '= ?' para los otros parámetros
             $conditions[] = "$param = ?";
             $paramValues[] = $value;
         }
     }

    // Unir las condiciones con AND para formar la cláusula WHERE
    $whereClause = implode(" AND ", $conditions);

    $sqlQuery = "SELECT * FROM colegiados WHERE $whereClause";

         // Añadir ORDER BY 
         if ($order) {
            $sqlQuery .= " ORDER BY $order";
         }
         if ($sort) {
            $sqlQuery .= " $sort";
         }


    $stmt = $con->prepare($sqlQuery);
    $stmt->execute($paramValues);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt->closeCursor();
    return $result;
}




