<?php
require_once '../model/Model_Personas.php';

class ControllerPersonas {
    private $model;

    public function __construct() {
        $this->model = new ModelPersonas();
    }


    public function listar($id_incidente = null) {
        if ($id_incidente) {
            return $this->model->obtenerPersonasPorIncidente($id_incidente);
        } else {
            return $this->model->obtenerPersonas();
        }
    }


    public function obtenerPorId($id) {
        return $this->model->obtenerPersonaPorId($id);
        
    }

    public function obtenerIncidentePorId($id) {
        return $this->model->obtenerIncidentePorId($id);
    }


    public function agregar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $sexo = $_POST['sexo'];
            $edad = $_POST['edad'];
            $clasificacion = $_POST['clasificacion'];
            $lugar_traslado = $_POST['lugar_traslado'];
            $trasladado_por = $_POST['trasladado_por'];
            $fecha_hora = $_POST['fecha_hora'];
            $probable_diagnostico = $_POST['probable_diagnostico'];
            $id_incidente = $_POST['id_incidente'];

            // Depuración: imprimir valores recibidos
            error_log("Datos recibidos: " . print_r($_POST, true));

            header('Content-Type: application/json');
            $resultado = $this->model->agregarPersona($nombre, $sexo, $edad, $clasificacion, $lugar_traslado, $trasladado_por, $fecha_hora, $probable_diagnostico, $id_incidente);
            
            // Depuración: imprimir resultado de la operación
            error_log("Resultado de agregarPersona: " . var_export($resultado, true));

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Persona agregada con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar la persona']);
            }
            exit;
        }
    }

    public function actualizar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $sexo = $_POST['sexo'];
            $edad = $_POST['edad'];
            $clasificacion = $_POST['clasificacion'];
            $lugar_traslado = $_POST['lugar_traslado'];
            $trasladado_por = $_POST['trasladado_por'];
            $fecha_hora = $_POST['fecha_hora'];
            $probable_diagnostico = $_POST['probable_diagnostico'];
            $id_incidente = $_POST['id_incidente'];

            header('Content-Type: application/json');
            if ($this->model->actualizarPersona($id, $nombre, $sexo, $edad, $clasificacion, $lugar_traslado, $trasladado_por, $fecha_hora, $probable_diagnostico, $id_incidente)) {
                echo json_encode(['success' => true, 'message' => 'Persona actualizada con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la persona']);
            }
            exit;
        }
    }
    public function eliminar($id) {
        $id_incidente = $_GET['id_incidente'];
        if ($this->model->eliminarPersona($id)) {
            header("Location: ../view/lista_personas.php?id_incidente=$id_incidente");
        } else {
            echo "Error al eliminar el registro.";
        }
    }
  
    public function actualizar_desde_excel() {
        // Desactivar la salida de errores
        ini_set('display_errors', 0);
        error_reporting(E_ALL);
    
        // Configurar un manejador de errores personalizado
        set_error_handler(function($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });
    
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
    
                if ($data === null) {
                    throw new Exception('Datos JSON inválidos');
                }
    
                $success_count = 0;
                $error_count = 0;
    
                foreach ($data as $row) {
                    $persona = [
                        'nombre' => $row[0],
                        'sexo' => $row[1],
                        'edad' => $row[2],
                        'clasificacion' => $row[3],
                        'lugar_traslado' => $row[4],
                        'trasladado_por' => $row[5],
                        'fecha_hora' => $row[6],
                        'probable_diagnostico' => $row[7]
                    ];
    
                    if ($this->model->insertarOActualizarPersona($persona)) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                }
    
                echo json_encode([
                    'message' => "Actualización completada. Éxitos: $success_count, Errores: $error_count",
                    'success' => $success_count,
                    'errors' => $error_count
                ]);
            } else {
                throw new Exception('Método no permitido');
            }
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    
        // Restaurar el manejador de errores predeterminado
        restore_error_handler();
    }
    
}

$controller = new ControllerPersonas();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'agregar':
            $controller->agregar();
            break;
        case 'actualizar':
            $controller->actualizar();
            break;
        case 'actualizar_desde_excel':
            $controller->actualizar_desde_excel();
            break;
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'eliminar':
            if (isset($_GET['id'])) {
                $controller->eliminar($_GET['id']);
            }
            break;
        case 'actualizar_desde_excel':
            $controller->actualizar_desde_excel();
            break;
    }
}
?>