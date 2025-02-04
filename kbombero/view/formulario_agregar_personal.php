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
    <title>Registro de Bomberos</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Enlace a Toastr CSS y JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        .container {
            width: 95%;
            padding: 3%;
            margin: 0 auto;
            margin-bottom: 5%;
        }
    </style>
</head>

<body class="colorB">
    <custom-header
        incidente-nombre="<?php echo htmlspecialchars($incidente['nombre_inci']); ?>"
        incidente-cerrado="<?php echo $incidente['estatus'] === 'CERRADO' ? 'true' : 'false'; ?>">
    </custom-header>
    <custom-menu></custom-menu>

    <div class="content">
        <div class="cuadro">
            <h6 class="card-header">Registro de Bomberos</h6>
            <div class="card-body">
                <form id="formRegistroBombero">
                    <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="institucion" class="form-label">Institución*</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" required>
                        </div>
                        <div class="col-md-6">
                            <label for="matricula_vehiculo" class="form-label">Matrícula del vehículo</label>
                            <input type="text" class="form-control" id="matricula_vehiculo" name="matricula_vehiculo">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="4"></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#formRegistroBombero').on('submit', function(e) {
                e.preventDefault();
                var idIncidente = $('#id_incidente').val();
                $.ajax({
                    url: '../controller/Controller-registro_personal.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Bombero registrado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'registro_personal.php?page=registro&id_incidente=' + idIncidente;
                            }, 2000); // Redirecciona después de 2 segundos
                        } else {
                            toastr.error('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        toastr.success('Bombero registrado con éxito!');
                        setTimeout(function() {
                            window.location.href = 'registro_personal.php?page=registro&id_incidente=' + idIncidente;
                        }, 2000);
                    }
                });
            });
        });
    </script>

</body>

</html>