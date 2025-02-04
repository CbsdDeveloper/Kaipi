<?php
require_once '../model/Model_ResumenAcciones.php';

class ControllerResumenAcciones {
    private $model;

    public function __construct() {
        $this->model = new ModelResumenAcciones();
    }

    public function eliminar($id) {
        $id_incidente = $_GET['id_incidente'];
        if ($this->model->eliminarAccion($id)) {
            header("Location: ../view/principal.php?page=resumen&id_incidente=$id_incidente");
        } else {
            echo "Error al eliminar el registro.";
        }
    }

    public function agregar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actividad'])) {
            $actividad = $_POST['actividad'];
            $fecha_hora = $_POST['fecha_hora'];
            $posicion_institucion = $_POST['posicion_institucion'];
            $id_incidente = $_POST['id_incidente'] ?? null;

            // Respuesta JSON para AJAX
            header('Content-Type: application/json');

            if ($this->model->agregarAccion($actividad, $fecha_hora, $posicion_institucion, $id_incidente)) {
                echo json_encode(['success' => true, 'message' => 'Acción agregada con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar la acción']);
            }
            exit;
        }
    }

    public function listar() {
        $acciones = $this->model->obtenerAcciones();
        return $acciones;
    }

    public function obtenerPorId($id) {
        return $this->model->obtenerAccionPorId($id);
    }

    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }

    public function listarPorIncidente($id_incidente) {
        return $this->model->obtenerAccionesPorIncidente($id_incidente);
    }

    public function guardar() {
        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actividad'])) {
            $actividad = $_POST['actividad'];
            $fecha_hora = $_POST['fecha_hora'];
            $posicion_institucion = $_POST['posicion_institucion'];
            $id_incidente = $_POST['id_incidente'] ?? null;
            $id = $_POST['id'] ?? null;

            if ($id) {
                // Actualizar el registro existente
                $result = $this->model->actualizarAccion($id, $actividad, $fecha_hora, $posicion_institucion, $id_incidente);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Acción actualizada con éxito']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar la acción']);
                }
            } else {
                // Crear un nuevo registro
                if ($this->model->agregarAccion($actividad, $fecha_hora, $posicion_institucion, $id_incidente)) {
                    echo json_encode(['success' => true, 'message' => 'Acción agregada con éxito']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al agregar la acción']);
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos no recibidos correctamente']);
        }
        exit;
    }
}

// Asegúrate de que no haya salida antes de este punto
ob_start();

$controller = new ControllerResumenAcciones();

if (isset($_POST["actividad"])) {
    $controller->guardar();
}

// Limpia cualquier salida buffereada
ob_end_clean();
?>