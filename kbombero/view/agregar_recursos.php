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
    <title>Agregar Recurso SCI</title>
    <link rel="stylesheet" href="../view/lib/css/estilos.css">
    <link rel="stylesheet" href="../view/lib/css/estilos_editar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
            <h6 class="card-header">Agregar Recurso SCI</h6>
            <div class="card-body">
                <form id="formAgregarRecurso">
                    <input type="hidden" id="id_incidente" name="id_incidente" value="<?php echo htmlspecialchars($_GET['id_incidente'] ?? ''); ?>">
                    <input type="hidden" name="action" value="guardar_recurso">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="clase" class="form-label">Clase*</label>
                            <select class="form-select select2" id="clase" name="clase" required>
                                <option value="" selected="selected">---------</option>
                                <option value="Ambulancia">Ambulancia</option>
                                <option value="Bus">Bus </option>
                                <option value="Camión de Carga">Camión de Carga</option>
                                <option value="Cisterna o pipa">Cisterna o pipa</option>
                                <option value="Grúas">Grúas</option>
                                <option value="Grupo USAR intermedio">Grupo USAR intermedio</option>
                                <option value="Helicóptero de Rescate">Helicóptero de Rescate</option>
                                <option value="Helicóptero Forestal">Helicóptero Forestal</option>
                                <option value="Helicóptero Policia">Helicóptero Policial</option>
                                <option value="Lancha">Lancha</option>
                                <option value="Logística">Logística</option>
                                <option value="Motobomba">Motobomba</option>
                                <option value="Motocicleta">Motocicleta</option>
                                <option value="Patrulla">Patrulla</option>
                                <option value="Pick Up">Pick Up</option>
                                <option value="Trailer">Trailer</option>
                                <option value="Unidad de Rescate">Unidad de Rescate</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo*</label>
                            <select class="form-select select2" id="tipo" name="tipo" required>
                                <option value="" selected="selected">---------</option>
                                <option value="Tipo 1">Tipo 1</option>
                                <option value="Tipo 2">Tipo 2</option>
                                <option value="Tipo 3">Tipo 3</option>
                                <option value="Tipo 4">Tipo 4</option>
                                <option value="Tipo 5">Tipo 5</option>
                                <option value="Tipo 6">Tipo 6</option>
                                <option value="Tipo 7">Tipo 7</option>
                                <option value="Tipo 8">Tipo 8</option>
                                <option value="Tipo 9">Tipo 9</option>
                                <option value="Tipo 10">Tipo 10</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_hora_solicitud" class="form-label">Fecha y hora de solicitud*</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_solicitud" name="fecha_hora_solicitud" required>
                        </div>
                        <div class="col-md-6">
                            <label for="solicitado_por" class="form-label">Solicitado por*</label>
                            <input type="text" class="form-control" id="solicitado_por" name="solicitado_por" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_hora_arribo" class="form-label">Fecha y hora de arribo</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_arribo" name="fecha_hora_arribo">
                        </div>
                        <div class="col-md-6">
                            <label for="institucion" class="form-label">Institución</label>
                            <input type="text" class="form-control" id="institucion" name="institucion">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="matricula">
                        </div>
                        <div class="col-md-6">
                            <label for="numero_personas" class="form-label">Número de personas</label>
                            <input type="number" class="form-control" id="numero_personas" name="numero_personas">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="estado_recurso" class="form-label">Estado del recurso*</label>
                            <select class="form-select select2" id="estado_recurso" name="estado_recurso" required>
                                <option value="" selected="selected">---------</option>
                                <option value="SinDato">SinDato</option>
                                <option value="Disponible">Disponible</option>
                                <option value="Asignado">Asignado</option>
                                <option value="NoDisponible">NoDisponible</option>
                                <option value="Desmovilizado">Desmovilizado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="asignado_a" class="form-label">Asignado a</label>
                            <input type="text" class="form-control" id="asignado_a" name="asignado_a">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="periodo_operacional" class="form-label">Periodo operacional</label>
                            <input type="text" class="form-control" id="periodo_operacional" name="periodo_operacional">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_hora_desmovilizacion" class="form-label">Fecha y hora de desmovilización</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora_desmovilizacion" name="fecha_hora_desmovilizacion">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="responsable_desmovilizacion" class="form-label">Responsable de desmovilización</label>
                            <input type="text" class="form-control" id="responsable_desmovilizacion" name="responsable_desmovilizacion">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>

                    <div class="form-buttons ">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Seleccione una opción",
                allowClear: true
            });

            $('#formAgregarRecurso').on('submit', function(e) {
                e.preventDefault();
                var idIncidente = $('#id_incidente').val();
                $.ajax({
                    url: '../controller/Controller-recursos.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Recurso agregado con éxito!');
                            setTimeout(function() {
                                window.location.href = 'bom_recursos.php?page=recursos&id_incidente=' + idIncidente;
                            }, 2000);
                        } else {
                            toastr.error('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Error al procesar la solicitud');
                    }
                });
            });
        });
    </script>

</body>

</html>