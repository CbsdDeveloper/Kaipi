<?php
// ob_start();

// error_reporting(0);
// ini_set('display_errors', 0);

// header('Content-Type: application/json');

// require_once '../model/Model-pai_datos_generales.php';
// // $response = array();
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener_datos') {
//     $id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;

//     if ($id_incidente) {
//         $pai_datos_generales = obtenerDatosPaiGeneralesPorIncidente($id_incidente);
//         echo json_encode($pai_datos_generales);
//     } else {
//         echo json_encode(['error' => 'ID de incidente no proporcionado']);
//     }
//     exit;
// }

// try {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
//         if ($_POST['accion'] === 'actualizar') {
//             $id_bom_pai_datos_g = $_POST['id_bom_pai_datos_g'];  

//             // Capturar los datos del formulario
//             $fecha_hora_inicio = $_POST['fecha_hora_inicio'];
//             $fecha_hora_fin = $_POST['fecha_hora_fin'];
//             $mensaje_seguridad = $_POST['mensaje_seguridad'];
//             $pronostico_tiempo = $_POST['pronostico_tiempo'];
//             $observaciones = $_POST['observaciones'];
//             $posicion = $_POST['posicion'];
//             $fecha_hora_preparacion = $_POST['fecha_hora_preparacion'];
//             $elaborador = $_POST['elaborador'];
//             $objetivos = [];

//             if (isset($_POST['objective']) && is_array($_POST['objective'])) {
//                 foreach ($_POST['objective'] as $key => $objetivo) {
//                     $objetivos[] = [
//                         'objetivo' => $objetivo,
//                         'estrategia' => $_POST['strategy'][$key],
//                         'tactica' => $_POST['tactic'][$key]
//                     ];
//                 }
//             }
//             error_log("Datos POST recibidos: " . json_encode($_POST));

//             $id_incidente = $_POST['id_incidente'];

//             // Llamar a la función para actualizar los datos
//             $resultado = actualizarDatosPaiGenerales(
//                 $id_bom_pai_datos_g,
//                 $fecha_hora_inicio,
//                 $fecha_hora_fin,
//                 $objetivos,
//                 $mensaje_seguridad,
//                 $pronostico_tiempo,
//                 $observaciones,
//                 $posicion,
//                 $fecha_hora_preparacion,
//                 $elaborador,
//                 $id_incidente
//             );

//             if ($resultado !== false) {
//                 $response = [
//                     'success' => true,
//                     'message' => 'Datos generales PAI actualizados con éxito'
//                 ];
//             } else {
//                 $response = [
//                     'success' => false,
//                     'message' => 'Error al actualizar los datos generales PAI'
//                 ];
//             }
//         }
//         echo json_encode($response);
//         exit;
//     }

//     // Verificar si se está haciendo una solicitud de eliminación
//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
//         $id_bom_pai_datos_g = isset($_POST['id']) ? $_POST['id'] : null;

//         if (!$id_bom_pai_datos_g) {
//             throw new Exception("ID de registro no proporcionado.");
//         }

//         // Llamar a la función para eliminar el registro
//         $resultado = eliminarDatosPaiGenerales($id_bom_pai_datos_g);

//         if ($resultado) {
//             $response = array(
//                 'success' => true,
//                 'message' => 'Registro eliminado con éxito.'
//             );
//         } else {
//             $response = array(
//                 'success' => false,
//                 'message' => 'Error al eliminar el registro.'
//             );
//         }
//     } else {
//         // Capturar los datos del formulario
//         $fecha_hora_inicio = $_POST['fecha_hora_inicio'];
//         $fecha_hora_fin = $_POST['fecha_hora_fin'];
//         $mensaje_seguridad = $_POST['mensaje_seguridad'];
//         $pronostico_tiempo = $_POST['pronostico_tiempo'];
//         $observaciones = $_POST['observaciones'];
//         $posicion = $_POST['posicion'];
//         $fecha_hora_preparacion = $_POST['fecha_hora_preparacion'];
//         $elaborador = $_POST['elaborador'];

//         // Capturar objetivos, estrategias y tácticas
//         $objetivos = array();
//         if (isset($_POST['objective']) && is_array($_POST['objective'])) {
//             foreach ($_POST['objective'] as $key => $objetivo) {
//                 $objetivos[] = array(
//                     'objetivo' => $objetivo,
//                     'estrategia' => $_POST['strategy'][$key],
//                     'tactica' => $_POST['tactic'][$key]
//                 );
//             }
//         }
//         error_log("Datos de objetivos recibidos: " . json_encode($objetivos));

//         $id_incidente = isset($_POST['id_incidente']) ? $_POST['id_incidente'] : null;

//         // Insertar siempre nuevos datos
//         $resultado = insertarDatosPaiGenerales(
//             $fecha_hora_inicio,
//             $fecha_hora_fin,
//             $objetivos,
//             $mensaje_seguridad,
//             $pronostico_tiempo,
//             $observaciones,
//             $posicion,
//             $fecha_hora_preparacion,
//             $elaborador,
//             $id_incidente
//         );

//         if ($resultado !== false) {
//             $fechas = obtenerFechasCreacionEdicion($resultado);
//             $response = array(
//                 'success' => true,
//                 'message' => 'Datos generales PAI guardados con éxito',
//                 'id_bom_pai_datos_g' => $resultado,
//                 'fecha_creacion' => $fechas['fecha_creacion'],
//                 'fecha_edicion' => $fechas['fecha_edicion']
//             );
//         } else {
//             $response = array(
//                 'success' => false,
//                 'message' => 'Error al guardar los datos generales PAI'
//             );
//         }
//     }
// } catch (Exception $e) {
//     $response = array(
//         'success' => false,
//         'message' => 'Error en el servidor: ' . $e->getMessage()
//     );
// }

// echo json_encode($response);





// --------------------------------------------------------------------------------------------
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

require_once '../model/Model-pai_datos_generales.php';

try {
    // Obtener datos PAI por ID de incidente
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener_datos') {
        $id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;

        if ($id_incidente) {
            $pai_datos_generales = obtenerDatosPaiGeneralesPorIncidente($id_incidente);
            echo json_encode($pai_datos_generales);
        } else {
            echo json_encode(['error' => 'ID de incidente no proporcionado']);
        }
        exit;
    }

    // Obtener elaboradores
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtener_elaboradores') {
        $elaboradores = obtenerElaboradoresPorPrograma();
        if ($elaboradores !== false) {
            echo json_encode([
                'success' => true,
                'elaboradores' => $elaboradores
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener la lista de elaboradores'
            ]);
        }
        exit;
    }

    // Manejar solicitudes POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['accion'])) {
            switch ($_POST['accion']) {
                case 'actualizar':
                    // Actualizar datos PAI
                    $id_bom_pai_datos_g = $_POST['id_bom_pai_datos_g'];
                    $fecha_hora_inicio = $_POST['fecha_hora_inicio'];
                    $fecha_hora_fin = $_POST['fecha_hora_fin'];
                    $mensaje_seguridad = $_POST['mensaje_seguridad'];
                    $pronostico_tiempo = $_POST['pronostico_tiempo'];
                    $observaciones = $_POST['observaciones'];
                    $posicion = $_POST['posicion'];
                    $fecha_hora_preparacion = $_POST['fecha_hora_preparacion'];
                    $elaborador = $_POST['elaborador'];

                    $objetivos = [];
                    if (isset($_POST['objective']) && is_array($_POST['objective'])) {
                        foreach ($_POST['objective'] as $key => $objetivo) {
                            if (!empty($objetivo) || !empty($_POST['strategy'][$key]) || !empty($_POST['tactic'][$key])) {
                                $objetivos[] = [
                                    'objetivo' => $objetivo,
                                    'estrategia' => $_POST['strategy'][$key],
                                    'tactica' => $_POST['tactic'][$key]
                                ];
                            }
                        }
                    }
                    error_log("Objetivos a actualizar: " . json_encode($objetivos));

                    $id_incidente = $_POST['id_incidente'];

                    $resultado = actualizarDatosPaiGenerales(
                        $id_bom_pai_datos_g,
                        $fecha_hora_inicio,
                        $fecha_hora_fin,
                        $objetivos,
                        $mensaje_seguridad,
                        $pronostico_tiempo,
                        $observaciones,
                        $posicion,
                        $fecha_hora_preparacion,
                        $elaborador,
                        $id_incidente
                    );

                    $response = $resultado !== false
                        ? ['success' => true, 'message' => 'Datos generales PAI actualizados con éxito']
                        : ['success' => false, 'message' => 'Error al actualizar los datos generales PAI'];
                    break;

                case 'eliminar':
                    // Eliminar datos PAI
                    $id_bom_pai_datos_g = isset($_POST['id']) ? $_POST['id'] : null;

                    if (!$id_bom_pai_datos_g) {
                        throw new Exception("ID de registro no proporcionado.");
                    }

                    $resultado = eliminarDatosPaiGenerales($id_bom_pai_datos_g);

                    $response = $resultado
                        ? ['success' => true, 'message' => 'Registro eliminado con éxito.']
                        : ['success' => false, 'message' => 'Error al eliminar el registro.'];
                    break;

                case 'agregar':
                    // Insertar nuevos datos PAI
                    $fecha_hora_inicio = $_POST['fecha_hora_inicio'];
                    $fecha_hora_fin = $_POST['fecha_hora_fin'];
                    $mensaje_seguridad = $_POST['mensaje_seguridad'];
                    $pronostico_tiempo = $_POST['pronostico_tiempo'];
                    $observaciones = $_POST['observaciones'];
                    $posicion = $_POST['posicion'];
                    $fecha_hora_preparacion = $_POST['fecha_hora_preparacion'];
                    $elaborador = $_POST['elaborador'];

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
                    error_log("Datos de objetivos recibidos: " . json_encode($objetivos));
                    $id_incidente = isset($_POST['id_incidente']) ? $_POST['id_incidente'] : null;

                    $resultado = insertarDatosPaiGenerales(
                        $fecha_hora_inicio,
                        $fecha_hora_fin,
                        $objetivos,
                        $mensaje_seguridad,
                        $pronostico_tiempo,
                        $observaciones,
                        $posicion,
                        $fecha_hora_preparacion,
                        $elaborador,
                        $id_incidente
                    );

                    if ($resultado !== false) {
                        $fechas = obtenerFechasCreacionEdicion($resultado);
                        $response = [
                            'success' => true,
                            'message' => 'Datos generales PAI guardados con éxito',
                            'id_bom_pai_datos_g' => $resultado,
                            'fecha_creacion' => $fechas['fecha_creacion'],
                            'fecha_edicion' => $fechas['fecha_edicion']
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'Error al guardar los datos generales PAI'
                        ];
                    }
                    break;

                default:
                    throw new Exception("Acción no reconocida.");
                    break;
            }
        } else {
            throw new Exception("Acción no especificada.");
        }
    } else {
        throw new Exception("Método de solicitud no válido.");
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ];
}

echo json_encode($response);