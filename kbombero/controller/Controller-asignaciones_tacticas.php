<?php
// Evitar que se muestre cualquier error de PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

// Logging para depuración
error_log("Iniciando Controller-asignaciones_tacticas.php");
error_log("Datos POST recibidos: " . print_r($_POST, true));
error_log("Datos GET recibidos: " . print_r($_GET, true));

header('Content-Type: application/json');

require_once '../model/Model-asignaciones_tacticas.php';

try {
    // Verificar la acción solicitada
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    error_log("Acción recibida: " . $action);

    switch ($action) {
        case 'guardar_asignacion_y_responsables':
            $datos_asignacion = [
                'periodo' => $_POST['periodo'],
                'posicion_estructura' => $_POST['posicion_estructura'],
                'observaciones' => $_POST['observaciones'],
                'elaborado_por' => $_POST['elaborado_por'],
                'aprobado_por' => $_POST['aprobado_por'],
                'id_incidente' => $_POST['id_incidente']
            ];
            
            $responsables = json_decode($_POST['responsables'], true);
        
            $resultado = guardarAsignacionYResponsables($datos_asignacion, $responsables);
        
            if ($resultado !== false) {
                $response = [
                    'success' => true,
                    'message' => 'Asignación y responsables guardados con éxito',
                    'id_asignacion' => $resultado
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al guardar la asignación y responsables'
                ];
            }
            break;

        case 'obtener_asignaciones_y_responsables':
            $id_incidente = $_GET['id_incidente'];
            $asignaciones = obtenerAsignacionesYResponsables($id_incidente);
            if ($asignaciones !== false) {
                $response = [
                    'success' => true,
                    'asignaciones' => $asignaciones
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al obtener las asignaciones y responsables'
                ];
            }
            break;

        case 'eliminar_asignacion_y_responsables':
            $id_asignacion = $_POST['id_asignacion'];
            $resultado = eliminarAsignacionYResponsables($id_asignacion);

            if ($resultado) {
                $response = [
                    'success' => true,
                    'message' => 'Asignación y responsables eliminados con éxito'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al eliminar la asignación y responsables'
                ];
            }
            break;
            case 'obtener_asignacion_y_responsables':
                $id_asignacion = isset($_GET['id_asignacion']) ? intval($_GET['id_asignacion']) : 0;
                
                error_log("Solicitando asignación con ID: " . $id_asignacion); // Para debug
                
                if ($id_asignacion <= 0) {
                    $response = [
                        'success' => false,
                        'message' => 'ID de asignación inválido'
                    ];
                } else {
                    $resultado = obtenerAsignacionYResponsables($id_asignacion);
                    error_log("Resultado de la consulta: " . print_r($resultado, true)); // Para debug
                    
                    if ($resultado !== false) {
                        $response = [
                            'success' => true,
                            'data' => $resultado
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'Error al obtener la asignación y responsables'
                        ];
                    }
                }
                break; 
        case 'actualizar_asignacion_y_responsables':
            $id_asignacion = $_POST['id_asignacion'];
            $datos_asignacion = [
                'periodo' => $_POST['periodo'],
                'posicion_estructura' => $_POST['posicion_estructura'],
                'observaciones' => $_POST['observaciones'],
                'elaborado_por' => $_POST['elaborado_por'],
                'aprobado_por' => $_POST['aprobado_por'],
                'id_incidente' => $_POST['id_incidente']
            ];
            $responsables = json_decode($_POST['responsables'], true);

            $resultado = actualizarAsignacionYResponsables($id_asignacion, $datos_asignacion, $responsables);

            if ($resultado) {
                $response = [
                    'success' => true,
                    'message' => 'Asignación y responsables actualizados con éxito'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al actualizar la asignación y responsables'
                ];
            }
            break;
//
case 'obtener_elaboradores':
    $elaboradores = obtenerElaboradoresPorPrograma();
    if ($elaboradores !== false) {
        $response = [
            'success' => true,
            'elaboradores' => $elaboradores
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error al obtener la lista de elaboradores'
        ];
    }
    break;

    case 'obtener_periodos':
        $id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : 0;
        if ($id_incidente > 0) {
            $periodos = obtenerPeriodos($id_incidente);
            if ($periodos !== false) {
                $response = [
                    'success' => true,
                    'periodos' => $periodos
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al obtener la lista de periodos'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'ID de incidente no válido'
            ];
        }
        break;


        default:
            $response = [
                'success' => false,
                'message' => 'Acción no reconocida'
            ];
    }
} catch (Exception $e) {
    error_log("Error en el controlador: " . $e->getMessage());
    $response = [
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ];
}

error_log("Respuesta del controlador: " . json_encode($response));
echo json_encode($response);