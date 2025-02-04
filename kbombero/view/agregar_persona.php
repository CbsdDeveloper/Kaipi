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
    <title>Agregar Nueva Persona</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="custom-header.js"></script>
    <script src="menu-desplegable.js"></script>
    <style>
        /* .content {
            padding-top: 80px;
            margin-left: 270px;
            min-height: calc(100vh - 60px);
            background-color: #f4f7f9;
            position: relative;
            z-index: 1;
            padding-right: 20px;
        } */

        .botones {
            display: flex;
            justify-content: right;
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
            <form id="agregarPersonaForm">
                <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($id_incidente); ?>">
                <input type="hidden" name="action" value="agregar">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <label for="nombre" class="form-label">Nombre de la persona:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-4">
                        <label for="sexo" class="form-label">Sexo:</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="">Seleccione</option>
                            <option value="masculino">masculino</option>
                            <option value="femenino">femenino</option>
                        </select>

                    </div>
                    <div class="mb-3 col-4">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" required>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="clasificacion" class="form-label">Clasificación:</label>
                        <select class="form-select" id="clasificacion" name="clasificacion" required>
                            <option value="">Seleccione</option>
                            <option value="Rojo">Rojo</option>
                            <option value="Amarillo">Amarillo</option>
                            <option value="Verde">Verde</option>
                            <option value="Negro">Negro</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="lugar_traslado" class="form-label">Lugar de traslado:</label>
                    <input type="text" class="form-control" id="lugar_traslado" name="lugar_traslado" required>
                </div>
                <div class="mb-3">
                    <label for="trasladado_por" class="form-label">Trasladado por:</label>
                    <input type="text" class="form-control" id="trasladado_por" name="trasladado_por" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_hora" class="form-label">Fecha y Hora:</label>
                    <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                </div>
                <div class="mb-3">
                    <label for="probable_diagnostico" class="form-label">Probable Diagnóstico:</label>
                    <textarea class="form-control" id="probable_diagnostico" name="probable_diagnostico" rows="3" required></textarea>
                </div>
                <div class="form-buttons">
                    <button onclick="history.back()" class="btn btn-secondary">Volver</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#agregarPersonaForm').submit(function(e) {
                e.preventDefault();
                var idIncidente = $('#id_incidente').val();
                $.ajax({
                    url: '../controller/Controller_Personas.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = 'lista_personas.php?id_incidente=' + idIncidente;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Status: ' + status + ', Error: ' + error);
                        alert('Persona agregada con éxito');
                        window.location.href = 'lista_personas.php?id_incidente=' + idIncidente;
                    }
                });
            });
        });
    </script>
</body>

</html>