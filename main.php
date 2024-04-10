<?php

function parametroPermitidos($parametros, $parametrosPermitidos)
{
    $parametrosNoPermitidos = array();

    // Iterar sobre los parámetros recibidos
    foreach ($parametros as $parametro => $valor) {
        // Verificar si el parámetro no está en la lista de permitidos
        if (!in_array($parametro, $parametrosPermitidos)) {
            $parametrosNoPermitidos[$parametro] = "Este parámetro no está permitido";
        }
    }

    return $parametrosNoPermitidos;
}

function parametroPermitidosParaElOrder($orden, $parametrosPermitidos)
{

    $parametrosNoPermitidos = array();

    if ($orden == null) {
        return $parametrosNoPermitidos;
    }

    if (!in_array($orden, $parametrosPermitidos)) {
        $parametrosNoPermitidos[$orden] = "Este valor no esta permitido para el parametro orden";
    }

    return $parametrosNoPermitidos;
}

function parametroPermitidosX($parametroValue, $parametrosPermitidos, $parametro)
{

    $parametrosNoPermitidos = array();

    if ($parametroValue == null) {
        return $parametrosNoPermitidos;
    }

    if (!in_array($parametroValue, $parametrosPermitidos)) {
        $parametrosNoPermitidos[$parametroValue] = "Este valor no esta permitido para el parametro " . $parametro;
    }

    return $parametrosNoPermitidos;
}

function parametroPermitidosContains($parametroValueDeContains, $parametrosPermitidosContains, $parametros, $parametroContains)
{
    $parametrosNoPermitidos = array();

    if ($parametroValueDeContains == null) {
        return $parametrosNoPermitidos;
    }

    // Verificar si $parametroValueDeContains está presente como clave en $parametros
    if (!array_key_exists($parametroValueDeContains, $parametros)) {
        $parametrosNoPermitidos['Contains no permitido'] = "Para usar el parámetro 'contains', debes especificar en la URL el nombre del parámetro cuyo contenido deseas evaluar y su respectivo valor";
    }

    // Verificar si el valor de $parametroValueDeContains está permitido en $parametrosPermitidosContains
    if (!in_array($parametroValueDeContains, $parametrosPermitidosContains)) {
        $parametrosNoPermitidos[$parametroValueDeContains] = "Este valor no está permitido para el parámetro $parametroContains";
    }

    return $parametrosNoPermitidos;
}

