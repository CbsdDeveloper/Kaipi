<?php
session_start();
ini_set('display_errors', 0);
error_reporting(0);
require_once '../controller/Controller-ResumenAcciones.php';
$controller = new ControllerResumenAcciones();

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
$incidente = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $accion = $controller->obtenerPorId($id);
    if (!is_array($accion) || empty($accion)) {
        echo "<p>No se encontraron datos para este registro.</p>";
        exit;
    }
} else {
    echo "<p>ID no especificado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Acción</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
</head>

<body>
    <custom-header></custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Resumen de las Acciones</h6><br>
            <form id="editarAccionForm">
                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo $_GET['id_incidente'] ?? ''; ?>">
                <div class="row">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($accion['id_bom_res_acc']) ?>">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <label for="actividad" class="form-label">Actividad:</label>
                        <textarea class="form-control" id="actividad" name="actividad" rows="3" required><?= htmlspecialchars($accion['actividad']) ?></textarea>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="fecha_hora" class="form-label">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" value="<?= htmlspecialchars($accion['fecha_hora']) ?>" required>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="posicion_institucion" class="form-label">Posición en la Institución:</label>
                        <input type="text" class="form-control" id="posicion_institucion" name="posicion_institucion" value="<?= htmlspecialchars($accion['posicion_institucion']) ?>" required>
                    </div>
                </div>
                <div class="form-buttons">
                    <a href="../view/principal.php?id_incidente=<?php echo htmlspecialchars($id_incidente); ?>" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editarAccionForm').submit(function(e) {
                e.preventDefault();
                var idIncidente = $('#id_incidente').val();
                $.ajax({
                    url: '../controller/Controller-ResumenAcciones.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = 'principal.php?page=resumen&id_incidente=' + idIncidente;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Status: ' + status + ', Error: ' + error);
                        console.log('Response:', xhr.responseText);
                        try {
                            var response = JSON.parse(xhr.responseText);
                            alert('Error: ' + (response.message || 'Ocurrió un error desconocido'));
                        } catch (e) {
                            alert('Datos editados correctamente');
                            window.location.href = 'principal.php?page=resumen&id_incidente=' + idIncidente;
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>