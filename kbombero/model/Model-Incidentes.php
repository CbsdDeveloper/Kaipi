<?php
session_start();
ini_set('display_errors', 0);
include('../../kconfig/Db.class.php');

function guardarIncidente($nombre, $lugar, $municipio, $localidad, $estatus, $fecha_incidente, $fecha_cierre)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    // Obtener el email y el año desde la sesión
    $email_usuario = $_SESSION['email'];
    $anio = date("Y");

    $sql = "INSERT INTO bomberos.incidentes_bom 
            (nombre_inci, lugar_inci, municipio_canton, localidad, estatus, fecha_hora_inci, fecha_cierre_oper, anio, email_usuario)
            VALUES (
            {$bd->sqlvalue_inyeccion($nombre, true)},
            {$bd->sqlvalue_inyeccion($lugar, true)},
            {$bd->sqlvalue_inyeccion($municipio, true)},
            {$bd->sqlvalue_inyeccion($localidad, true)},
            {$bd->sqlvalue_inyeccion($estatus, true)},
            {$bd->sqlvalue_inyeccion($fecha_incidente, true)},
            {$bd->sqlvalue_inyeccion($fecha_cierre, true)},
            {$bd->sqlvalue_inyeccion($anio, true)},
            {$bd->sqlvalue_inyeccion($email_usuario, true)})";

    return $bd->ejecutar($sql);
}
function eliminarIncidente($id_incidentes)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    // Revisa si el ID está siendo pasado correctamente
    if (empty($id_incidentes)) {
        return false;
    }

    $sql = "DELETE FROM bomberos.incidentes_bom WHERE id_incidentes = {$bd->sqlvalue_inyeccion($id_incidentes, true)}";
    $resultado = $bd->ejecutar($sql);

    // Devuelve true si se eliminó con éxito
    return $resultado ? true : false;
}


// Verificar si se recibe una solicitud para eliminar un incidente
// if (isset($_POST['id_incidentes'])) {
//     $id_incidentes = $_POST['id_incidentes'];
//     $eliminado = eliminarIncidente($id_incidentes);

//     if ($eliminado) {
//         echo json_encode(['status' => 'success']);
//     } else {
//         echo json_encode(['status' => 'error']);
//     }
// }

function obtenerIncidentes()
{
    $bd = new Db;
    $bd->conectar('', '', '');

    $sql = "SELECT id_incidentes, nombre_inci, fecha_hora_inci, fecha_cierre_oper, estatus FROM bomberos.incidentes_bom ORDER BY id_incidentes DESC";
    $resultado = $bd->ejecutar($sql);

    // Recoger los datos en un array
    $incidentes = [];
    while ($fila = $bd->obtener_array($resultado)) {
        $incidentes[] = $fila;
    }
    return $incidentes;
}

// // Llama a la función para obtener incidentes
// $incidentes = obtenerIncidentes();
// echo json_encode($incidentes); //los hace archivos json


function obtenerIncidentePorId($id_incidente)
{
    $bd = new Db;
    $bd->conectar('', '', '');

    // Consulta para obtener el incidente específico
    $sql = "SELECT id_incidentes, nombre_inci, lugar_inci, municipio_canton, localidad, estatus, fecha_hora_inci, fecha_cierre_oper 
            FROM bomberos.incidentes_bom 
            WHERE id_incidentes = {$bd->sqlvalue_inyeccion($id_incidente, true)}";

    $resultado = $bd->ejecutar($sql);

    // Devuelve solo una fila (un incidente)
    return $bd->obtener_array($resultado);
}



function actualizarIncidente($id_incidentes, $nombre, $lugar, $municipio, $localidad, $estatus, $fecha_incidente, $fecha_cierre)
{
    
    $bd = new Db;
    $bd->conectar('', '', '');

    $sql = "UPDATE bomberos.incidentes_bom SET 
            nombre_inci = {$bd->sqlvalue_inyeccion($nombre, true)},
            lugar_inci = {$bd->sqlvalue_inyeccion($lugar, true)},
            municipio_canton = {$bd->sqlvalue_inyeccion($municipio, true)},
            localidad = {$bd->sqlvalue_inyeccion($localidad, true)},
            estatus = {$bd->sqlvalue_inyeccion($estatus, true)},
            fecha_hora_inci = {$bd->sqlvalue_inyeccion($fecha_incidente, true)},
            fecha_cierre_oper = {$bd->sqlvalue_inyeccion($fecha_cierre, true)}
            WHERE id_incidentes = {$bd->sqlvalue_inyeccion($id_incidentes, true)}";

    $resultado = $bd->ejecutar($sql);
    // return $bd->ejecutar($sql);
    return $resultado? true : false;
}

// if (isset($_GET['accion']) &&  $_GET['accion']== 'consulta' ) {
//     $incidentes = obtenerIncidentes();
//     echo json_encode($incidentes); 
// }

if (isset($_GET['accion'])) {
    switch ($_GET['accion']) {
        case 'consulta':
            $incidentes = obtenerIncidentes();
            echo json_encode($incidentes);
            break;

        case 'editar':
            if (isset($_POST['id_incidentes'], $_POST['nombre'], $_POST['lugar'], $_POST['municipio'], $_POST['localidad'], $_POST['estatus'], $_POST['fecha_incidente'], $_POST['fecha_cierre'])) {
                $id_incidentes = $_POST['id_incidentes'];
                $nombre = $_POST['nombre'];
                $lugar = $_POST['lugar'];
                $municipio = $_POST['municipio'];
                $localidad = $_POST['localidad'];
                $estatus = $_POST['estatus'];
                $fecha_incidente = $_POST['fecha_incidente'];
                $fecha_cierre = $_POST['fecha_cierre'];

                $actualizado = actualizarIncidente($id_incidentes, $nombre, $lugar, $municipio, $localidad, $estatus, $fecha_incidente, $fecha_cierre);

                if ($actualizado) {
                    echo json_encode(['status' => 'success', 'message' => 'Incidente actualizado correctamente']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el incidente']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Faltan datos para actualizar el incidente']);
            }
            break;

        case 'eliminar':
            if (isset($_POST['id_incidentes'])) {
                $id_incidentes = $_POST['id_incidentes'];
                $eliminado = eliminarIncidente($id_incidentes);

                if ($eliminado) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error']);
                }
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
}
