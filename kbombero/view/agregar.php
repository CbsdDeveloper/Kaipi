<?php
include_once('../model/Model-Incidentes.php');

$id_incidente = isset($_GET['id_incidente']) ? intval($_GET['id_incidente']) : null;
$incidente = null;

if ($id_incidente) {
    $incidente = obtenerIncidentePorId($id_incidente);
} else {
    echo "No se ha seleccionado un incidente.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Nueva Acción</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>

</head>

<body class="colorB">
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>
    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Registro: Resumen de las Acciones</h6><br>
            <form id="agregarAccionForm">

                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo $_GET['id_incidente'] ?? ''; ?>">

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <label for="actividad" class="form-label">Actividad:</label>
                        <textarea class="form-control" id="actividad" name="actividad" rows="3" required></textarea>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="fecha_hora" class="form-label">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <label for="posicion_institucion" class="form-label">Posición/Institución que reporta:</label>
                        <input type="text" class="form-control" id="posicion_institucion" name="posicion_institucion" required>
                    </div>
                </div>
                <div class="form-buttons">
                    <button onclick="history.back()" class="btn btn-secondary">Volver</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#agregarAccionForm').submit(function(e) {
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
                        alert('Datos ingresados correctamente');
                        window.location.href = 'principal.php?page=resumen&id_incidente=' + idIncidente;
                    }
                });
            });
        });
    </script>
</body>

</html>