<?php
require_once '../model/Model-registro-214.php';

class ControllerRegistroSCI
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelBomberoSCI();
    }

    public function guardar()
    {
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'] ?? '';
            $posicion = $_POST['posicion'] ?? '';
            $institucion = $_POST['institucion'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $actividad = $_POST['actividad'] ?? '';
            $id_incidente = $_POST['id_incidente'] ?? null;

            if (empty($nombre) || empty($posicion) || empty($institucion) || empty($fecha_hora) || empty($actividad) || empty($id_incidente)) {
                echo json_encode(['success' => false, 'message' => 'Faltan campos requeridos']);
                exit;
            }

            $resultado = $this->model->agregarBombero($nombre, $posicion, $institucion, $fecha_hora, $actividad, $id_incidente);

            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Bombero agregado con éxito',
                    'id_incidente' => $resultado['id_incidente'],
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
        $bomberos = $this->model->obtenerBomberosPorIncidente($id_incidente);
        if ($bomberos === false) {
            error_log("Error al obtener bomberos para el incidente $id_incidente");
            return [];
        }
        return $bomberos;
    }

    public function eliminar()
    {
        try {
            $id_bombero = $_POST['id_bombero'] ?? null;
            $id_incidente = $_POST['id_incidente'] ?? null;

            if (!$id_bombero || !$id_incidente) {
                throw new Exception('Datos incompletos.');
            }

            $resultado = $this->model->eliminarBombero($id_bombero);

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Bombero eliminado con éxito']);
            } else {
                throw new Exception('Error al eliminar el bombero');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function obtenerBomberoPorId($id_bombero)
    {
        return $this->model->obtenerBomberoPorId($id_bombero);
    }

    public function actualizar()
    {
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_bombero = $_POST['id_bombero'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $posicion = $_POST['posicion'] ?? '';
            $institucion = $_POST['institucion'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $actividad = $_POST['actividad'] ?? '';

            if (empty($id_bombero) || empty($nombre) || empty($posicion) || empty($institucion) || empty($fecha_hora) || empty($actividad)) {
                echo json_encode(['success' => false, 'message' => 'Faltan campos requeridos']);
                exit;
            }

            $resultado = $this->model->actualizarBombero214($id_bombero, $nombre, $posicion, $institucion, $fecha_hora, $actividad);
            if ($resultado) {
                $bombero = $this->model->obtenerBomberoPorId($id_bombero);
                echo json_encode([
                    'success' => true,
                    'message' => 'Bombero actualizado con éxito',
                    'fecha_creacion' => $bombero['fecha_hora'],
                    'fecha_edicion' => $bombero['fecha_edicion']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el bombero']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
        }
        exit;
    }

    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }
}

$controller = new ControllerRegistroSCI();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'eliminar':
                $controller->eliminar();
                break;
            case 'actualizar':
                $controller->actualizar();
                break;
            default:
                $controller->guardar();
        }
    } else {
        $controller->guardar();
    }
}
