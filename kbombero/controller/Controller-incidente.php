<?php
session_start();
ini_set('display_errors', 0);  
error_reporting(0);  

require_once '../model/Model-Incidentes.php';

class ControllerIncidente
{

    function eliminar()
    {
        ob_clean();

        $id_incidentes = $_POST['id_incidentes'];
        $eliminado = eliminarIncidente($id_incidentes);

        // respuesta en formato JSON para manejarla con AJAX
        header('Content-Type: application/json');
        if ($eliminado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        return;
    }

    function obtenerPorId()
    {
        $id_incidentes = $_POST['id_incidentes'];
        $incidente = obtenerIncidentePorId($id_incidentes);

        header('Content-Type: application/json');
        echo json_encode($incidente);
        return;
    }

    function editar()
    {
        ob_clean();

        $id_incidentes = $_POST['id_incidentes'];
        $nombre = $_POST['nombre'];
        $lugar = $_POST['lugar'];
        $municipio = $_POST['municipio'];
        $localidad = $_POST['localidad'];
        $estatus = $_POST['estatus'];
        $fecha_incidente = $_POST['fecha_incidente'];
        $fecha_cierre = $_POST['fecha_cierre'];

        // Validar si los campos requeridos están vacíos
        if (empty($nombre) || empty($lugar) || empty($municipio) || empty($estatus) || empty($fecha_incidente)) {
            echo json_encode(['status' => 'error', 'message' => 'Campos requeridos vacíos']);
            exit;
        }

        // Formato de fecha
        $fecha_incidente = date('Y-m-d H:i:s', strtotime($fecha_incidente));
        $fecha_cierre = date('Y-m-d H:i:s', strtotime($fecha_cierre));

        // Llamar a la función para actualizar
        $actualizado = actualizarIncidente($id_incidentes, $nombre, $lugar, $municipio, $localidad, $estatus, $fecha_incidente, $fecha_cierre);

        // Respuesta en formato JSON para manejarla con AJAX
        header('Content-Type: application/json');
        if ($actualizado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el incidente']);
        }
        exit;
    }

    function guardar()
    {
        // se obtiene los datos del formulario
        $nombre = $_POST['nombre'];
        $lugar = $_POST['lugar'];
        $municipio = $_POST['municipio'];
        $localidad = $_POST['localidad'];
        $estatus = $_POST['estatus'];
        $fecha_incidente = $_POST['fecha_incidente'];
        $fecha_cierre = $_POST['fecha_cierre'];

        // Validar si los campos requeridos están vacíos
        if (empty($nombre) || empty($lugar) || empty($municipio) || empty($estatus) || empty($fecha_incidente)) {
            echo "
        <script>
            alert('Error: Todos los campos obligatorios deben ser completados.');
            window.history.back();
        </script>
    ";
            exit;
        }

        // Conversión de fechas al formato adecuado
        $fecha_incidente = date('Y-m-d H:i:s', strtotime($fecha_incidente));
        $fecha_cierre = date('Y-m-d H:i:s', strtotime($fecha_cierre));

        guardarIncidente($nombre, $lugar, $municipio, $localidad, $estatus, $fecha_incidente, $fecha_cierre);

        // Mostrar alerta y redirigir
        echo "
    <script>
        alert('Incidente guardado con éxito');
        window.location.href = '../view/inicio.php'; // Redirige a la página de inicio
    </script>
    ";
    }
}

$gestion = new ControllerIncidente;

// if (isset($_POST)) {
//     if (!$_POST['accion']) {
//         $gestion->guardar();
//         return;
//     }
//     if ($_POST['accion'] == 'obtenerIncidente') {
//         $gestion->obtenerPorId();
//         return;
//     }
// }

if (isset($_POST)) {
    if (!isset($_POST['accion'])) {
        $gestion->guardar();
        return;
    }

    switch ($_POST['accion']) {
        case 'guardar':
            $gestion->guardar();
            return;

        case 'obtenerIncidente':
            $gestion->obtenerPorId();
            return;

        case 'editar':
            $gestion->editar();
            return;

        case 'eliminar':
            $gestion->eliminar();
            return;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            return;
    }
}
