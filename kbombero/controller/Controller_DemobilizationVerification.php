<?php
require_once '../model/Model_DemobilizationVerification.php';

class ControllerDemobilizationVerification {
    private $model;

    public function __construct() {
        try {
            $this->model = new ModelDemobilizationVerification();
        } catch (Exception $e) {
            error_log("Error al inicializar el modelo: " . $e->getMessage());
            die("Error al inicializar el sistema. Por favor, contacte al administrador.");
        }
    }

    public function listar($id_incidente = null) {
        if (!$this->model) {
            error_log("El modelo no está inicializado en el método listar()");
            return [];
        }
        return $this->model->getAllDemobilizationVerifications($id_incidente);
    }

    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $periodo = $_POST['periodo'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $unidad_personal = $_POST['unidad_personal'] ?? '';
            $notas = $_POST['notas'] ?? '';
            $elaborado_por = $_POST['elaborado_por'] ?? '';
            $posicion = $_POST['posicion'] ?? '';
            $id_incidente = $_POST['id_incidente'] ?? null;
    
            $result = $this->model->addDemobilizationVerification($periodo, $fecha_hora, $unidad_personal, $notas, $elaborado_por, $posicion, $id_incidente);
    
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Verificación de desmovilización agregada con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar la verificación de desmovilización']);
            }
            exit;
        }
    }

    public function edit($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $periodo = $_POST['periodo'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $unidad_personal = $_POST['unidad_personal'] ?? '';
            $notas = $_POST['notas'] ?? '';
            $elaborado_por = $_POST['elaborado_por'] ?? '';
            $posicion = $_POST['posicion'] ?? '';

            $result = $this->model->updateDemobilizationVerification($id, $periodo, $fecha_hora, $unidad_personal, $notas, $elaborado_por, $posicion);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Verificación de desmovilización actualizada con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la verificación de desmovilización']);
            }
            exit;
        }
    }

    public function delete($id) {
        $result = $this->model->deleteDemobilizationVerification($id);

        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Verificación de desmovilización eliminada con éxito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar la verificación de desmovilización']);
        }
        exit;
    }
    public function getById($id) {
        return $this->model->getDemobilizationVerificationById($id);
    }

}

$controller = new ControllerDemobilizationVerification();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $controller->add();
            break;
        case 'edit':
            $controller->edit($_POST['id']);
            break;
        case 'delete':
            $controller->delete($_POST['id']);
            break;
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
            
    }
}
?>