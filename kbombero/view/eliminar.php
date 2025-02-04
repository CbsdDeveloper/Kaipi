<?php
require_once '../controller/Controller-ResumenAcciones.php';

if (isset($_GET['delete_id'])) {
    $controller = new ControllerResumenAcciones();
    $controller->eliminar($_GET['delete_id']);
} else {
    echo "ID de registro no proporcionado.";
}
?>
