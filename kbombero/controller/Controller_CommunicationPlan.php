<?php
require_once '../model/Model_CommunicationPlan.php';

class ControllerCommunicationPlan {
    private $model;

    public function __construct() {
        $this->model = new ModelCommunicationPlan();
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $periodo = $_POST['periodo'] ?? '';
            $sistema = $_POST['sistema'] ?? '';
            $canal_frecuencia = $_POST['canal_frecuencia'] ?? '';
            $asignado = $_POST['asignado'] ?? '';
            $ubicacion = $_POST['ubicacion'] ?? '';
            $observaciones = $_POST['observaciones'] ?? '';
            $elaborado_por = $_POST['elaborado_por'] ?? '';
            $posicion = $_POST['posicion'] ?? '';
            $id_incidente = $_POST['id_incidente'] ?? null;

            $result = $this->model->addCommunicationPlan($periodo, $sistema, $canal_frecuencia, $asignado, $ubicacion, $observaciones, $elaborado_por, $posicion, $id_incidente);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Plan de comunicación agregado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar el plan de comunicación']);
            }
            exit;
        }
    }

    public function edit($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $periodo = $_POST['periodo'] ?? '';
            $sistema = $_POST['sistema'] ?? '';
            $canal_frecuencia = $_POST['canal_frecuencia'] ?? '';
            $asignado = $_POST['asignado'] ?? '';
            $ubicacion = $_POST['ubicacion'] ?? '';
            $observaciones = $_POST['observaciones'] ?? '';
            $elaborado_por = $_POST['elaborado_por'] ?? '';
            $posicion = $_POST['posicion'] ?? '';

            $result = $this->model->updateCommunicationPlan($id, $periodo, $sistema, $canal_frecuencia, $asignado, $ubicacion, $observaciones, $elaborado_por, $posicion);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Plan de comunicación actualizado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el plan de comunicación']);
            }
            exit;
        }
    }

    public function delete($id) {
        $result = $this->model->deleteCommunicationPlan($id);
        
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Plan de comunicación eliminado con éxito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el plan de comunicación']);
        }
        exit;
    }

    public function listar($id_incidente = null) {
        return $this->model->getAllCommunicationPlans($id_incidente);
    }
    public function getPlanById($id) {
        return $this->model->getCommunicationPlanById($id);
    }
    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }
}

$controller = new ControllerCommunicationPlan();

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
    }
}
?>