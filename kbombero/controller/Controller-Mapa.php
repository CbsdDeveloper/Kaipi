<?php
// Evitar que se muestre cualquier error de PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

// Asegurarse de que la salida sea JSON
header('Content-Type: application/json');

require_once '../model/Model-Mapa.php';

// Envolver todo en un try-catch para manejar errores
try {
    // Verificar la acción solicitada
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    switch ($action) {
        case 'guardar_marcador':
            // Capturar los datos del marcador
            $latitud = $_POST['latitud'];
            $longitud = $_POST['longitud'];
            $titulo = $_POST['titulo'];
            $observaciones = $_POST['observaciones'];
            $clase_icono = $_POST['clase_icono'] ?? null;
            $color_icono = $_POST['color_icono'] ?? null;
            $imagen_url = $_POST['imagen_url'] ?? null;
            $id_incidente = $_POST['id_incidente'];

            $resultado = guardarMarcador($latitud, $longitud, $titulo, $observaciones, $clase_icono, $color_icono, $imagen_url, $id_incidente);

            if ($resultado !== false) {
                $response = array(
                    'success' => true,
                    'message' => 'Marcador guardado con éxito',
                    'id' => $resultado
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al guardar el marcador'
                );
            }
            break;

        case 'obtener_marcadores':
            $id_incidente = $_GET['id_incidente'];
            $marcadores = obtenerMarcadores($id_incidente);
            if ($marcadores !== false) {
                $response = array(
                    'success' => true,
                    'marcadores' => $marcadores,
                    'debug' => array(
                        'num_marcadores' => count($marcadores),
                        'primer_marcador' => !empty($marcadores) ? $marcadores[0] : null
                    )
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al obtener los marcadores',
                    'error' => 'Error en la consulta de base de datos'
                );
            }
            break;

        case 'eliminar_marcador':
            $id = $_POST['id'];
            $resultado = eliminarMarcador($id);

            if ($resultado) {
                $response = array(
                    'success' => true,
                    'message' => 'Marcador eliminado con éxito'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Error al eliminar el marcador'
                );
            }
            break;
            case 'guardar_imagen_mapa':
                if (!isset($_POST['id_incidente']) || !isset($_FILES['imagen'])) {
                    $response = array(
                        'success' => false,
                        'message' => 'Faltan datos requeridos'
                    );
                    break;
                }
            
                $id_incidente = intval($_POST['id_incidente']);
                $imagen = $_FILES['imagen'];
            
                if ($id_incidente <= 0) {
                    $response = array(
                        'success' => false,
                        'message' => 'ID de incidente no válido'
                    );
                    break;
                }
            
                $directorio = '../view/imagesMapa/';
                if (!file_exists($directorio)) {
                    if (!mkdir($directorio, 0777, true)) {
                        $response = array(
                            'success' => false,
                            'message' => 'No se pudo crear el directorio de imágenes',
                            'debug' => error_get_last()
                        );
                        break;
                    }
                }
            
                // Generar nombre único para la imagen que incluye el ID del incidente
                $nombre_archivo = 'mapaIncidente_' . $id_incidente . '.png';
                $ruta_archivo = $directorio . $nombre_archivo;
            
                // Eliminar la imagen anterior si existe
                if (file_exists($ruta_archivo)) {
                    unlink($ruta_archivo);
                }
            
                if (move_uploaded_file($imagen['tmp_name'], $ruta_archivo)) {
                    $imagen_url = '/view/imagesMapa/' . $nombre_archivo;
                    $resultado = guardarImagenMapa($id_incidente, $imagen_url);
            
                    if ($resultado) {
                        $response = array(
                            'success' => true,
                            'message' => 'Imagen del mapa guardada con éxito',
                            'imagen_url' => $imagen_url
                        );
                    } else {
                        $response = array(
                            'success' => false,
                            'message' => 'Error al guardar la URL de la imagen en la base de datos',
                            'debug' => error_get_last()
                        );
                    }
                } else {
                    $response = array(
                        'success' => false,
                        'message' => 'Error al guardar la imagen en el servidor',
                        'debug' => array(
                            'upload_error' => $imagen['error'],
                            'tmp_name' => $imagen['tmp_name'],
                            'destination' => $ruta_archivo,
                            'php_error' => error_get_last()
                        )
                    );
                }
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