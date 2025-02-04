<?php
// Evitar que se muestre cualquier error de PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

// Asegurarse de que la salida sea JSON
header('Content-Type: application/json');

require_once '../model/Model-Recursos.php';

// Envolver todo en un try-catch para manejar errores
try {
    // Verificar la acción solicitada
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    switch ($action) {
        case 'guardar_recurso':
            // Capturar los datos del recurso
            $clase = $_POST['clase'];
            $tipo = $_POST['tipo'];
            $fecha_hora_solicitud = $_POST['fecha_hora_solicitud'];
            $solicitado_por = $_POST['solicitado_por'];
            $fecha_hora_arribo = $_POST['fecha_hora_arribo'];
            $institucion = $_POST['institucion'];
            $matricula = $_POST['matricula'];
            $numero_personas = $_POST['numero_personas'];
            $estado_recurso = $_POST['estado_recurso'];
            $asignado_a = $_POST['asignado_a'];
            $periodo_operacional = $_POST['periodo_operacional'];
            $fecha_hora_desmovilizacion = $_POST['fecha_hora_desmovilizacion'];
            $responsable_desmovilizacion = $_POST['responsable_desmovilizacion'];
            $observaciones = $_POST['observaciones'];
            $id_incidente = $_POST['id_incidente'];

            $resultado = guardarRecursoBomberoSCI(
                $clase,
                $tipo,
                $fecha_hora_solicitud,
                $solicitado_por,
                $fecha_hora_arribo,
                $institucion,
                $matricula,
                $numero_personas,
                $estado_recurso,
                $asignado_a,
                $periodo_operacional,
                $fecha_hora_desmovilizacion,
                $responsable_desmovilizacion,
                $observaciones,
                $id_incidente
            );

            if ($resultado !== false) {
                $response = array(
                    'success' => true,
                    'message' => 'Recurso guardado con éxito',
                    'id' => $resultado
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al guardar el recurso'
                );
            }
            break;

        case 'obtener_recursos':
            $id_incidente = $_GET['id_incidente'];
            $recursos = obtenerRecursosBomberoSCI($id_incidente);
            if ($recursos !== false) {
                $response = array(
                    'success' => true,
                    'recursos' => $recursos,
                    'debug' => array(
                        'num_recursos' => count($recursos),
                        'primer_recurso' => !empty($recursos) ? $recursos[0] : null
                    )
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al obtener los recursos',
                    'error' => 'Error en la consulta de base de datos'
                );
            }
            break;

        case 'eliminar_recurso':
            $id = $_POST['id'];
            $resultado = eliminarRecursoBomberoSCI($id);

            if ($resultado) {
                $response = array(
                    'success' => true,
                    'message' => 'Recurso eliminado con éxito'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al eliminar el recurso'
                );
            }
            break;

        case 'duplicar_recurso':
            $id = $_POST['id'];
            $resultado = duplicarRecursoBomberoSCI($id);

            if ($resultado !== false) {
                $response = array(
                    'success' => true,
                    'message' => 'Recurso duplicado con éxito',
                    'id' => $resultado
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al duplicar el recurso'
                );
            }
            break;

        case 'obtener_recurso':
            $id = $_GET['id'];
            $recurso = obtenerRecursoBomberoSCI($id);

            if ($recurso !== false) {
                $response = array(
                    'success' => true,
                    'recurso' => $recurso
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al obtener el recurso'
                );
            }
            break;

        case 'actualizar_recurso':
            $id = $_POST['id'];
            $clase = $_POST['clase'];
            $tipo = $_POST['tipo'];
            $fecha_hora_solicitud = $_POST['fecha_hora_solicitud'];
            $solicitado_por = $_POST['solicitado_por'];
            $fecha_hora_arribo = $_POST['fecha_hora_arribo'];
            $institucion = $_POST['institucion'];
            $matricula = $_POST['matricula'];
            $numero_personas = $_POST['numero_personas'];
            $estado_recurso = $_POST['estado_recurso'];
            $asignado_a = $_POST['asignado_a'];
            $periodo_operacional = $_POST['periodo_operacional'];
            $fecha_hora_desmovilizacion = $_POST['fecha_hora_desmovilizacion'];
            $responsable_desmovilizacion = $_POST['responsable_desmovilizacion'];
            $observaciones = $_POST['observaciones'];
            $id_incidente = $_POST['id_incidente'];

            $resultado = actualizarRecursoBomberoSCI(
                $id,
                $clase,
                $tipo,
                $fecha_hora_solicitud,
                $solicitado_por,
                $fecha_hora_arribo,
                $institucion,
                $matricula,
                $numero_personas,
                $estado_recurso,
                $asignado_a,
                $periodo_operacional,
                $fecha_hora_desmovilizacion,
                $responsable_desmovilizacion,
                $observaciones,
                $id_incidente
            );

            if ($resultado) {
                $response = array(
                    'success' => true,
                    'message' => 'Recurso actualizado con éxito'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al actualizar el recurso'
                );
            }
            break;

        case 'importar_recursos':
            $datos = json_decode($_POST['datos'], true);
            $id_incidente = $_POST['id_incidente'];
            
            if (!is_array($datos) || empty($datos)) {
                throw new Exception('Datos inválidos o vacíos');
            }

            $resultados = array();
            foreach ($datos as $fila) {
                $resultado = guardarRecursoBomberoSCI(
                    $fila['clase'],
                    $fila['tipo'],
                    $fila['fecha_hora_solicitud'],
                    $fila['solicitado_por'],
                    $fila['fecha_hora_arribo'],
                    $fila['institucion'],
                    $fila['matricula'],
                    $fila['numero_personas'],
                    $fila['estado_recurso'],
                    $fila['asignado_a'],
                    $fila['periodo_operacional'] ?? '', // Asumiendo que este campo puede no estar presente en el Excel
                    $fila['fecha_hora_desmovilizacion'],
                    $fila['responsable_desmovilizacion'],
                    $fila['observaciones'],
                    $id_incidente
                );
                
                $resultados[] = $resultado;
            }

            $exitosos = array_filter($resultados);
            $fallidos = count($resultados) - count($exitosos);

            $response = array(
                'success' => true,
                'message' => "Se importaron " . count($exitosos) . " recursos exitosamente. " . $fallidos . " fallaron.",
                'resultados' => $resultados
            );
            break;

        default:
            $response = array(
                'success' => false,
                'message' => 'Acción no reconocida'
            );
    }
} catch (Exception $e) {
    $response = array(
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    );
}

echo json_encode($response);