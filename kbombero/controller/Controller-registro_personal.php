<?php
require_once '../model/Model-registro_personal.php';

class ControllerRegistroPersonal
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelBombero();
    }

    public function guardar()
    {
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'] ?? '';
            $especialidad = $_POST['especialidad'] ?? null;
            $institucion = $_POST['institucion'] ?? '';
            $matricula_vehiculo = $_POST['matricula_vehiculo'] ?? null;
            $observaciones = $_POST['observaciones'] ?? null;
            $id_incidente = $_POST['id_incidente'] ?? null;

            // Validación básica
            if (empty($nombre) || empty($institucion) || empty($id_incidente)) {
                echo json_encode(['success' => false, 'message' => 'Faltan campos requeridos']);
                exit;
            }

            $resultado = $this->model->agregarBombero($nombre, $especialidad, $institucion, $matricula_vehiculo, $observaciones, $id_incidente);
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Bombero agregado con éxito',
                    'id' => $resultado['id_bombero'],
                    'fecha_creacion' => $resultado['fecha_creacion']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar el bombero']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
        }
        exit;
    }

    public function obtenerBomberosPorIncidente($id_incidente)
    {
        return $this->model->obtenerBomberosPorIncidente($id_incidente);
    }
    public function eliminarBombero($id_bombero)
    {
        $resultado = $this->model->eliminarBombero($id_bombero);
        header('Content-Type: application/json');
        echo json_encode(['success' => $resultado]);
        exit;
    }

    public function duplicarBombero($id_bombero)
    {
        $bombero = $this->model->obtenerBomberoPorId($id_bombero);
        if ($bombero) {
            // Eliminamos el id_bombero para crear un nuevo registro
            unset($bombero['id_bombero']);
            $resultado = $this->model->agregarBombero(
                $bombero['nombre'],
                $bombero['especialidad'],
                $bombero['institucion'],
                $bombero['matricula_vehiculo'],
                $bombero['observaciones'],
                $bombero['id_incidente']
            );
            return $resultado;
        }
        return false;
    }

    public function guardarBomberoDesdeExcel()
    {
        $id_incidente = $_GET['id_incidente'] ?? null;

        if (!$id_incidente) {
            echo json_encode(['success' => false, 'message' => 'ID de incidente no proporcionado.']);
            return;
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);

        if (empty($jsonData)) {
            echo json_encode(['success' => false, 'message' => 'No se recibieron datos.']);
            return;
        }

        foreach ($jsonData as $row) {
            $nombre = $row[0]; // Ajusta según la estructura de tu Excel
            $institucion = $row[1];
            $especialidad = $row[2];
            $matricula_vehiculo = $row[3];

            if (empty($nombre) || empty($institucion)) {
                echo json_encode(['success' => false, 'message' => 'Nombre e institución son requeridos.']);
                return;
            }

            $resultado = $this->model->guardarBomberoDesdeExcel($id_incidente, $nombre, $institucion, $especialidad, $matricula_vehiculo);
            if (!$resultado) {
                echo json_encode(['success' => false, 'message' => 'Error al guardar datos desde Excel.']);
                return;
            }
        }

        echo json_encode(['success' => true, 'message' => 'Datos guardados exitosamente.']);
    }

    public function actualizar()
    {
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_bombero = $_POST['id_bombero'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $especialidad = $_POST['especialidad'] ?? null;
            $institucion = $_POST['institucion'] ?? '';
            $matricula_vehiculo = $_POST['matricula_vehiculo'] ?? null;
            $observaciones = $_POST['observaciones'] ?? null;

            if (empty($id_bombero) || empty($nombre) || empty($institucion)) {
                echo json_encode(['success' => false, 'message' => 'Faltan campos requeridos']);
                exit;
            }

            $resultado = $this->model->actualizarBombero($id_bombero, $nombre, $especialidad, $institucion, $matricula_vehiculo, $observaciones);
            if ($resultado) {
                $fechas = $this->model->obtenerFechasCreacionEdicion($id_bombero);
                echo json_encode([
                    'success' => true,
                    'message' => 'Bombero actualizado con éxito',
                    'fecha_creacion' => $fechas['fecha_creacion'],
                    'fecha_edicion' => $fechas['fecha_edicion']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el bombero']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
        }
        exit;
    }

    public function obtenerFechas($id_bombero)
    {
        header('Content-Type: application/json');

        try {
            $fechas = $this->model->obtenerFechasCreacionEdicion($id_bombero);
            var_dump($fechas);  // Depurar para ver los datos
            if ($fechas) {
                $response = [
                    'success' => true,
                    'fecha_creacion' => $fechas['fecha_creacion'],
                    'fecha_edicion' => $fechas['fecha_edicion'] ? $fechas['fecha_edicion'] : 'No editado'
                ];
            } else {
                $response = ['success' => false, 'error' => 'No se encontraron fechas'];
            }
        } catch (Exception $e) {
            $response = ['success' => false, 'error' => 'Error en el servidor: ' . $e->getMessage()];
        }

        echo json_encode($response);
        exit;
    }

    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }
}

// Asegúrate de que no haya salida antes de este punto
ob_start();

$controller = new ControllerRegistroPersonal();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['action']) && $_GET['action'] === 'actualizar') {
        $controller->actualizar();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'guardar_desde_excel') {
        $controller->guardarBomberoDesdeExcel();
    } else {
        $controller->guardar();
    }
} elseif (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'eliminar':
            $id_bombero = $_GET['id'] ?? null;
            $id_incidente = $_GET['id_incidente'] ?? null;
            if ($id_bombero && $id_incidente) {
                $controller->eliminarBombero($id_bombero);
            }
            break;
        case 'duplicar':
            $id_bombero = $_GET['id'] ?? null;
            $id_incidente = $_GET['id_incidente'] ?? null;
            if ($id_bombero && $id_incidente) {
                $resultado = $controller->duplicarBombero($id_bombero);
                $mensaje = $resultado ? "Bombero duplicado." : "Error al duplicar el bombero.";
                echo json_encode(['success' => $resultado, 'message' => $mensaje]);
            }
            break;
        case 'obtener_fechas':
            $id_bombero = $_GET['id'] ?? null;
            if ($id_bombero) {
                $controller->obtenerFechas($id_bombero);
            }
            break;
        case 'obtener_bomberos':
            $id_incidente = $_GET['id_incidente'] ?? null;
            if ($id_incidente) {
                $bomberos = $controller->obtenerBomberosPorIncidente($id_incidente);
                echo json_encode($bomberos);
            }
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}

// Limpia cualquier salida bufferizada
ob_end_clean();
