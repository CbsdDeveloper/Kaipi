<?php
// Evitar que se muestre cualquier error de PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

// Asegurarse de que la salida sea JSON
header('Content-Type: application/json');

require_once '../model/Model-datos_generales.php';

// Al principio del archivo, después de los headers
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener_datos') {
    $id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
    
    if ($id_incidente) {
        $datos_generales = obtenerDatosGeneralesPorIncidente($id_incidente);
        echo json_encode($datos_generales);
    } else {
        echo json_encode(['error' => 'ID de incidente no proporcionado']);
    }
    exit;
}

// Envolver todo en un try-catch para manejar errores
try {
    // Capturar los datos del formulario
    $evaluacion_inicial = $_POST['initial_evaluation'];
    $ubicacion_puesto_comando = $_POST['command_location'];
    $area_espera = $_POST['wait_area'];
    $ruta_egreso = $_POST['exit_route'];
    $ruta_ingreso = $_POST['entry_route'];
    $mensaje_seguridad = $_POST['security_message'];
    $distribucion_canales_comunicacion = $_POST['distribution'];
    $datos_meteorologicos = $_POST['metereological_data'];
    $fecha_hora_preparacion = $_POST['made_date'];
    
    // Capturar los nuevos campos
    $posicion = $_POST['posicion'];
    $elaborado_por = $_POST['elaborado_por'];

    // Capturar objetivos, estrategias y tácticas
    $objetivos = array();
    if (isset($_POST['objective']) && is_array($_POST['objective'])) {
        foreach ($_POST['objective'] as $key => $objetivo) {
            $objetivos[] = array(
                'objetivo' => $objetivo,
                'estrategia' => $_POST['strategy'][$key],
                'tactica' => $_POST['tactic'][$key]
            );
        }
    }

    $id_incidente = isset($_POST['id_incidente']) ? $_POST['id_incidente'] : null;

    // Verificar si ya existe un registro para este incidente
    $datos_existentes = obtenerDatosGeneralesPorIncidente($id_incidente);

    if ($datos_existentes) {
        // Si existe, actualizamos
        $id_bom_datos_g = $datos_existentes['id_bom_datos_g'];
        $resultado = actualizarDatosGenerales(
            $id_bom_datos_g,
            $evaluacion_inicial,
            $objetivos,
            $ubicacion_puesto_comando,
            $area_espera,
            $ruta_egreso,
            $ruta_ingreso,
            $mensaje_seguridad,
            $distribucion_canales_comunicacion,
            $datos_meteorologicos,
            $fecha_hora_preparacion,
            $id_incidente,
            $posicion,
            $elaborado_por
        );
    } else {
        // Si no existe, insertamos
        $resultado = insertarDatosGenerales(
            $evaluacion_inicial,
            $objetivos,
            $ubicacion_puesto_comando,
            $area_espera,
            $ruta_egreso,
            $ruta_ingreso,
            $mensaje_seguridad,
            $distribucion_canales_comunicacion,
            $datos_meteorologicos,
            $fecha_hora_preparacion,
            $id_incidente,
            $posicion,
            $elaborado_por
        );
    }

    if ($resultado !== false) {
        $fechas = obtenerFechasCreacionEdicion($resultado);
        $response = array(
            'success' => true,
            'message' => 'Datos generales guardados con éxito',
            'id_bom_datos_g' => $resultado,
            'fecha_creacion' => $fechas['fecha_creacion'],
            'fecha_edicion' => $fechas['fecha_edicion']
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error al guardar los datos generales'
        );
    }
} catch (Exception $e) {
    $response = array(
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    );
}

echo json_encode($response);