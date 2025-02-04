<?php
require_once '../model/Model_SafetyAnalysis.php';

class ControllerSafetyAnalysis {
    private $model;

    public function __construct() {
        $this->model = new ModelSafetyAnalysis();
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $area = $_POST['area'] ?? '';
            $riesgo = $_POST['riesgo'] ?? '';
            $accion_mitigante = $_POST['accion_mitigante'] ?? '';
            $posicion = $_POST['posicion'] ?? '';
            $id_incidente = $_POST['id_incidente'] ?? null;

            $result = $this->model->addSafetyAnalysis($area, $riesgo, $accion_mitigante, $posicion, $id_incidente);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Análisis de seguridad agregado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar el análisis de seguridad']);
            }
            exit;
        }
    }

    // public function edit($id) {
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $area = $_POST['area'] ?? '';
    //         $riesgo = $_POST['riesgo'] ?? '';
    //         $accion_mitigante = $_POST['accion_mitigante'] ?? '';
    //         $posicion = $_POST['posicion'] ?? '';

    //         $result = $this->model->updateSafetyAnalysis($id, $area, $riesgo, $accion_mitigante, $posicion);

    //         header('Content-Type: application/json');
    //         if ($result) {
    //             echo json_encode(['success' => true, 'message' => 'Análisis de seguridad actualizado con éxito']);
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Error al actualizar el análisis de seguridad']);
    //         }
    //         exit;
    //     }
    // }

    public function edit($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $area = $_POST['area'] ?? '';
        $riesgo = $_POST['riesgo'] ?? '';
        $accion_mitigante = $_POST['accion_mitigante'] ?? '';
        $posicion = $_POST['posicion'] ?? '';
        
            $result = $this->model->updateSafetyAnalysis($id, $area, $riesgo, $accion_mitigante, $posicion);
        
            header('Content-Type: application/json');
            if ($result) {
                $updatedAnalysis = $this->model->getSafetyAnalysisById($id);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Análisis de seguridad actualizado con éxito',
                    'fecha_edicion' => $updatedAnalysis['fecha_edicion_formatted']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el análisis de seguridad']);
            }
            exit;
        }
    }
    public function delete($id) {
        $result = $this->model->deleteSafetyAnalysis($id);
        
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Análisis de seguridad eliminado con éxito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el análisis de seguridad']);
        }
        exit;
    }

    public function listar($id_incidente = null) {
        return $this->model->getAllSafetyAnalysis($id_incidente);
    }

    public function getById($id) {
        return $this->model->getSafetyAnalysisById($id);
    }

    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }
}

$controller = new ControllerSafetyAnalysis();

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